<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<!-- <p <?php // echo get_block_wrapper_attributes(); ?>> -->
	<?php // esc_html_e('Gradientblock – hello from a dynamic block!', 'gradientblock'); ?>
<!-- </p> -->
<div class="min-h-64 bg-linear-135 from-secondary from-75% to-aletho-light-blue to-75%">
	<div class="container mx-auto lg:max-w-screen-xl md:max-w-screen-md px-4 pt-20">
		<h1 class="mb-6 text-center lg:text-left text-5xl lg:text-7xl font-alphapipe text-primary"><?php echo esc_html($attributes['blockContent']); ?></h1>
		<h3 class="text-center lg:text-left text-3xl font-alphapipe text-primary">mogelijk gemaakt in Noord-Nederland.</h3>
	</div>
</div>