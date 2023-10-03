<?php
/**
 * Citypaq shipping Correos webservice
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\CorreosWs\Bycp;

use function WooEnvio\ClientCorreos\Citypaq\Location\fetch_citypaqs_by_postal_code;
use function WooEnvio\WECorreos\Citypaq\CorreosWs\ByCode\normalize_citypaqs;
use function WooEnvio\WECorreos\Citypaq\CorreosWs\ByCodeCache\store_to_cache_citypaqs_by_code;
use function WooEnvio\WECorreos\Citypaq\CorreosWs\ByCpCache\obtain_cached_citypaqs_by_cp;
use function WooEnvio\WECorreos\Citypaq\CorreosWs\ByCpCache\store_to_cache_citypaqs_by_cp;
use function WooEnvio\WECorreos\Shared\Checkout\correos_credentials;

/**
 * Citypaq by postal code from Correos web service
 *
 * @param string $cp Postal code.
 * @return array
 */
function obtain_citypaqs_by_cp( $cp ) {

	$citypaqs = obtain_cached_citypaqs_by_cp( $cp );

	if ( ! empty( $citypaqs) ) {
		return $citypaqs;
	}

	$citypaqs = normalize_citypaqs(
		fetch_citypaqs_by_postal_code( correos_credentials(), $cp)
	);
	store_to_cache_citypaqs_by_cp( $cp, $citypaqs);
	store_to_cache_citypaqs_by_code( $citypaqs );

	return $citypaqs;
}


