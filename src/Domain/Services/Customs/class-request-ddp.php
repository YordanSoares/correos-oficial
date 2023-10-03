<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Customs;

use WooEnvio\WECorreos\Domain\Model\Correos\Aduanas\Ddp_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Customs\Customs;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;
use WooEnvio\WECorreos\Domain\Model\Settings\General;
use WooEnvio\WECorreos\Domain\Model\Settings\Sender\Sender;

/**
 * Class Request_Ddp
 */
class Request_Ddp {

	/**
	 * Request_Ddp
	 *
	 * @var Request_Ddp
	 */
	private $client_correos;
	/**
	 * Ddp_Data_Factory
	 *
	 * @var Ddp_Data_Factory
	 */
	private $ddp_data_factory;

	/**
	 * Request_Ddp constructor.
	 *
	 * @param Request_Ddp      $client_correos Request_Ddp.
	 * @param Ddp_Data_Factory $ddp_data_factory Ddp_Data_Factory.
	 */
	public function __construct( $client_correos, $ddp_data_factory ) {
		$this->client_correos   = $client_correos;
		$this->ddp_data_factory = $ddp_data_factory;
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
		$ddp_data = $this->ddp_data_factory->build(
			$customs,
			$general,
			$order,
			$sender
		);

		return $this->client_correos->obtain( $ddp_data->data() );
	}
}
