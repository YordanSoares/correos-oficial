<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Customs
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs;

/**
 * Class View_Customs_Request
 */
class View_Customs_Request {

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
