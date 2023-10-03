<?php
namespace WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Returns;

use WooEnvio\WpPlugin\Repositories\Post_Meta_Repository;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns\Returns;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns\Returns_Sender;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns\Returns_Recipient;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Package\Package_List;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Package\Package;

class Returns_Repository extends Post_Meta_Repository {

	const PREFIX_PRIVATE_POST_META = '_';
	const SUFIX_POST_META_NAME     = 'order_returns';
	const DEFAULT_COST             = 0.0;

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

		return new Returns(
			$data['recipient_key'],
			$this->returns_sender( $data ),
			$this->returns_recipient( $data ),
			self::DEFAULT_COST,
			$data['return_ccc'],
			$package_list
		);
	}

	private function returns_sender( $data ) {
		return new Returns_Sender(
			$data['sender_first_name'],
			$data['sender_last_name'],
			$data['sender_dni'],
			$data['sender_company'],
			$data['sender_contact'],
			$data['sender_address'],
			$data['sender_city'],
			$data['sender_state'],
			$data['sender_cp'],
			$data['sender_phone'],
			$data['sender_email']
		);
	}

	private function returns_recipient( $data ) {
		return new Returns_Recipient(
			$data['recipient_first_name'],
			$data['recipient_last_name'],
			$data['recipient_dni'],
			$data['recipient_company'],
			$data['recipient_contact'],
			$data['recipient_address'],
			$data['recipient_city'],
			$data['recipient_state'],
			$data['recipient_cp'],
			$data['recipient_phone'],
			$data['recipient_email']
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

	public function persist( $order_id, $returns ) {
		$this->save( $order_id, $returns->data() );
	}
}
