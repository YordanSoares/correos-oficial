<?php
/**
 * Email
 *
 * @package wooenvio/wecorreos
 */

use WooEnvio\WcPlugin\Common\Email_Config;
use WooEnvio\WECorreos\Infrastructure\Repositories\WooCommerce\Email_Configuration_Repository;
use WooEnvio\WECorreos\Infrastructure\Common\Email\Wecorreos_Return_Deliverer;
use WooEnvio\WECorreos\Infrastructure\Common\Email\Wecorreos_Tracking_Deliverer;

const EMAIL_CONFIG_FOLDER   = __DIR__ . '/config';
const EMAIL_TEMPLATE_FOLDER = __DIR__ . '/template/';

$cowc_container['email_config'] = function() {
	return new Email_Config( EMAIL_CONFIG_FOLDER );
};

$cowc_container['email_setting_repository'] = function() {
	return new Email_Configuration_Repository();
};

$cowc_container['wecorreos_return_deliverer'] = function() {
	return new Wecorreos_Return_Deliverer();
};

$cowc_container['wecorreos_tracking_deliverer'] = function() {
	return new Wecorreos_Tracking_Deliverer();
};

$cowc_container['add_email_actions'] = function( $email_actions ) use ( $cowc_container ) {

	$email_actions = array_merge( $email_actions, $cowc_container['email_config']->list_class_action() );
	return $email_actions;
};

$cowc_container['add_email_classes'] = function( $email_classes ) use ( $cowc_container ) {

	$email_correos_classes = array_map(
		function( $class ) {
			return new $class();
		}, $cowc_container['email_config']->id_class_list()
	);

	$email_classes = array_merge( $email_classes, $email_correos_classes );

	return $email_classes;
};

$cowc_container['filter_locate_template'] = function( $template, $template_name, $template_path ) {
	global $woocommerce;

	$_template = $template;

	if ( ! $template_path ) {
		$template_path = $woocommerce->template_url;
	}

	$plugin_path = EMAIL_TEMPLATE_FOLDER;

	// Look within passed path within the theme - this is priority.
	$template = locate_template(
		array( $template_path . $template_name, $template_name )
	);

	// Modification: Get the template from this plugin, if it exists.
	if ( ! $template && file_exists( $plugin_path . $template_name ) ) {
		$template = $plugin_path . $template_name;
	}

	// Use default template.
	if ( ! $template ) {
		$template = $_template;
	}

	return $template;
};

$cowc_container['filter_locate_core_template'] = function( $core_file, $template ) use ( $cowc_container ) {

	$correos_email_templates = $cowc_container['email_config']->all_templates();

	if ( in_array( $template, $correos_email_templates, true ) ) {
		return EMAIL_TEMPLATE_FOLDER . $template;
	}

	return $core_file;
};
