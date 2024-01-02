/* global colorScheme, Color */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api ) {
    var cssTemplate = wp.template( 'shibui-color-scheme' ),
        colorSchemeKeys = [
            'background_color',
            'accent_color',
            'dark_color'
        ],
        colorSettings = [
            'background_color',
            'shibui_options[accent_color]',
            'shibui_options[dark_color]'
        ];

    api.controlConstructor.select = api.Control.extend( {
        ready: function() {
            if ( 'shibui_color' === this.id ) {
                this.setting.bind( 'change', function( value ) {
                    // Update Background Color.
                    api( 'background_color' ).set( colorScheme[value].colors[0] );
                    api.control( 'background_color' ).container.find( '.color-picker-hex' )
                        .data( 'data-default-color', colorScheme[value].colors[0] )
                        .wpColorPicker( 'defaultColor', colorScheme[value].colors[0] );

                    // Update Base Accent Color.
                    api( 'shibui_options[accent_color]' ).set( colorScheme[value].colors[1] );
                    api.control( 'shibui_accent_color' ).container.find( '.color-picker-hex' )
                        .data( 'data-default-color', colorScheme[value].colors[1] )
                        .wpColorPicker( 'defaultColor', colorScheme[value].colors[1] );

                    // Update Base Dark Accent Color.
                    api( 'shibui_options[dark_color]' ).set( colorScheme[value].colors[2] );
                    api.control( 'shibui_dark_color' ).container.find( '.color-picker-hex' )
                        .data( 'data-default-color', colorScheme[value].colors[2] )
                        .wpColorPicker( 'defaultColor', colorScheme[value].colors[2] );
                } );
            }
        }
    } );

    // Generate the CSS for the current Color Scheme.
    function updateCSS() {
        var scheme = api( 'shibui_options[color]' )(), css,
            colors = _.object( colorSchemeKeys, colorScheme[ scheme ].colors );

        // Merge in color scheme overrides.
        _.each( colorSettings, function( setting ) {
            if ( setting == 'shibui_options[accent_color]' ) {
            colors[ 'accent_color' ] = api( setting )();
            } else if ( setting == 'shibui_options[dark_color]' ) {
                colors[ 'dark_color' ] = api( setting )();
            } else {
                colors[ setting ] = api( setting )();
            }
        });

        // Add additional colors.
        colors.accent_color_darker_30 = shadeColor( colors[ 'accent_color' ] , -30 );
        colors.dark_color_darker_10 = shadeColor( colors[ 'dark_color' ] , -10 );
        colors.dark_color_darker_5 = shadeColor( colors[ 'dark_color' ] , -5 );
        colors.background_color_darker_25 = shadeColor( colors[ 'background_color' ] , -25 );
        colors.background_color_lighter_50 = shadeColor( colors[ 'background_color' ] , 50 );

        if ( getContrastYIQ( colors[ 'background_color' ] ) == 'light' ) {
            colors.font_color = shadeColor( colors[ 'background_color' ] , -70 );
        } else {
            colors.font_color = shadeColor( colors[ 'background_color' ] , 70 );
        }

        if ( getContrastYIQ( colors[ 'dark_color' ] ) == 'light' ) {
            colors.header_font_color = shadeColor( colors[ 'dark_color' ] , -40 );
            colors.header_link_color = shadeColor( colors[ 'dark_color' ] , -60 );
        } else {
            colors.header_font_color = shadeColor( colors[ 'dark_color' ] , 40 );
            colors.header_link_color = shadeColor( colors[ 'dark_color' ] , 60 );
        }

        function shadeColor(color, percent) {
            var num = parseInt(color.slice(1),16),
            amt = Math.round(2.55 * percent),
            R = (num >> 16) + amt, G = (num >> 8 & 0x00FF) + amt,
            B = (num & 0x0000FF) + amt;
            return "#" + (0x1000000 + (R<255?R<1?0:R:255)*0x10000 + (G<255?G<1?0:G:255)*0x100 + (B<255?B<1?0:B:255)).toString(16).slice(1);
        }

        function getContrastYIQ(hexcolor){
            hexcolor = (hexcolor.substring(1, hexcolor.length));
            var r = parseInt(hexcolor.substr(0,2),16);
            var g = parseInt(hexcolor.substr(2,2),16);
            var b = parseInt(hexcolor.substr(4,2),16);
            var yiq = ((r*299)+(g*587)+(b*114))/1000;
            return (yiq >= 128) ? 'light' : 'dark';
        }

        css = cssTemplate( colors );
        api.previewer.send( 'update-color-scheme-css', css );
    }

    // Update the CSS whenever a color setting is changed.
    _.each( colorSettings, function( setting ) {
        api( setting, function( setting ) {
            setting.bind( updateCSS );
        } );
    } );
} )( wp.customize );
