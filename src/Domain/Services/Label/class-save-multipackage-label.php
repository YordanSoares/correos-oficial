<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Label;

use WooEnvio\WECorreos\Domain\Services\Bulk\Merge_Labels;
use WooEnvio\WECorreos\Infrastructure\Common\Files\Label_Files;

/**
 * Class Save_Multipackage_Label
 */
class Save_Multipackage_Label {

	/**
	 * Label_Files
	 *
	 * @var Label_Files
	 */
	private $label_files;
	/**
	 * Merge_Labels
	 *
	 * @var Merge_Labels
	 */
	private $merge_labels;

	/**
	 * Save_Multipackage_Label constructor.
	 *
	 * @param string       $slug Slug.
	 * @param Merge_Labels $merge_labels Merge_Labels.
	 */
	public function __construct( $slug, $merge_labels ) {
		$this->label_files  = new Label_Files( $slug );
		$this->merge_labels = $merge_labels;
	}

	/**
	 * Execute
	 *
	 * @param mixed  $order_id Order id.
	 * @param string $content_package_list Content_package_list.
	 */
	public function execute( $order_id, $content_package_list ) {

		$package_ids = $this->generate_package_files( $order_id, $content_package_list );

		$this->merge_package_files_to_label_file( $order_id, $package_ids );

		$this->delete_package_files( $package_ids );

	}

	/**
	 * Generate_package_files
	 *
	 * @param mixed  $order_id Order id.
	 * @param string $content_package_list Content_package_list.
	 *
	 * @return mixed
	 */
	private function generate_package_files( $order_id, $content_package_list ) {

		$package_ids = $this->package_ids( $order_id, count( $content_package_list ) );

		array_map(
			function( $package_id, $contenct ) {

				$path = $this->path_package_file( $package_id );
				// phpcs:ignore
				if ( false === file_put_contents( $path, $contenct ) ) {
					throw new \Exception( __( 'Check file permissions. WECorreos plugin needs write some files.', 'correoswc' ) );
				}
			}, $package_ids, $content_package_list
		);

		return $package_ids;
	}

	/**
	 * Package_ids
	 *
	 * @param mixed $order_id Order id.
	 * @param int   $num_packages Packages.
	 *
	 * @return mixed
	 */
	private function package_ids( $order_id, $num_packages ) {

		for ( $num = 0; $num < $num_packages; $num++ ) {
			$package_ids[] = sprintf( '%s-tmp-%s', $order_id, $num );
		}

		return $package_ids;
	}

	/**
	 * Path_package_file
	 *
	 * @param string $package_id Package id.
	 *
	 * @return string
	 */
	private function path_package_file( $package_id ) {
		return $this->label_files->file_path( $package_id );
	}

	/**
	 * Merge_package_files_to_label_file
	 *
	 * @param mixed $order_id Order id.
	 * @param array $package_ids packages ids.
	 */
	private function merge_package_files_to_label_file( $order_id, $package_ids ) {

		$this->merge_labels->labeler_format( $package_ids );

		$merged_file_path = $this->merge_labels->merged_file_path();

		rename( $merged_file_path, $this->path_label_file( $order_id ) );
	}

	/**
	 * Path_label_file
	 *
	 * @param mixed $order_id Order id.
	 *
	 * @return string
	 */
	private function path_label_file( $order_id ) {
		return $this->label_files->file_path( $order_id );
	}

	/**
	 * Delete_package_files
	 *
	 * @param array $package_ids packages ids.
	 */
	private function delete_package_files( $package_ids ) {
		array_map(
			function( $package_id ) {
				$path = $this->path_package_file( $package_id );
				unlink( $path );
			}, $package_ids
		);
	}

}
