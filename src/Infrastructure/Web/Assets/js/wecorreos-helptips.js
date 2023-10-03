jQuery(
	function ($) {

		$( document.body ).on(
			'init_tooltips', function () {
				var tiptip_args = {
					'attribute': 'data-tip',
					'fadeIn': 50,
					'fadeOut': 50,
					'delay': 200
				};

				$( '.tips, .help_tip, .woocommerce-help-tip' ).tipTip( tiptip_args );
			}
		);

		// Tooltips
		$( document.body ).trigger( 'init_tooltips' );
	}
);
