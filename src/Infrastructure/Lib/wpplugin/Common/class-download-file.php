<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Common;

/**
 * Download file handler
 */
class Download_File {

	/**
	 * Full base path to download dir
	 *
	 * @var string
	 */
	protected $base_path;

	/**
	 * Full base url to download dir
	 *
	 * @var string
	 */
	protected $base_url;

	/**
	 * Prefix on file name
	 *
	 * @var string
	 */
	private $prefix_file_name;

	/**
	 * File extension
	 *
	 * @var string
	 */
	private $extension;

	/**
	 * Construct
	 *
	 * @param string $wp_base_path       WordPress base path.
	 * @param string $wp_base_url        WordPress base url.
	 * @param string $download_dir       Relative download dir.
	 * @param string $prefix_file_name   Prefix on file name.
	 * @param string $extension          File extension.
	 */
	public function __construct( $wp_base_path, $wp_base_url, $download_dir, $prefix_file_name, $extension ) {

		$this->base_path = sprintf(
			'%s/%s/',
			str_replace( '//', '/', $wp_base_path ),
			$download_dir
		);

		$this->base_url = sprintf(
			'%s/%s/',
			$wp_base_url,
			$download_dir
		);

		$this->prefix_file_name = $prefix_file_name;
		$this->extension        = $extension;
	}

	/**
	 * Check if exists file
	 *
	 * @param string $post_id Post ID for identified associated file to post. (order on WooCommerce).
	 * @return bool
	 */
	public function exists( $post_id ) {
		return file_exists( $this->file_path( $post_id ) );
	}

	/**
	 * Return full file path (include file name)
	 *
	 * @param string $post_id Post ID for identified associated file to post. (order on WooCommerce).
	 * @return string
	 */
	public function file_path( $post_id ) {
		return sprintf(
			'%s%s',
			$this->base_path,
			$this->file_name( $post_id )
		);
	}

	/**
	 * Return full file url (include file name). And timestamp to avoid web cache.
	 *
	 * @param string $post_id Post ID for identified associated file to post. (order on WooCommerce).
	 * @return string
	 */
	public function download_link( $post_id ) {
		return sprintf(
			'%s%s?%s',
			$this->base_url,
			$this->file_name( $post_id ),
			time()
		);
	}

	/**
	 * Return Full base path to download dir
	 *
	 * @return string
	 */
	public function base_path() {
		return $this->base_path;
	}

	/**
	 * Return Full base url to download dir
	 *
	 * @return string
	 */
	public function base_url() {
		return $this->base_url;
	}

	/**
	 * Composing file name with prefix, post id and extension
	 *
	 * @param string $post_id Post ID for identified associated file to post. (order on WooCommerce).
	 * @return string
	 */
	private function file_name( $post_id ) {
		return sprintf(
			'%s-%s.%s',
			$this->prefix_file_name,
			$post_id,
			$this->extension
		);
	}
}
