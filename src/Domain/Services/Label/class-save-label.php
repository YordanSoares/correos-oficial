<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Label;

use WooEnvio\WECorreos\Infrastructure\Common\Files\Label_Files;

/**
 * Class Save_Label
 */
class Save_Label {

	/**
	 * Label files
	 *
	 * @var Label_Files
	 */
	private $label_files;

	/**
	 * Save_Label constructor.
	 *
	 * @param string $slug Slug.
	 */
	public function __construct( $slug ) {
		$this->label_files = new Label_Files( $slug );
	}

	/**
	 * Execute
	 *
	 * @param mixed  $order_id Order id.
	 * @param string $content_label content.
	 *
	 * @throws \Exception Fail save file.
	 */
	public function execute( $order_id, $content_label ) {
		$file_path = $this->path_file( $order_id );
		// phpcs:ignore
		if ( false === file_put_contents( $file_path, $content_label ) ) {
			throw new \Exception( __( 'Check file permissions. WECorreos plugin needs write some files.', 'correoswc' ) );
		}
	}

	/**
	 * Path file.
	 *
	 * @param mixed $order_id Order id.
	 * @return string
	 */
	private function path_file( $order_id ) {
		return $this->label_files->file_path( $order_id );
	}
}
