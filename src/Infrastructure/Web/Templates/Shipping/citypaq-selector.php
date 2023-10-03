<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<select id="wecorreos-select-citypaq-form-element" name="wecorreos-select-citypaq-form[selected_citypaq]" class="js-wc-select2 js-ajax-select-coord" style="width:100%;">

	<?php foreach ( $citypaqs as $code => $citypaq ) : ?>

		<option value="<?php echo esc_attr( $code ); ?>"
				data-latitude="<?php echo esc_attr( $citypaq['latitude'] ); ?>"
				data-longitude="<?php echo esc_attr( $citypaq['longitude'] ); ?>">
			<?php echo esc_html( $citypaq['label'] ); ?>
		</option>

	<?php endforeach ?>

</select>
