<?php
define('ALETHO_THEME_DIR_URI', get_template_directory_uri());
define('ALETHO_THEME_DIR', get_template_directory());

class Aletho_Theme
{
    private static $instance = null;

    private function __construct()
    {
        include_once ALETHO_THEME_DIR . '/includes/portfolio.php';

        add_action('wp_enqueue_scripts', [$this, 'enqueue_theme_styles']);
        add_action('admin_menu', [$this, 'aletho_admin_menu_addons']);

        add_action('init', [$this, 'aletho_register_button_styles']);
        add_action('init', [$this, 'aletho_register_list_styles']);

        add_action('enqueue_block_assets', [$this, 'aletho_enqueue_block_styles']);
        add_action('wp_enqueue_scripts', [$this, 'aletho_enqueue_hover_script']);

        // Sticky header assets
        add_action('enqueue_block_editor_assets', [$this, 'aletho_block_editor_assets']);
        add_action('enqueue_block_assets', [$this, 'aletho_js_frontend_backend_enqueue']);

        add_action('init', [$this, 'aletho_register_blocks']);
        add_action('init', [$this, 'aletho_register_pattern_categories']);


        add_action('admin_menu', [$this, 'add_admin_page']);
        add_action('admin_init', [$this, 'register_settings']);
        add_filter('wp_robots', [$this, 'set_robots']);
    }

    public static function enqueue_theme_styles()
    {
        // Enqueue main theme stylesheet
        wp_enqueue_style('aletho-theme-style', get_stylesheet_uri());

        $deps = [];
        if (wp_style_is('wpforms-modern-full', 'registered')) {
            $deps[] = 'wpforms-modern-full';
        }

        wp_enqueue_style(
            'aletho-wpforms',
            get_template_directory_uri() . '/assets/css/wpforms.css',
            $deps,
            filemtime(get_template_directory() . '/assets/css/wpforms.css')
        );

        wp_enqueue_style(
            'aletho-wpconsent',
            get_template_directory_uri() . '/assets/css/wpconsent.css',
            null,
            filemtime(get_template_directory() . '/assets/css/wpconsent.css')
        );

        // Enqueue Dashicons for frontend use
        wp_enqueue_style('dashicons');
    }

    public function aletho_enqueue_hover_script()
    {
        wp_enqueue_script(
            'aletho-button-hover',
            get_template_directory_uri() . '/assets/js/button-animation.js',
            array(),
            filemtime(get_template_directory() . '/assets/js/button-animation.js'),
            true
        );
    }

    public static function aletho_enqueue_block_styles()
    {
        wp_enqueue_style(
            'aletho-block-styles',
            get_template_directory_uri() . '/assets/css/button-styles.css',
            array(),
            filemtime(get_template_directory() . '/assets/css/button-styles.css')
        );

        wp_enqueue_style(
            'aletho-list-styles',
            get_template_directory_uri() . '/assets/css/list-styles.css',
            [],
            filemtime(get_template_directory() . '/assets/css/list-styles.css')
        );
    }

    // Register custom styles for core/button block: Light Blue, Orange, and Blue.
    // Styles use 'aletho-block-styles' handle and must be hooked into 'init'.
    public function aletho_register_button_styles()
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

    public function aletho_register_list_styles()
    {
        register_block_style('core/list', [
            'name'  => 'checkmarks',
            'label' => 'Checkmarks',
            'style_handle' => 'aletho-list-styles'
        ]);

        register_block_style('core/list', [
            'name'  => 'arrows',
            'label' => 'Arrows',
            'style_handle' => 'aletho-list-styles'
        ]);
    }

    public function aletho_admin_menu_addons()
    {
        add_menu_page(
            __('Aletho Theme Documentation'),
            __('Theme Documentation'),
            'manage_options',
            'theme-documentation',
            [$this, 'theme_documentation_page'],
            'dashicons-book',
            10
        );
    }

    public function theme_documentation_page()
    {
        esc_html_e('Welcome to my custom admin page.');
    }

    public static function aletho_block_editor_assets()
    {
        wp_enqueue_script(
            'aletho-block-style-icons',
            get_template_directory_uri() . '/assets/js/block-styles.js',
            array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'),
            filemtime(get_template_directory() . '/assets/js/block-styles.js'),
            true
        );
    }

    public static function aletho_js_frontend_backend_enqueue()
    {
        wp_enqueue_script(
            'group-navigation-script',
            ALETHO_THEME_DIR_URI . '/assets/js/group-navigation-script.js',
            array('wp-dom-ready'),
            filemtime(ALETHO_THEME_DIR . '/assets/js/group-navigation-script.js'),
            true
        );
    }

    // Register dynamic blocks used by the theme
    public function aletho_register_blocks()
    {
        register_block_type(
            get_template_directory() . '/blocks/portfolio-breadcrumbs'
        );
    }

    // Register pattern categories
    public function aletho_register_pattern_categories()
    {
        register_block_pattern_category(
            'aletho',
            [
                'label' => __('Alétho 💎', 'aletho'),
            ]
        );
    }

    // Applies noindex and nofollow directives to the intranet page.
    public function set_robots(array $robots): array
    {
        $slugs = get_option('aletho_noindex_pages', []);

        if (is_page($slugs)) {
            $robots['noindex']  = true;
            $robots['nofollow'] = true;
        }

        return $robots;
    }

    // Adds the admin page for managing pages hidden from search engines.
    public function add_admin_page(): void
    {
        add_theme_page(
            __('Verborgen pagina\'s', 'aletho'),
            __('Verborgen pagina\'s', 'aletho'),
            'manage_options',
            'robots-settings',
            [$this, 'render_options_page']
        );
    }

    // Renders the admin form for configuring pages excluded from search engines.
    public function render_options_page(): void
    {
        $slugs = (array) get_option('aletho_noindex_pages', []);
?>
        <div class="wrap">
            <h1><?php esc_html_e('Verborgen pagina\'s', 'aletho'); ?></h1>
            <?php settings_errors(); ?>
            <form method="post" action="options.php">
                <?php settings_fields('aletho'); ?>

                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="aletho_noindex_pages">
                                <?php esc_html_e('Pagina slugs', 'aletho'); ?>
                            </label>
                        </th>
                        <td>
                            <textarea
                                id="aletho_noindex_pages"
                                name="aletho_noindex_pages"
                                rows="6"
                                style="max-width: 350px; width: 100%; background-image: linear-gradient(#F1F1F1 50%, #F9F9F9 50%);
                                    background-size: 100% 4rem; line-height: 2rem; margin: 0 auto; padding: 4px 8px;"><?php echo esc_textarea(implode("\n", $slugs)); ?></textarea>

                            <p class="description">
                                <?php esc_html_e('Voer één slug per regel in.', 'aletho'); ?>
                            </p>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>
        </div>
<?php
    }
    
    // Registers the settings used to configure pages hidden from search engines.
    public function register_settings(): void
    {
        register_setting(
            'aletho',
            'aletho_noindex_pages',
            [
                'sanitize_callback' => [$this, 'sanitize_noindex_pages'],
                'default'           => [],
            ]
        );
    }

    // Sanitizes the configured page slugs.
    public function sanitize_noindex_pages(mixed $input): array
    {
        $slugs = is_array($input)
            ? $input
            : preg_split('/\r\n|\r|\n/', $input);

        return array_filter(
            array_map('sanitize_title', $slugs)
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
add_action('after_setup_theme', function () {
    Aletho_Theme::get_instance();
});
