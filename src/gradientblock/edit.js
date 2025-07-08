/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit() {
	return (
		// <p { ...useBlockProps() }>
		// 	{ __( 'Gradientblock – hello from the ed', 'gradientblock' ) }
		// </p>
	
        <div class="min-h-64 bg-linear-135 from-secondary from-75% to-aletho-light-blue to-75%">
            <div class="container mx-auto lg:max-w-screen-xl md:max-w-screen-md px-4 pt-20">
                <h1 class="mb-6 text-center lg:text-left text-5xl lg:text-7xl font-alphapipe text-primary">IT-trajecten en begeleiding</h1>
                <h3 class="text-center lg:text-left text-3xl font-alphapipe text-primary">mogelijk gemaakt in Noord-Nederland.</h3>
            </div>
        </div>
    
	);
}
