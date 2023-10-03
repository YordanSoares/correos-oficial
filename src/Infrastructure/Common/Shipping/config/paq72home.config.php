<?php
/**
 * Shipping
 *
 * @package wooenvio/wecorreos
 */

return [
	'id'                   => 'paq72home',
	'title'                => __( 'Paq Standard Home', 'correoswc' ),
	'description'          => __( 'Shipping on 48h/72h', 'correoswc' ),
	'correos_code'         => 'S0132',
	'type_delivery'        => 'ST',
	'compatible_countries' => [ 'ES', 'PT', 'AD' ],
	'class'                => 'WooEnvio\\WECorreos\\Infrastructure\\Common\\Shipping\\Paq72Home',
];
