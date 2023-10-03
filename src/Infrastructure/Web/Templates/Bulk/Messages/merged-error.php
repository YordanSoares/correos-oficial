<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<strong><?php esc_html_e( 'Not Generated Orders', 'correoswc' ); ?>: </strong>

<?php echo esc_html( implode( ', ', $not_correos ) ); ?>

<br/><strong><?php esc_html_e( 'Not Correos orders', 'correoswc' ); ?></strong>
