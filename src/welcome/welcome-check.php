<?php
/**
 * Check display welcome repository
 *
 * @package wooenvio/wecorreos/welcome
 */

namespace WooEnvio\WECorreos\Welcome;

/**
 * Check if display welcome page
 */
function check_display_welcome() {
	if ( check_existing_general_settings() ) {
		return false;
	}
	return get_display_welcome();
}

/**
 * Check if exits general settings
 */
function check_existing_general_settings() {
	return ! empty( \get_option( 'wecorreos_settings_general', []));
}
