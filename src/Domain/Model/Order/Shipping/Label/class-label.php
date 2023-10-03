<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Order/Shipping/Label
 */

namespace WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Package\Package_List;
use WooEnvio\WpPlugin\Validates\Validate_Data;

/**
 * Class Label
 */
class Label {

	/**
	 * Sender_key
	 *
	 * @var mixed
	 */
	private $sender_key;
	/**
	 * Comment
	 *
	 * @var mixed
	 */
	private $comment;
	/**
	 * Package_list
	 *
	 * @var mixed
	 */
	private $package_list;
	/**
	 * Insurance
	 *
	 * @var mixed
	 */
	private $insurance;
	/**
	 * First_item_value
	 *
	 * @var mixed
	 */
	private $first_item_value;
	/**
	 * First_item_description
	 *
	 * @var mixed
	 */
	private $first_item_description;
	/**
	 * customs_tariff_number
	 *
	 * @var mixed
	 */
	private $customs_tariff_number;	
	/**
	 * customs_consignor_reference
	 *
	 * @var mixed
	 */
	private $customs_consignor_reference;	
	/**
	 * Label constructor.
	 *
	 * @param mixed $sender_key Sender_key.
	 * @param mixed $comment Comment.
	 * @param mixed $insurance Insurance.
	 * @param mixed $first_item_value First_item_value.
	 * @param mixed $first_item_description First_item_description.
	 * @param mixed $package_list Package_list.
	 * @param mixed $customs_tariff_number Customs_tariff_number.
	 * @param mixed $customs_consignor_reference Customs_consignor_reference. 
	 */
	public function __construct( $sender_key, $comment, $insurance, $first_item_value, $first_item_description, $package_list,
	    $customs_tariff_number='', $customs_tariff_description='', $customs_consignor_reference='') {
		$this->sender_key             = $sender_key;
		$this->comment                = $comment;
		$this->insurance              = $insurance;
		$this->first_item_value       = $first_item_value;
		$this->first_item_description = $first_item_description;
		$this->package_list           = $package_list;
		$this->customs_tariff_number  = $customs_tariff_number;
		$this->customs_tariff_description  = $customs_tariff_description;		
		$this->customs_consignor_reference  = $customs_consignor_reference;		
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function sender_key() {
		return $this->sender_key;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function package_list() {
		return $this->package_list;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function comment() {
		return $this->comment;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function insurance() {
		return $this->insurance;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function first_item_value() {
		return $this->first_item_value;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function first_item_description() {
		return $this->first_item_description;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function customs_tariff_number() {
		return $this->customs_tariff_number;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function customs_consignor_reference() {
		return $this->customs_consignor_reference;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function weight() {
		return $this->package_list->weight();
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function num_packages() {
		return $this->package_list->num_packages();
	}

	/**
	 * To data.
	 *
	 * @return array
	 */
	public function data() {
		return [
			'sender_key'             => $this->sender_key,
			'observations'           => $this->comment,
			'insurance'              => $this->insurance,
			'first_item_value'       => $this->first_item_value,
			'first_item_description' => $this->first_item_description,
			'packages'               => $this->package_list->data(),
			'customs_tariff_number'  => $this->customs_tariff_number,
			'customs_consignor_reference'  => $this->customs_consignor_reference
		];
	}

	/**
	 * Build default
	 *
	 * @param mixed $sender_key Sender_key.
	 * @param mixed $order Order.
	 * @param mixed $first_item_description First_item_description.
	 *
	 * @return static
	 */
	public static function build_default( $sender_key, $order, $first_item_description ) {

		$comment   = apply_filters( 'wecorreos_shipping_label_observations', $order->comment(), $order->wc_order() );
		$insurance = apply_filters( 'wecorreos_shipping_label_insurance', '0', $order->wc_order() );

		return new static( $sender_key, $comment, $insurance, $order->get_total(), $first_item_description, Package_List::build_default( $order ) );
	}

	/**
	 * Build and validate
	 *
	 * @param mixed $sender_key Sender_key.
	 * @param mixed $comment Comment.
	 * @param mixed $insurance Insurance.
	 * @param mixed $first_item_value First_item_value.
	 * @param mixed $first_item_description First_item_description.
	 * @param mixed $package_list Package_list.
	 * @param bool  $needs_customs Needs_customs.
     * @param mixed $customs_tariff_number Customs_tariff_number.
	 * @param mixed $customs_consignor_reference Customs_consignor_reference. 
	 *
	 * @return static
	 */
	public static function build_and_validate( $sender_key, $comment, $insurance, $first_item_value, $first_item_description, $package_list, $needs_customs, 
	$customs_tariff_number='', $customs_tariff_description, $customs_consignor_reference='') {
		$label = new static( $sender_key, $comment, $insurance, $first_item_value, $first_item_description, $package_list, 
		$customs_tariff_number, $customs_tariff_description, $customs_consignor_reference);

		$label->validate_or_fail( $needs_customs );

		return $label;
	}

	/**
	 * Validate or fail
	 *
	 * @param bool $needs_customs Needs customs.
	 *
	 * @throws \WooEnvio\WpPlugin\Validates\Validation_Exception Fail validation rules.
	 */
	public function validate_or_fail( $needs_customs ) {
		( new Validate_Data( $this->rules( $needs_customs ), $this->data(), 'correoswc' ) )->validate();
	}

	/**
	 * Rules
	 *
	 * @param bool $needs_customs Needs customs.
	 *
	 * @return array|array[]
	 */
	private function rules( $needs_customs ) {
		$standard = [
			'sender_key'   => [
				'name'  => __( 'Sender', 'correoswc' ),
				'rules' => [ 'Is_Int' ],
			],
			'insurance'    => [
				'name'  => __( 'Insurance', 'correoswc' ),
				'rules' => [
					'Is_Float',
					'Is_Greater_Than' => [
						'min'       => 0,
						'inclusive' => true,
					],
					'Is_Less_Than'    => [ 'max' => 3000 ],
				],
			],
			'observations' => [
				'name'  => __( 'Comments', 'correoswc' ),
				'rules' => [
					'Is_Length_Less_Than' => [
						'max'       => 90,
						'inclusive' => true,
					],
				],
			],
		];

		// $customs_fields = [
		// 	'first_item_value' => [
		// 		'name'  => __( 'First product value', 'correoswc' ),
		// 		'rules' => [
		// 			'Is_Float',
		// 			'Is_Greater_Than' => [ 'min' => 0 ],
		// 		],
		// 	],

		// ];

		return $needs_customs ? array_merge( $standard, $customs_fields ) : $standard;
	}

	/**
	 * Update sender.
	 *
	 * @param int $sender_key Sender key.
	 *
	 * @return Label
	 */
	public function update_sender_key( $sender_key ) {
		return new self(
			$sender_key,
			$this->comment,
			$this->insurance,
			$this->first_item_value,
			$this->first_item_description,
			$this->package_list,
			$this->customs_tariff_number,
			$this->customs_consignor_reference
		);
	}
}
