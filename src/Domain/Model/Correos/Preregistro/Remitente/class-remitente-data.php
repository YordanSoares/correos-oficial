<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Remitente;

class Remitente_Data {

	private $Identificacion;
	private $DatosDireccion;
	private $CP;
	private $Telefonocontacto;
	private $Email;
	private $Pais;

	public function __construct( $Identificacion, $DatosDireccion, $CP, $Telefonocontacto, $Email, $Pais ) {
		$this->Identificacion   = $Identificacion;
		$this->DatosDireccion   = $DatosDireccion;
		$this->CP               = $CP;
		$this->Telefonocontacto = $Telefonocontacto;
		$this->Email            = $Email;
		$this->Pais             = $Pais;
	}

	public function data() {
		return [
			'Identificacion'   => $this->Identificacion->data(),
			'CP'               => $this->CP,
			'Telefonocontacto' => $this->Telefonocontacto,
			'Email'            => $this->Email,
			'DatosDireccion'   => $this->DatosDireccion->data(),
			'Pais'             => $this->Pais,
		];
	}
}
