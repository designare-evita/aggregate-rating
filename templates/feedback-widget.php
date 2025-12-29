<?php 
if (!defined('ABSPATH')) exit;
$options = get_option('dfr_options', []);
$show_stats = filter_var($atts['show_stats'] ?? true, FILTER_VALIDATE_BOOLEAN);
$show_share = filter_var($atts['show_share'] ?? true, FILTER_VALIDATE_BOOLEAN);
?>
<aside class="dfr-feedback-section" data-post-id="<?php echo esc_attr($post_id); ?>">
    <div class="dfr-feedback-container">
        <p class="dfr-feedback-title"><?php echo esc_html($options['text_title'] ?? 'War dieser Artikel hilfreich?'); ?></p>
        
        <div class="dfr-hp-wrap" style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
            <label for="dfr_honeypot_field">Bitte nicht ausfüllen</label>
            <input type="text" name="dfr_honeypot_field" id="dfr_honeypot_field" value="" tabindex="-1" autocomplete="off">
        </div>
        
        <div class="dfr-rating-buttons">
            <button class="dfr-rating-btn dfr-positive" type="button">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 19V5M5 12l7-7 7 7"/>
                </svg>
                <?php echo esc_html($options['text_pos'] ?? 'Hilfreich'); ?>
            </button>
            <button class="dfr-rating-btn dfr-neutral" type="button">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14"/>
                </svg>
                <?php echo esc_html($options['text_neu'] ?? 'Neutral'); ?>
            </button>
            <button class="dfr-rating-btn dfr-negative" type="button">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12l7 7 7-7"/>
                </svg>
                <?php echo esc_html($options['text_neg'] ?? 'Nicht hilfreich'); ?>
            </button>
        </div>
        
        <?php if ($show_stats && !empty($options['show_stats_bar'])) : ?>
        <div class="dfr-ratio-bar">
            <div class="dfr-ratio-segment dfr-pos" style="width:<?php echo esc_attr($percentages['positive']); ?>%"></div>
            <div class="dfr-ratio-segment dfr-neu" style="width:<?php echo esc_attr($percentages['neutral']); ?>%"></div>
            <div class="dfr-ratio-segment dfr-neg" style="width:<?php echo esc_attr($percentages['negative']); ?>%"></div>
        </div>
        <div class="dfr-rating-labels">
            <?php if ($total > 0) : ?>
                <span><?php echo esc_html($percentages['positive']); ?>% <?php echo esc_html($options['text_helpful_label'] ?? 'hilfreich'); ?></span>
                <span><?php echo esc_html($total); ?> <?php echo esc_html($options['text_votes_label'] ?? 'Bewertungen'); ?></span>
            <?php else : ?>
                <span><?php echo esc_html($options['text_no_votes'] ?? 'Noch keine Bewertungen'); ?></span>
                <span><?php echo esc_html($options['text_be_first'] ?? 'Sei der Erste!'); ?></span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <?php if ($show_share) : ?>
    <div class="dfr-share-container">
        <span class="dfr-share-label">Teilen</span>
        <a href="#" class="dfr-share-icon" data-platform="whatsapp" title="WhatsApp">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
        </a>
        <a href="#" class="dfr-share-icon" data-platform="linkedin" title="LinkedIn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
            </svg>
        </a>
        <a href="#" class="dfr-share-icon" data-platform="twitter" title="X">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
            </svg>
        </a>
        <a href="#" class="dfr-share-icon" data-platform="copy" title="Link kopieren">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
            </svg>
        </a>
    </div>
    <?php endif; ?>
</aside>
