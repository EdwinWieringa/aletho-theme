<?php

echo '<nav class="portfolio-breadcrumbs">';

// Home
echo '<a href="' . esc_url(home_url('/')) . '">Home</a>';
echo ' &raquo; ';

// Portfolio
echo '<a href="' . esc_url(home_url('/portfolio/')) . '">Portfolio</a>';

// Taxonomy page
if (is_tax('projects-category')) {

    $term = get_queried_object();

    echo ' &raquo; ';
    echo '<span>' . esc_html($term->name) . '</span>';

    echo '</nav>';
    return;
}

// Single project page
if (is_singular('projects')) {

    $project_id = get_the_ID();
    $terms = wp_get_post_terms($project_id, 'projects-category');

    if (!empty($terms)) {
        $term = $terms[0];
        echo ' &raquo; ';
        echo '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
    }

    echo ' &raquo; ';
    echo '<span>' . esc_html(get_the_title($project_id)) . '</span>';

    echo '</nav>';
    return;
}

echo '</nav>';
