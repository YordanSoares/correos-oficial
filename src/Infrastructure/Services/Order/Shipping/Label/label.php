<?php
/**
 * Services
 *
 * @package wooenvio/wecorreos
 */

use WooEnvio\ClientCorreos\WsPreregistro\Preregistro\Preregistro_Bulto;
use WooEnvio\ClientCorreos\WsPreregistro\Preregistro\Preregistro_Multibulto;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs\View_Customs_Handler;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs\View_Customs_Request;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs\View_Doc_Links_Request;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Label\Add_Package_Handler;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Label\Add_Package_Request;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Label\Obtain_Label_Handler;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Label\Obtain_Label_Request;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Label\Send_Tracking_Email_Handler;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Label\Send_Tracking_Email_Request;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Label\View_Label_Handler;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Label\View_Label_Request;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Label\View_Tracking_Handler;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Label\View_Tracking_Request;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns\View_Returns_Handler;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns\View_Returns_Request;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Preregistro_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Preregistro_Multibulto_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Label;
use WooEnvio\WECorreos\Domain\Model\Settings\General;
use WooEnvio\WECorreos\Domain\Services\Customs\Customs_Descriptions;
use WooEnvio\WECorreos\Domain\Services\Label\Request_Multipackage_Register;
use WooEnvio\WECorreos\Domain\Services\Label\Request_Register;
use WooEnvio\WECorreos\Domain\Services\Label\Save_Label;
use WooEnvio\WECorreos\Domain\Services\Label\Save_Multipackage_Label;
use WooEnvio\WECorreos\Domain\Services\Label\Tracking;
use WooEnvio\WECorreos\Domain\Services\Order\Order_Enable_Multipackage;
use WooEnvio\WECorreos\Domain\Services\Order\Order_Enable_Request_Declaration;
use WooEnvio\WECorreos\Domain\Services\Order\Order_Enable_Returns;
use WooEnvio\WECorreos\Domain\Services\Order\Order_Needs_Customs;
use function WooEnvio\WECorreos\Document\build_download_document_link;

$cowc_container['correos_tracking'] = function( $c ) {
	return new Tracking( $c['general_repository']);
};

$cowc_container['send_tracking_email_handler'] = function( $c ) {
	return new Send_Tracking_Email_Handler(
		$c['email_config'],
		$c['email_setting_repository'],
		$c['wecorreos_tracking_deliverer']
	);
};

$cowc_container['wecorreos_view_tracking'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$order_id = $c['request']->get( 'order_id' );

		$view_tracking_handler = new View_Tracking_Handler( $c['correos_id_repository'], $c['correos_tracking'] );

		$tracking_events = $view_tracking_handler( new View_Tracking_Request( $order_id ) );
		$content         = $c['plates']->render( 'order::tracking', compact( 'tracking_events' ) );

		return [
			'replace' => [
				'id'      => 'we-featured-header-tracking',
				'content' => $content,
			],
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};

$cowc_container['ws_production'] = function( $c ) {

	if ( isset( $c['ws_preproduccion'] ) && $c['ws_preproduccion'] ) {
		return false;
	}

	return true;
};

$cowc_container['preregistro_etiquetas'] = function( $c ) {

	$ws_production = $c['ws_production'];

	$general = $c['general_repository']->obtain();

	if ( is_null( $general ) ) {
		throw new \Exception( __( 'General Settings must be configurated', 'correoswc' ) );
	}
	return new Preregistro_Bulto( $general->soap_options(), null, $ws_production );
};


$cowc_container['request_register'] = function( $c ) {

	return new Request_Register(
		$c['preregistro_etiquetas'],
		new Preregistro_Data_Factory()
	);
};

$cowc_container['preregistro_multibulto'] = function( $c ) {

	$ws_production = $c['ws_production'];

	$general = $c['general_repository']->obtain();
	return new Preregistro_Multibulto( $general->soap_options(), null, $ws_production );
};

$cowc_container['request_multipackage_register'] = function( $c ) {
	return new Request_Multipackage_Register(
		$c['preregistro_multibulto'],
		new Preregistro_Multibulto_Data_Factory()
	);
};

$cowc_container['save_pdf_label'] = function( $c ) {
	return new Save_Label( $c['slug'] );
};

$cowc_container['save_multipackage_label'] = function( $c ) {
	return new Save_Multipackage_Label(
		$c['slug'],
		$c['merge_labels']
	);
};

$cowc_container['maybe_change_order_status'] = function( $order_id, $general_repository ) {
	$wc_order = wc_get_order( $order_id );
	$general  = $general_repository->obtain();
	$status   = $general->order_status_on_obtain_label();
	if ( General::NO_CHANGE_ORDER_STATUS === $status ) {
		return General::NO_CHANGE_ORDER_STATUS;
	}
	$wc_order->update_status( $status );
	return $status;
};

$cowc_container['wecorreos_obtain_label'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$order_id = $c['request']->get( 'order_id' );

		$order = $c['order_factory']->build( $order_id );

		$packages = call_user_func_array( $c->raw( 'decode_json_data' ), [ $c['request']->get( 'packages' ) ] );

		$request_register = $c['request_register'];
		$save_pdf         = $c['save_pdf_label'];

		if ( count( $packages ) > 1 && Order_Enable_Multipackage::on( $order ) ) {
			$request_register = $c['request_multipackage_register'];
			$save_pdf         = $c['save_multipackage_label'];
		}
//var_dump('DEBUG LABEL ENTRY_POINT', $c['request']);

		$obtain_label = new Obtain_Label_Handler(
			$c['label_repository'],
			$c['senders_repository'],
			$c['general_repository'],
			$c['correos_id_repository'],
			$c['order_factory'],
			$request_register,
			$save_pdf
		);

		$obtain_label(
			new Obtain_Label_Request(
				$packages,
				$c['request']->get( 'sender_key' ),
				$c['request']->get( 'comment' ),
				$c['request']->get( 'insurance' ),
				$c['request']->get( 'first_item_value' ),
				$c['request']->get( 'first_item_description' ),
				$order_id,
				$c['request']->get( 'customs_tariff_number' ),
				$c['request']->get( 'customs_tariff_description' ),
				$c['request']->get( 'customs_consignor_reference' ),
				$c['request']->get( 'customs_check_description_and_tariff')
			)
		);

		$obtain_correos_id = $c->raw( 'obtain_correos_id' );

		$correos_id = $obtain_correos_id( $order_id );

		$metabox_header = $c['plates']->render( 'order::header', compact( 'order', 'correos_id' ) );

		$label_download_link = build_download_document_link( $c['label_files']->download_link( $order_id ) );

		$label_header = $c['plates']->render( 'order::label-header', compact( 'label_download_link' ) );

		$sended_email = $c['send_tracking_email_handler']->send_if_enabled(
			new Send_Tracking_Email_Request(
				$order_id,
				$correos_id
			)
		);

		$label_created   = __( 'Label created, now you can download it', 'correoswc' );
		$tracking_sended = __( 'Localizaction link email sended to customer', 'correoswc' );

		$success              = $sended_email ? $label_created . '<br/>' . $tracking_sended : $label_created;
		$changed_order_status = call_user_func_array( $c->raw( 'maybe_change_order_status' ), [ $order_id, $c['general_repository'] ] );

		return [
			'success'              => $success,
			'replace'              => [
				[
					'id'      => 'wecorreos-order-metabox-header',
					'content' => $metabox_header,
				],
				[
					'id'      => 'metabox-label-form-header',
					'content' => $label_header,
				],
			],
			'changed_order_status' => $changed_order_status,
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};


$cowc_container['wecorreos_add_package'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$packages = call_user_func_array( $c->raw( 'decode_json_data' ), [ $c['request']->get( 'packages' ) ] );

		$order_id = $c['request']->get( 'order_id' );

		$order = $c['order_factory']->build( $order_id );

		$add_package_handler = new Add_Package_Handler();

		$package = $add_package_handler( new Add_Package_Request( $order, $packages ) );

		$add_package_content = $c['plates']->render( 'order::label-row-package', compact( 'package' ) );

		return [
			'add' => [
				'id'      => 'wecorreos-multipackage',
				'content' => $add_package_content,
			],
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};

$cowc_container['wecorreos_change_sender'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$order_id = $c['request']->get( 'order_id' );

		$order = $c['order_factory']->build( $order_id );

		$label_download_link = build_download_document_link( $c['label_files']->link( $order_id ));

		$obtain_correos_id = $c->raw( 'obtain_correos_id' );

		$correos_id = null === $label_download_link ? null : $obtain_correos_id( $order_id );

		$view_label = new View_Label_Handler( $c['label_repository'], $c['senders_repository'], $c['customs_repository'] );

		$label = $view_label( new View_Label_Request( $order ) );

		$label = $label->update_sender_key( $c['request']->get( 'sender_key' ));

		$senders = $c['senders_repository']->obtain();

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

		return [
			'replace' => [
				'id'      => 'wecorreos-order-metabox-all',
				'content' => $c['plates']->render(
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
				),
			],
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};
