<?php
/**
 * Return actions
 *
 * @package wooenvio/wecorreos/Application/Front
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns\Returns_Recipient;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\Senders_Repository;

/**
 * Class Obtain_Returns_Recipient_From_Sender_Handler
 */
class Obtain_Returns_Recipient_From_Sender_Handler {

	/**
	 * Senders_Repository.
	 *
	 * @var Senders_Repository
	 */
	private $repository_senders;

	/**
	 * Obtain_Returns_Recipient_From_Sender_Handler constructor.
	 *
	 * @param Senders_Repository $repository_senders Senders_Repository.
	 */
	public function __construct( $repository_senders ) {
		$this->repository_senders = $repository_senders;
	}

	/**
	 * Execute service
	 *
	 * @param Obtain_Returns_Recipient_From_Sender_Request $request Obtain_Returns_Recipient_From_Sender_Request.
	 *
	 * @return Returns_Recipient
	 */
	public function __invoke( $request ) {

		$senders = $this->repository_senders->obtain();

		$sender = $senders->sender_by_key( $request->sender_key );

		return Returns_Recipient::build_from_sender( $sender );
	}
}
