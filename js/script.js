(function( $ ) {

	$( document ).ready( function() {
		/* display blocks to choose necessary color for elements */
		var pgntn_display = [ 'everywhere', 'home', 'blog', 'archives', 'search', 'paginated', 'comments' ],
			pgntn_check   = 0,
			pgntn_flag    = false,
			window_width         = $( window ).width();
			$( window ).resize( function() {
				window_width = $( window ).width();
			});

		/*  Color Picker */
		if ( parseFloat( pgntn_script_vars.wp_version ) > 3.5 ) {
			$('.pgntn_color_picker').each( function() {
				var id = $( '#' + $( this ).prev().attr( 'id' ) ); /* get ID of <input type="text"/> */
	 			$( this ).farbtastic( id );                        /* initialize color picker for necessary input type="text"/> */       
	 			id.bind( "change click focus", function() { 
	 				$( this ).next().show();
	 			}).focusout( function() {
	 				$( this ).next().hide( 'fast');
					if ( ! /^#[0-9a-f]{3}(?:[0-9a-f]{3})?$/i.test( $( this ).val() ) ) { /* check for correct entered hexa color  */
						/* convert rgb to hex */
						var background_color = $( this ).css( 'background-color' );
						if ( background_color.substr( 0, 1 ) !== '#' ) {
							var digits = /(.*?)rgb\((\d+), (\d+), (\d+)\)/.exec( background_color ),
								red    = parseInt( digits[2] ),
								green  = parseInt( digits[3] ),
								blue   = parseInt( digits[4] ),
								rgb    = blue | ( green << 8 ) | (  red << 16 );
					    	background_color = digits[1] + '#' + rgb.toString( 16 );
						}
						$( this ).val( background_color).css({ 
							background: background_color,
							color: $( this ).css( 'color' )
						});
					}
	 			});
			});
		}
		
		/* select or deselect all checkboxes with page types on setting page */
		$( '#pgntn_everywhere' ).click( function() {
			if( $( this ).is( ':checked' ) ) {
				$( '.pgntn_where_display' ).attr( 'checked', true );
			} else {
				$( '.pgntn_where_display' ).attr( 'checked', false );
			}
		});
		$( '.pgntn_where_display' ).click( function() {
			if( $( this ).is( ':checked' ) ) {
				$( '.pgntn_where_display' ).each( function() {
					if( $( this ).is( ':checked' ) )
						pgntn_check ++;
				});
				if ( pgntn_check == $( '.pgntn_where_display' ).length ) {
					$( '#pgntn_everywhere' ).attr( 'checked', true );
				}
			} else {
				$( '#pgntn_everywhere' ).attr( 'checked', false );
			}
			pgntn_check = 0;
		});

		$( '#pgntn_position_loop').change( function() {
			if ( $( this ).is( ':checked' ) ) {
				$( '.pgntn-nav-position' ).show();
			} else {
				$( '.pgntn-nav-position' ).hide();
			}
		});
				
		$( '.pgntn_help_box' ).mouseover( function() {
			$( this ).children().css( 'display', 'block' );
			if ( window_width < 580 ) {
				var offset = $( this ).offset(),
					left   = Math.round( ( $(window).width() - $( this ).children().width() ) / 2 - offset.left ) - 10;
				$( this ).children().css( {
					left: left,
					top:  30 
				});
			} else {
				$( this ).children().css( {
					left: 36,
					top:  0 
				});
			}
		});
		$( '.pgntn_help_box' ).mouseout( function() {
			$( this ).children().css( 'display', 'none' );
		});

		$( '#pgntn_display_next_prev' ).change( function() {
			if ( $( this ).is( ':checked' ) ) {
				$( '#pgntn_prev_text, #pgntn_next_text' ).attr( 'disabled', false );
			} else {
				$( '#pgntn_prev_text, #pgntn_next_text' ).attr( 'disabled', true );
			}
		});

		$( '#pgntn_show_not_all' ).click( function() {
			$( 'input[name="pgntn_display_count_page"]' ).attr( 'disabled', false );
		});

		$( '#pgntn_show_all' ).click( function() {
			$( 'input[name="pgntn_display_count_page"]' ).attr( 'disabled', true );
		});
		
		$( 'input[name="pgntn_align"]' ).change( function() {
			if ( $( this ).val() == "center" && $( this ).is( ':checked' ) ) {
				$( '.pgntn_margin' ).attr( 'disabled', true );
			} else {
				$( '.pgntn_margin' ).attr( 'disabled', false );
			}
		});

		$( 'input[name="pgntn_display_custom_pagination"]' ).change( function() {
			if ( $( this ).is( ':checked' ) ) {
				$( '#pgntn_additional_pagination_style' ).attr( 'disabled', false );
			} else {
				$( '#pgntn_additional_pagination_style' ).attr( 'disabled', true );
			}
		});

		/* add notice about changing in the settings page */
		$( '#pgntn_settings_form input' ).bind( "change click select", function() {
			if ( ! ( $( this ).attr( 'type' ) == 'submit' || $( this ).attr( 'type' ) == 'button' ) ) {
				$( '.updated.fade' ).hide();
				$( '#pgntn_settings_notice' ).show();
			}
			if ( $( this ).attr( 'name' ) == 'pgntn_where_display[]' )  {
				$( 'input[name="pgntn_where_display[]"]' ).each( function() {
					if( $( this ).is( ':checked' ) && $.inArray( $( this ).val(), pgntn_display ) != -1 )
						pgntn_flag = true;
				});
				if( pgntn_flag ) {
					$( '#pgntn_empty_page_type' ).hide();
					pgntn_flag = false;
				} else {
					$( '#pgntn_empty_page_type' ).show();
				}
			}
		});
	});
})(jQuery);