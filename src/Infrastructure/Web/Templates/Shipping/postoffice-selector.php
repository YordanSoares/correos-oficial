<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<select id="wecorreos-select-office-form-element" name="wecorreos-select-office-form[selected_office]" class="js-wc-select2 js-ajax-select-coord" style="width:100%;">

	<?php foreach ( $postoffices as $code => $postoffice ) : ?>

		<option value="<?php echo esc_attr( $code ); ?>"
			data-latitude="<?php echo esc_attr( $postoffice['latitude'] ); ?>"
			data-longitude="<?php echo esc_attr( $postoffice['longitude'] ); ?>">
				<?php echo esc_html( $postoffice['label'] ); ?>
		</option>

	<?php endforeach ?>

</select>
