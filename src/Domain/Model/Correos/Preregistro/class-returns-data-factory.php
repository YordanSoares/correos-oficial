<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro;

use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Remitente\Remitente_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Destinatario\Destinatario_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\Envio_Data_Factory;

class Returns_Data_Factory {

	public static function build( $general, $label, $order, $returns ) {
		$Remitente    = Remitente_Data_Factory::build_from_returns( $returns->returns_sender() );
		$Destinatario = Destinatario_Data_Factory::build_from_returns( $returns->returns_recipient(), $general, $order );
		$Envio        = Envio_Data_Factory::build_to_returns( $returns, $label, $order );

		return new Preregistro_Data(
			$general->labeler_code(),
			$Remitente,
			$Destinatario,
			$Envio
		);
	}
}
