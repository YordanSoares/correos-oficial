<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>


<?php if ( $display_multipackage ) : ?>

	<div id="wecorreos-multipackage">

		<?php foreach ( $package_list->packages() as $package ) : ?>

			<?php $this->insert( 'order::label-row-package', compact( 'package' ) ); ?>

		<?php endforeach ?>

	</div>

	<a  href="#"
		action="wecorreos_add_package"
		form="metabox-label-form"
		add_id="wecorreos-multipackage"
		message_id="we-message-metabox"
		block_element="wecorreos-order-metabox"
		class="js-ajax-post-request button"
		>
		<?php esc_html_e( 'Add package', 'correoswc' ); ?>
	</a>

	<a  href="#"
		parent="wecorreos-multipackage"
		message_id="we-message-metabox"
		almostone="1"
		block_element="wecorreos-order-metabox"
		class="js-ajax-delete-last-element button"
		>
		<?php esc_html_e( 'Delete package', 'correoswc' ); ?>
	</a>

<?php else : ?>

	<?php $this->insert( 'order::label-row-package', [ 'package' => $package_list->first() ] ); ?>

<?php endif ?>
