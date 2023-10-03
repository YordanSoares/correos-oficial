<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Label;

use WooEnvio\ClientCorreos\WsPreregistro\Preregistro\Preregistro_Bulto;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Preregistro_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Label;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;
use WooEnvio\WECorreos\Domain\Model\Settings\General;
use WooEnvio\WECorreos\Domain\Model\Settings\Sender\Sender;

/**
 * Class Request_Register
 */
class Request_Register {

	/**
	 * Preregistro_Bulto
	 *
	 * @var Preregistro_Bulto
	 */
	private $client_correos;
	/**
	 * Preregistro_Data_Factory
	 *
	 * @var Preregistro_Data_Factory
	 */
	private $register_data_factory;

	/**
	 * Request_Register constructor.
	 *
	 * @param Preregistro_Bulto        $client_correos Preregistro_Bulto.
	 * @param Preregistro_Data_Factory $register_data_factory Preregistro_Data_Factory.
	 */
	public function __construct( $client_correos, $register_data_factory ) {
		$this->client_correos        = $client_correos;
		$this->register_data_factory = $register_data_factory;
	}

	/**
	 * Execute.
	 *
	 * @param General $general General.
	 * @param Sender  $sender Sender.
	 * @param Label   $label Label.
	 * @param Order   $order Order.
	 *
	 * @return array
	 * @throws \WooEnvio\ClientCorreos\WsPreregistro\Preregistro\Preregistro_Bulto_Exception Fail.
	 */
	public function __invoke( $general, $sender, $label, $order ) {
		$register_data = $this->register_data_factory->build(
			$general,
			$sender,
			$label,
			$order
		);
		//var_dump('DEBUG REQUEST_REGISTER_LABEL_B', $register_data->data());

		return $this->client_correos->preregistro( $register_data->data() );
	}
}
