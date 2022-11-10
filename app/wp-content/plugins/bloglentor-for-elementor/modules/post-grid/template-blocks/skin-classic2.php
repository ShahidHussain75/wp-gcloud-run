<?php
namespace BlogLentor\Modules\PostGrid\TemplateBlocks;
use Elementor\Utils;
use BlogLentor\Modules\PostGrid\TemplateBlocks\Skin_Style;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Skin_Business
 */
class Skin_Classic2 extends Skin_Style {


    public function render_image($thumbnail_id, $image_size){

        if( $this->get_instance_value( 'show_image' ) !== 'yes' ){
            return;
        }

        $placeholder_image = Utils::get_placeholder_image_src();
        $image_src = wp_get_attachment_image_src( $thumbnail_id, $image_size );

        if ( ! $image_src ) {
            $image_src = $placeholder_image;
        } else {
            $image_src = $image_src[0];
        }

        $link_img = $this->get_instance_value( 'link_img' );
        $img_link_new_tab = $this->get_instance_value( 'img_link_new_tab' );

        $target = $img_link_new_tab === 'yes' ? '_blank' : '_self';

        if( 'yes' === $link_img ) {
            echo '<a class="blfe-post-grid-image" href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_title()) . '" rel="nofollow" target="'.$target.'"><img src="'.$image_src.'" alt="'.esc_attr(get_the_title()).'"/></a>';
        } else {
            echo '<div class="blfe-post-grid-image"><img src="'.$image_src.'" alt="'.esc_attr(get_the_title()).'"/></div>';
        }

    }

    public function render_post() {
        $thumbnail_size = $this->get_instance_value( 'thumbnail_size' );

        $equal_height = $this->get_instance_value( 'carousel_equal_height' );

        $this->add_render_attribute(
            'grid_item'. get_the_ID(),
            'class',
            array(
                'blfe-post-grid-item',
                $equal_height === 'yes' ? 'blfe-equal-height' : '',
            )
        );
        ?>
        <div <?php echo wp_kses_post( $this->get_render_attribute_string( 'grid_item'. get_the_ID() ) ); ?>>
            <div class="blfe-post-grid-item-inner blfe-zoom">
                <?php $this->render_image( $this->thumbnail_id , $thumbnail_size ); ?>
                <?php $this->render_category(); ?>
                <div class="blfe-post-grid-details">
                    <div class="blfe-post-grid-details-inner">
                        <?php $this->render_title(); ?>
                        <?php $this->render_excerpt(); ?>
                        <?php $this->render_meta(); ?>
                        <?php $this->render_read_more(); ?>
                    </div>
                </div>

            </div>
        </div>
        <?php
    }


}

