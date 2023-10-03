<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Order/Shipping/Customs
 */

namespace WooEnvio\WECorreos\Domain\Model\Order\Shipping\Customs;

use WooEnvio\WpPlugin\Validates\Validate_Data;

/**
 * Class Customs
 */
class Customs {

	const DEFAULT_NUMBER_PIECES = 1;

	/**
	 * Number of pieces
	 *
	 * @var int
	 */
	private $number_pieces;

	/**
	 * Customs constructor.
	 *
	 * @param int $number_pieces Number_pieces.
	 */
	public function __construct( $number_pieces ) {
		$this->number_pieces = $number_pieces;
	}

	/**
	 * Data
	 *
	 * @return int
	 */
	public function number_pieces() {
		return $this->number_pieces;
	}

	/**
	 * Data
	 *
	 * @return array
	 */
	public function data() {
		return [
			'number_pieces' => $this->number_pieces,
		];
	}

	/**
	 * Build default
	 *
	 * @return static
	 */
	public static function build_default() {
		return new static( static::DEFAULT_NUMBER_PIECES );
	}

	/**
	 * Build and validtate
	 *
	 * @param int $number_pieces Number_pieces.
	 *
	 * @return static
	 */
	public static function build_and_validate( $number_pieces ) {
		$customs = new static( $number_pieces );

		$customs->validate_or_fail();

		return $customs;
	}

	/**
	 * Build
	 *
	 * @param int $number_pieces Number_pieces.
	 *
	 * @return static
	 */
	public static function build_from_old( $number_pieces ) {
		return new static( $number_pieces );
	}

	/**
	 * Validate
	 *
	 * @return mixed
	 */
	public function validate_or_fail() {
		( new Validate_Data( $this->rules(), $this->data(), 'correoswc' ) )->validate();
	}

	/**
	 * Rules
	 *
	 * @return array
	 */
	private function rules() {
		return [
			'number_pieces' => [
				'name'  => __( 'Number of elements', 'correoswc' ),
				'rules' => [
					'Is_Required',
					'Is_Int',
					'Is_Greater_Than' => [ 'min' => 0 ],
				],
			],
		];
	}
}
