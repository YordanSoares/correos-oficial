<?php // phpcs:ignoreFile
namespace WooEnvio\ClientCorreos\Citypaq\Favorites;

use function WooEnvio\ClientCorreos\Citypaq\Soap\build_soap_client;

/**
 * Fetch favorites citypaas by citypaq user from Correos Web Service
 *
 * @param  array $user_password User and password.
 * @param string $citypaq_user citypaq user.
 * @return array
 */
function fetch_favorites_citypaqs_by_citypaq_user( $user_password, $citypaq_user ) {

	try {
		$soap_client = build_soap_client( $user_password );
		$response    = $soap_client->getFavorites( params_by_citypaq_user( $citypaq_user ) );
		return $response->return->citypaqs->citypaq;
	} catch ( \Exception $exception ) {
		return [];
	}
}

/**
 * Params
 *
 * @param string $citypaq_user citypaq user.
 * @return array
 */
function params_by_citypaq_user( $citypaq_user ) {
	return [
		'user' => $citypaq_user,
		'ip'   => $_SERVER['REMOTE_ADDR'],
	];
}
