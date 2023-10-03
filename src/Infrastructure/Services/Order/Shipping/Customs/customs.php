<?php
/**
 * Services
 *
 * @package wooenvio/wecorreos
 */

use WooEnvio\ClientCorreos\WsPreregistro\Aduanas\Documentacion_Aduanera;
use WooEnvio\WECorreos\Infrastructure\Common\Files\Customs_Ddp_Files;
use WooEnvio\WECorreos\Domain\Services\Customs\Save_Ddp;
use WooEnvio\WECorreos\Domain\Services\Customs\Request_Ddp;
use WooEnvio\WECorreos\Domain\Model\Correos\Aduanas\Ddp_Data_Factory;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs\Obtain_Customs_Ddp_Handler;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs\Obtain_Customs_Doc_Request;

use WooEnvio\WECorreos\Infrastructure\Common\Files\Customs_Dua_Files;
use WooEnvio\WECorreos\Domain\Services\Customs\Save_Dua;
use WooEnvio\WECorreos\Domain\Services\Customs\Request_Dua;
use WooEnvio\WECorreos\Domain\Model\Correos\Aduanas\Dua_Data_Factory;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs\Obtain_Customs_Dua_Handler;

use WooEnvio\WECorreos\Infrastructure\Common\Files\Customs_Declaration_Files;
use WooEnvio\WECorreos\Domain\Services\Customs\Save_Declaration_Content;
use WooEnvio\WECorreos\Domain\Services\Customs\Request_Declaration;

use WooEnvio\ClientCorreos\WsPreregistro\Aduanas\Declaracion_Contenido;
use WooEnvio\WECorreos\Domain\Model\Correos\Aduanas\Declaracion_Contenido_Data;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs\Obtain_Customs_Declaration_Handler;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs\Obtain_Customs_Declaration_Request;

use WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs\View_Doc_Links_Handler;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs\View_Doc_Links_Request;

$cowc_container['documentacion_aduanera'] = function( $c ) {
	$ws_production = $c['ws_production'];

	$general = $c['general_repository']->obtain();
	return new Documentacion_Aduanera( $general->soap_options(), null, $ws_production );
};

$cowc_container['request_ddp'] = function( $c ) {
	return new Request_Ddp(
		$c['documentacion_aduanera'],
		new Ddp_Data_Factory()
	);
};

$cowc_container['ddp_files'] = function( $c ) {
	return new Customs_Ddp_Files( $c['slug'] );
};

$cowc_container['save_ddp'] = function( $c ) {
	return new Save_Ddp( $c['ddp_files'] );
};

$cowc_container['obtain_customs_ddp_handler'] = function( $c ) {
	return new Obtain_Customs_Ddp_Handler(
		$c['general_repository'],
		$c['order_customs_repository'],
		$c['label_repository'],
		$c['senders_repository'],
		$c['request_ddp'],
		$c['save_ddp'],
		$c['order_factory']
	);
};

$cowc_container['request_dua'] = function( $c ) {
	return new Request_Dua(
		$c['documentacion_aduanera'],
		new Dua_Data_Factory()
	);
};

$cowc_container['dua_files'] = function( $c ) {
	return new Customs_Dua_Files( $c['slug'] );
};

$cowc_container['save_dua'] = function( $c ) {
	return new Save_Dua( $c['dua_files'] );
};

$cowc_container['obtain_customs_dua_handler'] = function( $c ) {
	return new Obtain_Customs_Dua_Handler(
		$c['general_repository'],
		$c['order_customs_repository'],
		$c['label_repository'],
		$c['senders_repository'],
		$c['request_dua'],
		$c['save_dua'],
		$c['order_factory']
	);
};

$cowc_container['request_declaration'] = function( $c ) {

	$ws_production = $c['ws_production'];

	$general = $c['general_repository']->obtain();

	return new Request_Declaration(
		new Declaracion_Contenido( $general->soap_options(), null, $ws_production ),
		new Declaracion_Contenido_Data()
	);
};

$cowc_container['declaration_files'] = function( $c ) {
	return new Customs_Declaration_Files( $c['slug'] );
};

$cowc_container['save_declaration'] = function( $c ) {
	return new Save_Declaration_Content( $c['declaration_files'] );
};

$cowc_container['obtain_customs_declaration_handler'] = function( $c ) {
	return new Obtain_Customs_Declaration_Handler(
		$c['correos_id_repository'],
		$c['request_declaration'],
		$c['save_declaration']
	);
};

$cowc_container['view_doc_links_handler'] = function( $c ) {
	return new View_Doc_Links_Handler(
		$c['ddp_files'],
		$c['dua_files'],
		$c['declaration_files']
	);
};

$cowc_container['wecorreos_obtain_customs_ddp'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$order_id = $c['request']->get( 'order_id' );

		$obtain_customs_ddp_handler = $c['obtain_customs_ddp_handler'];

		$obtain_customs_ddp_handler(
			new Obtain_Customs_Doc_Request(
				$c['request']->get( 'number_pieces' ),
				$order_id
			)
		);

		$view_doc_links_handler = $c['view_doc_links_handler'];

		$doc_links = $view_doc_links_handler( new View_Doc_Links_Request( $order_id ) );

		$customs_header = $c['plates']->render( 'order::customs-header', compact( 'doc_links' ) );

		return [
			'success' => __( 'Ddp created, now you can download it', 'correoswc' ),
			'replace' => [
				'id'      => 'metabox-customs-form-header',
				'content' => $customs_header,
			],
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};

$cowc_container['wecorreos_obtain_customs_dua'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$order_id = $c['request']->get( 'order_id' );

		$obtain_customs_dua_handler = $c['obtain_customs_dua_handler'];

		$obtain_customs_dua_handler(
			new Obtain_Customs_Doc_Request(
				$c['request']->get( 'number_pieces' ),
				$order_id
			)
		);

		$view_doc_links_handler = $c['view_doc_links_handler'];

		$doc_links = $view_doc_links_handler( new View_Doc_Links_Request( $order_id ) );

		$customs_header = $c['plates']->render( 'order::customs-header', compact( 'doc_links' ) );

		return [
			'success' => __( 'Dua created, now you can download it', 'correoswc' ),
			'replace' => [
				'id'      => 'metabox-customs-form-header',
				'content' => $customs_header,
			],
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};


$cowc_container['wecorreos_obtain_customs_content_declaration'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$order_id = $c['request']->get( 'order_id' );

		$obtain_customs_declaration_handler = $c['obtain_customs_declaration_handler'];

		$obtain_customs_declaration_handler(
			new Obtain_Customs_Declaration_Request(
				$c['request']->get( 'order_id' )
			)
		);

		$view_doc_links_handler = $c['view_doc_links_handler'];

		$doc_links = $view_doc_links_handler( new View_Doc_Links_Request( $order_id ) );

		$customs_header = $c['plates']->render( 'order::customs-header', compact( 'doc_links' ) );

		return [
			'success' => __( 'Declaration created, now you can download it', 'correoswc' ),
			'replace' => [
				'id'      => 'metabox-customs-form-header',
				'content' => $customs_header,
			],
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};
