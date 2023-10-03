<?php
/**
 * Shared ajax functions
 *
 * @package wooenvio/wecorreos/shared
 */

namespace WooEnvio\WECorreos\Shared\Checkout;

use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\General_Repository;

/**
 * Correos credentials
 *
 * @return array
 */
function correos_credentials() {
	$general = ( new General_Repository( 'wecorreos') )->obtain();
	return $general->credentials();
}
