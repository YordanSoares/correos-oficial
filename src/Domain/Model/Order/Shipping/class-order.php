<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Order/Shipping/Order
 */

namespace WooEnvio\WECorreos\Domain\Model\Order\Shipping;

use WooEnvio\WECorreos\Domain\Services\Order\State_Correos_Code;
use WooEnvio\WECorreos\Infrastructure\Common\Format\Woocommerce_Weight;

/**
 * Class Order
 */
class Order {

	/**
	 * Wc_order
	 *
	 * @var \WC_Order
	 */
	private $wc_order;
	/**
	 * Shipping_method
	 *
	 * @var string
	 */
	private $shipping_method;
	/**
	 * Payment_method
	 *
	 * @var string
	 */
	private $payment_method;
	/**
	 * Selected_office
	 *
	 * @var string
	 */
	private $selected_office;
	/**
	 * Selected_citypaq
	 *
	 * @var string
	 */
	private $selected_citypaq;
	/**
	 * Countries_using_cp
	 *
	 * @var string[]
	 */
	private $countries_using_cp = [ 'ES', 'AD' ];

	/**
	 * Order constructor.
	 *
	 * @param \WC_Order $wc_order WC_Order.
	 * @param string    $shipping_method Shipping_method.
	 * @param string    $payment_method Payment_method.
	 * @param string    $selected_office Selected_office.
	 * @param string    $selected_citypaq Selected_citypaq.
	 */
	public function __construct( $wc_order, $shipping_method, $payment_method, $selected_office, $selected_citypaq ) {
		$this->wc_order         = $wc_order;
		$this->shipping_method  = $shipping_method;
		$this->payment_method   = $payment_method;
		$this->selected_office  = $selected_office;
		$this->selected_citypaq = $selected_citypaq;
	}

	/**
	 * Data
	 *
	 * @return int
	 */
	public function order_id() {
		return $this->wc_order->get_id();
	}

	/**
	 * Wc_order
	 *
	 * @return \WC_Order
	 */
	public function wc_order() {
		return $this->wc_order;
	}

	/**
	 * Address
	 *
	 * @return string
	 */
	public function address() {
		return $this->wc_order->get_formatted_shipping_address();
	}

	/**
	 * Shipping_name
	 *
	 * @return string|null
	 */
	public function shipping_name() {
		return null === $this->shipping_method ? null : $this->shipping_method['title'];
	}

	/**
	 * Shipping_method_id
	 *
	 * @return string|null
	 */
	public function shipping_method_id() {
		return null === $this->shipping_method ? null : $this->shipping_method['id'];
	}

	/**
	 * Shipping_method_logo
	 *
	 * @return string|null
	 */
	public function shipping_method_logo() {
		return null === $this->shipping_method ? null : $this->shipping_method['logo'];
	}

	/**
	 * Correos_code
	 *
	 * @return string|null
	 */
	public function correos_code() {
		return null === $this->shipping_method ? null : $this->shipping_method['correos_code'];
	}

	/**
	 * Type_delivery
	 *
	 * @return string|null
	 */
	public function type_delivery() {
		return null === $this->shipping_method ? null : $this->shipping_method['type_delivery'];
	}

	/**
	 * Payment_name
	 *
	 * @return string|null
	 */
	public function payment_name() {
		return null === $this->payment_method ? null : $this->payment_method['title'];
	}

	/**
	 * Comment
	 *
	 * @return string
	 */
	public function comment() {
		return $this->wc_order->get_customer_note();
	}

	// Generate an extra query on order page.

	/**
	 * Weight
	 *
	 * @return mixed|void
	 */
	public function weight() {
		$weight_items = array_map(
			function ( $item ) {
				return $this->weight_items( $item );
			}, $this->wc_order->get_items()
		);

		$weight = array_sum( $weight_items );

		$woocommerce_unit = get_option( 'woocommerce_weight_unit' );

		$weight = Woocommerce_Weight::to_kg( $weight, $woocommerce_unit );

		return apply_filters( 'wecorreos_shipping_label_weight', $weight, $this->wc_order() );
	}

	/**
	 * Width
	 *
	 * @return mixed|void
	 */
	public function width() {
		return apply_filters( 'wecorreos_shipping_label_width', '0', $this->wc_order() );
	}

	/**
	 * Height
	 *
	 * @return mixed|void
	 */
	public function height() {
		return apply_filters( 'wecorreos_shipping_label_height', '0', $this->wc_order() );
	}

	/**
	 * Length
	 *
	 * @return mixed|void
	 */
	public function length() {
		return apply_filters( 'wecorreos_shipping_label_length', '0', $this->wc_order() );
	}

	/**
	 * First_item_qty
	 *
	 * @return array|mixed|string|null
	 */
	public function first_item_qty() {
		$items      = $this->wc_order->get_items();
		$first_item = array_shift( $items );

		return $first_item['qty'];
	}

	/**
	 * Weight items
	 *
	 * @param \WC_Order_Item $item WC_Order_Item.
	 *
	 * @return float|int
	 */
	private function weight_items( $item ) {
		if ( ! $item->get_quantity() > 0 ) {
			return 0;
		}

		$product = $item->get_product();

		if ( false === $product ) {
			return 0;
		}

		$weight = empty( $product->get_weight() ) ? 0 : $product->get_weight();

		$total_weight = ! $product->is_virtual() ? $weight * $item['qty'] : 0;

		return $total_weight;
	}

	/**
	 * Get_shipping_first_name
	 *
	 * @return string|null
	 */
	public function get_shipping_first_name() {
		return $this->wc_order->get_shipping_first_name();
	}

	/**
	 * Get_shipping_last_name
	 *
	 * @return string|null
	 */
	public function get_shipping_last_name() {
		return $this->wc_order->get_shipping_last_name();
	}

	/**
	 * Get_shipping_address_1
	 *
	 * @return string|null
	 */
	public function get_shipping_address_1() {
		return $this->wc_order->get_shipping_address_1();
	}

	/**
	 * Get_shipping_address_2
	 *
	 * @return string|null
	 */
	public function get_shipping_address_2() {
		return $this->wc_order->get_shipping_address_2();
	}

	/**
	 * Get_shipping_city
	 *
	 * @return string|null
	 */
	public function get_shipping_city() {
		return $this->wc_order->get_shipping_city();
	}

	/**
	 * Get_shipping_postcode
	 *
	 * @return string|null
	 */
	public function get_shipping_postcode() {
		return $this->wc_order->get_shipping_postcode();
	}

	/**
	 * Get_shipping_state
	 *
	 * @return string|null
	 */
	public function get_shipping_state() {
		return $this->wc_order->get_shipping_state();
	}

	/**
	 * Get_shipping_country
	 *
	 * @return string|null
	 */
	public function get_shipping_country() {
		return $this->wc_order->get_shipping_country();
	}

	/**
	 * Get_billing_phone
	 *
	 * @return string|null
	 */
	public function get_billing_phone() {
		return $this->wc_order->get_billing_phone();
	}

	/**
	 * Get_billing_email
	 *
	 * @return string|null
	 */
	public function get_billing_email() {
		return $this->wc_order->get_billing_email();
	}

	/**
	 * Get_order_number
	 *
	 * @return mixed|void
	 */
	public function get_order_number() {
		return apply_filters( 'wecorreos_correos_label_customer_reference', $this->wc_order->get_order_number(), $this->wc_order );
	}

	/**
	 * Bank_account
	 *
	 * @return string|string[]
	 */
	public function bank_account() {
		$payment = wc_get_payment_gateway_by_order( $this->wc_order->get_id() );

		if ( ! $payment ) {
			return '';
		}

		$payment->init_settings();

		return str_replace( ' ', '', $payment->get_option( 'bank_account_number' ) );
	}

	/**
	 * Payment_on_delivery
	 *
	 * @return bool
	 */
	public function payment_on_delivery() {
		return ! is_null( $this->payment_method );
	}

	/**
	 * Get_total
	 *
	 * @return float
	 */
	public function get_total() {
		return $this->wc_order->get_total();
	}

	/**
	 * Get_shipping_state_name
	 *
	 * @return string
	 */
	public function get_shipping_state_name() {
		$state_code = $this->get_shipping_state();

		$states_by_country = WC()->countries->get_states( $this->get_shipping_country() );

		$state_name = isset( $states_by_country[ $state_code ] ) ? $states_by_country[ $state_code ] : '';

		return html_entity_decode( $state_name );
	}

	/**
	 * Get_shipping_state_correos_code
	 *
	 * @return mixed|string
	 */
	public function get_shipping_state_correos_code() {
		$state = $this->get_shipping_state();

		$state_codes = State_Correos_Code::options();

		if ( ! isset( $state_codes[ $state ] ) ) {
			return '';
		}

		return $state_codes[ $state ];
	}

	/**
	 * Get_selected_office
	 *
	 * @return string|null
	 */
	public function get_selected_office() {
		if ( ! $this->is_shipping_method_with_selected_office() ) {
			return null;
		}

		return $this->selected_office;
	}

	/**
	 * Is selected office
	 *
	 * @return bool
	 */
	private function is_shipping_method_with_selected_office() {
		$office_shippings = \apply_filters( 'wecorreos_office_shipping', [ 'paq48office', 'paq72office' ] );
		return in_array( $this->shipping_method_id(), $office_shippings, true );
	}

	/**
	 * Get_selected_citypaq
	 *
	 * @return string|null
	 */
	public function get_selected_citypaq() {
		if ( ! $this->is_shipping_method_with_selected_citypaq() ) {
			return null;
		}

		return $this->selected_citypaq;
	}

	/**
	 * Is_shipping_method_with_selected_citypaq
	 *
	 * @return bool
	 */
	private function is_shipping_method_with_selected_citypaq() {
		$citypaq_shippings = [ 'paq48citypaq', 'paq72citypaq' ];
		return in_array( $this->shipping_method_id(), $citypaq_shippings, true );
	}

	/**
	 * Get_shipping_internatioal_zip
	 *
	 * @return string|null
	 */
	public function get_shipping_internatioal_zip() {

		if ( $this->is_country_using_cp() ) {
			return '';
		}

		return $this->get_shipping_postcode();
	}

	/**
	 * Get_shipping_national_cp
	 *
	 * @return string|null
	 */
	public function get_shipping_national_cp() {

		if ( ! $this->is_country_using_cp() ) {
			return '';
		}

		return $this->get_shipping_postcode();
	}

	/**
	 * Get_shipping_national_state_correos_code
	 *
	 * @return mixed|string
	 */
	public function get_shipping_national_state_correos_code() {
		if ( 'ES' !== $this->get_shipping_country() ) {
			return '';
		}

		return $this->get_shipping_state_correos_code();
	}

	/**
	 * Get_shipping_national_state
	 *
	 * @return string
	 */
	public function get_shipping_national_state() {
		if ( 'ES' !== $this->get_shipping_country() ) {
			return '';
		}

		return $this->get_shipping_state_name();
	}

	/**
	 * Get_shipping_internatioal_country
	 *
	 * @return string|null
	 */
	public function get_shipping_internatioal_country() {
		if ( 'ES' === $this->get_shipping_country() ) {
			return '';
		}

		return $this->get_shipping_country();
	}

	/**
	 * Is_country_using_cp
	 *
	 * @return bool
	 */
	private function is_country_using_cp() {
		return in_array( $this->get_shipping_country(), $this->countries_using_cp, true );
	}
}
