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
                <p><strong>Was sind Rich Snippets?</strong></p>
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

        <!-- Dark Mode -->
        <div class="dfr-card">
            <h2>🌓 Dark Mode</h2>
            
            <div class="dfr-field">
                <label>Widget-Theme</label>
                <div class="dfr-style-options">
                    <label>
                        <input type="radio" name="widget_theme" value="light" 
                               <?php checked(($options['widget_theme'] ?? 'light') === 'light'); ?>>
                        <span>☀️ Hell (Standard)</span>
                    </label>
                    <label>
                        <input type="radio" name="widget_theme" value="dark" 
                               <?php checked(($options['widget_theme'] ?? '') === 'dark'); ?>>
                        <span>🌙 Dunkel</span>
                    </label>
                    <label>
                        <input type="radio" name="widget_theme" value="auto" 
                               <?php checked(($options['widget_theme'] ?? '') === 'auto'); ?>>
                        <span>🔄 Automatisch (System-Einstellung)</span>
                    </label>
                </div>
                <p class="description">
                    <strong>Hell:</strong> Widget hat immer hellen Hintergrund<br>
                    <strong>Dunkel:</strong> Widget hat immer dunklen Hintergrund<br>
                    <strong>Automatisch:</strong> Passt sich an die System-Einstellung des Besuchers an (Dark Mode)
                </p>
            </div>
            
            <div class="dfr-info-box" style="background:#2c3338;border-left-color:#C4A35A;color:#e0e0e0;margin-top:20px;">
                <p style="color:#fff;"><strong>💡 Dark Mode Vorschau</strong></p>
                <p style="color:#ddd;">
                    Im Dark Mode werden folgende Farben verwendet:<br>
                    • Hintergrund: Dunkelgrau (#1e1e1e)<br>
                    • Text: Hellgrau (#e0e0e0)<br>
                    • Buttons: Dunkler mit farbigen Hover-Effekten<br>
                    • Deine gewählten Akzentfarben bleiben erhalten
                </p>
            </div>
        </div>
        

        <!-- Icons & Grafiken -->
        <div class="dfr-card">
            <h2>Icons & Grafiken</h2>
            
            <div class="dfr-field">
                <label>
                    <input type="checkbox" name="use_custom_icons" value="1" <?php checked(!empty($options['use_custom_icons'])); ?>>
                    Eigene Icons verwenden (statt Standard-SVG)
                </label>
                <p class="description">
                    Lade deine eigenen Icons als SVG, PNG, JPG, GIF oder WebP hoch (max. 500KB pro Icon).
                </p>
            </div>
            
            <div class="dfr-field">
                <label>Icon-Größe (Pixel)</label>
                <input type="number" 
                       name="icon_size" 
                       value="<?php echo esc_attr($options['icon_size'] ?? 24); ?>" 
                       min="16" 
                       max="128" 
                       style="width:100px">
                <p class="description">Standard: 24px. Empfohlen: 16-48px</p>
            </div>
            
            <?php if (!empty($options['use_custom_icons'])) : ?>
            
            <div class="dfr-info-box" style="background:#fff3cd;border-left-color:#ffc107;margin:20px 0;">
                <p><strong>💡 Icon-Tipps:</strong></p>
                <ul style="margin:10px 0 0 20px;">
                    <li><strong>SVG</strong> - Empfohlen! Skaliert perfekt, kleine Dateigröße</li>
                    <li><strong>PNG</strong> - Mit transparentem Hintergrund, 2x Größe für Retina</li>
                    <li><strong>Optimierung</strong> - Nutze Tools wie SVGOMG oder TinyPNG</li>
                    <li><strong>Farbig oder Monochrom</strong> - Bei Monochrom färbt CSS automatisch ein</li>
                </ul>
            </div>
            
            <!-- Thumbs Icons -->
            <div class="dfr-icons-section" style="margin-top:30px;padding-top:30px;border-top:2px solid #f0f0f0;">
                <h3 style="margin:0 0 20px;font-size:0.95rem;color:#666;text-transform:uppercase;letter-spacing:0.05em;">
                    👍 Thumbs-System Icons
                </h3>
                
                <?php 
                $thumbs_icons = [
                    'icon_positive' => ['label' => 'Positiv (Daumen hoch)', 'emoji' => '👍'],
                    'icon_neutral' => ['label' => 'Neutral (Horizontal)', 'emoji' => '😐'],
                    'icon_negative' => ['label' => 'Negativ (Daumen runter)', 'emoji' => '👎']
                ];
                
                foreach ($thumbs_icons as $icon_key => $icon_data) :
                    $current_icon = $options[$icon_key] ?? '';
                ?>
                <div class="dfr-icon-upload-row">
                    <div class="dfr-icon-info">
                        <strong><?php echo $icon_data['emoji']; ?> <?php echo esc_html($icon_data['label']); ?></strong>
                        <?php if ($current_icon) : ?>
                            <div class="dfr-icon-preview">
                                <img src="<?php echo esc_url($current_icon); ?>" alt="<?php echo esc_attr($icon_data['label']); ?>" style="max-width:48px;max-height:48px;">
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="dfr-icon-actions">
                        <form method="post" enctype="multipart/form-data" style="display:inline-block;">
                            <?php wp_nonce_field('dfr_upload_icon_nonce'); ?>
                            <input type="hidden" name="icon_type" value="<?php echo esc_attr($icon_key); ?>">
                            <input type="file" name="dfr_icon_file" accept=".svg,.png,.jpg,.jpeg,.gif,.webp" required style="font-size:0.85rem;">
                            <button type="submit" name="dfr_upload_icon" class="button">
                                <?php echo $current_icon ? 'Ersetzen' : 'Hochladen'; ?>
                            </button>
                        </form>
                        
                        <?php if ($current_icon) : ?>
                        <form method="post" style="display:inline-block;margin-left:10px;">
                            <?php wp_nonce_field('dfr_delete_icon_nonce'); ?>
                            <input type="hidden" name="icon_type" value="<?php echo esc_attr($icon_key); ?>">
                            <button type="submit" name="dfr_delete_icon" class="button" onclick="return confirm('Icon wirklich löschen?');">
                                Löschen
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Sterne Icons -->
            <div class="dfr-icons-section" style="margin-top:30px;padding-top:30px;border-top:2px solid #f0f0f0;">
                <h3 style="margin:0 0 20px;font-size:0.95rem;color:#666;text-transform:uppercase;letter-spacing:0.05em;">
                    ⭐ Sterne-System Icons
                </h3>
                
                <?php 
                $star_icons = [
                    'icon_star_empty' => ['label' => 'Stern (Leer)', 'emoji' => '☆'],
                    'icon_star_filled' => ['label' => 'Stern (Gefüllt)', 'emoji' => '★']
                ];
                
                foreach ($star_icons as $icon_key => $icon_data) :
                    $current_icon = $options[$icon_key] ?? '';
                ?>
                <div class="dfr-icon-upload-row">
                    <div class="dfr-icon-info">
                        <strong><?php echo $icon_data['emoji']; ?> <?php echo esc_html($icon_data['label']); ?></strong>
                        <?php if ($current_icon) : ?>
                            <div class="dfr-icon-preview">
                                <img src="<?php echo esc_url($current_icon); ?>" alt="<?php echo esc_attr($icon_data['label']); ?>" style="max-width:48px;max-height:48px;">
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="dfr-icon-actions">
                        <form method="post" enctype="multipart/form-data" style="display:inline-block;">
                            <?php wp_nonce_field('dfr_upload_icon_nonce'); ?>
                            <input type="hidden" name="icon_type" value="<?php echo esc_attr($icon_key); ?>">
                            <input type="file" name="dfr_icon_file" accept=".svg,.png,.jpg,.jpeg,.gif,.webp" required style="font-size:0.85rem;">
                            <button type="submit" name="dfr_upload_icon" class="button">
                                <?php echo $current_icon ? 'Ersetzen' : 'Hochladen'; ?>
                            </button>
                        </form>
                        
                        <?php if ($current_icon) : ?>
                        <form method="post" style="display:inline-block;margin-left:10px;">
                            <?php wp_nonce_field('dfr_delete_icon_nonce'); ?>
                            <input type="hidden" name="icon_type" value="<?php echo esc_attr($icon_key); ?>">
                            <button type="submit" name="dfr_delete_icon" class="button" onclick="return confirm('Icon wirklich löschen?');">
                                Löschen
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="dfr-info-box" style="margin-top:30px;">
                <p><strong>🎨 Empfohlene Icon-Quellen:</strong></p>
                <ul style="margin:10px 0 0 20px;font-size:0.9rem;">
                    <li><strong>Heroicons</strong> - https://heroicons.com (MIT License)</li>
                    <li><strong>Feather Icons</strong> - https://feathericons.com (MIT License)</li>
                    <li><strong>Font Awesome</strong> - https://fontawesome.com (Free Icons)</li>
                    <li><strong>Flaticon</strong> - https://flaticon.com (Attribution erforderlich)</li>
                    <li><strong>Iconfinder</strong> - https://iconfinder.com (Verschiedene Lizenzen)</li>
                </ul>
            </div>
            
            <?php endif; ?>
        </div>

        <!-- Texte & Lokalisierung -->
        <div class="dfr-card">
            <h2>Texte & Lokalisierung</h2>
            <p class="description" style="margin:0 0 20px;color:#666;">Passe alle Texte an deine Sprache und Zielgruppe an.</p>
            
            <div class="dfr-field">
                <label>Widget-Titel</label>
                <input type="text" name="text_title" value="<?php echo esc_attr($options['text_title'] ?? 'War dieser Artikel hilfreich?'); ?>" style="width:100%;max-width:500px">
                <p class="description">Standard: "War dieser Artikel hilfreich?"</p>
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
}"><?php echo esc_textarea($options['custom_css'] ?? ''); ?></textarea>
                <p class="description">
                    Hier kannst du eigenes CSS einfügen, um das Widget perfekt an dein Theme anzupassen. 
                    Nutze CSS-Variablen wie <code>var(--dfr-primary)</code> für konsistente Farben.
                </p>
            </div>
            
            <div class="dfr-info-box" style="margin-top:15px;">
                <p><strong>💡 CSS-Tipps:</strong></p>
                <ul style="margin:10px 0 0 20px;">
                    <li><strong>CSS-Variablen nutzen:</strong> <code>var(--dfr-primary)</code>, <code>var(--dfr-positive)</code></li>
                    <li><strong>Thumbs-Theme ansprechen:</strong> <code>.dfr-feedback-section:not(.dfr-stars-theme)</code></li>
                    <li><strong>Sterne-Theme ansprechen:</strong> <code>.dfr-stars-theme</code></li>
                    <li><strong>Mobile anpassen:</strong> <code>@media (max-width: 768px) { ... }</code></li>
                </ul>
            </div>
        </div>

        <!-- Verwendung -->
        <div class="dfr-card">
            <h2>Verwendung & Integration</h2>
            
            <div class="dfr-field">
                <label>Universal-Shortcode (nutzt Theme aus Einstellungen)</label>
                <div class="dfr-shortcode-preview">
                    <code>[feedback_rating]</code>
                </div>
                <p class="description">
                    Verwendet das Theme, das oben in den Einstellungen ausgewählt wurde.
                </p>
            </div>
            
            <div class="dfr-field">
                <label>Thumbs-Shortcode (3-Stufen-System)</label>
                <div class="dfr-shortcode-preview">
                    <code>[feedback_thumbs]</code>
                </div>
                <p class="description">
                    Zeigt IMMER das 👍 Thumbs-System, unabhängig von den Einstellungen.
                </p>
            </div>
            
            <div class="dfr-field">
                <label>Sterne-Shortcode (5-Stufen-System)</label>
                <div class="dfr-shortcode-preview">
                    <code>[feedback_stars]</code>
                </div>
                <p class="description">
                    Zeigt IMMER das ⭐ Sterne-System, unabhängig von den Einstellungen.
                </p>
            </div>
            
            <div class="dfr-field">
                <label>Mit zusätzlichen Optionen</label>
                <div class="dfr-shortcode-preview">
                    <code>[feedback_stars show_stats="false" show_share="false"]</code>
                </div>
                <p class="description">
                    <strong>Verfügbare Parameter:</strong><br>
                    • <code>show_stats</code> - Statistik anzeigen (true/false)<br>
                    • <code>show_share</code> - Share-Buttons anzeigen (true/false)<br>
                    • <code>post_id</code> - Spezifische Post-ID (optional)<br>
                    • <code>theme</code> - Theme override: "thumbs" oder "stars"
                </p>
            </div>
            
            <div class="dfr-field">
                <label>Gutenberg Block</label>
                <p class="description" style="margin: 0;">
                    Im Block-Editor nach <strong>"Feedback Rating"</strong> suchen und einfügen. 
                    Der Block bietet in der Sidebar die Möglichkeit, das Theme pro Block zu wählen.
                </p>
            </div>
            
            <div class="dfr-field">
                <label>PHP-Code (für Theme-Entwickler)</label>
                <div class="dfr-shortcode-preview">
                    <code>&lt;?php echo do_shortcode('[feedback_rating]'); ?&gt;</code>
                </div>
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
