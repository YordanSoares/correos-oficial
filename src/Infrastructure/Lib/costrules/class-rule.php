<?php // phpcs:ignoreFile
/**
 * WooEnvio CostRules package file.
 *
 * @package WooEnvio\CostRules
 */

namespace WooEnvio\CostRules;

class Rule {


	/**
	 * Shipping class: All, not shipping class or custom shipping class.
	 */
	private $shipping_class;

	/**
	 * Condition: weight, vol, price.
	 */
	private $conditional;

	/**
	 * Products in rule
	 */
	private $value_in_rule = false;

	private $min;
	private $max;
	private $cost;
	private $cost_per_additional_unit;


	public function __construct( $rule_attrs ) {
		$this->cost_per_additional_unit = $rule_attrs['cost_per_additional_unit'];
		$this->shipping_class           = $rule_attrs['shipping_class'];
		$this->conditional              = $rule_attrs['condition'];
		$this->min                      = $rule_attrs['min'];
		$this->max                      = $rule_attrs['max'];
		$this->cost                     = $rule_attrs['cost'];
	}

	public function calculate_charge( $rules_products ) {

		$value = $rules_products->get_values_products_by_class_and_conditional(
			$this->shipping_class,
			$this->conditional
		);

		$charge = is_null( $value ) ? null : $this->evaluate_conditional( $value );

		$this->value_in_rule = is_null( $charge ) ? false : true;
		$charge              = is_null( $charge ) ? 0 : $charge;

		return $charge;
	}

	private function evaluate_conditional( $value ) {

		if ( $value >= $this->min && 0 == $this->max && $this->min > $this->max ) {
			return $this->cost;
		}

		if ( $value >= $this->min && $value < $this->max ) {
			return $this->cost;
		}

		if ( $value >= $this->max && $this->cost_per_additional_unit > 0 ) {
			$charge           = $this->cost;
			$additional_units = $value - $this->max;
			$charge          += $additional_units * $this->cost_per_additional_unit;
			return $charge;
		}

		return null;
	}

	public function get_shipping_class() {
		return $this->shipping_class;
	}

	public function get_conditional() {
		return $this->conditional;
	}

	public function value_in_rule() {
		return $this->value_in_rule;
	}
}
