/**
 * Designare Feedback Ratings - Admin JS v2.2.0
 */

(function($) {
    'use strict';

    const DFR_Admin = {
        init: function() {
            this.initCharts();
            this.initSettings();
        },

        initCharts: function() {
            if (typeof Chart === 'undefined' || typeof dfrChartData === 'undefined') {
                return;
            }

            // Bar Chart
            const barCanvas = document.getElementById('dfr-bar-chart');
            if (barCanvas && dfrChartData.labels.length > 0) {
                new Chart(barCanvas, {
                    type: 'bar',
                    data: {
                        labels: dfrChartData.labels,
                        datasets: [
                            {
                                label: 'Positiv',
                                data: dfrChartData.positive,
                                backgroundColor: 'rgba(81, 207, 102, 0.8)',
                                borderColor: 'rgba(81, 207, 102, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Neutral',
                                data: dfrChartData.neutral,
                                backgroundColor: 'rgba(196, 163, 90, 0.8)',
                                borderColor: 'rgba(196, 163, 90, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Negativ',
                                data: dfrChartData.negative,
                                backgroundColor: 'rgba(255, 107, 107, 0.8)',
                                borderColor: 'rgba(255, 107, 107, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 12,
                                titleFont: {
                                    size: 14
                                },
                                bodyFont: {
                                    size: 13
                                }
                            }
                        },
                        scales: {
                            x: {
                                stacked: true,
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }

            // Doughnut Chart
            const doughnutCanvas = document.getElementById('dfr-doughnut-chart');
            if (doughnutCanvas && dfrChartData.summary) {
                const summary = dfrChartData.summary;
                
                new Chart(doughnutCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: ['Positiv', 'Neutral', 'Negativ'],
                        datasets: [{
                            data: [summary.positive, summary.neutral, summary.negative],
                            backgroundColor: [
                                'rgba(81, 207, 102, 0.8)',
                                'rgba(196, 163, 90, 0.8)',
                                'rgba(255, 107, 107, 0.8)'
                            ],
                            borderColor: [
                                'rgba(81, 207, 102, 1)',
                                'rgba(196, 163, 90, 1)',
                                'rgba(255, 107, 107, 1)'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 15,
                                    font: {
                                        size: 13
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 12,
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                        return label + ': ' + value + ' (' + percentage + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        },

        initSettings: function() {
            // Border Radius Slider
            $('#dfr-border-radius-slider').on('input', function() {
                const val = $(this).val();
                $('input[name="border_radius"]').not(this).val(val);
                $('#dfr-radius-preview').text(val + 'px');
            });

            $('input[name="border_radius"][type="number"]').on('input', function() {
                const val = $(this).val();
                $('#dfr-border-radius-slider').val(val);
                $('#dfr-radius-preview').text(val + 'px');
            });

            // Theme Selection
            $('.dfr-theme-option input[type="radio"]').on('change', function() {
                $('.dfr-theme-option').removeClass('dfr-theme-active');
                $(this).closest('.dfr-theme-option').addClass('dfr-theme-active');
            });

            // Color Picker Value Display
            $('input[type="color"]').on('input change', function() {
                $(this).siblings('.dfr-color-value').text($(this).val());
            });

            // Custom Icons Toggle
            $('input[name="use_custom_icons"]').on('change', function() {
                const $iconSections = $('.dfr-icons-section').parent();
                if ($(this).is(':checked')) {
                    $iconSections.slideDown(300);
                } else {
                    $iconSections.slideUp(300);
                }
            }).trigger('change');

            // File Input Label Update
            $('.dfr-icon-actions input[type="file"]').on('change', function() {
                const fileName = $(this).val().split('\\').pop();
                if (fileName) {
                    $(this).next('.button').text('Hochladen: ' + fileName);
                }
            });

            // Confirmation for Icon Deletion
            $('button[name="dfr_delete_icon"]').on('click', function(e) {
                if (!confirm('Icon wirklich löschen? Diese Aktion kann nicht rückgängig gemacht werden.')) {
                    e.preventDefault();
                }
            });

            // Auto-save indicator
            let saveTimeout;
            $('.dfr-settings-wrap form input, .dfr-settings-wrap form textarea, .dfr-settings-wrap form select').on('change', function() {
                clearTimeout(saveTimeout);
                const $btn = $('.button-primary');
                const originalText = $btn.text();
                
                $btn.addClass('dfr-changed').text('💾 Nicht gespeichert');
                
                saveTimeout = setTimeout(function() {
                    $btn.removeClass('dfr-changed').text(originalText);
                }, 2000);
            });
        }
    };

    // Initialize on DOM Ready
    $(document).ready(function() {
        DFR_Admin.init();
    });

})(jQuery);
