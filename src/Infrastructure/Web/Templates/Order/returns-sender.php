<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<h3><?php esc_html_e( 'Sender Data', 'correoswc' ); ?></h3>

<p>
	<label>
		<?php esc_html_e( 'First name', 'correoswc' ); ?>
		<span class="we-required">**</span>
	</label>
	<input type="text" name="metabox-returns-form[sender_first_name]" value="<?php echo esc_attr( $returns_sender->first_name() ); ?>">
</p>

<p>
	<label>
		<?php esc_html_e( 'Last name', 'correoswc' ); ?>
		<span class="we-required">**</span>
	</label>
	<input type="text" name="metabox-returns-form[sender_last_name]" value="<?php echo esc_attr( $returns_sender->last_name() ); ?>">
</p>

<p>
	<label>
		<?php esc_html_e( 'DNI', 'correoswc' ); ?>
	</label>
	<input type="text" name="metabox-returns-form[sender_dni]" value="<?php echo esc_attr( $returns_sender->dni() ); ?>">
</p>

<p>
	<label>
		<?php esc_html_e( 'Company', 'correoswc' ); ?>
		<span class="we-required">**</span>
	</label>
	<input type="text" name="metabox-returns-form[sender_company]" value="<?php echo esc_attr( $returns_sender->company() ); ?>">
</p>

<p>
	<label>
		<?php esc_html_e( 'Contact', 'correoswc' ); ?>
		<span class="we-required">**</span>
	</label>
	<input type="text" name="metabox-returns-form[sender_contact]" value="<?php echo esc_attr( $returns_sender->contact() ); ?>">
</p>

<p>
	<label>
		<?php esc_html_e( 'Address', 'correoswc' ); ?>
		<span class="we-required">*</span>
	</label>
	<input type="text" name="metabox-returns-form[sender_address]" value="<?php echo esc_attr( $returns_sender->address() ); ?>">
</p>

<p>
	<label>
		<?php esc_html_e( 'City', 'correoswc' ); ?>
		<span class="we-required">*</span>
	</label>
	<input type="text" name="metabox-returns-form[sender_city]" value="<?php echo esc_attr( $returns_sender->city() ); ?>">
</p>

<p>
	<label>
		<?php esc_html_e( 'State', 'correoswc' ); ?>
		<span class="we-required">*</span>
	</label>
	<select name="metabox-returns-form[sender_state]">
		<?php foreach ( $states_options as $key => $name ) : ?>

			<option value="<?php echo esc_attr( $key ); ?>"  <?php selected( $returns_sender->state(), $key ); ?>>
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
	<input type="text" name="metabox-returns-form[sender_cp]" value="<?php echo esc_attr( $returns_sender->cp() ); ?>"">
</p>

<p>
	<label>
		<?php esc_html_e( 'Phone', 'correoswc' ); ?>
	</label>
	<input type="text" name="metabox-returns-form[sender_phone]" value="<?php echo esc_attr( $returns_sender->phone() ); ?>"">
</p>

<p>
	<label>
		<?php esc_html_e( 'Email', 'correoswc' ); ?>
	</label>
	<input type="text" name="metabox-returns-form[sender_email]" value="<?php echo esc_attr( $returns_sender->email() ); ?>"">
</p>
