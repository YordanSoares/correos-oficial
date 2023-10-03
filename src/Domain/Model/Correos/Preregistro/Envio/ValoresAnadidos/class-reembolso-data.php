<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\ValoresAnadidos;

class Reembolso_Data {

	const TIPO_REEMBOLSO_DEFAULT = 'RC';

	private $importe       = '';
	private $numero_cuenta = '';

	public function __construct( $importe, $numero_cuenta ) {
		$this->importe       = $importe;
		$this->numero_cuenta = $numero_cuenta;
	}

	public function data() {
		$reembolso = [ 'TipoReembolso' => static::TIPO_REEMBOLSO_DEFAULT ];

		$reembolso = array_merge( $reembolso, $this->importe() );

		$reembolso = array_merge( $reembolso, $this->numero_cuenta() );

		$data = [
			'Reembolso' => $reembolso,
		];

		return $data;
	}

	private function importe() {
		if ( empty( $this->importe ) ) {
			return [];
		}

		return [
			'Importe' => $this->importe,
		];
	}

	private function numero_cuenta() {
		if ( empty( $this->numero_cuenta ) ) {
			return [];
		}

		return [
			'NumeroCuenta' => $this->numero_cuenta,
		];
	}
}
