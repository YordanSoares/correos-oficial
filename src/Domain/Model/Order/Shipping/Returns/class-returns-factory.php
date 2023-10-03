<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Order/Shipping/Label/Returns
 */

namespace WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\Senders_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\WooCommerce\Bank_Account_Repository;

/**
 * Class Returns_Factory
 */
class Returns_Factory {

	/**
	 * Senders_Repository
	 *
	 * @var Senders_Repository
	 */
	private $senders_repository;
	/**
	 * Bank_Account_Repository
	 *
	 * @var Bank_Account_Repository
	 */
	private $bank_account_repository;

	/**
	 * Returns_Factory constructor.
	 *
	 * @param Senders_Repository      $senders_repository Senders_Repository.
	 * @param Bank_Account_Repository $bank_account_repository Bank_Account_Repository.
	 */
	public function __construct( $senders_repository, $bank_account_repository ) {
		$this->senders_repository      = $senders_repository;
		$this->bank_account_repository = $bank_account_repository;
	}

	/**
	 * Build default
	 *
	 * @param Order $order Order.
	 *
	 * @return Returns
	 */
	public function build_default_from( $order ) {

		$sender_key        = $this->default_sender_key();
		$returns_sender    = $this->returns_sender( $order );
		$returns_recipient = $this->returns_recipient();
		$cost              = $order->get_total();
		$ccc               = $this->bank_account();

		return new Returns( $sender_key, $returns_sender, $returns_recipient, '0.0', $ccc );

	}

	/**
	 * Sender
	 *
	 * @param Order $order Order.
	 *
	 * @return Returns_Sender
	 */
	private function returns_sender( $order ) {
		return new Returns_Sender(
			$order->get_shipping_first_name(),
			$order->get_shipping_last_name(),
			'',
			'',
			'',
			$order->get_shipping_address_1() . ' ' . $order->get_shipping_address_1(),
			$order->get_shipping_city(),
			$order->get_shipping_state(),
			$order->get_shipping_postcode(),
			$order->get_billing_phone(),
			$order->get_billing_email()
		);
	}

	/**
	 * Returns_Recipient
	 *
	 * @return Returns_Recipient
	 */
	private function returns_recipient() {
		$sender = $this->default_sender();

		return new Returns_Recipient(
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
	 * Default sender
	 *
	 * @return mixed
	 */
	private function default_sender() {

		$senders = $this->senders_repository->obtain();

		return $senders->sender_list()->default_sender();
	}

	/**
	 * Sender key
	 *
	 * @return mixed
	 */
	private function default_sender_key() {

		$senders = $this->senders_repository->obtain();

		return $senders->default_key();
	}

	/**
	 * Bank account
	 *
	 * @return mixed|string
	 */
	private function bank_account() {
		return $this->bank_account_repository->obtain();
	}
}
