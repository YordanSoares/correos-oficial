<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Aduanas;

class Ddp_Data_Factory {

	public static function build( $customs, $general, $order, $sender ) {
		$num_contrato        = $general->contract_number();
		$num_cliente         = $general->client_number();
		$cod_etiquetador     = $general->labeler_code();
		$provincia           = $order->get_shipping_national_state_correos_code();
		$pais_destino        = $order->get_shipping_country();
		$nombre_destinatario = static::customs_name( $order );
		$localidad_firma     = $sender->city();
		$numero_envios       = $customs->number_pieces();

		return new Ddp_Data(
			$num_contrato,
			$num_cliente,
			$cod_etiquetador,
			$provincia,
			$pais_destino,
			$nombre_destinatario,
			$numero_envios,
			$localidad_firma
		);
	}

	private static function customs_name( $order ) {
		return $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name();
	}
}
