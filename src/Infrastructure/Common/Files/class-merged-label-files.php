<?php
/**
 * Files
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Files;

use WooEnvio\WpPlugin\Common\Download_File;

/**
 * Class Merged_Label_Files
 */
class Merged_Label_Files extends Download_File {

	const FILE_EXTENSION  = 'pdf';
	const PREFIX          = 'merged';
	const SIMULATE_NUMBER = 'labels';

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
	 * Function
	 *
	 * @return string
	 */
	public function merged_download_link() {
		return $this->download_link( self::SIMULATE_NUMBER );
	}

	/**
	 * Function
	 *
	 * @return string
	 */
	public function merged_file_path() {
		return $this->file_path( self::SIMULATE_NUMBER );
	}
}
