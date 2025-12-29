(function($) {
    'use strict';
    var config = window.dfrConfig || {};
    var LOCAL_STORAGE_KEY = 'dfr_voted_';

    $(document).ready(function() {
        var $widget = $('.dfr-feedback-section');
        if (!$widget.length) return;

        var postId = config.postId || $widget.data('post-id');
        if (!postId) return;

        var existingVote = localStorage.getItem(LOCAL_STORAGE_KEY + postId);
        if (existingVote) {
            if ($widget.hasClass('dfr-stars-theme')) {
                markStarVoted($widget, existingVote);
            } else {
                markVotedState($widget, existingVote);
            }
        }

        loadStats($widget, postId);
        
        if ($widget.hasClass('dfr-stars-theme')) {
            initStarRating($widget, postId);
        } else {
            initRatingButtons($widget, postId);
        }
        
        initShareButtons($widget);
    });

    function loadStats($widget, postId) {
        $.ajax({
            url: config.ajaxUrl, type: 'GET',
            data: { action: 'dfr_get_stats', post_id: postId },
            success: function(r) { 
                if (r.success) {
                    if ($widget.hasClass('dfr-stars-theme')) {
                        updateStarsDisplay($widget, r.data.percentages, r.data.total);
                    } else {
                        updateRatioBar($widget, r.data.percentages, r.data.total);
                    }
                }
            }
        });
    }

    function updateRatioBar($widget, pct, total) {
        $widget.find('.dfr-ratio-segment.dfr-pos').css('width', pct.positive + '%');
        $widget.find('.dfr-ratio-segment.dfr-neu').css('width', pct.neutral + '%');
        $widget.find('.dfr-ratio-segment.dfr-neg').css('width', pct.negative + '%');
        var $labels = $widget.find('.dfr-rating-labels');
        if ($labels.length && total > 0) {
            $labels.html('<span>👍 ' + pct.positive + '% ' + config.strings.helpful + '</span><span>' + total + ' ' + config.strings.votes + '</span>');
        }
    }

    function updateStarsDisplay($widget, pct, total) {
        var $distFills = $widget.find('.dfr-dist-fill');
        var $distPercents = $widget.find('.dfr-dist-percent');
        
        $distFills.eq(0).css('width', pct.positive + '%');
        $distFills.eq(1).css('width', pct.neutral + '%');
        $distFills.eq(2).css('width', pct.negative + '%');
        
        $distPercents.eq(0).text(pct.positive + '%');
        $distPercents.eq(1).text(pct.neutral + '%');
        $distPercents.eq(2).text(pct.negative + '%');
    }

    // THUMBS SYSTEM
    function initRatingButtons($widget, postId) {
        $widget.on('click', '.dfr-rating-btn', function(e) {
            e.preventDefault();
            var $btn = $(this), $all = $widget.find('.dfr-rating-btn');
            var hpValue = $widget.find('input[name="dfr_honeypot_field"]').val();
            
            if (localStorage.getItem(LOCAL_STORAGE_KEY + postId)) { 
                showMessage($widget, config.strings.already_voted, 'info'); 
                return; 
            }

            var vote = $btn.hasClass('dfr-positive') ? 'positive' : ($btn.hasClass('dfr-negative') ? 'negative' : 'neutral');
            $all.prop('disabled', true);
            var orig = $btn.html();
            $btn.html('<span class="dfr-spinner"></span> ' + config.strings.saving);

            $.ajax({
                url: config.ajaxUrl, 
                type: 'POST',
                data: { 
                    action: 'dfr_submit_vote', 
                    nonce: config.nonce, 
                    post_id: postId, 
                    vote: vote,
                    hp_field: hpValue
                },
                success: function(r) {
                    if (r.success) {
                        localStorage.setItem(LOCAL_STORAGE_KEY + postId, vote);
                        $btn.html(orig);
                        markVotedState($widget, vote);
                        updateRatioBar($widget, r.data.percentages, r.data.total);
                        showMessage($widget, config.strings.thanks, 'success');
                    } else { 
                        $btn.html(orig); 
                        $all.prop('disabled', false); 
                        showMessage($widget, r.data.message || config.strings.error, 'error'); 
                    }
                },
                error: function() { 
                    $btn.html(orig); 
                    $all.prop('disabled', false); 
                    showMessage($widget, config.strings.error, 'error'); 
                }
            });
        });
    }

    function markVotedState($widget, vote) {
        $widget.find('.dfr-rating-btn').each(function() {
            var $btn = $(this);
            $btn.prop('disabled', true).removeClass('dfr-selected');
            if ((vote === 'positive' && $btn.hasClass('dfr-positive')) || 
                (vote === 'neutral' && $btn.hasClass('dfr-neutral')) || 
                (vote === 'negative' && $btn.hasClass('dfr-negative'))) {
                $btn.addClass('dfr-selected');
            }
        });
    }

    // STARS SYSTEM
    function initStarRating($widget, postId) {
        var $stars = $widget.find('.dfr-star-btn');
        var hoverRating = 0;
        
        $stars.on('mouseenter', function() {
            hoverRating = parseInt($(this).data('rating'));
            highlightStars($stars, hoverRating);
        });
        
        $widget.find('.dfr-stars-rating').on('mouseleave', function() {
            hoverRating = 0;
            highlightStars($stars, 0);
        });
        
        $stars.on('click', function(e) {
            e.preventDefault();
            
            if (localStorage.getItem(LOCAL_STORAGE_KEY + postId)) {
                showMessage($widget, config.strings.already_voted, 'info');
                return;
            }
            
            var rating = parseInt($(this).data('rating'));
            var hpValue = $widget.find('input[name="dfr_honeypot_field"]').val();
            
            $stars.prop('disabled', true);
            highlightStars($stars, rating);
            
            $.ajax({
                url: config.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'dfr_submit_vote',
                    nonce: config.nonce,
                    post_id: postId,
                    star_rating: rating,
                    hp_field: hpValue
                },
                success: function(r) {
                    if (r.success) {
                        localStorage.setItem(LOCAL_STORAGE_KEY + postId, 'star_' + rating);
                        markStarSelected($stars, rating);
                        updateStarsDisplay($widget, r.data.percentages, r.data.total);
                        showMessage($widget, config.strings.thanks, 'success');
                    } else {
                        $stars.prop('disabled', false);
                        highlightStars($stars, 0);
                        showMessage($widget, r.data.message || config.strings.error, 'error');
                    }
                },
                error: function() {
                    $stars.prop('disabled', false);
                    highlightStars($stars, 0);
                    showMessage($widget, config.strings.error, 'error');
                }
            });
        });
    }
    
    function highlightStars($stars, rating) {
        $stars.each(function(i) {
            var $star = $(this);
            if ((i + 1) <= rating) {
                $star.addClass('dfr-hover');
            } else {
                $star.removeClass('dfr-hover');
            }
        });
    }
    
    function markStarSelected($stars, rating) {
        $stars.each(function(i) {
            var $star = $(this);
            $star.removeClass('dfr-hover');
            if ((i + 1) <= rating) {
                $star.addClass('dfr-selected');
            }
        });
    }
    
    function markStarVoted($widget, vote) {
        if (vote.indexOf('star_') === 0) {
            var rating = parseInt(vote.replace('star_', ''));
            var $stars = $widget.find('.dfr-star-btn');
            markStarSelected($stars, rating);
            $stars.prop('disabled', true);
        }
    }

    function showMessage($widget, msg, type) {
        $widget.find('.dfr-feedback-message').remove();
        var $m = $('<div class="dfr-feedback-message dfr-' + type + '">' + msg + '</div>');
        $widget.find('.dfr-feedback-container').append($m);
        setTimeout(function() { $m.fadeOut(300, function() { $(this).remove(); }); }, 3000);
    }

    function initShareButtons($widget) {
        $widget.on('click', '.dfr-share-icon', function(e) {
            e.preventDefault();
            var p = $(this).data('platform'), 
                url = encodeURIComponent(location.href), 
                title = encodeURIComponent(document.title), 
                share = '';
                
            if (p === 'whatsapp') share = 'https://wa.me/?text=' + title + '%20' + url;
            else if (p === 'linkedin') share = 'https://www.linkedin.com/sharing/share-offsite/?url=' + url;
            else if (p === 'twitter') share = 'https://twitter.com/intent/tweet?url=' + url + '&text=' + title;
            else if (p === 'copy') { 
                navigator.clipboard.writeText(location.href); 
                alert('Link kopiert!'); 
                return; 
            }
            if (share) window.open(share, '_blank', 'width=600,height=500');
        });
    }
})(jQuery);
