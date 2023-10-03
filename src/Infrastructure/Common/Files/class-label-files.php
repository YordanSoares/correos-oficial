<?php
/**
 * Files
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Files;

use WooEnvio\WpPlugin\Common\Download_File;

/**
 * Class Label_Files
 */
class Label_Files extends Download_File {

	const FILE_EXTENSION = 'pdf';
	const PREFIX         = 'label';

	/**
	 * Constructor.
	 *
	 * @param string $slug Slug.
	 */
	public function __construct( $slug ) {

		$download_dir     = $slug;
		$prefix_file_name = sprintf( '%s-%s', $slug, self::PREFIX );

		parent::__construct(
			wp_upload_dir()['basedir'],
			wp_upload_dir()['baseurl'],
			$download_dir,
			$prefix_file_name,
			self::FILE_EXTENSION
		);
	}

	/**
	 * Function.
	 *
	 * @throws \Exception Fail write permissions.
	 */
	public function create_download_base_path_or_fail() {
		if ( ! wp_mkdir_p( $this->base_path() ) ) {
			throw new \Exception( __( 'Can not create a folder. Check write permissions.', 'starterplugin' ) );
		}

	}

	/**
	 * Function.
	 *
	 * @param mixed $order_id Order id.
	 *
	 * @return string|null
	 */
	public function link( $order_id ) {
		if ( ! $this->exists( $order_id ) ) {
			return null;
		}

		return $this->download_link( $order_id );
	}
}
