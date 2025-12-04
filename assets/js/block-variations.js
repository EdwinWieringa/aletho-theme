wp.blocks.registerBlockVariation(
    "core/group", {
    name: "sticky-header",
    title: "Sticky Header",
    icon: "sticky",
    attributes: {
        align: "full",
        className: "sticky-header",
        anchor: "sticky-header",
        layout: {
            type: "constrained"
        }
    }
});

wp.blocks.registerBlockVariation('core/image', {
  name: 'custom-footer-image',
  title: 'Footer Image',
  icon: "superhero-alt",
  attributes: {
    className: 'custom-footer-image',
    align: 'center',
  },
  icon: 'format-image',
});