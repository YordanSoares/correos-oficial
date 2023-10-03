<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Customs;

use WooEnvio\WECorreos\Domain\Model\Correos\Aduanas\Declaracion_Contenido_Data;

/**
 * Class Save_Declaration_Content
 */
class Save_Declaration_Content {

	/**
	 * Declaracion_Contenido_Data
	 *
	 * @var Declaracion_Contenido_Data
	 */
	private $declaration_content_files;

	/**
	 * Save_Declaration_Content constructor.
	 *
	 * @param Declaracion_Contenido_Data $declaration_content_files Declaracion_Contenido_Data.
	 */
	public function __construct( $declaration_content_files ) {
		$this->declaration_content_files = $declaration_content_files;
	}

	/**
	 * Execute.
	 *
	 * @param mixed  $order_id ORder id.
	 * @param string $content_declaration_content content.
	 *
	 * @throws \Exception Fail.
	 */
	public function execute( $order_id, $content_declaration_content ) {
		$file_path = $this->path_file( $order_id );
		// phpcs:ignore
		if ( false === file_put_contents( $file_path, $content_declaration_content ) ) {
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
		return $this->declaration_content_files->file_path( $order_id );
	}
}
