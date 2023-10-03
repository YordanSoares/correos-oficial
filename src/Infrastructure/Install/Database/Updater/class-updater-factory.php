<?php
/**
 * Database
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Install\Database\Updater;

/**
 * Class Updater_Factory
 */
class Updater_Factory {

	/**
	 * Versiob
	 *
	 * @var array
	 */
	private $versionToUpdaterClassList = [];

	/**
	 * Updater_Factory constructor.
	 *
	 * @param array $updaterClassList UpdaterClassList.
	 */
	public function __construct( $updaterClassList ) {
		$this->build_version_to_updater_class_list( $updaterClassList );
	}

	/**
	 * Build
	 *
	 * @param array $updaterClassList UpdaterClassList.
	 */
	private function build_version_to_updater_class_list( $updaterClassList ) {
		array_map(
			function ( $class ) {

				$this->versionToUpdaterClassList[ $class::VERSION ] = $class;
			}, $updaterClassList
		);
	}

	/**
	 * LAst
	 *
	 * @return mixed
	 */
	public function last_version() {
		$allVersions = array_keys( $this->versionToUpdaterClassList );

		return end( $allVersions );
	}

	/**
	 * Obtain before
	 *
	 * @param string $version Version.
	 *
	 * @return array
	 */
	public function obtain_before( $version ) {
		$updaters = $this->filter_updaters_before( $version );

		return array_map(
			function ( $updater ) {

				return new $updater();
			}, $updaters
		);
	}

	/**
	 * Obtain before
	 *
	 * @param string $version Version.
	 *
	 * @return array
	 */
	private function filter_updaters_before( $version ) {
		return array_filter(
			$this->versionToUpdaterClassList, function ( $updaterVersion ) use ( $version ) {

				return version_compare( $updaterVersion, $version, '>' );
			}, ARRAY_FILTER_USE_KEY
		);
	}

	/**
	 * Create
	 *
	 * @param array $list class list.
	 *
	 * @return Updater_Factory
	 */
	public static function create( $list ) {
		return new self( $list );
	}
}
