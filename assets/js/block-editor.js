/**
 * Designare Feedback Ratings - Block Editor v2.2.0
 */

(function(blocks, element, blockEditor, components) {
    const el = element.createElement;
    const { registerBlockType } = blocks;
    const { InspectorControls } = blockEditor;
    const { PanelBody, RadioControl, ToggleControl } = components;

    registerBlockType('dfr/feedback-rating', {
        title: 'Feedback Rating',
        description: 'Zeigt das Feedback-Rating-Widget mit wählbarem Theme an',
        icon: el('svg', { width: 24, height: 24, viewBox: '0 0 24 24' },
            el('polygon', {
                points: '12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2',
                fill: 'none',
                stroke: 'currentColor',
                strokeWidth: 2
            })
        ),
        category: 'widgets',
        keywords: ['feedback', 'rating', 'bewertung', 'sterne', 'thumbs'],
        attributes: {
            theme: {
                type: 'string',
                default: ''
            },
            showStats: {
                type: 'boolean',
                default: true
            },
            showShare: {
                type: 'boolean',
                default: true
            }
        },

        edit: function(props) {
            const { attributes, setAttributes } = props;
            const { theme, showStats, showShare } = attributes;

            // Theme Label
            const getThemeLabel = () => {
                if (theme === 'thumbs') return 'Thumbs (3-Stufen)';
                if (theme === 'stars') return 'Sterne (5-Stufen)';
                return 'Aus Plugin-Einstellungen';
            };

            // Preview Icon
            const renderPreviewIcon = () => {
                if (theme === 'stars' || (!theme && window.dfrDefaultTheme === 'stars')) {
                    return el('div', { className: 'dfr-block-preview-stars' },
                        [1,2,3,4,5].map(i => 
                            el('svg', {
                                key: i,
                                className: 'dfr-block-preview-star',
                                viewBox: '0 0 24 24',
                                fill: 'currentColor',
                                stroke: 'currentColor',
                                strokeWidth: 2
                            },
                                el('polygon', {
                                    points: '12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'
                                })
                            )
                        )
                    );
                } else {
                    return el('div', { className: 'dfr-block-preview-buttons' },
                        el('div', { className: 'dfr-block-preview-btn positive' },
                            el('svg', { width: 16, height: 16, viewBox: '0 0 24 24', fill: 'none', stroke: 'currentColor', strokeWidth: 2 },
                                el('path', { d: 'M12 19V5M5 12l7-7 7 7' })
                            ),
                            'Hilfreich'
                        ),
                        el('div', { className: 'dfr-block-preview-btn neutral' },
                            el('svg', { width: 16, height: 16, viewBox: '0 0 24 24', fill: 'none', stroke: 'currentColor', strokeWidth: 2 },
                                el('path', { d: 'M5 12h14' })
                            ),
                            'Neutral'
                        ),
                        el('div', { className: 'dfr-block-preview-btn negative' },
                            el('svg', { width: 16, height: 16, viewBox: '0 0 24 24', fill: 'none', stroke: 'currentColor', strokeWidth: 2 },
                                el('path', { d: 'M12 5v14M5 12l7 7 7-7' })
                            ),
                            'Nicht hilfreich'
                        )
                    );
                }
            };

            return [
                // Inspector Controls (Sidebar)
                el(InspectorControls, { key: 'inspector' },
                    el(PanelBody, { title: 'Widget Einstellungen', initialOpen: true },
                        el(RadioControl, {
                            label: 'Theme',
                            help: 'Wähle das Bewertungs-System',
                            selected: theme,
                            options: [
                                { label: '⚙️ Aus Plugin-Einstellungen', value: '' },
                                { label: '👍 Thumbs (3-Stufen)', value: 'thumbs' },
                                { label: '⭐ Sterne (5-Stufen)', value: 'stars' }
                            ],
                            onChange: function(value) {
                                setAttributes({ theme: value });
                            }
                        }),
                        el(ToggleControl, {
                            label: 'Statistik-Balken anzeigen',
                            checked: showStats,
                            onChange: function(value) {
                                setAttributes({ showStats: value });
                            }
                        }),
                        el(ToggleControl, {
                            label: 'Share-Buttons anzeigen',
                            checked: showShare,
                            onChange: function(value) {
                                setAttributes({ showShare: value });
                            }
                        })
                    )
                ),

                // Block Content (Preview)
                el('div', { 
                    key: 'content',
                    className: 'wp-block-dfr-feedback-rating'
                },
                    el('div', { className: 'dfr-block-preview' },
                        el('svg', {
                            className: 'dfr-block-preview-icon',
                            viewBox: '0 0 24 24',
                            fill: 'none',
                            stroke: 'currentColor',
                            strokeWidth: 2
                        },
                            el('polygon', {
                                points: '12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'
                            })
                        ),
                        el('h3', { className: 'dfr-block-preview-title' },
                            'Feedback Rating Widget'
                        ),
                        el('p', { className: 'dfr-block-preview-description' },
                            'Besucher können hier ihre Bewertung abgeben. Das Widget wird auf der Frontend-Seite angezeigt.'
                        ),
                        el('span', { 
                            className: 'dfr-block-theme-badge ' + (theme === 'stars' ? 'stars' : theme === 'thumbs' ? 'thumbs' : '')
                        },
                            getThemeLabel()
                        ),
                        renderPreviewIcon(),
                        el('div', { style: { marginTop: '15px', fontSize: '0.85rem', color: '#666' } },
                            el('div', {},
                                showStats ? '✓ Mit Statistik' : '✗ Ohne Statistik'
                            ),
                            el('div', {},
                                showShare ? '✓ Mit Share-Buttons' : '✗ Ohne Share-Buttons'
                            )
                        )
                    )
                )
            ];
        },

        save: function() {
            // Server-side rendering
            return null;
        }
    });

})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components
);
