/**
 * Core JS
 */

 function sliderHeight() {
    wh = jQuery(window).height();

    mainmenuHeight = jQuery('#masthead').outerHeight();
    homeSlider = jQuery('#section-slideshow .slides .slide').outerHeight();
    adminBar = jQuery('#wpadminbar').outerHeight();
    height = wh - mainmenuHeight;
    adminMargin = height - adminBar;
    homeSliderAdmin = homeSlider - adminBar;

    if ( homeSlider < wh ) {
        jQuery('.section-slideshow , #section-slideshow , #section-slideshow li').css({height: homeSlider});
    } else {
        jQuery('.section-slideshow , #section-slideshow , #section-slideshow li').css({height: height});
    }
}

jQuery( document ).ready( function( $ ) {

    $(window).scroll(function() {
        if($(this).scrollTop() != 0) {
            $("#masthead").addClass("shadow")
        } else {
            $("#masthead").removeClass("shadow")
        }
    });

    // fit videos to browser window
    $( '#page' ).fitVids();

    $( 'figcaption h3 a' ).hover(
        function() {
            $( this ).parent().parent().parent().find( '.entry-image img' ).addClass( 'img-hover' );
        }, function() {
            $( this ).parent().parent().parent().find( '.entry-image img' ).removeClass( 'img-hover' );
        }
    );

    // slideshows
    $( window ).load( function() {

        $i = 1;
        $( '.flexslider' ).each( function(){
            // Get control nav
            $nav_menu = $( this ).find( 'ul.slide-thumbs' );
            // Add unique control nav class
            new_menu = 'slide-thumbs-' + $i;
            $nav_menu.addClass( new_menu );
            new_menu_item = '.' + new_menu + ' li';

            $( this ).flexslider({
                animation: shibui_theme.slideshow_animation,
                controlNav: shibui_theme.slideshow_dots_nav,
                manualControls: new_menu_item,
                slideshow: shibui_theme.slideshow_autostart,
                prevText: "",
                nextText: "",
                start: function( slider ) {
                    slider.removeClass( 'loading' );
                }
            } );
            $i++;
        } );
        sliderHeight();
    } );

} );

jQuery(window).bind('resize',function () {
    //Update slideshow height
    sliderHeight();
});