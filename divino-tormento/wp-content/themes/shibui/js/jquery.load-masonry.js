/**
 * Masonry init
 */
jQuery( document ).ready( function( $ ) {

    $( window ).load( function() {

        var portfolio_content = $( '.portfolio-content, .jetpack-portfolio-shortcode, .blog-content' );

        portfolio_content.imagesLoaded( function() {
            if ( $( 'body' ).hasClass( 'rtl' ) ) {
                portfolio_content.masonry( {
                    columnWidth: '.grid-sizer',
                    itemSelector: '.grid-item',
                    percentPosition: true,
                    gutter: '.gutter-sizer',
                    transitionDuration: 0,
                    isRTL: true
                } );
            } else {
                portfolio_content.masonry( {
                    columnWidth: '.grid-sizer',
                    itemSelector: '.grid-item',
                    percentPosition: true,
                    gutter: '.gutter-sizer',
                    transitionDuration: 0
                } );
            }

            // Show the blocks
            $( '.grid-item' ).animate( {
                'opacity' : 1
            }, 250 );

        } );

        // Layout posts that arrive via infinite scroll
        $( document.body ).on( 'post-load', function () {

            var new_items = $( '.infinite-wrap .grid-item' );

            portfolio_content.append( new_items );
            portfolio_content.masonry( 'appended', new_items );

            // Force layout correction after 250 milliseconds
            setTimeout( function () {

                portfolio_content.masonry();

                // Show the blocks
                $( '.grid-item' ).animate( {
                    'opacity' : 1
                }, 250 );

            }, 250 );

        } );

    } );

} );