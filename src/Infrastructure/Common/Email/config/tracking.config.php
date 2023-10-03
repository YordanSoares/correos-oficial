<?php
/**
 * Email
 *
 * @package wooenvio/wecorreos
 */

return [
	'id'                 => 'wecorreos_tracking_email',
	'title'              => __( 'WECorreos shipping tracking', 'correoswc' ),
	'description'        => __( 'This is a notification that contains details for tracking orders shipping with WECorreos Shipping service.', 'correoswc' ),
	'heading'            => __( 'Tracking order {order_number}. {order_date}', 'correoswc' ),
	'subject'            => __( 'Shipping tracking on WECorreos Shipping', 'correoswc' ),
	'customer_email'     => true,
	'template'           => 'wecorreos-tracking.php',
	'action'             => 'wecorreos_tracking',
	'num_params_trigger' => 2,
	'class'              => 'WooEnvio\\WECorreos\\Infrastructure\\Common\\Email\\Wecorreos_Tracking',
];
