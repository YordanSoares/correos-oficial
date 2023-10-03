<?php
/**
 * Citypaq shipping Correos webservice
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\CorreosWs\FavoritesCache;

const PREFIX_CITYPAQS_FAVORITES = 'wecorreos_citypaq_favorites';

/**
 * Get cached Citypaqs favorites by citypaq user
 *
 * @param string $citypaq_user City paq user.
 * @return array
 */
function obtain_cached_citypaqs_favorites( $citypaq_user ) {
	$citypaqs = \get_transient( citypaqs_favorites_transient_key( $citypaq_user) );
	return false === $citypaqs ? [] : $citypaqs;
}

/**
 * Store Citypaqs by postal code to cache
 *
 * @param string $citypaq_user City paq user.
 * @param array  $citypaqs Citypaq.
 */
function store_to_cache_citypaqs_favorites( $citypaq_user, $citypaqs ) {
	\set_transient( citypaqs_favorites_transient_key( $citypaq_user), $citypaqs);
}

/**
 * Cache key for Citypaqs by postal code
 *
 * @param string $citypaq_user City paq user.
 * @return string
 */
function citypaqs_favorites_transient_key( $citypaq_user ) {
	return sprintf( '%s_%s', PREFIX_CITYPAQS_FAVORITES, $citypaq_user);
}
