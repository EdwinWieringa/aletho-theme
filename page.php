<?php get_header(); ?>
<main>
    <section class="bg-primary">
        <div>
            <div>
                <img src="<?php echo get_template_directory_uri() . '/img/aletho-logo.svg'; ?>" />
            </div>
        </div>
    </section>

    <!-- <section>
        <div class="min-h-64 bg-linear-135 from-secondary from-75% to-aletho-light-blue to-75%">
            <div class="container mx-auto lg:max-w-screen-xl md:max-w-screen-md px-4 pt-20">
                <h1 class="mb-6 text-center lg:text-left text-5xl lg:text-7xl font-alphapipe text-primary">IT-trajecten en begeleiding</h1>
                <h3 class="text-center lg:text-left text-3xl font-alphapipe text-primary">mogelijk gemaakt in Noord-Nederland.</h3>
            </div>
        </div>
    </section> -->

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