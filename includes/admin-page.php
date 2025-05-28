<?php
/**
 * Admin Page for Age Verification Popup Settings
 */

if (!defined('ABSPATH')) {
    exit;
}

// Handle form submission
if (isset($_POST['submit']) && wp_verify_nonce($_POST['avp_nonce'], 'avp_settings')) {
    update_option('avp_minimum_age', intval($_POST['avp_minimum_age']));
    update_option('avp_success_redirect', sanitize_url($_POST['avp_success_redirect']));
    update_option('avp_failure_redirect', sanitize_url($_POST['avp_failure_redirect']));
    update_option('avp_cookie_duration', intval($_POST['avp_cookie_duration']));
    update_option('avp_popup_title', sanitize_text_field($_POST['avp_popup_title']));
    update_option('avp_popup_message', sanitize_textarea_field($_POST['avp_popup_message']));
    update_option('avp_button_text', sanitize_text_field($_POST['avp_button_text']));
    update_option('avp_date_label', sanitize_text_field($_POST['avp_date_label']));
    
    echo '<div class="notice notice-success is-dismissible"><p>' . __('Settings saved successfully!', 'age-verification-popup') . '</p></div>';
}

// Get current settings
$minimum_age = get_option('avp_minimum_age', 18);
$success_redirect = get_option('avp_success_redirect', '');
$failure_redirect = get_option('avp_failure_redirect', 'https://www.google.com');
$cookie_duration = get_option('avp_cookie_duration', 30);
$popup_title = get_option('avp_popup_title', __('Age Verification Required', 'age-verification-popup'));
$popup_message = get_option('avp_popup_message', __('You must be 18 or older to access this website.', 'age-verification-popup'));
$button_text = get_option('avp_button_text', __('Verify Age', 'age-verification-popup'));
$date_label = get_option('avp_date_label', __('Enter your birth date:', 'age-verification-popup'));
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="avp-help-text">
        <h4><?php _e('Global Default Settings', 'age-verification-popup'); ?></h4>
        <p><?php _e('These are the default settings that will be used by all Age Verification widgets. You can override styling and some content settings in individual Elementor widgets, but core functionality settings (like minimum age and redirect URLs) are controlled here.', 'age-verification-popup'); ?></p>
    </div>
    
    <div class="avp-admin-container">
        <div class="avp-admin-main">
            <form method="post" action="">
                <?php wp_nonce_field('avp_settings', 'avp_nonce'); ?>
                
                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="avp_minimum_age"><?php _e('Minimum Age', 'age-verification-popup'); ?></label>
                            </th>
                            <td>
                                <input type="number" 
                                       id="avp_minimum_age" 
                                       name="avp_minimum_age" 
                                       value="<?php echo esc_attr($minimum_age); ?>" 
                                       min="13" 
                                       max="25" 
                                       class="small-text" />
                                <p class="description"><?php _e('Minimum age required to access the website.', 'age-verification-popup'); ?></p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="avp_success_redirect"><?php _e('Success Redirect URL', 'age-verification-popup'); ?></label>
                            </th>
                            <td>
                                <input type="url" 
                                       id="avp_success_redirect" 
                                       name="avp_success_redirect" 
                                       value="<?php echo esc_attr($success_redirect); ?>" 
                                       class="regular-text" 
                                       placeholder="<?php _e('Leave empty to stay on current page', 'age-verification-popup'); ?>" />
                                <p class="description"><?php _e('Where to redirect users who pass age verification (optional).', 'age-verification-popup'); ?></p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="avp_failure_redirect"><?php _e('Failure Redirect URL', 'age-verification-popup'); ?></label>
                            </th>
                            <td>
                                <input type="url" 
                                       id="avp_failure_redirect" 
                                       name="avp_failure_redirect" 
                                       value="<?php echo esc_attr($failure_redirect); ?>" 
                                       class="regular-text" 
                                       placeholder="https://www.google.com" 
                                       required />
                                <p class="description"><?php _e('Where to redirect users who fail age verification.', 'age-verification-popup'); ?></p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="avp_cookie_duration"><?php _e('Remember Verification (Days)', 'age-verification-popup'); ?></label>
                            </th>
                            <td>
                                <input type="number" 
                                       id="avp_cookie_duration" 
                                       name="avp_cookie_duration" 
                                       value="<?php echo esc_attr($cookie_duration); ?>" 
                                       min="1" 
                                       max="365" 
                                       class="small-text" />
                                <p class="description"><?php _e('How many days to remember successful verification.', 'age-verification-popup'); ?></p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="avp_popup_title"><?php _e('Popup Title', 'age-verification-popup'); ?></label>
                            </th>
                            <td>
                                <input type="text" 
                                       id="avp_popup_title" 
                                       name="avp_popup_title" 
                                       value="<?php echo esc_attr($popup_title); ?>" 
                                       class="regular-text" />
                                <p class="description"><?php _e('Title displayed in the age verification popup.', 'age-verification-popup'); ?></p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="avp_popup_message"><?php _e('Popup Message', 'age-verification-popup'); ?></label>
                            </th>
                            <td>
                                <textarea id="avp_popup_message" 
                                          name="avp_popup_message" 
                                          rows="3" 
                                          class="large-text"><?php echo esc_textarea($popup_message); ?></textarea>
                                <p class="description"><?php _e('Message displayed in the age verification popup.', 'age-verification-popup'); ?></p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="avp_button_text"><?php _e('Verify Button Text', 'age-verification-popup'); ?></label>
                            </th>
                            <td>
                                <input type="text" 
                                       id="avp_button_text" 
                                       name="avp_button_text" 
                                       value="<?php echo esc_attr($button_text); ?>" 
                                       class="regular-text" />
                                <p class="description"><?php _e('Text for the age verification button.', 'age-verification-popup'); ?></p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="avp_date_label"><?php _e('Date Input Label', 'age-verification-popup'); ?></label>
                            </th>
                            <td>
                                <input type="text" 
                                       id="avp_date_label" 
                                       name="avp_date_label" 
                                       value="<?php echo esc_attr($date_label); ?>" 
                                       class="regular-text" />
                                <p class="description"><?php _e('Label for the birth date input field.', 'age-verification-popup'); ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <?php submit_button(); ?>
            </form>
        </div>
        
        <div class="avp-admin-sidebar">
            <div class="postbox">
                <h3 class="hndle"><?php _e('How to Use', 'age-verification-popup'); ?></h3>
                <div class="inside">
                    <ol>
                        <li><?php _e('Configure your global settings above and save them.', 'age-verification-popup'); ?></li>
                        <li><?php _e('Go to Elementor and create a new popup template.', 'age-verification-popup'); ?></li>
                        <li><?php _e('Add the "Age Verification Popup" widget to your popup.', 'age-verification-popup'); ?></li>
                        <li><?php _e('Customize the styling in the widget (colors, fonts, spacing, etc.).', 'age-verification-popup'); ?></li>
                        <li><?php _e('Set the popup display conditions as needed.', 'age-verification-popup'); ?></li>
                    </ol>
                    
                    <h4><?php _e('Settings Priority', 'age-verification-popup'); ?></h4>
                    <p><?php _e('Core functionality (minimum age, redirects, cookie duration) is controlled here in the admin panel. The Elementor widget focuses on styling and visual customization.', 'age-verification-popup'); ?></p>
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

@media (max-width: 782px) {
    .avp-admin-container {
        flex-direction: column;
    }
    
    .avp-admin-sidebar {
        width: 100%;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    $('#avp-clear-cookies').on('click', function() {
        // Clear the verification cookie
        document.cookie = 'avp_verified=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        alert('<?php _e('Verification cookies cleared!', 'age-verification-popup'); ?>');
    });
});
</script> 