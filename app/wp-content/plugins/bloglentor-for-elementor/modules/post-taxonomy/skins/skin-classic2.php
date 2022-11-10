<?php
namespace BlogLentor\Modules\PostTaxonomy\Skins;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Classic2 extends Skin_Base {

    protected function _register_controls_actions() {
        parent::_register_controls_actions();
    }

    public function register_sections( Widget_Base $widget ) {

        $this->parent = $widget;
        $this->register_header_controls();
        // Content Controls.
        $this->register_design_post_taxonomy_general_controls();
        $this->register_design_header_controls();
        $this->register_design_post_taxonomy_title_controls();
        $this->register_design_post_taxonomy_count_controls();

    }

    public function get_id() {
        return 'classic2';
    }

    public function get_title() {
        return __( 'Classic 2', 'bloglentor' );
    }

    public function register_controls( Widget_Base $widget ) {
        $this->parent = $widget;
        $this->register_post_query_controls();
    }

    protected function rander_taxonomy($terms, $post_taxonomy){
        $display_header_title = $this->get_instance_value( 'display_header_title' );
        if( $display_header_title === 'yes' ) {
            $this->get_header();
        }
        ?>
        <div class="blfe-taxonomy blfe-taxonomy-classic2 blfe-taxonomy-list-item">
            <ul class="blfe-taxonomy-list">
                <?php 
                    $this->rander_post_taxonomy_item($terms, $post_taxonomy);
                ?>
            </ul>
        </div>
    <?php
    }
    
}

