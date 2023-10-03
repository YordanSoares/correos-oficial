<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Destinatario;

class Destinatario_Data {

	private $Identificacion;
	private $DatosDireccion;
	private $CP;
	private $Telefonocontacto;
	private $Email;
	private $ZIP;
	private $Pais;
	private $Sms;

	public function __construct( $Identificacion, $DatosDireccion, $CP, $Telefonocontacto, $Email, $ZIP, $Pais, $general ) {
		$this->Identificacion   = $Identificacion;
		$this->DatosDireccion   = $DatosDireccion;
		$this->CP               = $CP;
		$this->Telefonocontacto = $Telefonocontacto;
		$this->Email            = $Email;
		$this->ZIP              = $ZIP;
		$this->Pais             = $Pais;
		$this->Sms              = $this->sms( $Telefonocontacto, $general);
	}

	private function sms( $Telefonocontacto, $general ) {
		if ( $general->enabled_sms() ) {
			return Sms_Data::build( $Telefonocontacto);
		}
		return null;
	}

	public function data() {

		$base = [
			'Identificacion'   => $this->Identificacion->data(),
			'DatosDireccion'   => $this->DatosDireccion->data(),
			'DatosDireccion2'  => [
				'Direccion' => '',
				'Localidad' => '',
			],
			'CP'               => $this->CP,
			'ZIP'              => $this->ZIP,
			'Pais'             => $this->Pais,
			'Telefonocontacto' => $this->Telefonocontacto,
			'Email'            => $this->Email,
		];

		$sms = is_null( $this->Sms) ? [] : $this->Sms->data();

		return $base + $sms;
	}
}
