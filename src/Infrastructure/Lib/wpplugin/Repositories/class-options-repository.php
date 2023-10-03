<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Repositories;

/**
 * Class for save data on table wp_options
 */
abstract class Options_Repository {

	/**
	 * Option name builded with prefix and name.
	 *
	 * @var string
	 */
	private $option_name;

	/**
	 * Constructor
	 *
	 * @param string $prefix    Prefix to option name.
	 * @param string $name      Suffix option name.
	 */
	public function __construct( $prefix, $name ) {
		$this->option_name = $prefix . '_' . $name;
	}

	/**
	 * Obtain value of WordPress option
	 *
	 * @return mixed
	 */
	public function get() {
		return get_option( $this->option_name, [] );
	}

	/**
	 * Save value on WordPress option
	 *
	 * @param mixed $data  Value data.
	 */
	public function save( $data ) {
		update_option( $this->option_name, $data );
	}
}
