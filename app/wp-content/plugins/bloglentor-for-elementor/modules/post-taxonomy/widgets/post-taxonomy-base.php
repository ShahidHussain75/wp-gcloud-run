<?php
namespace BlogLentor\Modules\PostTaxonomy\Widgets;
use BlogLentor\Classes\Helper;

use Elementor\Controls_Manager;
use BlogLentor\Base\Base_Widget;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Class Posts_Base
 */
abstract class Post_Taxonomy_Base extends Base_Widget {

    protected $query = null;

    protected $_has_template_content = false;

    public function get_icon() {
        return 'blfe-icon eicon-editor-list-ul';
    }

    public function get_script_depends() {
        return array();
    }

    public function get_query() {

        return $this->query;
    }

    public function render() {}

    protected function register_controls() {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => __( 'Layout', 'bloglentor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'taxonomy_count_enable',
            array(
                'label'        => __( 'Count', 'bloglentor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'bloglentor' ),
                'label_off'    => __( 'No', 'bloglentor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'taxonomy_bar_enable',
            array(
                'label'        => __( 'Bar', 'bloglentor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'bloglentor' ),
                'label_off'    => __( 'No', 'bloglentor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'taxonomy_link_new_tab',
            array(
                'label'        => __( 'Open in New Tab', 'bloglentor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'bloglentor' ),
                'label_off'    => __( 'No', 'bloglentor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->end_controls_section();

    }


}