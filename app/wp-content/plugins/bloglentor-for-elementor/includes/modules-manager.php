<?php
namespace BlogLentor;

use BlogLentor\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Modules_Manager {
    /**
     * @var Module_Base[]
     */
    private $modules = [];

    public function register_modules() {
        $modules = [
            'post-grid',
            'post-list',
            'news-ticker',
            'post-taxonomy'
        ];

        foreach ( $modules as $module_name ) {

            $class_name = str_replace( '-', ' ', $module_name );

            $class_name = str_replace( ' ', '', ucwords( $class_name ) );

            $class_name = __NAMESPACE__ . '\\Modules\\' . $class_name . '\Module';

            /** @var Module_Base $class_name */
            if ( $class_name::is_active() ) {
                $this->modules[ $module_name ] = $class_name::instance();
            }
        }
    }

    /**
     * @param string $module_name
     *
     * @return Module_Base|Module_Base[]
     */
    public function get_modules( $module_name ) {
        if ( $module_name ) {
            if ( isset( $this->modules[ $module_name ] ) ) {
                return $this->modules[ $module_name ];
            }

            return null;
        }

        return $this->modules;
    }

    private function require_files() {
        require( BLFE_DIR_PATH . 'base/module-base.php' );
    }


    public function __construct() {
        $this->require_files();
        $this->register_modules();
    }
}