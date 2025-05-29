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
                'description' => __('You can use HTML tags like &lt;br&gt; for line breaks, &lt;strong&gt; for bold text, etc.', 'age-verification-popup'),
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

        // Core Functionality Settings Section
        $this->start_controls_section(
            'core_functionality_settings_section',
            [
                'label' => __('Core Functionality Settings', 'age-verification-popup'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'minimum_age',
            [
                'label' => __('Minimum Age', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 120,
                'step' => 1,
                'default' => 18,
                'description' => __('The minimum age required for verification.', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'success_redirect_url',
            [
                'label' => __('Success Redirect URL', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => __('https://example.com/success', 'age-verification-popup'),
                'default' => '',
                'description' => __('URL to redirect to on successful verification. Leave empty for no redirect.', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'failure_redirect_url',
            [
                'label' => __('Failure/Cancel Redirect URL', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => __('https://example.com/failure', 'age-verification-popup'),
                'default' => '',
                'description' => __('URL to redirect to on failed verification or if the cancel button is clicked. Leave empty for no redirect.', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'cookie_duration',
            [
                'label' => __('Verification Cookie Duration (Days)', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 365,
                'step' => 1,
                'default' => 30,
                'description' => __('How long the verification cookie should last, in days.', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'popup_id',
            [
                'label' => __('Elementor Popup ID', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('589', 'age-verification-popup'),
                'default' => '',
                'description' => __('The Elementor popup ID for precise control. You can find this in the popup URL or inspect element.', 'age-verification-popup'),
            ]
        );

        $this->end_controls_section();

        // Display Options Section (Renamed from "Display & Content Settings")
        $this->start_controls_section(
            'display_options_section', // Changed ID from 'settings_section'
            [
                'label' => __('Display Options', 'age-verification-popup'), // Renamed Label
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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

        // Messages Section
        $this->start_controls_section(
            'messages_section',
            [
                'label' => __('Success & Error Messages', 'age-verification-popup'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'success_message',
            [
                'label' => __('Success Message', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Age verified successfully!', 'age-verification-popup'),
                'placeholder' => __('Enter success message', 'age-verification-popup'),
                'description' => __('Message shown when age verification succeeds', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'error_message_template',
            [
                'label' => __('Error Message Template', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('You must be {age} or older to access this website.', 'age-verification-popup'),
                'placeholder' => __('Enter error message template', 'age-verification-popup'),
                'description' => __('Use {age} placeholder for minimum age. Example: "You must be {age} or older."', 'age-verification-popup'),
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
                    '{{WRAPPER}} .avp-widget-content' => 'width: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .avp-widget-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'popup_border',
                'label' => __('Border', 'age-verification-popup'),
                'selector' => '{{WRAPPER}} .avp-widget-content',
            ]
        );

        $this->add_control(
            'popup_border_radius',
            [
                'label' => __('Border Radius', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .avp-widget-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'popup_box_shadow',
                'label' => __('Box Shadow', 'age-verification-popup'),
                'selector' => '{{WRAPPER}} .avp-widget-content',
            ]
        );

        $this->add_control(
            'content_alignment',
            [
                'label' => __('Content Alignment', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'age-verification-popup'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'age-verification-popup'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'age-verification-popup'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justify', 'age-verification-popup'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .avp-widget-content' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'popup_padding',
            [
                'label' => __('Padding', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .avp-widget-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Typography
        $this->start_controls_section(
            'typography_style_section',
            [
                'label' => __('Typography & Colors', 'age-verification-popup'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_title_styles',
            [
                'label' => __('Popup Title', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .avp-title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avp-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_message_styles',
            [
                'label' => __('Popup Message', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'message_typography',
                'selector' => '{{WRAPPER}} .avp-message',
            ]
        );

        $this->add_control(
            'message_color',
            [
                'label' => __('Message Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avp-message' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_date_label_styles',
            [
                'label' => __('Date Input Label', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'date_label_typography',
                'selector' => '{{WRAPPER}} .avp-date-label',
            ]
        );

        $this->add_control(
            'date_label_color',
            [
                'label' => __('Date Label Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avp-date-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Spacing
        $this->start_controls_section(
            'spacing_style_section',
            [
                'label' => __('Spacing', 'age-verification-popup'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_spacing',
            [
                'label' => __('Title Bottom Spacing', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .avp-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'message_spacing',
            [
                'label' => __('Message Bottom Spacing', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 25,
                ],
                'selectors' => [
                    '{{WRAPPER}} .avp-message' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'date_label_spacing',
            [
                'label' => __('Date Label Bottom Spacing', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .avp-date-label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'date_input_spacing',
            [
                'label' => __('Date Input Bottom Spacing', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .avp-date-input' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'buttons_spacing',
            [
                'label' => __('Space Between Buttons', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .avp-verify-btn' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'buttons_top_spacing',
            [
                'label' => __('Buttons Top Spacing', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .avp-buttons' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section(); // End Spacing Section

        // Style Section - Verify Button
        $this->start_controls_section(
            'verify_button_style_section',
            [
                'label' => __('Verify Button Style', 'age-verification-popup'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'verify_button_typography',
                'label' => __('Typography', 'age-verification-popup'),
                'selector' => '{{WRAPPER}} .avp-verify-btn',
            ]
        );

        $this->add_control(
            'verify_button_padding',
            [
                'label' => __('Padding', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .avp-verify-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'verify_button_border',
                'label' => __('Border', 'age-verification-popup'),
                'selector' => '{{WRAPPER}} .avp-verify-btn',
            ]
        );

        $this->add_control(
            'verify_button_border_radius',
            [
                'label' => __('Border Radius', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .avp-verify-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('verify_button_style_tabs');

        $this->start_controls_tab(
            'verify_button_normal_tab',
            [
                'label' => __('Normal', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'verify_button_text_color',
            [
                'label' => __('Text Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avp-verify-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'verify_button_background_color',
            [
                'label' => __('Background Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avp-verify-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'verify_button_hover_tab',
            [
                'label' => __('Hover', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'verify_button_text_hover_color',
            [
                'label' => __('Text Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avp-verify-btn:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .avp-verify-btn:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'verify_button_background_hover_color',
            [
                'label' => __('Background Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avp-verify-btn:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .avp-verify-btn:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'verify_button_border_hover_color',
            [
                'label' => __('Border Hover Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avp-verify-btn:hover' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .avp-verify-btn:focus' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'verify_button_border_border!' => '',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); // End Verify Button Style Section

        // Style Section - Cancel Button
        $this->start_controls_section(
            'cancel_button_style_section',
            [
                'label' => __('Cancel Button Style', 'age-verification-popup'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cancel_button_typography',
                'label' => __('Typography', 'age-verification-popup'),
                'selector' => '{{WRAPPER}} .avp-cancel-btn',
            ]
        );

        $this->add_control(
            'cancel_button_padding',
            [
                'label' => __('Padding', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .avp-cancel-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'cancel_button_border',
                'label' => __('Border', 'age-verification-popup'),
                'selector' => '{{WRAPPER}} .avp-cancel-btn',
            ]
        );

        $this->add_control(
            'cancel_button_border_radius',
            [
                'label' => __('Border Radius', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .avp-cancel-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('cancel_button_style_tabs');

        $this->start_controls_tab(
            'cancel_button_normal_tab',
            [
                'label' => __('Normal', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'cancel_button_text_color',
            [
                'label' => __('Text Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avp-cancel-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cancel_button_background_color',
            [
                'label' => __('Background Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avp-cancel-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'cancel_button_hover_tab',
            [
                'label' => __('Hover', 'age-verification-popup'),
            ]
        );

        $this->add_control(
            'cancel_button_text_hover_color',
            [
                'label' => __('Text Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avp-cancel-btn:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .avp-cancel-btn:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cancel_button_background_hover_color',
            [
                'label' => __('Background Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avp-cancel-btn:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .avp-cancel-btn:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cancel_button_border_hover_color',
            [
                'label' => __('Border Hover Color', 'age-verification-popup'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avp-cancel-btn:hover' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .avp-cancel-btn:focus' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'cancel_button_border_border!' => '',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); // End Cancel Button Style Section
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = 'avp-widget-' . $this->get_id();

        // Core settings from the widget
        $minimum_age = !empty($settings['minimum_age']) ? intval($settings['minimum_age']) : 18;
        $success_redirect = !empty($settings['success_redirect_url']) ? esc_url($settings['success_redirect_url']) : '';
        $failure_redirect = !empty($settings['failure_redirect_url']) ? esc_url($settings['failure_redirect_url']) : '';
        $cookie_duration = !empty($settings['cookie_duration']) ? intval($settings['cookie_duration']) : 30;
        
        // Content settings from the widget
        $popup_title = !empty($settings['popup_title']) ? esc_html($settings['popup_title']) : __('Age Verification Required', 'age-verification-popup');
        $popup_message = !empty($settings['popup_message']) ? wp_kses($settings['popup_message'], array('br' => array(), 'strong' => array(), 'em' => array(), 'b' => array(), 'i' => array())) : __('You must be 18 or older to access this website. Please enter your birth date to continue.', 'age-verification-popup');
        $date_label = !empty($settings['date_label']) ? esc_html($settings['date_label']) : __('Enter your birth date:', 'age-verification-popup');
        $button_text = !empty($settings['button_text']) ? esc_html($settings['button_text']) : __('Verify Age', 'age-verification-popup');
        $cancel_button_text = !empty($settings['cancel_button_text']) ? esc_html($settings['cancel_button_text']) : __('I am under 18', 'age-verification-popup');

        // Message settings from the widget
        $success_message = !empty($settings['success_message']) ? esc_html($settings['success_message']) : __('Age verified successfully!', 'age-verification-popup');
        $error_message_template = !empty($settings['error_message_template']) ? esc_html($settings['error_message_template']) : __('You must be {age} or older to access this website.', 'age-verification-popup');
        
        // Display options from the widget
        $show_on_load = ($settings['show_on_load'] === 'yes');
        $trigger_selector = !empty($settings['trigger_selector']) ? esc_attr($settings['trigger_selector']) : '';
        
        // Popup ID from the widget  
        $popup_id = !empty($settings['popup_id']) ? esc_attr($settings['popup_id']) : '';

        // Prepare settings for JavaScript
        $js_settings = [
            'widget_id' => $widget_id,
            'minimum_age' => $minimum_age,
            'success_redirect' => $success_redirect,
            'failure_redirect' => $failure_redirect,
            'cookie_duration' => $cookie_duration,
            'show_on_load' => $show_on_load,
            'trigger_selector' => $trigger_selector,
            'popup_id' => $popup_id,
            'success_message' => $success_message,
            'error_message_template' => str_replace('{age}', $minimum_age, $error_message_template) // Pre-replace {age} for JS
        ];

        $this->add_render_attribute('wrapper', 'class', 'avp-widget-content');
        $this->add_render_attribute('wrapper', 'id', $widget_id);

        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            $this->add_render_attribute('wrapper', 'class', 'avp-editor-mode');
        }
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <h2 class="avp-title"><?php echo $popup_title; ?></h2>
            <p class="avp-message"><?php echo $popup_message; ?></p>
                        
            <div class="avp-form">
                <label for="avp-date-input-<?php echo esc_attr($this->get_id()); ?>" class="avp-date-label"><?php echo $date_label; ?></label>
                <input type="date" id="avp-date-input-<?php echo esc_attr($this->get_id()); ?>" class="avp-date-input" aria-label="<?php echo esc_attr($date_label); ?>">
                <div class="avp-error-message" style="display:none;"></div>
                <div class="avp-success-message" style="display:none;"></div>
                <div class="avp-buttons">
                    <button class="avp-verify-btn elementor-button"><?php echo $button_text; ?></button>
                    <button class="avp-cancel-btn elementor-button elementor-button-link"><?php echo $cancel_button_text; ?></button>
                </div>
            </div>
        </div>
        
        <?php if (!\Elementor\Plugin::$instance->editor->is_edit_mode()) : ?>
        <script type="application/json" class="avp-widget-settings">
            <?php echo json_encode($js_settings); ?>
        </script>
        <?php endif; ?>
        <?php
    }

    protected function content_template() {
        $widget_id_placeholder = 'avp-widget-{{ view.getID() }}';
        ?>
        <#
        var widget_id = 'avp-widget-' + view.getID();

        // Default values for content_template, mirroring render() logic where possible
        var minimum_age = settings.minimum_age ? parseInt(settings.minimum_age) : 18;
        var success_redirect = settings.success_redirect_url ? settings.success_redirect_url : '';
        var failure_redirect = settings.failure_redirect_url ? settings.failure_redirect_url : '';
        var cookie_duration = settings.cookie_duration ? parseInt(settings.cookie_duration) : 30;

        var popup_title = settings.popup_title || '<?php echo esc_js(__('Age Verification Required', 'age-verification-popup')); ?>';
        var popup_message = settings.popup_message || '<?php echo esc_js(__('You must be 18 or older to access this website. Please enter your birth date to continue.', 'age-verification-popup')); ?>';
        var date_label = settings.date_label || '<?php echo esc_js(__('Enter your birth date:', 'age-verification-popup')); ?>';
        var button_text = settings.button_text || '<?php echo esc_js(__('Verify Age', 'age-verification-popup')); ?>';
        var cancel_button_text = settings.cancel_button_text || '<?php echo esc_js(__('I am under 18', 'age-verification-popup')); ?>';
        
        var success_message = settings.success_message || '<?php echo esc_js(__('Age verified successfully!', 'age-verification-popup')); ?>';
        var error_message_template = settings.error_message_template || '<?php echo esc_js(__('You must be {age} or older to access this website.', 'age-verification-popup')); ?>';
        error_message_template = error_message_template.replace('{age}', minimum_age);


        var wrapper_class = 'avp-widget-content';
        if (typeof elementor !== 'undefined' && elementor.editor && typeof elementor.editor.isEditMode === 'function' && elementor.editor.isEditMode()) {
            wrapper_class += ' avp-editor-mode avp-preview-mode'; // Add preview mode for editor styling
        }
        #>
        <div id="{{ widget_id }}" class="{{ wrapper_class }}">
            <h2 class="avp-title">{{{ popup_title }}}</h2>
            <p class="avp-message">{{{ popup_message }}}</p>
                        
            <div class="avp-form">
                <label for="avp-date-input-{{ view.getID() }}" class="avp-date-label">{{{ date_label }}}</label>
                <input type="date" id="avp-date-input-{{ view.getID() }}" class="avp-date-input" aria-label="{{ date_label }}">
                <div class="avp-error-message" style="display:none;"></div>
                <div class="avp-success-message" style="display:none;"></div>
                <div class="avp-buttons">
                    <button class="avp-verify-btn elementor-button">{{{ button_text }}}</button>
                    <button class="avp-cancel-btn elementor-button elementor-button-link">{{{ cancel_button_text }}}</button>
                </div>
            </div>
        </div>

        <#
        // Simulate settings script for preview if needed, or rely on default JS behavior
        var js_settings_preview = {
            widget_id: widget_id,
            minimum_age: minimum_age,
            success_redirect: success_redirect,
            failure_redirect: failure_redirect,
            cookie_duration: cookie_duration,
            show_on_load: settings.show_on_load === 'yes',
            trigger_selector: settings.trigger_selector || '',
            popup_id: settings.popup_id || '',
            success_message: success_message,
            error_message_template: error_message_template
        };
        #>
        <?php
    }
} 