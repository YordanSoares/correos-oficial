<?php
/**
 * Postoffice shipping order meta repository
 *
 * @package wooenvio/wecorreos/postoffice
 */

namespace WooEnvio\WECorreos\Postoffice\OrderMeta;

const POST_META_POSTOFFICE_CODE = '_wecorreos_selected_office';

/**
 * Store Postoffice Order meta
 *
 * @param int    $order_id Order ID.
 * @param string $postoffice_code Postoffice code.
 */
function update_postoffice_code( $order_id, $postoffice_code ) {
	\update_post_meta( $order_id, POST_META_POSTOFFICE_CODE, $postoffice_code);
}

/**
 * Get Postoffice Order meta
 *
 * @param int $order_id Order ID.
 * @return array|null
 */
function get_postoffice_code( $order_id ) {
	$postoffice_code = \get_post_meta( $order_id, POST_META_POSTOFFICE_CODE, true);
	return false === $postoffice_code ? null : $postoffice_code;
}
