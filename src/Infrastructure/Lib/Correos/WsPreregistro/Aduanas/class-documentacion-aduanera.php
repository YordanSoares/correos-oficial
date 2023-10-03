<?php // phpcs:ignoreFile
namespace WooEnvio\ClientCorreos\WsPreregistro\Aduanas;

use WooEnvio\ClientCorreos\Soap_Correos;

class Documentacion_Aduanera {

	const FUNCTION_DOCUMENTACION = 'DocumentacionAduaneraOp';

	const PRODUCTION_WSDL = __DIR__ . '/../preregistro.wsdl';

	const PRE_WSDL = __DIR__ . '/../preregistro-pre.wsdl';

	const RESPONSE_WITH_ERROR = 1;

	private $client;

	public function __construct( $options = [], $client = null, $production = true ) {

		$this->check_empty_user_password( $options );

		if ( defined( 'WS_CORREOS_PREPRODUCCION' ) && WS_CORREOS_PREPRODUCCION ) {
			$production = false;
		}
		$wsdl = $production ? self::PRODUCTION_WSDL : self::PRE_WSDL;

		$this->client = null === $client ? new Soap_Correos( $wsdl, $options ) : $client;
	}

	public function obtain( $arguments ) {
		$response = $this->client->do_request(
			static::FUNCTION_DOCUMENTACION,
			$arguments
		);

		if ( static::RESPONSE_WITH_ERROR === $response->Resultado ) {
			$error = $response->MotivoError;
			throw Aduana_Exception::build( $error );
		}

		return [
			'customs_doc_pdf_content' => $response->Fichero,
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
