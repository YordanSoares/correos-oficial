<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div id="settings-general-form" class="we-form-settings we-form-tabs">

	<p>
		<?php esc_html_e( 'Fill in all data provided by Correos and enable the shipping methods for WooCommerce.', 'correoswc' ); ?>
		<br/>
		<?php esc_html_e( 'Then in shipping zones you can add theses shipping methods.', 'correoswc' ); ?>
	</p>

	<hr/>

	<p>
		<label for="settings-general-form[client_number]">
			<?php esc_html_e( 'Client number', 'correoswc' ); ?><span class="we-required">*</span>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Without 99', 'correoswc' ); ?> "></span>
		</label>
		<input type="text" name="settings-general-form[client_number]" value="<?php echo esc_attr( $this->e( $general->client_number() ) ); ?>">
	</p>

	<p>
		<label for="settings-general-form[contract_number]">
			<?php esc_html_e( 'Contract number', 'correoswc' ); ?><span class="we-required">*</span>
		</label>
		<input type="text" name="settings-general-form[contract_number]" value="<?php echo esc_attr( $this->e( $general->contract_number() ) ); ?>">
	</p>

	<p>
		<label for="settings-general-form[labeler_code]">
			<?php esc_html_e( 'Labeler code', 'correoswc' ); ?><span class="we-required">*</span>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Without CE', 'correoswc' ); ?> "></span>
		</label>
		<input type="text" name="settings-general-form[labeler_code]" value="<?php echo esc_attr( $this->e( $general->labeler_code() ) ); ?>" maxlength="4">
	</p>

	<p>
		<label for="settings-general-form[correos_user]">
			<?php esc_html_e( 'Correos user', 'correoswc' ); ?><span class="we-required">*</span>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Make sure you not use on-line Correos user', 'correoswc' ); ?> "></span>
		</label>
		<input type="text" name="settings-general-form[correos_user]" value="<?php echo esc_attr( $this->e( $general->correos_user() ) ); ?>">
	</p>

	<p>
		<label for="settings-general-form[correos_password]">
			<?php esc_html_e( 'Correos password', 'correoswc' ); ?><span class="we-required">*</span>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Make sure you not use on-line Correos password', 'correoswc' ); ?> "></span>
		</label>
		<input type="password" name="settings-general-form[correos_password]" value="<?php echo esc_attr( $this->e( $general->correos_password() ) ); ?>">
	</p>

	<hr/>

	<p>
		<label for="settings-general-form[enabled_sms]">
			<?php esc_html_e( 'SMS notices', 'correoswc' ); ?>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Send customer phone to Correos to SMS notices', 'correoswc' ); ?> "></span>
		</label>
		<input type="checkbox" name="settings-general-form[enabled_sms]" value="true" <?php checked( $general->enabled_sms() ); ?>>
		<span><?php esc_html_e( 'SMS shipping notices from Correos', 'correoswc' ); ?></span>
	</p>

	<p>
		<label for="settings-general-form[order_status_on_obtain_label]">
			<?php esc_html_e( 'Order status on obtain label', 'correoswc' ); ?>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Order status after obtain Correos label', 'correoswc' ); ?> "></span>
		</label>
		<select name="settings-general-form[order_status_on_obtain_label]" id="order_status_on_obtain_label">
			<?php foreach ( $order_statuses as $option => $label ) : ?>

				<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $general->order_status_on_obtain_label(), $option ); ?>>
					<?php echo esc_html( $label ); ?>
				</option>

			<?php endforeach ?>
		</select>
	</p>

	<p>
		<label for="settings-general-form[googlemap_apikey]">
			<?php esc_html_e( 'Google map API KEY', 'correoswc' ); ?>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Display Google map on selecting citypaq or postoffice in checkout. ', 'correoswc' ); ?> "></span>
		</label>
		<input type="text" name="settings-general-form[googlemap_apikey]" value="<?php echo esc_attr( $this->e( $general->googlemap_apikey() ) ); ?>">
	</p>

	<p>
		<label for="settings-general-form[altsslcom]">
			<?php esc_html_e( 'Alternative SSL', 'correoswc' ); ?>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Alternative SSL communication', 'correoswc' ); ?> "></span>
		</label>
		<input type="checkbox" name="settings-general-form[altsslcom]" value="true" <?php checked( $general->enabled_altsslcom() ); ?>>
		<span><?php esc_html_e( 'Active it if pre-register action no work', 'correoswc' ); ?></span>
	</p>

	<hr/>

	<p>
		<label for="settings-general-form[required_id]">
			<?php esc_html_e( 'Required Personal ID', 'correoswc' ); ?>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Here you make required the Personal ID field in the checkout', 'correoswc' ); ?> "></span>
		</label>
		<input type="checkbox" name="settings-general-form[enabled_required_id]" class="required_id" id="enabled_required_id" value="true" <?php checked( $general->enabled_required_id() ); ?>>
		<span><?php esc_html_e( 'Activate it if you need the Personal ID field to be required', 'correoswc' ); ?></span>
	</p>

	<p>
		<label for="settings-general-form[personalised_id]">
			<?php esc_html_e( 'Required Personalised Personal ID', 'correoswc' ); ?>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Here you can indicate whether your shop already has a personalised ID number added by yourself to the checkout', 'correoswc' ); ?> "></span>
		</label>
		<input type="checkbox" name="settings-general-form[enabled_personalised_id]" class="personalised_id" id="enabled_personalised_id" value="true" <?php checked( $general->enabled_personalised_id() ); ?>>
		<input type="text" name="settings-general-form[personalised_id]" class="personalised_id" value="<?php echo esc_attr( $this->e( $general->personalised_id() ) ); ?>">
		<span><?php esc_html_e( 'If you have developed a Required Personalised Personal ID field, indicate the field name', 'correoswc' ); ?></span>
	</p>

	<hr/>

	<p>
		<label for="settings-general-form[paq48home]"><?php esc_html_e( 'Shipping methods', 'correoswc' ); ?></label>
		<input type="checkbox" name="settings-general-form[paq48home]" value="true" <?php checked( $general->shippings()->paq48home() ); ?>>
		<img src="<?php echo esc_attr( $images_url ); ?>paq48home.png" style="vertical-align:middle;margin-right: 5px;">
	</p>

	<p>
		<label for="settings-general-form[paq72home]"></label>
		<input type="checkbox" name="settings-general-form[paq72home]" value="true" <?php checked( $general->shippings()->paq72home() ); ?>>
		<img src="<?php echo esc_attr( $images_url ); ?>paq72home.png" style="vertical-align:middle;margin-right: 5px;">
	</p>

	<p>
		<label for="settings-general-form[paq48office]"></label>
		<input type="checkbox" name="settings-general-form[paq48office]" value="true" <?php checked( $general->shippings()->paq48office() ); ?>>
		<img src="<?php echo esc_attr( $images_url ); ?>paq48office.png" style="vertical-align:middle;margin-right: 5px;">
	</p>

	<p>
		<label for="settings-general-form[paq72office]"></label>
		<input type="checkbox" name="settings-general-form[paq72office]" value="true" <?php checked( $general->shippings()->paq72office() ); ?>>
		<img src="<?php echo esc_attr( $images_url); ?>paq72office.png" style="vertical-align:middle;margin-right: 5px;">
	</p>

	<p>
		<label for="settings-general-form[paq48citypaq]"></label>
		<input type="checkbox" name="settings-general-form[paq48citypaq]" value="true" <?php checked( $general->shippings()->paq48citypaq() ); ?>>
		<img src="<?php echo esc_attr( $images_url); ?>paq48citypaq.png" style="vertical-align:middle;margin-right: 5px;">
	</p>

	<p>
		<label for="settings-general-form[paq72citypaq]"></label>
		<input type="checkbox" name="settings-general-form[paq72citypaq]" value="true" <?php checked( $general->shippings()->paq72citypaq() ); ?>>
		<img src="<?php echo esc_attr( $images_url); ?>paq72citypaq.png" style="vertical-align:middle;margin-right: 5px;">
	</p>

	<p>
		<label for="settings-general-form[international]"></label>
		<input type="checkbox" name="settings-general-form[international]" value="true" <?php checked( $general->shippings()->international() ); ?>>
		<img src="<?php echo esc_attr( $images_url); ?>international.png" style="vertical-align:middle;margin-right: 5px;">
	</p>

	<p>
		<label for="settings-general-form[paqlightinternational]"></label>
		<input type="checkbox" name="settings-general-form[paqlightinternational]" value="true" <?php checked( $general->shippings()->paqlightinternational() ); ?>>
		<img src="<?php echo esc_attr( $images_url); ?>paqlightinternational.png" style="vertical-align:middle;margin-right: 5px;">
	</p>

	<p>
		<a href="#" form="settings-general-form" action="wecorreos_save_general" message_id="we-message-settings" block_element="wecorreos-settings" class="js-ajax-post-request button-primary">
			<?php esc_html_e( 'Save', 'correoswc' ); ?>
		</a>
	</p>
</div>
