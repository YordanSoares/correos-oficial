<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\Aduana;

class Aduana_Data {

	const DEFAULT_TIPOFRANQUEO = '2';

	private $first_item_qty;
	private $first_item_description;
	private $weight;
	private $first_item_value;
	private $customs_tariff_number;
	private $customs_consignor_reference;

	public function __construct( $first_item_qty, $first_item_description, $weight, $first_item_value, 
	                             $customs_tariff_number='', $customs_consignor_reference='' ) {
		$this->first_item_qty         = $first_item_qty;
		$this->first_item_description = $first_item_description;
		$this->weight                 = $weight;
		$this->first_item_value       = $first_item_value;
		$this->customs_tariff_number  = $customs_tariff_number;
		$this->customs_consignor_reference    = $customs_consignor_reference;
	}

	public function data() {
		return [
			'Aduana' => [
				'TipoEnvio'    => self::DEFAULT_TIPOFRANQUEO,
				'DescAduanera' => [
					'DATOSADUANA' => [
						'Cantidad'    => $this->first_item_qty,
						'Descripcion' => $this->first_item_description,
						'Pesoneto'    => $this->weight,
						'Valorneto'   => $this->first_item_value,
						'NTarifario'  => $this->customs_tariff_number
					],
				],
				'RefAduaneraExpedidor' => $this->customs_consignor_reference
			],
		];
	}
}
