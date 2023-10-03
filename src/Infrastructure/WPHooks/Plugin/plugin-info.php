<?php
/**
 * WPHooks
 * Add row information on plugin information
 *
 * @package wooenvio/wecorreos
 */

add_filter(
	'plugin_row_meta', function( $links, $file ) {

		$wecorreo_plugin_basename = 'wecorreos/WECorreos.php';

		if ( $wecorreo_plugin_basename === $file ) {
			$row_meta = array(
				'docs' => '<a href="' . esc_url( 'https://correos.es' ) . '" aria-label="' . esc_attr__( 'Correos documentation', 'correoswc' ) . '">' . esc_html__( 'Docs', 'correoswc' ) . '</a>',
			);

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
	},
	10, 2
);
