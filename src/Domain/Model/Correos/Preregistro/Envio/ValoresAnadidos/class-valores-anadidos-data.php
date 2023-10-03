<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\ValoresAnadidos;

class Valores_Anadidos_Data {

	private $importe_seguro = '';
	private $reembolso      = null;

	public function __construct( $importe_seguro, $reembolso ) {
		$this->importe_seguro = $importe_seguro;
		$this->reembolso      = $reembolso;
	}

	public function data() {
		$valores_anadidos = [];

		$valores_anadidos = array_merge( $valores_anadidos, $this->importe_seguro() );

		$valores_anadidos = array_merge( $valores_anadidos, $this->reembolso() );

		return [
			'ValoresAnadidos' => $valores_anadidos,
		];
	}

	private function importe_seguro() {
		if ( empty( trim( $this->importe_seguro ) ) ) {
			return [];
		}

		return [
			'ImporteSeguro' => $this->importe_seguro,
		];
	}

	private function reembolso() {
		if ( null === $this->reembolso ) {
			return [];
		}

		return $this->reembolso->data();
	}
}
