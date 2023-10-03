<?php
namespace WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Label;

use WooEnvio\WpPlugin\Repositories\Post_Meta_Repository;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Package\Package_List;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Package\Package;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Label;

class Label_Repository extends Post_Meta_Repository {

	const PREFIX_PRIVATE_POST_META = '_';
	const SUFIX_POST_META_NAME     = 'order_preregister';

	public function __construct( $slug ) {
		$prefix = self::PREFIX_PRIVATE_POST_META . $slug;
		parent::__construct( $prefix, self::SUFIX_POST_META_NAME );
	}

	public function obtain( $order_id ) {
		$data = $this->get( $order_id, true );

		if ( empty( $data ) ) {
			return null;
		}

		$package_list = $this->obtain_package_list( $data );

		return new Label(
			$data['sender_key'],
			$data['observations'],
			$data['insurance'],
			isset( $data['first_item_value'] ) ? $data['first_item_value'] : '0',
			isset( $data['first_item_description'] ) ? $data['first_item_description'] : '0',
			$package_list,
			$data['customs_tariff_number'],
			$data['customs_consignor_reference']
		);
	}

	private function obtain_package_list( $data ) {

		if ( ! isset( $data['packages'] ) ) {
			return $this->obtain_package_list_old_data( $data );
		}

		return Package_List::build( $data['packages'] );
	}

	private function obtain_package_list_old_data( $data ) {

		$data['key'] = Package::DEFAULT_KEY;

		$package = Package::build( $data );

		$package_list = [ $package ];

		return new Package_List( $package_list );
	}

	public function persist( $order_id, $label ) {
		$this->save( $order_id, $label->data() );
	}
}
