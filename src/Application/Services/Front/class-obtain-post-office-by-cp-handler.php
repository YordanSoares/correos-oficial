<?php
/**
 * Front actions
 *
 * @package wooenvio/wecorreos/Application/Front
 */

namespace WooEnvio\WECorreos\Application\Services\Front;

use WooEnvio\WECorreos\Domain\Services\Front\Request_Post_Offices_By_Cp_Options;

/**
 * Class Obtain_Post_Office_By_Cp_Handler
 */
class Obtain_Post_Office_By_Cp_Handler {

	const NONE         = 'none';
	const ENABLE_CACHE = true;

	/**
	 * Request_Post_Offices_By_Cp_Options
	 *
	 * @var Request_Post_Offices_By_Cp_Options
	 */
	private $request_obtain_offices;

	/**
	 * Obtain_Post_Office_By_Cp_Handler constructor.
	 *
	 * @param Request_Post_Offices_By_Cp_Options $request_obtain_offices Request_Post_Offices_By_Cp_Options.
	 */
	public function __construct( $request_obtain_offices ) {
		$this->request_obtain_offices = $request_obtain_offices;
	}

	/**
	 * Execute service.
	 *
	 * @param Obtain_Post_Office_By_Cp_Request $request Obtain_Post_Office_By_Cp_Request.
	 *
	 * @return array
	 */
	public function __invoke( $request ) {

		if ( empty( trim( $request->cp ) ) ) {
			return $this->none();
		}

		$request_obtain_offices = $this->request_obtain_offices;

		$options = $request_obtain_offices( $request->cp, self::ENABLE_CACHE );

		if ( null === $options ) {
			return $this->none();
		}

		return $this->none() + $options;
	}

	/**
	 * None selec office
	 */
	private function none() {
		return [
			self::NONE => __( 'Select one office', 'correoswc' ),
		];
	}
}
