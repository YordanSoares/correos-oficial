<?php
namespace WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping;

use WooEnvio\WpPlugin\Repositories\Post_Meta_Repository;

class Correos_Id_Repository extends Post_Meta_Repository {

	const PREFIX_PRIVATE_POST_META = '_';
	const SUFIX_POST_META_NAME     = 'correos_id';

	public function __construct( $slug ) {
		$prefix = self::PREFIX_PRIVATE_POST_META . $slug;
		parent::__construct( $prefix, self::SUFIX_POST_META_NAME );
	}

	public function obtain( $order_id ) {
		$correos_id = $this->get( $order_id, true );

		if ( '' === $correos_id ) {
			return null;
		}

		return $correos_id;
	}

	public function persist( $order_id, $correos_id ) {
		$this->save( $order_id, $correos_id );
	}
}
