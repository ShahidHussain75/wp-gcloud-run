<?php
namespace BlogLentor;

if ( ! defined( 'ABSPATH' ) ) {	exit; } // Exit if accessed directly

/**
 * Main class plugin
 */
class Plugin {

    const MINIMUM_ELEMENTOR_VERSION = '2.5.0';
    const MINIMUM_PHP_VERSION = '5.4';
    /**
     * @var Plugin
     */
    private static $_instance;

    /**
     * @var Manager
     */
    private $_modules_manager;

    /**
     * @return string
     */
    public function get_version() {
        return BLFE;
    }

    /**
     * Throw error on object clone
     *
     * The whole idea of the singleton design pattern is that there is a single
     * object therefore, we don't want the object to be cloned.
     *
     * @since 1.0.0
     * @return void
     */
    public function __clone() {
        // Cloning instances of the class is forbidden
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'bloglentor' ), BLFE );
    }

    /**
     * Disable unserializing of the class
     *
     * @since 1.0.0
     * @return void
     */
    public function __wakeup() {
        // Unserializing instances of the class is forbidden
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'bloglentor' ), BLFE );
    }

    /**
     * @return Plugin
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function _includes() {
        require BLFE_DIR_PATH . 'includes/modules-manager.php';
    }

    public function autoload( $class ) {
        if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
            return;
        }

        $filename = strtolower(
            preg_replace(
                [ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
                [ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
                $class
            )
        );
        $filename = BLFE_DIR_PATH . $filename . '.php';

        if ( is_readable( $filename ) ) {
            include( $filename );
        }
    }

    /**
     * Enqueue frontend styles
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function enqueue_frontend_styles() {

        wp_enqueue_style(
            'slick',
            BLFE_DIR_URL . 'assets/lib/slick/slick.css',
            null,
            BLFE
        );

        wp_enqueue_style(
            'slick-theme',
            BLFE_DIR_URL . 'assets/lib/slick/slick-theme.css',
            null,
            BLFE
        );

        wp_enqueue_style(
            'bloglentor-main',
            BLFE_DIR_URL . 'assets/css/main.css',
            null,
            BLFE
        );

    }

    /**
     * Enqueue frontend scripts
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function enqueue_frontend_scripts() {
        wp_register_script(
            'slick',
            BLFE_DIR_URL . 'assets/lib/slick/slick.min.js',
            [ 'jquery' ],
            BLFE,
            true
        );
        wp_register_script(
            'bloglentor-frontend',
            BLFE_DIR_URL . 'assets/js/frontend.js',
            [
                'jquery',
            ],
            BLFE,
            true
        );

    }

    /**
     * Enqueue editor styles
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function enqueue_editor_styles() {
        wp_enqueue_style(
            'bloglentor-editor',
            BLFE_DIR_URL . 'assets/css/editor.css',
            [],
            BLFE
        );
    }

    /**
     * [i18n] Load Text Domain
     * @return [void]
     */
    public function i18n() {
        load_plugin_textdomain( 'bloglentor', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    public function is_plugins_active( $plugin_file_path = NULL ){
        $installed_plugins_list = get_plugins();
        return isset( $installed_plugins_list[$plugin_file_path] );
    }

    public function admin_notice_missing_elementor_plugin() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $elementor = 'elementor/elementor.php';
        if( $this->is_plugins_active( $elementor ) ) {
            if( ! current_user_can( 'activate_plugins' ) ) { return; }

            $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $elementor . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $elementor );

            $message = '<p>' . __( 'BlogLentor for Elementor not working because you need to activate the Elementor plugin.', 'bloglentor' ) . '</p>';
            $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, __( 'Elementor Activate Now', 'bloglentor' ) ) . '</p>';
        } else {
            if ( ! current_user_can( 'install_plugins' ) ) { return; }

            $install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );

            $message = '<p>' . __( 'BlogLentor for Elementor not working because you need to install the Elementor plugin', 'bloglentor' ) . '</p>';

            $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, __( 'Elementor Install Now', 'bloglentor' ) ) . '</p>';
        }
        echo '<div class="error"><p>' . $message . '</p></div>';

    }

    public function admin_notice_minimum_elementor_version(){
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            __( '"%1$s" requires "%2$s" version %3$s or greater.', 'bloglentor' ),
            '<strong>' . __( 'BlogLentor for Elementor', 'bloglentor' ) . '</strong>',
            '<strong>' . __( 'Elementor', 'bloglentor' ) . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function admin_notice_minimum_php_version() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            __( '"%1$s" requires "%2$s" version %3$s or greater.', 'bloglentor' ),
            '<strong>' . __( 'BlogLentor for Elementor', 'bloglentor' ) . '</strong>',
            '<strong>' . __( 'PHP', 'bloglentor' ) . '</strong>',
            self::MINIMUM_PHP_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function elementor_init() {

        $this->_modules_manager = new Modules_Manager();

        // Add element category in panel
        \Elementor\Plugin::instance()->elements_manager->add_category(
            'bloglentor', // This is the name of your addon's category and will be used to group your widgets/elements in the Edit sidebar pane!
            [
                'title' => __( 'BlogLentor', 'bloglentor' ), // The title of your modules category - keep it simple and short!
                'icon' => 'font',
            ],
            1
        );
    }

    public function post_views_tracker(){
        if  (!is_single() ){
            return;
        }

        global $post;

        if ( empty($post_id) ) {
            $post_id = $post->ID;
        }

        $views = (int)get_post_meta( $post_id, '_blfe_post_views', true );
        update_post_meta($post_id, '_blfe_post_views', $views ? (int)$views + 1 : 1 );

    }

    protected function add_actions() {
        add_action( 'elementor/init', [ $this, 'elementor_init' ] );
        add_action( 'init', array( $this, 'i18n') );

        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor_plugin' ] );
            return;
        }

        // Check required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return;
        }

        // Check required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );

        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'enqueue_frontend_scripts' ] );
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_frontend_styles' ] );

        add_action( 'wp_head', [ $this, 'post_views_tracker'] );
    }

    /**
     * Plugin constructor.
     */
    private function __construct() {
        spl_autoload_register( [ $this, 'autoload' ] );


        $this->_includes();
        $this->add_actions();
    }

}

if ( ! defined( 'BLOGLENTOR_TESTS' ) ) {
    // In tests we run the instance manually.
    Plugin::instance();
}
