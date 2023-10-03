<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div id="wecorreos-order-metabox-all" class="wecorreos-order-metabox">

	<div id="wecorreos-order-metabox-header">

		<?php $this->insert( 'order::header', compact( 'order', 'correos_id' ) ); ?>

	</div>

	<div id="we-message-metabox"></div>

	<?php
	$this->insert(
		'order::tabs', compact(
			'customs',
			'returns'
		)
	)
	?>

	<?php
	$this->insert(
		'order::label', compact(
			'label',
			'correos_id',
			'label_download_link',
			'order',
			'sender_list',
			'customs',
			'description_customs_options',
			'display_multipackage'
		)
	)
	?>

	<?php
	if ( ! is_null( $customs ) ) {
		$this->insert(
			'order::customs', compact(
				'customs',
				'order',
				'doc_links',
				'display_request_declaration'
			)
		); }
	?>

	<?php
	if ( ! is_null( $returns ) ) {
		$this->insert(
			'order::returns', compact(
				'returns_download_link',
				'returns_id',
				'returns',
				'states_options',
				'sender_list',
				'order'
			)
		); }
	?>

	<img style="padding: 10px;margin: 0 auto; display: block;" src="<?php echo esc_attr( $logo ); ?>"/>
</div>
