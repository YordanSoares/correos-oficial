<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Order/Shipping/Customs
 */

namespace WooEnvio\WECorreos\Domain\Model\Order\Shipping\Customs;

/**
 * Class Doc_Links
 */
class Doc_Links {

	/**
	 * Ddp
	 *
	 * @var mixed
	 */
	private $ddp;
	/**
	 * Dua
	 *
	 * @var mixed
	 */
	private $dua;
	/**
	 * Declaration
	 *
	 * @var mixed
	 */
	private $declaration;

	/**
	 * Doc_Links constructor.
	 *
	 * @param mixed $ddp Ddp.
	 * @param mixed $dua Dua.
	 * @param mixed $declaration Declaration.
	 */
	public function __construct( $ddp, $dua, $declaration ) {
		$this->ddp         = $ddp;
		$this->dua         = $dua;
		$this->declaration = $declaration;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function ddp() {
		return $this->ddp;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function dua() {
		return $this->dua;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function declaration() {
		return $this->declaration;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	public function doc_available() {
		return isset( $this->ddp ) || isset( $this->dua ) || isset( $this->declaration );
	}
}
