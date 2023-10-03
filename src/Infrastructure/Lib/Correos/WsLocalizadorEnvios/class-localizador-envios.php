<?php // phpcs:ignoreFile
namespace WooEnvio\ClientCorreos\WsLocalizadorEnvios;

use WooEnvio\ClientCorreos\Soap_Correos;

class Localizador_Envios {

	const FUNCTION_LOCALIZADORENVIOS = 'ConsultaLocalizacionEnviosFases';

	const PRODUCTION_WSDL = __DIR__ . '/localizadorenvios1.0.wsdl';

	private $client;

	public function __construct( $client = null, $options = [] ) {
		$this->client = null === $client ? new Soap_Correos( static::PRODUCTION_WSDL, $options ) : $client;
	}

	public function localizador_envios( $correos_code ) {
		$response = $this->client->do_request(
			static::FUNCTION_LOCALIZADORENVIOS,
			$this->localizador_envios_arguments( $correos_code )
		);

		return $this->extract_shipping_states( $response );
	}

	private function localizador_envios_arguments( $correos_codes ) {
		$XMLin = sprintf(
			'<ConsultaXMLin Idioma="1"
			xmlns:xsd="http://www.w3.org/2001/XMLSchema"
			xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
				<Consulta>
					%s
				</Consulta>
			</ConsultaXMLin>',
			implode( '', $this->consulta_correos_code( $correos_codes ) )
		);

		return compact( 'XMLin' );
	}

	private function consulta_correos_code( $correos_codes ) {
		return array_map(
			function( $code ) {
				return sprintf( '<Codigo>%s</Codigo>', $code );
			}, $correos_codes
		);
	}

	private function extract_shipping_states( $response ) {
		$xml = new \SimpleXMLElement( $response->ConsultaLocalizacionEnviosFasesResult );

		return array_map(
			function ( $datos ) {

				$params = get_object_vars( $datos );

				unset( $params['@attributes'] );

				return $params;
			}, $xml->xpath( '//Datos' )
		);
	}
}
