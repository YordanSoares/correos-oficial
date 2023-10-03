<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div id="settings-customs-form" class="we-form-settings we-form-tabs" style="display:none;">

	<p>
		<?php esc_html_e( 'Customs Doc configuration on preregister section on order page.', 'correoswc' ); ?>
	</p>

	<hr/>

	<p>
	<input type="radio" name="settings-customs-form[customs_check_description_and_tariff]" <?php if ($customs->customs_check_description_and_tariff()=='radio_description_by_default') echo 'checked' ?> value="radio_description_by_default"  class="we-customs-desription-and-tariff" aria-label="<?php esc_html_e('Choose description of Tariff Number', 'correoswc') ?>">		
	<label for="settings-customs-form[customs_default_description]">
			<?php esc_html_e( 'Default customs description', 'correoswc' ); ?>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Description by default that appears in the pre-registration form. It can be changed before pre-registration.', 'correoswc' ); ?>"></span>
		</label>
		<select name="settings-customs-form[customs_default_description]">
			<?php foreach ( $description_customs_options as $option => $label ) : ?>

				<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $customs->customs_default_description(), $option ); ?>>
					<?php echo esc_html( $label ); ?>
				</option>

			<?php endforeach ?>
		</select>
	</p>

	<p>
	<input type="radio" name="settings-customs-form[customs_check_description_and_tariff]" <?php if ($customs->customs_check_description_and_tariff()=='radio_tariff_number') echo 'checked';  ?> value="radio_tariff_number" class="we-customs-desription-and-tariff" aria-label="<?php esc_html_e('Choose description of Tariff Number', 'correoswc') ?>">
        	<span class="we-tariff">
				<label for="settings-customs-form[customs_tariff_number][1]">
			       	<?php esc_html_e( 'Tariff Number', 'correoswc' ); ?>
			       	<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Tariff number for customs managment that appears in the pre-registration form. It can be changed before pre-registration', 'correoswc' ); ?>"></span>
		        </label>
				<select name="settings-customs-form[customs_tariff_number][1]">
					<?php foreach ( $tariff_number_options as $option => $label ) : ?>
						<option value="<?php echo esc_html( $label ); ?>" <?php selected( $customs->customs_tariff_number(), $label ); ?>>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php endforeach ?>
				</select>
			</span>
			<span class="we-tariff">
					<span class="we-tariff-description-legend"><?php esc_html_e( 'Description', 'correoswc' ); ?></span>
					<input class="we-tariff-description we-tariff-description-input" type="text" name="settings-customs-form[customs_tariff_description][1]" id="customs_tariff_description" value="<?php echo $customs->customs_tariff_description(); ?>" aria-label="Descripción">
			</span>
	</p>

	<p class="we-consignor-reference">
        <span>
			<label for="settings-customs-form[customs_consignor_reference]">
		       	<?php esc_html_e( 'Customs reference of the consignor', 'correoswc' ); ?>
			       	<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Customs reference of the consignor that appears in the pre-registration form. It can be changed before pre-registration', 'correoswc' ); ?>"></span>
		    </label>
		</span>
		<span class="we-tariff">
			<input class="we-consignor-reference" type="text" name="settings-customs-form[customs_consignor_reference]" id="customs_consignor_reference" value="<?php echo $customs->customs_consignor_reference(); ?>" aria-label="Consignor Reference">
		</span>
	</p>	

	<p>
		<a href="#" id="we_message_settings" form="settings-customs-form" action="wecorreos_save_customs" message_id="we-message-settings" block_element="wecorreos-settings" class="js-ajax-post-request button-primary">
			<?php esc_html_e( 'Save', 'correoswc' ); ?>
		</a>
	</p>
</div>

<script>
var wecorreos_errorNoDescriptionFound='<?php esc_html_e('If you select tariff number you must choice a description', 'correoswc'); ?>';
</script>