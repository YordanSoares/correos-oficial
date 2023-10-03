<?php
/**
 * Citypaq shipping Correos webservice
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\CorreosWs\ByCode;

use function WooEnvio\WECorreos\Citypaq\CorreosWs\ByCodeCache\obtain_cached_citypaq_by_code;

/**
 * Citypaq data by citypaq code
 *
 * @param string $code Citypaq code.
 * @return array
 */
function obtain_citypaq_by_code( $code ) {
	return obtain_cached_citypaq_by_code( $code);
}

/**
 * Cast citypaqs objects to associative arrays
 *
 * @param string $citypaqs Postal code.
 * @return array
 */
function normalize_citypaqs( $citypaqs ) {
	if ( is_null( $citypaqs) ) {
		return [];
	}
	return array_map(function( $paq ) {
		return (array) $paq;
	}, $citypaqs);
}
