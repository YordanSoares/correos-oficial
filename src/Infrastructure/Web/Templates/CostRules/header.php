<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<thead>
	<tr>
		<td class="we-charge-rules-checkbox">
			<input type="checkbox" class="js-we-group-select-all">
		</td>
		<td>
			<?php esc_html_e( 'Shipping Class', 'correoswc' ); ?>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'All products, whihtout class or a certain class.', 'correoswc' ); ?>"></span>
		</td>
		<td>
			<?php esc_html_e( 'Condition', 'correoswc' ); ?>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Condition rule. Cost, weight o volume', 'correoswc' ); ?>"></span>
		</td>
		<td>
			<?php esc_html_e( 'From (minimum)', 'correoswc' ); ?>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( '[&gt;=] Units for &quot;weight&quot; and &quot;volume&quot; are configurated on settings WooCommerce.', 'correoswc' ); ?>"></span>
		</td>
		<td>
			<?php esc_html_e( 'To (maximum)', 'correoswc' ); ?>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( '[&lt;] If =0 not maximum (Set 0 on &quot;Cost per adional unit&quot;). Units for &quot;weight&quot; and &quot;volume&quot; are configurated on settings WooCommerce.', 'correoswc' ); ?>"></span>
		</td>
		<td>
			<?php esc_html_e( 'Cost', 'correoswc' ); ?>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Rule Cost', 'correoswc' ); ?>"></span>
		</td>
		<td>
			<?php esc_html_e( 'Cost Per Additional Unit', 'correoswc' ); ?>
			<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Cort per additional unit', 'correoswc' ); ?>"></span>
		</td>
	</tr>
</thead>
