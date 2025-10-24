( function( $ ) {
	$( document ).ready( function() {
		$( window ).scroll( function() {
			let scroll = document.body.scrollTop || document.documentElement.scrollTop;
			if ( scroll > window.screen.height ) {
				$( '.pgntn-scroll-to-top' ).css( 'display', 'flex' );
			} else {
				$( '.pgntn-scroll-to-top' ).hide();
			}
		});
		$( '.pgntn-scroll-to-top' ).on( 'click touch', function(){
			$( 'html, body' ).animate(
				{
					scrollTop: 0
				},
				'slow'
			);
		});
		if ( $( '.pgntn-scroll-to-top-form-square' ).outerWidth() > $( '.pgntn-scroll-to-top-form-square' ).outerHeight() ) {
			$( '.pgntn-scroll-to-top-form-square' ).css( 'height', $( '.pgntn-scroll-to-top-form-square' ).outerWidth() );
		} else if ( $( '.pgntn-scroll-to-top-form-square' ).outerWidth() < $( '.pgntn-scroll-to-top-form-square' ).outerHeight() ) {
			$( '.pgntn-scroll-to-top-form-square' ).css( 'width', $( '.pgntn-scroll-to-top-form-square' ).outerHeight() );
		}
		if ( $( '.pgntn-scroll-to-top-form-circle' ).outerWidth() > $( '.pgntn-scroll-to-top-form-circle' ).outerHeight() ) {
			$( '.pgntn-scroll-to-top-form-circle' ).css( 'height', $( '.pgntn-scroll-to-top-form-circle' ).outerWidth() );
		}
		if ( 0 < $( '.pgntn-scroll-to-top-form-triangle' ).length ) {
			$( '.pgntn-scroll-to-top' ).css({ 'visibility': 'hidden', 'display': 'block' });
			var width = parseInt ( $( '.pgntn-scroll-to-top-text' ).width() ) + 20;
			$( '.pgntn-scroll-to-top-form-triangle' ).css({ 'border-bottom-width': width, 'border-left-width': width, 'border-right-width': width });
			$( '.pgntn-scroll-to-top-text' ).css( 'top', width / 2 - 15 );
			$( '.pgntn-scroll-to-top' ).css({ 'display': 'none', 'visibility': 'visible' });
		}
	} );
} )( jQuery );
