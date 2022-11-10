<?php
/**
 * Plugin Name: BlogLentor for Elementor
 * Plugin URI: https://wordpress.org/plugins/bloglentor-for-elementor
 * Description: Showcase your WordPress posts from any post type in beautiful way with Elementor page builder
 * Author: wpsurface
 * Author URI: https://wpsurface.com/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Version: 1.0.8
 * Text Domain: bloglentor
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

define('BLFE', '1.0.8');
define('BLFE_DIR_PATH', plugin_dir_path(__FILE__));
define('BLFE_DIR_URL', plugin_dir_url(__FILE__));

function bloglentor_load_plugin() {
    require BLFE_DIR_PATH . 'plugin.php';
    require BLFE_DIR_PATH . 'classes/class-helper.php';
}

add_action( 'plugins_loaded', 'bloglentor_load_plugin' );





