<?php
/**
 * WPHooks
 *
 * @package wooenvio/wecorreos
 */

if ( ! wp_doing_ajax() ) {

	add_action( 'admin_enqueue_scripts', $cowc_container->raw( 'enqueue_wecorreos_ajax_js' ) );
	add_action( 'admin_enqueue_scripts', $cowc_container->raw( 'add_change_tab_js_on_settings_page' ) );
	add_action( 'admin_enqueue_scripts', $cowc_container->raw( 'enqueue_wecorreos_form_group_element_js' ) );
	add_action( 'admin_enqueue_scripts', $cowc_container->raw( 'add_helptip_js_on_settings_page' ) );
	add_action( 'admin_enqueue_scripts', $cowc_container->raw( 'add_style_on_settings_page' ) );
	add_action( 'admin_menu', $cowc_container->raw( 'add_settings_page_link_to_woocommerce_menu' ) );

}

add_action( 'wp_ajax_wecorreos_save_general', $cowc_container->raw( 'wecorreos_save_general' ) );
add_action( 'wp_ajax_wecorreos_save_senders', $cowc_container->raw( 'wecorreos_save_senders' ) );
add_action( 'wp_ajax_wecorreos_add_sender', $cowc_container->raw( 'wecorreos_add_sender' ) );
add_action( 'wp_ajax_wecorreos_save_customs', $cowc_container->raw( 'wecorreos_save_customs' ) );
