<?php
/**
 * Bulk actions
 *
 * @package wooenvio/wecorreos/Application/Bulk
 */

namespace WooEnvio\WECorreos\Application\Services\Bulk;

/**
 * Class Obtain_Manifiest_Request
 */
class Obtain_Manifiest_Request {

	/**
	 * Order ids
	 *
	 * @var array
	 */
	public $order_ids;

	/**
	 * Obtain_Manifiest_Request constructor.
	 *
	 * @param array $order_ids Order ids.
	 */
	public function __construct( $order_ids ) {
		$this->order_ids = $order_ids;
	}
}
