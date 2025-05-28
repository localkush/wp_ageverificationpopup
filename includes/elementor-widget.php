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
                'label' => __('Settings', 'age-verification-popup'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'minimum_age',
            [
                'label' => __('Minimum Age', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 18,
                'min' => 13,
                'max' => 25,
                'step' => 1,
            ]
        );

        $this->add_control(
            'success_redirect',
            [
                'label' => __('Success Redirect URL', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('Leave empty to stay on current page', 'age-verification-popup'),
                'description' => __('Where to redirect users who pass verification (optional)', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'failure_redirect',
            [
                'label' => __('Failure Redirect URL', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://www.google.com', 'age-verification-popup'),
                'default' => [
                    'url' => 'https://www.google.com',
                ],
                'description' => __('Where to redirect users who fail verification', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'cookie_duration',
            [
                'label' => __('Remember Verification (Days)', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 30,
                'min' => 1,
                'max' => 365,
                'step' => 1,
                'description' => __('How long to remember successful verification', 'age-verification-popup'),
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
        
        // Generate unique ID for this widget instance
        $widget_id = 'avp-' . $this->get_id();
        
        ?>
        <div class="avp-widget" data-widget-id="<?php echo esc_attr($widget_id); ?>">
            <div class="avp-popup-overlay" id="<?php echo esc_attr($widget_id); ?>-overlay" style="display: none;">
                <div class="avp-popup-content">
                    <div class="avp-popup-header">
                        <h2 class="avp-popup-title"><?php echo esc_html($settings['popup_title']); ?></h2>
                    </div>
                    
                    <div class="avp-popup-body">
                        <p class="avp-popup-message"><?php echo esc_html($settings['popup_message']); ?></p>
                        
                        <div class="avp-form-group">
                            <label for="<?php echo esc_attr($widget_id); ?>-birthdate" class="avp-date-label">
                                <?php echo esc_html($settings['date_label']); ?>
                            </label>
                            <input type="date" 
                                   id="<?php echo esc_attr($widget_id); ?>-birthdate" 
                                   class="avp-date-input" 
                                   required>
                        </div>
                        
                        <div class="avp-error-message" style="display: none;"></div>
                    </div>
                    
                    <div class="avp-popup-footer">
                        <button type="button" class="avp-button avp-verify-btn">
                            <?php echo esc_html($settings['button_text']); ?>
                        </button>
                        <button type="button" class="avp-button avp-cancel-btn">
                            <?php echo esc_html($settings['cancel_button_text']); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <script type="application/json" class="avp-widget-settings">
        <?php echo wp_json_encode([
            'widget_id' => $widget_id,
            'minimum_age' => intval($settings['minimum_age']),
            'success_redirect' => !empty($settings['success_redirect']['url']) ? $settings['success_redirect']['url'] : '',
            'failure_redirect' => !empty($settings['failure_redirect']['url']) ? $settings['failure_redirect']['url'] : 'https://www.google.com',
            'cookie_duration' => intval($settings['cookie_duration']),
            'show_on_load' => $settings['show_on_load'] === 'yes',
            'trigger_selector' => $settings['trigger_selector'] ?? '',
        ]); ?>
        </script>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        var widgetId = 'avp-' + view.getID();
        #>
        <div class="avp-widget" data-widget-id="{{ widgetId }}">
            <div class="avp-popup-overlay" style="display: block; position: relative; background: rgba(0,0,0,0.1);">
                <div class="avp-popup-content" style="position: relative; transform: none; top: auto; left: auto;">
                    <div class="avp-popup-header">
                        <h2 class="avp-popup-title">{{{ settings.popup_title }}}</h2>
                    </div>
                    
                    <div class="avp-popup-body">
                        <p class="avp-popup-message">{{{ settings.popup_message }}}</p>
                        
                        <div class="avp-form-group">
                            <label class="avp-date-label">{{{ settings.date_label }}}</label>
                            <input type="date" class="avp-date-input" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                    </div>
                    
                    <div class="avp-popup-footer">
                        <button type="button" class="avp-button avp-verify-btn">{{{ settings.button_text }}}</button>
                        <button type="button" class="avp-button avp-cancel-btn">{{{ settings.cancel_button_text }}}</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} 