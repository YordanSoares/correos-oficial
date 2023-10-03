<?php // phpcs:ignoreFile
/**
 * Services
 *
 * @package wooenvio/wecorreos
 */

require_once __DIR__ . '/Label/label.php';
require_once __DIR__ . '/Customs/customs.php';
require_once __DIR__ . '/Returns/returns.php';

use WooEnvio\WECorreos\Domain\Services\Order\Order_Enable_Returns;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Label\View_Label_Handler;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Label\View_Label_Request;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs\View_Customs_Handler;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs\View_Customs_Request;
use WooEnvio\WECorreos\Domain\Services\Order\Order_Needs_Customs;
use WooEnvio\WECorreos\Domain\Services\Order\Order_Available_Shippings;
use WooEnvio\WECorreos\Domain\Services\Customs\Customs_Descriptions;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs\View_Doc_Links_Request;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns\View_Returns_Handler;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns\View_Returns_Request;
use WooEnvio\WECorreos\Domain\Services\Order\Order_Enable_Multipackage;
use WooEnvio\WECorreos\Domain\Services\Order\Order_Enable_Request_Declaration;
use WooEnvio\WECorreos\Application\Services\Front\Obtain_Post_Office_By_Cp_Request;
use WooEnvio\WECorreos\Domain\Services\Order\Force_Order_Shipping;
use function WooEnvio\WECorreos\Citypaq\Options\citypaq_options_by_cp;
use function WooEnvio\WECorreos\Citypaq\States\states_with_citypaqs_options;
use function WooEnvio\WECorreos\Document\build_download_document_link;
use const WooEnvio\WECorreos\Citypaq\Options\NONE_CITY_PAQ_SELECTED;
use const WooEnvio\WECorreos\Postoffice\Options\NONE_POSTOFFICE_SELECTED;

$cowc_container['check_order_creating_new_order'] = function( $c ) {
	$order_id = $c['request']->get( 'post' );

	$order = $c['order_factory']->build( $order_id );

	return is_null( $order );
};

$cowc_container['check_is_order_with_correos_shipping'] = function( $c ) {
	$order_id = $c['request']->get( 'post' );

	if ( null === $order_id ) {
		return false;
	}

	$order = $c['order_factory']->build( $order_id );

	if ( null === $order ) {
		return false;
	}

	if ( null === $order->shipping_name() ) {
		return false;
	}

	return true;
};

$cowc_container['add_shipping_meta_box'] = function( $c ) {

	if ( $c['check_is_order_with_correos_shipping'] ) {
		$view_shipping_metabox = $c->raw( 'view_shipping_metabox' );
	} else {
		$view_shipping_metabox = $c->raw( 'view_shipping_metabox_empty' );
	}

	if ( $c['check_order_creating_new_order'] ) {
		$view_shipping_metabox = $c->raw( 'view_shipping_metabox_creating_order' );
	}

	add_meta_box(
		'wecorreos-order-metabox',
		__( 'Correos Shipping', 'correoswc' ),
		$view_shipping_metabox,
		'shop_order',
		'side',
		'default'
	);
};

$cowc_container['view_shipping_metabox'] = function( $c ) {

	$view_clousure = function() use ( $c ) {

		$senders = $c['senders_repository']->obtain();

		if ( is_null( $senders ) ) {
			echo $c['plates']->render( 'error-config-plugin' );
			return;
		}

		$order_id = $c['request']->get( 'post' );

		$order = $c['order_factory']->build( $order_id );

		$label_download_link = build_download_document_link( $c['label_files']->link( $order_id ));

		$obtain_correos_id = $c->raw( 'obtain_correos_id' );

		$correos_id = null === $label_download_link ? null : $obtain_correos_id( $order_id );

		$view_label = new View_Label_Handler( $c['label_repository'], $c['senders_repository'], $c['customs_repository'] );

		$label = $view_label( new View_Label_Request( $order ) );

		$sender_list = $senders->sender_list()->senders_key_alias();

		$order_needs_customs = Order_Needs_Customs::build( $senders->sender_by_key( $label->sender_key() ) );

		$display_customs = $order_needs_customs->execute( $order );

		$description_customs_options = Customs_Descriptions::options();

		$view_customs = new View_Customs_Handler( $c['order_customs_repository'] );

		$customs = $display_customs ? $view_customs( new View_Customs_Request( $order_id ) ) : null;

		$display_returns = ( new Order_Enable_Returns() )->on( $order );

		$view_returns = new View_Returns_Handler(
			$c['returns_repository'],
			$c['returns_factory']
		);

		$returns = $display_returns ? $view_returns( new View_Returns_Request( $order ) ) : null;

		$returns_download_link = $display_returns ? $c['returns_files']->link( $order_id ) : null;

		$returns_id = null === $returns_download_link ? null : $c['returns_id_repository']->obtain( $order_id );

		$view_doc_links_handler = $c['view_doc_links_handler'];

		$doc_links = $view_doc_links_handler( new View_Doc_Links_Request( $order_id ) );

		$states_options = WC()->countries->get_states( 'ES' );

		$logo = $c['images_url'] . '/' . $order->shipping_method_id() . '.png';

		$display_multipackage = Order_Enable_Multipackage::on( $order );

		$display_request_declaration = Order_Enable_Request_Declaration::on( $order );

		echo $c['plates']->render(
			'order::metabox', compact(
				'order',
				'label',
				'customs',
				'returns',
				'correos_id',
				'label_download_link',
				'sender_list',
				'description_customs_options',
				'doc_links',
				'returns_download_link',
				'returns_id',
				'states_options',
				'logo',
				'display_multipackage',
				'display_request_declaration'
			)
		);
	};
	call_user_func_array( $c->raw( 'view_error_wrapper' ), [ $view_clousure ] );
};

$cowc_container['view_shipping_metabox_empty'] = function( $c ) {

	$view_clousure = function() use ( $c ) {

		$senders = $c['senders_repository']->obtain();

		if ( is_null( $senders ) ) {
			echo $c['plates']->render( 'error-config-plugin' );
			return;
		}
		$order_id = $c['request']->get( 'post' );
		$order    = $c['order_factory']->build( $order_id );
		$view_label                = new View_Label_Handler( $c['label_repository'], $c['senders_repository'], $c['customs_repository'] );
		$label                     = $view_label( new View_Label_Request( $order ) );
		$sender                    = $senders->sender_by_key( $label->sender_key() );
		$order_available_shippings = Order_Available_Shippings::build( $sender, $c['shipping_config'] );

		$correos_shippings = $order_available_shippings->execute( $order );

		if ( is_null( $correos_shippings ) ) {
			echo $c['plates']->render( 'order::metabox-no-address-order' );
			return;
		}
		echo $c['plates']->render( 'order::metabox-empty', compact( 'correos_shippings', 'order_id' ) );
	};
	call_user_func_array( $c->raw( 'view_error_wrapper' ), [ $view_clousure ] );
};

$cowc_container['view_shipping_metabox_creating_order'] = function( $c ) {

	$view_clousure = function() use ( $c ) {
		echo $c['plates']->render( 'order::metabox-creating-order' );
	};
	call_user_func_array( $c->raw( 'view_error_wrapper' ), [ $view_clousure ] );
};

$cowc_container['wecorreos_force_correos_shipping'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$selected_office  = $c['request']->get( 'selected_office', NONE_POSTOFFICE_SELECTED );
		$selected_citypaq = $c['request']->get( 'selected_citypaq', NONE_CITY_PAQ_SELECTED );
		$correos_type     = $c['request']->get( 'correos_type' );
		$order_id         = $c['request']->get( 'order_id' );
		$order            = $c['order_factory']->build( $order_id );
		$wc_order         = $order->wc_order();

		$force_order_shipping = new Force_Order_Shipping( $c['selected_office_repository'] );
		$force_order_shipping->change_to(
			$wc_order, $correos_type, compact(
				'correos_type', 'selected_office', 'selected_citypaq'
			)
		);

		return [ 'reload' => true ];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};

$cowc_container['wecorreos_display_select_office_form'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$correos_type = $c['request']->get( 'correos_type' );

		$order_id = $c['request']->get( 'order_id' );
		$order    = $c['order_factory']->build( $order_id );

		$postalcode = $order->wc_order()->get_shipping_postcode();

		$obtain_post_office_by_cp = $c['obtain_post_office_by_cp_handler'];
		$postoffices              = $obtain_post_office_by_cp( new Obtain_Post_Office_By_Cp_Request( $postalcode ) );

		$form = $c['plates']->render(
			'order::metabox-office', compact(
				'postoffices', 'postalcode', 'correos_type', 'order_id'
			)
		);

		return [
			'replace' => [
				'id'      => 'metabox-select-extra',
				'content' => $form,
			],
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};

$cowc_container['wecorreos_display_select_citypaq_form'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$correos_type = $c['request']->get( 'correos_type' );

		$order_id = $c['request']->get( 'order_id' );
		$order    = $c['order_factory']->build( $order_id );

		$postalcode     = $order->wc_order()->get_shipping_postcode();
		$citypaqs       = citypaq_options_by_cp( $postalcode);
		$states_options = states_with_citypaqs_options();

		$form = $c['plates']->render(
			'order::metabox-citypaq', compact(
				'citypaqs', 'postalcode', 'correos_type', 'order_id', 'states_options'
			)
		);

		return [
			'replace' => [
				'id'      => 'metabox-select-extra',
				'content' => $form,
			],
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};
