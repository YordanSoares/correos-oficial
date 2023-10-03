<?php //phpcs:ignoreFile
/**
 * Tracking shipping email
 *
 * @author   WooEnvio
 * @package  WC_Correos_Shipping/Templates/emails
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// @hooked WC_Emails::email_header() Output the email header
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php
echo '<p>' . __( 'You can check the status of the shipment in this link', 'correoswc' ) . ': </p>';
echo '<p><a href="http://www.correos.es/comun/localizador/track.asp?numero=' . $wc_correos_shipping_id . '">';
echo __( 'Shipping Status', 'correoswc' ) . ' ' . $order_id . '</a></p>';
?>

<?php
// @hooked WC_Emails::order_details() Shows the order details table.
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

// @hooked WC_Emails::order_meta() Shows order meta data.
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

// @hooked WC_Emails::customer_details() Shows customer details
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

// @hooked WC_Emails::email_footer() Output the email footer
do_action( 'woocommerce_email_footer', $email );

