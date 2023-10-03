<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div id="metabox-label-form" class="we-form-metabox we-form-tabs" style="">

	<div id="metabox-label-form-header">

		<?php if ( ! is_null( $correos_id ) ) : ?>

			<?php $this->insert( 'order::label-header', compact( 'label_download_link' ) ); ?>

		<?php endif ?>

	</div>

	<input type="hidden" name="metabox-label-form[order_id]" value="<?php echo esc_attr( $order->order_id() ); ?>">

	<p>
		<label><?php esc_html_e( 'Sender', 'correoswc' ); ?></label>
		<select id="metabox-label-form-sender-key" name="metabox-label-form[sender_key]">

			<?php foreach ( $sender_list as $key => $alias ) : ?>

				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $label->sender_key(), $key ); ?>>
					<?php echo esc_html( $alias ); ?>
				</option>

			<?php endforeach ?>

		</select>
	</p>

	<?php
	$this->insert(
		'order::label-packages', [
			'package_list'         => $label->package_list(),
			'display_multipackage' => $display_multipackage,
		]
	)
	?>

	<p>
		<label>
			<?php esc_html_e( 'Insurance', 'correoswc' ); ?>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Insurance between 0 and 3000', 'correoswc' ); ?>"></span>
		</label>
		<input type="text" name="metabox-label-form[insurance]" value="<?php echo esc_attr( $label->insurance() ); ?>">
		<?php esc_html_e( '€', 'correoswc' ); ?>
	</p>

	<p>
		<label>
			<?php esc_html_e( 'Comment', 'correoswc' ); ?>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Observations printed on Label Order. No more of 45 characters', 'correoswc' ); ?>"></span>
		</label>
		<textarea name="metabox-label-form[comment]"><?php echo esc_html( $label->comment() ); ?></textarea>
	</p>

	<?php if ( ! is_null( $customs ) ) : ?>

		<h4><?php esc_html_e( 'Customs Doc', 'correoswc' ); ?></h4>

		<p class="we-consignor-reference">
			<span>
				<label id="wecorreos_customs_consignor_reference" for="metabox-label-form[customs_consignor_reference]">
					<?php esc_html_e( 'Customs reference of the consignor', 'correoswc' ); ?>
						<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Customs reference of the consignor that appears in the pre-registration form. It can be changed before pre-registration', 'correoswc' ); ?>"></span>
				</label>
			</span><br />
			<span class="we-tariff">
				<input class="we-tariff-description" type="text" name="metabox-label-form[customs_consignor_reference]" id="customs_consignor_reference" value="<?php  echo get_option('wecorreos_customs_consignor_reference');  ?>" aria-label="Consignor Reference">
			</span>
		</p>			

	<?php endif ?>

	<p>
		<a href="#" id="wecorreos_obtain_label" form="metabox-label-form" action="wecorreos_obtain_label" message_id="we-message-metabox" block_element="wecorreos-order-metabox" class="js-ajax-post-request button-primary">
			<?php esc_html_e( 'Obtain label', 'correoswc' ); ?>
		</a>
	</p>

</div>
