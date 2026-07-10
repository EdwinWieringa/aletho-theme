wp.blocks.registerBlockType('aletho/portfolio-breadcrumbs', {
    edit() {
        return wp.element.createElement(
            'div',
            { style: { padding: '8px', opacity: 0.7 } },
            'Portfolio Breadcrumbs (dynamic block)'
        );
    },
    save() {
        return null; // dynamic block
    }
});
