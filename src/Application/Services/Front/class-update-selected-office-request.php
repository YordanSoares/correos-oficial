<?php
/**
 * Front actions
 *
 * @package wooenvio/wecorreos/Application/Front
 */

namespace WooEnvio\WECorreos\Application\Services\Front;

/**
 * Class Update_Selected_Office_Request
 */
class Update_Selected_Office_Request {

	/**
	 * Order id
	 *
	 * @var string
	 */
	public $order_id;

	/**
	 * Selected office.
	 *
	 * @var string
	 */
	public $selected_office;

	/**
	 * Update_Selected_Office_Request constructor.
	 *
	 * @param string $order_id Order id.
	 * @param string $selected_office Selected office.
	 */
	public function __construct( $order_id, $selected_office ) {
		$this->order_id        = $order_id;
		$this->selected_office = $selected_office;
	}
}
