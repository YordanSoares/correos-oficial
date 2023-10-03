<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Order/Shipping/Label/Returns
 */

namespace WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns;

/**
 * Class Returns_Sender
 */
class Returns_Sender extends Identity {

	/**
	 * Array Data
	 *
	 * @return array
	 */
	public function data() {
		return [
			'sender_first_name' => $this->first_name,
			'sender_last_name'  => $this->last_name,
			'sender_dni'        => $this->dni,
			'sender_company'    => $this->company,
			'sender_contact'    => $this->contact,
			'sender_address'    => $this->address,
			'sender_city'       => $this->city,
			'sender_state'      => $this->state,
			'sender_cp'         => $this->cp,
			'sender_phone'      => $this->phone,
			'sender_email'      => $this->email,
		];
	}

	/**
	 * Validation rules.
	 *
	 * @return array[]
	 */
	protected function rules() {
		return [
			'sender_address' => [
				'name'  => __( 'Address', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
			'sender_city'    => [
				'name'  => __( 'City', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
			'sender_state'   => [
				'name'  => __( 'State', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
			'sender_cp'      => [
				'name'  => __( 'CP', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
			'sender_email'   => [
				'name'  => __( 'Email', 'correoswc' ),
				'rules' => [ 'Is_Required', 'Is_Email' ],
			],
		];
	}
}

