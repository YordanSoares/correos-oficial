<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Customs
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs;

/**
 * Class Obtain_Customs_Declaration_Request
 */
class Obtain_Customs_Declaration_Request {

	/**
	 * Order id
	 *
	 * @var string
	 */
	public $order_id;

	/**
	 * View_Doc_Links_Request constructor.
	 *
	 * @param string $order_id Order id.
	 */
	public function __construct( $order_id ) {
		$this->order_id = $order_id;
	}
}
