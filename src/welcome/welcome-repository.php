<?php
/**
 * Display welcome repository
 *
 * @package wooenvio/wecorreos/welcome
 */

namespace WooEnvio\WECorreos\Welcome;

const DISPLAY_WELCOME_OPTION = 'wecorreos_display_welcome';

/**
 * Update setting no display welcome page
 */
function update_no_display_welcome() {
	\update_option( DISPLAY_WELCOME_OPTION, 0);
}

/**
 * GEt setting no display welcome page
 */
function get_display_welcome() {
	return \get_option( DISPLAY_WELCOME_OPTION, 1);
}
