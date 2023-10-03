<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro;

use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Remitente\Remitente_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Destinatario\Destinatario_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\EnviosMultibulto\Envios_Multibulto_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\ValoresAnadidos\Valores_Anadidos_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\OficinaElegida\Oficina_Elegida_Data_Factory;

class Preregistro_Multibulto_Data_Factory {

	public static function build( $general, $sender, $label, $order ) {
		$Remitente    = Remitente_Data_Factory::build( $sender );
		$Destinatario = Destinatario_Data_Factory::build( $order, $general );

		$Envios = Envios_Multibulto_Data_Factory::build_from_label_order_and_sender(
			$label,
			$order,
			$sender
		);

		$TotalBultos      = $label->num_packages();
		$CodProducto      = $order->correos_code();
		$ModalidadEntrega = $order->type_delivery();
		$ValoresAnadidos  = Valores_Anadidos_Data_Factory::from_label_and_order( $label, $order );
		$OficinaElegida   = Oficina_Elegida_Data_Factory::build_from_order( $order );

		return new Preregistro_Multibulto_Data(
			$general->labeler_code(),
			$Remitente,
			$Destinatario,
			$Envios,
			$TotalBultos,
			$CodProducto,
			$ModalidadEntrega,
			$ValoresAnadidos,
			$OficinaElegida
		);
	}
}
