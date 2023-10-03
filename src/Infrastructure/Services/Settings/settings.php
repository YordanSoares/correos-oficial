<?php // phpcs:ignoreFile
/**
 * Services
 *
 * @package wooenvio/wecorreos
 */

require_once __DIR__ . '/General/general.php';
require_once __DIR__ . '/Senders/senders.php';
require_once __DIR__ . '/Customs/customs.php';

use WooEnvio\WECorreos\Application\Services\Settings\Customs\View_Customs_Handler;
use WooEnvio\WECorreos\Application\Services\Settings\General\View_General_Handle;
use WooEnvio\WECorreos\Application\Services\Settings\Senders\View_Senders_Handler;
use WooEnvio\WECorreos\Domain\Model\Settings\General;
use WooEnvio\WECorreos\Domain\Services\Customs\Customs_Descriptions;
use WooEnvio\WECorreos\Domain\Services\Customs\Tariff_Number;
use function WooEnvio\WECorreos\Shared\CountrySender\country_options;
use function WooEnvio\WECorreos\Shared\CountrySender\state_options;
use function WooEnvio\WECorreos\Welcome\action;
use function WooEnvio\WECorreos\Welcome\already_correos_user_url;
use function WooEnvio\WECorreos\Welcome\build_email_error_message;
use function WooEnvio\WECorreos\Welcome\build_email_sended_message;
use function WooEnvio\WECorreos\Welcome\check_display_welcome;
use function WooEnvio\WECorreos\Welcome\nonce;
use function WooEnvio\WECorreos\Welcome\send_correos_user_email_request_action;

$cowc_container['suffix_settings_page'] = $cowc_container['slug'] . '_settings';

$cowc_container['enqueue_wecorreos_ajax_js'] = function( $c ) {

	$c['script_handler']->enqueue(
		'wecorreos-ajax.js',
		[ 'jquery', 'jquery-blockui' ],
		'ajax_object',
		[
			'ajax_url'          => admin_url( 'admin-ajax.php' ),
			'nonce'             => wp_create_nonce( 'nonce' ),
			'deletelastelement' => __( 'You must have at least one lump', 'correoswc' ),
		],
		[ 'woocommerce_page_' . $c['suffix_settings_page'], 'toplevel_page_wecorreos_settings', 'shop_order', 'woocommerce_page_wc-settings' ]
	);
};

$cowc_container['add_change_tab_js_on_settings_page'] = function( $c ) {

	$c['script_handler']->enqueue(
		'wecorreos-change-tab.js',
		[ 'jquery' ],
		'change_settings',
		[
			'wrapper' => 'wecorreos-settings',
		],
		[ 'woocommerce_page_' . $c['suffix_settings_page'], 'toplevel_page_wecorreos_settings' ]
	);
};

$cowc_container['enqueue_wecorreos_form_group_element_js'] = function( $c ) {

	$c['script_handler']->enqueue(
		'wecorreos-form-group-element.js',
		[ 'jquery-tiptip' ],
		'data_settings',
		[
			'msg_select_one_record'     => __( 'Select at least one record', 'correoswc' ),
			'msg_not_delete_all_record' => __( 'Leave at least one record', 'correoswc' ),
		],
		[ 'woocommerce_page_' . $c['suffix_settings_page'], 'toplevel_page_wecorreos_settings', 'woocommerce_page_wc-settings' ]
	);
};

$cowc_container['add_helptip_js_on_settings_page'] = function( $c ) {

	$c['script_handler']->enqueue(
		'wecorreos-helptips.js',
		[ 'jquery' ],
		null,
		null,
		[ 'woocommerce_page_' . $c['suffix_settings_page'], 'toplevel_page_wecorreos_settings' ]
	);
};

$cowc_container['add_style_on_settings_page'] = function( $c ) {

	$c['style_handler']->enqueue(
		'wecorreos-settings.css',
		[],
		[ 'woocommerce_page_' . $c['suffix_settings_page'], 'toplevel_page_wecorreos_settings' ]
	);
};

$cowc_container['add_settings_page_link_to_woocommerce_menu'] = function( $c ) {
	add_menu_page(
		__( 'Correos', 'correoswc' ),
		__( 'Correos', 'correoswc' ),
		'manage_woocommerce',
		$c['suffix_settings_page'],
		$c->raw( 'view_settings_page' ),
		$c['plugin_url'] . 'src/Infrastructure/Web/Assets/img/correos-icon.png'
	);
};

$cowc_container['view_settings_page'] = function( $c ) {

	$view_clousure = function() use ( $c ) {

		if ( check_display_welcome() ) {
			$admin_url                           = \admin_url( 'admin.php' );
			$already_correos_user_url            = already_correos_user_url();
			$send_correos_user_email_action_type = send_correos_user_email_request_action();
			$action                              = action();
			$nonce                               = nonce();
			$error_message                       = isset( $_REQUEST['email_error']) ? build_email_error_message() : '';
			error_log( '$_REQUEST: ' . print_r($_REQUEST, true) );
			echo $c['plates']->render( 'welcome::welcome-form', compact(
				'admin_url',
				'already_correos_user_url',
				'action',
				'send_correos_user_email_action_type',
				'nonce',
				'error_message'
			));
			return;
		}

		$message      = isset( $_REQUEST['message']) && 'sended_email' === $_REQUEST['message'] ? build_email_sended_message() : '';
		$view_general = new View_General_Handle( $c['general_repository'] );
		$general      = $view_general();
		$view_senders = new View_Senders_Handler( $c['senders_repository'] );
		$senders      = $view_senders();
		$view_customs = new View_Customs_Handler( $c['customs_repository'] );
		$customs      = $view_customs();

		$description_customs_options = Customs_Descriptions::options();
		$tariff_number_options       = Tariff_Number::options();
		$states_options              = state_options( 'ES', true );
		$country_options             = country_options();
		$images_url                  = $c['images_url'];
		$order_statuses              = General::availables_order_statuses();

		echo $c['plates']->render(
			'settings::page',
			compact( 'message', 'general', 'senders', 'customs', 'description_customs_options', 'tariff_number_options', 'states_options', 'images_url', 'order_statuses', 'country_options')
		);
	};
	call_user_func_array( $c->raw( 'view_error_wrapper' ), [ $view_clousure ] );
};
