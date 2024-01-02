<?php
/**
 * The Template part for displaying all welcome messages.
 *
 * @package shibui
 */

 global $theme_options;

?>

<?php if ( is_front_page() && ( ! empty( $theme_options['welcome_message'] ) ) ) : ?>

    <div class="site-welcome">
        <p><?php echo stripslashes_deep( $theme_options['welcome_message'] ); ?></p>
    </div>

<?php endif; ?>