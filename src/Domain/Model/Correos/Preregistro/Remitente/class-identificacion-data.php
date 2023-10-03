<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Remitente;

class Identificacion_Data {


	private $Nombre;
	private $Apellido1;
	private $Nif;
	private $Empresa;
	private $PersonaContacto;

	public function __construct( $Nombre, $Apellido1, $Nif, $Empresa, $PersonaContacto ) {
		$this->Nombre          = $Nombre;
		$this->Apellido1       = $Apellido1;
		$this->Nif             = $Nif;
		$this->Empresa         = $Empresa;
		$this->PersonaContacto = $PersonaContacto;
	}

	public function data() {

		return [
			'Nombre'          => $this->Nombre,
			'Apellido1'       => $this->Apellido1,
			'Nif'             => $this->Nif,
			'Empresa'         => $this->Empresa,
			'PersonaContacto' => $this->PersonaContacto,
		];
	}
}
