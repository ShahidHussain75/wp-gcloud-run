<?php
namespace BlogLentor\Modules\PostList\Skins;
use Elementor\Widget_Base;
use BlogLentor\Modules\PostList\TemplateBlocks\Skin_Init;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Classic1 extends Skin_Base {

    protected function _register_controls_actions() {
        parent::_register_controls_actions();
        add_action( 'elementor/element/blfe-post-list/classic1_section_meta/before_section_end', [ $this, 'register_update_section_meta_controls' ] );

    }

    public function register_sections( Widget_Base $widget ) {

        $this->parent = $widget;

        // Content Controls.
        $this->register_header_controls();
        $this->register_image_controls();
        $this->register_title_controls();
        $this->register_meta_controls();
        $this->register_taxonomy_controls();
        $this->register_excerpt_controls();
        $this->register_read_more_controls();
        $this->register_carousel_controls();
        $this->register_pagination_controls();


        $this->register_design_layout_controls();
        $this->register_design_header_controls();
        $this->register_design_box_controls();
        $this->register_design_image_controls();
        $this->register_design_title_controls();
        $this->register_design_meta_controls();
        $this->register_design_excerpt_controls();
        $this->register_design_taxonomy_controls();
        $this->register_design_read_more_controls();
        $this->register_design_pagination_controls();
        $this->register_design_carousel_controls();
    }

    public function get_id() {
        return 'classic1';
    }

    public function get_title() {
        return __( 'Classic 1', 'bloglentor' );
    }

    public function register_controls( Widget_Base $widget ) {
        $this->parent = $widget;
        $this->register_post_query_controls();
    }

    public function register_update_section_meta_controls() {

        $this->update_control(
            'separator_type',
            array(
                'default' => 'custom',
            )
        );

        $this->update_control(
            'separator',
            array(
                'default' => '-',
            )
        );
    }

    public function render() {

        $settings = $this->parent->get_settings_for_display();

        $skin = Skin_Init::get_instance( $this->get_id() );

        echo wp_kses_post( $skin->render( $this->get_id(), $settings, $this->parent->get_id() ) );
    }
}

