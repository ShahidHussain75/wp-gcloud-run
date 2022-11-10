<?php
namespace BlogLentor\Modules\PostGrid\Skins;
use BlogLentor\Classes\Helper;
use Elementor\Controls_Manager;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

abstract class Skin_Base extends Elementor_Skin_Base {

    protected function _register_controls_actions() {
        add_action( 'elementor/element/blfe-post-grid/section_layout/after_section_end', [ $this, 'register_controls' ] );
        add_action( 'elementor/element/blfe-post-grid/section_general/after_section_end', [ $this, 'register_sections' ] );
    }

    public function register_sections( Widget_Base $widget ) {

        $this->parent = $widget;

        // Content Controls.
        $this->register_image_controls();
        $this->register_featured_post_controls();
        $this->register_header_controls();
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
        $this->register_design_featured_post_controls();
        $this->register_design_title_controls();
        $this->register_design_image_controls();
        $this->register_design_meta_controls();
        $this->register_design_excerpt_controls();
        $this->register_design_taxonomy_controls();
        $this->register_design_read_more_controls();
        $this->register_design_pagination_controls();
        $this->register_design_carousel_controls();
    }


    public function register_controls( Widget_Base $widget ) {
        $this->parent = $widget;

        $this->register_post_query_controls();
    }

    public function register_featured_post_controls(){
        $this->start_controls_section(
            'section_featured_post',
            array(
                'label' => __( 'Featured Post', 'bloglentor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'fp_image_position',
            [
                'label' => __( 'Featured Post Position', 'bloglentor' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'left',
                'options' => [
                    'left' => __( 'Left', 'bloglentor' ),
                    'right' => __( 'Right', 'bloglentor' ),
                ],
            ]
        );

        $this->add_control(
            'fp_meta_data',
            [
                'label' => __( 'Meta Data', 'bloglentor' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'default' => [],
                'multiple' => true,
                'options' => [
                    'author' => __( 'Author', 'bloglentor' ),
                    'date' => __( 'Date', 'bloglentor' ),
                    'time' => __( 'Time', 'bloglentor' ),
                    'reading_time' => __( 'Reading Time', 'bloglentor' ),
                    'comments' => __( 'Comments', 'bloglentor' ),
                ],
            ]
        );

        $this->add_control(
            'show_fp_category',
            [
                'label'   => __( 'Category', 'bloglentor' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_fp_excerpt',
            [
                'label' => __( 'Excerpt', 'bloglentor' ),
                'type'  => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'show_fp_read_more',
            [
                'label' => __( 'Read More', 'bloglentor' ),
                'type'  => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );


        $this->end_controls_section();
    }

    public function register_header_controls(){

        $this->start_controls_section(
            'section_header',
            array(
                'label' => __( 'Header', 'bloglentor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            )
        );

        $title_option = apply_filters(
            'blfe/post_header_styles',
            [
                'styles' => [
                    'style_1'     => __( 'Style 1', 'bloglentor' ),
                    'style_2'     => __( 'Style 2 (Pro)', 'bloglentor' ),
                    'style_3'     => __( 'Style 3 (Pro)', 'bloglentor' ),
                    'style_4'     => __( 'Style 4 (Pro)', 'bloglentor' ),
                    'style_5'     => __( 'Style 5 (Pro)', 'bloglentor' ),
                    'style_6'     => __( 'Style 6 (Pro)', 'bloglentor' ),
                ],
                'conditions' => [ 'style_2', 'style_3', 'style_4', 'style_5', 'style_6' ],
            ]
        );

        $this->add_control(
            'header_style',
            array(
                'label'       => __( 'Header Style', 'bloglentor' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'style_1',
                'label_block' => false,
                'options'     => $title_option['styles']
            )
        );

        $this->add_control(
            'header_pro_alert',
            array(
                'label'     => __( 'Only available in Pro Version', 'bloglentor' ),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    $this->get_control_id( 'header_style' ) => $title_option['conditions'],
                ],
            )
        );

        $this->add_control(
            'header_title_heading',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Title', 'bloglentor' ),
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'display_header_title',
            [
                'label'   => __( 'Title', 'bloglentor' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'header_title',
            [
                'label' => __( 'Title', 'bloglentor' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Post Grid',
                'condition' => [
                    $this->get_control_id( 'display_header_title' ) => 'yes',
                ],
            ]
        );

        $this->add_control(
            'header_title_url',
            [
                'label' => __( 'Title URL', 'bloglentor' ),
                'type' => Controls_Manager::URL,
                'default'  => array(
                    'url'         => '',
                    'is_external' => '',
                ),
                'dynamic'  => array(
                    'active' => true,
                ),
                'condition' => [
                    $this->get_control_id( 'display_header_title' ) => 'yes',
                ],
            ]
        );


        $this->add_control(
            'header_title_icon',
            [
                'label'       => __( 'Title Icon', 'bloglentor' ),
                'type'        => Controls_Manager::ICONS,
                'label_block' => true,
                'fa4compatibility' => 'header_title_fa4_icon',
                'default'	=> [],
                'condition' => [
                    $this->get_control_id( 'display_header_title' ) => 'yes',
                ],
            ]
        );

        $this->add_control(
            'header_icon_align',
            [
                'label'   => __( 'Icon Position', 'bloglentor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left'  => __( 'Before', 'bloglentor' ),
                    'right' => __( 'After', 'bloglentor' ),
                ],
                'condition' => [
                    $this->get_control_id( 'display_header_title' ) => 'yes',
                ],
            ]
        );


        $this->add_control(
            'header_title_tag',
            [
                'label' => __( 'Title HTML Tag', 'bloglentor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h3',
                'condition' => [
                    $this->get_control_id( 'display_header_title' ) => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'header_title_alignment',
            [
                'label' => __( 'Alignment', 'bloglentor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'bloglentor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'bloglentor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'bloglentor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'prefix_class' => 'blfe-title-align-',
                'condition' => [
                    $this->get_control_id( 'display_header_title' ) => 'yes',
                ],
            ]
        );

        do_action('blfe/post_header_filter', $this, $this->get_id());

        $this->end_controls_section();
    }

    public function register_image_controls() {

        $this->start_controls_section(
            'section_image',
            array(
                'label' => __( 'Image', 'bloglentor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'show_image',
            [
                'label'   => __( 'Image', 'bloglentor' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumbnail',
                'exclude'   => [ 'custom' ],
                'default'   => 'full',
                'condition' => [
                    $this->get_control_id( 'show_image' ) => 'yes',
                ]
            ]
        );

        $this->add_control(
            'image_height',
            [
                'label' => __( 'Height', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-bg-image img, {{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-image img, {{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-item-inner .blfe-post-grid-image:before' => 'min-height: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    $this->get_control_id( 'show_image' ) => 'yes',
                ]
            ]
        );

        $this->add_control(
            'link_img',
            array(
                'label'        => __( 'Link Image', 'bloglentor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'bloglentor' ),
                'label_off'    => __( 'No', 'bloglentor' ),
                'description'  => __( 'Disable the post image link, if you do not want to make the image clickable.', 'bloglentor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition' => [
                    $this->get_control_id( 'show_image' ) => 'yes',
                ],
            )
        );

        $this->add_control(
            'img_link_new_tab',
            array(
                'label'        => __( 'Open in New Tab', 'bloglentor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'bloglentor' ),
                'label_off'    => __( 'No', 'bloglentor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition' => [
                    $this->get_control_id( 'show_image' ) => 'yes',
                ],
            )
        );

        $this->end_controls_section();
    }

    public function register_title_controls(){

        $this->start_controls_section(
            'section_title',
            [
                'label' => __( 'Title', 'bloglentor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'   => __( 'Title', 'bloglentor' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'trim_title',
            [
                'label'   => __( 'Trim Title Words?', 'bloglentor' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => array(
                    $this->get_control_id( 'show_title' ) => 'yes',
                ),
            ]
        );

        $this->add_control(
            'title_num_words',
            array(
                'label'       => __( 'Title Words?', 'bloglentor' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 8,
                'condition' => [
                    $this->get_control_id( 'trim_title' ) => 'yes',
                ],
                'label_block' => false,
            )
        );

        $this->add_control(
            'title_indicator',
            [
                'label' => __( 'Expansion Indicator', 'bloglentor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                    $this->get_control_id( 'trim_title' ) => 'yes',
                ],
            ]
        );

        $this->add_control(
            'link_title',
            array(
                'label'        => __( 'Link Title', 'bloglentor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'bloglentor' ),
                'label_off'    => __( 'No', 'bloglentor' ),
                'description'  => __( 'Disable the post image link, if you do not want to make the image clickable.', 'bloglentor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition' => array(
                    $this->get_control_id( 'show_title' ) => 'yes',
                ),
            )
        );

        $this->add_control(
            'title_link_new_tab',
            array(
                'label'        => __( 'Open in New Tab', 'bloglentor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'bloglentor' ),
                'label_off'    => __( 'No', 'bloglentor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition' => array(
                    $this->get_control_id( 'show_title' ) => 'yes',
                ),
            )
        );

        $this->add_control(
            'title_tag',
            [
                'label' => __( 'Title HTML Tag', 'bloglentor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h3',
                'condition' => [
                    $this->get_control_id( 'show_title' ) => 'yes',
                ],
            ]
        );
        $this->end_controls_section();
    }

    public function register_meta_controls(){

        $this->start_controls_section(
            'section_meta',
            [
                'label' => __( 'Meta', 'bloglentor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'meta_data',
            [
                'label' => __( 'Meta Data', 'bloglentor' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'default' => [ 'author', 'date' ],
                'multiple' => true,
                'options' => [
                    'author' => __( 'Author', 'bloglentor' ),
                    'date' => __( 'Date', 'bloglentor' ),
                    'time' => __( 'Time', 'bloglentor' ),
                    'reading_time' => __( 'Reading Time', 'bloglentor' ),
                    'comments' => __( 'Comments', 'bloglentor' ),
                ],
            ]
        );

        $this->add_control(
            'meta_style',
            [
                'label'   => __( 'Meta Style', 'bloglentor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'with_icon',
                'options' => [
                    'no_icon'    => __( 'No Icon', 'bloglentor' ),
                    'with_icon'   => __( 'With Icon', 'bloglentor' ),
                    'style_1'   => __( 'Style 1', 'bloglentor' ),
                ],
                'condition' => [
                    $this->get_control_id( 'meta_data!' ) => [],
                ],
            ]
        );

        $this->add_control(
            'separator_type',
            [
                'label'   => __( 'Separator Type', 'bloglentor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default'    => __( 'Default', 'bloglentor' ),
                    'custom'   => __( 'Custom', 'bloglentor' ),
                ],
                'condition' => [
                    $this->get_control_id( 'meta_data!' ) => [],
                ],
            ]
        );

        $this->add_control(
            'separator',
            [
                'label' => __( 'Separator Between', 'bloglentor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '//',
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta span + span:before' => 'content: "{{VALUE}}"',
                ],
                'condition' => [
                    $this->get_control_id( 'separator_type' ) => 'custom',
                ],
            ]
        );

        $this->end_controls_section();

    }

    public function register_taxonomy_controls(){

        $this->start_controls_section(
            'section_taxonomy',
            [
                'label' => __( 'Taxonomy', 'bloglentor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_category',
            [
                'label'   => __( 'Category', 'bloglentor' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'max_terms',
            array(
                'label'       => __( 'Max Terms to Show', 'bloglentor' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 1,
                'condition' => [
                    $this->get_control_id( 'show_category' ) => 'yes',
                ],
                'label_block' => false,
            )
        );

        $this->end_controls_section();

    }

    public function register_excerpt_controls(){

        $this->start_controls_section(
            'section_excerpt',
            [
                'label' => __( 'Excerpt', 'bloglentor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => __( 'Excerpt', 'bloglentor' ),
                'type'  => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label'      => __( 'Excerpt Length', 'bloglentor' ),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 20,
                'condition' => [
                    $this->get_control_id( 'show_excerpt' ) => 'yes',
                ],

            ]
        );

        $this->add_control(
            'excerpt_indicator',
            [
                'label' => __( 'Expansion Indicator', 'bloglentor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '...',
                'condition' => [
                    $this->get_control_id( 'show_excerpt' ) => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

    }


    protected function register_carousel_controls(){

        $this->start_controls_section(
            'section_carousel',
            array(
                'label' => __( 'Carousel Settings', 'bloglentor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout_type'  => 'carousel',
                ],
            )
        );

        $this->add_control(
            'carousel_equal_height',
            array(
                'label' => __( 'Item Equal Height', 'bloglentor' ),
                'type'  => Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_responsive_control(
            'slides_to_show',
            [
                'label' => __( 'Slides To Show', 'bloglentor' ),
                'type' => Controls_Manager::NUMBER,
                'desktop_default' => 3,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'autoplay',
            array(
                'label'   => __( 'Autoplay?', 'bloglentor' ),
                'type'    => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'bloglentor' ),
                'label_off' => __( 'No', 'bloglentor' ),
                'default' => 'yes',
                'return_value' => 'yes',
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'autoplay_speed',
            array(
                'label'     => esc_html__( 'Autoplay Speed', 'bloglentor' ),
                'description' => __( 'Autoplay speed in milliseconds', 'bloglentor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'min' => 100,
                'step' => 100,
                'max' => 10000,
                'condition' => array(
                    $this->get_control_id( 'autoplay' ) => 'yes',
                ),
                'frontend_available' => true,
            )
        );
        $this->add_control(
            'pause_on_hover',
            array(
                'label' => esc_html__( 'Pause on Hover', 'bloglentor' ),
                'type'  => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'bloglentor' ),
                'label_off' => __( 'No', 'bloglentor' ),
                'default' => 'no',
                'return_value' => 'yes',
                'frontend_available' => true,
            )
        );


        $this->add_control(
            'loop',
            array(
                'label'   => __( 'Infinite Loop?', 'bloglentor' ),
                'type'    => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'bloglentor' ),
                'label_off' => __( 'No', 'bloglentor' ),
                'default' => 'yes',
                'return_value' => 'yes',
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'animation_speed',
            array(
                'label'   => __( 'Animation Speed', 'bloglentor' ),
                'description' => __( 'Slide speed in milliseconds', 'bloglentor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 200,
                'min' => 100,
                'step' => 10,
                'max' => 10000,
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'navigation',
            array(
                'label'       => __( 'Navigation', 'bloglentor' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'dots',
                'options'     => array(
                    'none'     => __( 'None', 'bloglentor' ),
                    'arrows'  => __( 'Arrows', 'bloglentor' ),
                    'dots'  => __( 'Dots', 'bloglentor' ),
                    'both'  => __( 'Arrows & Dots', 'bloglentor' ),
                ),
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'navigation_display_style',
            array(
                'label'       => __( 'Navigation Display Style', 'bloglentor' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'default',
                'options'     => array(
                    'default'     => __( 'Default', 'bloglentor' ),
                    'hover'  => __( 'On Hover', 'bloglentor' ),
                ),
                'condition' => array(
                    $this->get_control_id( 'navigation' ) => ['arrows', 'both'],
                ),
                'label_block' => false,
            )
        );

        $this->end_controls_section();

    }

    protected function register_pagination_controls(){
        $this->start_controls_section(
            'section_pagination',
            array(
                'label' => __( 'Pagination', 'bloglentor' ),
                'condition' => [
                    'layout_type!'  => 'carousel',
                    '_skin!' => [ 'hero5', 'hero6', 'hero7', 'hero8', 'hero9', 'hero10']
                ],
            )
        );


        $pagination_option = apply_filters(
            'blfe/post_grid_pagination_styles',
            [
                'styles' => [
                    'none'     => __( 'None', 'bloglentor' ),
                    'numbers'  => __( 'Numbers', 'bloglentor' ),
                    'numbers_with_prev_next'  => __( 'Numbers + Previous/Next', 'bloglentor' ),
                    'prev_next'  => __( 'Previous/Next(Pro)', 'bloglentor' ),
                    'prev_next_icon'  => __( 'Previous/Next By Icon(Pro)', 'bloglentor' ),
                    'loadmore'  => __( 'Load More(Pro)', 'bloglentor' ),
                    'infinite'  => __( 'Infinite(Pro)', 'bloglentor' ),
                ],
                'conditions' => [ 'prev_next', 'prev_next_icon', 'loadmore', 'infinite' ],
            ]
        );

        $this->add_control(
            'pagination',
            array(
                'label'       => __( 'Pagination', 'bloglentor' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'none',
                'label_block' => false,
                'options'     => $pagination_option['styles']
            )
        );

        $this->add_control(
            'pagination_pro_alert',
            array(
                'label'     => __( 'Only available in Pro Version', 'bloglentor' ),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    $this->get_control_id( 'pagination' ) => $pagination_option['conditions'],
                ],
            )
        );

        do_action( 'blfe/post_grid_prev_next_position_control', $this, $this->get_control_id( 'pagination' ) );


        $this->add_responsive_control(
            'pagination_alignment',
            [
                'label' => __( 'Alignment', 'bloglentor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'bloglentor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'bloglentor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'bloglentor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'prefix_class' => 'blfe-pagination-align-',
            ]
        );


        $this->end_controls_section();

    }


    public function register_read_more_controls(){

        $this->start_controls_section(
            'section_read_more',
            [
                'label' => __( 'Read More', 'bloglentor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'show_read_more',
            [
                'label'     => __( 'Read More', 'bloglentor' ),
                'type'      => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label'       => __( 'Read More Text', 'bloglentor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Read More', 'bloglentor' ),
                'placeholder' => __( 'Read More', 'bloglentor' ),
//                'condition' => [
//                    $this->get_control_id( 'show_read_more' ) => 'yes',
//                ],
            ]
        );

        $this->add_control(
            'open_new_tab',
            [
                'label' => __( 'Open in new window', 'bloglentor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'bloglentor' ),
                'label_off' => __( 'No', 'bloglentor' ),
                'default' => 'no',
                'render_type' => 'none',
//                'condition' => [
//                    $this->get_control_id( 'show_read_more' ) => 'yes',
//                ],
            ]
        );

        $this->add_control(
            'selected_icon',
            [
                'label'       => __( 'Icon', 'bloglentor' ),
                'type'        => Controls_Manager::ICONS,
                'label_block' => true,
                'fa4compatibility' => 'icon',
                'default'				=> [
                    'value'		=> 'fas fa-long-arrow-alt-right',
                    'library'	=> 'fa-solid',
                ],
//                'condition' => [
//                    $this->get_control_id( 'show_read_more' ) => 'yes',
//                ],
            ]
        );

        $this->add_control(
            'icon_align',
            [
                'label'   => __( 'Icon Position', 'bloglentor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left'  => __( 'Before', 'bloglentor' ),
                    'right' => __( 'After', 'bloglentor' ),
                ],
//                'condition' => [
//                    $this->get_control_id( 'show_read_more' ) => 'yes',
//                ],
            ]
        );

        $this->add_control(
            'icon_indent',
            [
                'label'   => __( 'Icon Spacing', 'bloglentor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 5,
                ],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
//                'condition' => [
//                    $this->get_control_id( 'show_read_more' ) => 'yes',
//                ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-read-more .blfe-read-more-btn-wrapper .blfe-read-more-btn-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-read-more .blfe-read-more-btn-wrapper .blfe-read-more-btn-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    public function register_design_layout_controls() {
        $this->start_controls_section(
            'section_design_layout',
            [
                'label' => __( 'Layout', 'bloglentor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'layout_column_gap',
            [
                'label' => __( 'Columns Gap', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .blfe-row' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
                    //'{{WRAPPER}} .blfe-carousel .slick-list .slick-track .slick-slide' => 'padding-right: {{SIZE}}{{UNIT}}; padding-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => array(
                    'layout_type!' => 'carousel',
                ),
            ]
        );

        $this->add_responsive_control(
            'layout_row_gap',
            [
                'label' => __( 'Rows Gap', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .blfe-row' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
//                    '{{WRAPPER}} .blfe-row.blfe-news1 .blfe-post-grid-item:last-child' => 'margin-bottom: -{{SIZE}}{{UNIT}}',
                ],
                'condition' => array(
                    'layout_type!' => 'carousel',
                ),
            ]
        );

        $this->add_responsive_control(
            'layout_alignment',
            [
                'label' => __( 'Alignment', 'bloglentor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'bloglentor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'bloglentor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'bloglentor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'prefix_class' => 'blfe-posts-align-',
            ]
        );

        $this->end_controls_section();
    }

    public function register_design_header_controls()
    {
        $this->start_controls_section(
            'section_design_header',
            [
                'label' => __( 'Header', 'bloglentor' ),
                'tab' => Controls_Manager::TAB_STYLE,
//                'conditions' => [
//                    'relation' => 'or',
//                    'terms' => [
//                        [
//                            'name' => $this->get_control_id( 'display_header_title' ),
//                            'operator' => '==',
//                            'value' => 'yes'
//                        ],
//                        [
//                            'name' => $this->get_control_id( 'display_filter' ),
//                            'operator' => '==',
//                            'value' => 'yes'
//                        ]
//                    ]
//                ],
            ]
        );

        $this->add_control(
            'header_border_color',
            [
                'label' => __( 'Border Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header' => 'border-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'header_bottom_spacing',
            array(
                'label'     => __( 'Header Bottom Spacing', 'bloglentor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'max' => 200,
                    ),
                ),
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            )
        );

        $this->add_control(
            'section_design_header_title',
            [
                'label'     => __( 'Title', 'bloglentor' ),
                'type'      => Controls_Manager::HEADING,
            ]
        );


        $this->add_control(
            'header_title_color',
            [
                'label' => __( 'Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-post-header-title a' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'header_title_icon_color',
            [
                'label' => __( 'Icon Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-header-title-icon i' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'header_title_bg_color',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-post-header-title' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'header_title_hover_color',
            [
                'label' => __( 'Hover Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-post-header-title a:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'header_title_typography',
                'selector'  => '{{WRAPPER}} .blfe-post-header .blfe-post-header-title .blfe-post-header-title-inner'
            ]
        );

        $this->add_responsive_control(
            'header_title_icon_size',
            array(
                'label'     => __( 'Icon Font Size', 'bloglentor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-header-title-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ]
            )
        );

        $this->add_responsive_control(
            'header_title_padding',
            [
                'label' => __( 'Padding', 'bloglentor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-post-header-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );


        $this->add_responsive_control(
            'header_title_bottom_spacing',
            array(
                'label'     => __( 'Bottom Spacing', 'bloglentor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                ]
            )
        );

        $this->add_control(
            'section_design_header_filter',
            [
                'label'     => __( 'Filter', 'bloglentor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'header_filter_typography',
                'selector' => '{{WRAPPER}} .blfe-post-header .blfe-post-header-filters ul li',
            ]
        );

        $this->start_controls_tabs( 'tabs_header_filter_style' );

        $this->start_controls_tab(
            'tab_header_filter_normal',
            [
                'label' => __( 'Normal', 'bloglentor' ),
            ]
        );

        $this->add_control(
            'header_filter_color',
            [
                'label' => __( 'Text Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-post-header-filters ul li' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'header_filter_bg_color',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-post-header-filters ul li' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_header_filter_hover',
            [
                'label' => __( 'Hover', 'bloglentor' ),
            ]
        );

        $this->add_control(
            'header_filter_hover_color',
            [
                'label' => __( 'Text Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-post-header-filters ul li:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'header_filter_bg_hover_color',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-post-header-filters ul li:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'header_filter_hover_border_color',
            [
                'label' => __( 'Border Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-post-header-filters ul li:hover, {{WRAPPER}} .blfe-post-header .blfe-post-header-filters ul li:focus' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'header_filter_border!' => '',
                ],
            ]
        );

        $this->add_control(
            'header_filter_hover_duration',
            [
                'label' => __( 'Transition Duration', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-post-header-filters ul li' => 'transition-duration: {{SIZE}}ms',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();


        $this->start_controls_tab(
            'tab_header_filter_active',
            [
                'label' => __( 'Active', 'bloglentor' ),
            ]
        );

        $this->add_control(
            'header_filter_active_color',
            [
                'label' => __( 'Text Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-post-header-filters ul li.active' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'header_filter_bg_active_color',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-post-header-filters ul li.active' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'header_filter_active_border_color',
            [
                'label' => __( 'Border Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-post-header-filters ul li.active' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'header_filter_border!' => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'header_filter_border',
                'selector' => '{{WRAPPER}} .blfe-post-header .blfe-post-header-filters ul li',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'header_filter_border_radius',
            [
                'label' => __( 'Border Radius', 'bloglentor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-post-header-filters ul li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'header_filter_box_shadow',
                'selector' => '{{WRAPPER}} .blfe-post-header .blfe-post-header-filters ul li',
            ]
        );

        $this->add_responsive_control(
            'header_filter_padding',
            [
                'label' => __( 'Padding', 'bloglentor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-post-header-filters ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'header_filter_spacing_between',
            array(
                'label'     => __( 'Filter Item Spacing Between', 'bloglentor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-header .blfe-post-header-filters ul li' => 'margin-right: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
                ],
            )
        );

        $this->end_controls_section();
    }

    public function register_design_box_controls(){
        $this->start_controls_section(
            'section_design_box',
            [
                'label' => __( 'Box', 'bloglentor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_border_width',
            [
                'label' => __( 'Border Width', 'bloglentor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => __( 'Border Radius', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label' => __( 'Padding', 'bloglentor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __( 'Content Padding', 'bloglentor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-details, {{WRAPPER}} .blfe-post-grid-details .blfe-post-grid-details-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ]
            ]
        );

        $this->start_controls_tabs( 'box_bg_effects_tabs' );

        $this->start_controls_tab( 'box_bg_normal',
            [
                'label' => __( 'Normal', 'bloglentor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_bg_box_shadow',
                'selector' => '{{WRAPPER}} .blfe-post-grid-item',
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_border_color',
            [
                'label' => __( 'Border Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'box_bg_hover',
            [
                'label' => __( 'Hover', 'bloglentor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_bg_box_shadow_hover',
                'selector' => '{{WRAPPER}} .blfe-post-grid-item:hover',
            ]
        );

        $this->add_control(
            'box_bg_color_hover',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_border_color_hover',
            [
                'label' => __( 'Border Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_bg_effect_duration',
            [
                'label' => __( 'Transition Duration', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item' => 'transition-duration: {{SIZE}}ms',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->end_controls_section();
    }


    public function register_design_featured_post_controls(){
        $this->start_controls_section(
            'section_design_fp',
            [
                'label' => __( 'Featured Post', 'bloglentor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'fp_title_section',
            [
                'label'     => __( 'Title', 'bloglentor' ),
                'type'      => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'fp_title_color',
            [
                'label' => __( 'Title Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-title a,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-title a' => 'color: {{VALUE}}',
                ],
                'condition' => array(
                    $this->get_control_id( 'show_title' ) => 'yes',
                ),
            ]
        );

        $this->add_control(
            'fp_title_hover_color',
            [
                'label' => __( 'Hover Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-title a:hover,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-title a:hover,{{WRAPPER}} .blfe-news4 > :nth-child(1) .blfe-post-grid-item .blfe-post-grid-title a:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'fp_title_typography',
                'selector'  => '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-title,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-title',
            ]
        );


        $this->add_control(
            'fp_meta_section',
            [
                'label'     => __( 'Meta', 'bloglentor' ),
                'type'      => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'fp_meta_color',
            [
                'label' => __( 'Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta span,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta span' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta .blfe-post-meta-dot,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta .blfe-post-meta-dot' => 'border-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'fp_meta_icon_color',
            [
                'label' => __( 'Icon Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta i,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta i' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'fp_meta_link_color',
            [
                'label' => __( 'Link Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta span a,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta span a' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'fp_meta_link_hover_color',
            [
                'label' => __( 'Link Hover Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta span a:hover,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta span a:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'fp_meta_typography',
                'selector'  => '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta span,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta span',
            ]
        );


        $this->add_control(
            'fp_content_section',
            [
                'label'     => __( 'Content', 'bloglentor' ),
                'type'      => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'fp_content_color',
            [
                'label' => __( 'Content Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-excerpt,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-excerpt' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'fp_content_typography',
                'selector'  => '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-excerpt,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-excerpt',
            ]
        );


        $this->add_control(
            'fp_read_more_section',
            [
                'label'     => __( 'Read More', 'bloglentor' ),
                'type'      => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'fp_read_more_text_color',
            [
                'label' => __( 'Text Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-read-more,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-read-more' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'fp_read_more_icon_color',
            [
                'label' => __( 'Icon Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-read-more-btn-wrapper .blfe-read-more-btn-icon,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-read-more-btn-wrapper .blfe-read-more-btn-icon' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'fp_read_more_text_hover_color',
            [
                'label' => __( 'Text Hover Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-read-more:hover,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-read-more:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'fp_read_more_icon_hover_color',
            [
                'label' => __( 'Icon Hover Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-read-more-btn-wrapper .blfe-read-more-btn-icon:hover,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-read-more-btn-wrapper .blfe-read-more-btn-icon:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'fp_read_more_typography',
                'selector'  => '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-read-more-btn-wrapper,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-read-more-btn-wrapper'
            ]
        );

        $this->add_control(
            'fp_taxonomy_section',
            [
                'label'     => __( 'Taxonomy', 'bloglentor' ),
                'type'      => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'fp_taxonomy_typography',
                'selector' => '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-category a,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-category a',
            ]
        );

        $this->start_controls_tabs( 'tabs_fp_taxonomy_style' );

        $this->start_controls_tab(
            'tab_fp_taxonomy_normal',
            [
                'label' => __( 'Normal', 'bloglentor' ),
            ]
        );

        $this->add_control(
            'fp_taxonomy_color',
            [
                'label' => __( 'Text Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-category a,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-category a' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'fp_taxonomy_bg_color',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-category a,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-category a' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_fp_taxonomy_hover',
            [
                'label' => __( 'Hover', 'bloglentor' ),
            ]
        );

        $this->add_control(
            'fp_taxonomy_hover_color',
            [
                'label' => __( 'Text Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-category a:hover,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-category a:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'fp_taxonomy_bg_hover_color',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-category a:hover,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-category a:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'fp_taxonomy_hover_border_color',
            [
                'label' => __( 'Border Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-category a:hover,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-category a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'fp_taxonomy_border',
                'selector' => '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-category a,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-category a',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'fp_taxonomy_border_radius',
            [
                'label' => __( 'Border Radius', 'bloglentor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-skin-news > :nth-child(1) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-category a,{{WRAPPER}} .blfe-skin-news.blfe-news5 > :nth-child(2) .blfe-post-grid-item-inner .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    public function register_design_image_controls(){
        $this->start_controls_section(
            'section_design_image',
            [
                'label' => __( 'Image', 'bloglentor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    $this->get_control_id( 'show_image' ) => 'yes',
                ),
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => __( 'Border Radius', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-image img' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_image_background' );

        $this->start_controls_tab(
            'tab_image_background_normal',
            [
                'label' => __( 'Normal', 'bloglentor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'image_background',
                'exclude'    => [
                    'image'
                ],
                'selector' => '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-bg-image .blfe-post-grid-image-inner:before, {{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-item-inner .blfe-post-grid-image:before',
            ]
        );

        $this->end_controls_tab();


        $this->start_controls_tab(
            'tab_image_background_hover',
            [
                'label' => __( 'Hover', 'bloglentor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'image_background_hover',
                'exclude'    => [
                    'image'
                ],
                'selector' => '{{WRAPPER}} .blfe-post-grid-item:hover .blfe-post-grid-bg-image .blfe-post-grid-image-inner:before, {{WRAPPER}} .blfe-post-grid-item:hover .blfe-post-grid-item-inner .blfe-post-grid-image:before',
            ]
        );


        $this->add_control(
            'image_background_hover_transition',
            [
                'label' => __( 'Transition Duration', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-bg-image .blfe-post-grid-image-inner:before, {{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-item-inner .blfe-post-grid-image:before' => 'transition: background {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'image_background_opacity',
            [
                'label' => __( 'Opacity', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0.4,
                ],
                'range' => [
                    'px' => [
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-bg-image .blfe-post-grid-image-inner:before, {{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-item-inner .blfe-post-grid-image:before' => 'opacity: {{SIZE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function register_design_title_controls(){
        $this->start_controls_section(
            'section_design_title',
            [
                'label' => __( 'Title', 'bloglentor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    $this->get_control_id( 'show_title' ) => 'yes',
                ),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-title a' => 'color: {{VALUE}}',
                ],
                'condition' => array(
                    $this->get_control_id( 'show_title' ) => 'yes',
                ),
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __( 'Hover Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-title a:hover' => 'color: {{VALUE}}',
                ],
                'condition' => array(
                    $this->get_control_id( 'show_title' ) => 'yes',
                ),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'selector'  => '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-title',
                'condition' => array(
                    $this->get_control_id( 'show_title' ) => 'yes',
                ),
            ]
        );

        $this->add_responsive_control(
            'title_top_spacing',
            array(
                'label'     => __( 'Top Spacing', 'bloglentor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-title' => 'padding-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => array(
                    $this->get_control_id( 'show_title' ) => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'title_bottom_spacing',
            array(
                'label'     => __( 'Bottom Spacing', 'bloglentor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-title' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => array(
                    $this->get_control_id( 'show_title' ) => 'yes',
                ),
            )
        );

        $this->end_controls_section();
    }

    public function register_design_excerpt_controls(){
        $this->start_controls_section(
            'section_design_excerpt',
            [
                'label' => __( 'Excerpt', 'bloglentor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    $this->get_control_id( 'show_excerpt' ) => 'yes',
                ),
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => __( 'Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-excerpt' => 'color: {{VALUE}}',
                ],
                'condition' => array(
                    $this->get_control_id( 'show_excerpt' ) => 'yes',
                ),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'excerpt_typography',
                'selector'  => '{{WRAPPER}} .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-excerpt',
                'condition' => array(
                    $this->get_control_id( 'show_excerpt' ) => 'yes',
                ),
            ]
        );

        $this->add_responsive_control(
            'excerpt_top_spacing',
            array(
                'label'     => __( 'Top Spacing', 'bloglentor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-excerpt' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => array(
                    $this->get_control_id( 'show_excerpt' ) => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'excerpt_bottom_spacing',
            array(
                'label'     => __( 'Bottom Spacing', 'bloglentor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => array(
                    $this->get_control_id( 'show_excerpt' ) => 'yes',
                ),
            )
        );

        $this->end_controls_section();
    }

    public function register_design_meta_controls(){
        $this->start_controls_section(
            'section_design_meta',
            [
                'label' => __( 'Meta', 'bloglentor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    $this->get_control_id( 'meta_data!' ) => []
                ),
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => __( 'Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta span' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta .blfe-post-meta-dot' => 'border-color: {{VALUE}}',
                ],
                'condition' => array(
                    $this->get_control_id( 'meta_data!' ) => []
                ),
            ]
        );

        $this->add_control(
            'meta_icon_color',
            [
                'label' => __( 'Icon Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta i' => 'color: {{VALUE}}',
                ],
                'condition' => array(
                    $this->get_control_id( 'meta_data!' ) => []
                ),
            ]
        );

        $this->add_control(
            'meta_link_color',
            [
                'label' => __( 'Link Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta span a' => 'color: {{VALUE}}',
                ],
                'condition' => array(
                    $this->get_control_id( 'meta_data!' ) => []
                ),
            ]
        );

        $this->add_control(
            'meta_link_hover_color',
            [
                'label' => __( 'Link Hover Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta span a:hover' => 'color: {{VALUE}}',
                ],
                'condition' => array(
                    $this->get_control_id( 'meta_data!' ) => []
                ),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'meta_typography',
                'selector'  => '{{WRAPPER}} .blfe-post-grid-details .blfe-post-grid-details-inner .blfe-post-grid-meta span',
                'condition' => array(
                    $this->get_control_id( 'meta_data!' ) => []
                ),
            ]
        );

        $this->add_responsive_control(
            'meta_spacing_between',
            array(
                'label'     => __( 'Meta Spacing Between', 'bloglentor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-meta span + span:before' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-meta-dot' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => array(
                    $this->get_control_id( 'meta_data!' ) => []
                ),
            )
        );

        $this->add_responsive_control(
            'meta_top_spacing',
            array(
                'label'     => __( 'Top Spacing', 'bloglentor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-meta' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => array(
                    $this->get_control_id( 'meta_data!' ) => []
                ),
            )
        );

        $this->add_responsive_control(
            'meta_bottom_spacing',
            array(
                'label'     => __( 'Bottom Spacing', 'bloglentor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => array(
                    $this->get_control_id( 'meta_data!' ) => []
                ),
            )
        );

        $this->end_controls_section();
    }

    public function register_design_taxonomy_controls(){
        $this->start_controls_section(
            'section_design_taxonomy',
            [
                'label' => __( 'Taxonomy', 'bloglentor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    $this->get_control_id( 'show_category' ) => 'yes'
                ),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'taxonomy_typography',
                'selector' => '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-item-inner .blfe-post-category a',
            ]
        );

        $this->start_controls_tabs( 'tabs_taxonomy_style' );

        $this->start_controls_tab(
            'tab_taxonomy_normal',
            [
                'label' => __( 'Normal', 'bloglentor' ),
            ]
        );

        $this->add_control(
            'taxonomy_color',
            [
                'label' => __( 'Text Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-item-inner .blfe-post-category a' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'taxonomy_bg_color',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-item-inner .blfe-post-category a' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_taxonomy_hover',
            [
                'label' => __( 'Hover', 'bloglentor' ),
            ]
        );

        $this->add_control(
            'taxonomy_hover_color',
            [
                'label' => __( 'Text Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-item-inner .blfe-post-category a:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'taxonomy_bg_hover_color',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-item-inner .blfe-post-category a:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'taxonomy_hover_border_color',
            [
                'label' => __( 'Border Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-item-inner .blfe-post-category a:hover, {{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-item-inner .blfe-post-category a:focus' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'taxonomy_border!' => '',
                ],
            ]
        );

        $this->add_control(
            'taxonomy_hover_duration',
            [
                'label' => __( 'Transition Duration', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-item-inner .blfe-post-category a' => 'transition-duration: {{SIZE}}ms',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();


        $this->end_controls_tabs();


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'taxonomy_border',
                'selector' => '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-item-inner .blfe-post-category a',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'taxonomy_border_radius',
            [
                'label' => __( 'Border Radius', 'bloglentor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-item-inner .blfe-post-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'taxonomy_box_shadow',
                'selector' => '{{WRAPPER}}  .blfe-post-grid-item .blfe-post-grid-item-inner .blfe-post-category a',
            ]
        );

        $this->add_responsive_control(
            'taxonomy_padding',
            [
                'label' => __( 'Padding', 'bloglentor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-grid-item-inner .blfe-post-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();
    }

    public function register_design_read_more_controls(){
        $this->start_controls_section(
            'section_design_read_more',
            [
                'label' => __( 'Read More', 'bloglentor' ),
                'tab' => Controls_Manager::TAB_STYLE,
//                'condition' => array(
//                    $this->get_control_id( 'show_read_more' ) => 'yes',
//                ),
            ]
        );

        $this->add_control(
            'read_more_text_color',
            [
                'label' => __( 'Text Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-read-more .blfe-read-more-btn-wrapper' => 'color: {{VALUE}}',
                ],
//                'condition' => array(
//                    $this->get_control_id( 'show_read_more' ) => 'yes',
//                ),
            ]
        );

        $this->add_control(
            'read_more_icon_color',
            [
                'label' => __( 'Icon Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-read-more .blfe-read-more-btn-wrapper .blfe-read-more-btn-icon' => 'color: {{VALUE}}',
                ],
//                'condition' => array(
//                    $this->get_control_id( 'show_read_more' ) => 'yes',
//                ),
            ]
        );

        $this->add_control(
            'read_more_text_hover_color',
            [
                'label' => __( 'Text Hover Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-read-more .blfe-read-more-btn-wrapper:hover' => 'color: {{VALUE}}',
                ],
//                'condition' => array(
//                    $this->get_control_id( 'show_read_more' ) => 'yes',
//                ),
            ]
        );

        $this->add_control(
            'read_more_icon_hover_color',
            [
                'label' => __( 'Icon Hover Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-read-more .blfe-read-more-btn-wrapper .blfe-read-more-btn-icon:hover' => 'color: {{VALUE}}',
                ],
//                'condition' => array(
//                    $this->get_control_id( 'show_read_more' ) => 'yes',
//                ),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'read_more_typography',
                'selector'  => '{{WRAPPER}} .blfe-post-grid-item .blfe-post-read-more .blfe-read-more-btn-wrapper',
//                'condition' => array(
//                    $this->get_control_id( 'show_read_more' ) => 'yes',
//                ),
            ]
        );

        $this->add_responsive_control(
            'read_more_top_spacing',
            array(
                'label'     => __( 'Top Spacing', 'bloglentor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-read-more .blfe-read-more-btn-wrapper' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
//                'condition' => array(
//                    $this->get_control_id( 'show_read_more' ) => 'yes',
//                ),
            )
        );

        $this->add_responsive_control(
            'read_more_bottom_spacing',
            array(
                'label'     => __( 'Bottom Spacing', 'bloglentor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => [
                    '{{WRAPPER}} .blfe-post-grid-item .blfe-post-read-more .blfe-read-more-btn-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
//                'condition' => array(
//                    $this->get_control_id( 'show_read_more' ) => 'yes',
//                ),
            )
        );

        $this->end_controls_section();
    }

    public function register_design_pagination_controls(){
        $this->start_controls_section(
            'section_design_pagination',
            [
                'label' => __( 'Pagination', 'bloglentor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    $this->get_control_id( 'pagination!' ) => 'none',
                ),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pagination_typography',
                'selector' => '{{WRAPPER}} .blfe-grid-pagination a.page-numbers, {{WRAPPER}} .blfe-grid-pagination span.page-numbers, {{WRAPPER}} .blfe-post-prev-next-wrap li a',
            ]
        );

        $this->start_controls_tabs( 'tabs_pagination_style' );

        $this->start_controls_tab(
            'tab_pagination_normal',
            [
                'label' => __( 'Normal', 'bloglentor' ),
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label' => __( 'Text Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-grid-pagination a.page-numbers, {{WRAPPER}} .blfe-grid-pagination span.page-numbers, {{WRAPPER}} .blfe-post-prev-next-wrap li a.blfe-link-disable' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'pagination_bg_color',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-grid-pagination a.page-numbers, {{WRAPPER}} .blfe-grid-pagination span.page-numbers, {{WRAPPER}} .blfe-post-prev-next-wrap li a.blfe-link-disable' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_pagination_hover',
            [
                'label' => __( 'Hover', 'bloglentor' ),
            ]
        );

        $this->add_control(
            'pagination_hover_color',
            [
                'label' => __( 'Text Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-grid-pagination a.page-numbers:hover, {{WRAPPER}} .blfe-grid-pagination span.page-numbers:hover, {{WRAPPER}} .blfe-post-prev-next-wrap li a:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'pagination_bg_hover_color',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-grid-pagination a.page-numbers:hover, {{WRAPPER}} .blfe-grid-pagination span.page-numbers:hover, {{WRAPPER}} .blfe-post-prev-next-wrap li a:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'pagination_hover_border_color',
            [
                'label' => __( 'Border Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-grid-pagination a.page-numbers:hover, {{WRAPPER}} .blfe-grid-pagination span.page-numbers:hover, {{WRAPPER}} .blfe-post-prev-next-wrap li a:hover, {{WRAPPER}} .blfe-grid-pagination a.page-numbers:focus, {{WRAPPER}} .blfe-grid-pagination span.page-numbers:focus, {{WRAPPER}} .blfe-post-prev-next-wrap li a:focus' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination_border!' => '',
                ],
            ]
        );

        $this->add_control(
            'pagination_hover_duration',
            [
                'label' => __( 'Transition Duration', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-grid-pagination a.page-numbers, {{WRAPPER}} .blfe-grid-pagination span.page-numbers,  {{WRAPPER}} .blfe-post-prev-next-wrap li' => 'transition-duration: {{SIZE}}ms',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();


        $this->start_controls_tab(
            'tab_pagination_active',
            [
                'label' => __( 'Active', 'bloglentor' ),
            ]
        );

        $this->add_control(
            'pagination_active_color',
            [
                'label' => __( 'Text Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-grid-pagination a.page-numbers.current, {{WRAPPER}} .blfe-grid-pagination span.page-numbers.current, {{WRAPPER}} .blfe-post-prev-next-wrap li a' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'pagination_bg_active_color',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-grid-pagination a.page-numbers.current, {{WRAPPER}} .blfe-grid-pagination span.page-numbers.current, {{WRAPPER}} .blfe-post-prev-next-wrap li a' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'pagination_active_border_color',
            [
                'label' => __( 'Border Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-grid-pagination a.page-numbers.current, {{WRAPPER}} .blfe-grid-pagination span.page-numbers.current, {{WRAPPER}} .blfe-post-prev-next-wrap li a' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination_border!' => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pagination_border',
                'selector' => '{{WRAPPER}} .blfe-grid-pagination a.page-numbers, {{WRAPPER}} .blfe-grid-pagination span.page-numbers, {{WRAPPER}} .blfe-post-prev-next-wrap li a',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'pagination_border_radius',
            [
                'label' => __( 'Border Radius', 'bloglentor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-grid-pagination a.page-numbers, {{WRAPPER}} .blfe-grid-pagination span.page-numbers, {{WRAPPER}} .blfe-post-prev-next-wrap li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'pagination_box_shadow',
                'selector' => '{{WRAPPER}} .blfe-grid-pagination a.page-numbers, {{WRAPPER}} .blfe-grid-pagination span.page-numbers, {{WRAPPER}} .blfe-post-prev-next-wrap li a',
            ]
        );

        $this->add_responsive_control(
            'pagination_padding',
            [
                'label' => __( 'Padding', 'bloglentor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-grid-pagination a.page-numbers, {{WRAPPER}} .blfe-grid-pagination span.page-numbers, {{WRAPPER}} .blfe-post-prev-next-wrap li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();
    }

    public function register_design_carousel_controls(){
        $this->start_controls_section(
            'section_design_carousel',
            [
                'label' => __( 'Carousel', 'bloglentor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout_type'  => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'section_design_carousel_arrows',
            [
                'label'     => __( 'Arrows', 'bloglentor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'carousel_arrow_size',
            [
                'label' => __( 'Arrow Size', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 70,
                    ],
                ],
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .blfe-carousel .slick-prev, {{WRAPPER}} .blfe-carousel .slick-next' => 'font-size: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'carousel_arrow_height',
            [
                'label' => __( 'Height', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 150,
                    ],
                ],
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .blfe-carousel .slick-prev, {{WRAPPER}} .blfe-carousel .slick-next' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'carousel_arrow_width',
            [
                'label' => __( 'Width', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 150,
                    ],
                ],
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .blfe-carousel .slick-prev, {{WRAPPER}} .blfe-carousel .slick-next' => 'width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs( 'tabs_carousel_arrows_style' );

        $this->start_controls_tab(
            'tab_carousel_arrows_normal',
            [
                'label' => __( 'Normal', 'bloglentor' ),
            ]
        );

        $this->add_control(
            'carousel_arrows_color',
            [
                'label' => __( 'Arrows Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-carousel .slick-prev, {{WRAPPER}} .blfe-carousel .slick-next' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'carousel_arrows_bg_color',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-carousel .slick-prev, {{WRAPPER}} .blfe-carousel .slick-next' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_carousel_arrows_hover',
            [
                'label' => __( 'Hover', 'bloglentor' ),
            ]
        );

        $this->add_control(
            'carousel_arrows_hover_color',
            [
                'label' => __( 'Arrows Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-carousel .slick-prev:hover, {{WRAPPER}} .blfe-carousel .slick-next:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'carousel_arrows_bg_hover_color',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-carousel .slick-prev:hover, {{WRAPPER}} .blfe-carousel .slick-next:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'carousel_arrows_hover_border_color',
            [
                'label' => __( 'Border Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-carousel .slick-prev, {{WRAPPER}} .blfe-carousel .slick-next, {{WRAPPER}} .blfe-carousel .slick-prev:focus, {{WRAPPER}} .blfe-carousel .slick-next:focus' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'carousel_arrows_border!' => '',
                ],
            ]
        );

        $this->add_control(
            'carousel_arrows_hover_duration',
            [
                'label' => __( 'Transition Duration', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-carousel .slick-prev, {{WRAPPER}} .blfe-carousel .slick-next' => 'transition-duration: {{SIZE}}ms',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();


        $this->end_controls_tabs();


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'carousel_arrows_border',
                'selector' => '{{WRAPPER}} .blfe-carousel .slick-prev, {{WRAPPER}} .blfe-carousel .slick-next',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'carousel_arrows_border_radius',
            [
                'label' => __( 'Border Radius', 'bloglentor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-carousel .slick-prev, {{WRAPPER}} .blfe-carousel .slick-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'carousel_arrows_box_shadow',
                'selector' => '{{WRAPPER}} .blfe-carousel .slick-prev, {{WRAPPER}} .blfe-carousel .slick-next',
            ]
        );

        $this->add_responsive_control(
            'carousel_arrows_padding',
            [
                'label' => __( 'Padding', 'bloglentor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-carousel .slick-prev, {{WRAPPER}} .blfe-carousel .slick-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'section_design_carousel_dots',
            [
                'label'     => __( 'Dots', 'bloglentor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'carousel_dots_size',
            [
                'label' => __( 'Dots Size', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 20,
                    ],
                ],
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .blfe-carousel .slick-dots li button' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'carousel_dots_color',
            [
                'label' => __( 'Dots Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-carousel .slick-dots li button' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'carousel_dots_active_color',
            [
                'label' => __( 'Dots Active Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-carousel .slick-dots li.slick-active button' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function register_post_query_controls(){

        $this->start_controls_section(
            'post_grid_heading',
            [
                'label' => __( 'Query', 'bloglentor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $post_types = apply_filters( 'blfe/post_grid_query_post_types', Helper::get_post_types());

        $this->add_control(
            'post_type',
            [
                'label' => __( 'Post Type', 'bloglentor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $post_types,
            ]
        );


        do_action( 'blfe/post_grid_query_manual_selection_control', $this,  $this->get_control_id('post_type'));

        do_action( 'blfe/post_grid_query_author_control', $this,  $this->get_control_id('post_type'));

        $taxonomies = get_taxonomies([], 'objects');
        foreach ($taxonomies as $taxonomy => $object) {
            if (!isset($object->object_type[0]) || !in_array($object->object_type[0], array_keys($post_types))) {
                continue;
            }

            $this->add_control(
                $taxonomy . '_ids',
                [
                    'label' => $object->label,
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'object_type' => $taxonomy,
                    'options' => wp_list_pluck(get_terms($taxonomy), 'name', 'term_id'),
                    'condition' => [
                        $this->get_control_id( 'post_type' ) => $object->object_type,
                    ],
                ]
            );
        }

        do_action('blfe/post_grid_query_exclude_control', $this, $this->get_control_id('post_type'));

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'bloglentor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->add_control(
            'ignore_sticky_posts',
            [
                'label'   => __( 'Ignore Sticky Posts', 'bloglentor' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'offset',
            [
                'label' => __('Offset', 'bloglentor'),
                'type' => Controls_Manager::NUMBER,
                'description' => __( 'Use this setting to exclude number of initial posts from being display', 'bloglentor' ),
                'default' => 0,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'bloglentor'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'none' => __('No order', 'bloglentor'),
                    'ID' => __('Post ID', 'bloglentor'),
                    'author' => __('Author', 'bloglentor'),
                    'title' => __('Title', 'bloglentor'),
                    'date' => __('Published date', 'bloglentor'),
                    'modified' => __('Modified date', 'bloglentor'),
                    'parent' => __('By parent', 'bloglentor'),
                    'rand' => __('Random order', 'bloglentor'),
                    'comment_count' => __('Comment count', 'bloglentor'),
                    'popular' => __('Popular Post by View Count', 'bloglentor'),
                    'menu_order' => __('Menu order', 'bloglentor'),
                ),
                'default' => 'ID',
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'bloglentor'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'ASC' => __('Ascending', 'bloglentor'),
                    'DESC' => __('Descending', 'bloglentor'),
                ),
                'default' => 'DESC',
            ]
        );

        $this->end_controls_section();
    }



}