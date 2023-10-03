<?php use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Package\Package ?>

	
<!-- ini -->	
<hr class="we-hr">

<div id="wecorreos-multipackage-returns">

	<div id="wecorreos_package_return1" class="wecorreos-package-return">

		<p>
		<label>
		Peso<span class="we-required">*</span>
		<span class="woocommerce-help-tip"></span>
		</label>
		<input type="text" name="metabox-returns-form[packages][1][weight]" value="0">
		kg	</p>

		<p>
		<label for="metabox-returns-form[width]">
		Ancho</label>
		<input type="text" name="metabox-returns-form[packages][1][width]" value="0">
		cm	</p>

		<p>
		<label>
		Alto</label>
		<input type="text" name="metabox-returns-form[packages][1][height]" value="0">
		cm	</p>

		<p>
		<label>
		Largo</label>
		<input type="text" name="metabox-returns-form[packages][1][length]" value="0">
		cm	</p>



		<hr class="we-hr">
		<input type="radio" name="metabox-returns-form[packages][1][customs_check_description_and_tariff]" checked="" value="radio_tariff_number" class="we-customs-desription-and-tariff" aria-label="Choose description of Tariff Number">
		<label for="metabox-returns-form[customs_tariff_number]">
		Número Tarifario<span class="woocommerce-help-tip"></span>
		</label><br>
        
        <?php $tariff_number_options = Package::tariff_humber();?>

		<select name="metabox-returns-form[packages][1][customs_tariff_number]" id="customs_tariff_number">
            <?php foreach ( $tariff_number_options as $option => $label ) : ?>
							<option value="<?php echo esc_html( $label ); ?>" <?php  selected( get_option('wecorreos_customs_tariff_number'), $label );  ?>>
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach ?>
		</select>

        <?php $description_customs_options = Package::customs_options(); ?>

		<br>
		<div class="we-tariff">
			<span class="we-tariff-description-legend">Descripción</span><br>
			<input class="we-tariff-description we-tariff-description-input" type="text" name="metabox-returns-form[packages][1][customs_tariff_description]" id="customs_tariff_description" value="<?php  echo get_option('wecorreos_customs_tariff_description'); ?>" aria-label="Descripción">
		</div>

		<hr class="we-hr">
		<input type="radio" name="metabox-returns-form[packages][1][customs_check_description_and_tariff]" value="radio_description_by_default" class="we-customs-desription-and-tariff" aria-label="Choose description of Tariff Number">

		<label>
			Descripción del primer artículo</label>
		<br>
        <?php $description_customs_options = Package::customs_options(); ?>
        <?php $first_item_description=get_option('wecorreos_settings_customs'); ?>

		<select name="metabox-returns-form[packages][1][first_item_description]">

        <?php foreach ( $description_customs_options as $key => $description ) : ?>

            <option value="<?php echo esc_attr( $key ); ?>"  <?php selected( $first_item_description['customs_default_description'], $key ); ?>>
                <?php echo esc_html( $description ); ?>
            </option>

        <?php endforeach ?>		</select>

		<p>
			<label>
				<?php esc_html_e( 'First product value', 'correoswc' ); ?>
				<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Net value of the first item', 'correoswc' ); ?>"></span>
			</label>
			<input type="text" name="metabox-returns-form[packages][1][first_item_value]" value="0">
			<?php esc_html_e( '€', 'correoswc' ); ?>
			</p>

		<hr class="we-hr">
	</div>
	<!-- fin	-->

	

	<i id="final_rule"></i>

	<script>
	var wecorreos_errorNoDescriptionFound='Si selecciona nº tarifario debe seleccionar una descripción';
	</script>

</div>

<a  href="#"
		class="js-ajax-post-request_return button"
		>
		<?php esc_html_e( 'Add package', 'correoswc' ); ?>
	</a>

	<a  href="#"
		class="js-ajax-delete-last-element_return button"
		>
		<?php esc_html_e( 'Delete package', 'correoswc' ); ?>
	</a>

<p>
	<a href="#" id="wecorreos_obtain_returns" action="wecorreos_obtain_returns" form="metabox-returns-form" message_id="we-message-metabox" block_element="wecorreos-order-metabox" class="js-ajax-post-request button-primary">
	<?php esc_html_e('Return Label', 'correoswc'); ?>
	</a>
</p>