(function(blocks, element, blockEditor, components) {
    var el = element.createElement;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var ToggleControl = components.ToggleControl;
    var RadioControl = components.RadioControl;

    blocks.registerBlockType('dfr/feedback-rating', {
        title: 'Feedback Rating',
        icon: 'star-filled',
        category: 'widgets',
        description: 'Fügt ein Besucher-Feedback Widget hinzu',
        attributes: {
            showStats: { type: 'boolean', default: true },
            showShare: { type: 'boolean', default: true },
            theme: { type: 'string', default: '' }
        },
        edit: function(props) {
            var attrs = props.attributes;

            return el('div', {},
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Einstellungen', initialOpen: true },
                        el(RadioControl, {
                            label: 'Theme',
                            selected: attrs.theme || '',
                            options: [
                                { label: 'Aus Plugin-Einstellungen', value: '' },
                                { label: '👍 Thumbs (3 Stufen)', value: 'thumbs' },
                                { label: '⭐ Sterne (5 Stufen)', value: 'stars' }
                            ],
                            onChange: function(val) { props.setAttributes({ theme: val }); }
                        }),
                        el('hr'),
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
                    el('div', { className: 'dfr-block-preview-title' }, 
                        attrs.theme === 'stars' ? 'Wie bewertest du diesen Artikel?' : 'War dieser Artikel hilfreich?'
                    ),
                    el('div', { className: 'dfr-block-preview-buttons' },
                        attrs.theme === 'stars' ? [
                            el('span', { key: 1, className: 'dfr-block-preview-btn star' }, '⭐'),
                            el('span', { key: 2, className: 'dfr-block-preview-btn star' }, '⭐'),
                            el('span', { key: 3, className: 'dfr-block-preview-btn star' }, '⭐'),
                            el('span', { key: 4, className: 'dfr-block-preview-btn star' }, '⭐'),
                            el('span', { key: 5, className: 'dfr-block-preview-btn star' }, '⭐')
                        ] : [
                            el('span', { key: 1, className: 'dfr-block-preview-btn pos' }, '👍 Hilfreich'),
                            el('span', { key: 2, className: 'dfr-block-preview-btn neu' }, '😐 Neutral'),
                            el('span', { key: 3, className: 'dfr-block-preview-btn neg' }, '👎 Nicht hilfreich')
                        ]
                    ),
                    el('p', { 
                        style: { fontSize: '11px', color: '#999', marginTop: '10px', textAlign: 'center' } 
                    }, 
                        attrs.theme === '' ? '📝 Theme aus Einstellungen' : 
                        attrs.theme === 'stars' ? '⭐ Sterne-System' : '👍 Thumbs-System'
                    ),
                    !attrs.showStats ? null : el('p', { style: { fontSize: '12px', color: '#666', marginTop: '5px' } }, '📊 Statistik aktiv'),
                    !attrs.showShare ? null : el('p', { style: { fontSize: '12px', color: '#666' } }, '🔗 Share aktiv')
                )
            );
        },
        save: function() { return null; }
    });
})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components
);
