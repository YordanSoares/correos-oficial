<?php // phpcs:ignoreFile
/**
 * WooEnvio WcPlugin package file.
 *
 * @package WooEnvio\WcPlugin
 */

namespace WooEnvio\WcPlugin\Common;

/**
 * Payment config
 */
class Payment_Config extends Config {

	/**
	 * Obtain payment config for Id payment
	 *
	 * @param string $id Id payment.
	 * @return mixed     Null|array.
	 */
	public function of_id( $id ) {

		$filtered_payments = array_filter(
			$this->config, function( $payment ) use ( $id ) {
				return $payment['id'] === $id;
			}
		);

		return empty( $filtered_payments ) ? null : array_values( $filtered_payments )[0];
	}

	/**
	 * Obtain payment classes list.
	 *
	 * @return array    Payment classes list.
	 */
	public function classes() {
		return array_column( $this->config, 'class' );
	}
}
