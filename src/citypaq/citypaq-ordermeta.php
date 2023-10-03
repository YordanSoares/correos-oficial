<?php
/**
 * Citypaq shipping order meta repository
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\OrderMeta;

const POST_META_CITYPAQ_CODE = '_wecorreos_citypaq_code';

/**
 * Store Citypaq Order meta
 *
 * @param int    $order_id Order ID.
 * @param string $citypaq_code Citypaq code.
 */
function update_citypaq_code( $order_id, $citypaq_code ) {
	\update_post_meta( $order_id, POST_META_CITYPAQ_CODE, $citypaq_code);
}

/**
 * Get Citypaq Order meta
 *
 * @param int $order_id Order ID.
 * @return array|null
 */
function get_citypaq_code( $order_id ) {
	$citypaq_code = \get_post_meta( $order_id, POST_META_CITYPAQ_CODE, true);
	return false === $citypaq_code ? null : $citypaq_code;
}
