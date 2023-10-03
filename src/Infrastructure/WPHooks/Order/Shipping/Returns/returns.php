<?php
/**
 * WPHooks
 *
 * @package wooenvio/wecorreos
 */

add_action( 'wp_ajax_wecorreos_obtain_returns', $cowc_container->raw( 'wecorreos_obtain_returns' ) );
add_action( 'wp_ajax_wecorreos_change_recipient', $cowc_container->raw( 'wecorreos_change_recipient' ) );
