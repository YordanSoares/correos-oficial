<?php
/**
 * Label actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Label
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Label;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Package\Package_List;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Package\Package;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;

/**
 * Class Add_Package_Handler
 */
class Add_Package_Handler {

	const MAX_PACKAGES = 6;

	/**
	 * Execute action
	 *
	 * @param Add_Package_Request $request Add_Package_Request.
	 *
	 * @return Package
	 * @throws \Exception Max packages.
	 */
	public function __invoke( $request ) {

		$order = $request->order;

		$packages = $request->packages;

		$package = $this->build_package( $order, $packages );

		return $package;
	}

	/**
	 * Build package
	 *
	 * @param Order $order Order.
	 * @param array $packages Packages.
	 *
	 * @return Package
	 * @throws \Exception Max packages.
	 */
	private function build_package( $order, $packages ) {

		$package = Package::build_default( $order );

		$last_package_key = $this->last_package_key( $packages );

		$next_package_key = $last_package_key + 1;

		if ( $next_package_key > self::MAX_PACKAGES ) {
			throw new \Exception(
				sprintf( __( 'maximum %s packages', 'correoswc' ), self::MAX_PACKAGES )
			);
		}

		return $package->change_key( $next_package_key );
	}

	/**
	 * Last packages key.
	 *
	 * @param array $packages Packages.
	 *
	 * @return mixed
	 */
	private function last_package_key( $packages ) {

		$package_list = Package_List::build_and_validate( $packages );

		$pacakges = $package_list->packages();

		$last_package = end( $pacakges );

		return $last_package->key();
	}
}
