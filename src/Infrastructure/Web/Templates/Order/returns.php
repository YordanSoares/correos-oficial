<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div id="metabox-returns-form" class="we-form-metabox we-form-tabs" style="display:none;">

	<div id="metabox-returns-form-header">
		<?php if (! is_null($returns_download_link)) : ?>

		<?php $this->insert('order::returns-header', compact('returns_download_link', 'returns_id')); ?>

		<?php endif ?>
	</div>

	<input type="hidden" name="metabox-returns-form[order_id]" value="<?php echo esc_attr($order->order_id()); ?>">

	<?php
    $this->insert(
    'order::returns-sender',
    [
            'returns_sender' => $returns->returns_sender(),
            'states_options' => $states_options,
        ]
    )
    ?>

	<?php
    $this->insert(
        'order::returns-recipient',
        [
            'returns'           => $returns,
            'returns_recipient' => $returns->returns_recipient(),
            'states_options'    => $states_options,
            'sender_list'       => $sender_list,
        ]
    )
    ?>

	<p>
		<label>
		<?php esc_html_e('Cost', 'correoswc'); ?>
		<span class="we-required">*</span>
		<span class="woocommerce-help-tip" data-tip="<?php esc_html_e('Returns cost to pay on Correos office from Customer', 'correoswc'); ?>"></span>
		</label>
		<input type="text" name="metabox-returns-form[return_cost]" value="<?php echo esc_attr($returns->return_cost()); ?>">
		<?php esc_html_e('€', 'correoswc'); ?>
	</p>

	<p>
		<label>
		<?php esc_html_e('CCC', 'correoswc'); ?>
		<span class="we-required">*</span>
		<span class="woocommerce-help-tip" data-tip="<?php esc_html_e('Bank account number / IBAN. Correos pay "payment sender" in this account. (Required if payment sender greater than 0)', 'correoswc'); ?>"></span>
		</label>
		<input type="text" name="metabox-returns-form[return_ccc]" value="<?php echo esc_attr($returns->return_ccc()); ?>">
		<?php esc_html_e('€', 'correoswc'); ?>
	</p>

	<?php
    $this->insert(
        'order::returns-row-package',
        [
            'package_list'           => $returns->package_list(),
        ]
    )
    ?>

</div>
