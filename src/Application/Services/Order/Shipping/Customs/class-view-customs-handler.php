<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Customs
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Customs\Customs;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Customs\Customs_Repository;

/**
 * Class View_Customs_Handler
 */
class View_Customs_Handler {

	/**
	 * Customs_Repository
	 *
	 * @var Customs_Repository
	 */
	private $order_customs_repository;

	/**
	 * View_Customs_Handler constructor.
	 *
	 * @param Customs_Repository $order_customs_repository Customs_Repository.
	 */
	public function __construct( $order_customs_repository ) {
		$this->order_customs_repository = $order_customs_repository;
	}

	/**
	 * Execute action
	 *
	 * @param View_Customs_Request $request View_Customs_Request.
	 *
	 * @return Customs|\WooEnvio\WECorreos\Domain\Model\Settings\Customs
	 */
	public function __invoke( $request ) {

		$customs = $this->order_customs_repository->obtain( $request->order_id );

		if ( null !== $customs ) {
			return $customs;
		}

		return Customs::build_default();
	}
}
