<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Order/Shipping/Label/Package
 */

namespace WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Package;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;
use WooEnvio\WpPlugin\Validates\Validate_Data;
use WooEnvio\WECorreos\Domain\Services\Customs\Customs_Descriptions;
use WooEnvio\WECorreos\Domain\Services\Customs\Tariff_Number;

/**
 * Class Package
 */
class Package {

	const DEFAULT_KEY = '1';

	/**
	 * Data
	 *
	 * @var mixed
	 */
	private $key;
	/**
	 * Data
	 *
	 * @var mixed
	 */
	private $weight;
	/**
	 * Data
	 *
	 * @var mixed
	 */
	private $width;
	/**
	 * Data
	 *
	 * @var mixed
	 */
	private $height;
	/**
	 * Data
	 *
	 * @var mixed
	 */
	private $length;

	private $customs_tariff_number;
	private $customs_tariff_description;
	private $first_item_value;
	/**
	 * Package constructor.
	 *
	 * @param array $data Data.
	 */
	public function __construct( $data ) {
		$this->key    = $data['key'];
		$this->weight = $data['weight'];
		$this->width  = $data['width'];
		$this->height = $data['height'];
		$this->length = $data['length'];
		$this->customs_tariff_number = $this->get_tariff_number($data);
		$this->customs_tariff_description = $this->get_description($data);
		$this->first_item_value           = $data['first_item_value'];
	}

	private function get_description($data){
		if ($data['customs_check_description_and_tariff']=='radio_tariff_number'){
				return $data['customs_tariff_description'];
		}
		else if ($data['customs_check_description_and_tariff']=='radio_description_by_default'){
				return $data['first_item_description'];
		}
	}

	private function get_tariff_number($data){
		if ($data['customs_check_description_and_tariff']=='radio_tariff_number'){
				return $data['customs_tariff_number'];
		}
		else if ($data['customs_check_description_and_tariff']=='radio_description_by_default'){
				return null;
		}
	}	

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function key() {
		return $this->key;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function weight() {
		return $this->weight;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function width() {
		return $this->width;
	}

	public function customs_options(){
		return $description_customs_options = Customs_Descriptions::options();
	}

	public function tariff_humber(){
		return $tariff_number = Tariff_number::options();
	}	

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function height() {
		return $this->height;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function length() {
		return $this->length;
	}
	
	public function customs_tariff_number() {
		return $this->customs_tariff_number;
	}

	public function customs_tariff_description() {
		return $this->customs_tariff_description;
	}

	public function first_item_value(){
		return $this->first_item_value;
	}


	/**
	 * Change key
	 *
	 * @param mixed $new_key Mew key.
	 *
	 * @return Package
	 */
	public function change_key( $new_key ) {

		$data        = $this->data();
		$data['key'] = $new_key;
		return new self( $data );
	}

	/**
	 * Array Data
	 *
	 * @return array
	 */
	public function data() {
		return [
			'key'    => $this->key,
			'weight' => $this->weight,
			'width'  => $this->width,
			'height' => $this->height,
			'length' => $this->length,
			'customs_tariff_number' => $this->customs_tariff_number,
			'customs_tariff_description' => $this->customs_tariff_description,
			'first_item_value' => $this->first_item_value,
		];
	}

	/**
	 * Build default
	 *
	 * @param Order $order Order.
	 *
	 * @return static
	 */
	public static function build_default( $order ) {
		return new static(
			[
				'key'    => self::DEFAULT_KEY,
				'weight' => $order->weight(),
				'width'  => $order->width(),
				'height' => $order->height(),
				'length' => $order->length(),
				//'customs_tariff_number'=>$order->customs_tariff_number(),
				//'customs_tariff_description'=>$order->customs_tariff_number()
			]
		);
	}

	/**
	 * Build and validate
	 *
	 * @param array $data Data.
	 *
	 * @return static
	 */
	public static function build_and_validate( $data ) {

		$package = new static( $data );

		$package->validate_or_fail();

		return $package;
	}

	/**
	 * Build
	 *
	 * @param array $data Data.
	 *
	 * @return static
	 */
	public static function build( $data ) {

		return new static( $data );
	}

	/**
	 * Validate
	 *
	 * @throws \WooEnvio\WpPlugin\Validates\Validation_Exception Fail validation rules.
	 */
	public function validate_or_fail() {
		( new Validate_Data( $this->rules(), $this->data(), 'correoswc' ) )->validate();
	}

	/**
	 * Rules validation
	 *
	 * @return array[]
	 */
	private function rules() {
		return [
			'weight' => [
				'name'  => __( 'Weight', 'correoswc' ),
				'rules' => [
					'Is_Float',
					'Is_Greater_Than' => [
						'min'       => 0,
						'inclusive' => true,
					],
					'Is_Less_Than'    => [
						'max'       => 999.99,
						'inclusive' => true,
					],
				],
			],
			'width'  => [
				'name'  => __( 'Width', 'correoswc' ),
				'rules' => [
					'Is_Int',
					'Is_Greater_Than' => [
						'min'       => 0,
						'inclusive' => true,
					],
				],
			],
			'height' => [
				'name'  => __( 'Height', 'correoswc' ),
				'rules' => [
					'Is_Int',
					'Is_Greater_Than' => [
						'min'       => 0,
						'inclusive' => true,
					],
				],
			],
			'length' => [
				'name'  => __( 'Length', 'correoswc' ),
				'rules' => [
					'Is_Int',
					'Is_Greater_Than' => [
						'min'       => 0,
						'inclusive' => true,
					],
				],
			],
		];
	}
}
