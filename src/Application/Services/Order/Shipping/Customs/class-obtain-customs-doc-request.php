<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Customs
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs;

/**
 * Class Obtain_Customs_Doc_Request
 */
class Obtain_Customs_Doc_Request {

	/**
	 * Number of pieces
	 *
	 * @var int
	 */
	public $number_pieces;
	/**
	 * Order id
	 *
	 * @var string
	 */
	public $order_id;

	/**
	 * View_Doc_Links_Request constructor.
	 *
	 * @param int    $number_pieces Number of pieces.
	 * @param string $order_id Order id.
	 */
	public function __construct( $number_pieces, $order_id ) {
		$this->number_pieces = $number_pieces;
		$this->order_id      = $order_id;
	}
}
