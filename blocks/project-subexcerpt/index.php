<?php
$post_id = get_the_ID();

if (!$post_id) {
    return '';
}

$excerpt = get_the_excerpt($post_id);
$excerpt_length = isset($attributes['excerptLength']) ? (int) $attributes['excerptLength'] : 20;
$excerpt = wp_trim_words($excerpt, $excerpt_length);

echo '<div class="project-subexcerpt">' . wp_kses_post($excerpt) . '</div>';
