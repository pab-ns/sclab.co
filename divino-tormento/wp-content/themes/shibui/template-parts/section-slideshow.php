<?php $theme_options = shibui_get_theme_options(); ?>

<section id="section-slideshow" class="slideshow">

    <?php
    // Get Slides
    $slides = $theme_options['slideshow'];
    $images = explode( ',', $slides );

    $slideshow_title = $theme_options['slideshow_title_showhide'];
    $slideshow_dots_navigation = $theme_options['slideshow_dots_showhide'];

    ?>

    <div class="flexslider loading">
        <ul class="slides">

            <?php
            foreach( $images as $id ) :

                $attachment_caption = get_post_field('post_excerpt', $id);
                $attachment_title = get_post_field('post_title', $id);

                ?>
                <li>
                    <div class="slide">
                        <?php echo wp_get_attachment_image( $id, "xl", 0 ); ?>
                        <?php if ( 'show' == $slideshow_title ) : ?>
                        <div class="slideshow-caption">
                                <?php
                                if ( ! empty ( $attachment_title ) )
                                    echo '<h2 class="slide-title">' . $attachment_title . '</h2>';
                                if ( ! empty ( $attachment_caption ) )
                                    echo '<p class="slide-caption">' . $attachment_caption . '</p>';
                                ?>
                        </div><!-- slideshow-caption -->
                        <?php endif; ?>
                    </div><!--  .slide -->
                </li>
            <?php endforeach; ?>
        </ul><!-- .slides -->
    </div><!-- .flexslider -->

</section> <!-- .slideshow-1 -->

