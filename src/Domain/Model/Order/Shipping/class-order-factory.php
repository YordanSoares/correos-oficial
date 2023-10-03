<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Order/Shipping/Order
 */

namespace WooEnvio\WECorreos\Domain\Model\Order\Shipping;

use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Selected_Office_Repository;
use function WooEnvio\WECorreos\Citypaq\OrderMeta\get_citypaq_code;

/**
 * Class Order_Factory
 *
 * @package WooEnvio\WECorreos\Domain\Model\Order\Shipping
 */
class Order_Factory {

	/**
	 * Selected_office_repository
	 *
	 * @var Selected_Office_Repository
	 */
	private $selected_office_repository;
	/**
	 * Shipping_method
	 *
	 * @var string
	 */
	private $shipping_method;
	/**
	 * Payment_method
	 *
	 * @var string
	 */
	private $payment_method;

	/**
	 * Order_Factory constructor.
	 *
	 * @param string                     $shipping_method Shipping_method.
	 * @param string                     $payment_method Payment_method.
	 * @param Selected_Office_Repository $selected_office_repository Selected_Office_Repository.
	 */
	public function __construct( $shipping_method, $payment_method, $selected_office_repository ) {
		$this->shipping_method            = $shipping_method;
		$this->payment_method             = $payment_method;
		$this->selected_office_repository = $selected_office_repository;
	}

	/**
	 * Build
	 *
	 * @param mixed $order_id Order id.
	 *
	 * @return Order|null
	 */
	public function build( $order_id ) {
		$wc_order = wc_get_order( $order_id );

		if ( false === $wc_order ) {
			return null;
		}

		$shipping = $this->obtain_shipping_method( $wc_order );

		$payment = $this->obtain_payment_method( $wc_order );

		$selected_office = $this->selected_office_repository->obtain( $order_id );

		$selected_citypaq = get_citypaq_code( $order_id );

		return new Order( $wc_order, $shipping, $payment, $selected_office, $selected_citypaq );
	}

	/**
	 * Shpping method from order.
	 *
	 * @param \WC_Order $wc_order Order.
	 *
	 * @return string
	 */
	private function obtain_shipping_method( $wc_order ) {
		$methods = $wc_order->get_shipping_methods();

		$method = array_shift( $methods );

		$method_id = explode( ':', $method['method_id'] )[0];

		return $this->shipping_method->of_id( $method_id );
	}

	/**
	 * Payment method from order.
	 *
	 * @param \WC_Order $wc_order Order.
	 *
	 * @return string
	 */
	private function obtain_payment_method( $wc_order ) {
		$method_id = $wc_order->get_payment_method();

		return $this->payment_method->of_id( $method_id );
	}
}
