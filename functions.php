<?php
define('ALETHO_THEME_DIR_URI', get_template_directory_uri());
define('ALETHO_THEME_DIR', get_template_directory());

class Aletho_Theme
{
    private static $instance = null;

    private function __construct()
    {
        include_once get_template_directory() . '/includes/portfolio.php';

        add_action('wp_enqueue_scripts', [$this, 'enqueue_theme_styles']);
        add_action('admin_menu', [$this, 'aletho_admin_menu_addons']);

        add_action('init', [$this, 'aletho_register_button_styles']);
        add_action('init', [$this, 'aletho_register_list_styles']);

        add_action('enqueue_block_assets', [$this, 'aletho_enqueue_block_styles']);
        add_action('wp_enqueue_scripts', [$this, 'aletho_enqueue_hover_script']);

        add_action('projects_category_add_form_fields', [$this, 'aletho_taxonomy_add_term_fields']);
        add_action('projects_category_edit_form_fields', [$this, 'aletho_taxonomy_edit_term_fields']);
        add_action('created_projects_category', [$this, 'aletho_taxonomy_save_term_fields']);
        add_action('edited_projects_category', [$this, 'aletho_taxonomy_save_term_fields']);
        add_action('admin_footer', [$this, 'aletho_taxonomy_term_image_js']);
        add_action('admin_enqueue_scripts', [$this, 'aletho_taxonomy_enqueue_media']);


        // Sticky header assets
        add_action('enqueue_block_editor_assets', [$this, 'aletho_block_editor_assets']);
        add_action('enqueue_block_assets', [$this, 'aletho_js_frontend_backend_enqueue']);

        add_filter('pre_render_block', function ($content, $block) {

            if (
                $block['blockName'] === 'core/query' &&
                !empty($block['attrs']['myFilter']) &&
                $block['attrs']['myFilter'] === 'projects-game-dev'
            ) {

                $block['attrs']['query']['taxQuery'] = [
                    [
                        'taxonomy' => 'projects_category',
                        'field'    => 'slug',
                        'terms'    => ['game-development'],
                    ]
                ];
            }
            error_log(print_r($block, true));

            return $content;
        }, 10, 2);
    }

    public static function enqueue_theme_styles()
    {
        // Enqueue main theme stylesheet
        wp_enqueue_style('aletho-theme-style', get_stylesheet_uri());

        // Enqueue Dashicons for frontend use
        wp_enqueue_style('dashicons');
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

    function aletho_register_list_styles()
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

    public static function aletho_admin_menu_addons()
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

    // Add image field to Add New Term screen
    public static function aletho_taxonomy_add_term_fields()
    {
?>
        <div class="form-field term-image-wrap">
            <label for="term_image">Image</label>
            <input type="hidden" name="term_image" id="term_image" value="" />
            <div id="term-image-preview" style="margin-bottom:10px;"></div>
            <button type="button" class="button" id="term-image-upload">Select Image</button>
        </div>
    <?php
    }

    // Add image field to Edit Term screen
    public static function aletho_taxonomy_edit_term_fields($term)
    {
        $image_id = get_term_meta($term->term_id, 'term_image', true);
    ?>
        <tr class="form-field term-image-wrap">
            <th scope="row"><label for="term_image">Image</label></th>
            <td>
                <input type="hidden" name="term_image" id="term_image" value="<?php echo esc_attr($image_id); ?>" />
                <div id="term-image-preview" style="margin-bottom:10px;">
                    <?php if ($image_id) : ?>
                        <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                    <?php endif; ?>
                </div>
                <button type="button" class="button" id="term-image-upload">Select Image</button>
            </td>
        </tr>
    <?php
    }

    function aletho_taxonomy_term_image_js()
    {
    ?>
        <script>
            jQuery(document).ready(function($) {
                var frame;
                $('#term-image-upload').on('click', function(e) {
                    e.preventDefault();
                    if (frame) {
                        frame.open();
                        return;
                    }

                    frame = wp.media({
                        title: 'Select or Upload Image',
                        button: {
                            text: 'Use this image'
                        },
                        multiple: false
                    });

                    frame.on('select', function() {
                        var attachment = frame.state().get('selection').first().toJSON();
                        $('#term_image').val(attachment.id);
                        $('#term-image-preview').html('<img src="' + attachment.sizes.thumbnail.url + '" />');
                    });

                    frame.open();
                });
            });
        </script>
<?php
    }

    public static function aletho_taxonomy_enqueue_media()
    {
        // Only load on term add/edit screens
        if (isset($_GET['taxonomy'])) {
            wp_enqueue_media();
        }
    }

    public static function aletho_taxonomy_save_term_fields($term_id)
    {
        if (isset($_POST['term_image'])) {
            update_term_meta($term_id, 'term_image', sanitize_text_field($_POST['term_image']));
        }
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
