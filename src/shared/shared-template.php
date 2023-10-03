<?php
/**
 * Shared template engine functions
 *
 * @package wooenvio/wecorreos/shared
 */

namespace WooEnvio\WECorreos\Shared\Template;

use League\Plates\Engine;

/**
 * Plates template engine: Render
 *
 * @param string $name Template name.
 * @param array  $data Data for template.
 * @return string
 */
function render( $name, $data ) {

	$template_base_path = __DIR__ . '/../Infrastructure/Web/Templates';
	$plates_engine      = ( new Engine( $template_base_path, 'php' ) )
		->addFolder( 'settings', $template_base_path . '/Settings' )
		->addFolder( 'costrules', $template_base_path . '/CostRules' )
		->addFolder( 'order', $template_base_path . '/Order' )
		->addFolder( 'shipping', $template_base_path . '/Shipping' )
		->addFolder( 'bulkactions', $template_base_path . '/Bulk/Actions' )
		->addFolder( 'bulkmessages', $template_base_path . '/Bulk/Messages' )
		->addFolder( 'bulkmodal', $template_base_path . '/Bulk/Modal' );

	return $plates_engine->render( $name, $data);
}

/**
 * Plates template engine: echo render
 *
 * @param string $name Template name.
 * @param array  $data Data for template.
 */
function echo_render( $name, $data ) {
	// phpcs:ignore
	echo render( $name, $data);
}
