<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Order/Shipping/Label/Package
 */

namespace WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Package;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;

/**
 * Class Package_List
 */
class Package_List {

	/**
	 * Packages
	 *
	 * @var array
	 */
	private $packages;

	/**
	 * Package_List constructor.
	 *
	 * @param array $packages Packages.
	 */
	public function __construct( $packages ) {
		$this->packages = $packages;
	}

	/**
	 * To array
	 *
	 * @return array
	 */
	public function data() {
		return array_map(
			function( $package ) {
				return $package->data();
			}, $this->packages
		);
	}

	/**
	 * Packages
	 *
	 * @return array
	 */
	public function packages() {
		return $this->packages;
	}

	/**
	 * Weight
	 *
	 * @return float|int
	 */
	public function weight() {
		$packages = array_map(
			function( $package ) {
				return $package->weight();
			}, $this->packages
		);

		return array_sum( $packages );
	}

	/**
	 * Num of packages
	 *
	 * @return int|void
	 */
	public function num_packages() {
		return count( $this->packages );
	}

	/**
	 * First
	 *
	 * @return mixed
	 */
	public function first() {

		$first = $this->packages[0];

		return $first;
	}

	/**
	 * Build default
	 *
	 * @param Order $order Order.
	 *
	 * @return static
	 */
	public static function build_default( $order ) {
		return new static( [ Package::build_default( $order ) ] );
	}

	/**
	 * Build
	 *
	 * @param array $data Data.
	 *
	 * @return Package_List
	 */
	public static function build( $data ) {
		$packages = array_map(
			function( $package_data ) {
				return Package::build( $package_data );
			}, $data
		);

		return new self( $packages );
	}

	/**
	 * Build and validate
	 *
	 * @param array $data Data.
	 *
	 * @return Package_List
	 */
	public static function build_and_validate( $data ) {

		$packages = array_map(
			function( $package_data ) {
				return Package::build_and_validate( $package_data );
			}, $data
		);

		return new self( $packages );
	}
}
