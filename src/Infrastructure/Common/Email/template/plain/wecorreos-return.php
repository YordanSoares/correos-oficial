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

echo '= ' . $email_heading . " =\n\n";

_e( 'Please find attached, the new label you need to print out put it on the parcel. Please take it to the nearest Post Office or contact us if you wish to organize a parcel collection', 'correoswc' );

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );
