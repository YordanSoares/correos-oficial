<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Order;

use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Selected_Office_Repository;
use function WooEnvio\WECorreos\Citypaq\Order\update_address_order_from_citypaq;
use function WooEnvio\WECorreos\Citypaq\Order\update_address_order_from_postoffice;
use function WooEnvio\WECorreos\Citypaq\OrderMeta\update_citypaq_code;
use function WooEnvio\WECorreos\Citypaq\CorreosWs\ByCode\obtain_citypaq_by_code;
use function WooEnvio\WECorreos\Postoffice\OrderMeta\update_postoffice_code;
use function WooEnvio\WECorreos\Postoffice\WebService\obtain_postoffice_by_code;
use const WooEnvio\WECorreos\Citypaq\Options\NONE_CITY_PAQ_SELECTED;
use const WooEnvio\WECorreos\Postoffice\Options\NONE_POSTOFFICE_SELECTED;

/**
 * Class Force_Order_Shipping
 */
class Force_Order_Shipping {

	/**
	 * Selected_Office_Repository
	 *
	 * @var Selected_Office_Repository
	 */
	private $repository;

	/**
	 * Force_Order_Shipping constructor.
	 *
	 * @param Selected_Office_Repository $repository Selected_Office_Repository.
	 */
	public function __construct( $repository ) {
		$this->repository = $repository;
	}

	/**
	 * Function
	 *
	 * @param \WC_Order $wc_order WC_Order.
	 * @param string    $correos_type Correos type.
	 * @param array     $args Args.
	 *
	 * @throws \Exception Fail.
	 */
	public function change_to( $wc_order, $correos_type, $args = [] ) {
		$this->guard_selected_office( $correos_type, $args);
		$this->guard_selected_citypaq( $correos_type, $args);

		$current_shipping = $this->current_shipping( $wc_order);

		if ( is_null( $current_shipping) ) {
			$this->create_new_shipping( $wc_order, $args);
			return;
		}

		$this->update_shipping( $wc_order, $current_shipping, $args);
	}

	/**
	 * Function
	 *
	 * @param string $correos_type Correos type.
	 * @param array  $args Args.
	 *
	 * @throws \Exception Fail.
	 */
	private function guard_selected_office( $correos_type, $args ) {
		if ( ! $this->is_office_shipping( $correos_type) ) {
			return;
		}

		if ( ! isset( $args['selected_office']) || NONE_POSTOFFICE_SELECTED === $args['selected_office'] ) {
			throw new \Exception( __( 'Select an office please', 'correoswc' ) );
		}
	}

	/**
	 * Function
	 *
	 * @param string $correos_type Correos type.
	 * @param array  $args Args.
	 *
	 * @throws \Exception Fail.
	 */
	private function guard_selected_citypaq( $correos_type, $args ) {
		if ( ! $this->is_citypaq_shipping( $correos_type) ) {
			return;
		}

		if ( ! isset( $args['selected_citypaq']) || NONE_CITY_PAQ_SELECTED === $args['selected_citypaq'] ) {
			throw new \Exception( __( 'Select an citypaq please', 'correoswc' ) );
		}
	}

	/**
	 * Function
	 *
	 * @param string $correos_type Correos type.
	 *
	 * @return bool
	 */
	private function is_office_shipping( $correos_type ) {
		$office_shippings = [ 'paq48office', 'paq72office' ];
		return in_array( $correos_type, $office_shippings, true);
	}

	/**
	 * Function
	 *
	 * @param string $correos_type Correos type.
	 *
	 * @return bool
	 */
	private function is_citypaq_shipping( $correos_type ) {
		$citypaq_shippings = [ 'paq48citypaq', 'paq72citypaq' ];
		return in_array( $correos_type, $citypaq_shippings, true);
	}

	/**
	 * Function
	 *
	 * @param \WC_Order $wc_order WC_Order.
	 *
	 * @return mixed|null
	 */
	private function current_shipping( $wc_order ) {
		$shipping_lines = $wc_order->get_shipping_methods();
		if ( empty( $shipping_lines) ) {
			return null;
		}
		$method = array_shift( $shipping_lines );
		return $method;
	}

	/**
	 * Function
	 *
	 * @param \WC_Order $wc_order WC_Order.
	 * @param array     $args Args.
	 */
	private function create_new_shipping( $wc_order, $args ) {

		$item = new \WC_Order_Item_Shipping();

		$item->set_props([
			'method_id' => $args['correos_type'],
			'label'     => 'Correos',
		]);
		$wc_order->add_item( $item);
		$wc_order->save();
		$this->save_selected_office( $wc_order, $args);
		$this->save_selected_citypaq( $wc_order, $args);
	}

	/**
	 * Function
	 *
	 * @param \WC_Order $wc_order WC_Order.
	 * @param string    $current_shipping Current shipping.
	 * @param array     $args Args.
	 */
	private function update_shipping( $wc_order, $current_shipping, $args ) {
		$current_shipping->set_method_id( $args['correos_type']);
		$current_shipping->save();
		$this->save_selected_office( $wc_order, $args);
		$this->save_selected_citypaq( $wc_order, $args);
	}

	/**
	 * Function
	 *
	 * @param \WC_Order $wc_order WC_Order.
	 * @param array     $args Args.
	 */
	public function save_selected_office( $wc_order, $args ) {
		$selected_office = $args['selected_office'];
		$correos_type    = $args['correos_type'];
		if ( ! $this->is_office_shipping( $correos_type) ) {
			return;
		}
		update_postoffice_code( $wc_order->get_id(), $selected_office );

		$postoffice = obtain_postoffice_by_code( $selected_office);
		update_address_order_from_postoffice( $wc_order, $postoffice);
		$wc_order->save();
	}

	/**
	 * Function
	 *
	 * @param \WC_Order $wc_order WC_Order.
	 * @param array     $args Args.
	 */
	public function save_selected_citypaq( $wc_order, $args ) {
		 $selected_citypaq = $args['selected_citypaq'];
		$correos_type      = $args['correos_type'];
		if ( ! $this->is_citypaq_shipping( $correos_type) ) {
			return;
		}

		update_citypaq_code( $wc_order->get_id(), $selected_citypaq);

		$citypaq = obtain_citypaq_by_code( $selected_citypaq);
		update_address_order_from_citypaq( $wc_order, $citypaq);
		$wc_order->save();
	}
}
