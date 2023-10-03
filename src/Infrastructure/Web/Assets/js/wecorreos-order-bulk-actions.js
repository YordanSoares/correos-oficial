jQuery(
	function ($) {

		var self;

		var wecorreosOrdersList = {

			init: function () {

				self = this;

			},

			addBulkActions: function () {
				$.each(
					data_settings_bulk.bulk_actions, function (key, action) {
						var option = $( action );
						option.appendTo( "select[name='action'], select[name='action2']" );
					}
				);
			},

			addMessagesContainer: function () {
				$( '<div id="wecorreos-bulk-message"></div>' ).insertAfter( '.page-title-action' );
			},
		};

		wecorreosOrdersList.addBulkActions();
		wecorreosOrdersList.addMessagesContainer();
	}
);
