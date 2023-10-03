<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Model/Settings
 */

namespace WooEnvio\WECorreos\Domain\Model\Settings;

use WooEnvio\WECorreos\Domain\Model\Settings\Sender\Sender_List;

/**
 * Class Senders
 */
class Senders {

	/**
	 * Sender list.
	 *
	 * @var array
	 */
	private $sender_list;

	/**
	 * Senders constructor.
	 *
	 * @param array $sender_list Sender list.
	 */
	public function __construct( $sender_list ) {
		$this->sender_list = $sender_list;
	}

	/**
	 * Data
	 *
	 * @return array
	 */
	public function sender_list() {
		return $this->sender_list;
	}
	/**
	 * Data
	 *
	 * @return string
	 */
	public function default_key() {
		return $this->sender_list->default_key();
	}
	/**
	 * Data
	 *
	 * @return string
	 */
	public function default_sender() {
		return $this->sender_list->default_sender();
	}
	/**
	 * Data
	 *
	 * @return string
	 */
	public function senders_key_alias() {
		return $this->sender_list->senders_key_alias();
	}

	/**
	 * Sender by key
	 *
	 * @param string $key Key.
	 *
	 * @return mixed
	 */
	public function sender_by_key( $key ) {
		return $this->sender_list->by_key( $key );
	}

	/**
	 * Data array
	 *
	 * @return string
	 */
	public function data() {
		return [
			'senders' => $this->sender_list->data(),
		];
	}

	/**
	 * Data
	 *
	 * @return static
	 */
	public static function build_default() {
		return new static( Sender_List::build_default() );
	}

	/**
	 * Data
	 *
	 * @param array $data Data.
	 *
	 * @return Sender_List
	 */
	public static function build_and_validate( $data ) {
		$sender_list = new static( Sender_List::build_and_validate( $data ) );
		return $sender_list;
	}

	/**
	 * Data
	 *
	 * @param array $data Data.
	 *
	 * @return static
	 */
	public static function build( $data ) {
		$sender_list = new static( Sender_List::build( $data ) );
		return $sender_list;
	}
}
