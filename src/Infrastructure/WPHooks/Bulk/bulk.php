<?php
/**
 * WPHooks
 *
 * @package wooenvio/wecorreos
 */

if ( ! wp_doing_ajax() ) {
	add_action( 'admin_enqueue_scripts', $cowc_container->raw( 'enqueue_wecorreos_order_bulk_actions_on_order_list_page' ) );
	add_action( 'admin_enqueue_scripts', $cowc_container->raw( 'enqueue_wecorreos_ajax_js_on_order_list_page' ) );
	add_action( 'admin_enqueue_scripts', $cowc_container->raw( 'add_style_on_order_list_page' ) );
}

add_action( 'wp_ajax_wecorreos_print_on_labeler', $cowc_container->raw( 'print_on_labeler_bulk' ) );
add_action( 'wp_ajax_wecorreos_print_on_a4', $cowc_container->raw( 'print_on_a4_bulk' ) );
add_action( 'wp_ajax_wecorreos_print_manifiest', $cowc_container->raw( 'print_manifiest_bulk' ) );
add_action( 'admin_footer-edit.php', $cowc_container->raw( 'display_modal_wecorreos_select_position_on_a4' ) );
