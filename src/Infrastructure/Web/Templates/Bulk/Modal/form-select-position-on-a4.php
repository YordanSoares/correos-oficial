<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div id="wecorreos_select_position_on_a4" style="display:none;">

	<div id="wecorreos_select_position_on_a4_form" class="we-form-bulkactions">

		<table border="0" cellspacing="0" cellpadding="0" class="wecorreos-border-grey">
			<tr>
				<td><input type="radio" id="cb1" name="wecorreos_select_position_on_a4_form[position]" value="0" class="wecorreos-radio-img" checked/>
					<label for="cb1" class="wecorreos-radio-img">
					<img class="logo-checkbox" src="<?php echo esc_attr( $path_img ); ?>position_one.png">
				</label></td>
				<td><input type="radio" id="cb2" name="wecorreos_select_position_on_a4_form[position]" value="1" class="wecorreos-radio-img"/>
					<label for="cb2" class="wecorreos-radio-img">
					<img class="logo-checkbox" src="<?php echo esc_attr( $path_img ); ?>position_two.png">
				</label></td>
			</tr>
			<tr>
				<td><input type="radio" id="cb3" name="wecorreos_select_position_on_a4_form[position]" value="2" class="wecorreos-radio-img"/>
					<label for="cb3" class="wecorreos-radio-img">
					<img class="logo-checkbox" src="<?php echo esc_attr( $path_img ); ?>position_three.png">
				</label></td>
				<td><input type="radio" id="cb4" name="wecorreos_select_position_on_a4_form[position]" value="3" class="wecorreos-radio-img"/>
					<label for="cb4" class="wecorreos-radio-img">
					<img class="logo-checkbox" src="<?php echo esc_attr( $path_img ); ?>position_four.png">
				</label></td>
			</tr>
		</table>

		<p>

			<a href="#" value="wecorreos_print_on_a4"
				action="wecorreos_print_on_a4"
				form="wecorreos_select_position_on_a4_form"
				message_id="wecorreos-bulk-message"
				message_updating="<?php esc_attr_e( 'Doing request', 'correoswc' ); ?>"
				block_element="wecorreos-bulk-message"
				class="js-ajax-post-request-on-modal button-primary">

				<?php esc_html_e( 'Obtain labels', 'correoswc' ); ?>

			</a>

		</p>

	</div>

</div>
