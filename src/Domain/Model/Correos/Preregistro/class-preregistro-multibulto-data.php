<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro;

class Preregistro_Multibulto_Data {

	const MODDEVETIQUETA_PDF   = '2';
	const CARE_DEFAULT         = '000000';
	const DEFAULT_TIPOFRANQUEO = 'FP';

	private $FechaOperacion;
	private $CodEtiquetador;
	private $ModDevEtiqueta;
	private $Care;
	private $TotalBultos;
	private $Remitente;
	private $Destinatario;
	private $Envios;
	private $CodProducto;
	private $ModalidadEntrega;
	private $OficinaElegida;

	public function __construct(
		$CodEtiquetador,
		$Remitente,
		$Destinatario,
		$Envios,
		$TotalBultos,
		$CodProducto,
		$ModalidadEntrega,
		$ValoresAnadidos,
		$OficinaElegida
	) {
		$this->CodEtiquetador   = $CodEtiquetador;
		$this->Remitente        = $Remitente;
		$this->Destinatario     = $Destinatario;
		$this->Envios           = $Envios;
		$this->FechaOperacion   = date( 'd-m-Y H:i:s' );
		$this->ModDevEtiqueta   = self::MODDEVETIQUETA_PDF;
		$this->Care             = self::CARE_DEFAULT;
		$this->TotalBultos      = $TotalBultos;
		$this->CodProducto      = $CodProducto;
		$this->ModalidadEntrega = $ModalidadEntrega;
		$this->ValoresAnadidos  = $ValoresAnadidos;
		$this->OficinaElegida   = $OficinaElegida;
	}

	public function data() {

		$data = [
			'FechaOperacion'   => $this->FechaOperacion,
			'CodEtiquetador'   => $this->CodEtiquetador,
			'ModDevEtiqueta'   => $this->ModDevEtiqueta,
			'Care'             => $this->Care,
			'TotalBultos'      => $this->TotalBultos,
			'Remitente'        => $this->Remitente->data(),
			'Destinatario'     => $this->Destinatario->data(),
			'CodProducto'      => $this->CodProducto,
			'TipoFranqueo'     => self::DEFAULT_TIPOFRANQUEO,
			'ModalidadEntrega' => $this->ModalidadEntrega,
		];

		return array_merge(
			$data,
			$this->Envios->data(),
			$this->valores_anadidos(),
			$this->oficina_elegida()
		);
	}

	private function valores_anadidos() {
		if ( is_null( $this->ValoresAnadidos) ) {
			return [];
		}

		return $this->ValoresAnadidos->data();
	}

	private function oficina_elegida() {
		if ( is_null( $this->OficinaElegida) ) {
			return [];
		}

		return $this->OficinaElegida->data();
	}
}
