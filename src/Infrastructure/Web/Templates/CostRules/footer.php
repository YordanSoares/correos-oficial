<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<tfoot>
	<tr>
		<td colspan="7">
			<a href="#" action="wecorreos_add_costrule" form="<?php echo esc_attr( $formName ); ?>" add_id="we-costrules-body" message_id="we-message-chargerules" block_element="wecorreos-chargerules-form" class="js-ajax-add-row button">
				<?php esc_html_e( 'Add Rule', 'correoswc' ); ?>
			</a>
			<a href="#" class="button js-we-group-remove" remove_all_allowed="true"><?php esc_html_e( 'Delete Rule', 'correoswc' ); ?></a>
			<a href="#" class="button js-charge-rules-export-csv"><?php esc_html_e( 'Export rules (csv)', 'correoswc' ); ?></a>
		</td>
	</tr>
</tfoot>
