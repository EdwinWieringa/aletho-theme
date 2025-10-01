<?php
define('ALETHO_THEME_DIR_URI', get_template_directory_uri());
define('ALETHO_THEME_DIR', get_template_directory());

class Aletho_Theme
{
    private static $instance = null;

    private function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_aletho_custom_styles']);
        add_action('wp_enqueue_scripts', [$this, 'theme_load_dashicons']);
        add_action('enqueue_block_editor_assets', [$this, 'theme_callback_function']);
        add_action('enqueue_block_assets', [$this, 'theme_js_frontend_backend_enqueue']);
        add_action('admin_menu', [$this, 'theme_admin_menu_addons']);

        //add_action('init', [$this, 'theme_block_assets_styles']);
        add_action('init', [$this, 'aletho_register_button_styles']);
        add_action('enqueue_block_assets', [$this, 'aletho_enqueue_block_styles']);
        add_action('wp_enqueue_scripts', [$this, 'aletho_enqueue_hover_script']);
    }

    public static function enqueue_aletho_custom_styles()
    {
        wp_enqueue_style('aletho-theme-style', get_stylesheet_uri());
    }

    public static function theme_block_assets_styles()
    {
        wp_enqueue_style('aletho-theme-style', get_stylesheet_uri());
    }

    public static function theme_load_dashicons()
    {
        wp_enqueue_style('dashicons');
    }

    public static function theme_callback_function()
    {
        wp_enqueue_script(
            'theme-callback-block-variation',
            ALETHO_THEME_DIR_URI . '/assets/js/block-variations.js',
            array('wp-blocks', 'wp-dom-ready'),
            wp_get_theme()->get('Version')
        );
    }

    public static function theme_js_frontend_backend_enqueue()
    {
        wp_enqueue_script(
            'group-navigation-script',
            ALETHO_THEME_DIR_URI . '/assets/js/group-navigation-script.js',
            array('wp-blocks', 'wp-element', 'wp-editor'),
            filemtime(ALETHO_THEME_DIR . '/assets/js/group-navigation-script.js'),
            true
        );
    }

    function aletho_enqueue_hover_script()
    {
        wp_enqueue_script(
            'aletho-button-hover',
            get_template_directory_uri() . '/assets/js/button-animation.js',
            array(),
            filemtime(get_template_directory() . '/assets/js/button-animation.js'),
            true
        );
    }

    function aletho_enqueue_block_styles()
    {
        wp_enqueue_style(
            'aletho-block-styles',
            get_template_directory_uri() . '/assets/css/button-styles.css',
            array(),
            filemtime(get_template_directory() . '/assets/css/button-styles.css')
        );
    }

    function aletho_register_button_styles()
    {
        register_block_style(
            'core/button',
            array(
                'name' => 'light-blue',
                'label' => __('Light Blue Button', 'aletho'),
                'style_handle' => 'aletho-block-styles'
            )
        );

        register_block_style(
            'core/button',
            array(
                'name' => 'orange',
                'label' => __('Orange Button', 'aletho'),
                'style_handle' => 'aletho-block-styles'
            )
        );

        register_block_style(
            'core/button',
            array(
                'name' => 'blue',
                'label' => __('Blue Button', 'aletho'),
                'style_handle' => 'aletho-block-styles'
            )
        );
    }

    public static function theme_admin_menu_addons()
    {
        add_menu_page(
            __('Aletho Theme Documentation'),
            __('Theme Documentation'),
            'manage_options',
            'theme-documentation',
            'theme_documentation_page',
            'dashicons-book',
            10
        );
    }

    public function theme_documentation_page()
    {
        esc_html_e('Welcome to my custom admin page.');
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
