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
                <p class="description">Wartezeit zwischen Abstimmungen. 0 = deaktiviert. <strong>Honeypot-Schutz ist immer aktiv.</strong></p>
            </div>
            <div class="dfr-info-box">
                <p><strong>🛡️ Automatischer Spam-Schutz aktiv</strong><br>
                Das Plugin nutzt ein unsichtbares Honeypot-Feld, das Bots automatisch ausfüllen, während echte Besucher es nicht sehen. Spam-Votes werden automatisch blockiert.</p>
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
            <h2>Texte & Lokalisierung</h2>
            <p class="description" style="margin:0 0 20px;color:#666;">Passe alle Texte an deine Sprache und Zielgruppe an.</p>
            
            <div class="dfr-field">
                <label>Widget-Titel</label>
                <input type="text" name="text_title" value="<?php echo esc_attr($options['text_title'] ?? 'War dieser Artikel hilfreich?'); ?>" style="width:100%;max-width:500px">
                <p class="description">Standard: "War dieser Artikel hilfreich?"</p>
            </div>

            <div class="dfr-card">
    <h2>Theme</h2>
    <div class="dfr-field">
        <label>Bewertungssystem</label>
        <div class="dfr-style-options">
            <label>
                <input type="radio" name="rating_theme" value="thumbs" <?php checked(($options['rating_theme'] ?? 'thumbs') === 'thumbs'); ?>>
                <span>👍 Thumbs (3 Stufen)</span>
            </label>
            <label>
                <input type="radio" name="rating_theme" value="stars" <?php checked(($options['rating_theme'] ?? 'thumbs') === 'stars'); ?>>
                <span>⭐ Sterne (5 Stufen)</span>
            </label>
        </div>
        <p class="description">Thumbs = Hilfreich/Neutral/Nicht hilfreich | Sterne = 1-5 Sterne Bewertung</p>
    </div>
</div>
            
            
            <div class="dfr-field">
                <label>Button-Texte</label>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:15px;margin-top:10px;">
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">Positiv</label>
                        <input type="text" name="text_pos" value="<?php echo esc_attr($options['text_pos'] ?? 'Hilfreich'); ?>" style="width:100%">
                    </div>
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">Neutral</label>
                        <input type="text" name="text_neu" value="<?php echo esc_attr($options['text_neu'] ?? 'Neutral'); ?>" style="width:100%">
                    </div>
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">Negativ</label>
                        <input type="text" name="text_neg" value="<?php echo esc_attr($options['text_neg'] ?? 'Nicht hilfreich'); ?>" style="width:100%">
                    </div>
                </div>
            </div>
            
            <div class="dfr-field">
                <label>Feedback-Meldungen</label>
                <div style="display:grid;gap:10px;margin-top:10px;">
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">Während Speicherung</label>
                        <input type="text" name="text_saving" value="<?php echo esc_attr($options['text_saving'] ?? 'Wird gespeichert...'); ?>" style="width:100%;max-width:500px">
                    </div>
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">Erfolgsmeldung (Danke)</label>
                        <input type="text" name="text_thanks" value="<?php echo esc_attr($options['text_thanks'] ?? 'Danke für dein Feedback!'); ?>" style="width:100%;max-width:500px">
                    </div>
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">Bereits abgestimmt</label>
                        <input type="text" name="text_already_voted" value="<?php echo esc_attr($options['text_already_voted'] ?? 'Du hast bereits abgestimmt.'); ?>" style="width:100%;max-width:500px">
                    </div>
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">Fehlermeldung</label>
                        <input type="text" name="text_error" value="<?php echo esc_attr($options['text_error'] ?? 'Fehler beim Speichern.'); ?>" style="width:100%;max-width:500px">
                    </div>
                </div>
            </div>
            
            <div class="dfr-field">
                <label>Statistik-Labels</label>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:15px;margin-top:10px;">
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">Label: % hilfreich</label>
                        <input type="text" name="text_helpful_label" value="<?php echo esc_attr($options['text_helpful_label'] ?? 'hilfreich'); ?>" style="width:100%">
                    </div>
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">Label: Bewertungen</label>
                        <input type="text" name="text_votes_label" value="<?php echo esc_attr($options['text_votes_label'] ?? 'Bewertungen'); ?>" style="width:100%">
                    </div>
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">Keine Bewertungen</label>
                        <input type="text" name="text_no_votes" value="<?php echo esc_attr($options['text_no_votes'] ?? 'Noch keine Bewertungen'); ?>" style="width:100%">
                    </div>
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">Sei der Erste</label>
                        <input type="text" name="text_be_first" value="<?php echo esc_attr($options['text_be_first'] ?? 'Sei der Erste!'); ?>" style="width:100%">
                    </div>
                </div>
            </div>
        </div>

        <div class="dfr-card">
            <h2>Individuelles CSS</h2>
            <div class="dfr-field">
                <label>Custom CSS</label>
                <textarea name="custom_css" rows="10" style="width:100%;font-family:monospace;font-size:13px;background:#1e1e1e;color:#d4d4d4;padding:15px;border:1px solid #333;border-radius:4px;"><?php echo esc_textarea($options['custom_css'] ?? ''); ?></textarea>
                <p class="description">Hier kannst du eigenes CSS einfügen, um das Widget perfekt an dein Theme anzupassen. Nutze CSS-Variablen wie <code>var(--dfr-primary)</code> für konsistente Farben.</p>
            </div>
            <div class="dfr-info-box">
                <p><strong>💡 Beispiel-CSS:</strong></p>
                <pre style="background:#1e1e1e;color:#d4d4d4;padding:15px;overflow-x:auto;font-size:12px;border-radius:4px;margin:10px 0 0;">.dfr-feedback-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}

.dfr-rating-btn {
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}</pre>
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
            <button type="submit" name="dfr_save_settings" class="button button-primary">Einstellungen speichern</button>
        </p>
    </form>
</div>
