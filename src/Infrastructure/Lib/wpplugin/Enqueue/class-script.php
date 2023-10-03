<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Enqueue;

/**
 * Class for enqueue javacripts scripts on WordPress.
 */
class Script extends Enqueue_File {

	/**
	 * Enqueue script file
	 *
	 * @param string $script         Script file name.
	 * @param array  $dependencies   Script files dependencies.
	 * @param mixed  $ajax_name      Variable name on javascript injection.  (null/string).
	 * @param array  $ajax_data      Value of injected variable on javascript.  (null/array).
	 * @param mixed  $on_pages       Enqueue on this pages (string/array).
	 */
	public function enqueue(
		$script,
		$dependencies = [],
		$ajax_name = null,
		$ajax_data = null,
		$on_pages = 'all'
	) {

		if ( ! $this->enqueue_on_page( $on_pages ) ) {
			return;
		}

		$handle = $this->obtain_handle( $script );

		wp_enqueue_script(
			$handle,
			$this->obtain_url( $script ),
			$dependencies,
			$this->obtain_version(),
			true
		);

		if ( null !== $ajax_name && null !== $ajax_data ) {

			wp_localize_script(
				$handle,
				$ajax_name,
				$ajax_data
			);
		}
	}
}
