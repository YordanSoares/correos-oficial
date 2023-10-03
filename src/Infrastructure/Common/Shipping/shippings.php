<?php // phpcs:ignoreFile
/**
 * Shipping
 *
 * @package wooenvio/wecorreos
 */

use WooEnvio\WcPlugin\Common\Shipping_Config;
use WooEnvio\CostRules\Products;

const SHIPPING_CONFIG_FOLDER = __DIR__ . '/config';

$cowc_container['shipping_config'] = function() {
	return new Shipping_Config( SHIPPING_CONFIG_FOLDER );
};


$cowc_container['add_shipping_methods'] = function( $methods ) use ( $cowc_container ) {

	$general = $cowc_container['general_repository']->obtain();

	$ids_enabled = null === $general ? [] : $general->enabled_shippings();

	$id_classes = $cowc_container['shipping_config']->id_class_list();

	$id_classes_enabled = array_filter(
		$id_classes, function( $id ) use ( $ids_enabled ) {

			return in_array( $id, $ids_enabled, true );

		}, ARRAY_FILTER_USE_KEY
	);

	$list = array_merge(
		$methods,
		$id_classes_enabled
	);

	return $list;
};

$cowc_container['add_payment_methods'] = function( $methods ) use ( $cowc_container ) {

	$classes = $cowc_container['payment_config']->classes();

	return array_merge(
		$methods,
		$classes
	);
};

$cowc_container['current_payment_method'] = function () {
	global $woocommerce;

	$available_payments = $woocommerce->payment_gateways->get_available_payment_gateways();

	if ( empty( $available_payments ) ) {
		return false;
	}

	if ( isset( $woocommerce->session->chosen_payment_method )
		&& isset( $available_payments[ $woocommerce->session->chosen_payment_method ] ) ) {
		return $available_payments[ $woocommerce->session->chosen_payment_method ];
	}

	if ( isset( $available_payments[ get_option( 'woocommerce_default_gateway' ) ] ) ) {
		return $available_payments[ get_option( 'woocommerce_default_gateway' ) ];
	}

	return current( $available_payments );
};

$cowc_container['payment_method_has_fees'] = function ( $payment_method ) {
	if ( false === $payment_method ) {
		return false;
	}

	if ( isset( $payment_method->settings['extra_charge'] ) && $payment_method->settings['extra_charge'] > 0 ) {
		return true;
	}

	return false;
};

$cowc_container['add_fees_to_cart'] = function() use ( $cowc_container ) {

	global $woocommerce;

	$payment_method = $cowc_container['current_payment_method'];

	if ( ! is_object( $payment_method ) ) {
		return;
	}

	if ( ! in_array( $payment_method->id, $cowc_container['payment_config']->ids(), true ) ) {
		return;
	}

	$payment_method_has_fees = $cowc_container->raw( 'payment_method_has_fees' );

	if ( ! $payment_method_has_fees( $payment_method ) ) {
		return;
	}

	$woocommerce->cart->add_fee(
		$payment_method->settings['extra_charge_display_cart_description'],
		$payment_method->settings['extra_charge']
	);
};


$cowc_container['add_style_on_settings_wc_shipping_page'] = function( $c ) {

	$c['style_handler']->enqueue(
		'wecorreos-costrules.css',
		[],
		[ 'woocommerce_page_wc-settings' ]
	);
};

$cowc_container['wecorreos_add_costrule'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$key = $c['request']->get( 'key' );

		$value = [
			'shipping_class'           => [
				$key => '0',
			],
			'condition'                => [
				$key => '0',
			],
			'min'                      => [
				$key => '0',
			],
			'max'                      => [
				$key => '0',
			],
			'cost'                     => [
				$key => '0',
			],
			'cost_per_additional_unit' => [
				$key => '0',
			],
		];

		$formName = $c['request']->get( 'form' );

		$condition_options = Products::condition_options( 'wecorreos' );

		$shipping_class_options = Products::shipping_class_options( 'wecorreos' );

		$costrule_content = $c['plates']->render(
			'costrules::row',
			compact( 'value', 'formName', 'key', 'condition_options', 'shipping_class_options' )
		);

		return [
			'add' => [
				'id'      => $c['request']->get( 'add_id' ),
				'content' => $costrule_content,
			],
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};

$cowc_container['wecorreos_obtain_empty_costrule'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$key = $c['request']->get( 'key' );

		$value = [
			'shipping_class'           => [
				$key => '0',
			],
			'condition'                => [
				$key => '0',
			],
			'min'                      => [
				$key => '0',
			],
			'max'                      => [
				$key => '0',
			],
			'cost'                     => [
				$key => '0',
			],
			'cost_per_additional_unit' => [
				$key => '0',
			],
		];

		$formName = $c['request']->get( 'form' );

		$condition_options = Products::condition_options( 'wecorreos' );

		$shipping_class_options = Products::shipping_class_options( 'wecorreos' );

		$costrule_content = $c['plates']->render(
			'costrules::row',
			compact( 'value', 'formName', 'key', 'condition_options', 'shipping_class_options' )
		);

		return [
			'add' => [
				'content' => $costrule_content,
			],
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};


$cowc_container['enqueue_wecorreos_costrules_csv_js'] = function( $c ) {

	$c['script_handler']->enqueue(
		'jquery.csv.min.js',
		[ 'jquery' ],
		null,
		null,
		[ 'woocommerce_page_wc-settings' ]
	);

	$c['script_handler']->enqueue(
		'wecorreos-costrules-csv.js',
		[ 'jquery', 'jquery-blockui' ],
		'costrulescsv_settings',
		[
			'message_updated_rules_imported' => __( 'Rules imported.', 'correoswc' ),
			'message_error_bad_format'       => __( 'Bad file. Check format file.', 'correoswc' ),
			'message_error_not_read_file'    => __( 'No read file.', 'correoswc' ),
			'message_error_select_file'      => __( 'Please select a file', 'correoswc' ),
		],
		[ 'woocommerce_page_wc-settings' ]
	);
};
