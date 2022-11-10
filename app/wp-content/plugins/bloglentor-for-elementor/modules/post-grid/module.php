<?php
namespace BlogLentor\Modules\PostGrid;
use BlogLentor\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'blfe-post-grid';
    }

    public function get_widgets() {
        return [
            'Post_Grid',
        ];
    }

    /**
     * Constructor.
     */
    public function __construct() {
        parent::__construct();
    }

}
