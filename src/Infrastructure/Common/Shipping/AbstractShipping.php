<?php // phpcs:ignoreFile
/**
 * Shipping
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Shipping;

use WooEnvio\WECorreos\Infrastructure\Common\Format\Woocommerce_Weight;

abstract class AbstractShipping extends \WC_Shipping_Method {

	public function __construct( $instance_id = 0 ) {
		$this->config = $this->getConfig();

		$this->id                 = $this->config['id'];
		$this->instance_id        = absint( $instance_id );
		$this->method_title       = $this->config['title'];
		$this->method_description = $this->config['description'];
		$this->supports           = array(
			'shipping-zones',
			'instance-settings',
		);
		$this->init();

		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	public function init() {
		$this->init_form_fields();
		$this->init_settings();

		$this->title      = $this->get_option( 'title' );
		$this->tax_status = $this->get_option( 'tax_status' );
		$this->fee        = $this->get_option( 'fee' );
		$this->max_weight = $this->get_option( 'max_weight' );
	}

	public function calculate_shipping( $package = array() ) {
		$this->add_rate(
			array(
				'label'   => $this->title,
				'package' => $package,
				'cost'    => str_replace( ',', '.', $this->fee ),
			)
		);
	}

	public function init_form_fields() {
		$this->instance_form_fields = array(
			'title'      => array(
				'title'       => __( 'Title', 'woocommerce' ),
				'type'        => 'text',
				'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
				'default'     => $this->method_title,
				'desc_tip'    => true,
			),
			'tax_status' => array(
				'title'   => __( 'Tax status', 'woocommerce' ),
				'type'    => 'select',
				'class'   => 'wc-enhanced-select',
				'default' => 'taxable',
				'options' => array(
					'taxable' => __( 'Taxable', 'woocommerce' ),
					'none'    => _x( 'None', 'Tax status', 'woocommerce' ),
				),
			),
			'fee'        => array(
				'title'       => __( 'Fee', 'woocommerce' ),
				'type'        => 'text',
				'class'       => 'wc_input_price',
				'placeholder' => '0',
				'description' => __( 'Optional fee for this shipping method.', 'correoswc' ),
				'default'     => '',
				'desc_tip'    => true,
			),
			'max_weight' => array(
				'title'       => __( 'Max Weight', 'correoswc' ),
				'type'        => 'text',
				'placeholder' => '0',
				'description' => __( 'Maximum cart weight (kg). Over this amount this shipping not available. With 0 the shipping is available with any weight.', 'correoswc' ),
				'default'     => '0',
				'desc_tip'    => true,
			),
		);
	}

	public function is_available( $package ) {
		// Check if this payment is enabled for some countries.
		if ( ! $this->compatibleWithCountries( $package ) ) {
			return false;
		}

		// Check if this payment minor or equals max weight for shipping method
		if ( ! $this->compatibleWithMaxWeight( $package ) ) {
			return false;
		}

		return parent::is_available( $package );
	}

	protected function getProducts( $package = [] ) {
		$products = [];

		foreach ( $package['contents'] as $item_id => $values ) {

			$length = is_numeric( $values['data']->get_length() ) ? $values['data']->get_length() : 0;
			$width  = is_numeric( $values['data']->get_width() ) ? $values['data']->get_width() : 0;
			$height = is_numeric( $values['data']->get_height() ) ? $values['data']->get_height() : 0;
			$weight = is_numeric( $values['data']->get_weight() ) ? $values['data']->get_weight() : 0;

			$volume = $length * $width * $height;
			$weight = $weight > 0 ? $weight : 0;

			$products[] = array(
				'quantity'       => $values['quantity'],
				'shipping_class' => $this->getShippingClassProduct( $values ),
				'weight'         => $weight,
				'volume'         => $volume,
				'price'          => $values['line_total'] + $values['line_tax'], // Price by cart line.
			);
		}

		return $products;
	}

	private function compatibleWithCountries( $package ) {
		if ( ! isset( $this->config['compatible_countries'] ) ) {
			return true;
		}

		$country = $package['destination']['country'];
		if ( in_array( $country, $this->config['compatible_countries'] ) ) {
			return true;
		}

		return false;
	}

	private function compatibleWithMaxWeight( $package ) {

		$max_weight = $this->obtain_max_weight();

		if ( is_null( $max_weight) ) {
			return true;
		}

		$package_weight = $this->packageWeight( $package );

		if ( $package_weight <= $max_weight ) {
			return true;
		}

		return false;
	}

	private function obtain_max_weight() {

		if ( $this->max_weight === '0' ) {
			return null;
		}

		if ( ! is_numeric( $this->max_weight) || $this->max_weight < 0 ) {
			return null;
		}

		return $this->max_weight;
	}

	private function packageWeight( $package ) {
		$package_weight = 0;

		foreach ( $package['contents'] as $item_id => $values ) {
			$item_weight = is_numeric( $values['data']->get_weight() ) ? $values['data']->get_weight() : 0;

			$item_weight = $item_weight > 0 ? $item_weight * $values['quantity'] : 0;

			$package_weight += $item_weight;
		}

		$woocommerce_unit = get_option( 'woocommerce_weight_unit' );

		$package_weight = Woocommerce_Weight::to_kg( $package_weight, $woocommerce_unit );

		return $package_weight;
	}

	private function getShippingClassProduct( $values ) {

		$shipping_class = $values['data']->get_shipping_class();
		if ( ! $shipping_class ) {
			$shipping_class = null;
		}

		return $shipping_class;
	}

	abstract public function getConfig();
}
