<?php

class Portfolio
{
    private static $instance = null;

    private function __construct()
    {
        add_action('init', [$this, 'aletho_register_projects_post_type']);
        add_action('init', [$this, 'aletho_register_category_taxonomy']);

        // Register custom nested URL rules and override term/project permalinks for the portfolio structure.
        add_action('init', [$this, 'add_nested_rewrite_rules']);
        add_filter('term_link', [$this, 'filter_term_link'], 10, 3);
        add_filter('post_type_link', [$this, 'filter_project_permalink'], 10, 2);

        add_shortcode('projects_taxonomies', [$this, 'aletho_projects_taxonomies_shortcode']);
        add_shortcode('project_tax_header', [$this, 'aletho_portfolio_tax_header']);

        add_filter('manage_projects_posts_columns', [$this, 'add_category_column']);
        add_action('manage_projects_posts_custom_column', [$this, 'render_category_column'], 10, 2);
        add_filter('manage_edit-projects_sortable_columns', [$this, 'make_category_sortable']);
        add_filter('manage_projects_posts_columns', [$this, 'add_thumbnail_column']);
        add_action('manage_projects_posts_custom_column', [$this, 'render_thumbnail_column'], 10, 2);
        add_action('admin_head', [$this, 'add_thumbnail_column_styles']);

        add_action('projects-category_add_form_fields', [$this, 'aletho_taxonomy_add_term_fields']);
        add_action('projects-category_edit_form_fields', [$this, 'aletho_taxonomy_edit_term_fields']);
        add_action('created_projects-category', [$this, 'aletho_taxonomy_save_term_fields']);
        add_action('edited_projects-category', [$this, 'aletho_taxonomy_save_term_fields']);
        add_action('admin_footer', [$this, 'aletho_taxonomy_term_image_js']);
        add_action('admin_enqueue_scripts', [$this, 'aletho_taxonomy_enqueue_media']);
        add_filter('manage_edit-projects-category_columns', [$this, 'add_taxonomy_image_column']);
        add_filter('manage_projects-category_custom_column', [$this, 'render_taxonomy_image_column'], 10, 3);
    }

    // Registers the 'projects' CPT for Portfolio entries with /portfolio/ slug,
    // no archive, and full REST/block editor support.
    public static function aletho_register_projects_post_type()
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
            'publicly_queryable' => true,
            'has_archive' => false,
            'rewrite' => [
                'slug' => 'portfolio',
                'with_front' => false
            ],
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'page-attributes'),
        );

        register_post_type('projects', $args);
    }

    // Registers the hierarchical 'projects-category' taxonomy attached to the 'projects' CPT
    //with /portfolio-category/ URLs and REST support.
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
            'public' => true,
            'publicly_queryable' => true,
            'hierarchical' => true,
            'rewrite' => [
                'slug' => 'portfolio-category',
                'hierarchical' => true,
                'with_front' => false
            ],
            'show_in_rest' => true,
        );

        register_taxonomy('projects-category', 'projects', $args);
    }

    /**
     * Add nested rewrite rules:
     * /portfolio/<category>/<postname>/
     * /portfolio/<category>/
     */
    public function add_nested_rewrite_rules()
    {

        // CPT single with category
        add_rewrite_rule(
            '^portfolio/([^/]+)/([^/]+)/?$',
            'index.php?projects=$matches[2]&projects-category=$matches[1]',
            'top'
        );

        // Taxonomy archive
        add_rewrite_rule(
            '^portfolio/([^/]+)/?$',
            'index.php?projects-category=$matches[1]',
            'top'
        );
    }

    // Outputs a project link using the active taxonomy term to create /portfolio/<term>/<postname>/ URLs.
    public function filter_term_link($url, $term, $taxonomy)
    {
        if ($taxonomy === 'projects-category') {
            $slug = $term->slug;
            return home_url('/portfolio/' . $slug . '/');
        }

        return $url;
    }

    // Replaces the default project permalink with /portfolio/<category>/<postname>/ using the post's primary term.
    public function filter_project_permalink($permalink, $post)
    {
        if ($post->post_type !== 'projects') {
            return $permalink;
        }

        // If we are inside a taxonomy archive, use that term
        if (is_tax('projects-category')) {
            $term = get_queried_object();
            return home_url('/portfolio/' . $term->slug . '/' . $post->post_name . '/');
        }

        // Otherwise fall back to first term
        $terms = wp_get_post_terms($post->ID, 'projects-category');

        if (!$terms || is_wp_error($terms)) {
            return $permalink;
        }

        $primary = $terms[0]->slug;

        return home_url('/portfolio/' . $primary . '/' . $post->post_name . '/');
    }

    // Generates the complete taxonomy overview: loops all 'projects' taxonomies
    // and displays each term with image, title, and excerpt.
    public function aletho_projects_taxonomies_shortcode()
    {
        // Get all taxonomies attached to CPT "projects"
        $taxonomies = get_object_taxonomies('projects', 'objects');

        if (empty($taxonomies)) {
            return '<p>Geen taxonomieën gevonden.</p>';
        }
        ob_start();
        echo '<div class="projects-taxonomy-list">';

        foreach ($taxonomies as $taxonomy) {

            $terms = get_terms([
                'taxonomy'   => $taxonomy->name,
                'hide_empty' => false,
            ]);

            if (! empty($terms) && ! is_wp_error($terms)) {
                echo '<ul class="portfolio-overview-grid">';
                foreach ($terms as $term) {
                    $image = get_term_meta($term->term_id, 'term_image', true);
                    $image_url = wp_get_attachment_image_url($image, 'medium');
                    $excerpt = $this->get_excerpt($term->description, 20);

                    echo '<li class="portfolio-tax-card">';
                    // Top section (image)
                    echo '<div class="portfolio-tax-card-top">';
                    echo '<figure class="portfolio-tax-card-image">';
                    echo '<a href="' . esc_url(get_term_link($term)) . '">';
                    echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($term->name) . '" />';
                    echo '</a>';
                    echo '</figure>';
                    echo '</div>';

                    // Bottom section (title + excerpt)
                    echo '<div class="portfolio-tax-card-bottom">';
                    echo '<h2 class="portfolio-tax-card-title">';
                    echo '<a href="' . esc_url(get_term_link($term)) . '">';
                    echo esc_html($term->name);
                    echo '</a>';
                    echo '</h2>';

                    // echo '<p class="portfolio-tax-card-excerpt">' . esc_html($excerpt) . '</p>';
                    echo '</div>';

                    echo '</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>Geen termen gevonden.</p>';
            }
        }

        echo '</div>';

        return ob_get_clean();
    }

    // Create a plain‑text excerpt limited to a specific number of words.
    public function get_excerpt($text, $length = 20)
    {
        $words = explode(' ', wp_strip_all_tags($text));
        if (count($words) > $length) {
            $words = array_slice($words, 0, $length);
            return implode(' ', $words) . '…';
        }
        return implode(' ', $words);
    }

    // Render the taxonomy term name as the page header on portfolio category archives.
    public function aletho_portfolio_tax_header()
    {
        $term = get_queried_object();
        if (!$term) return '';
        $name  = $term->name;
        ob_start();
?>
        <h1 class="wp-block-post-title portfolio_tax_header"><?php echo esc_html($name); ?></h1>
    <?php
        return ob_get_clean();
    }

    /* ------ [Admin] ------ */

    // Adds a custom "Category" column to the Portfolio post list, placing it right after the Title column.
    public function add_category_column($columns)
    {
        $new = [];
        foreach ($columns as $key => $label) {
            $new[$key] = $label;
            if ($key === 'title') {
                $new['projects-category'] = 'Category';
            }
        }
        return $new;
    }

    //Output the "Category" column value for each Portfolio post in the admin list table.
    public function render_category_column($column, $post_id)
    {
        if ($column === 'projects-category') {
            $terms = get_the_terms($post_id, 'projects-category');

            if (!empty($terms) && !is_wp_error($terms)) {
                echo join(', ', wp_list_pluck($terms, 'name'));
            } else {
                echo '<span style="color:#999;">—</span>';
            }
        }
    }

    // Register the "Category" column as sortable in the Portfolio admin list table.
    public function make_category_sortable($columns)
    {
        $columns['projects-category'] = 'projects-category';
        return $columns;
    }


    // Insert a "Thumbnail" column at the beginning of the Portfolio admin columns.
    public function add_thumbnail_column($columns)
    {
        $new = [];
        $new['thumbnail'] = 'Thumbnail';
        foreach ($columns as $key => $label) {
            $new[$key] = $label;
        }
        return $new;
    }

    // Render the "Thumbnail" column for each Portfolio post in the admin list table.
    public function render_thumbnail_column($column, $post_id)
    {
        if ($column === 'thumbnail') {
            $thumb = get_the_post_thumbnail($post_id, 'thumbnail');

            if ($thumb) {
                echo $thumb;
            } else {
                echo '<span style="color:#999;">—</span>';
            }
        }
    }

    //Add custom CSS to style the Thumbnail column in the Portfolio admin list table.
    public function add_thumbnail_column_styles()
    {
        echo '<style>
        .column-thumbnail { width: 80px; }
        .column-thumbnail img { width: 60px; height: auto; }
        </style>';
    }

    // Add image upload fields to the taxonomy term creation form.
    public function aletho_taxonomy_add_term_fields()
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
    public function aletho_taxonomy_edit_term_fields($term)
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

    // Outputs the JS needed to open the WP media modal and store the selected image as term meta.
    public function aletho_taxonomy_term_image_js()
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

    // Enqueue the WordPress media library on taxonomy term add/edit screens.
    public function aletho_taxonomy_enqueue_media()
    {
        if (isset($_GET['taxonomy'])) {
            wp_enqueue_media();
        }
    }

    // Save the selected term image to term meta when the term is created or updated.
    public static function aletho_taxonomy_save_term_fields($term_id)
    {
        if (isset($_POST['term_image'])) {
            update_term_meta($term_id, 'term_image', sanitize_text_field($_POST['term_image']));
        }
    }

    // Add image column to taxonomy overview table
    public function add_taxonomy_image_column($columns)
    {
        // Insert the column after the Name column
        $new = [];

        foreach ($columns as $key => $label) {
            $new[$key] = $label;

            if ($key === 'name') {
                $new['term_image'] = 'Image';
            }
        }

        return $new;
    }

    // Output the term image inside the column
    public function render_taxonomy_image_column($content, $column_name, $term_id)
    {
        if ($column_name !== 'term_image') {
            return $content;
        }

        $image_id = get_term_meta($term_id, 'term_image', true);

        if (!$image_id) {
            return '<span style="color:#999;">—</span>';
        }

        return wp_get_attachment_image($image_id, 'thumbnail', false, [
            'style' => 'width:60px;height:60px;object-fit:cover;border-radius:4px;'
        ]);
    }

    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

Portfolio::get_instance();
