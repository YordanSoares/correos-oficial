<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Aduanas;

class Ddp_Data {

	const ESAD_DDP = 'DDP';

	private $TipoESAD;
	private $NumContrato;
	private $NumCliente;
	private $CodEtiquetador;
	private $Provincia;
	private $PaisDestino;
	private $NombreDestinatario;
	private $NumeroEnvios;
	private $LocalidadFirma;


	public function __construct( $NumContrato, $NumCliente, $CodEtiquetador, $Provincia, $PaisDestino, $NombreDestinatario, $NumeroEnvios, $LocalidadFirma ) {
		$this->TipoESAD           = static::ESAD_DDP;
		$this->NumContrato        = $NumContrato;
		$this->NumCliente         = $NumCliente;
		$this->CodEtiquetador     = $CodEtiquetador;
		$this->Provincia          = $Provincia;
		$this->PaisDestino        = $PaisDestino;
		$this->NombreDestinatario = $NombreDestinatario;
		$this->NumeroEnvios       = $NumeroEnvios;
		$this->LocalidadFirma     = $LocalidadFirma;
	}

	public function data() {
		return [
			'TipoESAD'           => $this->TipoESAD,
			'NumContrato'        => $this->NumContrato,
			'NumCliente'         => $this->NumCliente,
			'CodEtiquetador'     => $this->CodEtiquetador,
			'Provincia'          => $this->Provincia,
			'PaisDestino'        => $this->PaisDestino,
			'NombreDestinatario' => $this->NombreDestinatario,
			'NumeroEnvios'       => $this->NumeroEnvios,
			'LocalidadFirma'     => $this->LocalidadFirma,
		];
	}
}
