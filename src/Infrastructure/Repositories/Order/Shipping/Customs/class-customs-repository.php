<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Customs;

use WooEnvio\WpPlugin\Repositories\Post_Meta_Repository;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Customs\Customs;

class Customs_Repository extends Post_Meta_Repository {

	const PREFIX_PRIVATE_POST_META = '_';
	const SUFIX_POST_META_NAME     = 'order_customs';

	public function __construct( $slug ) {
		$prefix = self::PREFIX_PRIVATE_POST_META . $slug;
		parent::__construct( $prefix, self::SUFIX_POST_META_NAME );
	}

	public function obtain( $order_id ) {
		$data = $this->get( $order_id, true );

		if ( empty( $data ) ) {
			return null;
		}

		return new Customs( $data['number_pieces'] );
	}

	public function persist( $order_id, $customs ) {
		$this->save( $order_id, $customs->data() );
	}
}
