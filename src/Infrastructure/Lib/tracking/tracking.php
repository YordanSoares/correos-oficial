<?php // phpcs:ignoreFile
namespace WooEnvio\ClientCorreos\Tracking;

const CORREOS_BASE_LOCATION = 'https://localizador.correos.es/canonico/eventos_envio_servicio_auth';

function fetch_tracking_by_correos_code( $user_password, $correos_code ) {
	$headers = [  
		'Authorization'  => 'Basic ' . base64_encode( $user_password['login'] . ':' . $user_password['password'] ),
		'Content-type'   => 'application/json'
	];
	$result = wp_remote_get( location( $correos_code ), [ 'headers' => $headers ] );
	$result = wp_remote_retrieve_body( $result );
	return json_decode( $result );
}

function location( $correos_code ) {
	return sprintf(
		'%s/%s?codIdioma=ES&indUltEvento=N',
		CORREOS_BASE_LOCATION,
		$correos_code
	);
}
