<?php //phpcs:ignoreFile
/**
 * Services
 *
 * @package wooenvio/wecorreos
 */

use WooEnvio\WECorreos\Domain\Services\Bulk\Merge_Labels;
use WooEnvio\WECorreos\Infrastructure\Common\Pdf\MergePdfs;
use WooEnvio\WECorreos\Application\Services\Bulk\Obtain_Merged_On_Labeler_Format_Handler;
use WooEnvio\WECorreos\Application\Services\Bulk\Obtain_Merged_On_Labeler_Format_Request;
use WooEnvio\WECorreos\Application\Services\Bulk\Obtain_Merged_On_A4_Format_Handler;
use WooEnvio\WECorreos\Application\Services\Bulk\Obtain_Merged_On_A4_Format_Request;
use WooEnvio\WECorreos\Application\Services\Bulk\Obtain_Manifiest_Handler;
use WooEnvio\WECorreos\Application\Services\Bulk\Obtain_Manifiest_Request;
use WooEnvio\WECorreos\Infrastructure\Common\Pdf\TablePdf;
use WooEnvio\WECorreos\Infrastructure\Common\Files\Manifiest_Files;
use WooEnvio\WECorreos\Domain\Services\Bulk\Manifiest;
use function WooEnvio\WECorreos\Document\build_download_document_link;

$cowc_container['manifiest'] = function( $c ) {
	return new Manifiest(
		new TablePdf(),
		$c['order_factory'],
		$c['label_repository'],
		$c['correos_id_repository'],
		$c['senders_repository'],
		$c['general_repository'],
		$c['shipping_config'],
		new Manifiest_Files( $c['slug'] )
	);
};

$cowc_container['display_modal_wecorreos_select_position_on_a4'] = function( $c ) {

	$screen = get_current_screen();
	if ( 'edit-shop_order' !== $screen->id ) {
		return;
	}

	$path_img = $c['images_url'];

	echo $c['plates']->render( 'bulkmodal::form-select-position-on-a4', compact( 'path_img' ) );
};

$cowc_container['add_style_on_order_list_page'] = function( $c ) {

	$c['style_handler']->enqueue(
		'wecorreos-order-bulk.css',
		[],
		[ 'edit-shop_order' ]
	);
};

$cowc_container['enqueue_wecorreos_order_bulk_actions_on_order_list_page'] = function( $c ) {

	$c['script_handler']->enqueue(
		'wecorreos-order-bulk-actions.js',
		[ 'jquery', 'jquery-blockui' ],
		'data_settings_bulk',
		[
			'bulk_actions'         => [
				$c['plates']->render( 'bulkactions::print-on-a4' ),
				$c['plates']->render( 'bulkactions::print-on-labeler' ),
				$c['plates']->render( 'bulkactions::print-manifiest' ),
			],
			'msg_updating'         => __( 'Updating', 'correoswc' ),
			'msg_select_one_order' => __( 'Select at least one order', 'correoswc' ),
		],
		[ 'edit-shop_order' ]
	);

	add_thickbox();
};

$cowc_container['enqueue_wecorreos_ajax_js_on_order_list_page'] = function( $c ) {

	$c['script_handler']->enqueue(
		'wecorreos-ajax.js',
		[ 'jquery', 'jquery-blockui' ],
		'ajax_object',
		[
			'ajax_url'          => admin_url( 'admin-ajax.php' ),
			'nonce'             => wp_create_nonce( 'nonce' ),
			'deletelastelement' => __( 'You must have at least one lump', 'correoswc' ),
		],
		[ 'edit-shop_order' ]
	);
};

$cowc_container['selected_order_ids'] = function( $c ) {
	$order_ids = $c['request']->get( 'order_ids' );

	return empty( $order_ids ) ? [] : json_decode( str_replace( '\\', '', $order_ids ) );
};


$cowc_container['merge_labels'] = function( $c ) {
	return new Merge_Labels(
		new MergePdfs(),
		$c['label_files'],
		$c['merged_label_files']
	);
};

$cowc_container['obtain_merged_on_labeler_format_handler'] = function( $c ) {

	return new Obtain_Merged_On_Labeler_Format_Handler(
		$c['merge_labels'],
		$c['label_files'],
		$c['order_factory'],
		$c['shipping_config']
	);
};

$cowc_container['obtain_merged_on_a4_format_handler'] = function( $c ) {

	return new Obtain_Merged_On_A4_Format_Handler(
		$c['merge_labels'],
		$c['label_files'],
		$c['order_factory'],
		$c['shipping_config']
	);
};

$cowc_container['filter_woocommerce_order_number'] = function( $order_ids ) {

	if ( empty( $order_ids ) ) {
		return [];
	}

	return array_map(
		function ( $order_id ) {
			return (string) apply_filters( 'woocommerce_order_number', $order_id, wc_get_order( $order_id ) );
		}, $order_ids
	);
};


$cowc_container['return_merged_messages'] = function( $merged_info ) use ( $cowc_container ) {
	$filter = $cowc_container->raw( 'filter_woocommerce_order_number' );

	$merged        = $filter( $merged_info->merged() );
	$not_merged    = $filter( $merged_info->not_merged() );
	$not_correos   = $filter( $merged_info->not_correos() );
	$download_link = build_download_document_link( $merged_info->merged_download_link() );

	$success = $merged_info->exists_merged() ? [ 'success' => $cowc_container['plates']->render( 'bulkmessages::merged-success', compact( 'merged', 'download_link' ) ) ] : [];
	$warning = $merged_info->exists_not_merged() ? [ 'warning' => $cowc_container['plates']->render( 'bulkmessages::merged-warning', compact( 'not_merged' ) ) ] : [];
	$error   = $merged_info->exists_not_correos() ? [ 'error' => $cowc_container['plates']->render( 'bulkmessages::merged-error', compact( 'not_correos' ) ) ] : [];

	return $success + $error + $warning;
};

$cowc_container['print_on_labeler_bulk'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$obtain_merged_on_labeler_format_handler = $c['obtain_merged_on_labeler_format_handler'];

		$merged_info = $obtain_merged_on_labeler_format_handler(
			new Obtain_Merged_On_Labeler_Format_Request( $c['selected_order_ids'] )
		);

		$return_merged_messages = $c->raw( 'return_merged_messages' );

		return $return_merged_messages( $merged_info );
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};

$cowc_container['print_on_a4_bulk'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$obtain_merged_on_a4_format_handler = $c['obtain_merged_on_a4_format_handler'];

		$merged_info = $obtain_merged_on_a4_format_handler(
			new Obtain_Merged_On_A4_Format_Request(
				$c['selected_order_ids'],
				$c['request']->get( 'position' )
			)
		);

		$return_merged_messages = $c->raw( 'return_merged_messages' );

		return $return_merged_messages( $merged_info );
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};

$cowc_container['print_manifiest_bulk'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$obtain_manifiest_handler = new Obtain_Manifiest_Handler(
			$c['manifiest'],
			$c['label_files'],
			$c['order_factory'],
			$c['shipping_config']
		);

		$merged_info = $obtain_manifiest_handler(
			new Obtain_Manifiest_Request( $c['selected_order_ids'] )
		);

		$return_merged_messages = $c->raw( 'return_merged_messages' );

		return $return_merged_messages( $merged_info );
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};
