<?php
/**
 * Services
 *
 * @package wooenvio/wecorreos
 */

use WooEnvio\WECorreos\Application\Services\Front\Obtain_Post_Office_By_Cp_Handler;
use WooEnvio\WECorreos\Domain\Services\Front\Request_Post_Offices_By_Cp_Options;
use WooEnvio\ClientCorreos\WsLocalizadorOficinas\Localizador_Oficinas;
use WooEnvio\WECorreos\Infrastructure\Repositories\Cache\Cache_Post_Office_By_Cp_Options;
use WooEnvio\WECorreos\Infrastructure\Repositories\Cache\Cache_Oficina_Data;

$cowc_container['post_office_selected'] = function() {
	if ( isset( $_POST['wecorreos-select-office-form']['selected_office'] ) ) {
		return \sanitize_text_field( $_POST['wecorreos-select-office-form']['selected_office'] );
	}

	return Obtain_Post_Office_By_Cp_Handler::NONE;
};

$cowc_container['add_style_on_checkout_page'] = function( $c ) {

	$c['style_handler']->enqueue(
		'wecorreos-front.css',
		[],
		function () {
			return is_checkout();
		}
	);
};

$cowc_container['enqueue_wecorreos_ajax_js_on_front'] = function( $c ) {

	$dependencies = [ 'jquery', 'jquery-blockui' ];
	$general      = $c['general_repository']->obtain();
	if ( false === is_null( $general) && $general->active_googlemap() ) {

		$src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=' . $general->googlemap_apikey();
		wp_register_script( 'wecorreos-googlemap', $src, [], true, true );
		$dependencies[] = 'wecorreos-googlemap';
	}

	$c['script_handler']->enqueue(
		'wecorreos-ajax.js',
		$dependencies,
		'ajax_object',
		[
			'ajax_url'          => admin_url( 'admin-ajax.php' ),
			'nonce'             => wp_create_nonce( 'nonce' ),
			'deletelastelement' => __( 'You must have at least one lump', 'correoswc' ),
			'plugin_images'     => $c['plugin_url'] . 'src/Infrastructure/Web/Assets/img/',
		],
		function () {
			if ( ! did_action( 'before_woocommerce_init' ) ) {
				return false;
			}
			return is_checkout();
		}
	);
};


$cowc_container['obtain_post_office_by_cp_handler'] = function() {
	return new Obtain_Post_Office_By_Cp_Handler(
		new Request_Post_Offices_By_Cp_Options(
			new Localizador_Oficinas(),
			new Cache_Post_Office_By_Cp_Options(),
			new Cache_Oficina_Data()
		)
	);
};

$cowc_container['enqueue_wecorreos_reload_payment_checkout'] = function( $c ) {

	$c['script_handler']->enqueue(
		'wecorreos-reload-payment-checkout.js',
		[ 'jquery' ],
		null,
		null,
		function () {
			if ( ! did_action( 'before_woocommerce_init' ) ) {
				return false;
			}
			return is_checkout();
		}
	);
};

$cowc_container['current_shipping_needs_select_post_office'] = function() {

	$shipping_methods = array_map(
		function ( $method ) {
			return current( explode( ':', $method ) );
		}, WC()->session->get( 'chosen_shipping_methods', [] )
	);

	$shipping_method = isset( $shipping_methods[0] ) ? $shipping_methods[0] : '';

	$select_office_methods = \apply_filters( 'wecorreos_select_office_methods', [ 'paq48office', 'paq72office' ] );
	return in_array( $shipping_method, $select_office_methods, true );
};

$cowc_container['add_free_word_on_none_shipping_cost'] = function( $method ) use ( $cowc_container ) {

	$current_method           = explode( ':', $method->id )[0];
	$correos_shipping_methods = $cowc_container['shipping_config']->ids();

	if ( ! in_array( $current_method, $correos_shipping_methods, true ) ) {
		return;
	}

	if ( $method->cost > 0 ) {
		return;
	}

	echo wp_kses_post( ': <strong>' . __( 'Free', 'woocommerce' ) . '</strong>' );
};
wp_enqueue_script( "bind-dni", plugins_url()."/correos-oficial/src/Infrastructure/Web/Assets/js/wecorreos-bind-dni.js", array( 'jquery' ), "1.0.0", true);
wp_enqueue_script( "customs-js", plugins_url()."/correos-oficial/src/Infrastructure/Web/Assets/js/wecorreos-customs.js", array( 'jquery' ), "1.0.0", true);
wp_enqueue_script( "general-js", plugins_url()."/correos-oficial/src/Infrastructure/Web/Assets/js/wecorreos-general.js", array( 'jquery' ), "1.0.0", true);
wp_enqueue_script( "clone-package-js", plugins_url()."/correos-oficial/src/Infrastructure/Web/Assets/js/clone_returns_package.js", array( 'jquery' ), "1.0.0", true);