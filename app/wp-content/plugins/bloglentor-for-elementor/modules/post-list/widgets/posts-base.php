<?php
namespace BlogLentor\Modules\PostList\Widgets;

use Elementor\Controls_Manager;
use BlogLentor\Base\Base_Widget;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Class Posts_Base
 */
abstract class Posts_Base extends Base_Widget {

    protected $query = null;

    protected $_has_template_content = false;

    public function get_icon() {
        return 'blfe-icon eicon-post-list';
    }

    public function get_script_depends() {
        return  apply_filters( 'blfe/post_list_script_depends', array('bloglentor-frontend', 'slick') );
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
            'layout_type',
            [
                'label'   => __( 'Layout Type', 'bloglentor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'list',
                'options' => [
                    'list'   => __( 'List', 'bloglentor' ),
                    'carousel' => __( 'Carousel', 'bloglentor' ),
                ],
                'condition' => [
                    '_skin' => [ 'classic1', 'classic2']
                ],
            ]
        );

        $this->end_controls_section();

        $this->register_content_general_controls();
    }

    public function register_content_general_controls() {
        $this->start_controls_section(
            'section_general',
            array(
                'label' => __( 'General', 'bloglentor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            )
        );


        $this->add_responsive_control(
            'columns',
            [
                'label'          => __( 'Columns', 'bloglentor' ),
                'type'           => Controls_Manager::SELECT,
                'default'        => '6',
                'tablet_default' => '6',
                'mobile_default' => '12',
                'options'        => [
                    '12' => '1',
                    '6' => '2',
                    '3' => '3',
                    '4' => '4',
                    '2' => '6',
                ],
                'frontend_available' => true,
            ]
        );

        $this->end_controls_section();
    }

}