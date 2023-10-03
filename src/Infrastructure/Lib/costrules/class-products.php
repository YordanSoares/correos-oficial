<?php // phpcs:ignoreFile
/**
 * WooEnvio CostRules package file.
 *
 * @package WooEnvio\CostRules
 */

namespace WooEnvio\CostRules;

class Products {

	const SC_ALL     = 0;
	const SC_NOCLASS = 1;

	const CO_PRICE  = 0;
	const CO_WEIGHT = 1;
	const CO_VOLUME = 2;

	private $raw_products;

	public function __construct( $raw_products ) {
		$this->raw_products = $raw_products;
	}

	public function get_values_products_by_class_and_conditional( $shipping_class, $conditional ) {
		$products_filtered = [];

		if ( is_numeric( $shipping_class ) && self::SC_ALL == $shipping_class ) {
			$products_filtered = $this->raw_products;
		} elseif ( is_numeric( $shipping_class ) && self::SC_NOCLASS == $shipping_class ) {
			$products_filtered = $this->filter_products_not_shipping_class();
		} else {
			$products_filtered = $this->filter_products_custom_shipping_class( $shipping_class );
		}
		if ( empty( $products_filtered ) ) {
			return null;
		}
		$total_conditional_value = 0;
		$prod_attr               = $this->get_product_attributes_by_conditional( $conditional );

		if ( 'price' === $prod_attr ) {
			array_walk(
				$products_filtered,
				function ( $attr ) use ( &$total_conditional_value, $prod_attr ) {
					$total_conditional_value += $attr[ $prod_attr ];
				}
			);
		} else {
			array_walk(
				$products_filtered,
				function ( $attr ) use ( &$total_conditional_value, $prod_attr ) {
					$total_conditional_value += $attr['quantity'] * $attr[ $prod_attr ];
				}
			);
		}
		return round( $total_conditional_value, 2 );
	}

	private function filter_products_not_shipping_class() {
		return array_filter(
			$this->raw_products, function ( $product ) {
			return null === $product['shipping_class'] || empty( $product['shipping_class'] );
		}
		);
	}

	private function filter_products_custom_shipping_class( $shipping_class ) {
		return array_filter(
			$this->raw_products, function ( $product ) use ( $shipping_class ) {
			return $shipping_class === $product['shipping_class'];
		}
		);
	}

	private function get_product_attributes_by_conditional( $conditional ) {

		if ( self::CO_PRICE == $conditional ) {
			return 'price';
		}

		if ( self::CO_WEIGHT == $conditional ) {
			return 'weight';
		}

		if ( self::CO_VOLUME == $conditional ) {
			return 'volume';
		}

		return null;
	}

	public static function shipping_class_options( $textdomain ) {
		$shipping_class_options = [
			self::SC_ALL     => __( 'All products', $textdomain ),
			self::SC_NOCLASS => __( 'Products without class', $textdomain ),
		];

		array_map(
			function ( $shipping_class ) use ( &$shipping_class_options, $textdomain ) {
				$shipping_class_options[ $shipping_class->slug ] = __( 'Class', $textdomain ) . ' "' . $shipping_class->name . '"';
			}, \WC()->shipping->get_shipping_classes()
		);

		return $shipping_class_options;
	}

	public static function condition_options( $textdomain ) {
		return [
			self::CO_PRICE  => __( 'Cost', $textdomain ),
			self::CO_WEIGHT => __( 'Weight', $textdomain ),
			self::CO_VOLUME => __( 'Volume', $textdomain ),
		];
	}
}
