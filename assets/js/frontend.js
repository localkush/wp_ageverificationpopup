/**
 * Age Verification Popup Frontend JavaScript
 * Version 1.0.5
 * Based on Elementor Academy tutorial approach
 */

(function($) {
    'use strict';

    console.log('🚀 Age Verification Popup JS v1.0.5 loading...');
    console.log('🔍 jQuery available:', typeof $ !== 'undefined');
    console.log('🔍 Document ready state:', document.readyState);

    // Don't initialize in Elementor editor mode
    if (typeof elementor !== 'undefined' && elementor.isEditMode) {
        console.log('❌ Elementor editor mode detected, skipping initialization');
        return;
    }

    // Also check for Elementor preview mode
    if (window.location.href.indexOf('elementor-preview') !== -1) {
        console.log('❌ Elementor preview mode detected, skipping initialization');
        return;
    }

    console.log('✅ No editor mode detected, proceeding with initialization');

    class AgeVerificationPopup {
        constructor() {
            console.log('🏗️ AgeVerificationPopup constructor called');
            
            // IMMEDIATE: Hide popup for verified users BEFORE Elementor shows it
            this.preventPopupForVerifiedUsers();
            
            this.init();
        }

        init() {
            console.log('🚀 Age Verification Popup initializing...');
            
            // Initialize when DOM is ready
            $(document).ready(() => {
                console.log('📄 DOM ready event fired');
                this.bindEvents();
            });
            
            // Also initialize when Elementor frontend is ready (for dynamic content)
            if (typeof elementorFrontend !== 'undefined') {
                console.log('🔍 ElementorFrontend detected, binding to init event');
                $(window).on('elementor/frontend/init', () => {
                    console.log('🎯 Elementor frontend init event fired');
                    this.bindEvents();
                });
            } else {
                console.log('⚠️ ElementorFrontend not detected');
            }
        }

        bindEvents() {
            console.log('🔗 Binding age verification events...');
            
            // Find all age verification widgets
            const $widgets = $('.avp-widget-content');
            console.log('🔍 Found', $widgets.length, 'age verification widgets');
            
            if ($widgets.length === 0) {
                console.warn('⚠️ No age verification widgets found on page');
                return;
            }

            $widgets.each((index, element) => {
                const $widget = $(element);
                const widgetId = $widget.attr('id') || 'unknown-' + index;
                
                console.log('🎯 Processing widget:', widgetId);
                
                // Skip if already processed
                if ($widget.data('avp-processed')) {
                    console.log('⏭️ Widget already processed:', widgetId);
                    return;
                }
                
                // Skip editor mode widgets
                if ($widget.hasClass('avp-editor-mode') || $widget.hasClass('avp-preview-mode')) {
                    console.log('⏭️ Skipping editor/preview mode widget:', widgetId);
                    return;
                }
                
                // Check if user is already verified
                if (this.isVerified()) {
                    // Check for testing bypass parameter
                    const urlParams = new URLSearchParams(window.location.search);
                    const forceShow = urlParams.get('avp_force') === 'true';
                    
                    if (forceShow) {
                        console.log('🧪 FORCING POPUP SHOW (testing bypass active)');
                    } else {
                        console.log('✅ User already verified, hiding popup');
                        
                        // Add small delay to ensure popup is fully rendered
                        setTimeout(() => {
                            const $popup = $widget.closest('.elementor-popup-modal');
                            if ($popup.length) {
                                console.log('🔒 Using nuclear close method for verified user');
                                this.closePopup($popup);
                            } else {
                                console.log('⚠️ No popup found to close, trying alternative selectors');
                                // Try alternative popup selectors
                                const $altPopup = $('.elementor-popup-modal, .dialog-widget, .dialog-lightbox-widget');
                                if ($altPopup.length) {
                                    console.log('🎯 Found popup with alternative selector, closing...');
                                    this.closePopup($altPopup.first());
                                } else {
                                    console.log('❌ No popup found with any selector');
                                    // Set up popup watcher since popup doesn't exist yet
                                    console.log('👁️ Setting up popup watcher for verified user...');
                                    this.setupVerifiedUserPopupWatcher();
                                }
                            }
                        }, 100); // Small delay to let popup fully render
                        
                        return;
                    }
                }
                
                this.initializeWidget($widget);
                $widget.data('avp-processed', true);
            });
        }

        initializeWidget($widget) {
            const widgetId = $widget.attr('id') || 'unknown';
            console.log('🚀 Initializing widget:', widgetId);
            
            // Get settings from the widget
            let settings = this.getWidgetSettings($widget);
            if (!settings) {
                console.error('❌ No settings found for widget:', widgetId);
                return;
            }
            
            console.log('⚙️ Widget settings loaded:', settings);
            
            // Find form elements with detailed logging
            const $verifyBtn = $widget.find('.avp-verify-btn');
            const $cancelBtn = $widget.find('.avp-cancel-btn');
            const $dateInput = $widget.find('.avp-date-input');
            
            console.log('🔍 Element search results for', widgetId + ':');
            console.log('  - Verify button found:', $verifyBtn.length, $verifyBtn);
            console.log('  - Cancel button found:', $cancelBtn.length, $cancelBtn);
            console.log('  - Date input found:', $dateInput.length, $dateInput);
            
            if (!$verifyBtn.length) {
                console.error('❌ Verify button not found in widget:', widgetId);
                console.log('🔍 Widget HTML:', $widget.html());
                return;
            }
            
            if (!$dateInput.length) {
                console.error('❌ Date input not found in widget:', widgetId);
                console.log('🔍 Widget HTML:', $widget.html());
                return;
            }
            
            // Store original button text
            if (!$verifyBtn.data('original-text')) {
                const originalText = $verifyBtn.text();
                $verifyBtn.data('original-text', originalText);
                console.log('💾 Stored original button text:', originalText);
            }
            
            // Diagnose overlay issues
            console.log('🧪 Diagnosing overlay issues:');
            console.log('  - Verify button visible (jQuery):', $verifyBtn.is(':visible'));
            console.log('  - Verify button disabled:', $verifyBtn.prop('disabled'));
            console.log('  - Verify button CSS display:', $verifyBtn.css('display'));
            console.log('  - Verify button CSS visibility:', $verifyBtn.css('visibility'));
            console.log('  - Verify button CSS z-index:', $verifyBtn.css('z-index'));
            console.log('  - Verify button CSS position:', $verifyBtn.css('position'));
            
            // Check parent container z-index
            const $popup = $widget.closest('.elementor-popup-modal');
            if ($popup.length) {
                console.log('  - Popup z-index:', $popup.css('z-index'));
                console.log('  - Popup position:', $popup.css('position'));
            }
            
            // SOLUTION 1: Use event delegation on document to bypass overlay issues
            console.log('🔧 Setting up event delegation to bypass overlays...');
            
            // Remove any existing delegated events first
            $(document).off('click.avp-verify', '.avp-verify-btn');
            $(document).off('click.avp-cancel', '.avp-cancel-btn');
            
            // Use event delegation with specific widget targeting
            $(document).on('click.avp-verify', '.avp-verify-btn', (e) => {
                const $clickedBtn = $(e.target);
                const $clickedWidget = $clickedBtn.closest('.avp-widget-content');
                
                // Only handle if it's our specific widget
                if ($clickedWidget.attr('id') === widgetId) {
                    console.log('🎯 EVENT DELEGATION VERIFY CLICK!', widgetId);
                    e.preventDefault();
                    e.stopPropagation();
                    this.handleVerification($clickedWidget, settings);
                }
            });
            
            $(document).on('click.avp-cancel', '.avp-cancel-btn', (e) => {
                const $clickedBtn = $(e.target);
                const $clickedWidget = $clickedBtn.closest('.avp-widget-content');
                
                // Only handle if it's our specific widget
                if ($clickedWidget.attr('id') === widgetId) {
                    console.log('🎯 EVENT DELEGATION CANCEL CLICK!', widgetId);
                    e.preventDefault();
                    e.stopPropagation();
                    this.handleCancel(settings);
                }
            });
            
            // SOLUTION 2: Force CSS fixes for overlays
            console.log('🔧 Applying CSS fixes for overlays...');
            
            // Ensure buttons have high z-index and proper positioning
            $verifyBtn.css({
                'position': 'relative',
                'z-index': '999999',
                'pointer-events': 'auto'
            });
            
            $cancelBtn.css({
                'position': 'relative', 
                'z-index': '999999',
                'pointer-events': 'auto'
            });
            
            // Ensure widget container allows pointer events
            $widget.css({
                'pointer-events': 'auto',
                'position': 'relative',
                'z-index': '999998'
            });
            
            // SOLUTION 3: Legacy event binding as backup (force even if not visible)
            console.log('🔧 Setting up backup direct event binding...');
            
            // Remove any existing event handlers first
            $verifyBtn.off('click.avp');
            $cancelBtn.off('click.avp');
            $dateInput.off('keypress.avp');
            
            // Force bind events regardless of visibility
            $verifyBtn.on('click.avp', (e) => {
                console.log('🎯 DIRECT VERIFY BUTTON CLICKED!', widgetId);
                e.preventDefault();
                e.stopPropagation();
                this.handleVerification($widget, settings);
            });
            
            if ($cancelBtn.length) {
                $cancelBtn.on('click.avp', (e) => {
                    console.log('🎯 DIRECT CANCEL BUTTON CLICKED!', widgetId);
                    e.preventDefault();
                    e.stopPropagation();
                    this.handleCancel(settings);
                });
            }

            // Bind Enter key on date input
            $dateInput.on('keypress.avp', (e) => {
                if (e.which === 13) { // Enter key
                    console.log('⌨️ ENTER KEY PRESSED on date input!', widgetId);
                    e.preventDefault();
                    this.handleVerification($widget, settings);
                }
            });
            
            // SOLUTION 4: Multiple native event listeners as ultimate backup
            console.log('🔧 Setting up native event listeners...');
            
            const verifyElement = $verifyBtn[0];
            const cancelElement = $cancelBtn[0];
            
            // Capturing phase listener (highest priority)
            verifyElement.addEventListener('click', (e) => {
                console.log('🚁 NATIVE CAPTURING CLICK!', widgetId);
                e.preventDefault();
                e.stopPropagation();
                this.handleVerification($widget, settings);
            }, true);
            
            // Bubbling phase listener
            verifyElement.addEventListener('click', (e) => {
                console.log('🫧 NATIVE BUBBLING CLICK!', widgetId);
                e.preventDefault();
                e.stopPropagation();
                this.handleVerification($widget, settings);
            }, false);
            
            // Mouse events for additional coverage
            verifyElement.addEventListener('mouseup', (e) => {
                console.log('🖱️ NATIVE MOUSEUP!', widgetId);
                // Small delay to differentiate from click
                setTimeout(() => {
                    if (!e.target.hasAttribute('data-click-handled')) {
                        console.log('🖱️ Handling via mouseup fallback');
                        this.handleVerification($widget, settings);
                    }
                }, 10);
            });
            
            if (cancelElement) {
                cancelElement.addEventListener('click', (e) => {
                    console.log('🚁 NATIVE CANCEL CLICK!', widgetId);
                    e.preventDefault();
                    e.stopPropagation();
                    this.handleCancel(settings);
                }, true);
            }
            
            // SOLUTION 5: Visual feedback and testing
            console.log('🔧 Setting up visual feedback system...');
            
            // Add visual click indicators
            $verifyBtn.on('mousedown.avp-debug', function() {
                console.log('🖱️ MOUSEDOWN detected on verify button!');
                $(this).css('transform', 'scale(0.95)');
            });
            
            $verifyBtn.on('mouseup.avp-debug', function() {
                console.log('🖱️ MOUSEUP detected on verify button!');
                $(this).css('transform', 'scale(1)');
            });
            
            // Test all event binding after a short delay
            setTimeout(() => {
                console.log('🧪 Testing all event bindings...');
                
                // Test jQuery events
                console.log('📋 jQuery events bound:', $._data($verifyBtn[0], 'events'));
                
                // Test delegation
                const delegatedEvents = $._data(document, 'events');
                console.log('📋 Document delegated events:', delegatedEvents);
                
                // Element positioning check
                const rect = $verifyBtn[0].getBoundingClientRect();
                const elementAtCenter = document.elementFromPoint(
                    rect.left + rect.width / 2, 
                    rect.top + rect.height / 2
                );
                console.log('🎯 Element at button center after fixes:', elementAtCenter);
                console.log('🎯 Is it the button now?', elementAtCenter === $verifyBtn[0]);
                
                // Force a test click to verify all systems
                console.log('🧪 Triggering comprehensive test...');
                $verifyBtn.trigger('click');
            }, 500);
            
            console.log('✅ Widget initialization complete with overlay fixes:', widgetId);
        }

        getWidgetSettings($widget) {
            console.log('⚙️ Getting widget settings...');
            
            // Try to find settings script
            let $settingsScript = $widget.find('.avp-widget-settings');
            if (!$settingsScript.length) {
                $settingsScript = $widget.siblings('.avp-widget-settings');
            }
            if (!$settingsScript.length) {
                $settingsScript = $widget.next('.avp-widget-settings');
            }
            
            console.log('🔍 Settings script search results:', $settingsScript.length);
            
            if ($settingsScript.length) {
                try {
                    const settingsText = $settingsScript.text();
                    console.log('📄 Raw settings text:', settingsText);
                    const settings = JSON.parse(settingsText);
                    console.log('✅ Parsed settings successfully:', settings);
                    return settings;
                } catch (e) {
                    console.error('❌ Failed to parse widget settings:', e);
                }
            }
            
            // Fallback to global settings
            if (typeof avp_ajax !== 'undefined' && avp_ajax.settings) {
                console.log('⚠️ Using fallback global settings');
                return {
                    widget_id: $widget.attr('id') || 'avp-fallback-' + Date.now(),
                    minimum_age: avp_ajax.settings.minimum_age || 18,
                    success_redirect: avp_ajax.settings.success_redirect || '',
                    failure_redirect: avp_ajax.settings.failure_redirect || '',
                    cookie_duration: avp_ajax.settings.cookie_duration || 30,
                    success_message: avp_ajax.settings.success_message || 'Age verified successfully!',
                    error_message_template: avp_ajax.settings.error_message_template || 'You must be {age} or older to access this website.'
                };
            }
            
            console.error('❌ No settings found anywhere');
            return null;
        }

        handleVerification($widget, settings) {
            console.log('🔄 HANDLE VERIFICATION CALLED!');
            
            const $dateInput = $widget.find('.avp-date-input');
            const $verifyBtn = $widget.find('.avp-verify-btn');
            const dateString = $dateInput.val();
            
            console.log('📅 Date string entered:', dateString);
            
            // Clear previous messages
            this.clearMessages($widget);
            
            // Validate date input
            if (!dateString || dateString === '') {
                console.log('❌ No date entered');
                this.showError($widget, 'You must provide your date of birth!');
                return;
            }

            // Disable button and show loading state
            const originalText = $verifyBtn.data('original-text') || $verifyBtn.text();
            $verifyBtn.prop('disabled', true).text('Verifying...');
            console.log('🔄 Button disabled, showing loading state');
            
            // Calculate age (following tutorial approach)
            const today = new Date();
            const birthDate = new Date(dateString);
            const age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            
            // Adjust age if birthday hasn't occurred this year
            const adjustedAge = (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) 
                ? age - 1 
                : age;
            
            console.log('🧮 Age calculation:', {
                today: today,
                birthDate: birthDate,
                rawAge: age,
                adjustedAge: adjustedAge,
                requiredAge: settings.minimum_age
            });
            
            // Check age
            setTimeout(() => {
                if (adjustedAge >= settings.minimum_age && adjustedAge <= 150) {
                    console.log('✅ Age verification successful');
                    this.handleSuccess($widget, settings);
                } else {
                    console.log('❌ Age verification failed');
                    this.handleFailure($widget, settings);
                }
                
                // Re-enable button
                $verifyBtn.prop('disabled', false).text(originalText);
                console.log('🔄 Button re-enabled');
            }, 500); // Small delay for better UX
        }

        handleSuccess($widget, settings) {
            console.log('🎉 Age verification successful');
            
            // Show success message
            this.showSuccess($widget, settings.success_message || 'Age verified successfully!');
            
            // Set verification cookie
            this.setVerificationCookie(settings.cookie_duration || 30);
            
            // Close popup and redirect after delay
            setTimeout(() => {
                const $popup = $widget.closest('.elementor-popup-modal');
                if ($popup.length) {
                    this.closePopup($popup);
                }
            
            // Redirect if specified
            if (settings.success_redirect) {
                window.location.href = settings.success_redirect;
            }
            }, 1500);
            
            // Trigger custom event
            $(document).trigger('avp:verified', { widget: $widget, settings: settings });
        }

        handleFailure($widget, settings) {
            console.log('❌ Age verification failed');
            
            // Create error message from template
            let errorMessage = settings.error_message_template || 'You must be {age} or older to access this website.';
            errorMessage = errorMessage.replace('{age}', settings.minimum_age);
            
            // Show error message
            this.showError($widget, errorMessage);
            
            // Redirect after delay if specified
            setTimeout(() => {
                if (settings.failure_redirect) {
                    window.location.href = settings.failure_redirect;
                }
            }, 2000);
            
            // Trigger custom event
            $(document).trigger('avp:failed', { widget: $widget, settings: settings });
        }

        handleCancel(settings) {
            console.log('🚫 Age verification cancelled');
            
            // Redirect immediately if specified
            if (settings.failure_redirect) {
                window.location.href = settings.failure_redirect;
            }
        }

        closePopup($popup) {
            console.log('🔒 Attempting to close popup');
            let closeAttempted = false;
            
            // Method 1: Use Elementor Pro popup close with proper event handling
            if (typeof elementorProFrontend !== 'undefined' && 
                elementorProFrontend.modules && 
                elementorProFrontend.modules.popup) {
                console.log('🎯 Trying ElementorPro popup close method');
                try {
                    // Create a synthetic event object for ElementorPro
                    const syntheticEvent = {
                        type: 'click',
                        target: $popup[0],
                        currentTarget: $popup[0],
                        preventDefault: function() {},
                        stopPropagation: function() {}
                    };
                    elementorProFrontend.modules.popup.closePopup({}, syntheticEvent);
                    console.log('✅ ElementorPro popup close attempted');
                    closeAttempted = true;
                } catch (error) {
                    console.warn('⚠️ ElementorPro popup close failed:', error);
                }
            }
            
            // Method 2: Try ElementorPro alternative method
            if (typeof elementorProFrontend !== 'undefined' && 
                elementorProFrontend.modules && 
                elementorProFrontend.modules.popup && 
                elementorProFrontend.modules.popup.getModal) {
                console.log('🎯 Trying ElementorPro getModal close method');
                try {
                    const modal = elementorProFrontend.modules.popup.getModal();
                    if (modal && modal.hide) {
                        modal.hide();
                        console.log('✅ ElementorPro modal hide attempted');
                        closeAttempted = true;
                    }
                } catch (error) {
                    console.warn('⚠️ ElementorPro modal hide failed:', error);
                }
            }
            
            // Method 3: Use Elementor frontend close modal
            if (typeof elementorFrontend !== 'undefined' && 
                elementorFrontend.utils && 
                elementorFrontend.utils.closeModal) {
                console.log('🎯 Trying ElementorFree closeModal method');
                try {
                    elementorFrontend.utils.closeModal();
                    console.log('✅ ElementorFree closeModal attempted');
                    closeAttempted = true;
                } catch (error) {
                    console.warn('⚠️ ElementorFree closeModal failed:', error);
                }
            }
            
            // Method 4: Try clicking the close button
            const $closeBtn = $popup.find('.dialog-close-button, .eicon-close, .fa-close, .fa-times, [data-dismiss="modal"]');
            if ($closeBtn.length) {
                console.log('🎯 Trying close button click method');
                try {
                    $closeBtn.first().trigger('click');
                    console.log('✅ Close button click attempted');
                    closeAttempted = true;
                } catch (error) {
                    console.warn('⚠️ Close button click failed:', error);
                }
            }
            
            // Method 5: Try clicking the backdrop
            const $backdrop = $popup.find('.dialog-widget-content').parent();
            if ($backdrop.length) {
                console.log('🎯 Trying backdrop click method');
                try {
                    // Simulate clicking outside the content area
                    const clickEvent = new Event('click', { bubbles: true });
                    $backdrop[0].dispatchEvent(clickEvent);
                    console.log('✅ Backdrop click attempted');
                    closeAttempted = true;
                } catch (error) {
                    console.warn('⚠️ Backdrop click failed:', error);
                }
            }
            
            // Method 6: Force close with CSS and DOM manipulation
            console.log('🎯 Force closing with CSS manipulation');
            try {
                // Hide the popup with animation
                $popup.fadeOut(300, function() {
                    // Remove from DOM completely
                    $popup.remove();
                });
                
                // Also force hide any related popup elements
                $('.elementor-popup-modal').fadeOut(300);
                $('.dialog-overlay').fadeOut(300);
                $('.elementor-popup-overlay').fadeOut(300);
                
                // Remove popup classes from body
                $('body').removeClass('elementor-popup-modal-opened');
                
                console.log('✅ Force CSS close applied');
                closeAttempted = true;
            } catch (error) {
                console.warn('⚠️ Force CSS close failed:', error);
            }
            
            // Final verification - check if popup is still visible after all attempts
            setTimeout(() => {
                const stillVisible = $popup.is(':visible') && $popup.css('display') !== 'none';
                console.log('🔍 Popup still visible after all close attempts:', stillVisible);
                
                if (stillVisible) {
                    console.log('💥 EMERGENCY CLOSE - All methods failed, using nuclear option');
                    $popup.hide().remove();
                    $('.elementor-popup-modal').hide().remove();
                    $('.dialog-overlay').hide().remove();
                    $('body').removeClass('elementor-popup-modal-opened');
                }
            }, 500);
            
            if (closeAttempted) {
                console.log('🎯 Multiple close methods attempted');
            } else {
                console.log('❌ No close methods available, popup may remain open');
            }
        }

        showError($widget, message) {
            console.log('❌ Showing error:', message);
            const $errorMsg = $widget.find('.avp-error-message');
            if ($errorMsg.length) {
                $errorMsg.text(message).slideDown(200);
            } else {
                console.log('⚠️ No error message element found, using alert');
                alert(message);
            }
        }

        showSuccess($widget, message) {
            console.log('✅ Showing success:', message);
            const $successMsg = $widget.find('.avp-success-message');
            if ($successMsg.length) {
                $successMsg.text(message).slideDown(200);
            }
        }

        clearMessages($widget) {
            $widget.find('.avp-error-message').slideUp(200);
            $widget.find('.avp-success-message').slideUp(200);
        }

        isVerified() {
            const verified = this.getCookie('avp_verified') === '1';
            console.log('🍪 Checking verification status:', verified);
            
            // Debug cookie details
            console.log('🔍 Cookie debug info:');
            console.log('  - Raw cookie string:', document.cookie);
            console.log('  - avp_verified cookie value:', this.getCookie('avp_verified'));
            console.log('  - All cookies:', document.cookie.split(';').map(c => c.trim()));
            
            // Check if we're in private browsing mode
            const isPrivate = this.isPrivateBrowsing();
            console.log('  - Private browsing detected:', isPrivate);
            
            return verified;
        }

        setVerificationCookie(days) {
            const expires = new Date();
            expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
            
            // Use more specific cookie settings for better private browsing compatibility
            const cookieString = `avp_verified=1; expires=${expires.toUTCString()}; path=/; SameSite=Lax; Secure=${location.protocol === 'https:'}`;
            document.cookie = cookieString;
            
            console.log('🍪 Setting verification cookie for', days, 'days');
            console.log('🍪 Cookie string:', cookieString);
            console.log('🍪 Cookie set at:', new Date().toISOString());
            console.log('🍪 Cookie expires:', expires.toISOString());
            
            // Verify cookie was set
            setTimeout(() => {
                const verifySet = this.getCookie('avp_verified');
                console.log('🍪 Cookie verification check:', verifySet);
            }, 100);
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

        isPrivateBrowsing() {
            // Try to detect private browsing mode
            try {
                // Method 1: Check if localStorage is available and writable
                const testKey = 'avp-private-test';
                localStorage.setItem(testKey, '1');
                localStorage.removeItem(testKey);
                
                // Method 2: Check storage quota (private mode often has limited quota)
                if ('storage' in navigator && 'estimate' in navigator.storage) {
                    navigator.storage.estimate().then(estimate => {
                        console.log('🔍 Storage estimate:', estimate);
                        const isLimitedStorage = estimate.quota < 50 * 1024 * 1024; // Less than 50MB might indicate private mode
                        console.log('🔍 Limited storage (might be private):', isLimitedStorage);
                    });
                }
                
                return false; // LocalStorage works, probably not private
            } catch (e) {
                console.log('🔍 LocalStorage not available, might be private browsing');
                return true; // LocalStorage blocked, likely private
            }
        }

        clearVerification() {
            console.log('🧹 Clearing verification cookie...');
            
            // Set cookie to expire in the past
            const expiredDate = new Date(0).toUTCString();
            document.cookie = `avp_verified=; expires=${expiredDate}; path=/; SameSite=Lax`;
            
            // Also try to clear with different path variations
            document.cookie = `avp_verified=; expires=${expiredDate}; path=/; domain=${location.hostname}; SameSite=Lax`;
            document.cookie = `avp_verified=; expires=${expiredDate}; path=${location.pathname}; SameSite=Lax`;
            
            console.log('🧹 Verification cookie cleared');
            console.log('🧹 Remaining cookies:', document.cookie);
            
            // Force page reload to reset verification state
            setTimeout(() => {
                console.log('🔄 Reloading page to reset verification state...');
                location.reload();
            }, 500);
        }

        setupVerifiedUserPopupWatcher() {
            console.log('🔍 Setting up MutationObserver to watch for popup creation...');
            
            // Create a MutationObserver to watch for popup creation
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    mutation.addedNodes.forEach((node) => {
                        // Skip text nodes
                        if (node.nodeType !== 1) return;
                        
                        const $node = $(node);
                        
                        // Check if this node or its children contain our popup
                        const $foundPopup = $node.find('.avp-widget-content').closest('.elementor-popup-modal');
                        let $popup = null;
                        
                        if ($foundPopup.length) {
                            $popup = $foundPopup;
                            console.log('🎯 Found age verification popup in added node!');
                        } else if ($node.hasClass('elementor-popup-modal') && $node.find('.avp-widget-content').length) {
                            $popup = $node;
                            console.log('🎯 Added node IS the age verification popup!');
                        }
                        
                        if ($popup && $popup.length) {
                            console.log('💥 VERIFIED USER POPUP DETECTED - CLOSING IMMEDIATELY!');
                            
                            // Small delay to ensure popup is fully rendered
                            setTimeout(() => {
                                this.closePopup($popup);
                                
                                // Stop observing once we've handled the popup
                                observer.disconnect();
                                console.log('👁️ Popup watcher disconnected after successful close');
                            }, 50);
                        }
                    });
                });
            });
            
            // Start observing
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
            
            console.log('👁️ Popup watcher active - will auto-close any age verification popups');
            
            // Auto-disconnect after 10 seconds to prevent memory leaks
            setTimeout(() => {
                observer.disconnect();
                console.log('👁️ Popup watcher auto-disconnected after 10 seconds');
            }, 10000);
        }

        preventPopupForVerifiedUsers() {
            console.log('🔍 Checking if popup should be prevented...');
            
            // Quick cookie check
            const verified = this.getCookie('avp_verified') === '1';
            console.log('🍪 Quick verification check:', verified);
            
            if (!verified) {
                console.log('✅ User not verified, allowing popup to show');
                return;
            }
            
            console.log('🚫 User already verified - PREVENTING popup from showing');
            
            // Get popup ID from first widget found (since there's usually only one)
            let popupId = null;
            $('.avp-widget-content').each(function() {
                const $widget = $(this);
                const $settingsScript = $widget.find('.avp-widget-settings').first();
                if ($settingsScript.length) {
                    try {
                        const settings = JSON.parse($settingsScript.text());
                        if (settings.popup_id) {
                            popupId = settings.popup_id;
                            console.log('🎯 Found popup ID from settings:', popupId);
                            return false; // Break the loop
                        }
                    } catch (e) {
                        console.warn('⚠️ Failed to parse widget settings for popup ID');
                    }
                }
            });
            
            // If no popup ID in settings, try to detect from current popup
            if (!popupId) {
                const $currentPopup = $('.elementor-popup-modal').first();
                if ($currentPopup.length) {
                    const id = $currentPopup.attr('id');
                    if (id) {
                        popupId = id.replace('elementor-popup-modal-', '');
                        console.log('🔍 Detected popup ID from DOM:', popupId);
                    }
                }
            }
            
            if (!popupId) {
                console.warn('⚠️ No popup ID found, falling back to generic prevention');
                this.genericPopupPrevention();
                return;
            }
            
            console.log('🎯 Using specific popup ID prevention:', popupId);
            
            // Method 1: Immediate CSS hiding for specific popup
            const style = document.createElement('style');
            style.id = 'avp-verified-user-css';
            style.textContent = `
                #elementor-popup-modal-${popupId} {
                    display: none !important;
                    visibility: hidden !important;
                    opacity: 0 !important;
                }
            `;
            document.head.appendChild(style);
            console.log('🎨 CSS prevention rules applied for popup ID:', popupId);
            
            // Method 2: Hook into ElementorPro popup system for specific ID
            if (typeof elementorProFrontend !== 'undefined' && elementorProFrontend.modules && elementorProFrontend.modules.popup) {
                console.log('🎣 Setting up ElementorPro prevention for popup ID:', popupId);
                
                // Store original methods
                const originalShowPopup = elementorProFrontend.modules.popup.showPopup;
                
                if (originalShowPopup) {
                    elementorProFrontend.modules.popup.showPopup = function(settings, event) {
                        console.log('🚫 ElementorPro showPopup intercepted', settings);
                        
                        // Check if this is our age verification popup
                        if (settings && settings.id && settings.id.toString() === popupId.toString()) {
                            console.log('🚫 BLOCKED: Age verification popup prevented for ID:', popupId);
                            if (event && event.preventDefault) {
                                event.preventDefault();
                            }
                            return false; // Don't show the popup
                        }
                        
                        // Allow other popups to show normally
                        return originalShowPopup.apply(this, arguments);
                    };
                    console.log('✅ ElementorPro popup hook installed for ID:', popupId);
                }
            }
            
            // Method 3: Hide existing popup if already visible
            setTimeout(() => {
                const $specificPopup = $(`#elementor-popup-modal-${popupId}`);
                if ($specificPopup.length && $specificPopup.is(':visible')) {
                    console.log('🚫 Found visible popup, hiding it:', popupId);
                    $specificPopup.hide().css({
                        'display': 'none !important',
                        'visibility': 'hidden !important'
                    });
                }
            }, 50);
            
            console.log('🛡️ Specific popup prevention measures activated for ID:', popupId);
        }

        genericPopupPrevention() {
            console.log('🔧 Applying generic popup prevention fallback...');
            
            // Fallback to original generic method
            const style = document.createElement('style');
            style.id = 'avp-verified-user-css-generic';
            style.textContent = `
                .elementor-popup-modal:has(.avp-widget-content),
                .dialog-widget:has(.avp-widget-content),
                .dialog-lightbox-widget:has(.avp-widget-content) {
                    display: none !important;
                    visibility: hidden !important;
                    opacity: 0 !important;
                }
            `;
            document.head.appendChild(style);
            console.log('🎨 Generic CSS prevention rules applied');
        }
    }

    // Initialize the age verification popup
    console.log('🚀 Creating AgeVerificationPopup instance...');
    const avpInstance = new AgeVerificationPopup();

    // Expose for external use
    window.AgeVerificationPopup = AgeVerificationPopup;
    window.avpInstance = avpInstance;
    
    // Expose clear verification method for testing
    window.clearAgeVerification = function() {
        console.log('🧪 Clearing age verification from global method...');
        avpInstance.clearVerification();
    };
    
    console.log('🌐 AgeVerificationPopup exposed to window');
    console.log('🧪 Use clearAgeVerification() in console to reset verification');

})(jQuery); 