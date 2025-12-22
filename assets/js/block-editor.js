(function(blocks, element, blockEditor, components) {
    var el = element.createElement;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var ToggleControl = components.ToggleControl;

    blocks.registerBlockType('dfr/feedback-rating', {
        title: 'Feedback Rating',
        icon: 'star-filled',
        category: 'widgets',
        description: 'Fügt ein Besucher-Feedback Widget hinzu',
        attributes: {
            showStats: { type: 'boolean', default: true },
            showShare: { type: 'boolean', default: true }
        },
        edit: function(props) {
            var attrs = props.attributes;

            return el('div', {},
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Einstellungen', initialOpen: true },
                        el(ToggleControl, {
                            label: 'Statistik-Balken anzeigen',
                            checked: attrs.showStats,
                            onChange: function(val) { props.setAttributes({ showStats: val }); }
                        }),
                        el(ToggleControl, {
                            label: 'Share-Buttons anzeigen',
                            checked: attrs.showShare,
                            onChange: function(val) { props.setAttributes({ showShare: val }); }
                        })
                    )
                ),
                el('div', { className: 'dfr-block-preview' },
                    el('div', { className: 'dfr-block-preview-title' }, 'War dieser Artikel hilfreich?'),
                    el('div', { className: 'dfr-block-preview-buttons' },
                        el('span', { className: 'dfr-block-preview-btn pos' }, '👍 Hilfreich'),
                        el('span', { className: 'dfr-block-preview-btn neu' }, '😐 Neutral'),
                        el('span', { className: 'dfr-block-preview-btn neg' }, '👎 Nicht hilfreich')
                    ),
                    !attrs.showStats ? null : el('p', { style: { fontSize: '12px', color: '#666', marginTop: '10px' } }, '📊 Statistik-Balken aktiv'),
                    !attrs.showShare ? null : el('p', { style: { fontSize: '12px', color: '#666' } }, '🔗 Share-Buttons aktiv')
                )
            );
        },
        save: function() { return null; } // Server-side rendering
    });
})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components
);
