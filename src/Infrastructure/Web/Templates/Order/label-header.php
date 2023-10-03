<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div class="we-featured-header">

	<a href="<?php echo esc_url( $label_download_link ); ?>" target="_blank" class="we-featured-header-links">
		<span class="dashicons dashicons-format-aside we-dashicons"></span><?php esc_html_e( 'Download Label', 'correoswc' ); ?>
	</a>

	<a href="#" form="metabox-label-form" action="wecorreos_view_tracking" message_id="we-message-metabox" block_element="wecorreos-order-metabox" class="js-ajax-post-request">
		<span class="dashicons dashicons-warning we-dashicons"></span><?php esc_html_e( 'Tracking', 'correoswc' ); ?>
	</a>

	<div id="we-featured-header-tracking" class="we-featured-header-tracking">
	</div>

</div>
