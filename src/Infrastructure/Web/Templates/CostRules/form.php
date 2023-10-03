<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div id="we-message-chargerules"></div>
<table id="<?php echo esc_attr( $formName ); ?>" class="we-charge-rules-table we-group-table">

	<?php $this->insert( 'header' ); ?>

	<tbody id="we-costrules-body">

		<?php foreach ( $keys as $key ) : ?>

			<?php $this->insert( 'row', compact( 'value', 'formName', 'key', 'condition_options', 'shipping_class_options' ) ); ?>

		<?php endforeach ?>

	</tbody>

	<?php $this->insert( 'footer', compact( 'formName' ) ); ?>

</table>

<?php $this->insert( 'importexportcsv' ); ?>
