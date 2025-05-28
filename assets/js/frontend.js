/**
 * Age Verification Popup Frontend JavaScript
 */

(function($) {
    'use strict';

    // Don't initialize in Elementor editor mode
    if (typeof elementor !== 'undefined' && elementor.isEditMode) {
        return;
    }

    // Also check for Elementor preview mode
    if (window.location.href.indexOf('elementor-preview') !== -1) {
        return;
    }

    class AgeVerificationPopup {
        constructor() {
            this.widgets = [];
            this.init();
        }

        init() {
            // Wait for DOM to be ready
            $(document).ready(() => {
                this.initializeWidgets();
                this.bindEvents();
            });
        }

        initializeWidgets() {
            // Find all age verification widgets
            $('.avp-widget').each((index, element) => {
                const $widget = $(element);
                
                // Skip widgets in editor mode
                if ($widget.hasClass('avp-editor-mode') || $widget.hasClass('avp-preview-mode')) {
                    return;
                }
                
                const settingsScript = $widget.find('.avp-widget-settings');
                
                if (settingsScript.length) {
                    try {
                        const settings = JSON.parse(settingsScript.text());
                        this.widgets.push({
                            element: $widget,
                            settings: settings,
                            overlay: $widget.find('.avp-popup-overlay'),
                            form: $widget.find('.avp-popup-content'),
                            dateInput: $widget.find('.avp-date-input'),
                            verifyBtn: $widget.find('.avp-verify-btn'),
                            cancelBtn: $widget.find('.avp-cancel-btn'),
                            errorMsg: $widget.find('.avp-error-message')
                        });
                    } catch (e) {
                        console.error('Failed to parse widget settings:', e);
                    }
                }
            });

            // Initialize each widget
            this.widgets.forEach(widget => {
                this.initWidget(widget);
            });
        }

        initWidget(widget) {
            const { settings, overlay, verifyBtn, cancelBtn, dateInput } = widget;

            // Check if user is already verified
            if (this.isVerified()) {
                return; // Don't show popup if already verified
            }

            // Show popup based on settings
            if (settings.show_on_load) {
                this.showPopup(widget);
            } else if (settings.trigger_selector) {
                $(settings.trigger_selector).on('click', (e) => {
                    e.preventDefault();
                    this.showPopup(widget);
                });
            }

            // Bind button events
            verifyBtn.on('click', () => this.verifyAge(widget));
            cancelBtn.on('click', () => this.cancelVerification(widget));

            // Bind Enter key on date input
            dateInput.on('keypress', (e) => {
                if (e.which === 13) {
                    this.verifyAge(widget);
                }
            });

            // Close popup when clicking overlay (optional)
            overlay.on('click', (e) => {
                if (e.target === overlay[0]) {
                    // Don't close automatically - force user to make a choice
                    // this.hidePopup(widget);
                }
            });
        }

        showPopup(widget) {
            const { overlay } = widget;
            
            // Prevent body scroll
            $('body').addClass('avp-popup-open');
            
            // Show overlay with animation
            overlay.fadeIn(300);
            
            // Focus on date input
            setTimeout(() => {
                widget.dateInput.focus();
            }, 350);
        }

        hidePopup(widget) {
            const { overlay } = widget;
            
            // Hide overlay
            overlay.fadeOut(300, () => {
                // Re-enable body scroll
                $('body').removeClass('avp-popup-open');
            });
        }

        verifyAge(widget) {
            const { settings, dateInput, errorMsg, verifyBtn } = widget;
            const birthDate = dateInput.val();

            // Clear previous errors
            this.clearError(widget);

            // Validate input
            if (!birthDate) {
                this.showError(widget, 'Please enter your birth date.');
                return;
            }

            // Disable button during processing
            verifyBtn.prop('disabled', true).text('Verifying...');

            // Calculate age
            const birthTimestamp = new Date(birthDate).getTime();
            const minimumTimestamp = new Date();
            minimumTimestamp.setFullYear(minimumTimestamp.getFullYear() - settings.minimum_age);

            const isOldEnough = birthTimestamp <= minimumTimestamp.getTime();

            // Simulate processing delay for better UX
            setTimeout(() => {
                if (isOldEnough) {
                    this.handleSuccess(widget);
                } else {
                    this.handleFailure(widget);
                }
                
                // Re-enable button
                verifyBtn.prop('disabled', false).text(verifyBtn.data('original-text') || 'Verify Age');
            }, 500);
        }

        handleSuccess(widget) {
            const { settings } = widget;
            
            // Set verification cookie
            this.setVerificationCookie(settings.cookie_duration);
            
            // Hide popup
            this.hidePopup(widget);
            
            // Redirect if specified
            if (settings.success_redirect) {
                window.location.href = settings.success_redirect;
            }
            
            // Trigger custom event
            $(document).trigger('avp:verified', { widget: widget });
        }

        handleFailure(widget) {
            const { settings } = widget;
            
            // Show error message
            this.showError(widget, `You must be ${settings.minimum_age} or older to access this website.`);
            
            // Redirect after delay
            setTimeout(() => {
                if (settings.failure_redirect) {
                    window.location.href = settings.failure_redirect;
                }
            }, 2000);
            
            // Trigger custom event
            $(document).trigger('avp:failed', { widget: widget });
        }

        cancelVerification(widget) {
            const { settings } = widget;
            
            // Redirect immediately
            if (settings.failure_redirect) {
                window.location.href = settings.failure_redirect;
            }
        }

        showError(widget, message) {
            const { errorMsg } = widget;
            errorMsg.text(message).slideDown(200);
        }

        clearError(widget) {
            const { errorMsg } = widget;
            errorMsg.slideUp(200);
        }

        isVerified() {
            return this.getCookie('avp_verified') === '1';
        }

        setVerificationCookie(days) {
            const expires = new Date();
            expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = `avp_verified=1; expires=${expires.toUTCString()}; path=/`;
        }

        getCookie(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        bindEvents() {
            // Store original button text for restoration
            $('.avp-verify-btn').each(function() {
                $(this).data('original-text', $(this).text());
            });

            // Handle Elementor preview mode
            if (typeof elementorFrontend !== 'undefined') {
                elementorFrontend.hooks.addAction('frontend/element_ready/age-verification-popup.default', ($scope) => {
                    // Re-initialize widget in preview mode
                    this.initializeWidgets();
                });
            }
        }
    }

    // Initialize when ready
    new AgeVerificationPopup();

    // Expose for external use
    window.AgeVerificationPopup = AgeVerificationPopup;

})(jQuery); 