<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Customs;

use WooEnvio\WECorreos\Infrastructure\Common\Files\Customs_Ddp_Files;

/**
 * Class Save_Ddp
 */
class Save_Ddp {

	/**
	 * Customs_Ddp_Files
	 *
	 * @var Customs_Ddp_Files
	 */
	private $ddp_files;

	/**
	 * Save_Ddp constructor.
	 *
	 * @param Customs_Ddp_Files $ddp_files Customs_Ddp_Files.
	 */
	public function __construct( $ddp_files ) {
		$this->ddp_files = $ddp_files;
	}

	/**
	 * Execute
	 *
	 * @param mixed  $order_id Order id.
	 * @param string $ddp_content Content.
	 *
	 * @throws \Exception Fail.
	 */
	public function execute( $order_id, $ddp_content ) {
		$file_path = $this->path_file( $order_id );
		// phpcs:ignore
		if ( false === file_put_contents( $file_path, $ddp_content ) ) {
			throw new \Exception( __( 'Check file permissions. WECorreos plugin needs write some files.', 'correoswc' ) );
		}
	}

	/**
	 * Funciont
	 *
	 * @param mixed $order_id Order id.
	 *
	 * @return string
	 */
	private function path_file( $order_id ) {
		return $this->ddp_files->file_path( $order_id );
	}
}
