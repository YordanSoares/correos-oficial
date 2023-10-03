<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Aduanas;

class Declaracion_Contenido_Data {

	private $cod_certificado;

	public function __construct( $cod_certificado = null ) {
		$this->cod_certificado = $cod_certificado;
	}

	public function data() {
		return [
			'codCertificado' => $this->cod_certificado,
		];
	}

	public static function build( $correos_id ) {
		return new static( $correos_id);
	}
}
