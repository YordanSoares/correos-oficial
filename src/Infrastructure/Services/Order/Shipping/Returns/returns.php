<?php
/**
 * Services
 *
 * @package wooenvio/wecorreos
 */

use WooEnvio\WECorreos\Infrastructure\Common\Files\Returns_Files;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns\Returns_Factory;
use WooEnvio\WECorreos\Infrastructure\Repositories\WooCommerce\Bank_Account_Repository;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Returns_Data_Factory;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns\Obtain_Returns_Handler;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns\Obtain_Returns_Request;
use WooEnvio\WECorreos\Domain\Services\Returns\Request_Register_Returns;
use WooEnvio\WECorreos\Domain\Services\Returns\Save_Returns;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns\Obtain_Returns_Recipient_From_Sender_Handler;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns\Obtain_Returns_Recipient_From_Sender_Request;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns\Send_Returns_Email_Handler;
use WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns\Send_Returns_Email_Request;
use function WooEnvio\WECorreos\Document\build_download_document_link;

use WooEnvio\WECorreos\Domain\Services\Label\Request_Multipackage_Register;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Preregistro_Multibulto_Data_Factory;

use WooEnvio\Wefpdf\FPDI;;
use WooEnvio\Wefpdf\FPDF;

$cowc_container['returns_files'] = function( $c ) {
	return new Returns_Files( $c['slug'] );
};

$cowc_container['save_returns'] = function( $c ) {
	return new Save_Returns( $c['returns_files'] );
};

$cowc_container['returns_factory'] = function( $c ) {
	return new Returns_Factory(
		$c['senders_repository'],
		new Bank_Account_Repository()
	);
};

$cowc_container['request_register_returns'] = function( $c ) {
	return new Request_Register_Returns(
		$c['preregistro_etiquetas'],
		new Returns_Data_Factory()
	);
};

$cowc_container['preregistro_multibulto_return'] = function( $c ) {

 	$ws_production = $c['ws_production'];

 	$general = $c['general_repository']->obtain();
 	return new Preregistro_Multibulto( $general->soap_options(), null, $ws_production );
};

$cowc_container['request_multipackage_register_return'] = function( $c ) {
	return new Request_Multipackage_Register(
		$c['preregistro_multibulto'],
		new Preregistro_Multibulto_Data_Factory()
	);
};

$cowc_container['obtain_returns_handler'] = function( $c ) {
	return new Obtain_Returns_Handler(
		$c['returns_repository'],
		$c['label_repository'],
		$c['general_repository'],
		$c['returns_id_repository'],
		$c['order_factory'],
		$c['request_register_returns'],
		$c['save_returns']
	);
};

$cowc_container['send_returns_email_handler'] = function( $c ) {
	return new Send_Returns_Email_Handler(
		$c['email_config'],
		$c['email_setting_repository'],
		$c['wecorreos_return_deliverer']
	);
};

$cowc_container['wecorreos_obtain_returns'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$request = $c['request'];

		$packages = call_user_func_array( $c->raw( 'decode_json_data' ), [ $c['request']->get( 'packages' ) ] );
//var_dump('DEBUG ENTRY POINT PACKAGES', $packages);
		$order_id = $request->get( 'order_id' );

		$obtain_returns_handler = $c['obtain_returns_handler'];

		if ( count( $packages ) > 1 /*&& Order_Enable_Multipackage::on( $order ) */) {
			$request_register = $c['request_multipackage_register'];
			$save_pdf         = $c['save_multipackage_label'];
		}

		// Se borran los ficheros de retorno que serán creados más adelante.
		$base_url = wp_upload_dir()['basedir'] . '/wecorreos/';

		foreach (glob($base_url."*wecorreos-return-".$order_id."*.pdf") as $f) {
			unlink($f);
		}

		$n=0;
		
		/**
		 * Informa al ws por cada bulto y genera las etiquetas de devolución
		 */
        foreach ($packages as $package) {
			//var_dump('DEBUG PACKAGES_FOR', $package);

            $return_id= new Obtain_Returns_Handler(
                $c['returns_repository'],
                $c['label_repository'],
                $c['general_repository'],
                $c['returns_id_repository'],
                $c['order_factory'],
                $request_register,
                $save_pdf
            );

            //var_dump('DEBUG RETURNS ENTRY_POINT', $c['request']);

            $returns_id = $obtain_returns_handler(
                new Obtain_Returns_Request(
                    $order_id,
                    $request->get('sender_first_name'),
                    $request->get('sender_last_name'),
                    $request->get('sender_dni'),
                    $request->get('sender_company'),
                    $request->get('sender_contact'),
                    $request->get('sender_address'),
                    $request->get('sender_city'),
                    $request->get('sender_state'),
                    $request->get('sender_cp'),
                    $request->get('sender_phone'),
                    $request->get('sender_email'),
                    $request->get('recipient_key'),
                    $request->get('recipient_first_name'),
                    $request->get('recipient_last_name'),
                    $request->get('recipient_dni'),
                    $request->get('recipient_company'),
                    $request->get('recipient_contact'),
                    $request->get('recipient_address'),
                    $request->get('recipient_city'),
                    $request->get('recipient_state'),
                    $request->get('recipient_cp'),
                    $request->get('recipient_phone'),
                    $request->get('recipient_email'),
                    $request->get('return_cost'),
                    $request->get('return_ccc'),
                    array($packages[$n])
                )
            );
			$n++;
        }

		/**
		 * Merge de las etiquetas de devolución en una sola.
		 */
		$files=array();
		foreach (glob($base_url."*wecorreos-return-".$order_id."*.pdf") as $f) {
			$files[]=$f;
		}

		$pdf = new FPDI();
		
		// iterate over array of files and merge
		foreach ($files as $file) {
			$pageCount = $pdf->setSourceFile($file);
			for ($i = 0; $i < $pageCount; $i++) {
				$tpl = $pdf->importPage($i + 1, '/MediaBox');
				$pdf->addPage();
				$pdf->useTemplate($tpl);
			}
		}
		
		$pdf->Output('F',$base_url."wecorreos-return-".$order_id.".pdf");
		// fin merge	

		$send_returns_email_handler = $c['send_returns_email_handler'];

		$sended_email = $send_returns_email_handler->send_if_enabled(
			new Send_Returns_Email_Request(
				$order_id,
				$returns_id
			)
		);

		$returns_created = __( 'Returns created, now you can download it', 'correoswc' );
		$returns_sended  = __( 'Returns instructions email sended to customer', 'correoswc' );

		$success = $sended_email ? $returns_created . '<br/>' . $returns_sended : $returns_created;

		$returns_download_link = build_download_document_link( $c['returns_files']->link( $order_id ) );
		//var_dump('DEBUG RETURNS_DOWNLOAD_LINK', $returns_download_link);
		
		// Se quita el id de devolución L3 porque ahora devuelve varios bultos, y devolvía 1.
		//$content = $c['plates']->render( 'order::returns-header', compact( 'returns_id', 'returns_download_link' ) );
		$content = $c['plates']->render( 'order::returns-header', compact('returns_download_link' ) );

		return [
			'success' => $success,
			'replace' => [
				'id'      => 'metabox-returns-form-header',
				'content' => $content,
			],
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};

$cowc_container['wecorreos_change_recipient'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$obtain_returns_recipient = new Obtain_Returns_Recipient_From_Sender_Handler( $c['senders_repository'] );

		$returns_recipient = $obtain_returns_recipient( new Obtain_Returns_Recipient_From_Sender_Request( $c['request']->get( 'recipient_key' ) ) );

		return [
			'success'   => __( 'Recipient changed', 'correoswc' ),
			'sanitized' => $returns_recipient->data(),
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};
