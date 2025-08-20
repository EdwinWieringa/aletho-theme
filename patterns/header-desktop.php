<?php

/**
 * Title: Header Desktop
 * Slug: aletho/header-desktop
 * Categories: features
 */
?>

<!-- wp:group {"className":"navigation-desktop","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group navigation-desktop"
    style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)">
    <!-- wp:columns {"isStackedOnMobile":false,"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0"}}}} -->
    <div class="wp-block-columns is-not-stacked-on-mobile" style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0">
        <!-- wp:column {"width":"200px"} -->
        <div class="wp-block-column" style="flex-basis:200px">
            <!-- wp:image {"lightbox":{"enabled":false},"width":"265px","sizeSlug":"large","linkDestination":"custom"} -->
            <figure class="wp-block-image size-large is-resized">
                <a href="<?php echo home_url(); ?>">
                    <img src="<?php echo esc_url(get_theme_file_uri('assets/images/logo-aletho-wit.png')) ?>" alt="" style="width:265px" />
                </a>
            </figure>
            <!-- /wp:image -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"verticalAlignment":"center"} -->
        <div class="wp-block-column is-vertically-aligned-center">
            <!-- wp:navigation {"ref":36,"textColor":"white","overlayMenu":"never","icon":"menu","overlayBackgroundColor":"secundary-light-blue","overlayTextColor":"primary-blue","fontSize":"medium","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center","orientation":"horizontal"}} /-->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"width":"270px"} -->
        <div class="wp-block-column" style="flex-basis:270px">
            <!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
            <div class="wp-block-buttons">
                <!-- wp:button -->
                <div class="wp-block-button">
                    <a class="wp-block-button__link wp-element-button"><strong>Aanmelden</strong></a>
                </div>
                <!-- /wp:button -->

                <!-- wp:button {"backgroundColor":"primary-orange","textColor":"white","style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}}} -->
                <div class="wp-block-button">
                    <a
                        class="wp-block-button__link has-white-color has-primary-orange-background-color has-text-color has-background has-link-color wp-element-button">
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