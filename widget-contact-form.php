<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit;

class Modern_Contact_Form_Widget extends Widget_Base {

    public function get_name() {
        return 'modern_contact_form';
    }

    public function get_title() {
        return __('Modern Contact Form', 'plugin-name');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function _register_controls() {
        // Content Section
        $this->start_controls_section('form_content', [
            'label' => __('Form Content', 'plugin-name')
        ]);

        $this->add_control('form_title', [
            'label' => __('Form Title', 'plugin-name'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Contact Us', 'plugin-name'),
        ]);

        $this->add_control('button_text', [
            'label' => __('Button Text', 'plugin-name'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Send', 'plugin-name'),
        ]);

        $this->add_control('recipient_email', [
            'label' => __('Recipient Email', 'plugin-name'),
            'type' => Controls_Manager::TEXT,
            'default' => get_option('admin_email'),
        ]);

        $this->add_control('webhook_url', [
            'label' => __('Zapier Webhook URL (optional)', 'plugin-name'),
            'type' => Controls_Manager::URL,
            'placeholder' => 'https://hooks.zapier.com/hooks/catch/...',
        ]);

        $this->add_control('success_msg', [
            'label' => __('Success Message', 'plugin-name'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Thank you! Your message was sent.', 'plugin-name'),
        ]);

        $this->add_control('error_msg', [
            'label' => __('Error Message', 'plugin-name'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Something went wrong. Please try again.', 'plugin-name'),
        ]);

        $this->end_controls_section();

        // Style: Input Fields
        $this->start_controls_section('input_style', [
            'label' => __('Input Fields', 'plugin-name'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('input_border_radius', [
            'label' => __('Border Radius', 'plugin-name'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 50]],
            'selectors' => [
                '{{WRAPPER}} .mecf-form input, {{WRAPPER}} .mecf-form textarea' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'input_typography',
            'selector' => '{{WRAPPER}} .mecf-form input, {{WRAPPER}} .mecf-form textarea',
        ]);

        $this->add_control('input_text_color', [
            'label' => __('Text Color', 'plugin-name'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .mecf-form input, {{WRAPPER}} .mecf-form textarea' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('input_background_color', [
            'label' => __('Background Color', 'plugin-name'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .mecf-form input, {{WRAPPER}} .mecf-form textarea' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        // Style: Button
        $this->start_controls_section('button_style', [
            'label' => __('Submit Button', 'plugin-name'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('button_text_color', [
            'label' => __('Text Color', 'plugin-name'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .mecf-form button' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('button_background_color', [
            'label' => __('Background Color', 'plugin-name'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .mecf-form button' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'button_typography',
            'selector' => '{{WRAPPER}} .mecf-form button',
        ]);

        $this->add_control('button_border_radius', [
            'label' => __('Border Radius', 'plugin-name'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 50]],
            'selectors' => [
                '{{WRAPPER}} .mecf-form button' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $form_id = 'mecf_' . $this->get_id();

        wp_localize_script('mecf-script', $form_id, [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('mecf_nonce'),
            'email' => $settings['recipient_email'],
            'webhook' => $settings['webhook_url']['url'],
            'success' => $settings['success_msg'],
            'error' => $settings['error_msg'],
        ]);
        ?>
        <div class="mecf-wrapper">
            <h3><?php echo esc_html($settings['form_title']); ?></h3>
            <form id="<?php echo esc_attr($form_id); ?>" class="mecf-form">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" required></textarea>
                <button type="submit"><?php echo esc_html($settings['button_text']); ?></button>
                <div class="mecf-response"></div>
            </form>
        </div>
        <?php
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Modern_Contact_Form_Widget());
