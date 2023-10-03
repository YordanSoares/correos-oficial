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
class Update_Customs_Handler {

	/**
	 * Customs Repository.
	 *
	 * @var Customs_Repository
	 */
	private $repository;

	/**
	 * Setup class.
	 *
	 * @param Customs_Repository $repository Customs Repository.
	 */
	public function __construct( $repository ) {
		$this->repository = $repository;
	}

	/**
	 * Execute service.
	 *
	 * @param Update_Customs_Request $request Update Customs Request.
	 */
	public function __invoke( $request ) {
		$customs = Customs::build_and_validate( $request->customs_default_description, 
		                                        $request->customs_tariff_number,
												$request->customs_check_description_and_tariff,
												$request->customs_tariff_description,
												$request->customs_consignor_reference);
		$this->repository->persist( $customs );

		$this->repository->persist_customs_data( $customs->customs_tariff_number,
												  $customs->customs_check_description_and_tariff,
												  $customs->customs_tariff_description,
												  $customs->customs_consignor_reference
	                                             );
		return $customs;
	}
}
