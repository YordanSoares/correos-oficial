<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Order/Shipping/Label/Returns
 */

namespace WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns;

use WooEnvio\WpPlugin\Validates\Validate_Data;

/**
 * Class Returns
 */
class Returns {

	/**
	 * Recipient_key
	 *
	 * @var mixed
	 */
	private $recipient_key;
	/**
	 * Returns_sender
	 *
	 * @var mixed
	 */
	private $returns_sender;
	/**
	 * Returns_recipient
	 *
	 * @var mixed
	 */
	private $returns_recipient;
	/**
	 * Return_cost
	 *
	 * @var mixed
	 */
	private $return_cost;
	/**
	 * Return_ccc
	 *
	 * @var mixed
	 */
	private $return_ccc;

	/**
	 * Package_list
	 *
	 * @var mixed
	 */
	private $package_list;

	/**
	 * Returns constructor.
	 *
	 * @param mixed $recipient_key Recipient_key.
	 * @param mixed $returns_sender Returns_sender.
	 * @param mixed $returns_recipient Returns_recipient.
	 * @param mixed $return_cost Return_cost.
	 * @param mixed $return_ccc Return_ccc.
	 * @param mixed $package_list $package_list
	 */
	public function __construct( $recipient_key, $returns_sender, $returns_recipient, $return_cost, $return_ccc,
	$packages='') {
		$this->recipient_key     = $recipient_key;
		$this->returns_sender    = $returns_sender;
		$this->returns_recipient = $returns_recipient;
		$this->return_cost       = $return_cost;
		$this->return_ccc        = $return_ccc;
		$this->packages_list   	 = $packages;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function recipient_key() {
		return $this->recipient_key;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function returns_sender() {
		return $this->returns_sender;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function returns_recipient() {
		return $this->returns_recipient;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function return_cost() {
		return $this->return_cost;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function return_ccc() {
		return $this->return_ccc;
	}

	/**
	 * Data
	 * @return mixed
	 */
	public function package_list(){
		return $this->packages_list;
	}

	/**
	 * To array
	 *
	 * @return array
	 */
	public function data() {
		$returns_data = [
			'recipient_key' => $this->recipient_key,
			'return_cost'   => $this->return_cost,
			'return_ccc'    => $this->return_ccc,
			'packages'      => $this->packages_list->data()
		];

		return array_merge(
			$returns_data,
			$this->returns_sender->data(),
			$this->returns_recipient->data()
		);
	}

	/**
	 * Validate or fail
	 *
	 * @throws \WooEnvio\WpPlugin\Validates\Validation_Exception Fail validation rules.
	 */
	public function validate_or_fail() {
		( new Validate_Data( $this->rules(), $this->data(), 'correoswc' ) )->validate();
	}

	/**
	 * Validate rules
	 *
	 * @return array[]
	 */
	private function rules() {
		return [
			'recipient_key' => [
				'name'  => __( 'Recipient', 'correoswc' ),
				'rules' => [ 'Is_Int' ],
			],
			'return_cost'   => [
				'name'  => __( 'Cost', 'correoswc' ),
				'rules' => [
					'Is_Float',
					'Is_Greater_Than' => [
						'min'       => 0,
						'inclusive' => true,
					],
				],
			],
			'return_ccc'    => [
				'name'  => __( 'CCC', 'correoswc' ),
				'rules' => [ 'Is_Iban' ],
			],
		];
	}
}
