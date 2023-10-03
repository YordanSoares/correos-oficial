<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\Aduana;

use WooEnvio\WECorreos\Infrastructure\Common\Format\Correos_Weight;
use WooEnvio\WECorreos\Infrastructure\Common\Format\Correos_Price;
use WooEnvio\WECorreos\Domain\Services\Order\Order_Needs_Customs;

class Aduana_Data_Factory {

	public static function from_label_order_and_sender( $label, $order, $sender, $return_packages='') {
		if ( false === static::order_needs_customs( $sender, $order ) ) {
			return null;
		}
		
		if (count($label->package_list()->packages())==1){
			$description=$label->package_list()->packages()[0]->customs_tariff_description();
			$tariff_number=$label->package_list()->packages()[0]->customs_tariff_number();
			$first_item_value=$label->package_list()->packages()[0]->first_item_value();
		}
		else if (count($label->package_list()->packages())>=1){
			$description=$return_packages->customs_tariff_description();
			$tariff_number=$return_packages->customs_tariff_number();
			$first_item_value=$return_packages->first_item_value();
		 }

		$aduana_Data =  new Aduana_Data(
			$order->first_item_qty(),
			$description,//$label->first_item_description(),
			Correos_Weight::kg_to_grams( $label->weight() ),
			Correos_Price::from_euros($first_item_value),
			$tariff_number,//$label->customs_tariff_number(),
			$label->customs_consignor_reference()
		);
		return $aduana_Data;
	}

	public static function order_needs_customs( $sender, $order ) {
		$order_needs_customs = Order_Needs_Customs::build( $sender );

		return $order_needs_customs->execute( $order );
	}

	public static function from_label_return_and_order( $label, $returns, $order, $return_packages='') {
		if ( ! static::return_needs_customs( $returns, $order ) ) {
			return null;
		}
		if (count($returns->package_list()->packages())==1){
			$description=$returns->package_list()->packages()[0]->customs_tariff_description();
			$tariff_number=$returns->package_list()->packages()[0]->customs_tariff_number();
			$weight=$returns->package_list()->packages()[0]->weight();
			$first_item_value=$returns->package_list()->packages()[0]->first_item_value();
		}
		else if (count($returns->package_list()->packages())>=1){
			$description=$return_packages->customs_tariff_description();
			$tariff_number=$return_packages->customs_tariff_number();
			$weight=$return_packages->height();
			$first_item_value=$return_packages->first_item_value();
		 }
		 
		return new Aduana_Data(
			$order->first_item_qty(),
			$description,//$label->first_item_description(),
			Correos_Weight::kg_to_grams( $weight ), // $label->weight();
			Correos_Price::from_euros(  $first_item_value), //$label->first_item_value() 
			$tariff_number,//$label->customs_tariff_number(),
			$label->customs_consignor_reference()
		);
	}

	public static function return_needs_customs( $returns, $order ) {

		$returns_sender        = $returns->returns_sender();
		$returns_recipient     = $returns->returns_recipient();
		$returns_needs_customs = Order_Needs_Customs::build_from_returns_sender_and_order( $returns_sender, $order );

		return $returns_needs_customs->execute_from_returns( $returns_recipient );
	}
}
