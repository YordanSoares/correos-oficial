<?php // phpcs:ignoreFile
/**
 * WooEnvio WcPlugin package file.
 *
 * @package WooEnvio\WcPlugin
 */

namespace WooEnvio\WcPlugin\Common;

/**
 * Shipping config
 */
class Shipping_Config extends Config {

	/**
	 * Obtain shipping config for Id shipping
	 *
	 * @param string $id Id shipping.
	 * @return mixed     Null|array.
	 */
	public function of_id( $id ) {

		$config = \apply_filters( 'wecorreos_shipping_config', $this->config );

		$filtered_shippings = array_filter(
			$config, function( $shipping ) use ( $id ) {
			return $shipping['id'] === $id;
		}
		);

		return empty( $filtered_shippings ) ? null : array_values( $filtered_shippings )[0];
	}

	/**
	 * Obtain shipping classes list.
	 *
	 * @return array    Shipping classes list.
	 */
	public function classes() {
		return array_column( $this->config, 'class' );
	}

	/**
	 * Obtain pair [id shipping] => [class] list.
	 *
	 * @return array    Pair id Shipping classes list.
	 */
	public function id_class_list() {
		return array_combine(
			$this->ids(),
			$this->classes()
		);
	}
}
