<?php

class Portfolio
{
    private static $instance = null;

    private function __construct()
    {
        add_action('init', [$this, 'aletho_register_projects_post_type']);
        add_action('init', [$this, 'aletho_register_category_taxonomy']);
        add_filter('manage_projects_posts_columns', [$this, 'add_category_column']);
        add_action('manage_projects_posts_custom_column', [$this, 'render_category_column'], 10, 2);
        add_filter('manage_edit-projects_sortable_columns', [$this, 'make_category_sortable']);
        add_filter('manage_projects_posts_columns', [$this, 'add_thumbnail_column']);

        add_shortcode('projects_taxonomies', [$this, 'aletho_projects_taxonomies_shortcode']);

        add_action('manage_projects_posts_custom_column', [$this, 'render_thumbnail_column'], 10, 2);
        add_action('admin_head', [$this, 'add_thumbnail_column_styles']);
    }

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
            'has_archive' => true,
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'page-attributes'),
        );

        register_post_type('projects', $args);
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
            'public' => true,
            'publicly_queryable' => true,
            'hierarchical' => true,
            'rewrite'      => array('slug' => 'projects-category'),
            'show_in_rest' => true,
        );

        register_taxonomy('projects_category', 'projects', $args);
    }

    // Adds a custom "Category" column to the Portfolio post list, placing it right after the Title column.
    public function add_category_column($columns)
    {
        $new = [];
        foreach ($columns as $key => $label) {
            $new[$key] = $label;
            if ($key === 'title') {
                $new['projects_category'] = 'Category';
            }
        }
        return $new;
    }


    //Output the "Category" column value for each Portfolio post in the admin list table.
    public function render_category_column($column, $post_id)
    {
        if ($column === 'projects_category') {
            $terms = get_the_terms($post_id, 'projects_category');

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
        $columns['projects_category'] = 'projects_category';
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
                    $excerpt = $this->get_excerpt( $term->description, 20 );

                    echo '<li class="aletho-card">';
                        // Top section (image)
                        echo '<div class="aletho-card-top">';
                            echo '<figure class="aletho-card-image">';
                                echo '<a href="' . esc_url( get_term_link( $term ) ) . '">';
                                    echo '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $term->name ) . '" />';
                                echo '</a>';
                            echo '</figure>';
                        echo '</div>';

                        // Bottom section (title + excerpt)
                        echo '<div class="aletho-card-bottom">';
                            echo '<h2 class="aletho-card-title">';
                                echo '<a href="' . esc_url( get_term_link( $term ) ) . '">';
                                    echo esc_html( $term->name );
                                echo '</a>';
                            echo '</h2>';

                            echo '<p class="aletho-card-excerpt">' . esc_html( $excerpt ) . '</p>';
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

    public function get_excerpt($text, $length = 20)
    {
        $words = explode(' ', wp_strip_all_tags($text));
        if (count($words) > $length) {
            $words = array_slice($words, 0, $length);
            return implode(' ', $words) . '…';
        }
        return implode(' ', $words);
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
