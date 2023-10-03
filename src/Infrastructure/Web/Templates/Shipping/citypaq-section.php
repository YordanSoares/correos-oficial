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

			<h3><?php esc_html_e( 'Select one city paq', 'correoswc' ); ?></h3>

			<div id="wecorreos-select-citypaq-form" class="we-form">

				<div id="wecorreos-select-citypaq-messages" class="we-wc-messages"></div>

				<div id="wecorreos-select-citypaq-element" style="margin-bottom:20px;">

					<?php $this->insert( 'shipping::citypaq-selector', compact( 'citypaqs' ) ); ?>

				</div>

				<div id="wecorreos-googlemap" class="wecorreos-googlemap" style="margin-bottom:20px;"></div>

				<?php if ( isset( $order_id ) && isset( $correos_type ) ) : ?>
					<input type="hidden" name="wecorreos-select-citypaq-form[order_id]" id="wecorreos-select-citypaq-form[order_id]"
						value="<?php echo esc_attr( $order_id ); ?>">
					<input type="hidden" name="wecorreos-select-citypaq-form[correos_type]" id="wecorreos-select-citypaq-form[correos_type]"
						value="<?php echo esc_attr( $correos_type ); ?>">
				<?php endif ?>

				<p>
					<input type="text" name="wecorreos-select-citypaq-form[postalcode]" value="<?php echo esc_attr( $postalcode ); ?>" placeholder="<?php esc_html_e( 'Postal Code', 'correoswc' ); ?>">
					<a  href="#"
						 action="wecorreos_obtain_citypaqs_by_cp"
						form="wecorreos-select-citypaq-form"
						message_id="wecorreos-select-citypaq-messages"
						block_element="wecorreos-select-citypaq-form"
						class="js-ajax-post-request button alt we-buttons-front-specials">
						<?php esc_html_e( 'Search by CP', 'correoswc' ); ?>
					</a>
				</p>

				<p>
					<select name="wecorreos-select-citypaq-form[state]" class="js-wc-select2"">
					<?php foreach ( $states_options as $code => $state ) : ?>
						<option value="<?php echo esc_attr( $code ); ?>">
							<?php echo esc_html( $state ); ?>
						</option>
					<?php endforeach ?>
					</select>

					<a  href="#"
						action="wecorreos_obtain_citypaqs_by_state"
						form="wecorreos-select-citypaq-form"
						message_id="wecorreos-select-citypaq-messages"
						block_element="wecorreos-select-citypaq-form"
						class="js-ajax-post-request button alt we-buttons-front-specials">
						<?php esc_html_e( 'Search by State', 'correoswc' ); ?>
					</a>
				</p>


				<p>
					<input type="text" name="wecorreos-select-citypaq-form[citypaq_user]" value="<?php echo esc_attr( $postalcode ); ?>" placeholder="<?php esc_html_e( 'City paq user', 'correoswc' ); ?>">
					<a  href="#"
						action="wecorreos_obtain_citypaqs_favorites"
						form="wecorreos-select-citypaq-form"
						message_id="wecorreos-select-citypaq-messages"
						block_element="wecorreos-select-citypaq-form"
						class="js-ajax-post-request button alt we-buttons-front-specials">
						<?php esc_html_e( 'Citypaq Favorites', 'correoswc' ); ?>
					</a>
				</p>


			</div>
		</div>

	</td>

</tr>
