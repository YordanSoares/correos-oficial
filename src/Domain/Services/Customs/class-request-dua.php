<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Customs;

use WooEnvio\WECorreos\Domain\Model\Correos\Aduanas\Dua_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Customs\Customs;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;
use WooEnvio\WECorreos\Domain\Model\Settings\General;
use WooEnvio\WECorreos\Domain\Model\Settings\Sender\Sender;

/**
 * Class Request_Dua
 */
class Request_Dua {

	/**
	 * Request_Dua
	 *
	 * @var Request_Dua
	 */
	private $client_correos;
	/**
	 * Dua_Data_Factory
	 *
	 * @var Dua_Data_Factory
	 */
	private $dua_data_factory;

	/**
	 * Request_Dua constructor.
	 *
	 * @param Request_Dua      $client_correos Request_Dua.
	 * @param Dua_Data_Factory $dua_data_factory Dua_Data_Factory.
	 */
	public function __construct( $client_correos, $dua_data_factory ) {
		$this->client_correos   = $client_correos;
		$this->dua_data_factory = $dua_data_factory;
	}

	/**
	 * Execute
	 *
	 * @param Customs $customs Customs.
	 * @param General $general General.
	 * @param Order   $order Order.
	 * @param Sender  $sender Sender.
	 *
	 * @return mixed
	 */
	public function __invoke( $customs, $general, $order, $sender ) {
		$dua_data = $this->dua_data_factory->build(
			$customs,
			$general,
			$order,
			$sender
		);

		return $this->client_correos->obtain( $dua_data->data() );
	}
}
