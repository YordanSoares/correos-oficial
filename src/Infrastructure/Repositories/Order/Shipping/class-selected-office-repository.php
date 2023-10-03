<?php
/**
 * Repository
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping;

use WooEnvio\WpPlugin\Repositories\Post_Meta_Repository;

/**
 *
 **/
class Selected_Office_Repository extends Post_Meta_Repository {

	const PREFIX_PRIVATE_POST_META = '_';
	const SUFIX_POST_META_NAME     = 'selected_office';

	public function __construct( $slug ) {
		$prefix = self::PREFIX_PRIVATE_POST_META . $slug;
		parent::__construct( $prefix, self::SUFIX_POST_META_NAME );
	}

	public function obtain( $order_id ) {
		$selected_office = $this->get( $order_id, true );

		if ( '' === $selected_office ) {
			return null;
		}

		return $selected_office;
	}

	public function persist( $order_id, $selected_office ) {
		$this->save( $order_id, $selected_office );
	}
}
