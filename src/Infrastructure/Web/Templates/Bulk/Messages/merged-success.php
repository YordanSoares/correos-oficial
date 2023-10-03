<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<strong><?php esc_html_e( 'Generated Orders', 'correoswc' ); ?>: </strong>

<?php echo esc_html( implode( ', ', $merged ) ); ?>

<a href="<?php echo esc_attr( $download_link ); ?>" target="_blank"><?php esc_html_e( 'Download File', 'correoswc' ); ?></a>
