<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div class="tabs">

	<h4 class="nav-tab-wrapper">

		<a href="#" class="js-wecorreos-change-tab nav-tab nav-tab-active metabox-label-form" form="metabox-label-form">
			<?php esc_html_e( 'Label', 'correoswc' ); ?>
		</a>

		<?php if ( ! is_null( $customs ) ) : ?>

			<a href="#" class="js-wecorreos-change-tab nav-tab metabox-customs-form" form="metabox-customs-form">
				<?php esc_html_e( 'Customs', 'correoswc' ); ?>
			</a>

		<?php endif ?>

		<?php if ( ! is_null( $returns ) ) : ?>

			<a href="#" class="js-wecorreos-change-tab nav-tab metabox-returns-form" form="metabox-returns-form">
				<?php esc_html_e( 'Returns', 'correoswc' ); ?>
			</a>

		<?php endif ?>

	</h4>

</div>
