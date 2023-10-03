<?php
/**
 * Data
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Data;

/**
 * Class General_Data_Transform
 */
class General_Data_Transform {

	/**
	 * Function
	 *
	 * @param array $data Data.
	 *
	 * @return mixed
	 */
	public function to_after_240( $data ) {
		if ( $this->is_data_before_2_4_0( $data ) ) {
			return $this->transform_data_to_after_240( $data );
		}

		return $data;
	}

	/**
	 * Function
	 *
	 * @param array $data Data.
	 *
	 * @return array|bool[]
	 */
	private function transform_data_to_after_240( $data ) {
		return array_map(
			function( $value ) {
				if ( $this->is_old_value( $value ) ) {
					return 'true' === $value;
				}

				return $value;
			}, $data
		);
	}

	/**
	 * Function
	 *
	 * @param array $data Data.
	 *
	 * @return float|int
	 */
	private function is_data_before_2_4_0( $data ) {
		$values = array_values( $data );

		$is_old_values = array_map(
			function( $value ) {
				return $this->is_old_value( $value );
			}, $values
		);

		return array_sum( $is_old_values );
	}

	/**
	 * Is old value.
	 *
	 * @param string $value Value.
	 *
	 * @return bool
	 */
	private function is_old_value( $value ) {
		$old_values = [ 'true', 'false' ];

		return in_array( $value, $old_values, true );
	}
}
