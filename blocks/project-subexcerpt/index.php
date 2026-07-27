<?php
$post_id = get_the_ID();

if (!$post_id) {
    return '';
}

$excerpt = get_the_excerpt($post_id);
echo '<div class="project-subexcerpt">' . wp_kses_post($excerpt) . '</div>';
