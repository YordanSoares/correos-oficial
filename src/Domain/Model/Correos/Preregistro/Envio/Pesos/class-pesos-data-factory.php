<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\Pesos;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Label;
use WooEnvio\WECorreos\Infrastructure\Common\Format\Correos_Weight;


class Pesos_Data_Factory {


	/** @var Label $label */
	public static function from_label( $label ) {

		$weight = $label->package_list()->weight();
		return new Pesos_Data(
			Correos_Weight::kg_to_grams( $weight ),
			self::calculate_weight_v( $label->package_list()->first())
		);
	}

	public static function from_package( $package ) {

		$weight = $package->weight();
		return new Pesos_Data(
			Correos_Weight::kg_to_grams( $weight),
			self::calculate_weight_v( $package)
		);
	}

	private static function calculate_weight_v( $package ) {
		if ( $package->length() == 0 ||
			$package->height()  == 0 ||
			$package->width()  == 0 ) {
			return null;
		}
		return (string)intval(round($package->length() * $package->height() * $package->width() / 6));
	}
}
