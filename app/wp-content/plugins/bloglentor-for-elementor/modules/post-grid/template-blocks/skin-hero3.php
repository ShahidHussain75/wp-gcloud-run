<?php
namespace BlogLentor\Modules\PostGrid\TemplateBlocks;
use BlogLentor\Modules\PostGrid\TemplateBlocks\Skin_Style;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Skin_Business
 */
class Skin_Hero3 extends Skin_Style {

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
            <div class="blfe-post-grid-item-inner blfe-modern-zoom">
                <?php $this->render_image( $this->thumbnail_id , $thumbnail_size ); ?>
                <div class="blfe-post-grid-details">
                    <div class="blfe-post-grid-details-inner">
                        <?php $this->render_category(); ?>
                        <?php $this->render_title(); ?>
                        <?php $this->render_meta(); ?>
                        <?php $this->render_excerpt(); ?>
                        <?php $this->render_read_more(); ?>
                    </div>
                </div>

            </div>
        </div>
        <?php
    }

}

