<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Remitente;

class Datos_Direccion_Data {


	private $Direccion;
	private $Localidad;
	private $Provincia;

	public function __construct( $Direccion, $Localidad, $Provincia ) {
		$this->Direccion = $Direccion;
		$this->Localidad = $Localidad;
		$this->Provincia = $Provincia;
	}

	public function data() {

		return [
			'Direccion' => $this->Direccion,
			'Localidad' => $this->Localidad,
			'Provincia' => $this->Provincia,
		];
	}
}
