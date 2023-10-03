<?php
/**
 * Bulk actions
 *
 * @package wooenvio/wecorreos/Application/Bulk
 */

namespace WooEnvio\WECorreos\Application\Services\Bulk;

/**
 * Class Merged_Info
 */
class Merged_Info {

	/**
	 * Merged
	 *
	 * @var array
	 */
	private $merged;
	/**
	 * Not_merged
	 *
	 * @var array
	 */
	private $not_merged;
	/**
	 * Not_correos
	 *
	 * @var array
	 */
	private $not_correos;
	/**
	 * Merged_download_link
	 *
	 * @var string
	 */
	private $merged_download_link;

	/**
	 * Merged_Info constructor.
	 *
	 * @param array  $merged Merged.
	 * @param array  $not_merged Not_merged.
	 * @param array  $not_correos Not_correos.
	 * @param string $merged_download_link Merged_download_link.
	 */
	public function __construct( $merged, $not_merged, $not_correos, $merged_download_link ) {
		$this->merged               = $merged;
		$this->not_merged           = $not_merged;
		$this->not_correos          = $not_correos;
		$this->merged_download_link = $merged_download_link;
	}

	/**
	 * Merged order ids
	 *
	 * @return array
	 */
	public function merged() {
		return $this->merged;
	}

	/**
	 * Not Merged order ids
	 *
	 * @return array
	 */
	public function not_merged() {
		return $this->not_merged;
	}

	/**
	 * Not Correos shippings order ids
	 *
	 * @return array
	 */
	public function not_correos() {
		return $this->not_correos;
	}

	/**
	 * Download link
	 *
	 * @return string
	 */
	public function merged_download_link() {
		return $this->merged_download_link;
	}

	/**
	 * Exists merged
	 *
	 * @return bool
	 */
	public function exists_merged() {
		return count( $this->merged ) > 0;
	}

	/**
	 * Exists not merged
	 *
	 * @return bool
	 */
	public function exists_not_merged() {
		return count( $this->not_merged ) > 0;
	}

	/**
	 * Exists not correos
	 *
	 * @return bool
	 */
	public function exists_not_correos() {
		return count( $this->not_correos ) > 0;
	}
}
