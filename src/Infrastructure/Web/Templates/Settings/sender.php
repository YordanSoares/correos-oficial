<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

use WooEnvio\WECorreos\Domain\Model\Settings\Sender\Sender;

?>
<tr>
	<td class="we-group-table-td-checkbox">
		<input type="checkbox" class="js-we-group-checkbox">
	</td>
	<td>
		<table class="we-group-table-row">
			<thead>
				<tr>
					<td colspan="4">
						<strong class="js-we-group-alias"><?php echo esc_html( $this->e( $sender->alias() ) ); ?></strong>
						<input type="checkbox" name="settings-senders-form[senders][<?php echo esc_attr( $sender->key() ); ?>][default]" value="1" class="js-we-group-default" <?php echo $sender->is_default() ? 'checked' : ''; ?>><?php esc_html_e( 'Default sender', 'wecorres' ); ?>
						<a href="#" class="js-group-show-hide-info"><?php esc_html_e( 'Show/Hide Info', 'correoswc' ); ?></a>
					</td>
				</tr>
			</thead>
			<tbody style="display: none;">
				<tr>
					<td>
						<label for="settings-sender-form[senders][<?php echo esc_attr( $sender->key() ); ?>][alias]"><?php esc_html_e( 'Alias', 'correoswc' ); ?><span class="we-required">*</span></label>
						<input type="text" name="settings-senders-form[senders][<?php echo esc_attr( $sender->key() ); ?>][alias]" value="<?php echo esc_attr( $this->e( $sender->alias() ) ); ?>"
						class="js-we-group-alias-change-event">
					</td>
					<td>
						<label for="settings-sender-form[senders][<?php echo esc_attr( $sender->key() ); ?>][first_name]"><?php esc_html_e( 'First name', 'correoswc' ); ?><span class="we-required">**</span></label>
						<input type="text" name="settings-senders-form[senders][<?php echo esc_attr( $sender->key() ); ?>][first_name]" value="<?php echo esc_attr( $this->e( $sender->first_name() ) ); ?>">
					</td>
					<td>
						<label for="settings-sender-form[senders][<?php echo esc_attr( $sender->key() ); ?>][last_name]"><?php esc_html_e( 'Last name', 'correoswc' ); ?><span class="we-required">**</span></label>
						<input type="text" name="settings-senders-form[senders][<?php echo esc_attr( $sender->key() ); ?>][last_name]" value="<?php echo esc_attr( $this->e( $sender->last_name() ) ); ?>">
					</td>
					<td>
						<label for="settings-sender-form[senders][<?php echo esc_attr( $sender->key() ); ?>][company]"><?php esc_html_e( 'Company', 'correoswc' ); ?><span class="we-required">**</span></label>
						<input type="text" name="settings-senders-form[senders][<?php echo esc_attr( $sender->key() ); ?>][company]" value="<?php echo esc_attr( $this->e( $sender->company() ) ); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<label for="settings-sender-form[senders][<?php echo esc_attr( $sender->key() ); ?>][contact]"><?php esc_html_e( 'Contact', 'correoswc' ); ?><span class="we-required">**</span></label>

						<input type="text" name="settings-senders-form[senders][<?php echo esc_attr( $sender->key() ); ?>][contact]" value="<?php echo esc_attr( $this->e( $sender->contact() ) ); ?>">
					</td>
					<td>
						<label for="settings-sender-form[senders][<?php echo esc_attr( $sender->key() ); ?>][dni]"><?php esc_html_e( 'DNI', 'correoswc' ); ?><span class="we-required">**</span></label>
						<input type="text" name="settings-senders-form[senders][<?php echo esc_attr( $sender->key() ); ?>][dni]" value="<?php echo esc_attr( $this->e( $sender->dni() ) ); ?>">
					</td>
					<td>
						<label for="settings-sender-form[senders][<?php echo esc_attr( $sender->key() ); ?>][address]"><?php esc_html_e( 'Address', 'correoswc' ); ?><span class="we-required">*</span></label>

						<input type="text" name="settings-senders-form[senders][<?php echo esc_attr( $sender->key() ); ?>][address]" value="<?php echo esc_attr( $this->e( $sender->address() ) ); ?>">
					</td>
					<td>
						<label for="settings-sender-form[senders][<?php echo esc_attr( $sender->key() ); ?>][city]"><?php esc_html_e( 'City', 'correoswc' ); ?><span class="we-required">*</span></label>

						<input type="text" name="settings-senders-form[senders][<?php echo esc_attr( $sender->key() ); ?>][city]" value="<?php echo esc_attr( $this->e( $sender->city() ) ); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<label for="settings-sender-form[senders][<?php echo esc_attr( $sender->key() ); ?>][state]"><?php esc_html_e( 'State', 'correoswc' ); ?><span class="we-required">*</span></label>

						<select name="settings-senders-form[senders][<?php echo esc_attr( $sender->key() ); ?>][state]" class="js-state-sender-field">
							<?php foreach ( $states_options as $option => $label ) : ?>

								<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $sender->state(), $option ); ?>>
									<?php echo esc_html( $label ); ?>
								</option>

							<?php endforeach ?>
						</select>
					</td>
					<td>
						<label for="settings-sender-form[senders][<?php echo esc_attr( $sender->key() ); ?>][cp]"><?php esc_html_e( 'CP', 'correoswc' ); ?><span class="we-required">*</span></label>
						<input type="text" name="settings-senders-form[senders][<?php echo esc_attr( $sender->key() ); ?>][cp]" value="<?php echo esc_attr( $this->e( $sender->cp() ) ); ?>">
					</td>
					<td>
						<label for="settings-sender-form[senders][<?php echo esc_attr( $sender->key() ); ?>][email]"><?php esc_html_e( 'Email', 'correoswc' ); ?><span class="we-required">*</span></label>
						<input type="text" name="settings-senders-form[senders][<?php echo esc_attr( $sender->key() ); ?>][email]" value="<?php echo esc_attr( $this->e( $sender->email() ) ); ?>">
					</td>
					<td>
						<label for="settings-sender-form[senders][<?php echo esc_attr( $sender->key() ); ?>][phone]"><?php esc_html_e( 'Phone', 'correoswc' ); ?></label>
						<input type="text" name="settings-senders-form[senders][<?php echo esc_attr( $sender->key() ); ?>][phone]" value="<?php echo esc_attr( $this->e( $sender->phone() ) ); ?>">
					</td>
				</tr>
			<tr>
				<td>
					<label for="settings-sender-form[senders][<?php echo esc_attr( $sender->key() ); ?>][country]"><?php esc_html_e( 'Country', 'correoswc' ); ?></label>
					<select name="settings-senders-form[senders][<?php echo esc_attr( $sender->key() ); ?>][country]" class="js-country-sender-field">
						<?php foreach ( $country_options as $option => $label ) : ?>

							<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $sender->country(), $option ); ?>>
								<?php echo esc_html( $label ); ?>
							</option>

						<?php endforeach ?>
					</select>
				</td>
				<td colspan="3"></td>
			</tr>
			</tbody>
		</table>
	</td>
</tr>
