<?php
/**
 * Label actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Label
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Label;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Label;
use WooEnvio\WECorreos\Domain\Services\Label\Tracking;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Correos_Id_Repository;

/**
 * Class View_Tracking_Handler
 */
class View_Tracking_Handler {

	/**
	 * Correos_Id_Repository
	 *
	 * @var Correos_Id_Repository
	 */
	private $correos_id_repository;
	/**
	 * Tracking
	 *
	 * @var Tracking
	 */
	private $tracking;

	/**
	 * View_Tracking_Handler constructor.
	 *
	 * @param Correos_Id_Repository $correos_id_repository Correos_Id_Repository.
	 * @param Tracking              $tracking Tracking.
	 */
	public function __construct( $correos_id_repository, $tracking ) {
		$this->correos_id_repository = $correos_id_repository;
		$this->tracking              = $tracking;
	}

	/**
	 * Execute action
	 *
	 * @param View_Tracking_Request $request View_Tracking_Request.
	 *
	 * @return array|\stdClass[]
	 */
	public function __invoke( $request ) {
		$correos_id = $this->correos_id_repository->obtain( $request->order_id );

		$result = $this->tracking->execute( $correos_id );
		if ( is_null( $result) ) {
			$event                  = new \stdClass();
			$event->fecEvento       = '';
			$event->desTextoResumen = 'Service Temporarily Unavailable';
			return [ $event ];
		}
		if ( '0' === $result[0]->error->codError ) {
			return $result[0]->eventos;
		}
		return [];
	}
}
