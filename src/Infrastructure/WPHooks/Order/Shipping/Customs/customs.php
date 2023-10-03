<?php
/**
 * WPHooks
 *
 * @package wooenvio/wecorreos
 */

add_action( 'wp_ajax_wecorreos_obtain_customs_dua', $cowc_container->raw( 'wecorreos_obtain_customs_dua' ) );
add_action( 'wp_ajax_wecorreos_obtain_customs_ddp', $cowc_container->raw( 'wecorreos_obtain_customs_ddp' ) );
add_action( 'wp_ajax_wecorreos_obtain_customs_content_declaration', $cowc_container->raw( 'wecorreos_obtain_customs_content_declaration' ) );
