<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\EnviosMultibulto;

use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\Pesos\Pesos_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\Aduana\Aduana_Data_Factory;

class Envio_Multibulto_Data_Factory {

	const COMMENT_LINE_MAX_LENGHT = 45;

	public static function build_from_label_order_sender_and_package( $label, $order, $sender, $package ) {

		$comment_lines = static::split_comments_in_two_comment_lines( $label->comment() );

		$NumBulto          = $package->key();
		$ReferenciaCliente = $order->get_order_number();
		$Pesos             = Pesos_Data_Factory::from_package( $package );
		$Largo             = $package->length();
		$Alto              = $package->height();
		$Ancho             = $package->width();
		$Observaciones1    = $comment_lines[0];
		$Observaciones2    = $comment_lines[1];
		$Aduanas           = Aduana_Data_Factory::from_label_order_and_sender( $label, $order, $sender, $package );

		return new Envio_Multibulto_Data(
			$NumBulto,
			$ReferenciaCliente,
			$Pesos,
			$Largo,
			$Alto,
			$Ancho,
			$Observaciones1,
			$Observaciones2,
			$Aduanas
		);
	}

	public static function split_comments_in_two_comment_lines( $comment ) {
		$comment_lines = [ '', '' ];

		if ( strlen( $comment ) <= static::COMMENT_LINE_MAX_LENGHT ) {
			$comment_lines[0] = $comment;

			return $comment_lines;
		}

		return str_split( $comment, static::COMMENT_LINE_MAX_LENGHT );
	}
}
