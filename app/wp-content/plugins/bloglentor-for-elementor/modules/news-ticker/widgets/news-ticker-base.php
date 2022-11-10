<?php
namespace BlogLentor\Modules\NewsTicker\Widgets;

use Elementor\Controls_Manager;
use BlogLentor\Base\Base_Widget;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Class Posts_Base
 */
abstract class News_Ticker_Base extends Base_Widget {

    protected $query = null;

    protected $_has_template_content = false;

    public function get_icon() {
        return 'blfe-icon eicon-posts-ticker';
    }

    public function get_script_depends() {
        return array('bloglentor-frontend', 'slick');
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
            'title_enable',
            [
                'label'   => esc_html__( 'Title', 'bloglentor' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => esc_html__( 'Title Text', 'bloglentor' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [ 'active' => true ],
                'default'     => esc_html__( 'LATEST NEWS', 'bloglentor' ),
                'placeholder' => esc_html__( 'Enter title', 'bloglentor' ),
                'condition' => [
                    'title_enable' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'post_link_new_tab',
            array(
                'label'        => __( 'Post Open in New Tab', 'bloglentor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'bloglentor' ),
                'label_off'    => __( 'No', 'bloglentor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'display_date',
            array(
                'label'        => __( 'Date', 'bloglentor' ),
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