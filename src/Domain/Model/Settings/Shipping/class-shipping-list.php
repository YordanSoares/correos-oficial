<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Model/Settings/Shipping
 */

namespace WooEnvio\WECorreos\Domain\Model\Settings\Shipping;

/**
 * Class Shipping_List
 */
class Shipping_List {

	/**
	 * Paq48home
	 *
	 * @var bool
	 */
	private $paq48home;
	/**
	 * Paq72home
	 *
	 * @var bool
	 */
	private $paq72home;
	/**
	 * Paq48office
	 *
	 * @var bool
	 */
	private $paq48office;
	/**
	 * Paq72office
	 *
	 * @var bool
	 */
	private $paq72office;
	/**
	 * International
	 *
	 * @var bool
	 */
	private $international;
	/**
	 * Paqlightinternational
	 *
	 * @var bool
	 */
	private $paqlightinternational;
	/**
	 * Paq48citypaq
	 *
	 * @var bool
	 */
	private $paq48citypaq;
	/**
	 * Paq72citypaq
	 *
	 * @var bool
	 */
	private $paq72citypaq;

	/**
	 * Shipping_List constructor.
	 *
	 * @param bool $paq48home Paq48home.
	 * @param bool $paq72home Paq72home.
	 * @param bool $paq48office Paq48office.
	 * @param bool $paq72office Paq72office.
	 * @param bool $international International.
	 * @param bool $paqlightinternational Paqlightinternational.
	 * @param bool $paq48citypaq Paq48citypaq.
	 * @param bool $paq72citypaq Paq72citypaq.
	 */
	public function __construct( $paq48home, $paq72home, $paq48office, $paq72office, $international, $paqlightinternational, $paq48citypaq, $paq72citypaq ) {
		$this->paq48home             = $paq48home;
		$this->paq72home             = $paq72home;
		$this->paq48office           = $paq48office;
		$this->paq72office           = $paq72office;
		$this->international         = $international;
		$this->paqlightinternational = $paqlightinternational;
		$this->paq48citypaq          = $paq48citypaq;
		$this->paq72citypaq          = $paq72citypaq;
	}

	/**
	 * Paq48home
	 *
	 * @return bool
	 */
	public function paq48home() {
		return $this->paq48home;
	}

	/**
	 * Paq72home
	 *
	 * @return bool
	 */
	public function paq72home() {
		return $this->paq72home;
	}

	/**
	 * Paq48office
	 *
	 * @return bool
	 */
	public function paq48office() {
		return $this->paq48office;
	}

	/**
	 * Paq72office
	 *
	 * @return bool
	 */
	public function paq72office() {
		return $this->paq72office;
	}

	/**
	 * International
	 *
	 * @return bool
	 */
	public function international() {
		return $this->international;
	}

	/**
	 * Paqlightinternational
	 *
	 * @return bool
	 */
	public function paqlightinternational() {
		return $this->paqlightinternational;
	}

	/**
	 * Paq48citypaq
	 *
	 * @return bool
	 */
	public function paq48citypaq() {
		return $this->paq48citypaq;
	}

	/**
	 * Paq72citypaq
	 *
	 * @return bool
	 */
	public function paq72citypaq() {
		return $this->paq72citypaq;
	}

	/**
	 * Default
	 *
	 * @return static
	 */
	public static function build_default() {
		return new static( false, false, false, false, false, false, false, false );
	}

	/**
	 * Data
	 *
	 * @return array
	 */
	public function data() {
		return [
			'paq48home'             => $this->paq48home,
			'paq72home'             => $this->paq72home,
			'paq48office'           => $this->paq48office,
			'paq72office'           => $this->paq72office,
			'international'         => $this->international,
			'paqlightinternational' => $this->paqlightinternational,
			'paq48citypaq'          => $this->paq48citypaq,
			'paq72citypaq'          => $this->paq72citypaq,
		];
	}
}
