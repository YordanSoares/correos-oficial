<?php
/**
 * Return actions
 *
 * @package wooenvio/wecorreos/Application/Front
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns\Returns_Factory;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Returns\Returns_Repository;

/**
 * Class View_Returns_Handler
 */
class View_Returns_Handler {

	/**
	 * Returns_Repository
	 *
	 * @var Returns_Repository
	 */
	private $order_returns_repository;
	/**
	 * Returns_Factory
	 *
	 * @var Returns_Factory
	 */
	private $returns_factory;

	/**
	 * View_Returns_Handler constructor.
	 *
	 * @param Returns_Repository $order_returns_repository Returns_Repository.
	 * @param Returns_Factory    $returns_factory Returns_Factory.
	 */
	public function __construct( $order_returns_repository, $returns_factory ) {
		$this->order_returns_repository = $order_returns_repository;
		$this->returns_factory          = $returns_factory;
	}

	/**
	 * Execute service
	 *
	 * @param View_Returns_Request $request View_Returns_Request.
	 */
	public function __invoke( $request ) {
		$returns = $this->order_returns_repository->obtain( $request->order->order_id() );

		if ( null !== $returns ) {
			return $returns;
		}

		return $this->returns_factory->build_default_from( $request->order );
	}
}
