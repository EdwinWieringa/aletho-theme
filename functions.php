<?php
// define('ALETHO_THEME_DIR_URI', get_template_directory_uri());
// define('ALETHO_THEME_DIR', get_template_directory());

class Aletho_Theme
{
    private static $instance = null;

    private function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_aletho_custom_styles']);
    }

    public function enqueue_aletho_custom_styles()
    {        
        wp_enqueue_style('aletho-theme-style', get_stylesheet_uri());
    }

    public static function get_instance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}

Aletho_Theme::get_instance();
