<?php
/**
 * Services
 *
 * @package wooenvio/wecorreos
 */

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order_Factory;

$cowc_container['order_factory'] = function( $c ) {
	return new Order_Factory(
		$c['shipping_config'],
		$c['payment_config'],
		$c['selected_office_repository']
	);
};

$cowc_container['add_style_on_order_page'] = function( $c ) {

	$c['style_handler']->enqueue(
		'wecorreos-order-metabox.css',
		[],
		[ 'shop_order' ]
	);
};

$cowc_container['add_change_tab_js_on_order_page'] = function( $c ) {

	$c['script_handler']->enqueue(
		'wecorreos-change-tab.js',
		[ 'jquery' ],
		'change_settings',
		[
			'wrapper' => 'wecorreos-order-metabox',
		],
		[ 'shop_order' ]
	);
};
