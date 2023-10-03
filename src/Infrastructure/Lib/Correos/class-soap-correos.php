<?php // phpcs:ignoreFile
namespace WooEnvio\ClientCorreos;
//Para debug completo del var_dump
ini_set('xdebug.var_display_max_depth', -1 );
ini_set('xdebug.var_display_max_children', -1 );
ini_set('xdebug.var_display_max_data', -1 );
class Soap_Correos {

	private $urlWSDL;
	private $options;
	private $soap_client;

	public function __construct( $urlWSDL = null, $options = [], $soap_client = null ) {
		$this->urlWSDL     = $urlWSDL;
		$this->options     = \wp_parse_args( $options, $this->default_options() );
		$this->soap_client = null === $soap_client ? new \SoapClient( $this->urlWSDL, $this->options ) : $soap_client;
	}

	public function do_request( $request, $params = [] ) {
		try {
			$response = $this->soap_client->{$request}( $params );
			 //error_log( '$this->soap_client->__get: ' . print_r($this->soap_client->__getLastRequest(), true) );
             //var_dump('DEBUG XML', $this->soap_client->__getLastRequest());
             //var_dump('DEBUG XML RESPONSE', $response);
		} catch ( \Exception $e ) {
			$this->exception_handler( $e );
		}

		return $response;
	}

	private function default_options() {
		return [
			'soap_version'       => SOAP_1_1,
			'cache_wsdl'         => WSDL_CACHE_BOTH,
			'connection_timeout' => 30,
			'trace'              => true,
			'encoding'           => 'UTF-8',
			'exceptions'         => true,
			'features'           => SOAP_SINGLE_ELEMENT_ARRAYS,
			'stream_context'     => $this->stream_context_create(),
		];
	}

	private function stream_context_create() {
		return stream_context_create(
			[
				'ssl' => [
					'verify_peer'       => false,
					'verify_peer_name'  => false,
					'allow_self_signed' => true,
				],
			]
		);
	}

	private function exception_handler( $exception ) {
		if ( $exception->getMessage() === 'Authorization Required' ) {
			throw new Authenticate_Exception( 'Wrong user and password' );
		}
		throw new Soap_Exception( $exception->getMessage() );
	}
}
