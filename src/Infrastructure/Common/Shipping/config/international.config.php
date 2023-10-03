<?php
/**
 * Shipping
 *
 * @package wooenvio/wecorreos
 */

return [
	'id'            => 'international',
	'title'         => __( 'Paq Standard International', 'correoswc' ),
	'description'   => __( 'Paq Standard International', 'correoswc' ),
	'correos_code'  => 'S0410',
	'type_delivery' => 'ST',
	'class'         => 'WooEnvio\\WECorreos\\Infrastructure\\Common\\Shipping\\International',
];
