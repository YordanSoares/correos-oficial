<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\OficinaElegida;

class Oficina_Elegida_Data {

	private $oficina_elegida;

	public function __construct( $oficina_elegida ) {
		$this->oficina_elegida = $oficina_elegida;
	}

	public function data() {
		return [
			'OficinaElegida' => $this->oficina_elegida,
		];
	}
}
