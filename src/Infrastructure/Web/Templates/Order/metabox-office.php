<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<hr/>

<?php $this->insert( 'shipping::postoffice-section', compact( 'postoffices', 'postalcode', 'order_id', 'correos_type' ) ); ?>

<p>
	<a href="#" id="wecorreos_force_correos_shipping_second"
		form="wecorreos-select-office-form"
		action="wecorreos_force_correos_shipping"
		message_id="we-message-metabox"
		block_element="wecorreos-order-metabox"
		class="js-ajax-post-request button">
		<?php esc_html_e( 'Generate shipping', 'correoswc' ); ?>
	</a>
</p>

