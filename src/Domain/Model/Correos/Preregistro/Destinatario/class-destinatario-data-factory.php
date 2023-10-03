<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Destinatario;
require_once plugin_dir_path( __DIR__ ) . '../../../../../src/Infrastructure/Common/Shipping/DniRequired.php';


class Destinatario_Data_Factory {

	public static function build( $order, $general ) {

		$Identificacion = new Identificacion_Data(
			$order->get_shipping_first_name(),
			$order->get_shipping_last_name(),
			'',
			'',
			'',
			//get_post_meta( $order->get_order_number(), 'NIF', true)
			get_personal_id( $order )
		);

		$DatosDireccion = new Datos_Direccion_Data(
			$order->get_shipping_address_1() . ' ' . $order->get_shipping_address_2(),
			$order->get_shipping_city(),
			$order->get_shipping_state_name()
		);

		return new Destinatario_Data(
			$Identificacion,
			$DatosDireccion,
			$order->get_shipping_national_cp(),
			self::build_phone( $order),
			$order->get_billing_email(),
			$order->get_shipping_internatioal_zip(),
			$order->get_shipping_internatioal_country(),
			$general
		);
	}

	public static function build_phone( $order ) {
		$billing_phone = $order->get_billing_phone();
		return str_replace( '+34', '', $billing_phone);
	}

	public static function build_from_returns( $returns_recipient, $general, $order ) {
		$Identificacion = new Identificacion_Data(
			$returns_recipient->first_name(),
			$returns_recipient->last_name(),
			$returns_recipient->company(),
			$returns_recipient->contact(),
			'',
			//get_post_meta( $order->get_order_number(), 'NIF', true)
			get_personal_id( $order )
		);

		$DatosDireccion = new Datos_Direccion_Data(
			$returns_recipient->address(),
			$returns_recipient->city(),
			static::state_name_from_id( $returns_recipient->state() )
		);

		return new Destinatario_Data(
			$Identificacion,
			$DatosDireccion,
			$returns_recipient->cp(),
			$returns_recipient->phone(),
			$returns_recipient->email(),
			'',
			'',
			$general
		);
	}

	public static function state_name_from_id( $state_id ) {
		$states_by_country = WC()->countries->get_states( 'ES' );

		$state_name = isset( $states_by_country[ $state_id ] ) ? $states_by_country[ $state_id ] : '';

		return html_entity_decode( $state_name );
	}
}
