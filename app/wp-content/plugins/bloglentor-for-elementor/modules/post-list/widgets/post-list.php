<?php
namespace BlogLentor\Modules\PostList\Widgets;
use BlogLentor\Modules\PostList\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Blog Grid
 *
 * Elementor widget for blog grid
 *
 * @since 1.0.0
 */
class Post_List extends Posts_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'blfe-post-list';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Post List', 'bloglentor' );
	}

    public function get_keywords() {

        return [ 'posts', 'grid', 'post list', 'posts grid', 'cpt', 'blog post', 'bloglentor', 'query', 'blog grid', 'custom post type', 'mesonry' ];
    }


	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'bloglentor' ];
	}

    protected function register_skins() {

         $this->add_skin( new Skins\Skin_Classic1( $this ) );
         $this->add_skin( new Skins\Skin_Classic2( $this ) );

    }
	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function register_controls() {
        parent::register_controls();
	}

}
