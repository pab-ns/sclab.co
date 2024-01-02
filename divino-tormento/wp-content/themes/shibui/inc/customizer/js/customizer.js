/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

    // Variables
    var $style = $( '#shibui-color-scheme-css' ),
        api = wp.customize;

    // Color schemes
    if ( ! $style.length ) {
        $style = $( 'head' ).append( '<style type="text/css" id="shibui-color-scheme-css" />' ).find( '#shibui-color-scheme-css' );
    }

    // Site Title
    api( 'blogname', function( value ) {
        value.bind( function( to ) {
            $( '.site-title a' ).text( to );
        } );
    } );

    // Site Description
    api( 'blogdescription', function( value ) {
        value.bind( function( to ) {
            $( '.site-description' ).text( to );
        } );
    } );

    // Add class if Background Image is present
    api( 'background_image', function( value ) {
        value.bind( function( to ) {
            var body = $( 'body' );
            if ( '' !== to ) {
                body.addClass( 'custom-background-image' );
            } else {
                body.removeClass( 'custom-background-image' );
            }
        } );
    } );

    // Fonts
    api( shibui_customizer.theme + "_options[font]", function( value ) {
        value.bind( function( to ) {
            $( "#fontdiv" ).remove();
            var googlefont = to.split( "," );
            var n = googlefont[0].indexOf( ":" );
            googlefontfamily = googlefont[0].substring( 0, n != -1 ? n : googlefont[0].length );
            $( "body" ).append( "<div id=\"fontdiv\"><link href=\"http://fonts.googleapis.com/css?family="+googlefont[0]+"\" rel=\"stylesheet\" type=\"text/css\" /><style type=\"text/css\">  h1, h2, h3, h4, h5, h6, ul.menu li a {font-family: \""+googlefontfamily+"\";}</style></div>" );
        } );
    } );

    // Font Alt
    api( shibui_customizer.theme + "_options[font_alt]", function( value ) {
        value.bind( function( to ) {
            $( "#fontaltdiv" ).remove();
            var googlefont = to.split( "," );
            var n = googlefont[0].indexOf( ":" );
            googlefontfamily = googlefont[0].substring( 0, n != -1 ? n : googlefont[0].length );
            $( "body" ).append( "<div id=\"fontaltdiv\"><link href=\"http://fonts.googleapis.com/css?family="+googlefont[0]+"\" rel=\"stylesheet\" type=\"text/css\" /><style type=\"text/css\">   body, p, h2.site-description {font-family: \""+googlefontfamily+"\";}</style></div>" );
        } );
    } );

    // CSS
    api( shibui_customizer.theme + "_options[css]", function( value ) {
        value.bind( function( to ) {
            $( "#tempcss" ).remove();
            var googlefont = to.split( "," );
            $( "body" ).append( "<div id=\"tempcss\"><style type=\"text/css\">" + to + "</style></div>" );
        } );
    } );


    // Color Scheme CSS.
    api.bind( 'preview-ready', function() {
        api.preview.bind( 'update-color-scheme-css', function( css ) {
            $style.html( css );
        } );
    } );


} )( jQuery );
