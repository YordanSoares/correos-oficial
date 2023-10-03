<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<h3><?php esc_html_e( 'Recipient Data', 'correoswc' ); ?></h3>


<p>
	<label>
		<?php esc_html_e( 'Recipient', 'correoswc' ); ?>
	</label>

	<select name="metabox-returns-form[recipient_key]"
			class="js-ajax-post-request-on-select"
			action="wecorreos_change_recipient"
			form="metabox-returns-form"
			message_id="we-message-metabox"
			block_element="wecorreos-order-metabox">

		<?php foreach ( $sender_list as $key => $alias ) : ?>

			<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $returns->recipient_key(), $key ); ?>>
				<?php echo esc_html( $alias); ?>
			</option>

		<?php endforeach ?>

	</select>
</p>

<p>
	<label>
		<?php esc_html_e( 'First name', 'correoswc' ); ?>
		<span class="we-required">**</span>
	</label>
	<input type="text" name="metabox-returns-form[recipient_first_name]" value="<?php echo esc_attr( $returns_recipient->first_name() ); ?>">
</p>

<p>
	<label>
		<?php esc_html_e( 'Last name', 'correoswc' ); ?>
		<span class="we-required">**</span>
	</label>
	<input type="text" name="metabox-returns-form[recipient_last_name]" value="<?php echo esc_attr( $returns_recipient->last_name() ); ?>">
</p>

<p>
	<label>
		<?php esc_html_e( 'DNI', 'correoswc' ); ?>
	</label>
	<input type="text" name="metabox-returns-form[recipient_dni]" value="<?php echo esc_attr( $returns_recipient->dni() ); ?>">
</p>

<p>
	<label>
		<?php esc_html_e( 'Company', 'correoswc' ); ?>
		<span class="we-required">**</span>
	</label>
	<input type="text" name="metabox-returns-form[recipient_company]" value="<?php echo esc_attr( $returns_recipient->company() ); ?>">
</p>

<p>
	<label>
		<?php esc_html_e( 'Contact', 'correoswc' ); ?>
		<span class="we-required">**</span>
	</label>
	<input type="text" name="metabox-returns-form[recipient_contact]" value="<?php echo esc_attr( $returns_recipient->contact() ); ?>">
</p>

<p>
	<label>
		<?php esc_html_e( 'Address', 'correoswc' ); ?>
		<span class="we-required">*</span>
	</label>
	<input type="text" name="metabox-returns-form[recipient_address]" value="<?php echo esc_attr( $returns_recipient->address() ); ?>">
</p>

<p>
	<label>
		<?php esc_html_e( 'City', 'correoswc' ); ?>
		<span class="we-required">*</span>
	</label>
	<input type="text" name="metabox-returns-form[recipient_city]" value="<?php echo esc_attr( $returns_recipient->city() ); ?>">
</p>

<p>
	<label>
		<?php esc_html_e( 'State', 'correoswc' ); ?>
		<span class="we-required">*</span>
	</label>
	<select name="metabox-returns-form[recipient_state]">
		<?php foreach ( $states_options as $key => $name ) : ?>

			<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $returns_recipient->state(), $key ); ?>>
				<?php echo esc_html( $name ); ?>
			</option>

		<?php endforeach ?>
	</select>
</p>

<p>
	<label>
		<?php esc_html_e( 'CP', 'correoswc' ); ?>
		<span class="we-required">*</span>
	</label>
	<input type="text" name="metabox-returns-form[recipient_cp]" value="<?php echo esc_attr( $returns_recipient->cp() ); ?>"">
</p>

<p>
	<label>
		<?php esc_html_e( 'Phone', 'correoswc' ); ?>
	</label>
	<input type="text" name="metabox-returns-form[recipient_phone]" value="<?php echo esc_attr( $returns_recipient->phone() ); ?>"">
</p>

<p>
	<label>
		<?php esc_html_e( 'Email', 'correoswc' ); ?>
	</label>
	<input type="text" name="metabox-returns-form[recipient_email]" value="<?php echo esc_attr( $returns_recipient->email() ); ?>"">
</p>
