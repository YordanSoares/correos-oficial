<?php // phpcs:disable
/**
 * WPHooks
 *
 * @package wooenvio/wecorreos
 */

require_once __DIR__ . '/Label/label.php';
require_once __DIR__ . '/Customs/customs.php';
require_once __DIR__ . '/Returns/returns.php';

if ( ! wp_doing_ajax() ) {

	add_action( 'admin_enqueue_scripts', $cowc_container->raw( 'enqueue_wecorreos_costrules_csv_js' ) );
	add_action( 'admin_enqueue_scripts', $cowc_container->raw( 'add_style_on_settings_wc_shipping_page' ) );
	add_action( 'add_meta_boxes', $cowc_container->raw( 'add_shipping_meta_box' ) );
}

add_filter( 'woocommerce_shipping_methods', $cowc_container->raw( 'add_shipping_methods' ) );
add_filter( 'woocommerce_payment_gateways', $cowc_container->raw( 'add_payment_methods' ) );
add_action( 'woocommerce_cart_calculate_fees', $cowc_container->raw( 'add_fees_to_cart' ) );

add_filter( 'woocommerce_email_actions', $cowc_container->raw( 'add_email_actions' ) );
add_filter( 'woocommerce_email_classes', $cowc_container->raw( 'add_email_classes' ) );
add_filter( 'woocommerce_locate_template', $cowc_container->raw( 'filter_locate_template' ), 10, 3 );
add_filter( 'woocommerce_locate_core_template', $cowc_container->raw( 'filter_locate_core_template' ), 10, 2 );


add_action( 'wp_ajax_wecorreos_add_costrule', $cowc_container->raw( 'wecorreos_add_costrule' ) );
add_action( 'wp_ajax_wecorreos_obtain_empty_costrule', $cowc_container->raw( 'wecorreos_obtain_empty_costrule' ) );
add_action( 'wp_ajax_wecorreos_force_correos_shipping', $cowc_container->raw( 'wecorreos_force_correos_shipping' ) );
add_action( 'wp_ajax_wecorreos_display_select_office_form', $cowc_container->raw( 'wecorreos_display_select_office_form' ) );
add_action( 'wp_ajax_wecorreos_display_select_citypaq_form', $cowc_container->raw( 'wecorreos_display_select_citypaq_form' ) );


