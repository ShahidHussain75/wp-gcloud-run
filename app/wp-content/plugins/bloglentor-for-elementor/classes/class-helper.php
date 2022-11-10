<?php
namespace BlogLentor\Classes;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Helper {

	public static function get_post_types(){
        $post_types = get_post_types(
            ['public' => true, 'show_in_nav_menus' => true],
            'objects'
        );

        $post_types = wp_list_pluck($post_types, 'label', 'name');

        return array_diff_key($post_types, ['elementor_library', 'attachment']);
	}

    public static function get_paged() {

        global $wp_the_query, $paged;

        if ( isset( $_POST['security'] ) && wp_verify_nonce( $_POST['security'], 'blfe-posts-widget-nonce' ) ) {

            if (isset($_POST['page_number']) && '' !== $_POST['page_number']) {
                return $_POST['page_number'];
            }
        }

        // Check the 'paged' query var.
        $paged_qv = $wp_the_query->get( 'paged' );

        if ( is_numeric( $paged_qv ) ) {
            return $paged_qv;
        }

        // Check the 'page' query var.
        $page_qv = $wp_the_query->get( 'page' );

        if ( is_numeric( $page_qv ) ) {
            return $page_qv;
        }

        // Check the $paged global?
        if ( is_numeric( $paged ) ) {
            return $paged;
        }

        return 0;
    }

	public static function build_query_args($skin_id, $settings = [], $filter = ''){

        if ( '' !== $skin_id ) {
            $skin_id = $skin_id . '_';
        }

        if ( isset($settings[ $skin_id . 'pagination' ]) && 'none' !== $settings[ $skin_id . 'pagination' ] ) {
            $paged = self::get_paged();
        } else {
            $paged = 1;
        }

        $tax_count = 0;

		$query_args = array(
			'posts_per_page' => ( '' === $settings[''.$skin_id.'posts_per_page']) ? -1 : $settings[''.$skin_id.'posts_per_page'],
			'post_status' => 'publish',
			'ignore_sticky_posts' => isset($settings[''.$skin_id.'ignore_sticky_posts']) && 'yes' === $settings[''.$skin_id.'ignore_sticky_posts'] ? 1 : 0,
			'orderby' => $settings[''.$skin_id.'orderby'],
			'order' => $settings[''.$skin_id.'order'],
			'paged' => $paged,
            'suppress_filters' => false,
		);


        if ( $settings[''.$skin_id.'orderby'] === 'popular' ) {
            $query_args['meta_key'] = '_blfe_post_views';
            $query_args['orderby'] = 'meta_value_num';
            $query_args['order'] = 'DESC';
        }

        if ( 0 < $settings[''.$skin_id.'offset'] ) {

            /**
             * Offser break the pagination. Using WordPress's work around
             *
             * @see https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
             */
            $query_args['offset'] = $settings[''.$skin_id.'offset'];
        }


        if ('by_id' === $settings[''.$skin_id.'post_type']) {
            $query_args['post_type'] = 'any';
        } else {
			if (!empty($settings[''.$skin_id.'post_type'])) {
				$query_args['post_type'] = $settings[''.$skin_id.'post_type'];
			}

            if ($query_args['post_type'] !== 'page') {
                $query_args['tax_query'] = [];

                $taxonomies = get_object_taxonomies($settings[''.$skin_id.'post_type'], 'objects');
                $tax_count = 0;
                foreach ($taxonomies as $object) {
                    $setting_key = $object->name . '_ids';

                    if (!empty($settings[$skin_id.$setting_key])) {
                        $query_args['tax_query'][] = [
                            'taxonomy' => $object->name,
                            'field' => 'term_id',
                            'terms' => $settings[$skin_id.$setting_key],
                        ];
                        $tax_count++;
                    }
                }

                if (!empty($query_args['tax_query'])) {
                    $query_args['tax_query']['relation'] = 'AND';
                }
            }
		}


        if ( '' !== $filter && '*' !== $filter ) {
            $taxonomy = ( isset( $_POST['taxonomy'] ) ) ? $_POST['taxonomy'] : '';
            $query_args['tax_query'][$tax_count]['taxonomy'] = $taxonomy;
            $query_args['tax_query'][$tax_count]['field']    = 'slug';
            $query_args['tax_query'][$tax_count]['terms']    = $filter;
            $query_args['tax_query'][$tax_count]['operator'] = 'IN';
        }

        $query_args = apply_filters( 'blfe/post_query_args', $query_args, $settings, $skin_id );

        return $query_args;
	}




	public static function custom_excerpt( $limit = 70, $indicator = '...' ) {
        return strip_shortcodes(wp_trim_words(get_the_content(), $limit, $indicator));
    }

    public static function reading_time(){

        $word_count = str_word_count( strip_tags( get_the_content() ) );

        $readingtime = ceil($word_count / 200);

        return $readingtime . __(' Min read', 'bloglentor');
    }


}
