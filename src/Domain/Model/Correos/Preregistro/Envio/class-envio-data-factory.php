<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio;

use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\CodigoHomepaq\Codigo_Homepaq;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\Pesos\Pesos_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\Aduana\Aduana_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\ValoresAnadidos\Valores_Anadidos_Data_Factory;
use WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\OficinaElegida\Oficina_Elegida_Data_Factory;

class Envio_Data_Factory {

	const COMMENT_LINE_MAX_LENGHT = 45;
	const RETURNS_CORREOS_CODE    = 'S0148';
	const RETURNS_TYPE_DELIVERY   = 'ST';

	public static function build_from_label_order_and_sender( $label, $order, $sender ) {
		$comment_lines = static::split_comments_in_two_comment_lines( $label->comment() );

		$package_first = $label->package_list()->packages()[0];

		return new Envio_Data(
			$order->correos_code(),
			$order->get_order_number(),
			$order->type_delivery(),
			$package_first->length(),
			$package_first->height(),
			$package_first->width(),
			Pesos_Data_Factory::from_label( $label ),
			Aduana_Data_Factory::from_label_order_and_sender( $label, $order, $sender ),
			Valores_Anadidos_Data_Factory::from_label_and_order( $label, $order ),
			Oficina_Elegida_Data_Factory::build_from_order( $order ),
			$comment_lines[0],
			$comment_lines[1],
			Codigo_Homepaq::from_order( $order)
		);
	}

	public static function build_to_returns( $returns, $label, $order ) {

		$package_first = $label->package_list()->packages()[0];
//var_dump('DEBUG ENVIO_DATA_FACTORY_4', $returns->package_list()->packages());
 
       $return_packages = $returns->package_list()->packages()[0];
		
		$customs_tariff_number	   =$return_packages->customs_tariff_number();
		$customs_tariff_description=$return_packages->customs_tariff_description();

		return new Envio_Data(
			static::RETURNS_CORREOS_CODE,
			$order->get_order_number(),
			static::RETURNS_TYPE_DELIVERY,
			$package_first->length(),
			$package_first->height(),
			$package_first->width(),
			Pesos_Data_Factory::from_label( $returns ),
			Aduana_Data_Factory::from_label_return_and_order( $label, $returns, $order, $return_packages),
			Valores_Anadidos_Data_Factory::from_returns( $returns ),
			null,
			'',
			'',
			null
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
