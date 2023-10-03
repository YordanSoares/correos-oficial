<?php
/**
 * General
 *
 * @package wooenvio/wecorreos/Application/Settings/General
 */

namespace WooEnvio\WECorreos\Application\Services\Settings\General;

use WooEnvio\WECorreos\Domain\Model\Settings\General;
use WooEnvio\WECorreos\Domain\Model\Settings\Shipping\Shipping_List;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\General_Repository;

/**
 * Settings Class.
 */
class Update_General_Handle {

	/**
	 * General Repository.
	 *
	 * @var General_Repository
	 */
	private $repository;

	/**
	 * Setup class.
	 *
	 * @param General_Repository $repository General Repository.
	 */
	public function __construct( $repository ) {
		$this->repository = $repository;
	}

	/**
	 * Execute service.
	 *
	 * @param Update_General_Request $request Update_General_Request.
	 */
	public function __invoke( $request ) {
		$shippings = new Shipping_List(
			isset( $request->paq48home ) && $request->paq48home,
			isset( $request->paq72home ) && $request->paq72home,
			isset( $request->paq48office ) && $request->paq48office,
			isset( $request->paq72office ) && $request->paq72office,
			isset( $request->international ) && $request->international,
			isset( $request->paqlightinternational ) && $request->paqlightinternational,
			isset( $request->paq48citypaq ) && $request->paq48citypaq,
			isset( $request->paq72citypaq ) && $request->paq72citypaq
		);

		$general = General::build_and_validate(
			$request->user,
			$request->password,
			$request->labeler_code,
			$request->contract_number,
			$request->client_number,
			$shippings,
			$request->enabled_sms,
			$request->order_status_on_obtain_label,
			$request->googlemap_apikey,
			$request->altsslcom,
			$request->enabled_required_id,
			$request->enabled_personalised_id,
			$request->personalised_id
		);

		$this->repository->persist( $general );

		return $general;
	}
}
