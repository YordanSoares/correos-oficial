<?php // phpcs:ignoreFile
/**
 * WooEnvio WcPlugin package file.
 *
 * @package WooEnvio\WcPlugin
 */

namespace WooEnvio\WcPlugin\Common;

/**
 * Config abstract base
 */
abstract class Config {

	/**
	 * Config params.
	 *
	 * @var array
	 */
	protected $config = [];

	/**
	 * Constructor
	 *
	 * @param string $path Full path dir with all config files.
	 */
	public function __construct( $path ) {

		if ( ! is_dir( $path ) ) {
			return;
		}

		$dir_iterator = new \RecursiveDirectoryIterator( $path );

		foreach ( new \RecursiveIteratorIterator( $dir_iterator ) as $file ) {
			if ( $this->is_php_config_file( $file ) ) {
				$this->config[] = require $file->getPathname();
			}
		}
	}

	/**
	 * Return config list
	 *
	 * @return array Config list.
	 */
	public function config_list() {
		$config_list = [];

		array_map(
			function( $element ) use ( &$config_list ) {
				if ( is_array( $element ) ) {
					$id                 = $element['id'];
					$config_list[ $id ] = $element;
				}
			}, $this->config
		);

		return $config_list;
	}

	/**
	 * Obtain ids list.
	 *
	 * @return array    Ids list.
	 */
	public function ids() {
		return array_column( $this->config, 'id' );
	}

	/**
	 * Obtain x config for Id x
	 *
	 * @param string $id Id x.
	 * @return mixed     Null|array.
	 */
	abstract public function of_id( $id );

	/**
	 * Check if file is config file
	 *
	 * @param string $file Full path to file.
	 * @return bool
	 */
	private function is_php_config_file( $file ) {
		if ( 'php' !== $file->getExtension() ) {
			return false;
		}

		if ( false === strpos( $file->getFilename(), '.config' ) ) {
			return false;
		}

		return true;
	}
}
