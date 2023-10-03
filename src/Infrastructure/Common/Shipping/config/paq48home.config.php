<?php
/**
 * Shipping
 *
 * @package wooenvio/wecorreos
 */

return [
	'id'                   => 'paq48home',
	'title'                => __( 'Paq Premium Home', 'correoswc' ),
	'description'          => __( 'Shipping on 24h/48h', 'correoswc' ),
	'correos_code'         => 'S0235',
	'type_delivery'        => 'ST',
	'compatible_countries' => [ 'ES', 'PT', 'AD' ],
	'class'                => 'WooEnvio\\WECorreos\\Infrastructure\\Common\\Shipping\\Paq48Home',
];
