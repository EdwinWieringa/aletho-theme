import { registerBlockType } from '@wordpress/blocks';

registerBlockType('aletho/hello-block', {
    edit() {
        return 'Hello Block (editor)';
    },
    save() {
        return null;
    }
});
