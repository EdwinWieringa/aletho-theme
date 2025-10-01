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
}
)