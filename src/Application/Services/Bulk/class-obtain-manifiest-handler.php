<?php
/**
 * Bulk actions
 *
 * @package wooenvio/wecorreos/Application/Bulk
 */

namespace WooEnvio\WECorreos\Application\Services\Bulk;

use WooEnvio\WcPlugin\Common\Shipping_Config;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order_Factory;
use WooEnvio\WECorreos\Domain\Services\Bulk\Manifiest;
use WooEnvio\WECorreos\Infrastructure\Common\Files\Label_Files;

/**
 * Class Obtain_Manifiest_Handler
 */
class Obtain_Manifiest_Handler {

	/**
	 * Manifiest
	 *
	 * @var Manifiest
	 */
	private $manifiest;
	/**
	 * Label_files
	 *
	 * @var Label_Files
	 */
	private $label_files;
	/**
	 * Order_factory
	 *
	 * @var Order_Factory
	 */
	private $order_factory;
	/**
	 * Shipping_config
	 *
	 * @var Shipping_Config
	 */
	private $shipping_config;

	/**
	 * Obtain_Manifiest_Handler constructor.
	 *
	 * @param Manifiest       $manifiest Manifiest.
	 * @param Label_Files     $label_files Label_Files.
	 * @param Order_Factory   $order_factory Order_Factory.
	 * @param Shipping_Config $shipping_config Shipping_Config.
	 */
	public function __construct( $manifiest, $label_files, $order_factory, $shipping_config ) {
		$this->manifiest       = $manifiest;
		$this->label_files     = $label_files;
		$this->order_factory   = $order_factory;
		$this->shipping_config = $shipping_config;
	}

	/**
	 * Execute service
	 *
	 * @param Obtain_Manifiest_Request $request Obtain_Manifiest_Request.
	 *
	 * @return Merged_Info
	 * @throws \Exception Select one order.
	 */
	public function __invoke( $request ) {

		$order_ids = $request->order_ids;

		if ( count( $order_ids ) === 0 ) {
			throw new \Exception( __( 'Select one order', 'correoswc' ) );
		}

		$correos_order_ids = $this->correos_order_ids( $order_ids );

		$manifiest_order_ids = $this->manifiest_order_ids( $correos_order_ids );

		$not_manifiest_order_ids = $this->not_manifiest_order_ids( $correos_order_ids, $manifiest_order_ids );

		$not_correos_order_ids = $this->not_manifiest_order_ids( $order_ids, $correos_order_ids );

		$manifiest_download_link = $this->manifiest->generate( $manifiest_order_ids );

		return new Merged_Info(
			$manifiest_order_ids,
			$not_manifiest_order_ids,
			$not_correos_order_ids,
			$manifiest_download_link
		);
	}

	/**
	 * Manifiest_order_ids
	 *
	 * @param array $order_ids Order ids.
	 *
	 * @return array
	 */
	private function manifiest_order_ids( $order_ids ) {

		return array_filter(
			$order_ids, function( $order_id ) {

				return $this->label_files->exists( $order_id );

			}
		);
	}

	/**
	 * Correos_order_ids
	 *
	 * @param array $order_ids Order ids.
	 *
	 * @return array
	 */
	private function correos_order_ids( $order_ids ) {

		$correos_methods = $this->shipping_config->ids();

		return array_filter(
			$order_ids, function( $order_id ) use ( $correos_methods ) {

				$order = $this->order_factory->build( $order_id );

				return in_array( $order->shipping_method_id(), $correos_methods, true );

			}
		);
	}

	/**
	 * Not_manifiest_order_ids
	 *
	 * @param array $order_ids Order ids.
	 * @param array $manifiest_order_ids Manifest order ids.
	 *
	 * @return array
	 */
	private function not_manifiest_order_ids( $order_ids, $manifiest_order_ids ) {
		return array_diff( $order_ids, $manifiest_order_ids );
	}

}
