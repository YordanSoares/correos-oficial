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
class Update_Senders_Handler {

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
	 * @param Update_Senders_Request $request Update_Senders_Request.
	 */
	public function __invoke( $request ) {
		$senders = Senders::build_and_validate(
			$request->senders
		);

		$this->repository->persist( $senders );

		return $senders;
	}
}
