<?php
define('ALETHO_THEME_DIR_URI', get_template_directory_uri());
define('ALETHO_THEME_DIR', get_template_directory());

class Aletho_Theme
{

    private static $instance = null;

    private function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
        add_action('init', [$this, 'register_aletho_menus']);
        add_action('init', [$this, 'myblocks_myheader_block_init']);
        add_action('after_setup_thene', [$this, 'wp_add_block_template_part_support']);
    }

    public function enqueue_styles()
    {
        wp_enqueue_style('aletho-theme', get_stylesheet_uri());
        wp_enqueue_style('tailwindcss', ALETHO_THEME_DIR_URI . '/src/output.css');
    }

    public function wp_add_block_template_part_support()
    {
        add_theme_support('block-template-parts');
    }

    public function myblocks_myheader_block_init()
    {
        if (function_exists('wp_register_block_types_from_metadata_collection')) {
            wp_register_block_types_from_metadata_collection(__DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php');
            return;
        }

        if (function_exists('wp_register_block_metadata_collection')) {
            wp_register_block_metadata_collection(__DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php');
        }
        $manifest_data = require __DIR__ . '/build/blocks-manifest.php';
        foreach (array_keys($manifest_data) as $block_type) {
            register_block_type(__DIR__ . "/build/{$block_type}");
        }
    }

    public function register_aletho_menus()
    {
        register_nav_menus(
            array(
                'header-menu' => __('Header Menu'),
                'footer-menu' => __('Footer Menu')
            )
        );
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
