<?php if (!defined('ABSPATH')) exit;
$post_types = get_post_types(['public' => true], 'objects');
$selected_types = $options['post_types'] ?? ['post'];
?>
<div class="wrap dfr-settings-wrap">
    <h1>
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:#666">
            <circle cx="12" cy="12" r="3"/>
            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
        </svg>
        Einstellungen
    </h1>
    <form method="post">
        <?php wp_nonce_field('dfr_settings_nonce'); ?>

        <div class="dfr-card">
            <h2>Allgemein</h2>
            <div class="dfr-field">
                <label><input type="checkbox" name="auto_append" value="1" <?php checked(!empty($options['auto_append'])); ?>> Widget automatisch am Ende anzeigen</label>
                <p class="description">Deaktivieren um Shortcode [feedback_rating] oder Gutenberg Block zu nutzen.</p>
            </div>
            <div class="dfr-field">
                <label>Post-Typen</label>
                <div class="dfr-checkbox-list">
                    <?php foreach ($post_types as $pt) : if ($pt->name === 'attachment') continue; ?>
                    <label><input type="checkbox" name="post_types[]" value="<?php echo esc_attr($pt->name); ?>" <?php checked(in_array($pt->name, $selected_types)); ?>> <?php echo esc_html($pt->labels->singular_name); ?></label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="dfr-field">
                <label><input type="checkbox" name="show_stats_bar" value="1" <?php checked(!empty($options['show_stats_bar'])); ?>> Statistik-Balken anzeigen</label>
            </div>
        </div>

        <div class="dfr-card">
            <h2>SEO</h2>
            <div class="dfr-field">
                <label><input type="checkbox" name="enable_schema" value="1" <?php checked(!empty($options['enable_schema'])); ?>> Schema.org AggregateRating generieren</label>
                <p class="description">Aktiviert Rich Snippets in Google. Kann die CTR um 15-25% steigern.</p>
            </div>
        </div>

        <div class="dfr-card">
            <h2>E-Mail Benachrichtigungen</h2>
            <div class="dfr-field">
                <label><input type="checkbox" name="email_alerts" value="1" <?php checked(!empty($options['email_alerts'])); ?>> Bei negativem Feedback benachrichtigen</label>
            </div>
            <div class="dfr-field">
                <label>E-Mail Adresse</label>
                <input type="email" name="alert_email" value="<?php echo esc_attr($options['alert_email'] ?? get_option('admin_email')); ?>">
            </div>
        </div>

        <div class="dfr-card">
            <h2>Spam-Schutz</h2>
            <div class="dfr-field">
                <label>Rate Limit (Minuten)</label>
                <input type="number" name="rate_limit_minutes" value="<?php echo esc_attr($options['rate_limit_minutes'] ?? 60); ?>" min="0" max="1440" style="width:80px">
                <p class="description">Wartezeit zwischen Abstimmungen. 0 = deaktiviert.</p>
            </div>
        </div>

        <div class="dfr-card">
            <h2>Design</h2>
            <div class="dfr-color-row">
                <div class="dfr-color-field">
                    <label>Akzent</label>
                    <input type="color" name="primary_color" value="<?php echo esc_attr($options['primary_color'] ?? '#C4A35A'); ?>">
                </div>
                <div class="dfr-color-field">
                    <label>Positiv</label>
                    <input type="color" name="positive_color" value="<?php echo esc_attr($options['positive_color'] ?? '#51cf66'); ?>">
                </div>
                <div class="dfr-color-field">
                    <label>Neutral</label>
                    <input type="color" name="neutral_color" value="<?php echo esc_attr($options['neutral_color'] ?? '#C4A35A'); ?>">
                </div>
                <div class="dfr-color-field">
                    <label>Negativ</label>
                    <input type="color" name="negative_color" value="<?php echo esc_attr($options['negative_color'] ?? '#ff6b6b'); ?>">
                </div>
            </div>
            <div class="dfr-field">
                <label>Border Radius (px)</label>
                <input type="number" name="border_radius" value="<?php echo esc_attr($options['border_radius'] ?? 0); ?>" min="0" max="50" style="width:80px">
            </div>
            <div class="dfr-field">
                <label>Button-Stil</label>
                <div class="dfr-style-options">
                    <label><input type="radio" name="button_style" value="default" <?php checked(($options['button_style'] ?? 'default') === 'default'); ?>> <span>Standard</span></label>
                    <label><input type="radio" name="button_style" value="minimal" <?php checked(($options['button_style'] ?? '') === 'minimal'); ?>> <span>Minimal</span></label>
                    <label><input type="radio" name="button_style" value="pill" <?php checked(($options['button_style'] ?? '') === 'pill'); ?>> <span>Pill</span></label>
                </div>
            </div>
        </div>

        <div class="dfr-card">
            <h2>Verwendung</h2>
            <p style="margin:0 0 10px;color:#666;font-size:0.9rem;">Shortcode:</p>
            <div class="dfr-shortcode-preview">[feedback_rating]</div>
            <p style="margin:15px 0 10px;color:#666;font-size:0.9rem;">Mit Optionen:</p>
            <div class="dfr-shortcode-preview">[feedback_rating show_stats="false" show_share="false"]</div>
            <p style="margin:15px 0 0;color:#666;font-size:0.9rem;"><strong>Gutenberg:</strong> Block "Feedback Rating" im Editor suchen.</p>
        </div>

        <p class="submit">
            <button type="submit" name="dfr_save_settings" class="button button-primary">Speichern</button>
        </p>
    </form>
</div>
