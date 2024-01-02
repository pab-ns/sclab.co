<?php

/**
 * Extend Customizer
 *
 * @package shibui
 * @since shibui 1.0
 */

if ( class_exists( 'WP_Customize_Control' ) ) {

    /*
     * Add multi-image support for uploading slideshow images
     * Adds sorting capabilities to customizer
     */
    class Shibui_Multi_Image_Control extends WP_Customize_Control {

        public $type = 'multi-image';
        protected $inputId = '';
        protected $thumbnailsId = '';

        public function __construct($manager, $id, $args = array()) {
            parent::__construct($manager, $id, $args);
            $this->inputId = $this->type . '-control-' . $this->id;
            $this->thumbnailsId = $this->inputId . '-thumbnails';
        }

        public function enqueue() {
            wp_enqueue_media();
            wp_enqueue_script( 'multi-image-control', get_template_directory_uri() . '/inc/customizer/js/multi-image.js', array('jquery', 'jquery-ui-sortable'), '', true );
        }

        public function render_content() {
            // get the set values if any
            $imageSrcs = explode( ',', $this->value() );
            if ( ! is_array($imageSrcs ) ) {
                $imageSrcs = array();
            }
            $this->theTitle();
            $this->theButtons();
            $this->theUploadedImages( $imageSrcs );
        }

        protected function theTitle() { ?>
            <label>
                <span class="customize-control-title">
                    <?php echo esc_html($this->label); ?>
                </span>
            </label>
            <?php
        }

        protected function getImages() {
            $options = $this->value();
            if ( ! isset( $options['image_sources'] ) ) {
                return '';
            }
            return $options['image_sources'];
        }

        public function theButtons() { ?>
            <div>
                <input type="hidden" value="<?php echo $this->value(); ?>" <?php $this->link(); ?> id="<?php echo $this->inputId; ?>" data-thumbs-container="#<?php echo $this->thumbnailsId; ?>" class="multi-images-control-input"/>
                <a href="#" class="button-secondary multi-images-upload" data-store="#<?php echo $this->inputId; ?>">Images</a>
                <a href="#" class="button-secondary multi-images-remove" data-store="#<?php echo $this->inputId; ?>" data-thumbs-container="#<?php echo $this->thumbnailsId; ?>">
                   <?php _e( 'Remove Images', 'shibui'); ?>
               </a>
           </div>
           <?php
       }

       public function theUploadedImages($ids = array() ) { ?>
            <div class="customize-control-content">
                <ul class="thumbnails" data-store="#<?php echo $this->inputId; ?>" id="<?php echo $this->thumbnailsId; ?>">
                    <?php
                    if ( is_array($ids) ):
                        foreach ( $ids as $id ) :
                            if ( $id != '' ) :
                                $src = wp_get_attachment_image_src( $id ); ?>
                                <li class="thumbnail" style="background-image: url(<?php echo $src[0]; ?>);" data-src="<?php echo $src[0]; ?>" data-id="<?php echo $id; ?>">
                                </li>
                            <?php
                            endif;
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>
        <?php
        }
    }
}