<?php
$post_id = get_the_ID();

if (!$post_id) {
    return '';
}

$subexcerpt = get_post_meta($post_id, 'project_subexcerpt', true);

if (!empty($subexcerpt)) {
    echo '<div class="project-subexcerpt">' . wp_kses_post($subexcerpt) . '</div>';
} else {
    echo do_blocks('<!-- wp:post-excerpt {"excerptLength":20,"fontSize":"small"} /-->');
}
