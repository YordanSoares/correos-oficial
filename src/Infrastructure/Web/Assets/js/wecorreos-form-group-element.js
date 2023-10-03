jQuery(
	function ($) {

		var self;
		var wrapper;

		var wecorreosFormGroup = {

			init: function () {
				self    = this;
				wrapper = $( '.we-group-table' );

				wrapper.off( 'change', '.js-we-group-default' );
				wrapper.on(
					'change', '.js-we-group-default', function (event) {
						var tableMain = $( this ).closest( '.we-group-table' );
						tableMain.find( '.js-we-group-default' ).prop( 'checked', false );
						$( this ).prop( 'checked', true );
					}
				);

				wrapper.off( 'change', '.js-we-group-select-all' );
				wrapper.on(
					'change', '.js-we-group-select-all', function (event) {
						$( this ).closest( 'table' ).find( '.js-we-group-checkbox' ).prop( 'checked', $( this ).prop( 'checked' ) );
					}
				);

				wrapper.off( 'click', 'a.js-group-show-hide-info' );
				wrapper.on(
					'click', 'a.js-group-show-hide-info', function (event) {
						event.preventDefault();

						var tbody = $( this ).closest( 'table' ).find( 'tbody' );
						tbody.slideToggle();
					}
				)

				wrapper.off( 'change', '.js-we-group-alias-change-event' );
				wrapper.on(
					'change keyup input', '.js-we-group-alias-change-event', function (event) {
						$( this ).closest( 'table' ).find( '.js-we-group-alias' ).text( $( this ).val() );
					}
				);

				wrapper.off( 'click', 'a.js-we-group-add' );
				wrapper.on(
					'click', 'a.js-we-group-add', function (event) {
						event.preventDefault();
						self.addRegister( this );
						self.init;
					}
				);

				wrapper.off( 'click', 'a.js-we-group-remove' )
				wrapper.on(
					'click', 'a.js-we-group-remove', function (event) {
						event.preventDefault();
						self.removeRegister( this );
						self.init;
						self.checkRemoveAllDefault( this );
					}
				);
				wrapper.off( 'change', '.js-country-sender-field' );
				wrapper.on(
					'change', '.js-country-sender-field', function (event) {
						if ($( this ).val() === 'ES') {
							$( this ).closest( 'table' ).find( '.js-state-sender-field option[value="C"]').attr("selected", "selected");
							return;
						}
						if ($( this ).val() === 'AD') {
							$( this ).closest( 'table' ).find( '.js-state-sender-field option[value="ANDORRA"]').attr("selected", "selected");
							return;
						}
					}
				);
			},


			addRegister: function (link) {
				var lastElement = $( link ).closest( 'table' ).find( 'tbody:first > tr:last' );
				var newElement  = lastElement.clone()
				.find( 'input' ).val( '' ).end()
				.find( '.js-we-group-alias' ).text( '...' ).end()
				.find( 'input:checked' ).attr( 'checked', false ).end();

				newElement.find( 'input:not(.js-we-group-checkbox), select' ).each(
					function () {
						self.replaceToNewKey( $( this ) );
					}
				);

				$( lastElement ).after( newElement );

				newElement.find( 'tbody' ).show();
			},

			removeRegister: function (link, remove_all_allowed) {
				var table           = $( link ).closest( 'table' );
				var checkedElements = table.find( 'tbody:first .js-we-group-checkbox:checked' );
				var totalElements   = table.find( 'tbody:first .js-we-group-checkbox' );

				if (checkedElements.length == 0) {
					alert( data_settings.msg_select_one_record )
					return;
				}

				remove_all_allowed = $( link ).attr( 'remove_all_allowed' );

				if ( remove_all_allowed != 'true') {

					if (checkedElements.length == totalElements.length) {
						alert( data_settings.msg_not_delete_all_record )
						return;
					}
				}

				checkedElements.closest( 'tr' ).remove()
			},

			replaceToNewKey: function (element) {
				var nameElement    = String( element.attr( 'name' ) );
				var currentKey     = parseInt( nameElement.match( /(\d+)/ ) );
				var newKey         = currentKey + 1;
				var newNameElement = nameElement.replace( currentKey, newKey );
				element.attr( 'name', newNameElement );
				element.attr( 'id', newNameElement );
			},

			checkRemoveAllDefault: function (element) {
				var tableMain = $( element ).closest( '.we-group-table' );
				if ( ! tableMain.find( '.js-we-group-default' ).is( ':checked' )) {
					tableMain.find( '.js-we-group-default' ).first().attr( 'checked', true );
				};
			},
		};

		wecorreosFormGroup.init();
	}
);
