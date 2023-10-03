<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div class="wecorreos-order-metabox">

	<div id="metabox-empty">

		<p class=""><?php esc_html_e( 'This order no have Correos shipping', 'correoswc' ); ?></p>

		<p><?php esc_html_e( 'Do you want create it? ', 'correoswc' ); ?></p>


		<div id="we-message-metabox"></div>

		<div class="">

			<p>
				<select id="wecorreos-select-correos-type" name="metabox-empty[correos_type]">

					<?php foreach ( $correos_shippings as $key => $config ) : ?>

						<option value="<?php echo esc_attr( $key ); ?>">
							<?php echo esc_html( $config['title'] ); ?>
						</option>

					<?php endforeach ?>

				</select>
				<input type="hidden" name="metabox-empty[order_id]" value="<?php echo esc_attr( $order_id ); ?>" id="metabox[order_id]">
			</p>

			<p>
				<a href="#" id="wecorreos_force_correos_shipping"
					form="metabox-empty"
					action="wecorreos_force_correos_shipping"
					second_action="wecorreos_display_select_office_form"
					third_action="wecorreos_display_select_citypaq_form"
					message_id="we-message-metabox"
					block_element="wecorreos-order-metabox"
					class="js-ajax-generate-correos-shipping button">
					<?php esc_html_e( 'Generate', 'correoswc' ); ?>
				</a>

			</p>
		</div>
		<div id="metabox-select-extra">

		</div>

	</div>

</div>
