<?php get_header(); ?>
<main>

    <section>
        <div class="bg-green-200 py-3 px-4">
            <?php // block_template_part('content');
            while (have_posts()) {
                the_post(); ?>
                <?php the_title() ?>
            <?php    } ?>


        </div>
    </section>

</main>

<?php get_footer(); ?>