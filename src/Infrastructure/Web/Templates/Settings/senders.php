<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div id="settings-senders-form" class="we-form-settings we-form-tabs" style="display:none;">

	<p>
		<span class="we-required">* </span><?php esc_html_e( 'Fields are required', 'correoswc' ); ?>: <strong><?php esc_html_e( 'Email, State, City, CP and Address', 'correoswc' ); ?></strong>
		<br/>
		<span class="we-required">** </span><?php esc_html_e( 'Sender needs:', 'correoswc' ); ?>
		<?php esc_html_e( 'First and Second name or Company and Contact.', 'correoswc' ); ?>
		<?php esc_html_e( 'If you fill all of them has preference company + contact person.', 'correoswc' ); ?>
	</p>

	<hr/>

	<div class="we-group">

		<table class="we-group-table">

			<thead>
				<tr>
					<td class="we-group-table-td-checkbox">
						<input type="checkbox" class="js-we-group-select-all">
					</td>
					<td>
						<strong><?php esc_html_e( 'Senders', 'correoswc' ); ?></strong>
					</td>
				</tr>
			</thead>

			<tbody id="senders-list">

				<?php foreach ( $senders->sender_list()->senders() as $sender ) : ?>
					<?php $this->insert( 'settings::sender', compact( 'sender', 'states_options', 'country_options' ) ); ?>
				<?php endforeach ?>

			</tbody>

			<tfoot>
				<tr>
					<td colspan="2">
						<a href="#" action="wecorreos_add_sender" form="settings-senders-form" add_id="senders-list" message_id="we-message-settings" block_element="wecorreos-settings" class="js-ajax-add-row button">
							<?php esc_html_e( 'Add sender', 'correoswc' ); ?>
						</a>
						<a href="#" class="button js-we-group-remove" remove_all_allowed="false">
							<?php esc_html_e( 'Delete sender/s', 'correoswc' ); ?>
						</a>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>

	<p>
		<a href="#" form="settings-senders-form" action="wecorreos_save_senders" message_id="we-message-settings" block_element="wecorreos-settings" class="js-ajax-post-request button-primary">
			<?php esc_html_e( 'Save', 'correoswc' ); ?>
		</a>
	</p>
</div>

