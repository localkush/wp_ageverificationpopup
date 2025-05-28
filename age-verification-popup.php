<?php
/**
 * Plugin Name: Age Verification Popup for Elementor
 * Plugin URI: https://creativewebconcept.ca
 * Description: A customizable age verification popup that integrates with Elementor Pro. Verify user age with configurable settings and redirect options.
 * Version: 1.0.0
 * Author: Charles W. (localkush@github)
 * License: GPL v2 or later
 * Text Domain: age-verification-popup
 * Elementor tested up to: 3.18.0
 * Elementor Pro tested up to: 3.18.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('AVP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('AVP_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('AVP_PLUGIN_VERSION', '1.0.0');

/**
 * Main Age Verification Popup Class
 */
class AgeVerificationPopup {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('init', array($this, 'init'));
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        
        // Check if Elementor is active
        add_action('plugins_loaded', array($this, 'check_elementor'));
        
        // Register activation and deactivation hooks
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    public function init() {
        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        
        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Initialize Elementor widget
        add_action('elementor/widgets/widgets_registered', array($this, 'register_elementor_widget'));
        add_action('elementor/elements/categories_registered', array($this, 'add_elementor_widget_categories'));
        
        // AJAX handlers
        add_action('wp_ajax_verify_age', array($this, 'verify_age_ajax'));
        add_action('wp_ajax_nopriv_verify_age', array($this, 'verify_age_ajax'));
    }
    
    public function load_textdomain() {
        load_plugin_textdomain('age-verification-popup', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
    
    public function check_elementor() {
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', array($this, 'admin_notice_missing_elementor'));
            return;
        }
        
        // Check for minimum Elementor version
        if (!version_compare(ELEMENTOR_VERSION, '3.0.0', '>=')) {
            add_action('admin_notices', array($this, 'admin_notice_minimum_elementor_version'));
            return;
        }
    }
    
    public function admin_notice_missing_elementor() {
        if (isset($_GET['activate'])) unset($_GET['activate']);
        
        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'age-verification-popup'),
            '<strong>' . esc_html__('Age Verification Popup for Elementor', 'age-verification-popup') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'age-verification-popup') . '</strong>'
        );
        
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
    
    public function admin_notice_minimum_elementor_version() {
        if (isset($_GET['activate'])) unset($_GET['activate']);
        
        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'age-verification-popup'),
            '<strong>' . esc_html__('Age Verification Popup for Elementor', 'age-verification-popup') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'age-verification-popup') . '</strong>',
            '3.0.0'
        );
        
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
    
    public function enqueue_scripts() {
        wp_enqueue_script('avp-frontend', AVP_PLUGIN_URL . 'assets/js/frontend.js', array('jquery'), AVP_PLUGIN_VERSION, true);
        wp_enqueue_style('avp-frontend', AVP_PLUGIN_URL . 'assets/css/frontend.css', array(), AVP_PLUGIN_VERSION);
        
        // Localize script for AJAX
        wp_localize_script('avp-frontend', 'avp_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('avp_nonce'),
            'settings' => $this->get_plugin_settings()
        ));
    }
    
    public function admin_enqueue_scripts($hook) {
        if ('toplevel_page_age-verification-popup' !== $hook) {
            return;
        }
        
        wp_enqueue_script('avp-admin', AVP_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), AVP_PLUGIN_VERSION, true);
        wp_enqueue_style('avp-admin', AVP_PLUGIN_URL . 'assets/css/admin.css', array(), AVP_PLUGIN_VERSION);
    }
    
    public function add_admin_menu() {
        add_menu_page(
            __('Age Verification', 'age-verification-popup'),
            __('Age Verification', 'age-verification-popup'),
            'manage_options',
            'age-verification-popup',
            array($this, 'admin_page'),
            'dashicons-shield-alt',
            30
        );
    }
    
    public function admin_page() {
        include_once AVP_PLUGIN_PATH . 'includes/admin-page.php';
    }
    
    public function add_elementor_widget_categories($elements_manager) {
        $elements_manager->add_category(
            'age-verification',
            array(
                'title' => __('Age Verification', 'age-verification-popup'),
                'icon' => 'fa fa-shield-alt',
            )
        );
    }
    
    public function register_elementor_widget() {
        require_once AVP_PLUGIN_PATH . 'includes/elementor-widget.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \AVP_Elementor_Widget());
    }
    
    public function verify_age_ajax() {
        check_ajax_referer('avp_nonce', 'nonce');
        
        $birth_date = sanitize_text_field($_POST['birth_date']);
        $minimum_age = intval(get_option('avp_minimum_age', 18));
        
        if (empty($birth_date)) {
            wp_send_json_error(array('message' => __('Please enter your birth date.', 'age-verification-popup')));
        }
        
        $birth_timestamp = strtotime($birth_date);
        $minimum_timestamp = strtotime("-{$minimum_age} years");
        
        if ($birth_timestamp <= $minimum_timestamp) {
            // User is old enough
            setcookie('avp_verified', '1', time() + (86400 * 30), '/'); // 30 days
            wp_send_json_success(array(
                'verified' => true,
                'redirect_url' => get_option('avp_success_redirect', '')
            ));
        } else {
            // User is too young
            wp_send_json_success(array(
                'verified' => false,
                'redirect_url' => get_option('avp_failure_redirect', 'https://www.google.com')
            ));
        }
    }
    
    public function get_plugin_settings() {
        return array(
            'minimum_age' => get_option('avp_minimum_age', 18),
            'success_redirect' => get_option('avp_success_redirect', ''),
            'failure_redirect' => get_option('avp_failure_redirect', 'https://www.google.com'),
            'cookie_duration' => get_option('avp_cookie_duration', 30),
            'popup_title' => get_option('avp_popup_title', __('Age Verification Required', 'age-verification-popup')),
            'popup_message' => get_option('avp_popup_message', __('You must be 18 or older to access this website.', 'age-verification-popup')),
            'button_text' => get_option('avp_button_text', __('Verify Age', 'age-verification-popup')),
            'date_label' => get_option('avp_date_label', __('Enter your birth date:', 'age-verification-popup'))
        );
    }
    
    public function activate() {
        // Set default options
        add_option('avp_minimum_age', 18);
        add_option('avp_success_redirect', '');
        add_option('avp_failure_redirect', 'https://www.google.com');
        add_option('avp_cookie_duration', 30);
        add_option('avp_popup_title', __('Age Verification Required', 'age-verification-popup'));
        add_option('avp_popup_message', __('You must be 18 or older to access this website.', 'age-verification-popup'));
        add_option('avp_button_text', __('Verify Age', 'age-verification-popup'));
        add_option('avp_date_label', __('Enter your birth date:', 'age-verification-popup'));
    }
    
    public function deactivate() {
        // Clean up if needed
    }
}

// Initialize the plugin
AgeVerificationPopup::get_instance(); 
