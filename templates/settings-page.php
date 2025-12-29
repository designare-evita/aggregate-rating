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

        <!-- Theme Auswahl -->
        <div class="dfr-card">
            <h2>Bewertungs-Theme</h2>
            <div class="dfr-field">
                <label>Welches Bewertungssystem möchtest du verwenden?</label>
                <div class="dfr-theme-selector">
                    <label class="dfr-theme-option <?php echo ($options['rating_theme'] ?? 'thumbs') === 'thumbs' ? 'dfr-theme-active' : ''; ?>">
                        <input type="radio" name="rating_theme" value="thumbs" <?php checked(($options['rating_theme'] ?? 'thumbs') === 'thumbs'); ?>>
                        <div class="dfr-theme-preview">
                            <div class="dfr-theme-icon">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 19V5M5 12l7-7 7 7"/>
                                </svg>
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14"/>
                                </svg>
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 5v14M5 12l7 7 7-7"/>
                                </svg>
                            </div>
                            <div class="dfr-theme-info">
                                <strong>Thumbs System</strong>
                                <span>3-Stufen Bewertung</span>
                                <small>Hilfreich / Neutral / Nicht hilfreich</small>
                            </div>
                        </div>
                    </label>
                    
                    <label class="dfr-theme-option <?php echo ($options['rating_theme'] ?? 'thumbs') === 'stars' ? 'dfr-theme-active' : ''; ?>">
                        <input type="radio" name="rating_theme" value="stars" <?php checked(($options['rating_theme'] ?? 'thumbs') === 'stars'); ?>>
                        <div class="dfr-theme-preview">
                            <div class="dfr-theme-icon">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                            </div>
                            <div class="dfr-theme-info">
                                <strong>Sterne System</strong>
                                <span>5-Stufen Bewertung</span>
                                <small>1 Stern bis 5 Sterne</small>
                            </div>
                        </div>
                    </label>
                </div>
                <p class="description" style="margin-top: 15px;">
                    <strong>Hinweis:</strong> Beide Systeme verwenden intern dieselbe Datenstruktur. 
                    Bei Sterne: 5-4★ = positiv, 3-2★ = neutral, 1★ = negativ. 
                    Du kannst jederzeit zwischen den Themes wechseln.
                </p>
            </div>
        </div>

        <!-- Allgemein -->
        <div class="dfr-card">
            <h2>Allgemeine Einstellungen</h2>
            
            <div class="dfr-field">
                <label>
                    <input type="checkbox" name="auto_append" value="1" <?php checked(!empty($options['auto_append'])); ?>>
                    Widget automatisch am Ende anzeigen
                </label>
                <p class="description">
                    Wenn aktiviert, wird das Widget automatisch am Ende aller ausgewählten Post-Typen angezeigt. 
                    Deaktivieren um stattdessen den Shortcode <code>[feedback_rating]</code> oder den Gutenberg Block zu nutzen.
                </p>
            </div>
            
            <div class="dfr-field">
                <label>Auf welchen Post-Typen soll das Widget erscheinen?</label>
                <div class="dfr-checkbox-list">
                    <?php foreach ($post_types as $pt) : 
                        if ($pt->name === 'attachment') continue; 
                    ?>
                    <label>
                        <input type="checkbox" name="post_types[]" value="<?php echo esc_attr($pt->name); ?>" 
                               <?php checked(in_array($pt->name, $selected_types)); ?>>
                        <?php echo esc_html($pt->labels->singular_name); ?>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="dfr-field">
                <label>
                    <input type="checkbox" name="show_stats_bar" value="1" <?php checked(!empty($options['show_stats_bar'])); ?>>
                    Statistik-Balken anzeigen
                </label>
                <p class="description">
                    Zeigt die prozentuale Verteilung der Bewertungen visuell an.
                </p>
            </div>
        </div>

        <!-- SEO -->
        <div class="dfr-card">
            <h2>SEO & Schema.org</h2>
            
            <div class="dfr-field">
                <label>
                    <input type="checkbox" name="enable_schema" value="1" <?php checked(!empty($options['enable_schema'])); ?>>
                    Schema.org AggregateRating generieren
                </label>
                <p class="description">
                    Aktiviert strukturierte Daten (JSON-LD) für Rich Snippets in Google. 
                    <strong>Kann die Click-Through-Rate um 15-25% steigern.</strong>
                </p>
            </div>
            
            <div class="dfr-info-box">
                <p><strong>📊 Was sind Rich Snippets?</strong></p>
                <p>Rich Snippets sind erweiterte Suchergebnisse in Google, die zusätzliche Informationen wie Sternebewertungen anzeigen. 
                Diese werden aus den strukturierten Daten generiert, die dieses Plugin automatisch erstellt.</p>
                <p><strong>Vorteile:</strong></p>
                <ul style="margin: 10px 0 0 20px;">
                    <li>Höhere Sichtbarkeit in Suchergebnissen</li>
                    <li>Vertrauenssignal für Besucher</li>
                    <li>Mehr Klicks ohne zusätzlichen SEO-Aufwand</li>
                </ul>
                <p style="margin-top: 10px;">
                    <strong>Tipp:</strong> Teste deine Seite mit dem 
                    <a href="https://search.google.com/test/rich-results" target="_blank" rel="noopener">Rich Results Test</a>
                </p>
            </div>
        </div>

        <!-- E-Mail Benachrichtigungen -->
        <div class="dfr-card">
            <h2>E-Mail Benachrichtigungen</h2>
            
            <div class="dfr-field">
                <label>
                    <input type="checkbox" name="email_alerts" value="1" <?php checked(!empty($options['email_alerts'])); ?>>
                    Bei negativem Feedback benachrichtigen
                </label>
                <p class="description">
                    Erhalte eine E-Mail, wenn ein Besucher eine negative Bewertung abgibt. 
                    So kannst du schnell auf Probleme reagieren.
                </p>
            </div>
            
            <div class="dfr-field">
                <label>E-Mail Adresse für Benachrichtigungen</label>
                <input type="email" 
                       name="alert_email" 
                       value="<?php echo esc_attr($options['alert_email'] ?? get_option('admin_email')); ?>"
                       placeholder="<?php echo esc_attr(get_option('admin_email')); ?>">
                <p class="description">
                    Standard: <?php echo esc_html(get_option('admin_email')); ?>
                </p>
            </div>
        </div>

        <!-- Spam-Schutz -->
        <div class="dfr-card">
            <h2>Spam-Schutz</h2>
            
            <div class="dfr-field">
                <label>Rate Limit (Minuten zwischen Abstimmungen)</label>
                <input type="number" 
                       name="rate_limit_minutes" 
                       value="<?php echo esc_attr($options['rate_limit_minutes'] ?? 60); ?>" 
                       min="0" 
                       max="1440" 
                       style="width:100px">
                <p class="description">
                    Wartezeit zwischen Abstimmungen derselben Person (basierend auf IP + User-Agent). 
                    <strong>0 = deaktiviert</strong>
                </p>
            </div>
            
            <div class="dfr-info-box" style="background: #f0f6fc; border-left-color: #2271b1;">
                <p><strong>🛡️ Automatischer Spam-Schutz ist aktiv</strong></p>
                <p>Das Plugin nutzt ein unsichtbares Honeypot-Feld, das Bots automatisch ausfüllen, während echte Besucher es nicht sehen. 
                Zusätzlich verhindert LocalStorage Mehrfach-Abstimmungen im selben Browser.</p>
                <p style="margin-top: 10px;"><strong>Aktive Schutzmechanismen:</strong></p>
                <ul style="margin: 5px 0 0 20px;">
                    <li>Honeypot-Feld (unsichtbar für Menschen)</li>
                    <li>LocalStorage-Prüfung</li>
                    <li>Rate Limiting (IP + User-Agent)</li>
                    <li>WordPress Nonce-Validierung</li>
                </ul>
            </div>
        </div>

        <!-- Design -->
        <div class="dfr-card">
            <h2>Design & Farben</h2>
            
            <div class="dfr-field">
                <label>Farbschema</label>
                <div class="dfr-color-row">
                    <div class="dfr-color-field">
                        <label>Akzentfarbe</label>
                        <input type="color" 
                               name="primary_color" 
                               value="<?php echo esc_attr($options['primary_color'] ?? '#C4A35A'); ?>">
                        <span class="dfr-color-value"><?php echo esc_html($options['primary_color'] ?? '#C4A35A'); ?></span>
                    </div>
                    <div class="dfr-color-field">
                        <label>Positiv</label>
                        <input type="color" 
                               name="positive_color" 
                               value="<?php echo esc_attr($options['positive_color'] ?? '#51cf66'); ?>">
                        <span class="dfr-color-value"><?php echo esc_html($options['positive_color'] ?? '#51cf66'); ?></span>
                    </div>
                    <div class="dfr-color-field">
                        <label>Neutral</label>
                        <input type="color" 
                               name="neutral_color" 
                               value="<?php echo esc_attr($options['neutral_color'] ?? '#C4A35A'); ?>">
                        <span class="dfr-color-value"><?php echo esc_html($options['neutral_color'] ?? '#C4A35A'); ?></span>
                    </div>
                    <div class="dfr-color-field">
                        <label>Negativ</label>
                        <input type="color" 
                               name="negative_color" 
                               value="<?php echo esc_attr($options['negative_color'] ?? '#ff6b6b'); ?>">
                        <span class="dfr-color-value"><?php echo esc_html($options['negative_color'] ?? '#ff6b6b'); ?></span>
                    </div>
                </div>
            </div>
            
            <div class="dfr-field">
                <label>Border Radius (Ecken-Abrundung in Pixel)</label>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <input type="range" 
                           name="border_radius" 
                           id="dfr-border-radius-slider"
                           value="<?php echo esc_attr($options['border_radius'] ?? 0); ?>" 
                           min="0" 
                           max="50" 
                           style="width: 200px;">
                    <input type="number" 
                           name="border_radius" 
                           id="dfr-border-radius-input"
                           value="<?php echo esc_attr($options['border_radius'] ?? 0); ?>" 
                           min="0" 
                           max="50" 
                           style="width: 70px;">
                    <span>px</span>
                </div>
                <p class="description">
                    0 = eckig, 50 = sehr rund. Aktuell: <strong id="dfr-radius-preview"><?php echo esc_html($options['border_radius'] ?? 0); ?>px</strong>
                </p>
            </div>
            
            <div class="dfr-field">
                <label>Button-Stil</label>
                <div class="dfr-style-options">
                    <label>
                        <input type="radio" name="button_style" value="default" 
                               <?php checked(($options['button_style'] ?? 'default') === 'default'); ?>>
                        <span>Standard</span>
                    </label>
                    <label>
                        <input type="radio" name="button_style" value="minimal" 
                               <?php checked(($options['button_style'] ?? '') === 'minimal'); ?>>
                        <span>Minimal</span>
                    </label>
                    <label>
                        <input type="radio" name="button_style" value="pill" 
                               <?php checked(($options['button_style'] ?? '') === 'pill'); ?>>
                        <span>Pill (Runde Buttons)</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Texte & Lokalisierung -->
        <div class="dfr-card">
            <h2>Texte & Lokalisierung</h2>
            <p class="description" style="margin:0 0 20px;color:#666;">
                Passe alle Texte an deine Sprache und Zielgruppe an. Perfekt für mehrsprachige Websites.
            </p>
            
            <div class="dfr-field">
                <label>Widget-Titel</label>
                <input type="text" 
                       name="text_title" 
                       value="<?php echo esc_attr($options['text_title'] ?? 'War dieser Artikel hilfreich?'); ?>" 
                       placeholder="War dieser Artikel hilfreich?"
                       style="width:100%;max-width:500px">
                <p class="description">
                    Der Haupttext über den Bewertungs-Buttons
                </p>
            </div>
            
            <div class="dfr-field">
                <label>Button-Beschriftungen</label>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:15px;margin-top:10px;">
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">
                            👍 Positiv
                        </label>
                        <input type="text" 
                               name="text_pos" 
                               value="<?php echo esc_attr($options['text_pos'] ?? 'Hilfreich'); ?>" 
                               placeholder="Hilfreich"
                               style="width:100%">
                    </div>
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">
                            😐 Neutral
                        </label>
                        <input type="text" 
                               name="text_neu" 
                               value="<?php echo esc_attr($options['text_neu'] ?? 'Neutral'); ?>" 
                               placeholder="Neutral"
                               style="width:100%">
                    </div>
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">
                            👎 Negativ
                        </label>
                        <input type="text" 
                               name="text_neg" 
                               value="<?php echo esc_attr($options['text_neg'] ?? 'Nicht hilfreich'); ?>" 
                               placeholder="Nicht hilfreich"
                               style="width:100%">
                    </div>
                </div>
                <p class="description">
                    Diese Texte werden nur im <strong>Thumbs Theme</strong> verwendet
                </p>
            </div>
            
            <div class="dfr-field">
                <label>Feedback-Meldungen</label>
                <div style="display:grid;gap:12px;margin-top:10px;">
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">
                            ⏳ Während Speicherung
                        </label>
                        <input type="text" 
                               name="text_saving" 
                               value="<?php echo esc_attr($options['text_saving'] ?? 'Wird gespeichert...'); ?>" 
                               placeholder="Wird gespeichert..."
                               style="width:100%;max-width:500px">
                    </div>
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">
                            ✅ Erfolgsmeldung
                        </label>
                        <input type="text" 
                               name="text_thanks" 
                               value="<?php echo esc_attr($options['text_thanks'] ?? 'Danke für dein Feedback!'); ?>" 
                               placeholder="Danke für dein Feedback!"
                               style="width:100%;max-width:500px">
                    </div>
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">
                            ℹ️ Bereits abgestimmt
                        </label>
                        <input type="text" 
                               name="text_already_voted" 
                               value="<?php echo esc_attr($options['text_already_voted'] ?? 'Du hast bereits abgestimmt.'); ?>" 
                               placeholder="Du hast bereits abgestimmt."
                               style="width:100%;max-width:500px">
                    </div>
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">
                            ❌ Fehlermeldung
                        </label>
                        <input type="text" 
                               name="text_error" 
                               value="<?php echo esc_attr($options['text_error'] ?? 'Fehler beim Speichern.'); ?>" 
                               placeholder="Fehler beim Speichern."
                               style="width:100%;max-width:500px">
                    </div>
                </div>
            </div>
            
            <div class="dfr-field">
                <label>Statistik-Labels</label>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:15px;margin-top:10px;">
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">
                            Label: % hilfreich
                        </label>
                        <input type="text" 
                               name="text_helpful_label" 
                               value="<?php echo esc_attr($options['text_helpful_label'] ?? 'hilfreich'); ?>" 
                               placeholder="hilfreich"
                               style="width:100%">
                    </div>
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">
                            Label: Bewertungen
                        </label>
                        <input type="text" 
                               name="text_votes_label" 
                               value="<?php echo esc_attr($options['text_votes_label'] ?? 'Bewertungen'); ?>" 
                               placeholder="Bewertungen"
                               style="width:100%">
                    </div>
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">
                            Keine Bewertungen
                        </label>
                        <input type="text" 
                               name="text_no_votes" 
                               value="<?php echo esc_attr($options['text_no_votes'] ?? 'Noch keine Bewertungen'); ?>" 
                               placeholder="Noch keine Bewertungen"
                               style="width:100%">
                    </div>
                    <div>
                        <label style="font-size:0.8rem;color:#666;display:block;margin-bottom:5px;">
                            Sei der Erste
                        </label>
                        <input type="text" 
                               name="text_be_first" 
                               value="<?php echo esc_attr($options['text_be_first'] ?? 'Sei der Erste!'); ?>" 
                               placeholder="Sei der Erste!"
                               style="width:100%">
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom CSS -->
        <div class="dfr-card">
            <h2>Individuelles CSS</h2>
            
            <div class="dfr-field">
                <label>Custom CSS Code</label>
                <textarea name="custom_css" 
                          rows="12" 
                          placeholder="/* Dein eigenes CSS hier einfügen */
.dfr-feedback-section {
    /* Anpassungen */
}"
                          style="width:100%;font-family:monospace;font-size:13px;background:#1e1e1e;color:#d4d4d4;padding:15px;border:1px solid #333;border-radius:4px;"><?php echo esc_textarea($options['custom_css'] ?? ''); ?></textarea>
                <p class="description">
                    Füge hier eigenes CSS ein, um das Widget perfekt an dein Theme anzupassen. 
                    Nutze CSS-Variablen wie <code>var(--dfr-primary)</code> für konsistente Farben.
                </p>
            </div>
            
            <details style="margin-top: 15px;">
                <summary style="cursor: pointer; font-weight: 500; color: #2271b1;">
                    💡 CSS-Beispiele anzeigen
                </summary>
                <div style="margin-top: 15px;">
                    <p><strong>Beispiel 1: Gradient Background</strong></p>
                    <pre style="background:#1e1e1e;color:#d4d4d4;padding:15px;overflow-x:auto;font-size:12px;border-radius:4px;margin:10px 0;">.dfr-feedback-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}</pre>

                    <p><strong>Beispiel 2: Glassmorphism</strong></p>
                    <pre style="background:#1e1e1e;color:#d4d4d4;padding:15px;overflow-x:auto;font-size:12px;border-radius:4px;margin:10px 0;">.dfr-feedback-section {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}</pre>

                    <p><strong>Beispiel 3: Button Styling</strong></p>
                    <pre style="background:#1e1e1e;color:#d4d4d4;padding:15px;overflow-x:auto;font-size:12px;border-radius:4px;margin:10px 0;">.dfr-rating-btn {
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 12px 24px;
}

.dfr-rating-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}</pre>
                </div>
            </details>
        </div>

        <!-- Verwendung -->
        <div class="dfr-card">
            <h2>Verwendung & Integration</h2>
            
            <div class="dfr-field">
                <label>Shortcode (manuell einfügen)</label>
                <div class="dfr-shortcode-preview">
                    <code>[feedback_rating]</code>
                </div>
                <p class="description">
                    Kopiere diesen Shortcode und füge ihn in jeden Beitrag oder jede Seite ein, wo du das Widget anzeigen möchtest.
                </p>
            </div>
            
            <div class="dfr-field">
                <label>Shortcode mit Optionen</label>
                <div class="dfr-shortcode-preview">
                    <code>[feedback_rating show_stats="false" show_share="false"]</code>
                </div>
                <p class="description">
                    <strong>Verfügbare Parameter:</strong><br>
                    • <code>show_stats</code> - Statistik-Balken anzeigen (true/false)<br>
                    • <code>show_share</code> - Share-Buttons anzeigen (true/false)<br>
                    • <code>post_id</code> - Spezifische Post-ID (optional)
                </p>
            </div>
            
            <div class="dfr-field">
                <label>Gutenberg Block</label>
                <p class="description" style="margin: 0;">
                    Im Block-Editor nach <strong>"Feedback Rating"</strong> suchen und einfügen. 
                    Der Block bietet dieselben Optionen wie der Shortcode, aber mit visueller Oberfläche.
                </p>
            </div>
            
            <div class="dfr-field">
                <label>PHP-Code (für Theme-Entwickler)</label>
                <div class="dfr-shortcode-preview">
                    <code>&lt;?php echo do_shortcode('[feedback_rating]'); ?&gt;</code>
                </div>
                <p class="description">
                    Füge das Widget programmatisch in deine Theme-Templates ein.
                </p>
            </div>
        </div>

        <!-- Speichern -->
        <p class="submit">
            <button type="submit" name="dfr_save_settings" class="button button-primary button-large">
                💾 Einstellungen speichern
            </button>
            <a href="<?php echo admin_url('admin.php?page=dfr-dashboard'); ?>" class="button button-secondary" style="margin-left: 10px;">
                📊 Zum Dashboard
            </a>
        </p>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    // Border Radius Slider Sync
    $('#dfr-border-radius-slider').on('input', function() {
        var val = $(this).val();
        $('#dfr-border-radius-input').val(val);
        $('#dfr-radius-preview').text(val + 'px');
    });
    
    $('#dfr-border-radius-input').on('input', function() {
        var val = $(this).val();
        $('#dfr-border-radius-slider').val(val);
        $('#dfr-radius-preview').text(val + 'px');
    });
    
    // Theme Selection Animation
    $('.dfr-theme-option input[type="radio"]').on('change', function() {
        $('.dfr-theme-option').removeClass('dfr-theme-active');
        $(this).closest('.dfr-theme-option').addClass('dfr-theme-active');
    });
    
    // Color Value Display
    $('input[type="color"]').on('input', function() {
        $(this).siblings('.dfr-color-value').text($(this).val());
    });
});
</script>

<style>
/* Theme Selector */
.dfr-theme-selector {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 15px;
}

.dfr-theme-option {
    position: relative;
    cursor: pointer;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    transition: all 0.3s ease;
    background: #fff;
}

.dfr-theme-option:hover {
    border-color: #2271b1;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.dfr-theme-option.dfr-theme-active {
    border-color: #2271b1;
    background: #f0f6fc;
}

.dfr-theme-option input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.dfr-theme-preview {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.dfr-theme-icon {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    padding: 20px;
    background: #fafafa;
    border-radius: 6px;
    min-height: 80px;
}

.dfr-theme-option.dfr-theme-active .dfr-theme-icon {
    background: #e3f2fd;
}

.dfr-theme-icon svg {
    color: #666;
}

.dfr-theme-option.dfr-theme-active .dfr-theme-icon svg {
    color: #2271b1;
}

.dfr-theme-info {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.dfr-theme-info strong {
    font-size: 1.1rem;
    color: #1d2327;
}

.dfr-theme-info span {
    color: #666;
    font-size: 0.9rem;
}

.dfr-theme-info small {
    color: #999;
    font-size: 0.8rem;
}

/* Color Fields Enhancement */
.dfr-color-value {
    display: block;
    text-align: center;
    font-size: 0.75rem;
    color: #666;
    margin-top: 5px;
    font-family: monospace;
}

/* Shortcode Preview Enhancement */
.dfr-shortcode-preview {
    position: relative;
}

.dfr-shortcode-preview code {
    user-select: all;
}
</style>
