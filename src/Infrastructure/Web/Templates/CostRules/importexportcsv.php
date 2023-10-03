<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div class="we-charge-rules-import-export-csv">
	<p>
		<strong><?php esc_html_e( 'Import Rules from CSV file', 'correoswc' ); ?></strong>
	</p>

	<div id="client-messages">
	</div>

	<p>
		<input type="file" name="csv_files" multiple></input>
	</p>

	<p>
		<a href="#" class="button js-charge-rules-import-csv"><?php esc_html_e( 'Import rules (csv)', 'correoswc' ); ?></a>
	</p>
</div>
