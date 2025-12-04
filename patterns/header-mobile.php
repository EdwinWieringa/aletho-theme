<?php
/**
 * Title: Header Mobile
 * Slug: aletho/header-mobile
 * Categories: header
 * 
 * 
 */
?>
<!-- wp:group {"className":"nav-mobile-wrap","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"backgroundColor":"primary-blue","layout":{"type":"constrained"}} -->
<div class="wp-block-group nav-mobile-wrap has-primary-blue-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
    <!-- wp:navigation {"overlayMenu":"always","icon":"menu","overlayBackgroundColor":"secundary-pale-blue","overlayTextColor":"primary-blue","layout":{"type":"flex","justifyContent":"left"}} -->
        <!-- wp:site-logo {"width":170} /-->
        <!-- wp:navigation-link {"label":"Over ons","type":"page","url":"/over-ons"} /-->
        <!-- wp:navigation-link {"label":"Aanbod","type":"page","url":"/aanbod"} /-->
        <!-- wp:navigation-link {"label":"Verwijzers","type":"page","url":"/verwijzers"} /-->
        <!-- wp:navigation-link {"label":"Portfolio","type":"page","url":"/portfolio"} /-->
        <!-- wp:navigation-link {"label":"Aanmelden","type":"page","url":"/it-trajecten"} /-->
        <!-- wp:navigation-link {"label":"Contact","type":"page","url":"/it-trajecten"} /-->
    <!-- /wp:navigation -->

    <!-- wp:image  -->
    <figure class="wp-block-image">
        <a href="<?php echo get_home_url(); ?>">
            <img src="<?php echo esc_url(get_theme_file_uri('assets/images/logo-aletho-big-diamond.png')); ?>" alt="" />
        </a>
    </figure>
    <!-- /wp:image -->
</div>
<!-- /wp:group -->