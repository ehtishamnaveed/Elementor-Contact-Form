<?php
/**
 * Plugin Name: Modern Elementor Contact Form
 * Description: Elementor-based contact form with native PHP mail(), AJAX, and webhook support.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;

// Load widget
add_action('elementor/widgets/register', function($widgets_manager) {
    require_once __DIR__ . '/widget-contact-form.php';
});

// Enqueue JS and CSS
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script('mecf-script', plugin_dir_url(__FILE__) . 'form.js', ['jquery'], null, true);
    wp_enqueue_style('mecf-style', plugin_dir_url(__FILE__) . 'form-style.css');
});

// AJAX handler
add_action('wp_ajax_mecf_submit_form', 'mecf_handle_form');
add_action('wp_ajax_nopriv_mecf_submit_form', 'mecf_handle_form');

function mecf_handle_form() {
    check_ajax_referer('mecf_nonce', 'nonce');

    $name    = sanitize_text_field($_POST['name']);
    $email   = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);
    $to      = sanitize_email($_POST['to_email']);
    $webhook = esc_url_raw($_POST['webhook']);

    $subject = "New Contact Message from $name";
    $body = "<strong>Name:</strong> $name<br><strong>Email:</strong> $email<br><strong>Message:</strong><br>$message";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    $sent = mail($to, $subject, $body, $headers);

    if ($webhook) {
        wp_remote_post($webhook, [
            'body' => ['name' => $name, 'email' => $email, 'message' => $message]
        ]);
    }

    if ($sent) {
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
