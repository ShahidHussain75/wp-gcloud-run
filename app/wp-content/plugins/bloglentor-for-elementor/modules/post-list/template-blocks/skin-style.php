<?php
namespace BlogLentor\Modules\PostList\TemplateBlocks;
use BlogLentor\Classes\Helper;
use Elementor\Utils;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Skin_Style
 */
abstract class Skin_Style {

    public static $query;

    public static $query_obj;

    public static $settings;

    public static $skin;

    public static $node_id;

    protected $current_permalink;

    protected $thumbnail_id;

    /**
     * Element render attributes.
     *
     * Holds all the render attributes of the element. Used to store data like
     * the HTML class name and the class value, or HTML element ID name and value.
     *
     * @access private
     *
     * @var array
     */
    protected $_render_attributes;


    /**
     * Add render attribute.
     *
     * Used to add attributes to a specific HTML element.
     *
     * The HTML tag is represented by the element parameter, then you need to
     * define the attribute key and the attribute key. The final result will be:
     * `<element attribute_key="attribute_value">`.
     *
     * Example usage:
     *
     * `$this->add_render_attribute( 'wrapper', 'class', 'custom-widget-wrapper-class' );`
     * `$this->add_render_attribute( 'widget', 'id', 'custom-widget-id' );`
     * `$this->add_render_attribute( 'button', [ 'class' => 'custom-button-class', 'id' => 'custom-button-id' ] );`
     *
     * @since 1.0.0
     * @access public
     *
     * @param array|string $element   The HTML element.
     * @param array|string $key       Optional. Attribute key. Default is null.
     * @param array|string $value     Optional. Attribute value. Default is null.
     * @param bool         $overwrite Optional. Whether to overwrite existing
     *                                attribute. Default is false, not to overwrite.
     *
     * @return Element_Base Current instance of the element.
     */
    public function add_render_attribute( $element, $key = null, $value = null, $overwrite = false ) {
        if ( is_array( $element ) ) {
            foreach ( $element as $element_key => $attributes ) {
                $this->add_render_attribute( $element_key, $attributes, null, $overwrite );
            }

            return $this;
        }

        if ( is_array( $key ) ) {
            foreach ( $key as $attribute_key => $attributes ) {
                $this->add_render_attribute( $element, $attribute_key, $attributes, $overwrite );
            }

            return $this;
        }

        if ( empty( $this->_render_attributes[ $element ][ $key ] ) ) {
            $this->_render_attributes[ $element ][ $key ] = array();
        }

        settype( $value, 'array' );

        if ( $overwrite ) {
            $this->_render_attributes[ $element ][ $key ] = $value;
        } else {
            $this->_render_attributes[ $element ][ $key ] = array_merge( $this->_render_attributes[ $element ][ $key ], $value );
        }

        return $this;
    }


    /**
     * Get render attribute string.
     *
     * Used to retrieve the value of the render attribute.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array|string $element The element.
     *
     * @return string Render attribute string, or an empty string if the attribute
     *                is empty or not exist.
     */
    public function get_render_attribute_string( $element ) {
        if ( empty( $this->_render_attributes[ $element ] ) ) {
            return '';
        }

        $render_attributes = $this->_render_attributes[ $element ];

        $attributes = array();

        foreach ( $render_attributes as $attribute_key => $attribute_values ) {
            $attributes[] = sprintf( '%1$s="%2$s"', $attribute_key, esc_attr( implode( ' ', $attribute_values ) ) );
        }

        return implode( ' ', $attributes );
    }


    /**
     * Add link render attributes.
     *
     * Used to add link tag attributes to a specific HTML element.
     *
     * The HTML link tag is represented by the element parameter. The `url_control` parameter
     * needs to be an array of link settings in the same format they are set by Elementor's URL control.
     *
     * Example usage:
     *
     * `$this->add_link_attributes( 'button', $settings['link'] );`
     *
     * @since 1.0.3
     * @access public
     *
     * @param array|string $element   The HTML element.
     * @param array $url_control      Array of link settings.
     * @param bool $overwrite         Optional. Whether to overwrite existing
     *                                attribute. Default is false, not to overwrite.
     *
     * @return Element_Base Current instance of the element.
     */

    public function add_link_attributes( $element, array $url_control, $overwrite = false ) {
        $attributes = [];

        if ( ! empty( $url_control['url'] ) ) {
            $attributes['href'] = esc_url( $url_control['url'] );
        }

        if ( ! empty( $url_control['is_external'] ) ) {
            $attributes['target'] = '_blank';
        }

        if ( ! empty( $url_control['nofollow'] ) ) {
            $attributes['rel'] = 'nofollow';
        }

        if ( ! empty( $url_control['custom_attributes'] ) ) {
            // Custom URL attributes should come as a string of comma-delimited key|value pairs
            $attributes = array_merge( $attributes, Utils::parse_custom_attributes( $url_control['custom_attributes'] ) );
        }

        if ( $attributes ) {
            $this->add_render_attribute( $element, $attributes, $overwrite );
        }

        return $this;
    }

    /**
     * Render settings array for selected skin
     *
     * @since 1.0.0
     * @param string $control_base_id Skin ID.
     * @access public
     */
    public function get_instance_value( $control_base_id ) {
        if ( isset( self::$settings[ self::$skin . '_' . $control_base_id ] ) ) {
            return self::$settings[ self::$skin . '_' . $control_base_id ];
        } else {
            return null;
        }
    }

    public function render_title(){

        if( $this->get_instance_value( 'show_title' ) !== 'yes' ){
            return;
        }

        $tag = $this->get_instance_value( 'title_tag' );

        $link_title = $this->get_instance_value( 'link_title' );
        $title_link_new_tab = $this->get_instance_value( 'title_link_new_tab' );
        $target = $title_link_new_tab === 'yes' ? '_blank' : '_self';

        $trim_title = $this->get_instance_value( 'trim_title' );
        $title_num_words = $this->get_instance_value( 'title_num_words' );
        $title_indicator = $this->get_instance_value( 'title_indicator' );
        $title =  $trim_title === 'yes' ? wp_trim_words(get_the_title(), $title_num_words, $title_indicator) : get_the_title();

        if( 'yes' === $link_title ){
            echo '<'.$tag.' class="blfe-post-list-title">
            <a href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_title()) . '" rel="nofollow" target="'.$target.'">' . esc_html($title)  . '</a>
            </'.$tag.'>';
        } else {
            echo '<'.$tag.' class="blfe-post-list-title">'. esc_html($title) .'</'.$tag.'>';
        }
    }

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
            echo '<div class="blfe-post-image-wrapper"><a class="blfe-post-list-image" href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_title()) . '" rel="nofollow" target="'.$target.'"><span style="background-image: url('.$image_src.')"></span></a></div>';
        } else {
            echo '<div class="blfe-post-image-wrapper"><div class="blfe-post-list-image"><span style="background-image: url('.$image_src.')"></span></div></div>';
        }
    }

    public function render_excerpt() {
        if( $this->get_instance_value( 'show_excerpt' ) !== 'yes'  ){
            return;
        }

        $excerpt_length = $this->get_instance_value( 'excerpt_length' );
        $indicator = $this->get_instance_value( 'excerpt_indicator' );

        echo '<p class="blfe-post-list-excerpt">' . Helper::custom_excerpt($excerpt_length, $indicator) . '</p>';
    }


    public function render_author(){
        $meta_style = $this->get_instance_value('meta_style');
        $icon = $meta_style !== 'no_icon' && $meta_style !== 'style_1' ? '<i class="fa fa-user far fa-user"></i>' : '';

        echo '<span class="blfe-post-list-author">'.$icon.''.__('by ', 'bloglentor').'<a href="'.get_author_posts_url(get_the_author_meta( 'ID' )).'">'.get_the_author().'</a></span>';
    }

    protected function render_avatar() {
        $meta_style = $this->get_instance_value('meta_style');

        if( $meta_style !== 'style_1' ){
            return;
        }

        echo get_avatar( get_the_author_meta( 'ID' ), 128, '', get_the_author_meta( 'display_name' ) );
    }

    public function render_date(){
        $icon = $this->get_instance_value('meta_style') !== 'no_icon' ? '<i class="fa fa-calendar-alt far fa-calendar-alt"></i>' : '';

        echo '<span class="blfe-post-list-date">'.$icon.''.apply_filters( 'the_date', get_the_date(), get_option( 'date_format' ), '', '' ).'</span>';
    }

    public function render_time(){
        $icon = $this->get_instance_value('meta_style') !== 'no_icon' ? '<i class="fa fa-clock far fa-clock"></i>' : '';
        echo '<span class="blfe-post-list-time">'.$icon.''.esc_attr(get_the_time()).'</span>';
    }

    public function render_comments(){
        ?>
        <span>
            <?php echo $this->get_instance_value('meta_style') !== 'no_icon' ? '<i class="fa fa-comment-alt far fa-comment-alt"></i>' : ''; ?>
            <?php comments_number(); ?>
		</span>
        <?php
    }

    public function render_category(){
        if( $this->get_instance_value( 'show_category' ) !== 'yes' ){
            return;
        }

        $terms = wp_get_post_terms( get_the_ID(), 'category' );

        if ( empty( $terms ) || is_wp_error( $terms ) ) {
            return;
        }

        $number = $this->get_instance_value( 'max_terms' );

        if ( '' !== $number ) {
            $terms = array_slice( $terms, 0, $number );
        }

        $format = '<a href="%2$s">%1$s</a>';

        $taxonomy = '';

        foreach ( $terms as $term ) {
            $taxonomy .= sprintf( $format, $term->name, get_term_link( (int) $term->term_id ) );
        }

        printf( '<span class="blfe-post-category">%s</span>', wp_kses_post( $taxonomy ) );
    }

    public function render_meta(){
        if( ! $this->get_instance_value( 'meta_data' ) ){
            return;
        }

        ?>
        <div class="blfe-post-list-meta">
            <?php

            if ( in_array( 'author', $this->get_instance_value('meta_data') ) ) {
                $this->render_avatar();
                $this->render_author();
            }


            if ( in_array( 'author', $this->get_instance_value('meta_data') ) && $this->get_instance_value( 'separator_type' ) === 'default' ) {
                ?>
                <div class="blfe-post-meta-dot"></div>
                <?php
            }


            if ( in_array( 'date', $this->get_instance_value('meta_data') ) ) {
                $this->render_date();
            }

            if ( in_array( 'date', $this->get_instance_value('meta_data') ) && $this->get_instance_value( 'separator_type' ) === 'default' ) {
                ?>
                <div class="blfe-post-meta-dot"></div>
                <?php
            }


            if ( in_array( 'time', $this->get_instance_value('meta_data') ) ) {
                $this->render_time();
            }


            if ( in_array( 'time', $this->get_instance_value('meta_data') ) && $this->get_instance_value( 'separator_type' ) === 'default' ) {
                ?>
                <div class="blfe-post-meta-dot"></div>
                <?php
            }

            if ( in_array( 'comments', $this->get_instance_value('meta_data') ) ) {
                $this->render_comments();
            }

            if ( in_array( 'comments', $this->get_instance_value('meta_data') ) && $this->get_instance_value( 'separator_type' ) === 'default' ) {
                ?>
                <div class="blfe-post-meta-dot"></div>
                <?php
            }

            if ( in_array( 'reading_time', $this->get_instance_value('meta_data') ) ) {
                $icon = $this->get_instance_value('meta_style') !== 'no_icon' ? '<i class="fas fa-book-reader"></i>' : '';
                echo '<span class="blfe-post-list-time">'.$icon.''.Helper::reading_time().'</span>';
            }

            ?>
        </div>
        <?php
    }

    protected function get_optional_link_attributes_html() {

        $new_tab_setting_key = $this->get_instance_value( 'open_new_tab' );
        $optional_attributes_html = 'yes' === $new_tab_setting_key ? 'target="_blank"' : '';

        return $optional_attributes_html;
    }


    protected function render_read_more() {
        if ( $this->get_instance_value( 'show_read_more' ) != 'yes' ) {
            return;
        }

        $settings = self::$settings;

        $migration_allowed = Icons_Manager::is_migration_allowed();
        $migrated = $this->get_instance_value( '__fa4_migrated');

        $is_new = empty( $settings['icon'] ) && $migration_allowed;

        $selected_icon = $this->get_instance_value('selected_icon');

        $optional_attributes_html = $this->get_optional_link_attributes_html();

        $this->add_render_attribute( 'content-wrapper'. get_the_ID(), 'class', 'blfe-read-more-btn-wrapper' );
        $this->add_render_attribute( 'text'. get_the_ID(), 'class', 'blfe-read-more-btn-text' );
        $this->add_render_attribute(
            'icon-align'. get_the_ID(),
            'class',
            array(
                'blfe-read-more-btn-icon',
                'blfe-read-more-btn-align-icon-' . $this->get_instance_value('icon_align')
            )
        );

        ?>
        <a class="blfe-post-read-more" href="<?php echo $this->current_permalink; ?>" <?php echo $optional_attributes_html; ?>>
            <span <?php echo wp_kses_post($this->get_render_attribute_string( 'content-wrapper'. get_the_ID() )); ?>>

             <span <?php echo wp_kses_post($this->get_render_attribute_string( 'text'. get_the_ID() )); ?>><?php echo $this->get_instance_value( 'read_more_text' ); ?></span>

                <?php if ( ! empty( $settings['icon'] ) || ! empty( $selected_icon['value'] ) ) : ?>
                    <span <?php echo wp_kses_post($this->get_render_attribute_string( 'icon-align'. get_the_ID() )); ?>>
                <?php if ( $is_new || $migrated ) :
                    Icons_Manager::render_icon( $selected_icon, [ 'aria-hidden' => 'true' ] );
                else : ?>
                    <i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
                <?php endif; ?>
                    </span>
                <?php endif; ?>

            </span>
        </a>
        <?php
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
                <?php $this->render_category(); ?>
                <?php $this->render_title(); ?>
                <?php $this->render_meta(); ?>
                <?php $this->render_excerpt(); ?>
                <?php $this->render_read_more(); ?>
            </div>

        </div>
        <?php
    }

    public function inner_render( $style_id, $widget ) {

        ob_start();

        check_ajax_referer( 'blfe-posts-widget-nonce', 'security' );

        self::$settings  = $widget->get_settings_for_display();

        $filter = ( isset( $_POST['filter'] ) ) ? $_POST['filter'] : '';

        $args = Helper::build_query_args($style_id, self::$settings, $filter);

        self::$query = new \WP_Query($args);
        $query       = self::$query;
        self::$skin  = $style_id;
        $count       = 0;

        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id = get_the_ID();
            $this->thumbnail_id = get_post_thumbnail_id($post_id);
            $this->current_permalink = get_permalink();
            $this->render_post();
            $count++;
        }

        wp_reset_postdata();

        return ob_get_clean();
    }

    /**
     * Get Pagination.
     *
     * Returns the Pagination HTML.
     *
     * @since 1.0.0
     * @access public
     */
    public function render_pagination() {

        if ( 'none' === $this->get_instance_value( 'pagination' ) ) {
            return;
        }

        // Get current page number.
        $paged = Helper::get_paged();


        $query = self::$query;

        $total_pages = $query->max_num_pages;

        // Return pagination html.
        if ( $total_pages > 1 ) {

            $current_page = $paged;

            if ( ! $current_page ) {
                $current_page = 1;
            }

            $pagination = $this->get_instance_value('pagination');

            $links = [];
            if( $pagination === 'numbers_with_prev_next' || $pagination === 'numbers') {
                $links = paginate_links(
                    array(
                        'current' => $current_page,
                        'total' => $total_pages,
                        'prev_next' => $this->get_instance_value('pagination') === 'numbers_with_prev_next' ? true : false,
                        'type' => 'array',
                    )
                );
            }
            ?>

            <?php if( $pagination === 'numbers_with_prev_next' || $pagination === 'numbers' ){ ?>
            <nav class="blfe-grid-pagination" role="navigation" aria-label="<?php esc_attr_e( 'Pagination', 'blfe' ); ?>" data-total="<?php echo esc_attr( $total_pages ); ?>">
                <?php echo wp_kses_post( implode( PHP_EOL, $links ) ); ?>
            </nav>
            <?php } ?>

            <?php do_action('blfe/post_list_load_more_button', $total_pages, $pagination); ?>


            <?php
            $prev_next_position = $this->get_instance_value('prev_next_position');
            if( $prev_next_position === 'bottom' ) {
                do_action('blfe/post_list_next_prev_pagination', $this, $total_pages);
            }
            ?>

            <?php
        }
    }

    public function get_header(){

        $settings = self::$settings;

        $migration_allowed = Icons_Manager::is_migration_allowed();
        $migrated = $this->get_instance_value( '__fa4_migrated');

        $is_new = empty( $settings['header_title_fa4_icon'] ) && $migration_allowed;

        $selected_icon = $this->get_instance_value('header_title_icon');

        $this->add_render_attribute(
            'header-icon-align'. get_the_ID(),
            'class',
            array(
                'blfe-header-title-icon',
                'blfe-header-title-align-icon-' . $this->get_instance_value('header_icon_align')
            )
        );

        echo '<div class="blfe-post-header-title">';

        if ( ! empty( $settings['header_title_fa4_icon'] ) || ! empty( $selected_icon['value'] ) ) : ?>
            <span <?php echo wp_kses_post($this->get_render_attribute_string( 'header-icon-align'. get_the_ID() )); ?>>
                <?php if ( $is_new || $migrated ) :
                    Icons_Manager::render_icon( $selected_icon, [ 'aria-hidden' => 'true' ] );
                else : ?>
                    <i class="<?php echo esc_attr( $settings['header_title_fa4_icon'] ); ?>" aria-hidden="true"></i>
                <?php endif; ?>
                    </span>
        <?php endif;

        $total_pages = self::$query->max_num_pages;

        $display_header_title = $this->get_instance_value( 'display_header_title' );
        if( $display_header_title === 'yes' ) {
            $tag = $this->get_instance_value('header_title_tag');

            $title = $this->get_instance_value('header_title');

            $url = $this->get_instance_value('header_title_url');

            $this->add_render_attribute('title', 'class', 'blfe-post-header-title-inner');

            if (!empty($url)) {

                $this->add_link_attributes('url', $url);

                $title = sprintf('<a %1$s>%2$s</a>', $this->get_render_attribute_string('url'), $title);
            }

            $title_html = sprintf('<%1$s %2$s>%3$s</%1$s>', $tag, $this->get_render_attribute_string('title'), $title);

            echo $title_html;
        }

        echo '</div>';

        do_action('blfe/post_header_filter_menu', $this);

        $prev_next_position = $this->get_instance_value('prev_next_position');

        if( $prev_next_position === 'top_right' ){
            do_action('blfe/post_list_header_next_prev_pagination',  $this, $total_pages);
        }
    }

    public function get_footer(){
        $this->render_pagination();
    }

    public function get_body(){

        $skin = self::$skin;
        $settings = self::$settings;
        $count               = 0;

        apply_filters('blfe/post_list_body_data_attr', $this);

        $this->add_render_attribute( 'inner_wrapper', 'data-skin', $skin );
        $pagination = $this->get_instance_value('pagination');
        $display_filter = $this->get_instance_value('display_filter');
        $navigation_display_style = $this->get_instance_value('navigation_display_style');

        $this->add_render_attribute(
            'wrapper',
            'class',
            array(
                'blfe-post-list-container',
                $pagination !== 'none' || $display_filter === 'yes' ? 'blfe-active-post-loader' : '',
            )
        );

        $this->add_render_attribute(
            'inner_wrapper',
            'class',
            array(
                'blfe-' . $skin,
                'blfe-row',
                'blfe-posts-inner',
                $settings['layout_type' ] !== 'carousel' ? 'blfe-col-' .$settings['columns'] : '',
                $settings['layout_type' ] !== 'carousel' ? 'blfe-col-tab-' .$settings['columns_tablet'] : '',
                $settings['layout_type' ] !== 'carousel' ? 'blfe-col-mob-' .$settings['columns_mobile'] : '',
                $settings['layout_type' ] === 'carousel' ? 'blfe-'.$settings['layout_type' ] : '',
                $pagination === 'infinite' ? 'blfe-post-list-infinite-scroll' : '',
                $settings['layout_type' ] === 'carousel' && $navigation_display_style === 'hover' ? 'blfe-arrows-display-hover' : '',
            )
        );

        $args = Helper::build_query_args($skin, $settings, '');
        self::$query = new \WP_Query($args);
        $query       = self::$query;
        if( $query->have_posts() ){
            ?>

            <div <?php echo wp_kses_post( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
                <div <?php echo wp_kses_post( $this->get_render_attribute_string( 'inner_wrapper' ) ); ?>>
                    <?php

                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $post_id = get_the_ID();
                        $this->thumbnail_id = get_post_thumbnail_id($post_id);
                        $this->current_permalink = get_permalink();
                        $this->render_post();
                        $count++;
                    }
                    wp_reset_postdata();

                    ?>
                </div>
            </div>

            <?php
        }


    }

    public function render( $style, $settings, $node_id) {

        self::$settings  = $settings;
        self::$skin      = $style;
        self::$node_id   = $node_id;

        $args = Helper::build_query_args($style, $settings, '');
        self::$query = new \WP_Query($args);
        $query       = self::$query->get_query();

        $display_header_title = $this->get_instance_value( 'display_header_title' );
        $display_filter = $this->get_instance_value( 'display_filter' );
        $prev_next_position = $this->get_instance_value('prev_next_position');

        $header_style = $this->get_instance_value('header_style');
        $this->add_render_attribute(
            'header_wrapper',
            'class',
            array(
                'blfe-post-header',
                 $display_filter !== 'yes' ? 'blfe-post-header-has-no-filter' : '',
                'blfe-post-header-'.$header_style
            )
        );

        if( $display_header_title === 'yes' || $display_filter === 'yes' || $prev_next_position === 'top_right') {
            ?>

            <div <?php echo wp_kses_post($this->get_render_attribute_string('header_wrapper')); ?>>
                <?php $this->get_header(); ?>
            </div>

            <?php
        }
        $this->get_body();

        if ( $settings['layout_type'] !== 'carousel' ) {
            ?>
            <div class="blfe-post-footer">
                <?php $this->get_footer(); ?>
            </div>
            <?php
        }

    }

    public function page_render( $style_id, $widget ) {

        ob_start();
        check_ajax_referer( 'blfe-posts-widget-nonce', 'security' );
        self::$settings  = $widget->get_settings_for_display();
        $filter = ( isset( $_POST['filter'] ) ) ? $_POST['filter'] : '';

        $args = Helper::build_query_args($style_id, self::$settings, $filter);

        self::$query = new \WP_Query($args);
        self::$skin  = $style_id;

        $this->render_pagination();


        return ob_get_clean();

    }

}
