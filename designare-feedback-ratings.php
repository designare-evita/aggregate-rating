<?php
/**
 * Plugin Name: Designare Feedback Ratings
 * Plugin URI: https://designare.at
 * Description: Sammelt Besucher-Feedback mit 2 Themes (Thumbs & Sterne), Custom Icons und automatischer Schema.org AggregateRating-Generierung für besseres SEO.
 * Version: 2.2.0
 * Author: Michael Kanda
 * Author URI: https://designare.at
 * License: GPL v2 or later
 * Text Domain: designare-feedback
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) exit;

define('DFR_VERSION', '2.2.0');
define('DFR_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DFR_PLUGIN_URL', plugin_dir_url(__FILE__));

class Designare_Feedback_Ratings {

    private static $instance = null;
    const META_KEY = '_dfr_ratings';
    const CACHE_PREFIX = 'dfr_cache_';
    const CACHE_DURATION = 3600;

    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);

        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
        add_action('wp_head', [$this, 'inject_schema_json_ld'], 5);
        add_action('wp_head', [$this, 'inject_custom_styles'], 20);
        
        add_shortcode('feedback_rating', [$this, 'render_feedback_widget']);
        add_shortcode('feedback_thumbs', [$this, 'render_thumbs_widget']);
        add_shortcode('feedback_stars', [$this, 'render_stars_widget']);
        
        add_filter('the_content', [$this, 'auto_append_widget']);

        add_action('init', [$this, 'register_gutenberg_block']);
        add_action('enqueue_block_editor_assets', [$this, 'enqueue_block_editor_assets']);

        add_action('wp_ajax_dfr_submit_vote', [$this, 'handle_vote']);
        add_action('wp_ajax_nopriv_dfr_submit_vote', [$this, 'handle_vote']);
        add_action('wp_ajax_dfr_get_stats', [$this, 'handle_get_stats']);
        add_action('wp_ajax_nopriv_dfr_get_stats', [$this, 'handle_get_stats']);

        if (is_admin()) {
            add_action('admin_menu', [$this, 'add_admin_menu']);
            add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
            add_action('add_meta_boxes', [$this, 'add_meta_box']);
        }

        add_action('rest_api_init', [$this, 'register_rest_routes']);
    }

    public function activate() {
        $default_options = [
            'rating_theme' => 'thumbs',
            'widget_theme' => 'light',
            'auto_append' => true,
            'post_types' => ['post'],
            'show_stats_bar' => true,
            'enable_schema' => true,
            'rate_limit_minutes' => 60,
            'email_alerts' => false,
            'alert_email' => get_option('admin_email'),
            'primary_color' => '#C4A35A',
            'positive_color' => '#51cf66',
            'neutral_color' => '#C4A35A',
            'negative_color' => '#ff6b6b',
            'border_radius' => '0',
            'button_style' => 'default',
            'custom_css' => '',
            
            // Icon-Upload
            'use_custom_icons' => false,
            'icon_positive' => '',
            'icon_neutral' => '',
            'icon_negative' => '',
            'icon_star_empty' => '',
            'icon_star_filled' => '',
            'icon_size' => '24',
            
            // Texte
            'text_title' => 'War dieser Artikel hilfreich?',
            'text_pos' => 'Hilfreich',
            'text_neu' => 'Neutral',
            'text_neg' => 'Nicht hilfreich',
            'text_saving' => 'Wird gespeichert...',
            'text_thanks' => 'Danke für dein Feedback!',
            'text_already_voted' => 'Du hast bereits abgestimmt.',
            'text_error' => 'Fehler beim Speichern.',
            'text_helpful_label' => 'hilfreich',
            'text_votes_label' => 'Bewertungen',
            'text_no_votes' => 'Noch keine Bewertungen',
            'text_be_first' => 'Sei der Erste!',
        ];
        
        if (!get_option('dfr_options')) {
            add_option('dfr_options', $default_options);
        } else {
            $existing = get_option('dfr_options');
            update_option('dfr_options', array_merge($default_options, $existing));
        }
        flush_rewrite_rules();
    }

    public function deactivate() {
        global $wpdb;
        $wpdb->query($wpdb->prepare(
            "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s",
            '_transient_' . self::CACHE_PREFIX . '%'
        ));
        flush_rewrite_rules();
    }

    public function register_gutenberg_block() {
        if (!function_exists('register_block_type')) return;

        register_block_type('dfr/feedback-rating', [
            'editor_script' => 'dfr-block-editor',
            'render_callback' => [$this, 'render_feedback_widget'],
            'attributes' => [
                'showStats' => ['type' => 'boolean', 'default' => true],
                'showShare' => ['type' => 'boolean', 'default' => true],
                'theme' => ['type' => 'string', 'default' => ''],
            ]
        ]);
    }

    public function enqueue_block_editor_assets() {
        wp_enqueue_script('dfr-block-editor', DFR_PLUGIN_URL . 'assets/js/block-editor.js', ['wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components'], DFR_VERSION, true);
        wp_enqueue_style('dfr-block-editor', DFR_PLUGIN_URL . 'assets/css/block-editor.css', [], DFR_VERSION);
    }

    public function enqueue_frontend_assets() {
        if (!$this->should_load_on_current_page()) return;

        $options = get_option('dfr_options', []);

        wp_enqueue_style('dfr-frontend', DFR_PLUGIN_URL . 'assets/css/frontend.css', [], DFR_VERSION);
        wp_enqueue_script('dfr-frontend', DFR_PLUGIN_URL . 'assets/js/frontend.js', ['jquery'], DFR_VERSION, true);

        wp_localize_script('dfr-frontend', 'dfrConfig', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('dfr_vote_nonce'),
            'postId' => get_the_ID(),
            'strings' => [
                'saving' => $options['text_saving'] ?? __('Wird gespeichert...', 'designare-feedback'),
                'thanks' => $options['text_thanks'] ?? __('Danke für dein Feedback!', 'designare-feedback'),
                'already_voted' => $options['text_already_voted'] ?? __('Du hast bereits abgestimmt.', 'designare-feedback'),
                'error' => $options['text_error'] ?? __('Fehler beim Speichern.', 'designare-feedback'),
                'helpful' => $options['text_helpful_label'] ?? __('hilfreich', 'designare-feedback'),
                'votes' => $options['text_votes_label'] ?? __('Bewertungen', 'designare-feedback'),
            ]
        ]);
    }

    public function inject_custom_styles() {
        if (!$this->should_load_on_current_page()) return;
        
        $options = get_option('dfr_options', []);
        $primary = $options['primary_color'] ?? '#C4A35A';
        $positive = $options['positive_color'] ?? '#51cf66';
        $neutral = $options['neutral_color'] ?? '#C4A35A';
        $negative = $options['negative_color'] ?? '#ff6b6b';
        $radius = $options['border_radius'] ?? '0';
        $style = $options['button_style'] ?? 'default';
        
        $btn_radius = $style === 'pill' ? '50px' : $radius . 'px';
        
        echo "<style>\n:root{--dfr-primary:{$primary};--dfr-positive:{$positive};--dfr-neutral:{$neutral};--dfr-negative:{$negative};--dfr-radius:{$radius}px;--dfr-btn-radius:{$btn_radius};}\n";
        
        if (!empty($options['custom_css'])) {
            echo wp_strip_all_tags($options['custom_css']) . "\n";
        }
        
        echo "</style>\n";
    }

    private function should_load_on_current_page() {
        if (!is_singular()) return false;
        $options = get_option('dfr_options', []);
        $post_types = $options['post_types'] ?? ['post'];
        return in_array(get_post_type(), $post_types);
    }

    public function inject_schema_json_ld() {
        if (!is_singular()) return;

        $options = get_option('dfr_options', []);
        if (empty($options['enable_schema'])) return;

        $post_types = $options['post_types'] ?? ['post'];
        if (!in_array(get_post_type(), $post_types)) return;

        $post_id = get_the_ID();
        $ratings = $this->get_ratings($post_id);
        $total = $ratings['positive'] + $ratings['neutral'] + $ratings['negative'];

        if ($total === 0) return;

        $score = ($ratings['positive'] * 5) + ($ratings['neutral'] * 3) + ($ratings['negative'] * 1);
        $average = round($score / $total, 1);

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title(),
            'url' => get_permalink(),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => ['@type' => 'Person', 'name' => get_the_author()],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => (string) $average,
                'bestRating' => '5',
                'worstRating' => '1',
                'ratingCount' => (string) $total,
            ]
        ];

        $schema = apply_filters('dfr_schema_json_ld', $schema, $post_id, $ratings);

        echo "\n<!-- Designare Feedback Ratings -->\n";
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }

    public function render_feedback_widget($atts = []) {
        $atts = shortcode_atts([
            'post_id' => get_the_ID(),
            'show_stats' => true,
            'showStats' => true,
            'show_share' => true,
            'showShare' => true,
            'theme' => '',
        ], $atts, 'feedback_rating');

        $atts['show_stats'] = $atts['show_stats'] && $atts['showStats'];
        $atts['show_share'] = $atts['show_share'] && $atts['showShare'];

        $post_id = intval($atts['post_id']);
        $options = get_option('dfr_options', []);
        
        if (!empty($atts['theme']) && in_array($atts['theme'], ['thumbs', 'stars'])) {
            $theme = $atts['theme'];
        } else {
            $theme = $options['rating_theme'] ?? 'thumbs';
        }
        
        $ratings = $this->get_ratings($post_id);
        $total = $ratings['positive'] + $ratings['neutral'] + $ratings['negative'];

        $percentages = [
            'positive' => $total > 0 ? round(($ratings['positive'] / $total) * 100) : 0,
            'neutral' => $total > 0 ? round(($ratings['neutral'] / $total) * 100) : 0,
            'negative' => $total > 0 ? round(($ratings['negative'] / $total) * 100) : 0,
        ];

        $score = ($ratings['positive'] * 5) + ($ratings['neutral'] * 3) + ($ratings['negative'] * 1);
        $average = $total > 0 ? round($score / $total, 1) : 0;

        ob_start();
        if ($theme === 'stars') {
            include DFR_PLUGIN_DIR . 'templates/feedback-widget-stars.php';
        } else {
            include DFR_PLUGIN_DIR . 'templates/feedback-widget.php';
        }
        return ob_get_clean();
    }

    public function render_thumbs_widget($atts = []) {
        $atts['theme'] = 'thumbs';
        return $this->render_feedback_widget($atts);
    }

    public function render_stars_widget($atts = []) {
        $atts['theme'] = 'stars';
        return $this->render_feedback_widget($atts);
    }

    public function auto_append_widget($content) {
        if (!is_singular() || !is_main_query() || !in_the_loop()) return $content;

        $options = get_option('dfr_options', []);
        if (empty($options['auto_append'])) return $content;

        $post_types = $options['post_types'] ?? ['post'];
        if (!in_array(get_post_type(), $post_types)) return $content;

        return $content . $this->render_feedback_widget();
    }

    public function handle_vote() {
        if (!empty($_POST['hp_field'])) {
            wp_send_json_error(['message' => 'Spam erkannt.'], 403);
        }

        if (!check_ajax_referer('dfr_vote_nonce', 'nonce', false)) {
            wp_send_json_error(['message' => 'Sicherheitscheck fehlgeschlagen.'], 403);
        }

        if ($this->is_rate_limited()) {
            wp_send_json_error(['message' => 'Bitte warte etwas.'], 429);
        }

        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $vote = isset($_POST['vote']) ? sanitize_text_field($_POST['vote']) : '';
        $star_rating = isset($_POST['star_rating']) ? intval($_POST['star_rating']) : 0;

        if (!$post_id) {
            wp_send_json_error(['message' => 'Ungültige Anfrage.'], 400);
        }

        if ($star_rating > 0) {
            if ($star_rating < 1 || $star_rating > 5) {
                wp_send_json_error(['message' => 'Ungültige Bewertung.'], 400);
            }
            if ($star_rating >= 4) $vote = 'positive';
            elseif ($star_rating >= 2) $vote = 'neutral';
            else $vote = 'negative';
        }

        if (!in_array($vote, ['positive', 'neutral', 'negative'])) {
            wp_send_json_error(['message' => 'Ungültige Anfrage.'], 400);
        }

        if (!get_post($post_id)) {
            wp_send_json_error(['message' => 'Beitrag nicht gefunden.'], 404);
        }

        $ratings = $this->get_ratings($post_id);
        $ratings[$vote]++;
        
        update_post_meta($post_id, self::META_KEY, $ratings);
        delete_transient(self::CACHE_PREFIX . $post_id);
        $this->set_rate_limit();

        if ($vote === 'negative') {
            $this->maybe_send_alert_email($post_id, $ratings);
        }

        $total = $ratings['positive'] + $ratings['neutral'] + $ratings['negative'];
        $percentages = [
            'positive' => $total > 0 ? round(($ratings['positive'] / $total) * 100) : 0,
            'neutral' => $total > 0 ? round(($ratings['neutral'] / $total) * 100) : 0,
            'negative' => $total > 0 ? round(($ratings['negative'] / $total) * 100) : 0,
        ];

        wp_send_json_success([
            'stats' => $ratings, 
            'total' => $total, 
            'percentages' => $percentages,
            'star_rating' => $star_rating
        ]);
    }

    public function handle_get_stats() {
        $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
        if (!$post_id) wp_send_json_error(['message' => 'Post ID fehlt.'], 400);

        $ratings = $this->get_ratings($post_id);
        $total = $ratings['positive'] + $ratings['neutral'] + $ratings['negative'];

        $percentages = [
            'positive' => $total > 0 ? round(($ratings['positive'] / $total) * 100) : 0,
            'neutral' => $total > 0 ? round(($ratings['neutral'] / $total) * 100) : 0,
            'negative' => $total > 0 ? round(($ratings['negative'] / $total) * 100) : 0,
        ];

        wp_send_json_success(['stats' => $ratings, 'total' => $total, 'percentages' => $percentages]);
    }

    private function maybe_send_alert_email($post_id, $ratings) {
        $options = get_option('dfr_options', []);
        if (empty($options['email_alerts'])) return;
        
        $email = $options['alert_email'] ?? get_option('admin_email');
        if (!is_email($email)) return;

        $post = get_post($post_id);
        $post_title = $post ? $post->post_title : "Post #$post_id";
        $post_url = get_permalink($post_id);
        
        $total = $ratings['positive'] + $ratings['neutral'] + $ratings['negative'];
        $neg_percent = $total > 0 ? round(($ratings['negative'] / $total) * 100) : 0;

        $subject = sprintf('[%s] Negatives Feedback: %s', get_bloginfo('name'), $post_title);
        
        $message = "Hallo,\n\n";
        $message .= "Ein Besucher hat negatives Feedback abgegeben:\n\n";
        $message .= "Beitrag: $post_title\n";
        $message .= "URL: $post_url\n\n";
        $message .= "Statistiken:\n";
        $message .= "Positiv: {$ratings['positive']} | Neutral: {$ratings['neutral']} | Negativ: {$ratings['negative']} ($neg_percent%)\n\n";
        $message .= "-- Designare Feedback Ratings";

        wp_mail($email, $subject, $message);
    }

    public function get_ratings($post_id) {
        $cache_key = self::CACHE_PREFIX . $post_id;
        $cached = get_transient($cache_key);
        if ($cached !== false) return $cached;

        $ratings = get_post_meta($post_id, self::META_KEY, true);
        if (!is_array($ratings)) $ratings = ['positive' => 0, 'neutral' => 0, 'negative' => 0];
        $ratings = wp_parse_args($ratings, ['positive' => 0, 'neutral' => 0, 'negative' => 0]);
        set_transient($cache_key, $ratings, self::CACHE_DURATION);

        return $ratings;
    }

    private function is_rate_limited() {
        $options = get_option('dfr_options', []);
        $limit_minutes = $options['rate_limit_minutes'] ?? 60;
        if ($limit_minutes <= 0) return false;
        return get_transient('dfr_ratelimit_' . $this->get_user_fingerprint()) !== false;
    }

    private function set_rate_limit() {
        $options = get_option('dfr_options', []);
        $limit_minutes = $options['rate_limit_minutes'] ?? 60;
        if ($limit_minutes <= 0) return;
        set_transient('dfr_ratelimit_' . $this->get_user_fingerprint(), time(), $limit_minutes * MINUTE_IN_SECONDS);
    }

    private function get_user_fingerprint() {
        return md5(($_SERVER['REMOTE_ADDR'] ?? '') . ($_SERVER['HTTP_USER_AGENT'] ?? ''));
    }

    public function add_admin_menu() {
        add_menu_page(__('Feedback Ratings', 'designare-feedback'), __('Feedback', 'designare-feedback'), 'manage_options', 'dfr-dashboard', [$this, 'render_dashboard_page'], 'dashicons-star-filled', 30);
        add_submenu_page('dfr-dashboard', __('Dashboard', 'designare-feedback'), __('Dashboard', 'designare-feedback'), 'manage_options', 'dfr-dashboard', [$this, 'render_dashboard_page']);
        add_submenu_page('dfr-dashboard', __('Einstellungen', 'designare-feedback'), __('Einstellungen', 'designare-feedback'), 'manage_options', 'dfr-settings', [$this, 'render_settings_page']);
    }

    public function enqueue_admin_assets($hook) {
        if ($hook === 'toplevel_page_dfr-dashboard') {
            wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js', [], '4.4.1', true);
            wp_enqueue_style('dfr-admin', DFR_PLUGIN_URL . 'assets/css/admin.css', [], DFR_VERSION);
            wp_enqueue_script('dfr-admin', DFR_PLUGIN_URL . 'assets/js/admin.js', ['chart-js', 'jquery'], DFR_VERSION, true);
            wp_localize_script('dfr-admin', 'dfrChartData', $this->get_chart_data());
        }
        if ($hook === 'feedback_page_dfr-settings' || $hook === 'post.php') {
            wp_enqueue_style('dfr-admin', DFR_PLUGIN_URL . 'assets/css/admin.css', [], DFR_VERSION);
            wp_enqueue_media();
        }
    }

    public function get_chart_data() {
        global $wpdb;
        $options = get_option('dfr_options', []);
        $post_types = $options['post_types'] ?? ['post'];
        $placeholders = implode(',', array_fill(0, count($post_types), '%s'));
        
        $posts = $wpdb->get_results($wpdb->prepare(
            "SELECT p.ID, p.post_title, pm.meta_value FROM {$wpdb->posts} p 
             INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id 
             WHERE pm.meta_key = %s AND p.post_type IN ($placeholders) AND p.post_status = 'publish'
             ORDER BY p.post_date DESC LIMIT 50",
            array_merge([self::META_KEY], $post_types)
        ));

        $labels = []; $positive = []; $neutral = []; $negative = []; $totals = [];
        $all_pos = 0; $all_neu = 0; $all_neg = 0;

        foreach ($posts as $post) {
            $ratings = maybe_unserialize($post->meta_value);
            if (!is_array($ratings)) continue;
            $total = ($ratings['positive'] ?? 0) + ($ratings['neutral'] ?? 0) + ($ratings['negative'] ?? 0);
            if ($total === 0) continue;

            $all_pos += $ratings['positive'] ?? 0;
            $all_neu += $ratings['neutral'] ?? 0;
            $all_neg += $ratings['negative'] ?? 0;

            $totals[] = ['id' => $post->ID, 'title' => $post->post_title, 'total' => $total, 'ratings' => $ratings];
        }

        usort($totals, fn($a, $b) => $b['total'] - $a['total']);
        $top10 = array_slice($totals, 0, 10);

        foreach ($top10 as $item) {
            $labels[] = wp_trim_words($item['title'], 4, '...');
            $positive[] = $item['ratings']['positive'] ?? 0;
            $neutral[] = $item['ratings']['neutral'] ?? 0;
            $negative[] = $item['ratings']['negative'] ?? 0;
        }

        $all_total = $all_pos + $all_neu + $all_neg;

        return [
            'labels' => $labels, 'positive' => $positive, 'neutral' => $neutral, 'negative' => $negative,
            'topPosts' => $top10,
            'summary' => [
                'total' => $all_total, 'positive' => $all_pos, 'neutral' => $all_neu, 'negative' => $all_neg,
                'avgRating' => $all_total > 0 ? round((($all_pos * 5) + ($all_neu * 3) + ($all_neg * 1)) / $all_total, 1) : 0,
            ]
        ];
    }

    public function add_meta_box() {
        $options = get_option('dfr_options', []);
        foreach (($options['post_types'] ?? ['post']) as $post_type) {
            add_meta_box('dfr_ratings_box', 'Feedback Ratings', [$this, 'render_meta_box'], $post_type, 'side', 'default');
        }
    }

    public function render_meta_box($post) {
        $ratings = $this->get_ratings($post->ID);
        $total = $ratings['positive'] + $ratings['neutral'] + $ratings['negative'];
        if ($total === 0) { echo '<p>Noch keine Bewertungen.</p>'; return; }
        $average = round((($ratings['positive'] * 5) + ($ratings['neutral'] * 3) + ($ratings['negative'] * 1)) / $total, 1);
        echo "<div class='dfr-meta-box'><p><strong>$average</strong> ⭐ ($total Bewertungen)</p>";
        echo "<ul><li>👍 {$ratings['positive']}</li><li>😐 {$ratings['neutral']}</li><li>👎 {$ratings['negative']}</li></ul></div>";
    }

    public function render_dashboard_page() { 
        $data = $this->get_chart_data();
        include DFR_PLUGIN_DIR . 'templates/dashboard-page.php'; 
    }

    public function render_settings_page() {
        // Icon Upload Handler
        if (isset($_POST['dfr_upload_icon'])) {
            check_admin_referer('dfr_upload_icon_nonce');
            
            if (!empty($_FILES['dfr_icon_file']['name'])) {
                $icon_type = sanitize_text_field($_POST['icon_type']);
                $uploaded = $this->handle_icon_upload($_FILES['dfr_icon_file'], $icon_type);
                
                if ($uploaded['success']) {
                    $options = get_option('dfr_options', []);
                    $options[$icon_type] = $uploaded['url'];
                    update_option('dfr_options', $options);
                    echo '<div class="notice notice-success is-dismissible"><p><strong>✓ Icon hochgeladen!</strong></p></div>';
                } else {
                    echo '<div class="notice notice-error is-dismissible"><p><strong>✗ Fehler:</strong> ' . esc_html($uploaded['error']) . '</p></div>';
                }
            }
        }
        
        // Icon löschen
        if (isset($_POST['dfr_delete_icon'])) {
            check_admin_referer('dfr_delete_icon_nonce');
            $icon_type = sanitize_text_field($_POST['icon_type']);
            $options = get_option('dfr_options', []);
            
            if (!empty($options[$icon_type])) {
                $attachment_id = attachment_url_to_postid($options[$icon_type]);
                if ($attachment_id) {
                    wp_delete_attachment($attachment_id, true);
                }
                $options[$icon_type] = '';
                update_option('dfr_options', $options);
                echo '<div class="notice notice-success is-dismissible"><p><strong>✓ Icon gelöscht!</strong></p></div>';
            }
        }
        
        // Settings speichern
        if (isset($_POST['dfr_save_settings'])) {
            if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'dfr_settings_nonce')) {
                wp_die('Sicherheitsprüfung fehlgeschlagen');
            }
            
            $existing_options = get_option('dfr_options', []);
            
            $options = [
                'rating_theme' => sanitize_text_field($_POST['rating_theme'] ?? 'thumbs'),
                'widget_theme' => sanitize_text_field($_POST['widget_theme'] ?? 'light'),
                'auto_append' => isset($_POST['auto_append']),
                'post_types' => isset($_POST['post_types']) ? array_map('sanitize_text_field', $_POST['post_types']) : ['post'],
                'show_stats_bar' => isset($_POST['show_stats_bar']),
                'enable_schema' => isset($_POST['enable_schema']),
                'rate_limit_minutes' => intval($_POST['rate_limit_minutes'] ?? 60),
                'email_alerts' => isset($_POST['email_alerts']),
                'alert_email' => sanitize_email($_POST['alert_email'] ?? ''),
                'primary_color' => sanitize_hex_color($_POST['primary_color'] ?? '#C4A35A'),
                'positive_color' => sanitize_hex_color($_POST['positive_color'] ?? '#51cf66'),
                'neutral_color' => sanitize_hex_color($_POST['neutral_color'] ?? '#C4A35A'),
                'negative_color' => sanitize_hex_color($_POST['negative_color'] ?? '#ff6b6b'),
                'border_radius' => intval($_POST['border_radius'] ?? 0),
                'button_style' => sanitize_text_field($_POST['button_style'] ?? 'default'),
                'custom_css' => wp_strip_all_tags($_POST['custom_css'] ?? ''),
                
                // Icon-Einstellungen
                'use_custom_icons' => isset($_POST['use_custom_icons']),
                'icon_size' => intval($_POST['icon_size'] ?? 24),
                'icon_positive' => $existing_options['icon_positive'] ?? '',
                'icon_neutral' => $existing_options['icon_neutral'] ?? '',
                'icon_negative' => $existing_options['icon_negative'] ?? '',
                'icon_star_empty' => $existing_options['icon_star_empty'] ?? '',
                'icon_star_filled' => $existing_options['icon_star_filled'] ?? '',
                
                // Texte
                'text_title' => sanitize_text_field($_POST['text_title'] ?? ''),
                'text_pos' => sanitize_text_field($_POST['text_pos'] ?? ''),
                'text_neu' => sanitize_text_field($_POST['text_neu'] ?? ''),
                'text_neg' => sanitize_text_field($_POST['text_neg'] ?? ''),
                'text_saving' => sanitize_text_field($_POST['text_saving'] ?? ''),
                'text_thanks' => sanitize_text_field($_POST['text_thanks'] ?? ''),
                'text_already_voted' => sanitize_text_field($_POST['text_already_voted'] ?? ''),
                'text_error' => sanitize_text_field($_POST['text_error'] ?? ''),
                'text_helpful_label' => sanitize_text_field($_POST['text_helpful_label'] ?? ''),
                'text_votes_label' => sanitize_text_field($_POST['text_votes_label'] ?? ''),
                'text_no_votes' => sanitize_text_field($_POST['text_no_votes'] ?? ''),
                'text_be_first' => sanitize_text_field($_POST['text_be_first'] ?? ''),
            ];
            update_option('dfr_options', $options);
            wp_cache_flush();
            echo '<div class="notice notice-success is-dismissible"><p><strong>✓ Einstellungen gespeichert!</strong></p></div>';
        }
        $options = get_option('dfr_options', []);
        include DFR_PLUGIN_DIR . 'templates/settings-page.php';
    }

    private function handle_icon_upload($file, $icon_type) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'Upload-Fehler'];
        }
        
        $allowed_types = ['image/svg+xml', 'image/png', 'image/jpeg', 'image/gif', 'image/webp'];
        
        if (!in_array($file['type'], $allowed_types)) {
            return ['success' => false, 'error' => 'Nur SVG, PNG, JPG, GIF und WebP erlaubt'];
        }
        
        if ($file['size'] > 500000) {
            return ['success' => false, 'error' => 'Datei zu groß (max. 500KB)'];
        }
        
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        
        $upload = wp_handle_upload($file, ['test_form' => false]);
        
        if (isset($upload['error'])) {
            return ['success' => false, 'error' => $upload['error']];
        }
        
        $attachment = [
            'post_mime_type' => $upload['type'],
            'post_title' => 'DFR Icon: ' . $icon_type,
            'post_content' => '',
            'post_status' => 'inherit'
        ];
        
        $attachment_id = wp_insert_attachment($attachment, $upload['file']);
        wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $upload['file']));
        
        return ['success' => true, 'url' => $upload['url'], 'id' => $attachment_id];
    }

    public function register_rest_routes() {
        register_rest_route('dfr/v1', '/ratings/(?P<id>\d+)', [
            'methods' => 'GET', 'callback' => [$this, 'rest_get_ratings'], 'permission_callback' => '__return_true',
        ]);
    }

    public function rest_get_ratings($request) {
        $post_id = $request['id'];
        $ratings = $this->get_ratings($post_id);
        $total = $ratings['positive'] + $ratings['neutral'] + $ratings['negative'];
        if ($total === 0) return new WP_REST_Response(['success' => true, 'stats' => $ratings, 'total' => 0, 'aggregateRating' => null], 200);
        $average = round((($ratings['positive'] * 5) + ($ratings['neutral'] * 3) + ($ratings['negative'] * 1)) / $total, 1);
        return new WP_REST_Response([
            'success' => true, 'stats' => $ratings, 'total' => $total,
            'aggregateRating' => ['@type' => 'AggregateRating', 'ratingValue' => (string)$average, 'bestRating' => '5', 'worstRating' => '1', 'ratingCount' => (string)$total]
        ], 200);
    }
}

add_action('plugins_loaded', fn() => Designare_Feedback_Ratings::get_instance());
