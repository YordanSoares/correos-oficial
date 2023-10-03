<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div class="we-featured-header">

	<h3 style="margin: 0 0 .5em; border-bottom: 1px solid white;padding-bottom:.3em;">
		<?php echo esc_html( $order->shipping_name() ); ?>
	</h3>

	<div class="we-table">

		<?php if ( ! is_null( $correos_id ) ) : ?>

			<div class="we-row">
				<div class="we-label"><?php esc_html_e( 'ID', 'correoswc' ); ?>: </div>
				<div class="we-cell"><?php echo esc_html( $correos_id); ?></div>
			</div>

		<?php endif ?>

		<?php if ( $order->payment_on_delivery() ) : ?>

			<div class="we-row">
				<div class="we-label"><?php esc_html_e( 'Payment', 'correoswc' ); ?>:</div>
				<div class="we-cell"><?php echo esc_html( $order->payment_name() ); ?></div>
			</div>

		<?php endif ?>

		<div class="we-row">
			<div class="we-label"><?php esc_html_e( 'Addr.', 'correoswc' ); ?>:</div>
			<div class="we-cell"><?php echo wp_kses_post( $order->address() ); ?></div>
		</div>

	</div>

</div>
