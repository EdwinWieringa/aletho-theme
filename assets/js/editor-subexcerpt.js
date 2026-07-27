wp.domReady(() => {
    const { TextareaControl } = wp.components;
    const { useEntityProp } = wp.coreData;
    const { createElement, render } = wp.element;

    const interval = setInterval(() => {
        const panel = document.querySelector('.editor-post-summary__panel');
        if (!panel) return;

        clearInterval(interval);

        const SubExcerptField = () => {
            const [ excerpt, setExcerpt ] = useEntityProp('postType', 'projects', 'excerpt');

            return createElement(TextareaControl, {
                className: 'subexcerpt-field',
                label: 'Extra Excerpt',
                value: excerpt || '',
                onChange: setExcerpt,
            });
        };

        const container = document.createElement('div');
        container.classList.add('subexcerpt-container');
        panel.appendChild(container);

        render(createElement(SubExcerptField), container);
    }, 200);
});
