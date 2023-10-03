<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div class="we-table-tracking">

	<?php foreach ( $tracking_events as $event ) : ?>

		<div>
			<span><strong><?php echo esc_html( $event->fecEvento); ?></strong>: </span>
			<span><?php echo esc_html( utf8_decode( $event->desTextoResumen )); ?></span>
		</div>

	<?php endforeach ?>

</div>
