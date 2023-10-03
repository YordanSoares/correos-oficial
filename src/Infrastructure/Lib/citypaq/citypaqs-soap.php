<?php // phpcs:ignoreFile
namespace WooEnvio\ClientCorreos\Citypaq\Soap;

const WSDL_CORREOS_PAQ_SERVICE = __DIR__ . '/CorreospaqServiceService.wsdl';
const LOCATION_PAQ_SERVICE     = 'https://online.correospaq.es/correospaqws/CorreospaqService';
const LOCATION_PAQ_SERVICE_PRE = 'https://onlinepre.correospaq.es/correospaqws/CorreospaqService';

/**
 * Build soap client
 *
 * @param  array $user_password User and password.
 * @return \SoapClient
 */
function build_soap_client( $user_password ) {
	$options = array_merge( default_soap_options(), $user_password );
	return new \SoapClient( WSDL_CORREOS_PAQ_SERVICE, $options );
}

/**
 * Soap options
 *
 * @return array
 */
function default_soap_options() {
	$location = LOCATION_PAQ_SERVICE;

	return [
		'location'           => $location,
		'soap_version'       => SOAP_1_1,
		'cache_wsdl'         => WSDL_CACHE_BOTH,
		'connection_timeout' => 30,
		'trace'              => true,
		'encoding'           => 'UTF-8',
		'exceptions'         => true,
		'features'           => SOAP_SINGLE_ELEMENT_ARRAYS,
		'stream_context'     => \stream_context_create(
			[
				'ssl' => [
					'verify_peer'       => false,
					'verify_peer_name'  => false,
					'allow_self_signed' => true,
				],
			]
		),
	];
}

