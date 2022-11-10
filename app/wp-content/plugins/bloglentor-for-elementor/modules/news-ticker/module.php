<?php
namespace BlogLentor\Modules\NewsTicker;
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
        return 'blfe-news-ticker';
    }

    public function get_widgets() {
        return [
            'News_Ticker',
        ];
    }

}
