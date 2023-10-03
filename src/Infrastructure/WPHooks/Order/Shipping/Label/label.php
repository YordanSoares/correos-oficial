<?php
/**
 * WPHooks
 *
 * @package wooenvio/wecorreos
 */

add_action( 'wp_ajax_wecorreos_view_tracking', $cowc_container->raw( 'wecorreos_view_tracking' ) );
add_action( 'wp_ajax_wecorreos_obtain_label', $cowc_container->raw( 'wecorreos_obtain_label' ) );
add_action( 'wp_ajax_wecorreos_add_package', $cowc_container->raw( 'wecorreos_add_package' ) );
add_action( 'wp_ajax_wecorreos_change_sender', $cowc_container->raw( 'wecorreos_change_sender' ) );
