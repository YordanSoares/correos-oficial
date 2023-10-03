<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Order;

use WooEnvio\WcPlugin\Common\Shipping_Config;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;
use WooEnvio\WECorreos\Domain\Model\Settings\Sender\Sender;

/**
 * Class Order_Available_Shippings
 */
class Order_Available_Shippings {

	const SPAIN    = 'ES';
	const ANDORRA  = 'AD';
	const PORTUGAL = 'PT';

	/**
	 * Country_sender
	 *
	 * @var string
	 */
	private $country_sender;
	/**
	 * State_sender
	 *
	 * @var string
	 */
	private $state_sender;
	/**
	 * Shipping_config
	 *
	 * @var Shipping_Config
	 */
	private $shipping_config;

	/**
	 * Order_Available_Shippings constructor.
	 *
	 * @param string          $country_sender Country_sender.
	 * @param string          $state_sender State_sender.
	 * @param Shipping_Config $shipping_config Shipping_Config.
	 */
	public function __construct( $country_sender, $state_sender, $shipping_config ) {
		$this->country_sender  = $country_sender;
		$this->state_sender    = $state_sender;
		$this->shipping_config = $shipping_config;
	}

	/**
	 * Function
	 *
	 * @param Order $order Order.
	 *
	 * @return |null
	 */
	public function execute( $order ) {

		if ( ! $this->address_well_formed( $order) ) {
			return null;
		}

		if ( $this->is_international( $order) ) {
			return $this->international_shippings();
		}

		return $this->national_shippings();
	}

	/**
	 * Function
	 *
	 * @param Order $order Order.
	 *
	 * @return bool
	 */
	private function address_well_formed( $order ) {
		$country_recipient = $order->get_shipping_country();
		$state_recipient   = $order->get_shipping_state();
		if ( empty( $country_recipient) || empty( $state_recipient) ) {
			return false;
		}

		return true;
	}

	/**
	 * Function
	 *
	 * @param Order $order Order.
	 *
	 * @return bool
	 */
	private function is_international( $order ) {

		$country_recipient = $order->get_shipping_country();

		if ( self::ANDORRA === $this->country_sender && self::SPAIN === $country_recipient ) {
			return false;
		}

		if ( self::ANDORRA === $country_recipient && self::SPAIN === $this->country_sender ) {
			return false;
		}

		if ( self::PORTUGAL === $this->country_sender && self::SPAIN === $country_recipient ) {
			return false;
		}

		if ( self::PORTUGAL === $country_recipient && self::SPAIN === $this->country_sender ) {
			return false;
		}

		return $this->country_sender !== $country_recipient;
	}

	/**
	 * Function
	 *
	 * @return array
	 */
	private function international_shippings() {
		$international_shippings = [ 'international', 'paqlightinternational' ];
		return array_intersect_key( $this->shipping_config->config_list(), array_flip( $international_shippings));
	}

	/**
	 * Function
	 *
	 * @return array
	 */
	private function national_shippings() {
		$national_shippings = [ 'paq48office', 'paq48home', 'paq48citypaq', 'paq72office', 'paq72home', 'paq72citypaq' ];
		return array_intersect_key( $this->shipping_config->config_list(), array_flip( $national_shippings));
	}

	/**
	 * Function
	 *
	 * @param Sender          $sender Sender.
	 * @param Shipping_Config $shipping_config Shipping_Config.
	 *
	 * @return static
	 */
	public static function build( $sender, $shipping_config ) {
		return new static(
			$sender->country(),
			$sender->state(),
			$shipping_config
		);
	}

	/**
	 * Function
	 *
	 * @return bool|mixed|string|void
	 */
	private static function country_from_woocommerce() {
		$shop_location = get_option( 'woocommerce_default_country' );

		if ( strpos( $shop_location, ':' ) !== false ) {
			$country = explode( ':', $shop_location )[0];
		} else {
			$country = $shop_location;
		}

		return $country;
	}
}
