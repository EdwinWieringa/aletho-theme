<?php
/**
 * Title: Call To Action
 * Slug: aletho/c2a-banner
 * Categories: features
 */
?>

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"gradient":"aletho-light-blue-gradient","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-aletho-light-blue-gradient-gradient-background has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">


    <!-- wp:group {"layout":{"type":"default"}} -->
    <div class="wp-block-group">

        <!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-blue"}}}},"textColor":"primary-blue","fontSize":"x-large"} -->
        <h2 class="wp-block-heading has-primary-blue-color has-text-color has-link-color has-x-large-font-size"><?php esc_html_e("Ben je geïnteresseerd?"); ?></h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"style":{"spacing":{"margin":{"right":"14em"}}},"fontSize":"medium"} -->
        <p class="has-medium-font-size" style="margin-right:14em">Bij interesse kan je contact opnemen voor het plannen van een rondleiding zodat je een beter beeld krijgt van wat Alétho voor je kan doen. We hebben locaties in Assen en in Groningen.</p>
        <!-- /wp:paragraph -->

        <!-- wp:buttons -->
        <div class="wp-block-buttons"><!-- wp:button {"className":"is-style-blue"} -->
            <div class="wp-block-button is-style-blue"><a class="wp-block-button__link wp-element-button">
                    <strong><?php esc_html_e("Aanmelden"); ?></strong>
                </a>
            </div>
            <!-- /wp:button -->

            <!-- wp:button {"className":"is-style-orange"} -->
            <div class="wp-block-button is-style-orange">
                <a class="wp-block-button__link wp-element-button">
                    <strong><?php esc_html_e("Contact"); ?></strong>
                </a>
            </div>
            <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->

    </div>
    <!-- /wp:group -->

</div>
<!-- /wp:group -->
