<?php
namespace BlogLentor\Base;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Base Widget
 *
 * @since 1.0.0
 */
abstract class Base_Widget extends Widget_Base {

    /**
     * Get categories
     *
     * @since 1.0.0
     */
    public function get_categories() {
        return [ 'bloglentor-elements' ];
    }
}
