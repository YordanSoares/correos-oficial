<?php // phpcs:ignoreFile
/**
 * Shipping
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Shipping;

use WooEnvio\CostRules\Cost;
use WooEnvio\CostRules\Products;
use WooEnvio\WECorreos\Infrastructure\Common\Shipping\CostRulesForm\Cost_Rules_Form;

abstract class AbstractShippingPro extends AbstractShipping {

	public function init() {
		parent::init();

		$this->charge_rules = $this->get_option( 'charge_rules' );
	}

	public function init_form_fields() {
		parent::init_form_fields();

		$this->instance_form_fields['charge_rules'] = [
			'title'   => __( 'Rules table', 'correoswc' ),
			'type'    => 'charge_rules',
			'default' => '',
		];
	}

	public function generate_charge_rules_html( $key, $data ) {

		$cost_rules_form = new Cost_Rules_Form( $this->get_field_key( $key ) );

		$values = $this->get_option( $key, [] );

		$cost_rules_form->bind( $values );

		return sprintf(
			'<tr><td colspan="2"><p><strong>%1$s</strong></p><br/>%2$s</td></tr>',
			__( 'Rules table', 'correoswc' ),
			$cost_rules_form->render()
		);
	}

	public function validate_charge_rules_field( $key, $value ) {

		$value['shipping_class'] = $this->validateShippingClass(
			isset( $value['shipping_class'] ) ? $value['shipping_class'] : []
		);

		$value['condition'] = $this->validateConditional(
			isset( $value['condition'] ) ? $value['condition'] : []
		);

		$old_value = $value;
		array_map(
			function ( $field ) use ( &$value, $old_value ) {
				$value[ $field ] = $this->validatePositiveFloat(
					isset( $old_value[ $field ] ) ? $old_value[ $field ] : []
				);
			}, [ 'min', 'max', 'cost', 'cost_per_additional_unit' ]
		);

		return $value;
	}

	private function validateShippingClass( $shipping_classes ) {
		$valid_shipping_classes     = array_keys( Products::shipping_class_options( 'wecorreos' ) );
		$validated_shipping_classes = array_map(
			function ( $shipping_class ) use ( $valid_shipping_classes ) {

				return in_array( $shipping_class, $valid_shipping_classes ) ? $shipping_class : '0';
			}, $shipping_classes
		);

		return $validated_shipping_classes;
	}

	private function validateConditional( $conditionals ) {
		$valid_conditionals = array_keys( Products::condition_options( 'wecorreos' ) );

		$validated_conditionals = array_map(
			function ( $conditional ) use ( $valid_conditionals ) {

				return in_array( $conditional, $valid_conditionals ) ? $conditional : '0';
			}, $conditionals
		);

		return $validated_conditionals;
	}

	private function validatePositiveFloat( $values ) {

		$validated_values = array_map(
			function ( $value ) {

				$value = str_replace( ',', '.', $value );

				if ( ! $this->is_zero_or_positive_float( $value ) ) {

					$this->add_error(
						sprintf( __( 'Cost rules error: We are changed %s by 0. Please check it', 'correoswc' ), $value )
					);

					return '0';
				}

				return $value;
			}, $values
		);

		return $validated_values;
	}

	private function is_zero_or_positive_float( $value ) {
			return $this->is_float( $value ) && $this->is_greater_or_equal_than_zero( $value );
	}

	private function is_float( $value ) {
		if ( ! is_numeric( $value ) ) {
			return false;
		}

		return is_float( $value + 0.0 );
	}

	private function is_greater_or_equal_than_zero( $value ) {
		return ( $value + 0 ) >= 0;
	}

	public function calculate_shipping( $package = [] ) {
		$total           = 0;
		$chargeRulesCost = 0;

		if ( null != $this->charge_rules ) {
			$chargeRules     = new Cost( $this->charge_rules, $this->getProducts( $package ) );
			$chargeRulesCost = $chargeRules->calculate();
		}

		$fee = str_replace( ',', '.', $this->fee );

		$fee = is_numeric( $fee ) ? $fee : 0;

		$total = $fee + $chargeRulesCost;

		$this->add_rate(
			array(
				'label'   => $this->title,
				'package' => $package,
				'cost'    => $total,
			)
		);
	}

}
