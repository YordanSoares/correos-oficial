<?php // phpcs:ignoreFile
/**
 * WooEnvio CostRules package file.
 *
 * @package WooEnvio\CostRules
 */

namespace WooEnvio\CostRules;

class Rules_Iterator {

	private $rules;
	private $current_rule;
	private $pointer;

	public function __construct( $rules ) {
		$this->rules        = $rules;
		$this->pointer      = 0;
		$this->current_rule = $this->rules[ $this->pointer ];
	}

	public function calculate_charge( $products ) {
		return $this->current_rule->calculate_charge( $products );
	}

	public function next_rule() {
		if ( ! $this->process_more_rules() ) {
			return false;
		}

		$this->current_rule = $this->rules[ $this->pointer ];

		return true;
	}

	private function process_more_rules() {
		if ( $this->current_rule_stop_process_rules() ) {
			return false;
		}

		if ( $this->pointer + 1 >= count( $this->rules ) ) {
			return false;
		}

		$this->pointer++;
		return true;
	}

	private function current_rule_stop_process_rules() {
		if ( $this->current_rule->value_in_rule()
			&& Products::SC_ALL == $this->current_rule->get_shipping_class()
				&& Products::CO_PRICE == $this->current_rule->get_conditional() ) {
			return true;
		}

		if ( $this->current_rule->value_in_rule()
			&& Products::CO_PRICE == $this->current_rule->get_conditional() ) {
			$this->pointer = $this->search_last_pointer_current_shipping_class();
		}

		return false;
	}

	private function search_last_pointer_current_shipping_class() {
		$last_pointer = $this->pointer;
		$total_rules  = count( $this->rules );

		for ( $pointer = $this->pointer; $pointer < $total_rules; $pointer ++ ) {
			if ( $this->rules[ $pointer ]->get_shipping_class() !== $this->current_rule->get_shipping_class() ) {
				$last_pointer = $pointer - 1;
				break;
			}
		}
		return $last_pointer;
	}
}
