<?php
namespace BlogLentor\Modules\NewsTicker\Skins;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Classic1 extends Skin_Base {

    protected function _register_controls_actions() {
        parent::_register_controls_actions();
    }

    public function register_sections( Widget_Base $widget ) {

        $this->parent = $widget;

        // Content Controls.
        $this->register_animation_controls();
        $this->register_design_ticker_controls();
        $this->register_design_ticker_title_controls();
        $this->register_design_ticker_content_controls();
        $this->register_design_ticker_arrows_controls();

    }

    public function get_id() {
        return 'classic1';
    }

    public function get_title() {
        return __( 'Classic 1', 'bloglentor' );
    }

    public function register_controls( Widget_Base $widget ) {
        $this->parent = $widget;
        $this->register_post_query_controls();
    }

    protected function render_post() {
        ?>
        <div class="blfe-ticker-item">
            <div class="blfe-ticker-item-content">
                <?php
                $this->render_title();
                $this->render_date();
                ?>
            </div>
        </div>
        <?php
    }
}

