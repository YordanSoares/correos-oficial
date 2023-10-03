<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<tr>
	<td class="we-charge-rules-checkbox">
		<input type="checkbox" class="js-we-group-checkbox">
	</td>
	<td>
		<select id="<?php echo esc_attr( $formName ); ?>[shipping_class][<?php echo esc_attr( $key ); ?>]" name="<?php echo esc_attr( $formName ); ?>[shipping_class][<?php echo esc_attr( $key ); ?>]" class="we-charge-rules-field" >

			<?php foreach ( $shipping_class_options as $condition => $label ) : ?>

				<option value="<?php echo esc_attr( $condition ); ?>" <?php echo $condition == $value['shipping_class'][ $key ] ? 'selected' : ''; // phpcs:ignore ?>><?php echo $label; ?></option>

			<?php endforeach ?>

		</select>
	</td>
	<td>
		<select id="<?php echo esc_attr( $formName ); ?>[condition][<?php echo esc_attr( $key ); ?>]" name="<?php echo esc_attr( $formName ); ?>[condition][<?php echo esc_attr( $key ); ?>]" class="we-charge-rules-field" >

			<?php foreach ( $condition_options as $condition => $label ) : ?>

				<option value="<?php echo esc_attr( $condition ); ?>" <?php echo $condition == $value['condition'][ $key ] ? 'selected' : ''; // phpcs:ignore ?>><?php echo $label; ?></option>

			<?php endforeach ?>

		</select>
	</td>
	<td>
		<input id="<?php echo esc_attr( $formName ); ?>[min][<?php echo esc_attr( $key ); ?>]" type="text" name="<?php echo esc_attr( $formName ); ?>[min][<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $value['min'][ $key ] ); ?>" class="we-charge-rules-field" >
	</td>
	<td>
		<input id="<?php echo esc_attr( $formName ); ?>[max][<?php echo esc_attr( $key ); ?>]" type="text" name="<?php echo esc_attr( $formName ); ?>[max][<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $value['max'][ $key ] ); ?>" class="we-charge-rules-field" >
	</td>
	<td>
		<input id="<?php echo esc_attr( $formName ); ?>[cost][<?php echo esc_attr( $key ); ?>]" type="text" name="<?php echo esc_attr( $formName ); ?>[cost][<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $value['cost'][ $key ] ); ?>" class="we-charge-rules-field" >
	</td>
	<td>
		<input id="<?php echo esc_attr( $formName ); ?>[cost_per_additional_unit][<?php echo esc_attr( $key ); ?>]" type="text" name="<?php echo esc_attr( $formName ); ?>[cost_per_additional_unit][<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $value['cost_per_additional_unit'][ $key ] ); ?>" class="we-charge-rules-field" >
	</td>
</tr>
