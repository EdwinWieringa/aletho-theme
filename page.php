<?php get_header(); ?>
<main>

    <section>
            <?php
            while (have_posts()) {
                the_post(); ?>
                <p><?php the_content() ?></p>
            <?php } ?>
    </section>

</main>

<?php get_footer(); ?>