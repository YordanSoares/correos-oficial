<?php
/**
 * Database
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Install\Database;

use WooEnvio\WECorreos\Infrastructure\Install\Database\Updater\Updater_Factory;

/**
 * Class Maybe_Update_Database
 */
class Maybe_Update_Database {

	const DATABASE_VERSION_OPTION  = 'wecorreos_db_version';
	const DEFAULT_DATABASE_VERSION = '0.0';

	/**
	 * Updater_Factory
	 *
	 * @var Updater_Factory
	 */
	private $updaterFactory;

	/**
	 * Maybe_Update_Database constructor.
	 *
	 * @param Updater_Factory $updaterFactory Updater_Factory.
	 */
	public function __construct( $updaterFactory ) {
		$this->updaterFactory = $updaterFactory;
	}

	/**
	 * Execute
	 */
	public function __invoke() {
		$currentVersion = $this->obtain_current_version();

		if ( ! $this->database_needs_update_for( $currentVersion ) ) {
			return;
		}

		$this->update_database_before( $currentVersion );
	}

	/**
	 * Current version.
	 *
	 * @return bool|mixed|void
	 */
	public function obtain_current_version() {
		return get_option( self::DATABASE_VERSION_OPTION, self::DEFAULT_DATABASE_VERSION );
	}

	/**
	 * Data
	 *
	 * @param string $currentVersion Version.
	 *
	 * @return bool|int
	 */
	private function database_needs_update_for( $currentVersion ) {
		$last_version = $this->updaterFactory->last_version();

		return version_compare( $currentVersion, $last_version, '<' );
	}

	/**
	 * Data
	 *
	 * @param string $currentVersion version.
	 *
	 * @throws \Exception Fail.
	 */
	private function update_database_before( $currentVersion ) {
		$updaters = $this->updaterFactory->obtain_before( $currentVersion );

		foreach ( $updaters as $version => $updater ) {
			$this->update_to( $version, $updater );
		}
	}

	/**
	 * Update
	 *
	 * @param string $version Version.
	 * @param mixed  $updater Updater.
	 *
	 * @throws \Exception Fail.
	 */
	private function update_to( $version, $updater ) {
		try {
			$updater();
			$this->update_current_version( $version );
		} catch ( \Exception $e ) {
			$error = sprintf( 'Correos Oficial: Error updating to version %s: %s', $version, $e->getMessage() );
			throw new \Exception( $error );
		}
	}

	/**
	 * Update current version
	 *
	 * @param string $version Version.
	 */
	private function update_current_version( $version ) {
		update_option( self::DATABASE_VERSION_OPTION, $version );
	}

	/**
	 * Create
	 *
	 * @param Updater_Factory $updaterFactory Updater_Factory.
	 *
	 * @return Maybe_Update_Database
	 */
	public static function create( $updaterFactory ) {
		return new self( $updaterFactory );
	}
}
