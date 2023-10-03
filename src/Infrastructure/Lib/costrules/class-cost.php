<?php // phpcs:ignoreFile
/**
 * WooEnvio CostRules package file.
 *
 * @package WooEnvio\CostRules
 */

namespace WooEnvio\CostRules;

class Cost {

	private $rules;
	private $products;

	public function __construct( $raw_rules, $raw_products ) {
		$this->rules    = $this->obtain_rules( $raw_rules );
		$this->products = new Products( $raw_products );
	}

	private function obtain_rules( $raw_rules ) {
		$raw_rules = $this->transpose( $raw_rules );
		$rules     = [];
		foreach ( $raw_rules as $raw_rule => $rule_attrs ) {
			if ( $this->is_valid_rule( $rule_attrs ) ) {
				$rules[] = new Rule( $rule_attrs );
			}
		}

		$rules = $this->sort_rules( $rules );
		return $rules;
	}

	/**
	 * Transpose array. Example:
	 *
	 * In:
	 *
	 * Array (
	 *   [shipping_class] => Array ( [1] => 0, [2] => 0 ),
	 *   [conditional]    => Array ( [1] => 1, [2] => 1 )
	 * )
	 *
	 * Out:
	 *
	 * Array (
	 *   [0] => Array ( [shipping_class] => 0, [conditional] => 1 ),
	 *   [1] => Array ( [shipping_class] => 0, [conditional] => 1 ),
	 * )
	 */
	public function transpose( $in ) {
		$out = array();
		foreach ( $in as $key => $subarr ) {
			foreach ( $subarr as $subkey => $subvalue ) {
				$out[ $subkey ][ $key ] = $subvalue;
			}
		}
		return array_values( $out );
	}

	public function is_valid_rule( $rule_attrs ) {

		if ( $rule_attrs['min'] === $rule_attrs['max'] ) {
			return false;
		}

		if ( ( $rule_attrs['min'] > $rule_attrs['max'] ) && 0 != $rule_attrs['max'] ) {
			return false;
		}

		return true;
	}

	public function sort_rules( $rules ) {
		$shipping_class_sort = [];
		$coditional_sort     = [];
		if ( ! empty( $rules ) ) {
			foreach ( $rules as $rule ) {
				$shipping_class_sort[] = $rule->get_shipping_class();
				$coditional_sort[]     = $rule->get_conditional();
			}
			array_multisort( $shipping_class_sort, SORT_STRING, $coditional_sort, SORT_ASC, $rules );
		}
		return $rules;
	}

	public function calculate() {
		if ( count( $this->rules ) == 0 ) {
			return 0;
		}

		$rules_iterator = new Rules_Iterator( $this->rules );

		$charge = 0;
		do {
			$charge += $rules_iterator->calculate_charge( $this->products );
		} while ( $rules_iterator->next_rule() );

		return $charge;
	}
}
