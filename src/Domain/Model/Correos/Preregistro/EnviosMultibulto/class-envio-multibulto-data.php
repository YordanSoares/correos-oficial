<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\EnviosMultibulto;

class Envio_Multibulto_Data {

	private $NumBulto;
	private $ReferenciaCliente;
	private $Pesos;
	private $Largo;
	private $Alto;
	private $Ancho;
	private $Observaciones1;
	private $Observaciones2;
	private $Aduana;

	public function __construct(
		$NumBulto,
		$ReferenciaCliente,
		$Pesos,
		$Largo,
		$Alto,
		$Ancho,
		$Observaciones1,
		$Observaciones2,
		$Aduana
	) {
		$this->NumBulto          = $NumBulto;
		$this->ReferenciaCliente = $ReferenciaCliente;
		$this->Pesos             = $Pesos;
		$this->Largo             = $Largo;
		$this->Alto              = $Alto;
		$this->Ancho             = $Ancho;
		$this->Observaciones1    = $Observaciones1;
		$this->Observaciones2    = $Observaciones2;
		$this->Aduana            = $Aduana;
	}

	public function data() {

		$data = [
			'NumBulto'          => $this->NumBulto,
			'ReferenciaCliente' => $this->ReferenciaCliente,
			'ReferenciaCliente3'=> _PLATFORM_AND_VERSION_,
			'Largo'             => $this->Largo,
			'Alto'              => $this->Alto,
			'Ancho'             => $this->Ancho,
			'Observaciones2'    => $this->Observaciones1,
			'Observaciones2'    => $this->Observaciones1,
		];

		$data = $this->maybe_delete_size($data);

		return array_merge(
			$data,
			$this->aduana(),
			$this->pesos()
		);
	}

	private function aduana() {
		if ( null === $this->Aduana ) {
			return [];
		}

		return $this->Aduana->data();
	}
	private function pesos() {
		if ( null === $this->Pesos ) {
			return [];
		}

		return $this->Pesos->data();
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
