<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro;

use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Remitente\Remitente_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Destinatario\Destinatario_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\Envio_Data_Factory;

class Preregistro_Data_Factory {

	public static function build( $general, $sender, $label, $order ) {
		$Remitente    = Remitente_Data_Factory::build( $sender );
		$Destinatario = Destinatario_Data_Factory::build( $order, $general );
		$Envio        = Envio_Data_Factory::build_from_label_order_and_sender( $label, $order, $sender );

		return new Preregistro_Data(
			$general->labeler_code(),
			$Remitente,
			$Destinatario,
			$Envio,
			$label->num_packages()
		);
	}
}
