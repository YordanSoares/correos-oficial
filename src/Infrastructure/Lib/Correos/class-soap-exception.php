<?php // phpcs:ignoreFile
namespace WooEnvio\ClientCorreos;

class Soap_Exception extends \Exception {

	const PREFIX = 'SoapCorreos';

	public function __construct( $message ) {
		parent::__construct( sprintf( '%s: %s', self::PREFIX, $message ) );
	}
}
