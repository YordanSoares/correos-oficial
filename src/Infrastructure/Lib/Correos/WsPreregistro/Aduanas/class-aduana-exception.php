<?php // phpcs:ignoreFile
namespace WooEnvio\ClientCorreos\WsPreregistro\Aduanas;

class Aduana_Exception extends \Exception {

	const PREFIX = 'Aduanas';

	public function __construct( $message ) {
		parent::__construct( sprintf( '%s: %s', self::PREFIX, $message ) );
	}

	public static function build( $error ) {
		return new self( $error );
	}
}
