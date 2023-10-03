<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Customs;

use WooEnvio\WECorreos\Infrastructure\Common\Files\Customs_Dua_Files;

/**
 * Class Save_Dua
 */
class Save_Dua {

	/**
	 * Customs_Dua_Files
	 *
	 * @var Customs_Dua_Files
	 */
	private $dua_files;

	/**
	 * Save_Dua constructor.
	 *
	 * @param Customs_Dua_Files $dua_files Customs_Dua_Files.
	 */
	public function __construct( $dua_files ) {
		$this->dua_files = $dua_files;
	}

	/**
	 * Execute.
	 *
	 * @param mixed  $order_id ORder id.
	 * @param string $dua_content content.
	 *
	 * @throws \Exception Fail.
	 */
	public function execute( $order_id, $dua_content ) {
		$file_path = $this->path_file( $order_id );
		// phpcs:ignore
		if ( false === file_put_contents( $file_path, $dua_content ) ) {
			throw new \Exception( __( 'Check file permissions. WECorreos plugin needs write some files.', 'correoswc' ) );
		}
	}

	/**
	 * Path
	 *
	 * @param mixed $order_id ORder id.
	 * @return string
	 */
	private function path_file( $order_id ) {
		return $this->dua_files->file_path( $order_id );
	}
}
