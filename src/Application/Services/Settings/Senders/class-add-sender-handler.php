<?php
/**
 * Sender
 *
 * @package wooenvio/wecorreos/Application/Settings/Sender
 */

namespace WooEnvio\WECorreos\Application\Services\Settings\Senders;

use WooEnvio\WECorreos\Domain\Model\Settings\Sender\Sender;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\Senders_Repository;

/**
 * Settings Class.
 */
class Add_Sender_Handler {

	/**
	 * Senders Repository
	 *
	 * @var Senders_Repository
	 */
	private $repository;

	/**
	 * Setup class.
	 *
	 * @param Senders_Repository $repository Sender repo.
	 */
	public function __construct( $repository ) {
		$this->repository = $repository;
	}

	/**
	 * Execute service.
	 *
	 * @param Add_Sender_Request $request Add_Sender_Request.
	 * @throws \Exception Key already exists.
	 */
	public function __invoke( $request ) {

		$senders = $this->repository->obtain();

		if ( is_null( $senders ) ) {
			throw new \Exception( __( 'First save almost one', 'correoswc' ) );
		}

		if ( $this->check_exists_key_on( $request->key, $senders->sender_list()->senders() ) ) {
			throw new \Exception( 'This key exists' );
		}

		return Sender::build_by_key( $request->key );
	}

	/**
	 * Check already exists sender.
	 *
	 * @param string $key Key sender.
	 * @param array  $senders Senders.
	 */
	private function check_exists_key_on( $key, $senders ) {

		$senders_with_key = array_filter(
			$senders, function( $sender ) use ( $key ) {
				return (string) $sender->key() === $key;
			}
		);

		return count( $senders_with_key ) > 0;
	}
}
