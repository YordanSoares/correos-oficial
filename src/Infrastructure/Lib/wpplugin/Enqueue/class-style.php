<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Enqueue;

/**
 * Class for enqueue javacripts styles on WordPress.
 */
class Style extends Enqueue_File {

	/**
	 * Enqueue style file
	 *
	 * @param string $style          Style file name.
	 * @param array  $dependencies   Style files dependencies.
	 * @param mixed  $on_pages       Enqueue on this pages (string/array).
	 */
	public function enqueue(
		$style,
		$dependencies = [],
		$on_pages = 'all'
	) {

		if ( ! $this->enqueue_on_page( $on_pages ) ) {
			return;
		}

		$handle = $this->obtain_handle( $style );

		wp_enqueue_style(
			$handle,
			$this->obtain_url( $style ),
			$dependencies,
			$this->obtain_version()
		);
	}
}
