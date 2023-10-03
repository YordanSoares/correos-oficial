<?php
/**
 * Shared country options
 *
 * @package wooenvio/wecorreos/shared
 */

namespace WooEnvio\WECorreos\Shared\CountrySender;

/**
 * Country options (front)
 *
 * @return array
 */
function country_options() {
	return [
		'ES' => __( 'Spain', 'correoswc'),
		'AD' => __( 'Andorra', 'correoswc'),
	];
}

/**
 * State options (front)
 *
 * @param string $country Country.
 * @param bool   $andorra_option Add Andorra?.
 *
 * @return array
 */
function state_options( $country, $andorra_option = false ) {
	$state_options = WC()->countries->get_states( $country );
	return $andorra_option ? array_merge( $state_options, [ 'ANDORRA' => __( 'Andorra', 'correoswc') ]) : $state_options;
}
