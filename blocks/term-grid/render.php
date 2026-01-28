<?php
$taxonomy = 'portfolio';

$terms = get_terms([
    'taxonomy' => $taxonomy,
    'hide_empty' => false,
]);
if (!empty($terms) && !is_wp_error($terms)) : ?>
    <div class="term-grid">
        <?php foreach ($terms as $term) :
            $image_id = get_term_meta($term->term_id, 'term_image', true);
            $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : null;
        ?>
            <div class="term-grid__item">
                <?php if ($image_url) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($term->name); ?>">
                <?php endif; ?>

                <h3>
                    <a href="<?php echo esc_url(get_term_link($term)); ?>">
                        <?php echo esc_html($term->name); ?>
                    </a>
                </h3>
            </div> <?php endforeach; ?>
    </div> <?php endif; ?>