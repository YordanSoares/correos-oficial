<?php
/**
 * Email
 *
 * @package wooenvio/wecorreos
 */

return [
	'id'                 => 'wecorreos_return_email',
	'title'              => __( 'WECorreos shipping return', 'correoswc' ),
	'description'        => __( 'This is a notification that contains details for return orders shipping with WECorreos Shipping service.', 'correoswc' ),
	'heading'            => __( 'Return order {order_number}. {order_date}', 'correoswc' ),
	'subject'            => __( 'RMA Label for refund order {order_number}', 'correoswc' ),
	'customer_email'     => true,
	'template'           => 'wecorreos-return.php',
	'action'             => 'wecorreos_return',
	'num_params_trigger' => 3,
	'class'              => 'WooEnvio\\WECorreos\\Infrastructure\\Common\\Email\\Wecorreos_Return',
];
