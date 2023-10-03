<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio;

class Envio_Data {

	const DEFAULT_TIPOFRANQUEO            = 'FP';
	const DEFAULT_INSTRUCCIONESDEVOLUCION = 'D';

	private $CodProducto;
	private $ReferenciaCliente;
	private $ModalidadEntrega;
	private $TipoFranqueo;
	private $Largo;
	private $Alto;
	private $Ancho;
	private $Pesos;
	private $Aduana;
	private $ValoresAnadidos;
	private $OficinaElegida = null;
	private $Observaciones1;
	private $Observaciones2;
	private $CodigoHomepaq = null;

	public function __construct( $CodProducto, $ReferenciaCliente, $ModalidadEntrega, $Largo, $Alto, $Ancho, $Pesos, $Aduana, $ValoresAnadidos, $OficinaElegida, $Observaciones1, $Observaciones2, $CodigoHomepaq ) {
		$this->CodProducto       = $CodProducto;
		$this->ReferenciaCliente = $ReferenciaCliente;
		$this->ModalidadEntrega  = $ModalidadEntrega;
		$this->Largo             = $Largo;
		$this->Alto              = $Alto;
		$this->Ancho             = $Ancho;
		$this->Pesos             = $Pesos;
		$this->Aduana            = $Aduana;
		$this->ValoresAnadidos   = $ValoresAnadidos;
		$this->OficinaElegida    = $OficinaElegida;
		$this->Observaciones1    = $Observaciones1;
		$this->Observaciones2    = $Observaciones2;
		$this->CodigoHomepaq     = $CodigoHomepaq;
	}

	public function data() {
		$data = [
			'CodProducto'             => $this->CodProducto,
			'ReferenciaCliente'       => $this->ReferenciaCliente,
			'ReferenciaCliente3'      => _PLATFORM_AND_VERSION_,
			'ModalidadEntrega'        => $this->ModalidadEntrega,
			'TipoFranqueo'            => self::DEFAULT_TIPOFRANQUEO,
			'Largo'                   => $this->Largo,
			'Alto'                    => $this->Alto,
			'Ancho'                   => $this->Ancho,
			'InstruccionesDevolucion' => self::DEFAULT_INSTRUCCIONESDEVOLUCION,
			'Observaciones1'          => $this->Observaciones1,
			'Observaciones2'          => $this->Observaciones2,
		];

		$data = $this->maybe_delete_size($data);
		return array_merge(
			$data,
			$this->pesos(),
			$this->aduana(),
			$this->valores_anadidos(),
			$this->oficina_elegida(),
			$this->codigo_homepaq()
		);
	}

	private function pesos() {
		if ( null === $this->Pesos ) {
			return [];
		}

		return $this->Pesos->data();
	}

	private function aduana() {
		if ( null === $this->Aduana ) {
			return [];
		}

		return $this->Aduana->data();
	}

	private function valores_anadidos() {
		if ( null === $this->ValoresAnadidos ) {
			return [];
		}

		return $this->ValoresAnadidos->data();
	}

	private function oficina_elegida() {
		if ( null === $this->OficinaElegida ) {
			return [];
		}

		return $this->OficinaElegida->data();
	}

	private function codigo_homepaq() {
		if ( null === $this->CodigoHomepaq ) {
			return [];
		}

		return $this->CodigoHomepaq->data();
	}

	private function maybe_delete_size( array $data )
	{
		if ($data['Largo'] == '0' || $data['Alto'] == '0' || $data['Ancho'] == '0') {
			unset($data['Largo']);
			unset($data['Alto']);
			unset($data['Ancho']);
		}
		return $data;
	}
}
