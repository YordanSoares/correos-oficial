<?php
/**
 * Postoffice shipping Correos webservice connect
 *
 * @package wooenvio/wecorreos/postoffice
 */

namespace WooEnvio\WECorreos\Postoffice\WebService;

use WooEnvio\ClientCorreos\WsLocalizadorOficinas\Localizador_Oficinas;
use function WooEnvio\WECorreos\Postoffice\WebServiceCache\obtain_cached_postoffice_by_code;
use function WooEnvio\WECorreos\Postoffice\WebServiceCache\obtain_cached_postoffices_by_cp;
use function WooEnvio\WECorreos\Postoffice\WebServiceCache\store_to_cache_postoffices_by_code;
use function WooEnvio\WECorreos\Postoffice\WebServiceCache\store_to_cache_postoffices_by_cp;

/**
 * Postoffice by postal code from Correos web service
 *
 * @param string $cp Postal code.
 * @return array
 */
function obtain_postoffices_by_cp( $cp ) {

	$postoffices = obtain_cached_postoffices_by_cp( $cp);

	if ( ! empty( $postoffices) ) {
		return $postoffices;
	}

	$postoffices_finder = new Localizador_Oficinas();
	$postoffices        = normalize_postoffices( $postoffices_finder->by_cp( $cp));

	store_to_cache_postoffices_by_cp( $cp, $postoffices);
	store_to_cache_postoffices_by_code( $postoffices );

	return $postoffices;
}

/**
 * Cast postoffices objects to associative arrays
 *
 * @param string $postoffices Postal code.
 * @return array
 */
function normalize_postoffices( $postoffices ) {
	if ( is_null( $postoffices) ) {
		return [];
	}
	return array_map(function( $paq ) {
		return (array) $paq;
	}, $postoffices);
}

/**
 * Postoffice data by postoffice code
 *
 * @param string $code Postoffice code.
 * @return array
 */
function obtain_postoffice_by_code( $code ) {
	return obtain_cached_postoffice_by_code( $code);
}
