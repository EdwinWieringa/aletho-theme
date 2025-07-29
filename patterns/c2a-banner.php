<?php

/**
 * Title: Call To Action
 * Slug: aletho/c2a-banner
 * Categories: features
 */
?>

<!-- wp:columns {"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"gradient":"aletho-light-blue-gradient"} -->
<div class="wp-block-columns alignfull has-aletho-light-blue-gradient-gradient-background has-background"
	style="margin-top:0;margin-bottom:0"><!-- wp:column {"layout":{"type":"constrained"}} -->
	<div class="wp-block-column">
		<!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-blue"}}}},"textColor":"primary-blue","fontSize":"x-large"} -->
		<h2 class="wp-block-heading has-primary-blue-color has-text-color has-link-color has-x-large-font-size"><?php esc_html_e( 'Ben je geïnteresseerd?' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"fontSize":"medium"} -->
		<p class="has-medium-font-size"><?php esc_html_e('Bij interesse kan je contact opnemen voor het plannen van een rondleiding zodat je een beter beeld krijgt van wat Alétho voor je kan doen. We hebben locaties in Assen en in Groningen.'); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button {"backgroundColor":"primary-blue","textColor":"white","style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}}} -->
			<div class="wp-block-button"><a
					class="wp-block-button__link has-white-color has-primary-blue-background-color has-text-color has-background has-link-color wp-element-button"><strong><?php esc_html_e( 'Aanmelden'); ?></strong></a>
			</div>
			<!-- /wp:button -->

			<!-- wp:button {"backgroundColor":"primary-orange","textColor":"white","style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}}} -->
			<div class="wp-block-button"><a
					class="wp-block-button__link has-white-color has-primary-orange-background-color has-text-color has-background has-link-color wp-element-button"><strong><?php esc_html_e( 'Contact'); ?></strong></a>
			</div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->
 