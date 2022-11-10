<?php
namespace BlogLentor\Modules\NewsTicker\Skins;
use BlogLentor\Classes\Helper;
use Elementor\Controls_Manager;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

abstract class Skin_Base extends Elementor_Skin_Base {

    /**
     * @var string Save current permalink to avoid conflict with plugins the filters the permalink during the post render.
     */
    protected $current_permalink;

    protected function _register_controls_actions() {
        add_action( 'elementor/element/blfe-news-ticker/section_layout/after_section_end', [ $this, 'register_controls' ] );
        add_action( 'elementor/element/blfe-news-ticker/section_layout/after_section_end', [ $this, 'register_sections' ] );
    }

    public function register_sections( Widget_Base $widget ) {

        $this->parent = $widget;

        // Content Controls.
        $this->register_animation_controls();

        $this->register_design_ticker_controls();
        $this->register_design_ticker_title_controls();
        $this->register_design_ticker_content_controls();
        $this->register_design_ticker_arrows_controls();

    }


    public function register_controls( Widget_Base $widget ) {
        $this->parent = $widget;
        $this->register_post_query_controls();
    }

    protected function register_post_query_controls(){

        $this->start_controls_section(
            'section_query',
            [
                'label' => __( 'Query', 'bloglentor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $post_types = Helper::get_post_types();

        $this->add_control(
            'post_type',
            [
                'label' => __( 'Post Type', 'bloglentor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $post_types,
            ]
        );

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


    protected function register_animation_controls(){

        $this->start_controls_section(
            'section_carousel',
            array(
                'label' => __( 'Animation Settings', 'bloglentor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'animation',
            [
                'label'     => __( 'Animation', 'bloglentor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'ease',
                'options'   => [
                    'ease' => __( 'Slide', 'bloglentor' ),
                    'fade'  => __( 'Fade', 'bloglentor' ),
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'animation_speed',
            array(
                'label'   => __( 'Animation Speed', 'bloglentor' ),
                'description' => __( 'Slide speed in milliseconds', 'bloglentor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 400,
                'min' => 100,
                'step' => 10,
                'max' => 10000,
                'frontend_available' => true,
            )
        );

        $this->add_responsive_control(
            'slides_to_show',
            [
                'label' => __( 'Slides To Show', 'bloglentor' ),
                'type' => Controls_Manager::NUMBER,
                'desktop_default' => 1,
                'tablet_default' => 1,
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
                'default'   => 2000,
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
            'navigation',
            array(
                'label'       => __( 'Navigation', 'bloglentor' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'arrows',
                'options'     => array(
                    'none'     => __( 'None', 'bloglentor' ),
                    'arrows'  => __( 'Arrows', 'bloglentor' ),
                ),
                'frontend_available' => true,
            )
        );

        $this->end_controls_section();

    }

    protected function register_design_ticker_controls(){
        $this->start_controls_section(
            'section_ticker_style',
            [
                'label' => esc_html__('Ticker', 'bloglentor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'ticker_height',
            [
                'label' => __( 'Height', 'bloglentor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 300,
                    ],
                ],
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .blfe-news-ticker' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'ticker_bg_color',
            [
                'label' => esc_html__('Background Color', 'bloglentor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .blfe-news-ticker' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'ticker_border',
                'selector' => '{{WRAPPER}} .blfe-news-ticker',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'ticker_border_radius',
            [
                'label' => __( 'Border Radius', 'bloglentor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-news-ticker' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'ticker_box_shadow',
                'selector' => '{{WRAPPER}} .blfe-news-ticker',
            ]
        );


        $this->end_controls_section();
    }


    public function register_design_ticker_title_controls(){
        $this->start_controls_section(
            'section_ticker_title_style',
            [
                'label' => esc_html__('Title', 'bloglentor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'ticker_title_bg_color',
            [
                'label' => esc_html__('Background Color', 'bloglentor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .blfe-news-ticker .blfe-news-ticker-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'ticker_title_color',
            [
                'label' => esc_html__('Color', 'bloglentor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .blfe-news-ticker .blfe-news-ticker-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'ticker_title_typography',
                'selector' => '{{WRAPPER}} .blfe-news-ticker .blfe-news-ticker-title',
            ]
        );

        $this->add_responsive_control(
            'ticker_title_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bloglentor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .blfe-news-ticker .blfe-news-ticker-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    public function register_design_ticker_content_controls(){

        $this->start_controls_section(
            'section_ticker_content_style',
            [
                'label' => esc_html__('Ticker Content', 'bloglentor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_ticker_content_style');

        $this->start_controls_tab(
            'tab_ticker_content_normal',
            [
                'label' => __('Normal', 'bloglentor'),
            ]
        );

        $this->add_control(
            'ticker_content_bg',
            [
                'label' => esc_html__('Background Color', 'bloglentor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .blfe-news-ticker .blfe-news-ticker-content-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'ticker_content_color',
            [
                'label' => esc_html__('Text Color', 'bloglentor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .blfe-news-ticker .blfe-news-ticker-content-wrapper .blfe-news-ticker-content .blfe-ticker-item .blfe-ticker-item-content a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'ticker_content_typography',
                'selector' => '{{WRAPPER}} .blfe-news-ticker .blfe-news-ticker-content-wrapper .blfe-news-ticker-content .blfe-ticker-item .blfe-ticker-item-content a',

            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_ticker_content_hover',
            [
                'label' => __('Hover', 'bloglentor'),
            ]
        );

        $this->add_control(
            'ticker_content_hover_color',
            [
                'label' => esc_html__('Text Hover Color', 'bloglentor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .blfe-news-ticker .blfe-news-ticker-content-wrapper .blfe-news-ticker-content .blfe-ticker-item .blfe-ticker-item-content a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'date_heading',
            [
                'label' => esc_html__( 'Date', 'bloglentor' ),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'ticker_date_color',
            [
                'label' => esc_html__('Date Color', 'bloglentor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .blfe-news-ticker .blfe-news-ticker-content-wrapper .blfe-news-ticker-content .blfe-ticker-item .blfe-ticker-item-content .blfe-news-ticker-date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'ticker_date_typography',
                'selector' => '{{WRAPPER}} .blfe-news-ticker .blfe-news-ticker-content-wrapper .blfe-news-ticker-content .blfe-ticker-item .blfe-ticker-item-content .blfe-news-ticker-date',

            ]
        );

        $this->end_controls_section();
    }

    public function register_design_ticker_arrows_controls(){
        $this->start_controls_section(
            'section_arrows_style',
            [
                'label' => __('Arrows', 'bloglentor'),
                'tab' => Controls_Manager::TAB_STYLE,
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
                    '{{WRAPPER}} .blfe-news-ticker .slick-prev, {{WRAPPER}} .blfe-news-ticker .slick-next' => 'font-size: {{SIZE}}{{UNIT}}',
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
                    '{{WRAPPER}} .blfe-news-ticker .slick-prev, {{WRAPPER}} .blfe-news-ticker .slick-next' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .blfe-news-ticker .slick-prev, {{WRAPPER}} .blfe-news-ticker .slick-next' => 'width: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .blfe-news-ticker .slick-prev,{{WRAPPER}} .blfe-news-ticker .slick-next' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'carousel_arrows_bg_color',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-news-ticker .slick-prev,{{WRAPPER}} .blfe-news-ticker .slick-next' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .blfe-news-ticker .slick-prev:hover,{{WRAPPER}} .blfe-news-ticker .slick-next:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'carousel_arrows_bg_hover_color',
            [
                'label' => __( 'Background Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-news-ticker .slick-prev:hover,{{WRAPPER}} .blfe-news-ticker .slick-next:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'carousel_arrows_hover_border_color',
            [
                'label' => __( 'Border Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-news-ticker .slick-prev:hover,{{WRAPPER}} .blfe-news-ticker .slick-next:hover, {{WRAPPER}} .blfe-news-ticker .slick-prev:focus,{{WRAPPER}} .blfe-news-ticker .slick-next:focus' => 'border-color: {{VALUE}};',
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
                    '{{WRAPPER}} .blfe-news-ticker .slick-prev,{{WRAPPER}} .blfe-news-ticker .slick-next' => 'transition-duration: {{SIZE}}ms',
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
                'selector' => '{{WRAPPER}} .blfe-news-ticker .slick-prev,{{WRAPPER}} .blfe-news-ticker .slick-next',
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
                    '{{WRAPPER}} .blfe-news-ticker .slick-prev,{{WRAPPER}} .blfe-news-ticker .slick-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'carousel_arrows_box_shadow',
                'selector' => '{{WRAPPER}} .blfe-news-ticker .slick-prev,{{WRAPPER}} .blfe-news-ticker .slick-next',
            ]
        );

        $this->add_responsive_control(
            'carousel_arrows_padding',
            [
                'label' => __( 'Padding', 'bloglentor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .blfe-news-ticker .slick-prev,{{WRAPPER}} .blfe-news-ticker .slick-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();
    }

    public function render_date(){
        $settings =  $this->parent->get_settings();
        if( $settings['display_date'] !== 'yes' ){
            return;
        }

        echo '<span class="blfe-news-ticker-date">'.apply_filters( 'the_date', get_the_date(), get_option( 'date_format' ), '', '' ).'</span>';
    }

    protected function render_title() {
        $post_link_new_tab = $this->get_instance_value( 'post_link_new_tab' );
        $target = $post_link_new_tab === 'yes' ? '_blank' : '_self';
        ?>
        <a href="<?php echo $this->current_permalink; ?>" rel="nofollow" target="<?php echo $target; ?>">
            <?php the_title(); ?>
        </a>
       <?php
    }

    public function render() {

        $skin = $this->get_id();
        $settings =  $this->parent->get_settings();

        $this->parent->add_render_attribute(
            'wrapper',
            'class',
            array(
                'blfe-news-ticker',
                'blfe-'.$skin,
            )
        );

        $this->parent->add_render_attribute('inner_wrapper', 'data-skin', $skin);

        $this->parent->add_render_attribute(
            'inner_wrapper',
            'class',
            array(
                'blfe-news-ticker-content',
                'blfe-carousel',
            )
        );

        ?>
        <div <?php echo wp_kses_post( $this->parent->get_render_attribute_string( 'wrapper' ) ); ?>>

            <?php if ( $settings['title_enable'] === 'yes' ) { ?>
            <div class="blfe-news-ticker-title">
                <span><?php echo $settings['title']; ?></span>
            </div>
            <?php } ?>
            <div class="blfe-news-ticker-content-wrapper">
                <div <?php echo wp_kses_post( $this->parent->get_render_attribute_string( 'inner_wrapper' ) ); ?>>

                    <?php
                    $args = Helper::build_query_args($skin, $settings);
                    $query = new \WP_Query($args);

                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                            $this->current_permalink = get_permalink();
                            $this->render_post();
                        }
                    }
                    wp_reset_postdata();
                    ?>

                </div>
            </div>

        </div>
        <?php
    }


    protected function render_post() {
        ?>
        <div class="blfe-ticker-item">
            <div class="blfe-ticker-item-content">
                <?php
                    $this->render_title();
                    $this->render_date();
                ?>
            </div>
        </div>
        <?php
    }

}