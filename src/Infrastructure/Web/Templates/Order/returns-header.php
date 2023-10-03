<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div class="we-featured-header">

	<div>

		<strong><?php echo esc_html( $returns_id ); ?></strong>

	</div>

	<br/>

	<div>

		<a href="<?php echo esc_url( $returns_download_link ); ?>" target="_blank" class="we-featured-header-links">

			<span class="dashicons dashicons-format-aside we-dashicons"></span>
			<?php esc_html_e( 'Download RMA Label', 'correoswc' ); ?>

		</a>

	</div>

</div>
