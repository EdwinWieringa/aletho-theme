<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset')  ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php wp_title(); ?></title>
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>

    <header class="top-0 py-0 bg-primary border-b-1 border-secondary">
        <div class="lg:py py-2">
            <div class="container mx-auto lg:max-w-screen-xl md:max-w-screen-md flex items-center justify-between px-4">
                <a class="flex items-center" href="<?php echo esc_url( home_url( '/' ) ); ?>"  title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                    <img width="220" height="85" src="<?php echo get_template_directory_uri(); ?>/img/aletho-logo.svg" alt="">
                </a>

                <!-- wp_nav_menu -->

                    <?php wp_nav_menu( array(
                        'theme_location' => 'header-menu',
                        'menu_class' => 'text-white lg:flex flex-grow items-center gap-10 justify-center text-xl **:hover:text-aletho-orange'
                         ) ); 
                    ?>


                <div class="flex items-center gap-4">
                    <a class="hidden lg:block text-primary bg-secondary hover:text-white hover:bg-aletho-orange font-bold text-xl py-3 px-3 rounded-2xl" href="">Aanmelden</a>
                    <a class="hidden lg:block bg-aletho-orange text-white hover:bg-white hover:text-primary font-bold text-xl py-3 px-3 rounded-2xl" href="">Contact</a>
                </div>

            </div>
        </div>

    </header>