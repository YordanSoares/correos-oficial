<?php // phpcs:ignoreFile
namespace WooEnvio\ClientCorreos\WsPreregistro\Preregistro;

use WooEnvio\ClientCorreos\Soap_Correos;

class Preregistro_Bulto {

	const FUNCTION_PREREGISTRO = 'PreRegistro';

	const PRODUCTION_WSDL = __DIR__ . '/../preregistro.wsdl';

	const PRE_WSDL = __DIR__ . '/../preregistro-pre.wsdl';

	const RESPONSE_WITH_ERROR = 1;

	private $client;

	public function __construct( $options = [], $client = null, $production = true, $cache_wsdl = true ) {

		$this->check_empty_user_password( $options );

		if ( defined( 'WS_CORREOS_PREPRODUCCION' ) && WS_CORREOS_PREPRODUCCION ) {
			$production = false;
		}
		$wsdl = $production ? self::PRODUCTION_WSDL : self::PRE_WSDL;

		if ( false === $cache_wsdl ) {
			$options['cache_wsdl'] = WSDL_CACHE_NONE;
		}

		$this->client = null === $client ? new Soap_Correos( $wsdl, $options ) : $client;
	}

	public function preregistro( $arguments ) {
		//debug_print_backtrace();
		//var_dump('DEBUG SOAP 1 BULTO', $arguments);
		$response = $this->client->do_request(
			static::FUNCTION_PREREGISTRO,
			$arguments
		);
		if ( static::RESPONSE_WITH_ERROR === $response->Resultado ) {
			$error = $response->BultoError;
			throw Preregistro_Bulto_Exception::build( $error );
		}

		return [
			'correos_id'        => $response->Bulto->CodEnvio,
			'label_pdf_content' => $response->Bulto->Etiqueta->Etiqueta_pdf->Fichero,
		];
	}

	private function check_empty_user_password( $user_password ) {
		if ( ! isset( $user_password['login'] ) || ! isset( $user_password['password'] ) ) {
			throw new \InvalidArgumentException( 'User and password are needed for preregistro request.' );
		}

		if ( empty( trim( $user_password['login'] ) ) || empty( trim( $user_password['password'] ) ) ) {
			throw new \InvalidArgumentException( 'User or password are empty.' );
		}
	}
}
