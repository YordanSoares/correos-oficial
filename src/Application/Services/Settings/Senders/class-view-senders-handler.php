<?php
/**
 * Sender
 *
 * @package wooenvio/wecorreos/Application/Settings/Sender
 */

namespace WooEnvio\WECorreos\Application\Services\Settings\Senders;

use WooEnvio\WECorreos\Domain\Model\Settings\Senders;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\Senders_Repository;

/**
 * Settings Class.
 */
class View_Senders_Handler {

	/**
	 * Senders Repository
	 *
	 * @var Senders_Repository
	 */
	private $senders_repository;

	/**
	 * Setup class.
	 *
	 * @param Senders_Repository $senders_repository Sender repo.
	 */
	public function __construct( $senders_repository ) {
		$this->senders_repository = $senders_repository;
	}

	/**
	 * Execute service.
	 */
	public function __invoke() {
		$senders = $this->senders_repository->obtain();

		if ( null !== $senders ) {
			return $senders;
		}

		return Senders::build_default();
	}
}
