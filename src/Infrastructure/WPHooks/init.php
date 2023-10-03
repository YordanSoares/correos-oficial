<?php //phpcs:ignoreFile
/**
 * WPHooks
 *
 * @package wooenvio/wecorreos
 */

if ( ! wp_doing_ajax() ) {

	add_action(
		'init', function() use ( $cowc_container ) {

			try {
				$cowc_container['label_files']->create_download_base_path_or_fail();

			} catch ( Exception $e ) {

				add_action(
					'admin_notices', function() use ( $cowc_container, $e ) {

						echo $cowc_container['plates']->render(
							'error', [
								'error'        => $e->getMessage(),
								'link_support' => $cowc_container['we_support'],
							]
						);
					}
				);
			}
		}
	);

	add_action(
		'init', function() use ( $cowc_container ) {

			try {
				$maybeUpdateDatabase = $cowc_container['maybe_update_database'];

				$maybeUpdateDatabase();

			} catch ( Exception $e ) {

				$logger = wc_get_logger();

				$logger->error( $e->getMessage(), [ 'source' => 'wecorreos' ] );
			}

		}, 5
	);
}
