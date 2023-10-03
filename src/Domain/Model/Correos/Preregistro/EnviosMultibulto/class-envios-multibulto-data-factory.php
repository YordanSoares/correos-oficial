<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\EnviosMultibulto;

class Envios_Multibulto_Data_Factory {

	public static function build_from_label_order_and_sender( $label, $order, $sender ) {

		$packages = $label->package_list()->packages();

		$envios = [];

		array_map(function( $package ) use ( &$envios, $label, $order, $sender ) {
			$envios[] = Envio_Multibulto_Data_Factory::build_from_label_order_sender_and_package(
				$label,
				$order,
				$sender,
				$package
			);
		}, $packages);

		return new Envios_Multibulto_Data( $envios );
	}
}
