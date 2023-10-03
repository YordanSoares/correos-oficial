<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Order;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns\Returns_Recipient;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns\Returns_Sender;
use WooEnvio\WECorreos\Domain\Model\Settings\Sender\Sender;

/**
 * Class Order_Needs_Customs
 */
class Order_Needs_Customs {

	const SPAIN    = 'ES';
	const ANDORRA  = 'AD';
	const PORTUGAL = 'PT';

	/**
	 *  Evolutivo DNI Obligatorio y Documentación Aduanera
	 *  El origen y destino es Canarias no necesita tramites aduaneros..
	 *  @author A649437
	 */
	const CEUTA    = 'CE';
	const MELILLA  = 'ML';

	/**
	 * Origin country
	 *
	 * @var string
	 */
	private $origin_country;
	/**
	 * Origin state
	 *
	 * @var string
	 */
	private $origin_state;

	/**
	 * Order_Needs_Customs constructor.
	 *
	 * @param string $country_sender Country_sender.
	 * @param string $state_sender State_sender.
	 */
	public function __construct( $country_sender, $state_sender ) {
		$this->origin_country = $country_sender;
		$this->origin_state   = $state_sender;
	}

	/**
	 * Function
	 *
	 * @param Order $order Order.
	 *
	 * @return bool
	 */
	public function execute( $order ) {

		if ( $this->is_international_correos_shipping( $order) ) {
			return true;
		}

		$destination_country = $order->get_shipping_country();
		$destination_state   = $order->get_shipping_state();

		return $this->need_customs( $destination_country, $destination_state );
	}

	/**
	 * Function
	 *
	 * @param Returns_Recipient $returns_recipient Returns_Recipient.
	 *
	 * @return mixed
	 */
	public function execute_from_returns( $returns_recipient ) {
		$destination_country = static::country_from_woocommerce();
		$destination_state   = $returns_recipient->state();

		return $this->need_customs( $destination_country, $destination_state );
	}

	/**
	 * Function
	 *
	 * @param string $destination_country Country_recipient.
	 * @param string $destination_state Destination state.
	 * State_recipient.
	 *
	 * @return bool
	 */
	private function need_customs( $destination_country, $destination_state ) {
		if ( $this->shipping_not_needs_customs( $destination_country, $destination_state) ) {
			return false;
		}
		if ( $this->shipping_needs_customs( $destination_country, $destination_state) ) {
			return true;
		}
		return false;
	}

	/**
	 * Function
	 *
	 * @param Sender $sender Sender.
	 *
	 * @return static
	 */
	public static function build( $sender ) {
		return new static(
			$sender->country(),
			$sender->state()
		);
	}

	/**
	 * Function
	 *
	 * @param Returns_Sender $returns_sender Returns_Sender.
	 * @param \WC_Order      $order WC_Order.
	 *
	 * @return Order_Needs_Customs
	 */
	public static function build_from_returns_sender_and_order( $returns_sender, $order ) {
		return new self(
			$order->get_shipping_country(),
			$returns_sender->state()
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

	/**
	 * Function
	 *
	 * @param Order $order Order.
	 *
	 * @return bool
	 */
	private function is_international_correos_shipping( $order ) {
		$shipping = $order->shipping_method_id();

		$international_shippings = [ 'international', 'paqlightinternational' ];

		return in_array( $shipping, $international_shippings, true );
	}

	/**
	 * Check if shipping not needs customs docs.
	 *
	 * @param string $destination_country Destination country.
	 * @param string $destination_state   Destination state.
	 * @return bool
	 */
	private function shipping_not_needs_customs( $destination_country, $destination_state ) {

		if ( $this->same_origin_and_destination( $destination_country, $destination_state ) ) {
			return true;
		}
		if ( $this->spain_except_canary_island_to_portugal( $destination_country ) ) {
			return true;
		}
		if ( self::ANDORRA === $this->origin_country && self::ANDORRA === $destination_country ) {
			return true;
		}
		/**
		 *  Evolutivo DNI Obligatorio y Documentación Aduanera
		 *  El origen y destino es Canarias no necesita tramites aduaneros..
		 *  @author A649437
		 */
		if ($this->is_canary_island_state($this->origin_state) && $this->is_canary_island_state($destination_state) ){
			return true;
		}
		return false;
	}

	/**
	 * Check origin and destination
	 *
	 * @param string $destination_country Destination country.
	 * @param string $destination_state   Destination state.
	 * @return bool
	 */
	private function same_origin_and_destination( $destination_country, $destination_state ) {
		if ( $this->origin_country !== $destination_country ) {
			return false;
		}
		if ( $this->origin_state !== $destination_state ) {
			return false;
		}
		return true;
	}

	/**
	 * Check origin spain except canary island to portugal
	 *
	 * @param string $destination_country Destination country.
	 * @return bool
	 */
	private function spain_except_canary_island_to_portugal( $destination_country ) {
		if ( self::SPAIN !== $this->origin_country || self::PORTUGAL !== $destination_country ) {
			return false;
		}
		return false === $this->is_canary_island_state( $this->origin_state);
	}

	/**
	 * Check origin spain canary island to portugal
	 *
	 * @param string $destination_country Destination country.
	 * @return bool
	 */
	private function spain_canary_island_to_portugal( $destination_country ) {
		if ( self::SPAIN !== $this->origin_country || self::PORTUGAL !== $destination_country ) {
			return false;
		}
		return $this->is_canary_island_state( $this->origin_state);
	}

	/**
	 * Check if shipping needs customs docs.
	 *
	 * @param string $destination_country Destination country.
	 * @return bool
	 * 
	 *  Evolutivo DNI Obligatorio y Documentación Aduanera
	 *  El origen y destino es Canarias no necesita tramites aduaneros..
	 *  @author A649437
	 */
	private function shipping_needs_customs( $destination_country, $destination_state ) {
		if ( $this->origin_country !== $destination_country ) {
			return true;
		}
		// Si el destino y el origen es el Canarias
		if ( $this->is_canary_island_state( $this->origin_state) || 
		    $this->is_canary_island_state( $destination_state)) {
			return true;
		}
		if ( self::ANDORRA === $this->origin_country ) {
			return true;
		}
		if ( self::ANDORRA === $destination_country ) {
			return true;
		}
		/**
		 * ini
		 * Evolutivo DNI Obligatorio y Documentación Aduanera
		 * Si el origen o destino es Ceuta.
		 */
		if ( self::CEUTA == $destination_state || self::CEUTA == $this->origin_state ) {
			return true;
		}
		if ( self::MELILLA == $destination_state || self::MELILLA == $this->origin_state) {
			return true;
		}
		// fin
		return false;
	}

	/**
	 * Check if canary island state
	 *
	 * @param string $state State.
	 * @return bool
	 */
	private function is_canary_island_state( $state ) {
		return in_array( $state, [ 'GC', 'TF' ], true );
	}
}
