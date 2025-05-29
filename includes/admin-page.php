<?php
/**
 * Admin Page for Age Verification Popup Settings
 */

if (!defined('ABSPATH')) {
    exit;
}

// No form submission to handle for these settings anymore

// No need to get these options globally here anymore

?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="avp-help-text" style="margin-bottom: 20px; padding: 15px; background-color: #f7f7f7; border-left: 4px solid #72aee6;">
        <h4><?php _e('Plugin Configuration Information', 'age-verification-popup'); ?></h4>
        <p><?php _e('All operational and content settings for the Age Verification Popup are now managed directly within the <strong>Age Verification Popup widget in the Elementor editor</strong>.', 'age-verification-popup'); ?></p>
        <p><?php _e('This includes: Minimum Age, Success/Failure Redirect URLs, Cookie Duration, Popup Title, Messages, Button Texts, and Date Labels.', 'age-verification-popup'); ?></p>
        <p><?php _e('To configure a popup, please add or edit the Age Verification Popup widget in your Elementor templates (e.g., an Elementor Popup template).', 'age-verification-popup'); ?></p>
    </div>
    
    <div class="avp-admin-container">
        <div class="avp-admin-main">
            <p><?php _e('There are no global settings to configure here. Please use the Elementor widget for all configurations.', 'age-verification-popup'); ?></p>
            <?php
            // Example: You could add other non-settings related info here in the future if needed.
            // For example, links to documentation, support, or other tools.
            ?>
        </div>
        
        <div class="avp-admin-sidebar">
            <div class="postbox">
                <h3 class="hndle"><?php _e('How to Use', 'age-verification-popup'); ?></h3>
                <div class="inside">
                    <ol>
                        <li><?php _e('Go to Elementor and create or edit a popup template (or any page/template where you want the verification).', 'age-verification-popup'); ?></li>
                        <li><?php _e('Add the "Age Verification Popup" widget to your Elementor layout.', 'age-verification-popup'); ?></li>
                        <li><?php _e('Configure all settings (minimum age, redirects, messages, styling, etc.) directly in the widget controls in the Elementor editor panel.', 'age-verification-popup'); ?></li>
                        <li><?php _e('If using an Elementor Popup, set its display conditions as needed.', 'age-verification-popup'); ?></li>
                    </ol>
                </div>
            </div>
            
            <div class="postbox">
                <h3 class="hndle"><?php _e('Support', 'age-verification-popup'); ?></h3>
                <div class="inside">
                    <p><?php _e('Need help? Check out our documentation or contact support.', 'age-verification-popup'); ?></p>
                    <p>
                        <a href="#" class="button button-secondary" target="_blank"><?php _e('Documentation', 'age-verification-popup'); ?></a>
                        <a href="#" class="button button-secondary" target="_blank"><?php _e('Support', 'age-verification-popup'); ?></a>
                    </p>
                </div>
            </div>
            
            <div class="postbox">
                <h3 class="hndle"><?php _e('Clear Verification Data', 'age-verification-popup'); ?></h3>
                <div class="inside">
                    <p><?php _e('Use this to clear all stored verification cookies for testing purposes.', 'age-verification-popup'); ?></p>
                    <button type="button" id="avp-clear-cookies" class="button button-secondary">
                        <?php _e('Clear All Verification Cookies', 'age-verification-popup'); ?>
                    </button>
                    <p id="avp-clear-cookies-feedback" style="margin-top: 10px;"></p> 
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avp-admin-container {
    display: flex;
    gap: 20px;
    margin-top: 20px;
}

.avp-admin-main {
    flex: 1;
}

.avp-admin-sidebar {
    width: 300px;
}

.avp-admin-sidebar .postbox {
    margin-bottom: 20px;
}

.avp-admin-sidebar .postbox h3 {
    padding: 12px;
    margin: 0;
    background: #f1f1f1;
    border-bottom: 1px solid #ddd;
}

.avp-admin-sidebar .postbox .inside {
    padding: 12px;
}

.avp-admin-sidebar .postbox ol {
    padding-left: 20px;
}

.avp-admin-sidebar .postbox li {
    margin-bottom: 8px;
}
</style>

<script type="text/javascript">
jQuery(document).ready(function($) {
    $('#avp-clear-cookies').on('click', function() {
            var feedbackEl = $('#avp-clear-cookies-feedback');
            feedbackEl.text('<?php echo esc_js(__("Processing...", "age-verification-popup")); ?>').css('color', 'inherit');
            
            // Basic cookie clearing by setting expiry to the past
            // This will clear cookies accessible via JS for the current path and domain
            var cookies = document.cookie.split(";");
            var clearedCount = 0;
            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i];
                var eqPos = cookie.indexOf("=");
                var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
                if (name.trim().startsWith('avp_verified')) { // Target specific cookie
                    document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
                    clearedCount++;
                }
            }

            if (clearedCount > 0) {
                 feedbackEl.text('<?php echo esc_js(__("AVP verification cookie(s) cleared. You may need to reload the page to see changes on the frontend.", "age-verification-popup")); ?>').css('color', 'green');
            } else {
                 feedbackEl.text('<?php echo esc_js(__("No AVP verification cookies found to clear in the browser.", "age-verification-popup")); ?>').css('color', 'orange');
            }

            // Note: This only clears cookies accessible to JavaScript. 
            // HttpOnly cookies set by server-side (if any were) cannot be cleared this way.
            // Our current cookie is JS accessible, so this should work.
        });
});
</script> 