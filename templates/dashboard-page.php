<?php if (!defined('ABSPATH')) exit; 

// Chart-Daten abrufen
$instance = Designare_Feedback_Ratings::get_instance();
$chart_method = new ReflectionMethod($instance, 'get_chart_data');
$chart_method->setAccessible(true);
$data = $chart_method->invoke($instance);

$summary = $data['summary'] ?? ['total' => 0, 'positive' => 0, 'neutral' => 0, 'negative' => 0, 'avgRating' => 0];
?>

<div class="wrap dfr-dashboard">
    <h1>
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:#C4A35A">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
        </svg>
        Feedback Dashboard
    </h1>

    <div class="dfr-stats-grid">
        <div class="dfr-stat-card">
            <div class="dfr-stat-value"><?php echo esc_html($summary['total']); ?></div>
            <div class="dfr-stat-label">Gesamt</div>
        </div>
        <div class="dfr-stat-card">
            <div class="dfr-stat-value"><?php echo esc_html($summary['avgRating']); ?></div>
            <div class="dfr-stat-label">Durchschnitt</div>
        </div>
        <div class="dfr-stat-card dfr-positive">
            <div class="dfr-stat-value"><?php echo esc_html($summary['positive']); ?></div>
            <div class="dfr-stat-label">Positiv</div>
        </div>
        <div class="dfr-stat-card dfr-neutral">
            <div class="dfr-stat-value"><?php echo esc_html($summary['neutral']); ?></div>
            <div class="dfr-stat-label">Neutral</div>
        </div>
        <div class="dfr-stat-card dfr-negative">
            <div class="dfr-stat-value"><?php echo esc_html($summary['negative']); ?></div>
            <div class="dfr-stat-label">Negativ</div>
        </div>
    </div>

    <?php if ($summary['total'] > 0) : ?>
    <div class="dfr-charts-row">
        <div class="dfr-chart-card">
            <h2>Top 10 Artikel</h2>
            <div class="dfr-chart-container">
                <canvas id="dfr-bar-chart"></canvas>
            </div>
        </div>
        <div class="dfr-chart-card">
            <h2>Verteilung</h2>
            <div class="dfr-chart-container">
                <canvas id="dfr-doughnut-chart"></canvas>
            </div>
        </div>
    </div>

    <div class="dfr-top-posts">
        <h2>Artikel Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Artikel</th>
                    <th style="text-align:center">👍</th>
                    <th style="text-align:center">😐</th>
                    <th style="text-align:center">👎</th>
                    <th style="text-align:center">Total</th>
                    <th style="text-align:right">Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $topPosts = $data['topPosts'] ?? [];
                if (!empty($topPosts)) :
                    foreach ($topPosts as $item) :
                        $r = $item['ratings'];
                        $t = $item['total'];
                        $avg = $t > 0 ? round((($r['positive'] * 5) + ($r['neutral'] * 3) + ($r['negative'] * 1)) / $t, 1) : 0;
                        $badge = $avg >= 4 ? 'good' : ($avg >= 2.5 ? 'ok' : 'bad');
                ?>
                    <tr>
                        <td><a href="<?php echo get_edit_post_link($item['id']); ?>"><?php echo esc_html(wp_trim_words($item['title'], 6, '...')); ?></a></td>
                        <td style="text-align:center"><?php echo esc_html($r['positive']); ?></td>
                        <td style="text-align:center"><?php echo esc_html($r['neutral']); ?></td>
                        <td style="text-align:center"><?php echo esc_html($r['negative']); ?></td>
                        <td style="text-align:center"><?php echo esc_html($t); ?></td>
                        <td style="text-align:right"><span class="dfr-rating-badge <?php echo $badge; ?>"><?php echo $avg; ?></span></td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
    <?php else : ?>
    <div class="dfr-info-box" style="text-align:center;padding:60px 20px;margin-top:30px;">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 20px;opacity:0.3;">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
        </svg>
        <h2 style="margin:0 0 10px;font-size:1.5rem;font-weight:300;color:#666;">Noch keine Bewertungen</h2>
        <p style="margin:0;color:#999;font-size:0.95rem;">Sobald Besucher Feedback abgeben, erscheinen hier detaillierte Statistiken.</p>
        <p style="margin:20px 0 0;font-size:0.9rem;color:#666;">
            <strong>Tipp:</strong> Stelle sicher, dass das Widget auf deinen Seiten angezeigt wird.<br>
            <a href="<?php echo admin_url('admin.php?page=dfr-settings'); ?>" style="color:#2271b1;">→ Zu den Einstellungen</a>
        </p>
    </div>
    <?php endif; ?>
</div>

<script>
var dfrChartData = <?php echo json_encode($data); ?>;
</script>
