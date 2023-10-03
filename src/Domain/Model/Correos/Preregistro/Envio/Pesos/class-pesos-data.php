<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\Pesos;

class Pesos_Data {
	const DEFAULT_PESO_R = 'R';
	const DEFAULT_PESO_V = 'V';

	private $peso_r;
	private $peso_v;

	public function __construct( $peso_r, $peso_v = null) {
		$this->peso_r = $peso_r;
		$this->peso_v = $peso_v;
	}

	public function data() {
		$weights = [];
		$weights[] = $this->formatted_weight_r();
		if (false === is_null($this->peso_v)) {
			$weights[] = $this->formatted_weight_v();
		}

		return [
			'Pesos' => [
				'Peso' => $weights
			],
		];
	}

	private function formatted_weight_r()
	{
		return [
			'TipoPeso' => self::DEFAULT_PESO_R,
			'Valor'    => $this->peso_r,
		];
	}

	private function formatted_weight_v()
	{
		return [
			'TipoPeso' => self::DEFAULT_PESO_V,
			'Valor'    => $this->peso_v,
		];
	}
}
