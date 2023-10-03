<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Label;

use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\General_Repository;
use function WooEnvio\ClientCorreos\Tracking\fetch_tracking_by_correos_code;

/**
 * Class Tracking
 */
class Tracking {

	/**
	 * Tracking constructor.
	 *
	 * @param General_Repository $general_repository General repo.
	 */
	public function __construct( $general_repository ) {
		$this->general_repository = $general_repository;
	}

	/**
	 * Execute
	 *
	 * @param mixed $correos_id Correos id.
	 * @return mixed
	 */
	public function execute( $correos_id ) {
		if ( is_array( $correos_id) ) {
			$correos_id = array_keys( $correos_id);
			$correos_id = array_shift( $correos_id);
		}
		$general = $this->general_repository->obtain();
		$result  = fetch_tracking_by_correos_code( $general->soap_options(), $correos_id );
		return $result;
	}
}
