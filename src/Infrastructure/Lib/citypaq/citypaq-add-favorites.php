<?php // phpcs:ignoreFile
namespace WooEnvio\ClientCorreos\Citypaq\AddFavorites;

use function WooEnvio\ClientCorreos\Citypaq\Soap\build_soap_client;

const OPERATION_ADD_FAVORITE = 'Add_Favorite';

/**
 * Add favorite citypaa to citypaq user from Correos Web Service
 *
 * @param  array $user_password User and password.
 * @param string $citypaq_user Citypaq user.
 * @param string $citypaq_code Citypaq code.
 * @return string
 */
function add_favorite_to_citypaq_user( $user_password, $citypaq_user, $citypaq_code ) {

	try {
		$soap_client = build_soap_client( $user_password );
		$response    = $soap_client->getUrl( params_add_favorite_citypaq( $citypaq_user, $citypaq_code ) );
		return $response->return->url;
	} catch ( \Exception $exception ) {
		return '';
	}
}

/**
 * Params
 *
 * @param string $citypaq_user citypaq user.
 * @param string $citypaq_code Citypaq code.
 * @return array
 */
function params_add_favorite_citypaq( $citypaq_user, $citypaq_code ) {
	return [
		'operationType'   => OPERATION_ADD_FAVORITE,
		'user'            => $citypaq_user,
		'favorite'        => $citypaq_code,
		'urlCallBack'     => '',
		'integrationMode' => 'I',
	];
}
