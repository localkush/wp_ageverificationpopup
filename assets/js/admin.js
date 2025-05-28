/**
 * Age Verification Popup Admin JavaScript
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Clear cookies functionality
        $('#avp-clear-cookies').on('click', function() {
            // Clear the verification cookie
            document.cookie = 'avp_verified=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
            
            // Show success message
            $(this).text('Cleared!').prop('disabled', true);
            
            // Reset button after 2 seconds
            setTimeout(function() {
                $('#avp-clear-cookies').text('Clear All Verification Cookies').prop('disabled', false);
            }, 2000);
        });

        // Form validation
        $('form').on('submit', function(e) {
            var isValid = true;
            var firstInvalidField = null;

            // Validate minimum age
            var minAge = $('#avp_minimum_age').val();
            if (minAge < 13 || minAge > 25) {
                isValid = false;
                $('#avp_minimum_age').addClass('error');
                if (!firstInvalidField) firstInvalidField = $('#avp_minimum_age');
            } else {
                $('#avp_minimum_age').removeClass('error');
            }

            // Validate failure redirect URL
            var failureUrl = $('#avp_failure_redirect').val();
            if (!failureUrl || !isValidUrl(failureUrl)) {
                isValid = false;
                $('#avp_failure_redirect').addClass('error');
                if (!firstInvalidField) firstInvalidField = $('#avp_failure_redirect');
            } else {
                $('#avp_failure_redirect').removeClass('error');
            }

            // Validate cookie duration
            var cookieDuration = $('#avp_cookie_duration').val();
            if (cookieDuration < 1 || cookieDuration > 365) {
                isValid = false;
                $('#avp_cookie_duration').addClass('error');
                if (!firstInvalidField) firstInvalidField = $('#avp_cookie_duration');
            } else {
                $('#avp_cookie_duration').removeClass('error');
            }

            if (!isValid) {
                e.preventDefault();
                if (firstInvalidField) {
                    firstInvalidField.focus();
                }
                showNotice('Please correct the highlighted fields.', 'error');
            }
        });

        // Real-time validation
        $('#avp_minimum_age').on('input', function() {
            var value = parseInt($(this).val());
            if (value >= 13 && value <= 25) {
                $(this).removeClass('error').addClass('valid');
            } else {
                $(this).removeClass('valid').addClass('error');
            }
        });

        $('#avp_failure_redirect').on('input', function() {
            var value = $(this).val();
            if (value && isValidUrl(value)) {
                $(this).removeClass('error').addClass('valid');
            } else {
                $(this).removeClass('valid').addClass('error');
            }
        });

        $('#avp_cookie_duration').on('input', function() {
            var value = parseInt($(this).val());
            if (value >= 1 && value <= 365) {
                $(this).removeClass('error').addClass('valid');
            } else {
                $(this).removeClass('valid').addClass('error');
            }
        });

        // Auto-save functionality (optional)
        var autoSaveTimeout;
        $('.form-table input, .form-table textarea').on('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(function() {
                // Could implement auto-save here if needed
                console.log('Auto-save triggered');
            }, 2000);
        });

        // Tooltips
        $('[data-tooltip]').hover(
            function() {
                var tooltip = $('<div class="avp-tooltip-content">' + $(this).data('tooltip') + '</div>');
                $('body').append(tooltip);
                
                var pos = $(this).offset();
                tooltip.css({
                    position: 'absolute',
                    top: pos.top - tooltip.outerHeight() - 10,
                    left: pos.left + ($(this).outerWidth() / 2) - (tooltip.outerWidth() / 2),
                    zIndex: 9999
                });
            },
            function() {
                $('.avp-tooltip-content').remove();
            }
        );

        // Settings export/import (future feature)
        $('#avp-export-settings').on('click', function() {
            var settings = {
                minimum_age: $('#avp_minimum_age').val(),
                success_redirect: $('#avp_success_redirect').val(),
                failure_redirect: $('#avp_failure_redirect').val(),
                cookie_duration: $('#avp_cookie_duration').val(),
                popup_title: $('#avp_popup_title').val(),
                popup_message: $('#avp_popup_message').val(),
                button_text: $('#avp_button_text').val(),
                date_label: $('#avp_date_label').val()
            };
            
            var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(settings, null, 2));
            var downloadAnchorNode = document.createElement('a');
            downloadAnchorNode.setAttribute("href", dataStr);
            downloadAnchorNode.setAttribute("download", "age-verification-settings.json");
            document.body.appendChild(downloadAnchorNode);
            downloadAnchorNode.click();
            downloadAnchorNode.remove();
        });

        // Character counter for text fields
        $('#avp_popup_title, #avp_button_text, #avp_date_label').each(function() {
            var maxLength = 100;
            var $field = $(this);
            var $counter = $('<div class="char-counter"></div>');
            $field.after($counter);
            
            function updateCounter() {
                var remaining = maxLength - $field.val().length;
                $counter.text(remaining + ' characters remaining');
                
                if (remaining < 10) {
                    $counter.addClass('warning');
                } else {
                    $counter.removeClass('warning');
                }
            }
            
            $field.on('input', updateCounter);
            updateCounter();
        });

        // Message character counter
        $('#avp_popup_message').each(function() {
            var maxLength = 500;
            var $field = $(this);
            var $counter = $('<div class="char-counter"></div>');
            $field.after($counter);
            
            function updateCounter() {
                var remaining = maxLength - $field.val().length;
                $counter.text(remaining + ' characters remaining');
                
                if (remaining < 50) {
                    $counter.addClass('warning');
                } else {
                    $counter.removeClass('warning');
                }
            }
            
            $field.on('input', updateCounter);
            updateCounter();
        });

    });

    // Helper functions
    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }

    function showNotice(message, type) {
        var notice = $('<div class="notice notice-' + type + ' is-dismissible"><p>' + message + '</p></div>');
        $('.wrap h1').after(notice);
        
        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            notice.fadeOut();
        }, 5000);
    }

    // Add custom styles for validation
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .form-table input.error,
            .form-table textarea.error {
                border-color: #d63638 !important;
                box-shadow: 0 0 0 1px #d63638 !important;
            }
            
            .form-table input.valid,
            .form-table textarea.valid {
                border-color: #00a32a !important;
                box-shadow: 0 0 0 1px #00a32a !important;
            }
            
            .char-counter {
                font-size: 12px;
                color: #646970;
                margin-top: 5px;
            }
            
            .char-counter.warning {
                color: #d63638;
                font-weight: 600;
            }
            
            .avp-tooltip-content {
                background: #1d2327;
                color: #ffffff;
                padding: 8px 12px;
                border-radius: 4px;
                font-size: 12px;
                max-width: 200px;
                word-wrap: break-word;
            }
        `)
        .appendTo('head');

})(jQuery); 