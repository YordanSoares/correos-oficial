<?php
/**
 * Data
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Data;

/**
 * Class Senders_Data_Transform
 */
class Senders_Data_Transform {

	const DEFAULT_COLUMN_NAME = 'default';
	const KEY_COLUMN_NAME     = 'key';

	/**
	 * Transform
	 *
	 * @param array $data Data.
	 *
	 * @return array|array[]
	 */
	public function to_after_240( $data ) {
		if ( $this->is_data_before_2_4_0( $data ) ) {
			return $this->transform_data_to_after_240( $data );
		}

		return $data;
	}

	/**
	 * Transform
	 *
	 * @param array $old_data Data.
	 *
	 * @return array|array[]
	 */
	private function transform_data_to_after_240( $old_data ) {
		$columns = array_keys( $old_data );

		$keys = array_keys( $old_data[ static::DEFAULT_COLUMN_NAME ] );

		$new_data = array_map(
			function( $key ) use ( $columns, $old_data ) {

				return $this->obtain_row( $key, $columns, $old_data );

			}, $keys
		);

		return $new_data;
	}

	/**
	 * Obtain row.
	 *
	 * @param string $key Key.
	 * @param array  $columns Columns.
	 * @param array  $old_data Old_data.
	 *
	 * @return array
	 */
	private function obtain_row( $key, $columns, $old_data ) {
		$row = [];

		$row[ static::KEY_COLUMN_NAME ] = $key;

		array_map(
			function( $column ) use ( &$row, $old_data, $key ) {

				$value = $old_data[ $column ][ $key ];

				$value = $this->transform_value_on_default_column( $column, $value );

				$row[ $column ] = $value;

			}, $columns
		);

		return $row;
	}

	/**
	 * Transform
	 *
	 * @param array $data Data.
	 *
	 * @return array|array[]
	 */
	private function is_data_before_2_4_0( $data ) {
		$columns = array_keys( $data );

		return in_array( static::DEFAULT_COLUMN_NAME, $columns, true );
	}

	/**
	 * Transform
	 *
	 * @param string $column Column.
	 * @param string $value Value.
	 *
	 * @return mixed
	 */
	private function transform_value_on_default_column( $column, $value ) {
		if ( static::DEFAULT_COLUMN_NAME !== $column ) {
			return $value;
		}

		return 'true' === $value;
	}
}
