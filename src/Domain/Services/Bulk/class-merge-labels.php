<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Bulk;

use WooEnvio\WECorreos\Infrastructure\Common\Files\Label_Files;
use WooEnvio\WECorreos\Infrastructure\Common\Files\Merged_Label_Files;

/**
 * Class Merge_Labels
 */
class Merge_Labels {

	const ORIENTATION = 'L';

	/**
	 * Merge_labels
	 *
	 * @var Merge_Labels
	 */
	private $merge_labels;
	/**
	 * Label_files
	 *
	 * @var Label_Files
	 */
	private $label_files;
	/**
	 * Merged_label_files
	 *
	 * @var Merged_Label_Files
	 */
	private $merged_label_files;

	/**
	 * Merge_Labels constructor.
	 *
	 * @param Merge_Labels       $merge_labels Merge_Labels.
	 * @param Label_Files        $label_files Label_Files.
	 * @param Merged_Label_Files $merged_label_files Merged_Label_Files.
	 */
	public function __construct( $merge_labels, $label_files, $merged_label_files ) {
		$this->merge_labels       = $merge_labels;
		$this->label_files        = $label_files;
		$this->merged_label_files = $merged_label_files;
	}

	/**
	 * Labeler_format
	 *
	 * @param mixed $order_ids Order_id.
	 *
	 * @return mixed
	 */
	public function labeler_format( $order_ids ) {

		$this->add_pdfs( $order_ids );

		$this->merge_labels->mergeFilesToUniqueFile(
			$this->merged_label_files->merged_file_path()
		);

		return $this->download_link();
	}

	/**
	 * A4_format
	 *
	 * @param mixed $order_ids Order_id.
	 * @param int   $position Position.
	 *
	 * @return mixed
	 */
	public function a4_format( $order_ids, $position ) {

		$this->add_pdfs( $order_ids );

		$this->merge_labels->mergeFilesToFourGridPage(
			$this->merged_label_files->merged_file_path(),
			self::ORIENTATION,
			$position
		);

		return $this->download_link();
	}

	/**
	 * Pdfs
	 *
	 * @param mixed $order_ids Order_id.
	 */
	public function add_pdfs( $order_ids ) {

		$label_path_list = $this->label_path_list( $order_ids );

		array_map(
			function( $label_path ) {

				return $this->merge_labels->addPdf( $label_path );

			}, $label_path_list
		);
	}

	/**
	 * Download_link
	 *
	 * @return mixed
	 */
	public function download_link() {
		return $this->merged_label_files->merged_download_link();
	}

	/**
	 * Merged_file_path
	 *
	 * @return mixed
	 */
	public function merged_file_path() {
		return $this->merged_label_files->merged_file_path();
	}

	/**
	 *  Label_path_list
	 *
	 * @param mixed $order_ids Order_id.
	 * @return array
	 */
	private function label_path_list( $order_ids ) {

		return array_map(
			function( $order_id ) {

				return $this->label_files->file_path( $order_id );

			}, $order_ids
		);
	}
}
