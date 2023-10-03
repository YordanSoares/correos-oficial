<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div id="metabox-customs-form" class="we-form-metabox we-form-tabs" style="display:none;">

	<div id="metabox-customs-form-header">

		<?php if ( $doc_links->doc_available() ) : ?>

			<?php $this->insert( 'order::customs-header', compact( 'doc_links' ) ); ?>

		<?php endif ?>

	</div>

	<input type="hidden" name="metabox-customs-form[order_id]" value="<?php echo esc_attr( $order->order_id() ); ?>">

	<p>
		<label>
			<?php esc_html_e( 'Number of elements', 'correoswc' ); ?>
			<span class="we-required">*</span>
		</label>
		<input type="text" name="metabox-customs-form[number_pieces]" value="<?php echo esc_attr( $customs->number_pieces() ); ?>">
	</p>

	<p>
		<a href="#" action="wecorreos_obtain_customs_dua" form="metabox-customs-form" message_id="we-message-metabox" block_element="wecorreos-order-metabox" class="js-ajax-post-request button-primary">
			<?php esc_html_e( 'DUA Documentation', 'correoswc' ); ?>
		</a>
	</p>

	<p>
		<a href="#" action="wecorreos_obtain_customs_ddp" form="metabox-customs-form" message_id="we-message-metabox" block_element="wecorreos-order-metabox" class="js-ajax-post-request button-primary">
			<?php esc_html_e( 'DDP Documentation', 'correoswc' ); ?>
		</a>
	</p>

	<?php if ( $display_request_declaration ) : ?>

		<p>
			<a href="#" action="wecorreos_obtain_customs_content_declaration" form="metabox-customs-form" message_id="we-message-metabox" block_element="wecorreos-order-metabox" class="js-ajax-post-request button-primary">
				<?php esc_html_e( 'Content declaration', 'correoswc' ); ?>
			</a>
		</p>

	<?php endif ?>

</div>
