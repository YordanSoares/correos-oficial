<?php
/**
 * Front actions
 *
 * @package wooenvio/wecorreos/Application/Front
 */

namespace WooEnvio\WECorreos\Application\Services\Front;

use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Selected_Office_Repository;

/**
 * Class Update_Selected_Office_Handler
 */
class Update_Selected_Office_Handler {

	/**
	 * Selected_Office_Repository.
	 *
	 * @var Selected_Office_Repository
	 */
	private $repository;

	/**
	 * Update_Selected_Office_Handler constructor.
	 *
	 * @param Selected_Office_Repository $repository Selected_Office_Repository.
	 */
	public function __construct( $repository ) {
		$this->repository = $repository;
	}

	/**
	 * Execute service.
	 *
	 * @param Update_Selected_Office_Request $request Update_Selected_Office_Request.
	 */
	public function __invoke( $request ) {
		$this->repository->persist( $request->order_id, $request->selected_office );
	}
}
