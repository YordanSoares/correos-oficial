<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Enqueue;

/**
 * Class for enquue files like scripts and styles on WordPress.
 */
abstract class Enqueue_File {

	const RELATIVE_PATH_STYLES = 'app/Infrastructure/Web/Assets/';

	/**
	 * Prefix handler name.
	 *
	 * @var string
	 */
	private $prefix;

	/**
	 * File url (style or script).
	 *
	 * @var string
	 */
	private $file_url;

	/**
	 * Debug mode. Add timestamp.
	 *
	 * @var bool
	 */
	private $debug;

	/**
	 * Constructor
	 *
	 * @param string $prefix    Prefix handler name.
	 * @param string $file_url  File url (style or script).
	 * @param bool   $debug     Debug mode. Add timestamp.
	 */
	public function __construct( $prefix, $file_url, $debug ) {
		$this->prefix   = $prefix;
		$this->file_url = $file_url;
		$this->debug    = $debug;
	}

	/**
	 * Check if enqueue style or script on current page
	 *
	 * @param mixed $on_pages Enqueue on this pages (string/array).
	 * @return bool
	 */
	protected function enqueue_on_page( $on_pages ) {

		if ( is_callable( $on_pages ) ) {
			return call_user_func( $on_pages );
		}

		if ( 'all' === $on_pages ) {
			return true;
		}

		$screen = get_current_screen();

		if ( null === $screen ) {
			return false;
		}

		if ( is_array( $on_pages ) ) {
			return in_array( $screen->id, $on_pages, true );
		}

		return $on_pages === $screen->id;
	}

	/**
	 * Build handler name script/style file with prefix and file name.
	 *
	 * @param string $file File name.
	 * @return string
	 */
	protected function obtain_handle( $file ) {
		return sprintf(
			'%s_%s',
			$this->prefix,
			$this->extract_name( $file )
		);
	}

	/**
	 * Extract name of file from path file
	 *
	 * @param string $file File name.
	 * @return string
	 */
	protected function extract_name( $file ) {
		$path_parts = pathinfo( $file );
		return $path_parts['filename'];
	}

	/**
	 * Build full url to file
	 *
	 * @param string $file File name.
	 * @return string
	 */
	protected function obtain_url( $file ) {
		return sprintf(
			'%s%s',
			$this->file_url,
			$file
		);
	}

	/**
	 * Obtain version. If debug is true return timestamp.
	 *
	 * @return string
	 */
	protected function obtain_version() {
		if ( true === $this->debug ) {
			return time();
		}
		return '';
	}
}
