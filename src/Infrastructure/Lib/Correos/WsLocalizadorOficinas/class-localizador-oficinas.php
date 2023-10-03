<?php // phpcs:ignoreFile
namespace WooEnvio\ClientCorreos\WsLocalizadorOficinas;

use WooEnvio\ClientCorreos\Soap_Correos;

class Localizador_Oficinas {

	const FUNCTION_PROCESALOCALIZADOR = 'procesaLocalizador';

	const PRODUCTION_WSDL = __DIR__ . '/localizadoroficinas1.13.wsdl';

	const DEFAULT_LOCATION = 'http://localizadoroficinas.correos.es/localizadoroficinas';

	private $client;

	public function __construct( $client = null, $options = [] ) {

		$default_options = [ 'location' => static::DEFAULT_LOCATION ];
		$options = wp_parse_args($options, $default_options);
		$this->client = null === $client ? new Soap_Correos( static::PRODUCTION_WSDL, $options ) : $client;
	}

	public function by_cp( $cp ) {

		$response = $this->client->do_request(
			static::FUNCTION_PROCESALOCALIZADOR,
			[ 'codigoPostal' => $cp ]
		);

		return $response->arrayOficina;
	}
}
