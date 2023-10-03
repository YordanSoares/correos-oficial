<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Returns;

use WooEnvio\WECorreos\Infrastructure\Common\Files\Returns_Files;

/**
 * Class Save_Returns
 */
class Save_Returns {

	/**
	 * Returns_Files
	 *
	 * @var Returns_Files
	 */
	private $returns_files;

	/**
	 * Save_Returns constructor.
	 *
	 * @param Returns_Files $returns_files Returns_Files.
	 */
	public function __construct( $returns_files ) {
		$this->returns_files = $returns_files;
	}

	/**
	 * Execute
	 *
	 * @param mixed  $order_id Order id.
	 * @param string $content_returns Content.
	 *
	 * @throws \Exception Fail.
	 */
	public function execute( $order_id, $content_returns ) {
		$count=1;

		$time=time();
		
		if (!file_exists($this->path_file( $order_id."-".+$count))){
			$file_path = $this->path_file( $order_id."-".+$count );
		}
		else {
			while (file_exists($this->path_file( $order_id."-".+$count))){
				$count++;
				$file_path = $this->path_file( $order_id."-".+$count );
			}
		}

		// phpcs:ignore
		if ( false === file_put_contents( $file_path, $content_returns ) ) {
			throw new \Exception( __( 'Check file permissions. WECorreos plugin needs write some files.', 'correoswc' ) );
		}
	}

	/**
	 * Path file
	 *
	 * @param mixed $order_id Order id.
	 *
	 * @return string
	 */
	private function path_file( $order_id ) {
		//var_dump('DEBUG RETURNS_PATH', $this->returns_files->file_path( $order_id ));
		return $this->returns_files->file_path( $order_id );
	}
}
