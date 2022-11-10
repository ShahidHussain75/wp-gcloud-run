<?php
namespace BlogLentor\Modules\PostTaxonomy\Skins;
use BlogLentor\Classes\Helper;
use Elementor\Controls_Manager;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

abstract class Skin_Base extends Elementor_Skin_Base {

    protected function _register_controls_actions() {
        add_action( 'elementor/element/blfe-post-taxonomy/section_layout/after_section_end', [ $this, 'register_controls' ] );
        add_action( 'elementor/element/blfe-post-taxonomy/section_layout/after_section_end', [ $this, 'register_sections' ] );

    }

    public function register_sections( Widget_Base $widget ) {

        $this->parent = $widget;

        // Content Controls.
        $this->register_header_controls();
        $this->register_design_post_taxonomy_general_controls();
        $this->register_design_header_controls();
        $this->register_design_post_taxonomy_title_controls();
        $this->register_design_post_taxonomy_count_controls();

    }


    public function register_controls( Widget_Base $widget ) {
        $this->parent = $widget;
        $this->register_post_query_controls();
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
                'default' => 'Category',
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

        $this->end_controls_section();
    }


    protected function register_design_post_taxonomy_general_controls(){
        $this->start_controls_section(
            'section_general_style',
            [
                'label' => esc_html__('Box', 'bloglentor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'post_taxonomy_bg',
				'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .blfe-taxonomy-list li',
                'exclude'   =>[
                    'image'
                ]
			]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'post_taxonomy_border_color',
				'selector' => '{{WRAPPER}} .blfe-taxonomy-list li',
            ]
        );

		$this->add_responsive_control(
			'post_taxonomy_radius',
			[
				'label'      => __( 'Border Radius', 'bloglentor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .blfe-taxonomy-list li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'post_taxonomy_shadow',
				'selector' => '{{WRAPPER}} .blfe-taxonomy-list li',
			]
        );
        
        $this->add_responsive_control(
            'post_taxonomy_padding',
            [
                'label' => __('Padding', 'bloglentor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .blfe-taxonomy-list li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
            ]
        );
        
        $this->add_responsive_control(
			'post_taxonomy_margin',
			[
				'label' => __('Margin', 'bloglentor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .blfe-taxonomy-list li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
                'condition' => array(
                    $this->get_control_id( 'display_header_title' ) => 'yes',
                )
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

        $this->end_controls_section();
    }

    protected function register_design_post_taxonomy_title_controls(){
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Taxonomy', 'bloglentor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'post_taxonomy_title_color',
            [
                'label' => __( 'Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-taxonomy-list li a .blfe-taxonomy-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'post_taxonomy_title_typography',
                'label' => __( 'Typography', 'bloglentor' ),
                'selector' => '{{WRAPPER}} .blfe-taxonomy-list li a .blfe-taxonomy-name',
            ]
		);

        $this->end_controls_section();
    }

    protected function register_design_post_taxonomy_count_controls(){
        $this->start_controls_section(
            'section_count_style',
            [
                'label' => esc_html__('Count', 'bloglentor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'post_taxonomy_count_color',
            [
                'label' => __( 'Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-taxonomy-list li a .blfe-taxonomy-count' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'post_taxonomy_count_bg',
				'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .blfe-taxonomy-list li a .blfe-taxonomy-count',
                'exclude'   =>[
                    'image'
                ]
			]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'post_taxonomy_count_border_color',
				'selector' => '{{WRAPPER}} .blfe-taxonomy-list li a .blfe-taxonomy-count',
            ]
        );

		$this->add_responsive_control(
			'post_taxonomy_count_radius',
			[
				'label'      => __( 'Border Radius', 'bloglentor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .blfe-taxonomy-list li a .blfe-taxonomy-count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'post_taxonomy_count_height',
            [
               'label' => esc_html__('Height', 'bloglentor'),
               'type' => \Elementor\Controls_Manager::SLIDER,
               'range' => [
                  'px' => [
                     'min' => 0,
                     'max' => 100,
                  ],
               ],
               'selectors' => [
                  '{{WRAPPER}} .blfe-taxonomy-list li a .blfe-taxonomy-count' => 'height: {{SIZE}}{{UNIT}};line-height: calc({{SIZE}}{{UNIT}} - 4{{UNIT}});',
               ],
            ]
         );

         $this->add_responsive_control(
            'post_taxonomy_count_width',
            [
               'label' => esc_html__('Width', 'bloglentor'),
               'type' => \Elementor\Controls_Manager::SLIDER,
               'range' => [
                  'px' => [
                     'min' => 0,
                     'max' => 100,
                  ],
               ],
               'selectors' => [
                  '{{WRAPPER}} .blfe-taxonomy-list li a .blfe-taxonomy-count' => 'width: {{SIZE}}{{UNIT}};',
               ],
            ]
         );

        $this->add_control(
            'post_taxonomy_count_bar_heading',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Bar', 'bloglentor' ),
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'post_taxonomy_count_bar_color',
            [
                'label' => __( 'Bar Color', 'bloglentor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blfe-taxonomy-list li a span.blfe-taxonomy-bar' => 'border-bottom: 1px dashed {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function register_post_query_controls(){

        $this->start_controls_section(
            'post_taxonomy_heading',
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
        foreach ($taxonomies as $post_taxonomy => $object) {
            if (!isset($object->object_type[0]) || !in_array($object->object_type[0], array_keys($post_types))) {
                continue;
            }

            if($post_taxonomy != 'post_format'){
                $this->add_control(
                    $post_taxonomy . '_ids',
                    [
                        'label' => $object->label,
                        'type' => Controls_Manager::SELECT2,
                        'label_block' => true,
                        'multiple' => true,
                        'object_type' => $post_taxonomy,
                        'options' => wp_list_pluck(get_terms($post_taxonomy), 'name', 'slug'),
                        'condition' => [
                            $this->get_control_id( 'post_type' ) => $object->object_type,
                        ],
                    ]
                );
            }
            
        }

        $this->end_controls_section();
    }

    
    public function render() {
        $taxonomies = get_taxonomies([], 'objects');

        $post_type = $this->get_instance_value('post_type');

        $i = 0;
        foreach ($taxonomies as $post_taxonomy => $object) {
            $i++;
            if($post_taxonomy != 'post_format' && in_array($post_type, $object->object_type )){
                $control_id = $post_taxonomy . '_ids';

                $terms = $this->get_instance_value( $control_id );

                if ( empty( $terms) && $i <= 1){
                    echo __('Please select a taxonomy from the widget query settings', 'bloglentor');
                }

                if( !empty($terms) && is_array($terms) ){
                    $this->rander_taxonomy($terms, $post_taxonomy);
                }

            }

        }

    }

    protected function rander_post_taxonomy_item($terms, $post_taxonomy){

        $settings  =  $this->parent->get_settings();

        $taxonomy_count_enable = $settings['taxonomy_count_enable'];
        $taxonomy_bar_enable   = $settings['taxonomy_bar_enable'];

        $taxonomy_link_new_tab = $settings['taxonomy_link_new_tab'];
        $target = $taxonomy_link_new_tab === 'yes' ? '_blank' : '_self';

        foreach ($terms as $index => $cat) {
            $taxonomy = get_term_by('slug', $cat, $post_taxonomy);
            if (!empty($taxonomy)) { ?>
                <li>
                    <a href="<?php echo esc_url(get_category_link($taxonomy->term_id)); ?>" target="<?php echo $target ?>">
                        <span class="blfe-taxonomy-name"> <?php echo esc_html($taxonomy->name); ?> </span>

                        <?php if ($taxonomy_count_enable): ?>
                            <?php if ($taxonomy_bar_enable): ?> <span class="blfe-taxonomy-bar"></span> <?php endif; ?>
                            <?php if (isset($taxonomy->count)) : ?>
                                <span class="blfe-taxonomy-count"><?php echo esc_html($taxonomy->count); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>
                </li>
            <?php }
        } 
    }


    public function get_header(){

        $settings = $this->parent->get_settings();

        $migration_allowed = Icons_Manager::is_migration_allowed();
        $migrated = $this->get_instance_value( '__fa4_migrated');

        $is_new = empty( $settings['header_title_fa4_icon'] ) && $migration_allowed;

        $selected_icon = $this->get_instance_value('header_title_icon');

        $this->parent->add_render_attribute(
            'header-icon-align',
            'class',
            array(
                'blfe-header-title-icon',
                'blfe-header-title-align-icon-' . $this->get_instance_value('header_icon_align')
            )
        );

        $header_style = $this->get_instance_value('header_style');

        $this->parent->add_render_attribute(
            'header_wrapper',
            'class',
            array(
                'blfe-post-header',
                'blfe-post-header-'.$header_style
            )
        );


        echo '<div '.wp_kses_post($this->parent->get_render_attribute_string('header_wrapper')).'>';
        echo '<div class="blfe-post-header-title">';

        if ( ! empty( $settings['header_title_fa4_icon'] ) || ! empty( $selected_icon['value'] ) ) : ?>
            <span <?php echo wp_kses_post($this->parent->get_render_attribute_string( 'header-icon-align')); ?>>
                <?php if ( $is_new || $migrated ) :
                    Icons_Manager::render_icon( $selected_icon, [ 'aria-hidden' => 'true' ] );
                else : ?>
                    <i class="<?php echo esc_attr( $settings['header_title_fa4_icon'] ); ?>" aria-hidden="true"></i>
                <?php endif; ?>
                    </span>
        <?php endif;


        $display_header_title = $this->get_instance_value( 'display_header_title' );

        if( $display_header_title === 'yes' ) {
            $tag = $this->get_instance_value('header_title_tag');

            $title = $this->get_instance_value('header_title');

            $url = $this->get_instance_value('header_title_url');

            $this->parent->add_render_attribute('title', 'class', 'blfe-post-header-title-inner');

            if (!empty($url)) {

                $this->parent->add_link_attributes('url', $url);

                $title = sprintf('<a %1$s>%2$s</a>',$this->parent->get_render_attribute_string('url'), $title);
            }

            $title_html = sprintf('<%1$s %2$s>%3$s</%1$s>', $tag, $this->parent->get_render_attribute_string('title'), $title);

            echo $title_html;
        }

        echo '</div>';
        echo '</div>';

    }

    protected function rander_taxonomy($terms, $post_taxonomy){
        $display_header_title = $this->get_instance_value( 'display_header_title' );
        if( $display_header_title === 'yes' ) {
            $this->get_header();
        }
        ?>
        <div class="blfe-taxonomy blfe-taxonomy-list-item">
            <ul class="blfe-taxonomy-list">
                <?php 
                    $this->rander_post_taxonomy_item($terms, $post_taxonomy);
                ?>
            </ul>
        </div>
    <?php
    }
    

}