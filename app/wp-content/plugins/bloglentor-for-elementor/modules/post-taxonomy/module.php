<?php
namespace BlogLentor\Modules\PostTaxonomy;
use BlogLentor\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

    /**
     * Constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    public function get_name() {
        return 'blfe-post-taxonomy';
    }

    public function get_widgets() {
        return [
            'Post_Taxonomy',
        ];
    }

}
