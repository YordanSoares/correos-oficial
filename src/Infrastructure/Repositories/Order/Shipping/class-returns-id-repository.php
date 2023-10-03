<?php
namespace WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping;

use WooEnvio\WpPlugin\Repositories\Post_Meta_Repository;

class Returns_Id_Repository extends Post_Meta_Repository {

	const PREFIX_PRIVATE_POST_META = '_';
	const SUFIX_POST_META_NAME     = 'returns_id';

	public function __construct( $slug ) {
		$prefix = self::PREFIX_PRIVATE_POST_META . $slug;
		parent::__construct( $prefix, self::SUFIX_POST_META_NAME );
	}

	public function obtain( $order_id ) {
		$returns_id = $this->get( $order_id, true );

		if ( '' === $returns_id ) {
			return null;
		}

		return $returns_id;
	}

	public function persist( $order_id, $returns_id ) {
		$this->save( $order_id, $returns_id );
	}
}
