<?php
/**
 * General
 *
 * @package wooenvio/wecorreos/Application/Settings/General
 */

namespace WooEnvio\WECorreos\Application\Services\Settings\General;

use WooEnvio\WECorreos\Domain\Model\Settings\General;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\General_Repository;

/**
 * Settings Class.
 */
class View_General_Handle {

	/**
	 * General Repository.
	 *
	 * @var General_Repository
	 */
	private $general_repository;

	/**
	 * Setup class.
	 *
	 * @param General_Repository $general_repository General Repository.
	 */
	public function __construct( $general_repository ) {
		$this->general_repository = $general_repository;
	}

	/**
	 * Execute service.
	 */
	public function __invoke() {
		$general = $this->general_repository->obtain();

		if ( null !== $general ) {
			return $general;
		}

		return General::build_default();
	}
}
