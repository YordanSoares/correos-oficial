<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\ValoresAnadidos;

use WooEnvio\WECorreos\Infrastructure\Common\Format\Correos_Price;

class Valores_Anadidos_Data_Factory {

	public static function from_label_and_order( $label, $order ) {
		if ( ! static::order_contains_valores_anadidos( $label, $order ) ) {
			return null;
		}

		$insurance = static::insurance( $label );

		$reembolso_data = Reembolso_Data_Factory::from_order( $order );

		return new Valores_Anadidos_Data( $insurance, $reembolso_data );
	}

	public static function from_returns( $returns ) {
		if ( ! static::returns_contains_valores_anadidos( $returns ) ) {
			return null;
		}

		$insurance = '';

		$reembolso_data = Reembolso_Data_Factory::from_returns( $returns );

		return new Valores_Anadidos_Data( $insurance, $reembolso_data );
	}

	private static function returns_contains_valores_anadidos( $returns ) {
		return $returns->return_cost() > 0;
	}

	private static function order_contains_valores_anadidos( $label, $order ) {
		if ( static::label_contains_insurance( $label ) ) {
			return true;
		}

		if ( Reembolso_Data_Factory::order_is_payondelivery_method( $order ) ) {
			return true;
		}

		return false;
	}

	private static function label_contains_insurance( $label ) {
		if ( empty( trim( $label->insurance() ) ) ) {
			return false;
		}

		return true;
	}

	private static function insurance( $label ) {
		if ( ! static::label_contains_insurance( $label ) ) {
			return '';
		}

		return Correos_Price::from_euros( $label->insurance() );
	}
}
