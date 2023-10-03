<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Destinatario;

class Identificacion_Data {

	private $Nombre;
	private $Apellido1;
	private $Empresa;
	private $PersonaContacto;
	private $Nif;

	public function __construct( $Nombre, $Apellido1, $Empresa, $PersonaContacto, $Nose='', $Nif='' ) {
		$this->Nombre          = $Nombre;
		$this->Apellido1       = $Apellido1;
		$this->Empresa         = $Empresa;
		$this->PersonaContacto = $PersonaContacto;
		$this->Nif             = $Nif;
	}

	public function data() {

		return [
			'Nombre'          => $this->Nombre,
			'Apellido1'       => $this->Apellido1,
			'Empresa'         => $this->Empresa,
			'PersonaContacto' => $this->PersonaContacto,
			'Nif'             => $this->Nif,
		];
	}
}
