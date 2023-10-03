<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<tr>

	<td colspan="2">

		<div class="wecorreos-checkout-front" class="wecorreos-checkout-front" style="position: static; zoom: 1;">

			<h3><?php esc_html_e( 'Select one office', 'correoswc' ); ?></h3>

			<div id="wecorreos-select-office-form" class="we-form">

				<div id="wecorreos-select-office-messages" class="we-wc-messages"></div>

				<div id="wecorreos-select-office-element" style="margin-bottom:10px;">

					<?php $this->insert( 'shipping::postoffice-selector', compact( 'postoffices' ) ); ?>

				</div>

				<div id="wecorreos-googlemap" class="wecorreos-googlemap"></div>

				<?php if ( isset( $order_id ) && isset( $correos_type ) ) : ?>
					<input type="hidden" name="wecorreos-select-office-form[order_id]" id="wecorreos-select-office-form[order_id]"
						value="<?php echo esc_attr( $order_id ); ?>">
					<input type="hidden" name="wecorreos-select-office-form[correos_type]" id="wecorreos-select-office-form[correos_type]"
						value="<?php echo esc_attr( $correos_type ); ?>">
				<?php endif ?>

				<h4><?php esc_html_e( 'Search by ZIP', 'correoswc' ); ?></h4>

				<p>
					<input type="text" name="wecorreos-select-office-form[postalcode]" value="<?php echo esc_attr( $postalcode); ?>" placeholder="<?php esc_attr_e( 'Postal Code', 'correoswc' ); ?>">
					<a  href="#"
						 action="wecorreos_obtain_postoffices_by_cp"
						form="wecorreos-select-office-form"
						message_id="wecorreos-select-office-messages"
						block_element="wecorreos-select-office-form"
						class="js-ajax-post-request button alt we-buttons-front-specials">
						<?php esc_html_e( 'Search', 'correoswc' ); ?>
					</a>
				</p>

			</div>
		</div>

	</td>

</tr>
