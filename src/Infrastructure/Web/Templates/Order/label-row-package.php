<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<?php use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Package\Package ?>

<div class="wecorreos-package">

	<p>
		<label>
			<?php esc_html_e( 'Weight', 'correoswc' ); ?>
			<span class="we-required">*</span>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'The weight must be a number between 0 and 30', 'correoswc' ); ?>"></span>
		</label>
		<input type="text" name="metabox-label-form[packages][<?php echo esc_attr( $package->key() ); ?>][weight]" value="<?php echo esc_attr( $package->weight() ); ?>">
		<?php esc_html_e( 'kg', 'correoswc' ); ?>
	</p>

	<p>
		<label for="metabox-label-form[width]">
			<?php esc_html_e( 'Width', 'correoswc' ); ?>
		</label>
		<input type="text" name="metabox-label-form[packages][<?php echo esc_attr( $package->key() ); ?>][width]" value="<?php echo esc_attr( $package->width() ); ?>">
		<?php esc_html_e( 'cm', 'correoswc' ); ?>
	</p>

	<p>
		<label>
			<?php esc_html_e( 'Height', 'correoswc' ); ?>
		</label>
		<input type="text" name="metabox-label-form[packages][<?php echo esc_attr( $package->key() ); ?>][height]" value="<?php echo esc_attr( $package->height() ); ?>">
		<?php esc_html_e( 'cm', 'correoswc' ); ?>
	</p>

	<p>
		<label>
			<?php esc_html_e( 'Length', 'correoswc' ); ?>
		</label>
		<input type="text" name="metabox-label-form[packages][<?php echo esc_attr( $package->key() ); ?>][length]" value="<?php echo esc_attr( $package->length() ); ?>">
		<?php esc_html_e( 'cm', 'correoswc' ); ?>
	</p>

	<!-- ini -->
	
	<p>
	    <hr class="we-hr">
		<input type="radio" name="metabox-label-form[packages][<?php echo esc_attr( $package->key() ); ?>][customs_check_description_and_tariff]" <?php if (get_option('wecorreos_customs_check_description_and_tariff')=='radio_tariff_number') echo 'checked';  ?> value="radio_tariff_number" class="we-customs-desription-and-tariff" aria-label="<?php esc_html_e('Choose description of Tariff Number', 'correoswc') ?>">
				<span class="we-tariff">
					<label for="metabox-label-form[customs_tariff_number]">
						<?php esc_html_e( 'Tariff Number', 'correoswc' ); ?>
						<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Tariff number for customs managment that appears in the pre-registration form. It can be changed before pre-registration', 'correoswc' ); ?>"></span>
					</label><br />
					<?php $tariff_number_options = Package::tariff_humber(); ?>

					<select name="metabox-label-form[packages][<?php echo esc_attr( $package->key() ); ?>][customs_tariff_number]" id="customs_tariff_number">
						<?php foreach ( $tariff_number_options as $option => $label ) : ?>
							<option value="<?php echo esc_html( $label ); ?>" <?php  selected( get_option('wecorreos_customs_tariff_number'), $label );  ?>>
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach ?>
					</select>
				</span><br />
				<span class="we-tariff">
						<span class="we-tariff-description-legend"><?php esc_html_e( 'Description', 'correoswc' ); ?></span><br />
						<input class="we-tariff-description we-tariff-description-input" type="text" name="metabox-label-form[packages][<?php echo esc_attr( $package->key() ); ?>][customs_tariff_description]" id="customs_tariff_description" value="<?php  echo get_option('wecorreos_customs_tariff_description'); ?>" aria-label="Descripción">
				</span>
		</p>
		<hr class="we-hr">
		<input type="radio" name="metabox-label-form[packages][<?php echo esc_attr( $package->key() ); ?>][customs_check_description_and_tariff]" <?php  if (get_option('wecorreos_customs_check_description_and_tariff')=='radio_description_by_default') echo 'checked'  ?> value="radio_description_by_default"  class="we-customs-desription-and-tariff" aria-label="<?php esc_html_e('Choose description of Tariff Number', 'correoswc') ?>">		

		<label>
				<?php esc_html_e( 'First product description', 'correoswc' ); ?>
			</label>
			<br />
			<?php $first_item_description=get_option('wecorreos_settings_customs'); ?>
			<select name="metabox-label-form[packages][<?php echo esc_attr( $package->key() ); ?>][first_item_description]">
                <?php $description_customs_options = Package::customs_options(); ?>

				<?php foreach ( $description_customs_options as $key => $description ) : ?>

					<option value="<?php echo esc_attr( $key ); ?>"  <?php selected( $first_item_description['customs_default_description'], $key ); ?>>
						<?php echo esc_html( $description ); ?>
					</option>

				<?php endforeach ?>

			</select>

			<p>
			<label>
				<?php esc_html_e( 'First product value', 'correoswc' ); ?>
				<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Net value of the first item', 'correoswc' ); ?>"></span>
			</label>
			<input type="text" name="metabox-label-form[packages][<?php echo esc_attr( $package->key() ); ?>][first_item_value]" value="<?php echo esc_attr( $package->first_item_value()!='' ? $package->first_item_value() : 0 ); ?>">
			<?php esc_html_e( '€', 'correoswc' ); ?>
			</p>

			<hr class="we-hr">
	<!-- fin	-->
</div>

<script>
var wecorreos_errorNoDescriptionFound='<?php esc_html_e('If you select tariff number you must choice a description', 'correoswc'); ?>';
</script>