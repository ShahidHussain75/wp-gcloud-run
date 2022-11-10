<?php
namespace BlogLentor\Modules\PostList\TemplateBlocks;
use Elementor\Utils;
use BlogLentor\Modules\PostList\TemplateBlocks\Skin_Style;

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
            echo '<div class="blfe-post-image-wrapper"><a class="blfe-post-list-image" href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_title()) . '" rel="nofollow" target="'.$target.'"><span style="background-image: url('.$image_src.')"></span></a>'.$this->render_category().'</div>';
        } else {
            echo '<div class="blfe-post-image-wrapper"><div class="blfe-post-list-image"><span style="background-image: url('.$image_src.')"></span></div>'.$this->render_category().'</div>';
        }

    }

    public function render_post() {
        $thumbnail_size = $this->get_instance_value( 'thumbnail_size' );

        $equal_height = $this->get_instance_value( 'carousel_equal_height' );

        $this->add_render_attribute(
            'grid_item'. get_the_ID(),
            'class',
            array(
                'blfe-post-list-item',
                $equal_height === 'yes' ? 'blfe-equal-height' : '',
                $this->get_instance_value( 'show_image' ) !== 'yes' ? 'hide-post-image' : ''
            )
        );
        ?>
        <div <?php echo wp_kses_post( $this->get_render_attribute_string( 'grid_item'. get_the_ID() ) ); ?>>
            <?php $this->render_image( $this->thumbnail_id , $thumbnail_size ); ?>
            <div class="blfe-post-list-details">
                <?php $this->render_title(); ?>
                <?php $this->render_meta(); ?>
                <?php $this->render_excerpt(); ?>
                <?php $this->render_read_more(); ?>
            </div>
        </div>
        <?php
    }


}

