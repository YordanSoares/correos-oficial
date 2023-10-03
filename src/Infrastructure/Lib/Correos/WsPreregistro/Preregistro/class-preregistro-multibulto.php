<?php // phpcs:ignoreFile
namespace WooEnvio\ClientCorreos\WsPreregistro\Preregistro;

use WooEnvio\ClientCorreos\Soap_Correos;

class Preregistro_Multibulto {

	const FUNCTION_WS = 'PreregistroMultibulto';

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
		//var_dump('DEBUG SOAP MULTI BULTO', $arguments);
		$response = $this->client->do_request(
			static::FUNCTION_WS,
			$arguments
		);

		if ( static::RESPONSE_WITH_ERROR === $response->Resultado ) {
			$errors = $response->BultosError->BultoError;
			throw Preregistro_Multibulto_Exception::build( $errors );
		}

		return $this->build_response( $response );
	}

	private function check_empty_user_password( $user_password ) {
		if ( ! isset( $user_password['login'] ) || ! isset( $user_password['password'] ) ) {
			throw new \InvalidArgumentException( 'User and password are needed for preregistro request.' );
		}

		if ( empty( trim( $user_password['login'] ) ) || empty( trim( $user_password['password'] ) ) ) {
			throw new \InvalidArgumentException( 'User or password are empty.' );
		}
	}

	private function build_response( $response ) {

		$package_ids = array_map(
			function( $bulto ) {
				return $bulto->CodEnvio;
			}, $response->Bultos->Bulto
		);

		$correos_id = [
			$response->CodExpedicion => $package_ids,
		];

		$useful_response['correos_id'] = $correos_id;

		$label_pdf_content = array_map(
			function( $bulto ) {
				return $bulto->Etiqueta->Etiqueta_pdf->Fichero;
			}, $response->Bultos->Bulto
		);

		$useful_response['label_pdf_content'] = $label_pdf_content;

		return $useful_response;
	}
}
