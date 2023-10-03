<?php
/**
 * Services
 *
 * @package wooenvio/wecorreos
 */

use WooEnvio\WECorreos\Infrastructure\Install\Database\Maybe_Update_Database;
use WooEnvio\WECorreos\Infrastructure\Install\Database\Updater\Updater_Factory;
use WooEnvio\WECorreos\Infrastructure\Install\Database\Updater\Version10;

$cowc_container['maybe_update_database'] = function () {

	$updateFactory = Updater_Factory::create(
		[
			Version10::class,
		]
	);

	return Maybe_Update_Database::create( $updateFactory );
};
