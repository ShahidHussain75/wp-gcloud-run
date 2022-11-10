<?php
namespace BlogLentor\Modules\PostGrid\TemplateBlocks;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Skin_Init
 */
class Skin_Init {

    /**
     * Member Variable
     *
     * @var instance
     */
    private static $skin_instance;

    /**
     * Initiator
     *
     * @param string $style Skin.
     */
    public static function get_instance( $style ) {

        $pro_style = array(
            'news1',
            'news2',
            'news3',
            'news4',
            'news5',
            'hero5',
            'hero6',
            'hero7',
            'hero8',
            'hero9',
            'hero10'
        );

        if( in_array($style, $pro_style) ){
            $skin_class = 'BlogLentorPro\\Modules\\PostGrid\\TemplateBlocks\\Skin_' . ucfirst( $style );
        } else {
            $skin_class = 'BlogLentor\\Modules\\PostGrid\\TemplateBlocks\\Skin_' . ucfirst( $style );
        }


        if ( class_exists( $skin_class ) ) {

            self::$skin_instance[ $style ] = new $skin_class( $style );
        }

        return self::$skin_instance[ $style ];
    }
}
