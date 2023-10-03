<?php // phpcs:ignoreFile
namespace WooEnvio\ClientCorreos\Citypaq\Location;

use function WooEnvio\ClientCorreos\Citypaq\Soap\build_soap_client;

/**
 * Fetch citypaas by postal code from Correos Web Service
 *
 * @param  array $user_password User and password.
 * @param string $postal_code Postal code.
 * @return array
 */
function fetch_citypaqs_by_postal_code( $user_password, $postal_code ) {

	try {
		$soap_client = build_soap_client( $user_password );
		$response    = $soap_client->getCitypaqs( [ 'postalCode' => $postal_code ] );
		return $response->return->citypaq;
	} catch ( \Exception $exception ) {
		return [];
	}
}

/**
 * Fetch citypaas by state code from Correos Web Service
 *
 * @param  array $user_password User and password.
 * @param string $state_code State code.
 * @return array
 */
function fetch_citypaqs_by_state_code( $user_password, $state_code ) {

	try {
		$soap_client = build_soap_client( $user_password );
		$response    = $soap_client->getCitypaqs( [ 'stateCode' => $state_code ] );
		return $response->return->citypaq;
	} catch ( \Exception $exception ) {
		return [];
	}
}
