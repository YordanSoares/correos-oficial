<?php // phpcs:ignoreFile
namespace WooEnvio\ClientCorreos\WsPreregistro\Preregistro;

use WooEnvio\ClientCorreos\Soap_Exception;

class Preregistro_Multibulto_Exception extends Soap_Exception {

	const PREFIX = 'PreRegistro Multibulto';

	public function __construct( $message ) {
		parent::__construct( sprintf( '%s: %s', self::PREFIX, $message ) );
	}

	public static function build( $errors ) {

		$first_error_msg = self::first_error_msg( $errors );

		return new self( $first_error_msg );
	}

	private static function first_error_msg( $errors ) {

		$first_error = $errors[0];

		return sprintf( 'Error %s. %s.', $first_error->Error, $first_error->DescError );
	}
}
