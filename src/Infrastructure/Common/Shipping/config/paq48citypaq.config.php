<?php
/**
 * Shipping
 *
 * @package wooenvio/wecorreos
 */

return [
	'id'                   => 'paq48citypaq',
	'title'                => __( 'Paq Premium CityPaq', 'correoswc' ),
	'description'          => __( 'Paq Premium CityPaq 48h/72h', 'correoswc' ),
	'correos_code'         => 'S0176',
	'type_delivery'        => 'CP',
	'compatible_countries' => [ 'ES' ],
	'class'                => 'WooEnvio\\WECorreos\\Infrastructure\\Common\\Shipping\\Paq48Citypaq',
];
