<?php
/**
 * Label actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Label
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Label;

/**
 * Class Obtain_Label_Request
 */
class Obtain_Label_Request {

	/**
	 * Packages
	 *
	 * @var string
	 */
	public $packages;
	/**
	 * Sender_key
	 *
	 * @var string
	 */
	public $sender_key;
	/**
	 * Comment
	 *
	 * @var string
	 */
	public $comment;
	/**
	 * Insurance
	 *
	 * @var string
	 */
	public $insurance;
	/**
	 * First_item_value
	 *
	 * @var string
	 */
	public $first_item_value;
	/**
	 * First_item_description
	 *
	 * @var string
	 */
	public $first_item_description;
   /**
	 * Customs_tariff_number
	 *
	 * @var string
	 */
	public $customs_tariff_number;
   /**
	 * Customs_tariff_description
	 *
	 * @var string
	 */
	public $customs_tariff_description;	

   /**
	 * customs_consignor_reference
	 *
	 * @var string
	 */
	public $customs_consignor_reference;
   /**
	 * customs_check_description_and_tariff
	 *
	 * @var string
	 */
	public $customs_check_description_and_tariff;		

	/**
	 * Order_id
	 *
	 * @var string
	 */
	public $order_id;

	/**
	 * Obtain_Label_Request constructor.
	 *
	 * @param string $packages Packages.
	 * @param string $sender_key Sender_key.
	 * @param string $comment Comment.
	 * @param string $insurance Insurance.
	 * @param string $first_item_value First_item_value.
	 * @param string $first_item_description First_item_description.
	 * @param string $order_id Order_id.
	 * @param string $customs_tariff_number customs_tariff_number.
	 * @param string $customs_tariff_description customs_tariff_description. 
	 * @param string $customs_consignor_reference customs_consignor_reference. 
	 * @param string $customs_check_description_and_tariff customs_check_description_and_tariff. 
	 */
	public function __construct( $packages, $sender_key, $comment, $insurance, $first_item_value, $first_item_description, $order_id,
	$customs_tariff_number='', $customs_tariff_description='', $customs_consignor_reference='', $customs_check_description_and_tariff='') {
		$this->packages               = $packages;
		$this->sender_key             = $sender_key;
		$this->comment                = $comment;
		$this->insurance              = $insurance;
		$this->first_item_value       = $first_item_value;
		$this->first_item_description = $first_item_description;
		$this->order_id               = $order_id;
		$this->customs_tariff_number  = $customs_tariff_number;
		$this->customs_tariff_description  = $customs_tariff_description;
		$this->customs_consignor_reference  = $customs_consignor_reference;
		$this->customs_check_description_and_tariff = $customs_check_description_and_tariff;
	}
}
