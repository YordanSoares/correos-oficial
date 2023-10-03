<?php
/**
 * Bulk actions
 *
 * @package wooenvio/wecorreos/Application/Bulk
 */

namespace WooEnvio\WECorreos\Application\Services\Bulk;

/**
 * Class Obtain_Merged_On_A4_Format_Request
 */
class Obtain_Merged_On_A4_Format_Request {

	/**
	 * Order ids
	 *
	 * @var array
	 */
	public $order_ids;
	/**
	 * Position in A4 page
	 *
	 * @var int
	 */
	public $position;

	/**
	 * Obtain_Merged_On_A4_Format_Request constructor.
	 *
	 * @param array $order_ids Order ids.
	 * @param int   $position Position.
	 */
	public function __construct( $order_ids, $position ) {
		$this->order_ids = $order_ids;
		$this->position  = $position;
	}
}
