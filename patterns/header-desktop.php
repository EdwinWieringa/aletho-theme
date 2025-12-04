<?php
/**
 * Title: Header Desktop
 * Slug: aletho/header-desktop
 * Categories: header
 */
?>

<!-- wp:group {"align":"full","className":"sticky-header","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}},"position":{"type":"sticky","top":"0px"}},"backgroundColor":"primary-blue","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull sticky-header has-primary-blue-background-color has-background" id="sticky-header" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)">
    <!-- wp:columns {"isStackedOnMobile":false,"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0"}}}} -->
    <div class="wp-block-columns is-not-stacked-on-mobile" style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0">
        <!-- wp:column {"width":"200px"} -->
        <div class="wp-block-column" style="flex-basis:200px">
            <!-- wp:image {"lightbox":{"enabled":false},"width":"265px","sizeSlug":"large","linkDestination":"custom"} -->
            <figure class="wp-block-image size-large is-resized">
                <a href="<?php echo get_home_url(); ?>">
                    <img src="<?php echo esc_url(get_theme_file_uri('assets/images/logo-aletho-wit.png')); ?>" alt="" />
                </a>
            </figure>
            <!-- /wp:image -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"verticalAlignment":"center"} -->
        <div class="wp-block-column is-vertically-aligned-center">
            <!-- wp:navigation {"textColor":"white","overlayMenu":"never","icon":"menu","overlayBackgroundColor":"secundary-light-blue","overlayTextColor":"primary-blue","fontSize":"medium","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center","orientation":"horizontal"}} -->
                <!-- wp:navigation-link {"label":"Over ons","type":"page","url":"/over-ons"} /-->
                <!-- wp:navigation-link {"label":"Aanbod","type":"page","url":"/aanbod"} /-->
                <!-- wp:navigation-link {"label":"Verwijzers","type":"page","url":"/verwijzers"} /-->
                <!-- wp:navigation-link {"label":"Portfolio","type":"page","url":"/portfolio"} /-->
            <!-- /wp:navigation -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"width":"270px"} -->
        <div class="wp-block-column" style="flex-basis:270px">
            <!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
            <div class="wp-block-buttons">
                <!-- wp:button {"className":"is-style-light-blue"} -->
                <div class="wp-block-button is-style-light-blue">                
                    <a class="wp-block-button__link wp-element-button">
                        <strong>Aanmelden</strong>
                    </a>
                </div>
                <!-- /wp:button -->
                
                <!-- wp:button {"className":"is-style-orange"} -->
                <div class="wp-block-button is-style-orange">
                    <a class="wp-block-button__link wp-element-button">
                        <strong>Contact</strong>
                    </a>
                </div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"aletho/title-banner"} /-->