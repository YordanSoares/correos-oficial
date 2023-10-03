<?php
/**
 * Citypaq shipping Correos webservice
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\CorreosWs\ByState;

use function WooEnvio\ClientCorreos\Citypaq\Location\fetch_citypaqs_by_state_code;
use function WooEnvio\WECorreos\Citypaq\CorreosWs\ByCode\normalize_citypaqs;
use function WooEnvio\WECorreos\Citypaq\CorreosWs\ByCodeCache\store_to_cache_citypaqs_by_code;
use function WooEnvio\WECorreos\Citypaq\CorreosWs\ByStateCache\obtain_cached_citypaqs_by_state;
use function WooEnvio\WECorreos\Citypaq\CorreosWs\ByStateCache\store_to_cache_citypaqs_by_state;
use function WooEnvio\WECorreos\Shared\Checkout\correos_credentials;

/**
 * Citypaq by state from Correos web service
 *
 * @param string $state Citypaq user.
 * @return array
 */
function obtain_citypaqs_by_state( $state ) {
	$citypaqs = obtain_cached_citypaqs_by_state( $state );

	if ( ! empty( $citypaqs) ) {
		return $citypaqs;
	}

	$citypaqs = normalize_citypaqs(
		fetch_citypaqs_by_state_code( correos_credentials(), $state)
	);
	store_to_cache_citypaqs_by_state( $state, $citypaqs);
	store_to_cache_citypaqs_by_code( $citypaqs );

	return $citypaqs;
}
