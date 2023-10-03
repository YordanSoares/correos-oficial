<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<strong><?php esc_html_e( 'Not Generated Orders', 'correoswc' ); ?>: </strong>

<?php echo esc_html( implode( ', ', $not_merged ) ); ?>

<br/><strong><?php esc_html_e( 'Not Preregister orders. Go to each order and preregiter it.', 'correoswc' ); ?></strong>
