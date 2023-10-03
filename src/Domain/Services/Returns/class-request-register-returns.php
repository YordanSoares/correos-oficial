<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Returns;

use WooEnvio\ClientCorreos\WsPreregistro\Preregistro\Preregistro_Bulto;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Returns_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Label;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns\Returns;
use WooEnvio\WECorreos\Domain\Model\Settings\General;

/**
 * Class Request_Register_Returns
 */
class Request_Register_Returns {

	/**
	 * Preregistro_Bulto
	 *
	 * @var Preregistro_Bulto
	 */
	private $client_correos;
	/**
	 * Returns_Data_Factory
	 *
	 * @var Returns_Data_Factory
	 */
	private $register_returns_data_factory;

	/**
	 * Request_Register_Returns constructor.
	 *
	 * @param Preregistro_Bulto    $client_correos Preregistro_Bulto.
	 * @param Returns_Data_Factory $register_returns_data_factory Returns_Data_Factory.
	 */
	public function __construct( $client_correos, $register_returns_data_factory ) {
		$this->client_correos                = $client_correos;
		$this->register_returns_data_factory = $register_returns_data_factory;
	}

	/**
	 * Execute
	 *
	 * @param General $general General.
	 * @param Label   $label Label.
	 * @param Order   $order Order.
	 * @param Returns $returns Returns.
	 *
	 * @return array
	 * @throws \WooEnvio\ClientCorreos\WsPreregistro\Preregistro\Preregistro_Bulto_Exception Fail pre.
	 */
	public function __invoke( $general, $label, $order, $returns ) {
   //var_dump('DEBUG REQUEST_REGISTER_RETURNS_3', $returns);
		$register_data = $this->register_returns_data_factory->build(
			$general,
			$label,
			$order,
			$returns
		);
//var_dump('DEBUG REQUEST_REGISTER_RETURNS_5', $register_data->data());
		return $this->client_correos->preregistro( $register_data->data() );
	}
}
