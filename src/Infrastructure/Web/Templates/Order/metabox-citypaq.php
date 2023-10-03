<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<hr/>

<?php $this->insert( 'shipping::citypaq-section', compact( 'citypaqs', 'postalcode', 'order_id', 'correos_type', 'states_options' ) ); ?>

<p>
	<a href="#" id="wecorreos_force_correos_shipping_second"
		form="wecorreos-select-citypaq-form"
		action="wecorreos_force_correos_shipping"
		message_id="we-message-metabox"
		block_element="wecorreos-order-metabox"
		class="js-ajax-post-request button">
		<?php esc_html_e( 'Generate shipping', 'correoswc' ); ?>
	</a>
</p>

