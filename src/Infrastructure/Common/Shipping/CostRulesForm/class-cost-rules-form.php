<?php
/**
 * Shipping
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Shipping\CostRulesForm;

use League\Plates\Engine;
use WooEnvio\CostRules\Products;

/**
 * Class CostRulesForm
 */
class Cost_Rules_Form {

	/**
	 * CostRulesForm constructor.
	 *
	 * @param string $formName Form name.
	 */
	public function __construct( $formName ) {
		$this->plates_engine = new Engine( __DIR__ . '/../../../Web/Templates/CostRules', 'php' );

		$this->formName = $formName;
	}

	/**
	 * Function.
	 *
	 * @return string|string[]|null
	 */
	public function render() {
		return preg_replace( '~[\t\r\n]+~', '', $this->render_form() );
	}

	/**
	 * Function.
	 *
	 * @param mixed $value Value.
	 */
	public function bind( $value ) {
		$this->value = $value;
	}

	/**
	 * Function.
	 *
	 * @return string
	 */
	private function render_form() {
		$value    = $this->value;
		$formName = $this->formName;
		$keys     = isset( $this->value['shipping_class'] ) ? array_keys( $this->value['shipping_class'] ) : [];

		$condition_options = Products::condition_options( 'wecorreos' );

		$shipping_class_options = Products::shipping_class_options( 'wecorreos' );

		return $this->plates_engine->render( 'form', compact( 'value', 'formName', 'keys', 'condition_options', 'shipping_class_options' ) );
	}
}
