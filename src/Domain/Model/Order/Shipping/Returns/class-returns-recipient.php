<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Order/Shipping/Label/Returns
 */

namespace WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns;

use WooEnvio\WECorreos\Domain\Model\Settings\Sender\Sender;

/**
 * Class Returns_Recipient
 */
class Returns_Recipient extends Identity {

	/**
	 * Return array data.
	 *
	 * @return array
	 */
	public function data() {
		return [
			'recipient_first_name' => $this->first_name,
			'recipient_last_name'  => $this->last_name,
			'recipient_dni'        => $this->dni,
			'recipient_company'    => $this->company,
			'recipient_contact'    => $this->contact,
			'recipient_address'    => $this->address,
			'recipient_city'       => $this->city,
			'recipient_state'      => $this->state,
			'recipient_cp'         => $this->cp,
			'recipient_phone'      => $this->phone,
			'recipient_email'      => $this->email,
		];
	}

	/**
	 * Build from sender.
	 *
	 * @param Sender $sender Sender.
	 *
	 * @return Returns_Recipient
	 */
	public static function build_from_sender( $sender ) {
		return new self(
			$sender->first_name(),
			$sender->last_name(),
			$sender->dni(),
			$sender->company(),
			$sender->contact(),
			$sender->address(),
			$sender->city(),
			$sender->state(),
			$sender->cp(),
			$sender->phone(),
			$sender->email()
		);
	}

	/**
	 * Validation rules.
	 *
	 * @return array[]
	 */
	protected function rules() {
		return [
			'recipient_address' => [
				'name'  => __( 'Address', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
			'recipient_city'    => [
				'name'  => __( 'City', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
			'recipient_state'   => [
				'name'  => __( 'State', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
			'recipient_cp'      => [
				'name'  => __( 'CP', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
			'recipient_email'   => [
				'name'  => __( 'Email', 'correoswc' ),
				'rules' => [ 'Is_Required', 'Is_Email' ],
			],
		];
	}
}

