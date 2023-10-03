<?php
/**
 * Files
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Files;

use WooEnvio\WpPlugin\Common\Download_File;

/**
 * Class Customs_Dua_Files
 */
class Customs_Dua_Files extends Download_File {

	const FILE_EXTENSION = 'pdf';
	const PREFIX         = 'dua';

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
}
