<?php
/**
 * Customs
 *
 * @package wooenvio/wecorreos/Application/Settings/Customs
 */

namespace WooEnvio\WECorreos\Application\Services\Settings\Customs;

use WooEnvio\WECorreos\Domain\Model\Settings\Customs;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\Customs_Repository;

/**
 * Settings Class.
 */
class View_Customs_Handler {

	/**
	 * Customs Repository.
	 *
	 * @var Customs_Repository
	 */
	private $customs_repository;

	/**
	 * Setup class.
	 *
	 * @param Customs_Repository $customs_repository Customs_Repository.
	 */
	public function __construct( $customs_repository ) {
		$this->customs_repository = $customs_repository;
	}

	/**
	 * Execute service.
	 */
	public function __invoke() {
		$customs = $this->customs_repository->obtain();

		if ( null !== $customs ) {
			return $customs;
		}

		return Customs::build_default();
	}
}
