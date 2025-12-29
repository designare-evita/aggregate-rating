/**
 * Designare Feedback Ratings - Frontend JS v2.2.0
 */

(function($) {
    'use strict';

    const DFR = {
        init: function() {
            this.initRatingButtons();
            this.initStarRating();
            this.initShareButtons();
            this.checkLocalStorage();
        },

        initRatingButtons: function() {
            $('.dfr-rating-btn').on('click', function(e) {
                e.preventDefault();
                
                const $btn = $(this);
                const $container = $btn.closest('.dfr-feedback-section');
                const postId = $container.data('post-id');
                const vote = $btn.hasClass('dfr-positive') ? 'positive' : 
                             $btn.hasClass('dfr-neutral') ? 'neutral' : 'negative';
                
                // LocalStorage Check
                const storageKey = 'dfr_voted_' + postId;
                if (localStorage.getItem(storageKey)) {
                    DFR.showMessage($container, dfrConfig.strings.already_voted, 'info');
                    return;
                }
                
                DFR.submitVote($container, postId, vote, $btn);
            });
        },

        initStarRating: function() {
            const $starsContainer = $('.dfr-stars-rating');
            
            // Hover Effect
            $starsContainer.on('mouseenter', '.dfr-star-btn', function() {
                const $this = $(this);
                const rating = $this.data('rating');
                DFR.highlightStars($this.closest('.dfr-stars-rating'), rating, true);
            });
            
            $starsContainer.on('mouseleave', function() {
                const $this = $(this);
                const $container = $this.closest('.dfr-feedback-section');
                const voted = $container.find('.dfr-star-btn.dfr-selected').length > 0;
                
                if (!voted) {
                    DFR.highlightStars($this, 0, false);
                }
            });
            
            // Click Event
            $starsContainer.on('click', '.dfr-star-btn', function(e) {
                e.preventDefault();
                
                const $this = $(this);
                const $container = $this.closest('.dfr-feedback-section');
                const postId = $container.data('post-id');
                const rating = $this.data('rating');
                
                // LocalStorage Check
                const storageKey = 'dfr_voted_' + postId;
                if (localStorage.getItem(storageKey)) {
                    DFR.showMessage($container, dfrConfig.strings.already_voted, 'info');
                    return;
                }
                
                DFR.submitVote($container, postId, null, $this, rating);
            });
        },

        highlightStars: function($container, rating, isHover) {
            $container.find('.dfr-star-btn').each(function(index) {
                const $star = $(this);
                const starRating = index + 1;
                
                if (starRating <= rating) {
                    if (isHover) {
                        $star.addClass('dfr-hover');
                    }
                    
                    // Custom Icons Support
                    if ($star.find('.dfr-star-empty, .dfr-star-filled').length > 0) {
                        $star.find('.dfr-star-empty').hide();
                        $star.find('.dfr-star-filled').show();
                    } else {
                        $star.find('svg').attr('fill', 'currentColor');
                    }
                } else {
                    if (isHover) {
                        $star.removeClass('dfr-hover');
                    }
                    
                    // Custom Icons Support
                    if ($star.find('.dfr-star-empty, .dfr-star-filled').length > 0) {
                        $star.find('.dfr-star-empty').show();
                        $star.find('.dfr-star-filled').hide();
                    } else {
                        $star.find('svg').attr('fill', 'none');
                    }
                }
            });
        },

        submitVote: function($container, postId, vote, $btn, starRating) {
            const honeypot = $container.find('#dfr_honeypot_field').val();
            
            if (honeypot) {
                console.warn('DFR: Honeypot triggered');
                return;
            }
            
            // Disable buttons
            $container.find('button').prop('disabled', true);
            $container.addClass('dfr-loading');
            
            DFR.showMessage($container, dfrConfig.strings.saving, 'info');
            
            const data = {
                action: 'dfr_submit_vote',
                nonce: dfrConfig.nonce,
                post_id: postId,
                hp_field: honeypot
            };
            
            if (starRating) {
                data.star_rating = starRating;
            } else {
                data.vote = vote;
            }
            
            $.ajax({
                url: dfrConfig.ajaxUrl,
                type: 'POST',
                data: data,
                success: function(response) {
                    if (response.success) {
                        // Mark as voted
                        const storageKey = 'dfr_voted_' + postId;
                        localStorage.setItem(storageKey, Date.now());
                        
                        // Update UI
                        if (starRating) {
                            DFR.markStarVoted($container, starRating);
                        } else {
                            DFR.markVotedState($container, $btn);
                        }
                        
                        // Update stats
                        if (response.data.stats) {
                            DFR.updateStats($container, response.data);
                        }
                        
                        DFR.showMessage($container, dfrConfig.strings.thanks, 'success');
                    } else {
                        DFR.showMessage($container, response.data.message || dfrConfig.strings.error, 'error');
                        $container.find('button').prop('disabled', false);
                    }
                },
                error: function() {
                    DFR.showMessage($container, dfrConfig.strings.error, 'error');
                    $container.find('button').prop('disabled', false);
                },
                complete: function() {
                    $container.removeClass('dfr-loading');
                }
            });
        },

        markVotedState: function($container, $btn) {
            $container.find('.dfr-rating-btn').removeClass('dfr-selected');
            $btn.addClass('dfr-selected');
        },

        markStarVoted: function($container, rating) {
            const $stars = $container.find('.dfr-stars-rating');
            $stars.find('.dfr-star-btn').each(function(index) {
                const $star = $(this);
                const starRating = index + 1;
                
                if (starRating <= rating) {
                    $star.addClass('dfr-selected');
                    
                    // Custom Icons Support
                    if ($star.find('.dfr-star-empty, .dfr-star-filled').length > 0) {
                        $star.find('.dfr-star-empty').hide();
                        $star.find('.dfr-star-filled').show();
                    } else {
                        $star.find('svg').attr('fill', 'currentColor');
                    }
                } else {
                    $star.removeClass('dfr-selected');
                }
            });
        },

        updateStats: function($container, data) {
            const stats = data.stats;
            const total = data.total;
            const percentages = data.percentages;
            
            // Update Thumbs Stats
            if ($container.find('.dfr-ratio-bar').length > 0) {
                DFR.updateRatioBar($container, percentages);
                
                const helpfulPercent = percentages.positive;
                const $labels = $container.find('.dfr-rating-labels span').first();
                $labels.text(helpfulPercent + '% ' + dfrConfig.strings.helpful);
                
                const $votesLabel = $container.find('.dfr-rating-labels span').last();
                $votesLabel.text(total + ' ' + dfrConfig.strings.votes);
            }
            
            // Update Stars Stats
            if ($container.find('.dfr-stars-distribution').length > 0) {
                DFR.updateStarsDisplay($container, stats, total, percentages);
            }
        },

        updateRatioBar: function($container, percentages) {
            $container.find('.dfr-ratio-segment.dfr-pos').css('width', percentages.positive + '%');
            $container.find('.dfr-ratio-segment.dfr-neu').css('width', percentages.neutral + '%');
            $container.find('.dfr-ratio-segment.dfr-neg').css('width', percentages.negative + '%');
        },

        updateStarsDisplay: function($container, stats, total, percentages) {
            // Update average
            const score = (stats.positive * 5) + (stats.neutral * 3) + (stats.negative * 1);
            const average = total > 0 ? (score / total).toFixed(1) : 0;
            
            $container.find('.dfr-avg-rating').text(average);
            $container.find('.dfr-avg-count').text('(' + total + ' ' + dfrConfig.strings.votes + ')');
            
            // Update average stars display
            const $avgStars = $container.find('.dfr-avg-stars');
            const avgRounded = Math.round(average);
            
            $avgStars.find('svg, .dfr-custom-icon-small').each(function(index) {
                const starNum = index + 1;
                const $star = $(this);
                
                if ($star.is('svg')) {
                    if (starNum <= avgRounded) {
                        $star.attr('fill', 'currentColor');
                    } else {
                        $star.attr('fill', 'none');
                    }
                } else if ($star.hasClass('dfr-custom-icon-small')) {
                    // Custom icon - swap src if needed
                    // This would require data attributes for empty/filled URLs
                }
            });
            
            // Update distribution bars
            $container.find('.dfr-dist-row').each(function() {
                const $row = $(this);
                const label = $row.find('.dfr-dist-label').text().trim();
                let percentage = 0;
                
                if (label === '5★') percentage = percentages.positive;
                else if (label === '3★') percentage = percentages.neutral;
                else if (label === '1★') percentage = percentages.negative;
                
                $row.find('.dfr-dist-fill').css('width', percentage + '%');
                $row.find('.dfr-dist-percent').text(percentage + '%');
            });
        },

        showMessage: function($container, message, type) {
            const $existing = $container.find('.dfr-feedback-message');
            
            if ($existing.length > 0) {
                $existing.remove();
            }
            
            const $message = $('<div class="dfr-feedback-message dfr-' + type + '">' + message + '</div>');
            $container.find('.dfr-feedback-container').append($message);
            
            if (type === 'success') {
                setTimeout(function() {
                    $message.fadeOut(function() {
                        $(this).remove();
                    });
                }, 5000);
            }
        },

        checkLocalStorage: function() {
            $('.dfr-feedback-section').each(function() {
                const $container = $(this);
                const postId = $container.data('post-id');
                const storageKey = 'dfr_voted_' + postId;
                
                if (localStorage.getItem(storageKey)) {
                    $container.find('button').prop('disabled', true);
                    DFR.showMessage($container, dfrConfig.strings.already_voted, 'info');
                }
            });
        },

        initShareButtons: function() {
            $('.dfr-share-icon').on('click', function(e) {
                e.preventDefault();
                
                const platform = $(this).data('platform');
                const url = encodeURIComponent(window.location.href);
                const title = encodeURIComponent(document.title);
                
                let shareUrl = '';
                
                switch(platform) {
                    case 'whatsapp':
                        shareUrl = 'https://wa.me/?text=' + title + ' ' + url;
                        break;
                    case 'linkedin':
                        shareUrl = 'https://www.linkedin.com/sharing/share-offsite/?url=' + url;
                        break;
                    case 'twitter':
                        shareUrl = 'https://twitter.com/intent/tweet?url=' + url + '&text=' + title;
                        break;
                    case 'copy':
                        DFR.copyToClipboard(window.location.href);
                        return;
                }
                
                if (shareUrl) {
                    window.open(shareUrl, '_blank', 'width=600,height=400');
                }
            });
        },

        copyToClipboard: function(text) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(function() {
                    alert('Link kopiert!');
                });
            } else {
                // Fallback
                const $temp = $('<input>');
                $('body').append($temp);
                $temp.val(text).select();
                document.execCommand('copy');
                $temp.remove();
                alert('Link kopiert!');
            }
        }
    };

    // Initialize on DOM Ready
    $(document).ready(function() {
        DFR.init();
    });

})(jQuery);
