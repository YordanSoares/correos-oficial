<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div class="we-featured-header">

	<?php if ( ! is_null( $doc_links->dua() ) ) : ?>

		<a href="<?php echo esc_url( $doc_links->dua() ); ?>" target="_blank" class="we-featured-header-links">
			<span class="dashicons dashicons-format-aside we-dashicons">
			</span><?php esc_html_e( 'Download DUA', 'correoswc' ); ?>
		</a>

	<?php endif ?>

	<?php if ( ! is_null( $doc_links->ddp() ) ) : ?>

		<a href="<?php echo esc_url( $doc_links->ddp()); ?>" target="_blank" class="we-featured-header-links">
			<span class="dashicons dashicons-format-aside we-dashicons">
			</span><?php esc_html_e( 'Download DDP', 'correoswc' ); ?>
		</a>

	<?php endif ?>

	<?php if ( ! is_null( $doc_links->declaration() ) ) : ?>

		<a href="<?php echo esc_url( $doc_links->declaration()); ?>" target="_blank" class="we-featured-header-links">
			<span class="dashicons dashicons-format-aside we-dashicons">
			</span><?php esc_html_e( 'Download Content Declaration', 'correoswc' ); ?>
		</a>

	<?php endif ?>

</div>
