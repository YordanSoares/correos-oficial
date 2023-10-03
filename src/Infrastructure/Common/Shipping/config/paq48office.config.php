<?php
/**
 * Shipping
 *
 * @package wooenvio/wecorreos
 */

return [
	'id'                   => 'paq48office',
	'title'                => __( 'Paq Premium Office', 'correoswc' ),
	'description'          => __( 'Shipping on Correos Office 24h/48h', 'correoswc' ),
	'correos_code'         => 'S0236',
	'type_delivery'        => 'LS',
	'compatible_countries' => [ 'ES', 'AD' ],
	'class'                => 'WooEnvio\\WECorreos\\Infrastructure\\Common\\Shipping\\Paq48Office',
];
