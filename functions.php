<?php
define('ALETHO_THEME_DIR_URI', get_template_directory_uri());
define('ALETHO_THEME_DIR', get_template_directory());

class Aletho_Theme
{
    private static $instance = null;

    private function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_theme_styles']);


        add_action('init', [$this, 'aletho_register_blocks']);


        add_action('admin_menu', [$this, 'theme_admin_menu_addons']);
        add_action('init', [$this, 'aletho_register_button_styles']);
        add_action('init', [$this, 'aletho_register_list_styles']);
        add_action('enqueue_block_assets', [$this, 'aletho_enqueue_block_styles']);
        add_action('wp_enqueue_scripts', [$this, 'aletho_enqueue_hover_script']);

        add_action('init', [$this, 'aletho_register_portfolio_post_type']);
        add_action('init', [$this, 'aletho_register_category_taxonomy']);
        

        add_filter('the_content', function($content) { error_log("CONTENT BEFORE OUTPUT: " . $content); return $content; }, 1);

        add_filter('manage_portfolio_posts_columns', function ($columns) {
            $new = [];
            foreach ($columns as $key => $label) {
                $new[$key] = $label;
                if ($key === 'title') {
                    $new['category'] = 'Category';
                }
            }
            return $new;
        });

        add_action('manage_portfolio_posts_custom_column', function ($column, $post_id) {
            if ($column === 'category') {
                $terms = get_the_terms($post_id, 'category');
                if (!empty($terms) && !is_wp_error($terms)) {
                    echo join(', ', wp_list_pluck($terms, 'name'));
                } else {
                    echo '<span style="color:#999;">—</span>';
                }
            }
        }, 10, 2);

        add_filter('manage_edit-portfolio_sortable_columns', function ($columns) {
            $columns['category'] = 'category';
            return $columns;
        });

        add_filter('manage_portfolio_posts_columns', function ($columns) {
            $new = [];
            $new['thumbnail'] = 'Thumbnail';
            foreach ($columns as $key => $label) {
                $new[$key] = $label;
            }
            return $new;
        });

        add_action('manage_portfolio_posts_custom_column', function ($column, $post_id) {
            if ($column === 'thumbnail') {
                $thumb = get_the_post_thumbnail($post_id, 'thumbnail');
                if ($thumb) {
                    echo $thumb;
                } else {
                    echo '<span style="color:#999;">—</span>';
                }
            }
        }, 10, 2);

        add_action('admin_head', function () {
            echo '<style> .column-thumbnail { width: 80px; } .column-thumbnail img { width: 60px; height: auto; } </style>';
        });

        add_action('category_add_form_fields', [$this, 'aletho_taxonomy_add_term_fields']);
        add_action('category_edit_form_fields', [$this, 'aletho_taxonomy_edit_term_fields']);
        add_action('created_category', [$this, 'aletho_taxonomy_save_term_fields']);
        add_action('edited_category', [$this, 'aletho_taxonomy_save_term_fields']);
        add_action('admin_footer', [$this, 'aletho_taxonomy_term_image_js']);
        add_action('admin_enqueue_scripts', [$this, 'aletho_taxonomy_enqueue_media']);
        // add_action('init', function () {

        //     // Register editor script manually
        //     wp_register_script(
        //         'hello-block-editor',
        //         get_template_directory_uri() . '/blocks/hello-block/editor.js',
        //         ['wp-blocks', 'wp-element', 'wp-editor'],
        //         filemtime(get_template_directory() . '/blocks/hello-block/editor.js')
        //     );

        //     // Register block.json and attach script
        //     register_block_type(
        //         __DIR__ . '/blocks/hello-block/block.json',
        //         [
        //             'editor_script' => 'hello-block-editor'
        //         ]
        //     );
        // });

        // Sticky header assets
        add_action('enqueue_block_editor_assets', [$this, 'aletho_callback_function']);
        add_action('enqueue_block_assets', [$this, 'aletho_js_frontend_backend_enqueue']);
    }

    public static function enqueue_theme_styles()
    {
        // Enqueue main theme stylesheet
        wp_enqueue_style('aletho-theme-style', get_stylesheet_uri());

        // Enqueue Dashicons for frontend use
        wp_enqueue_style('dashicons');
    }

    public function aletho_register_blocks()
    {
        register_block_type(get_template_directory() . '/blocks/contactform/block.json');
        register_block_type( get_template_directory() . '/blocks/my-dynamic-block' );
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

    public static function aletho_register_portfolio_post_type()
    {
        $args = array(
            'labels' => array(
                'name' => __('Portfolio', 'aletho'),
                'singular_name' => __('Project', 'aletho'),
                'menu_name' => __('Portfolio', 'aletho'),
                'add_new' => __('Add New Portfolio', 'aletho'),
                'add_new_item' => __('Add New Project', 'aletho'),
                'new_item' => __('New Project', 'aletho'),
                'edit_item' => __('Edit Project', 'aletho'),
                'view_item' => __('View Project', 'aletho'),
                'all_items' => __('All Projects', 'aletho'),
            ),
            'public' => true,
            'has_archive' => true,
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'page-attributes'),
        );

        register_post_type('portfolio', $args);
    }

    public static function aletho_register_category_taxonomy()
    {
        $args = array(
            'labels'       => array(
                'name'          => __('Category', 'aletho'),
                'singular_name' => __('Category', 'aletho'),
                'edit_item'     => __('Edit Category', 'aletho'),
                'update_item'   => __('Update Category', 'aletho'),
                'add_new_item'  => __('Add New Category', 'aletho'),
                'new_item_name' => __('New Category Name', 'aletho'),
                'menu_name'     => __('Category', 'aletho'),
            ),
            'hierarchical' => true,
            'rewrite'      => array('slug' => 'portfolio-category'),
            'show_in_rest' => true,
        );

        register_taxonomy('portfolio_category', 'portfolio', $args);
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

    public static function aletho_callback_function()
    {
        wp_enqueue_script(
            'theme-callback-block-variation',
            ALETHO_THEME_DIR_URI . '/assets/js/block-variations.js',
            array('wp-blocks', 'wp-dom-ready'),
            wp_get_theme()->get('Version')
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
