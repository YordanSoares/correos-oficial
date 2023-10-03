jQuery(
	function ($) {

		var self;
		var wrapper;

		var wecorreosChangeTab = {

			init: function () {
				self    = this;
				wrapper = $( '.' + change_settings.wrapper );

				wrapper.on(
					'click', 'a.js-wecorreos-change-tab', function (event) {
						event.preventDefault();
						self.changeTab( this );
					}
				)
			},

			changeTab: function (selectedTab) {
				$.each(
					wrapper.find( 'a.js-wecorreos-change-tab' ), function (index, tab) {
						$( tab ).removeClass( 'nav-tab-active' );
					}
				)
				$( selectedTab ).addClass( 'nav-tab-active' );
				$.each(
					wrapper.find( '.we-form-tabs' ), function (index, form) {
						$( form ).hide();
					}
				)
				$( '#' + $( selectedTab ).attr( 'form' ) ).show();
			},
		};

		wecorreosChangeTab.init();
	}
);
