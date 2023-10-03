<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Model/Settings/Sender
 */

namespace WooEnvio\WECorreos\Domain\Model\Settings\Sender;

/**
 * Class Sender_List
 */
class Sender_List {

	/**
	 * Senders
	 *
	 * @var array
	 */
	private $senders;

	/**
	 * Sender_List constructor.
	 *
	 * @param array $senders Senders.
	 */
	public function __construct( $senders ) {
		$this->senders = $senders;
	}

	/**
	 * Senders
	 *
	 * @return array
	 */
	public function senders() {
		return $this->senders;
	}

	/**
	 * Default key.
	 *
	 * @return mixed
	 */
	public function default_key() {
		$sender = $this->default_sender();

		return $sender->key();
	}

	/**
	 * Defauld sender.
	 *
	 * @return mixed
	 */
	public function default_sender() {
		$default_senders = array_filter(
			$this->senders, function( $sender ) {
				return $sender->is_default();
			}
		);

		return array_shift( $default_senders );
	}

	/**
	 * By key
	 *
	 * @param string $key Key.
	 *
	 * @return mixed
	 */
	public function by_key( $key ) {
		$senders = array_filter(
			$this->senders, function( $sender ) use ( $key ) {
				return $sender->key() === intval( $key );
			}
		);

		return array_shift( $senders );
	}

	/**
	 * Senders key alias.
	 *
	 * @return array
	 */
	public function senders_key_alias() {

		$key_alias = [];
		array_map(
			function( $sender ) use ( &$key_alias ) {
				$key_alias[ $sender->key() ] = $sender->alias();
			}, $this->senders
		);

		return $key_alias;
	}

	/**
	 * Data
	 *
	 * @return array
	 */
	public function data() {
		return array_map(
			function( $sender ) {
				return $sender->data();
			}, $this->senders
		);
	}

	/**
	 * Build default.
	 *
	 * @return static
	 */
	public static function build_default() {
		return new static( [ Sender::build_default() ] );
	}

	/**
	 * Build
	 *
	 * @param array $data Data.
	 *
	 * @return static
	 */
	public static function build( $data ) {
		$senders = array_map(
			function( $sender_data ) {
				return Sender::build( $sender_data );
			}, $data
		);

		return new static( $senders );
	}

	/**
	 * Build and validation
	 *
	 * @param array $data Data.
	 *
	 * @return static
	 * @throws \Exception Fai validation.
	 */
	public static function build_and_validate( $data ) {

		$senders = array_map(
			function( $sender_data ) {
				return Sender::build_and_validate( $sender_data );
			}, $data
		);

		$senders = new static( $senders );

		$senders->validate_or_fail();

		return $senders;
	}

	/**
	 * Validation
	 *
	 * @throws \Exception Fail validation.
	 */
	private function validate_or_fail() {
		$default_senders = array_filter(
			$this->senders, function( $sender ) {
				return $sender->is_default();
			}
		);

		if ( count( $default_senders ) > 1 ) {
			throw new \Exception( 'Only one sender default allowed' );
		}
	}
}
