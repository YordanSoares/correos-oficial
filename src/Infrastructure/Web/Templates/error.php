<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div class="notice notice-error">
	<p>
		<strong><?php esc_html_e( $this->e( $error )); ?></strong>
	</p>
	<p>
		<?php esc_html_e( 'Please contact with', 'correoswc' ); ?>
		<a href="<?php esc_attr( $this->e( $link_support ) ); ?>" target="_blank">
			<?php esc_html_e( 'WooEnvio Support', 'correoswc' ); ?>
		</a>
	</p>
</div>
