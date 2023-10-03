<?php
/**
 * Shipping
 *
 * @package wooenvio/wecorreos
 */

return [
	'id'                   => 'paq72office',
	'title'                => __( 'Paq Standard Office', 'correoswc' ),
	'description'          => __( 'Shipping on Correos Office 48h/72h', 'correoswc' ),
	'correos_code'         => 'S0133',
	'type_delivery'        => 'LS',
	'compatible_countries' => [ 'ES', 'AD' ],
	'class'                => 'WooEnvio\\WECorreos\\Infrastructure\\Common\\Shipping\\Paq72Office',
];
