<?php
/**
 * Elementor Age Verification Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class AVP_Elementor_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'age-verification-popup';
    }

    public function get_title() {
        return __('Age Verification Popup', 'age-verification-popup');
    }

    public function get_icon() {
        return 'eicon-lock-user';
    }

    public function get_categories() {
        return ['age-verification'];
    }

    public function get_keywords() {
        return ['age', 'verification', 'popup', 'modal', '18+', 'adult'];
    }

    protected function register_controls() {
        
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'age-verification-popup'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'popup_title',
            [
                'label' => __('Popup Title', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Age Verification Required', 'age-verification-popup'),
                'placeholder' => __('Enter popup title', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'popup_message',
            [
                'label' => __('Popup Message', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('You must be 18 or older to access this website. Please enter your birth date to continue.', 'age-verification-popup'),
                'placeholder' => __('Enter popup message', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'date_label',
            [
                'label' => __('Date Input Label', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Enter your birth date:', 'age-verification-popup'),
                'placeholder' => __('Enter date label', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Verify Age', 'age-verification-popup'),
                'placeholder' => __('Enter button text', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'cancel_button_text',
            [
                'label' => __('Cancel Button Text', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('I am under 18', 'age-verification-popup'),
                'placeholder' => __('Enter cancel button text', 'age-verification-popup'),
            ]
        );

        $this->end_controls_section();

        // Settings Section
        $this->start_controls_section(
            'settings_section',
            [
                'label' => __('Display & Content Settings', 'age-verification-popup'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'settings_note',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<div style="background: #e8f4fd; padding: 10px; border-radius: 4px; border-left: 4px solid #2271b1;"><strong>' . __('Note:', 'age-verification-popup') . '</strong> ' . __('Core functionality settings (minimum age, redirects, cookie duration) are controlled in the WordPress admin under Age Verification. These settings below are for display and content customization only.', 'age-verification-popup') . '</div>',
            ]
        );

        $this->add_control(
            'show_on_load',
            [
                'label' => __('Show on Page Load', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'age-verification-popup'),
                'label_off' => __('No', 'age-verification-popup'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => __('Show popup automatically when page loads', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'trigger_selector',
            [
                'label' => __('Trigger Element Selector', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('.my-trigger-button', 'age-verification-popup'),
                'description' => __('CSS selector for element that triggers popup (if not showing on load)', 'age-verification-popup'),
                'condition' => [
                    'show_on_load!' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Popup Container
        $this->start_controls_section(
            'popup_style_section',
            [
                'label' => __('Popup Container', 'age-verification-popup'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'popup_width',
            [
                'label' => __('Width', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 300,
                        'max' => 800,
                    ],
                    '%' => [
                        'min' => 20,
                        'max' => 90,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'selectors' => [
                    '{{WRAPPER}} .avp-popup-content' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'popup_background',
            [
                'label' => __('Background Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .avp-popup-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'popup_border',
                'label' => __('Border', 'age-verification-popup'),
                'selector' => '{{WRAPPER}} .avp-popup-content',
            ]
        );

        $this->add_control(
            'popup_border_radius',
            [
                'label' => __('Border Radius', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .avp-popup-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'popup_box_shadow',
                'label' => __('Box Shadow', 'age-verification-popup'),
                'selector' => '{{WRAPPER}} .avp-popup-content',
            ]
        );

        $this->add_control(
            'popup_padding',
            [
                'label' => __('Padding', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .avp-popup-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Overlay
        $this->start_controls_section(
            'overlay_style_section',
            [
                'label' => __('Overlay', 'age-verification-popup'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'overlay_background',
            [
                'label' => __('Overlay Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.8)',
                'selectors' => [
                    '{{WRAPPER}} .avp-popup-overlay' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'overlay_blur',
            [
                'label' => __('Background Blur', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .avp-popup-overlay' => 'backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Typography
        $this->start_controls_section(
            'typography_style_section',
            [
                'label' => __('Typography', 'age-verification-popup'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography', 'age-verification-popup'),
                'selector' => '{{WRAPPER}} .avp-popup-title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .avp-popup-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'message_typography',
                'label' => __('Message Typography', 'age-verification-popup'),
                'selector' => '{{WRAPPER}} .avp-popup-message',
            ]
        );

        $this->add_control(
            'message_color',
            [
                'label' => __('Message Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .avp-popup-message' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Buttons
        $this->start_controls_section(
            'button_style_section',
            [
                'label' => __('Buttons', 'age-verification-popup'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __('Button Typography', 'age-verification-popup'),
                'selector' => '{{WRAPPER}} .avp-button',
            ]
        );

        $this->start_controls_tabs('button_style_tabs');

        $this->start_controls_tab(
            'button_normal_tab',
            [
                'label' => __('Normal', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Text Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .avp-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => __('Background Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#007cba',
                'selectors' => [
                    '{{WRAPPER}} .avp-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_hover_tab',
            [
                'label' => __('Hover', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'button_hover_text_color',
            [
                'label' => __('Text Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avp-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background_color',
            [
                'label' => __('Background Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avp-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => __('Border', 'age-verification-popup'),
                'selector' => '{{WRAPPER}} .avp-button',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .avp-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_padding',
            [
                'label' => __('Padding', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .avp-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Check if we're in Elementor editor mode
        $is_editor_mode = \Elementor\Plugin::$instance->editor->is_edit_mode();
        
        // Get global settings from admin panel for core functionality
        $global_settings = [
            'minimum_age' => get_option('avp_minimum_age', 18),
            'success_redirect' => get_option('avp_success_redirect', ''),
            'failure_redirect' => get_option('avp_failure_redirect', 'https://www.google.com'),
            'cookie_duration' => get_option('avp_cookie_duration', 30),
        ];
        
        // Use widget settings for content (with fallbacks to global settings)
        $content_settings = [
            'popup_title' => !empty($settings['popup_title']) ? $settings['popup_title'] : get_option('avp_popup_title', __('Age Verification Required', 'age-verification-popup')),
            'popup_message' => !empty($settings['popup_message']) ? $settings['popup_message'] : get_option('avp_popup_message', __('You must be 18 or older to access this website.', 'age-verification-popup')),
            'button_text' => !empty($settings['button_text']) ? $settings['button_text'] : get_option('avp_button_text', __('Verify Age', 'age-verification-popup')),
            'date_label' => !empty($settings['date_label']) ? $settings['date_label'] : get_option('avp_date_label', __('Enter your birth date:', 'age-verification-popup')),
            'cancel_button_text' => !empty($settings['cancel_button_text']) ? $settings['cancel_button_text'] : __('I am under 18', 'age-verification-popup'),
        ];
        
        // Generate unique ID for this widget instance
        $widget_id = 'avp-' . $this->get_id();
        
        // Add editor-specific class if in editor mode
        $widget_class = 'avp-widget';
        if ($is_editor_mode) {
            $widget_class .= ' avp-editor-mode';
        }
        
        ?>
        <div class="<?php echo esc_attr($widget_class); ?>" data-widget-id="<?php echo esc_attr($widget_id); ?>">
            <div class="avp-popup-overlay" id="<?php echo esc_attr($widget_id); ?>-overlay" style="<?php echo $is_editor_mode ? 'display: block; position: relative; background: rgba(0,0,0,0.1); min-height: 400px; display: flex; align-items: center; justify-content: center;' : 'display: none;'; ?>">
                <div class="avp-popup-content" style="<?php echo $is_editor_mode ? 'position: relative; transform: none; top: auto; left: auto; max-width: 500px; width: 90%; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);' : ''; ?>">
                    <div class="avp-popup-header" style="<?php echo $is_editor_mode ? 'text-align: center; margin-bottom: 20px;' : ''; ?>">
                        <h2 class="avp-popup-title" style="<?php echo $is_editor_mode ? 'margin: 0; font-size: 24px; color: #333;' : ''; ?>"><?php echo esc_html($content_settings['popup_title']); ?></h2>
                    </div>
                    
                    <div class="avp-popup-body" style="<?php echo $is_editor_mode ? 'margin-bottom: 25px;' : ''; ?>">
                        <p class="avp-popup-message" style="<?php echo $is_editor_mode ? 'margin: 0 0 20px; color: #666; line-height: 1.6;' : ''; ?>"><?php echo esc_html($content_settings['popup_message']); ?></p>
                        
                        <div class="avp-form-group">
                            <label for="<?php echo esc_attr($widget_id); ?>-birthdate" class="avp-date-label" style="<?php echo $is_editor_mode ? 'display: block; margin-bottom: 8px; font-weight: 500; color: #333;' : ''; ?>">
                                <?php echo esc_html($content_settings['date_label']); ?>
                            </label>
                            <input type="date" 
                                   id="<?php echo esc_attr($widget_id); ?>-birthdate" 
                                   class="avp-date-input" 
                                   style="<?php echo $is_editor_mode ? 'width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;' : ''; ?>"
                                   required>
                        </div>
                        
                        <div class="avp-error-message" style="display: none;"></div>
                    </div>
                    
                    <div class="avp-popup-footer" style="<?php echo $is_editor_mode ? 'display: flex; gap: 10px; justify-content: center;' : ''; ?>">
                        <button type="button" class="avp-button avp-verify-btn" style="<?php echo $is_editor_mode ? 'padding: 12px 24px; background: #007cba; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 500;' : ''; ?>">
                            <?php echo esc_html($content_settings['button_text']); ?>
                        </button>
                        <button type="button" class="avp-button avp-cancel-btn" style="<?php echo $is_editor_mode ? 'padding: 12px 24px; background: #666; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 500;' : ''; ?>">
                            <?php echo esc_html($content_settings['cancel_button_text']); ?>
                        </button>
                    </div>
                    
                    <?php if ($is_editor_mode): ?>
                    <div style="margin-top: 15px; text-align: center; font-size: 12px; color: #999; font-style: italic;">
                        <?php _e('Preview Mode - Popup will function normally on the frontend', 'age-verification-popup'); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <?php if (!$is_editor_mode): ?>
        <script type="application/json" class="avp-widget-settings">
        <?php echo wp_json_encode([
            'widget_id' => $widget_id,
            'minimum_age' => intval($global_settings['minimum_age']),
            'success_redirect' => $global_settings['success_redirect'],
            'failure_redirect' => $global_settings['failure_redirect'],
            'cookie_duration' => intval($global_settings['cookie_duration']),
            'show_on_load' => $settings['show_on_load'] === 'yes',
            'trigger_selector' => $settings['trigger_selector'] ?? '',
        ]); ?>
        </script>
        <?php endif; ?>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        var widgetId = 'avp-' + view.getID();
        
        // Provide fallbacks for empty settings
        var popupTitle = settings.popup_title || '<?php echo esc_js(__('Age Verification Required', 'age-verification-popup')); ?>';
        var popupMessage = settings.popup_message || '<?php echo esc_js(__('You must be 18 or older to access this website. Please enter your birth date to continue.', 'age-verification-popup')); ?>';
        var dateLabel = settings.date_label || '<?php echo esc_js(__('Enter your birth date:', 'age-verification-popup')); ?>';
        var buttonText = settings.button_text || '<?php echo esc_js(__('Verify Age', 'age-verification-popup')); ?>';
        var cancelButtonText = settings.cancel_button_text || '<?php echo esc_js(__('I am under 18', 'age-verification-popup')); ?>';
        #>
        <div class="avp-widget avp-preview-mode" data-widget-id="{{ widgetId }}">
            <div class="avp-popup-overlay" style="display: block; position: relative; background: rgba(0,0,0,0.1); min-height: 400px; display: flex; align-items: center; justify-content: center;">
                <div class="avp-popup-content" style="position: relative; transform: none; top: auto; left: auto; max-width: 500px; width: 90%; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                    <div class="avp-popup-header" style="text-align: center; margin-bottom: 20px;">
                        <h2 class="avp-popup-title" style="margin: 0; font-size: 24px; color: #333;">{{{ popupTitle }}}</h2>
                    </div>
                    
                    <div class="avp-popup-body" style="margin-bottom: 25px;">
                        <p class="avp-popup-message" style="margin: 0 0 20px; color: #666; line-height: 1.6;">{{{ popupMessage }}}</p>
                        
                        <div class="avp-form-group">
                            <label class="avp-date-label" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">{{{ dateLabel }}}</label>
                            <input type="date" class="avp-date-input" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                        </div>
                    </div>
                    
                    <div class="avp-popup-footer" style="display: flex; gap: 10px; justify-content: center;">
                        <button type="button" class="avp-button avp-verify-btn" style="padding: 12px 24px; background: #007cba; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 500;">{{{ buttonText }}}</button>
                        <button type="button" class="avp-button avp-cancel-btn" style="padding: 12px 24px; background: #666; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 500;">{{{ cancelButtonText }}}</button>
                    </div>
                    
                    <div style="margin-top: 15px; text-align: center; font-size: 12px; color: #999; font-style: italic;">
                        <?php _e('Preview Mode - Popup will function normally on the frontend', 'age-verification-popup'); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} 