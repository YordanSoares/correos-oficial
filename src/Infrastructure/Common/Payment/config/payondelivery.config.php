<?php
/**
 * Payment
 *
 * @package wooenvio/wecorreos
 */

return [
	'id'                          => 'we_correos_payondelivery',
	'icon'                        => '',
	'title'                       => __( 'Cash on Delivery by Correos', 'correoswc' ),
	'description'                 => __( 'Have your customers pay with cash upon delivery (Correos).', 'woocommerce' ),
	'has_fields'                  => false,
	'class'                       => 'WooEnvio\\WECorreos\\Infrastructure\\Common\\Payment\\Correos_Pay_On_Delivery',
	'compatible_shipping_methods' => [ 'paq48home', 'paq48office', 'paq72home', 'paq72office' ],
	'compatible_countries'        => [ 'ES', 'AD' ],
];
