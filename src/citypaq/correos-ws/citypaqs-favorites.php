<?php
/**
 * Citypaq shipping Correos webservice
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\CorreosWs\Favorites;

use function WooEnvio\ClientCorreos\Citypaq\Favorites\fetch_favorites_citypaqs_by_citypaq_user;
use function WooEnvio\ClientCorreos\Citypaq\Location\fetch_citypaqs_by_state_code;
use function WooEnvio\WECorreos\Citypaq\CorreosWs\ByCode\normalize_citypaqs;
use function WooEnvio\WECorreos\Citypaq\CorreosWs\ByCodeCache\store_to_cache_citypaqs_by_code;
use function WooEnvio\WECorreos\Citypaq\CorreosWs\FavoritesCache\obtain_cached_citypaqs_favorites;
use function WooEnvio\WECorreos\Citypaq\CorreosWs\FavoritesCache\store_to_cache_citypaqs_favorites;
use function WooEnvio\WECorreos\Shared\Checkout\correos_credentials;

/**
 * Citypaq favorites from citypaq user from Correos web service
 *
 * @param string $citypaq_user Citypaq user.
 * @return array
 */
function obtain_citypaqs_favorites( $citypaq_user ) {

	$citypaqs = normalize_citypaqs(
		fetch_favorites_citypaqs_by_citypaq_user( correos_credentials(), $citypaq_user)
	);

	store_to_cache_citypaqs_favorites( $citypaq_user, $citypaqs);
	store_to_cache_citypaqs_by_code( $citypaqs );

	return $citypaqs;
}
