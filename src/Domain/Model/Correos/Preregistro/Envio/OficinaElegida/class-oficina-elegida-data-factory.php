<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\OficinaElegida;

class Oficina_Elegida_Data_Factory {

	public static function build_from_order( $order ) {
		$selected_office = $order->get_selected_office();

		if ( null === $selected_office ) {
			return null;
		}

		return new Oficina_Elegida_Data( $selected_office );
	}
}
