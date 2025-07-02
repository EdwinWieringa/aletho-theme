<?php get_header(); ?>
<main>
    <section class="bg-primary">
        <div>
            <div  class="m-auto py-0" >
                <img src="<?php echo get_template_directory_uri() . '/img/aletho-logo.svg'; ?>" />
            </div>
        </div>
    </section>

    <section>
        <div class="">
            <?php // block_template_part('content'); 
            while (have_posts()) {
                the_post(); ?>
                <p><?php the_content() ?></p>
            <?php    } ?>


        </div>
    </section>

</main>

<?php get_footer(); ?>