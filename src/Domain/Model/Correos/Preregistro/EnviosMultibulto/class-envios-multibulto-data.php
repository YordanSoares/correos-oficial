<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\EnviosMultibulto;

class Envios_Multibulto_Data {

	private $envios;

	public function __construct( $envios ) {
		$this->envios = $envios;
	}

	public function data() {

		$envios = array_map(function( $envio ) {
			return $envio->data();
		}, $this->envios);

		return [ 'Envios' => [ 'Envio' => $envios ] ];
	}
}
