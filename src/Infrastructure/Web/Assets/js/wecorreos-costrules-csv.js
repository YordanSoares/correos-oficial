jQuery(
	function ($) {

		var self;
		var rulesTable;
		var sectionImport;

		var wecorreosFormChargeRulesCSV = {

			emptyElement: '',

			init: function () {
				self          = this;
				rulesTable    = $( '.we-charge-rules-table' );
				sectionImport = $( '.we-charge-rules-import-export-csv' );

				rulesTable.off( 'click', 'a.js-charge-rules-export-csv' );
				rulesTable.on(
					'click', 'a.js-charge-rules-export-csv', function (event) {
						event.preventDefault();
						self.exportCSV();
					}
				);

				sectionImport.off( 'click', 'a.js-charge-rules-import-csv' );
				sectionImport.on(
					'click', 'a.js-charge-rules-import-csv', function (event) {
						event.preventDefault();
						self.importCSV();
					}
				);
			},

			exportCSV: function () {
				var csv = self.rulesToCSV( {} );
				if ( null == csv ) {
					return;
				}

				if ( ! csv.match( /^data:text\/csv/i ) ) {
					csv = 'data:text/csv;charset=utf-8,' + csv;
				}
				var data              = encodeURI( csv );
				var element           = document.createElement( 'a' );
				element.style.display = 'none';
				element.setAttribute( 'href', data );
				element.setAttribute( 'download', 'tabla_reglas.csv' );
				document.body.appendChild( element );
				element.click();
				document.body.removeChild( element );
			},

			rulesToCSV: function ( args ) {
				var result, ctr, keys, columnDelimiter, lineDelimiter, data;

				data = self.getRules();
				if (data == null || ! data.length) {
					return null;
				}

				columnDelimiter = args.columnDelimiter || ',';
				lineDelimiter   = args.lineDelimiter || '\n';

				keys = Object.keys( data[0] );

				result  = '';
				result += keys.join( columnDelimiter );
				result += lineDelimiter;

				data.forEach(
					function ( item ) {
						ctr = 0;
						keys.forEach(
							function (key ) {
								if ( ctr > 0 ) {
									result += columnDelimiter;
								}

								result += item[key];
								ctr++;
							}
						);
						result += lineDelimiter;
					}
				);

				return result;
			},

			getRules: function () {
				var rules = [];

				rulesTable.children( 'tbody' ).find( 'tr' ).each(
					function () {
						var row = {
							shipping_class: $( this ).find( "select[name*='[shipping_class]']" ).val(),
							condition: $( this ).find( "select[name*='[condition]']" ).val(),
							min: $( this ).find( "input[name*='[min]']" ).val(),
							max: $( this ).find( "input[name*='[max]']" ).val(),
							cost: $( this ).find( "input[name*='[cost]']" ).val(),
							cost_per_additional_unit: $( this ).find( "input[name*='[cost_per_additional_unit]']" ).val(),
						};

						rules.push( row );
					}
				);

				return rules;
			},

			importCSV: function () {
				self.block();
				var files = $( 'input[name="csv_files"]' ).prop( 'files' );
				var file  = files[0];

				if ( ! file ) {
					self.displayMessages( costrulescsv_settings.message_error_select_file, 'error' );
					self.unBlock();
				}

				var reader = new FileReader();
				reader.readAsText( file );
				reader.onload  = function ( event ) {
					var csv = event.target.result;
					try {
						var data = $.csv.toObjects( csv );
						self.checkFormatData( data );
						self.removeRows();
						data.forEach(
							function ( el ) {
								self.addRow();
								self.valueRow( el );
							}
						);
						self.displayMessages( costrulescsv_settings.message_updated_rules_imported, 'updated' );
					} catch (e) {
						self.displayMessages( costrulescsv_settings.message_error_bad_format, 'error' );
					}
				};
				reader.onerror = function () {
					self.displayMessages( costrulescsv_settings.message_error_not_read_file, 'error' );
				};
				self.unBlock();
			},

			removeRows: function () {
				rulesTable.find( 'tbody:first > tr' ).remove();
			},

			addRow: function () {
				var lastElement = rulesTable.find( 'tbody:first > tr:last' );

				if (lastElement.length == 0) {
					rulesTable.find( 'tbody' ).append( self.emptyElement );
					return;
				}
				var newElement = lastElement.clone()
				.find( 'input, select' ).val( '0' ).end();

				newElement.find( 'input:not(.js-we-group-checkbox), select' ).each(
					function () {
						self.replaceToNewKey( $( this ) );
					}
				);

				$( lastElement ).after( newElement );
			},

			obtainEmptyElement: function () {

				var form = $( '.form-table' ).find( "input[name*='_title']" ).attr( 'name' ).replace( '_title', '_charge_rules' );
				var data = {};

				var data = {
					nonce:  ajax_object.nonce,
					action: 'wecorreos_obtain_empty_costrule',
					form:   form,
					key:    '1'
				};

				$.post(
					ajax_object.ajax_url, data, function (response) {
						self.emptyElement = response.add.content;
					}
				);
			},

			replaceToNewKey: function (element) {
				var nameElement    = String( element.attr( 'name' ) );
				var matchKey       = nameElement.match( /\[(\d+)\]/ );
				var currentKey     = parseInt( matchKey[1] );
				var newKey         = currentKey + 1;
				var newNameElement = nameElement.replace( '[' + currentKey + ']', '[' + newKey + ']' );
				element.attr( 'name', newNameElement );
				element.attr( 'id', newNameElement );
			},

			valueRow: function ( el ) {
				var last_row = rulesTable.find( 'tbody:first > tr:last' );

				last_row.find( "select[name*='[shipping_class]']" ).val( el.shipping_class );
				last_row.find( "select[name*='[condition]']" ).val( el.condition );
				last_row.find( "input[name*='[min]']" ).val( el.min );
				last_row.find( "input[name*='[max]']" ).val( el.max );
				last_row.find( "input[name*='[cost]']" ).val( el.cost );
				last_row.find( "input[name*='[cost_per_additional_unit]']" ).val( el.cost_per_additional_unit );
			},

			displayMessages: function ( message, type ) {

				var messages_html = '<div class="' + type + ' notice">';
				messages_html    += '<p><strong>' + message + '</strong></p>';
				messages_html    += '</div>';

				message_place = sectionImport.children( '#client-messages' );
				message_place.empty();
				message_place.append( messages_html );
			},

			checkFormatData: function (data) {
				var formatOk = true;
				data         = data[0];
				if ( ! data.hasOwnProperty( 'shipping_class' )) {
					formatOk = false;
				}
				if ( ! data.hasOwnProperty( 'condition' )) {
					formatOk = false;
				}
				if ( ! data.hasOwnProperty( 'min' )) {
					formatOk = false;
				}
				if ( ! data.hasOwnProperty( 'max' )) {
					formatOk = false;
				}
				if ( ! data.hasOwnProperty( 'cost' )) {
					formatOk = false;
				}
				if ( ! data.hasOwnProperty( 'cost_per_additional_unit' )) {
					formatOk = false;
				}
				if ( ! formatOk) {
					throw 'Bad format';
				}
			},

			block: function () {
				sectionImport.block(
					{
						message: null,
						overlayCSS: {
							background: '#fff',
							opacity: 0.6
						}
					}
				);
			},

			unBlock: function () {
				sectionImport.unblock();
			},
		}

		wecorreosFormChargeRulesCSV.init();
		setTimeout(
			function () {
				wecorreosFormChargeRulesCSV.obtainEmptyElement();
			}, 500
		);
	}
);
