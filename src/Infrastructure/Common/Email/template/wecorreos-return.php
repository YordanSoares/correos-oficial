<?php //phpcs:ignoreFile
/**
 * Refund shipping email
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
_e( 'Please find attached, the new label you need to print out put it on the parcel. Please take it to the nearest Post Office or contact us if you wish to organize a parcel collection', 'correoswc' );
?>

<?php
// @hooked WC_Emails::email_footer() Output the email footer
do_action( 'woocommerce_email_footer', $email );
