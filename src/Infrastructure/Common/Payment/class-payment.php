<?php
/**
 * Payment
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Payment;

/**
 * Class Payment
 */
abstract class Payment extends \WC_Payment_Gateway {

	/**
	 * Function.
	 * Payment constructor.
	 */
	public function __construct() {
		$this->config = $this->getConfig();

		$this->id                 = $this->config['id'];
		$this->icon               = apply_filters( $this->config['id'] . '_icon', $this->config['icon'] );
		$this->method_title       = $this->config['title'];
		$this->method_description = $this->config['description'];
		$this->has_fields         = false;

		$this->init_form_fields();
		$this->init_settings();

		$this->title                                 = $this->get_option( 'title' );
		$this->description                           = $this->get_option( 'description' );
		$this->instructions                          = $this->get_option( 'instructions' );
		$this->max_amount_cart                       = $this->get_option( 'max_amount_cart' );
		$this->extra_charge                          = $this->get_option( 'extra_charge' );
		$this->extra_charge_display_cart_description = $this->get_option( 'extra_charge_display_cart_description' );

		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, [ $this, 'process_admin_options' ] );

		add_action( 'woocommerce_thankyou_' . $this->id, [ $this, 'thankyouPage' ] );

		add_action( 'woocommerce_email_before_order_table', [ $this, 'emailInstructions' ], 10, 3 );
	}

	/**
	 * Function.
	 */
	public function init_form_fields() {

		$this->form_fields = array(
			'enabled'                               => array(
				'title'       => __( 'Enable/Disable', 'woocommerce' ),
				'label'       => __( 'Enable this Payment Method', 'correoswc' ),
				'type'        => 'checkbox',
				'description' => '',
				'default'     => 'no',
			),
			'title'                                 => array(
				'title'       => __( 'Title', 'woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Payment method description that the customer will see on your checkout.', 'woocommerce' ),
				'default'     => __( 'Pay on delivery', 'correoswc' ),
				'desc_tip'    => true,
			),
			'description'                           => array(
				'title'       => __( 'Description', 'woocommerce' ),
				'type'        => 'textarea',
				'description' => __( 'Payment method description that the customer will see on your website.', 'woocommerce' ),
				'default'     => __( 'Pay with cash upon delivery', 'correoswc' ),
				'desc_tip'    => true,
			),
			'instructions'                          => array(
				'title'       => __( 'Instructions', 'woocommerce' ),
				'type'        => 'textarea',
				'description' => __( 'Instructions that will be added to the thank you page.', 'woocommerce' ),
				'default'     => __( 'Pay with cash upon delivery', 'correoswc' ),
				'desc_tip'    => true,
			),
			'max_amount_cart'                       => array(
				'title'       => __( 'Maximum transaction amount', 'correoswc' ),
				'type'        => 'price',
				'description' => __( 'Maximum transaction amount for this payment method', 'correoswc' ),
				'default'     => '2499',
				'desc_tip'    => true,
			),
			'extra_charge'                          => array(
				'title'       => __( 'Extra charge', 'correoswc' ),
				'type'        => 'price',
				'description' => __( 'Extra charge added to total cart.', 'correoswc' ),
				'default'     => '0',
				'placeholder' => 0,
				'desc_tip'    => true,
			),
			'extra_charge_display_cart_description' => array(
				'title'       => __( 'Extra charge display cart', 'correoswc' ),
				'type'        => 'text',
				'description' => __( 'Description of the additional charge shown on the cart', 'correoswc' ),
				'default'     => __( 'Extra charge (Payment on delivery)', 'correoswc' ),
				'desc_tip'    => true,
			),
		);
	}

	/**
	 * Function.
	 *
	 * @param int $order_id Order id.
	 *
	 * @return array
	 */
	public function process_payment( $order_id ) {
		$order = wc_get_order( $order_id );

		// Mark as processing or on-hold (payment won't be taken until delivery).
		$order->update_status( apply_filters( 'woocommerce_' . $this->id . '_process_payment_order_status', $order->has_downloadable_item() ? 'on-hold' : 'processing', $order ), __( 'Payment to be made upon delivery.', 'correoswc' ) );

		// Reduce stock levels.
		wc_reduce_stock_levels( $order_id );

		// Remove cart.
		WC()->cart->empty_cart();

		// Return thankyou redirect.
		return array(
			'result'   => 'success',
			'redirect' => $this->get_return_url( $order ),
		);
	}

	/**
	 * Function.
	 */
	public function thankyouPage() {
		if ( $this->instructions ) {
			echo wp_kses_post( wpautop( wptexturize( $this->instructions ) ));
		}
	}

	/**
	 * Function.
	 *
	 * @param \WC_Order $order Order.
	 * @param mixed     $sent_to_admin Send to dmin.
	 * @param bool      $plain_text Plan text.
	 */
	public function emailInstructions( $order, $sent_to_admin, $plain_text = false ) { //phpcs:ignore
		$payment = $order->get_payment_method();

		if ( $this->instructions && ! $sent_to_admin && $this->id === $payment ) {
			echo wp_kses_post( wpautop( wptexturize( $this->instructions ) )) . PHP_EOL;
		}
	}

	/**
	 * Function.
	 *
	 * @return bool
	 */
	public function is_available() {
		// Check if cart meeds shipping.
		if ( ! apply_filters( 'woocommerce_cart_needs_shipping', $this->cartNeedsShipping() ) ) {
			return false;
		}

		// Check if this payment is enabled for shipping method order.
		if ( ! $this->compatibleWithCurrentShippingMethod() ) {
			return false;
		}

		// Check if this payment is enabled for some countries.
		if ( ! $this->compatibleWithCountries() ) {
			return false;
		}

		// Check if cart ammount is greater than max_amount_cart.
		if ( $this->greaterTanMaxAmountCart() ) {
			return false;
		}

		return parent::is_available();
	}

	/**
	 * Function.
	 *
	 * @return bool
	 */
	private function cartNeedsShipping() {
		if ( WC()->cart && WC()->cart->needs_shipping() ) {
			return true;
		}

		if ( is_page( wc_get_page_id( 'checkout' ) ) && 0 < get_query_var( 'order-pay' ) ) {
			$order_id = absint( get_query_var( 'order-pay' ) );

			if ( $this->itemsNeedsShipping( wc_get_order( $order_id ) ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Function.
	 *
	 * @param \WC_Order $order Order.
	 *
	 * @return bool
	 */
	private function itemsNeedsShipping( $order ) {
		if ( 0 < count( $order->get_items() ) ) {
			foreach ( $order->get_items() as $item ) {
				$product = $order->get_product_from_item( $item );
				if ( $product && $product->needs_shipping() ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Function.
	 *
	 * @return bool
	 */
	private function compatibleWithCurrentShippingMethod() {
		if ( ! isset( $this->config['compatible_shipping_methods'] ) ) {
			return true;
		}

		$currentShippingMethod = $this->currentShippingMethod();
		if ( in_array( $currentShippingMethod, $this->config['compatible_shipping_methods'], true ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Function.
	 *
	 * @return bool
	 */
	private function compatibleWithCountries() {
		if ( ! isset( $this->config['compatible_countries'] ) ) {
			return true;
		}

		$country = WC()->customer->get_shipping_country();
		if ( in_array( $country, $this->config['compatible_countries'], true ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Function.
	 *
	 * @return bool
	 */
	private function greaterTanMaxAmountCart() {
		return WC()->cart->total > $this->max_amount_cart;
	}

	/**
	 * Function.
	 *
	 * @return mixed|string
	 */
	private function currentShippingMethod() {
		$shippingMethods = array_map(
			function ( $method ) {
				return current( explode( ':', $method ) );
			}, \WC()->session->get( 'chosen_shipping_methods', [] )
		);

		return isset( $shippingMethods[0] ) ? $shippingMethods[0] : '';
	}

	/**
	 * Function.
	 *
	 * @return mixed
	 */
	abstract public function getConfig();
}
