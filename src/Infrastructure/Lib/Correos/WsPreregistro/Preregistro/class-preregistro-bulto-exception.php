<?php // phpcs:ignoreFile
namespace WooEnvio\ClientCorreos\WsPreregistro\Preregistro;

use WooEnvio\ClientCorreos\Soap_Exception;

class Preregistro_Bulto_Exception extends Soap_Exception {

	const PREFIX = 'Preregistro';

	public function __construct( $message ) {
		parent::__construct( sprintf( '%s: %s', self::PREFIX, $message ) );
	}

	public static function build( $error ) {
		return new self( sprintf( 'Error %s. %s.', $error->Error, $error->DescError ) );
	}
}
