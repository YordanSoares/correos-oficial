<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\ValoresAnadidos;

use WooEnvio\WECorreos\Infrastructure\Common\Format\Correos_Price;

class Reembolso_Data_Factory {

	public static function from_order( $order ) {
		if ( ! static::order_is_payondelivery_method( $order ) ) {
			return null;
		}

		return new Reembolso_Data(
			Correos_Price::from_euros( $order->get_total() ),
			static::bank_account_from_order( $order )
		);
	}

	public static function from_returns( $returns ) {
		return new Reembolso_Data(
			Correos_Price::from_euros( $returns->return_cost() ),
			static::bank_account_from_returns( $returns )
		);
	}

	public static function order_is_payondelivery_method( $order ) {
		return $order->payment_on_delivery();
	}

	private static function bank_account_from_order( $order ) {
		return str_replace( ' ', '', $order->bank_account() );
	}

	private static function bank_account_from_returns( $returns ) {
		return str_replace( ' ', '', $returns->return_ccc() );
	}
}
