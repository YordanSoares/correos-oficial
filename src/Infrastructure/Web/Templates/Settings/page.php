<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div id="wecorreos-settings" class="wecorreos-settings we-form">
	<?php echo esc_html( $message ); ?>
	<div id="we-message-settings">

	</div>

	<?php $this->insert( 'settings::tabs' ); ?>

	<?php $this->insert( 'settings::general', compact( 'general', 'images_url', 'order_statuses' ) ); ?>
	<?php $this->insert( 'settings::senders', compact( 'senders', 'states_options', 'country_options' ) ); ?>
	<?php $this->insert( 'settings::customs', compact( 'customs', 'description_customs_options', 'tariff_number_options' ) ); ?>

</div>


