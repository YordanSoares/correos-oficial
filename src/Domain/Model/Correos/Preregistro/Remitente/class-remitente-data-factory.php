<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Remitente;

use WooEnvio\WECorreos\Domain\Model\Settings\Sender\Sender;

class Remitente_Data_Factory {

	/**
	 * @param Sender $sender
	 *
	 * @return Remitente_Data
	 */
	public static function build( $sender ) {

		$Identificacion = new Identificacion_Data(
			$sender->first_name(),
			$sender->last_name(),
			$sender->dni(),
			$sender->company(),
			$sender->contact()
		);

		$DatosDireccion = new Datos_Direccion_Data(
			$sender->address(),
			$sender->city(),
			$sender->state()
		);

		return new Remitente_Data(
			$Identificacion,
			$DatosDireccion,
			$sender->cp(),
			$sender->phone(),
			$sender->email(),
			$sender->country()
		);
	}

	public static function build_from_returns( $returns_sender ) {
		$Identificacion = new Identificacion_Data(
			$returns_sender->first_name(),
			$returns_sender->last_name(),
			$returns_sender->dni(),
			$returns_sender->company(),
			$returns_sender->contact()
		);

		$DatosDireccion = new Datos_Direccion_Data(
			$returns_sender->address(),
			$returns_sender->city(),
			static::state_name_from_id( $returns_sender->state() )
		);

		return new Remitente_Data(
			$Identificacion,
			$DatosDireccion,
			$returns_sender->cp(),
			$returns_sender->phone(),
			$returns_sender->email(),
			'ES'
		);
	}

	public static function state_name_from_id( $state_id ) {
		$states_by_country = WC()->countries->get_states( 'ES' );

		$state_name = isset( $states_by_country[ $state_id ] ) ? $states_by_country[ $state_id ] : '';

		return html_entity_decode( $state_name );
	}
}
