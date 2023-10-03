<?php
/**
 * Shipping
 *
 * @package wooenvio/wecorreos
 */

return [
	'id'                   => 'paq72citypaq',
	'title'                => __( 'Paq Estándar CityPaq', 'correoswc' ),
	'description'          => __( 'Paq Estándar CityPaq 72h', 'correoswc' ),
	'correos_code'         => 'S0178',
	'type_delivery'        => 'CP',
	'compatible_countries' => [ 'ES' ],
	'class'                => 'WooEnvio\\WECorreos\\Infrastructure\\Common\\Shipping\\Paq72Citypaq',
];
