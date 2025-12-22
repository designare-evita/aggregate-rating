(function($) {
    'use strict';
    
    $(document).ready(function() {
        if (typeof Chart === 'undefined' || typeof dfrChartData === 'undefined') return;

        // Bar Chart - Top Artikel
        var barCtx = document.getElementById('dfr-bar-chart');
        if (barCtx) {
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: dfrChartData.labels,
                    datasets: [
                        { label: 'Positiv', data: dfrChartData.positive, backgroundColor: 'rgba(0, 163, 42, 0.8)' },
                        { label: 'Neutral', data: dfrChartData.neutral, backgroundColor: 'rgba(219, 166, 23, 0.8)' },
                        { label: 'Negativ', data: dfrChartData.negative, backgroundColor: 'rgba(214, 54, 56, 0.8)' }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'top' } },
                    scales: { x: { stacked: true }, y: { stacked: true, beginAtZero: true } }
                }
            });
        }

        // Doughnut Chart - Gesamtverteilung
        var doughnutCtx = document.getElementById('dfr-doughnut-chart');
        if (doughnutCtx) {
            new Chart(doughnutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Positiv', 'Neutral', 'Negativ'],
                    datasets: [{
                        data: [dfrChartData.summary.positive, dfrChartData.summary.neutral, dfrChartData.summary.negative],
                        backgroundColor: ['rgba(0, 163, 42, 0.8)', 'rgba(219, 166, 23, 0.8)', 'rgba(214, 54, 56, 0.8)']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label: function(ctx) {
                                    var total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    var pct = total > 0 ? Math.round((ctx.raw / total) * 100) : 0;
                                    return ctx.label + ': ' + ctx.raw + ' (' + pct + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }
    });
})(jQuery);
