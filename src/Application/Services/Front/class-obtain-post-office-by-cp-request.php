<?php
/**
 * Front actions
 *
 * @package wooenvio/wecorreos/Application/Front
 */

namespace WooEnvio\WECorreos\Application\Services\Front;

/**
 * Class Obtain_Post_Office_By_Cp_Request
 */
class Obtain_Post_Office_By_Cp_Request {

	/**
	 * Postal code
	 *
	 * @var string
	 */
	public $cp;

	/**
	 * Obtain_Post_Office_By_Cp_Request constructor.
	 *
	 * @param string $cp Postal code.
	 */
	public function __construct( $cp ) {
		$this->cp = $cp;
	}
}
