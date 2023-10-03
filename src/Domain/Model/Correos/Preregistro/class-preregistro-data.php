<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro;

class Preregistro_Data {


	const MODDEVETIQUETA_PDF  = '2';
	const CARE_DEFAULT        = '000000';
	const TOTALBULTOS_DEFAULT = '1';

	private $FechaOperacion;
	private $CodEtiquetador;
	private $ModDevEtiqueta;
	private $Care;
	private $TotalBultos;
	private $Remitente;
	private $Destinatario;
	private $Envio;

	public function __construct( $CodEtiquetador, $Remitente, $Destinatario, $Envio, $TotalBultos = null ) {
		$this->CodEtiquetador = $CodEtiquetador;
		$this->Remitente      = $Remitente;
		$this->Destinatario   = $Destinatario;
		$this->Envio          = $Envio;

		$this->FechaOperacion = date( 'd-m-Y H:i:s' );
		$this->ModDevEtiqueta = self::MODDEVETIQUETA_PDF;
		$this->Care           = self::CARE_DEFAULT;
		$this->TotalBultos    = is_null( $TotalBultos) ? self::TOTALBULTOS_DEFAULT : $TotalBultos;
	}

	public function data() {

		$data = [
			'FechaOperacion' => $this->FechaOperacion,
			'CodEtiquetador' => $this->CodEtiquetador,
			'ModDevEtiqueta' => $this->ModDevEtiqueta,
			'Care'           => $this->Care,
			'TotalBultos'    => $this->TotalBultos,
			'Remitente'      => $this->Remitente->data(),
			'Destinatario'   => $this->Destinatario->data(),
			'Envio'          => $this->Envio->data(),
		];
		return $data;
	}
}
