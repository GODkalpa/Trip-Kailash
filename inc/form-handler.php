<?php
/**
 * Contact Form Handler
 * Handles AJAX form submissions and sends emails via wp_mail()
 *
 * @package TripKailash
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle contact form AJAX submission
 */
function tk_handle_contact_form()
{
    // Verify nonce for security
    if (!isset($_POST['tk_contact_nonce']) || !wp_verify_nonce($_POST['tk_contact_nonce'], 'tk_contact_form')) {
        wp_send_json_error(array(
            'message' => __('Security verification failed. Please refresh the page and try again.', 'trip-kailash')
        ));
        return;
    }

    // Honeypot spam check - if this field is filled, it's a bot
    if (!empty($_POST['tk_website_url'])) {
        // Silently pretend success to fool bots
        wp_send_json_success(array(
            'message' => __('Thank you for your message!', 'trip-kailash')
        ));
        return;
    }

    // Sanitize form data
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $package = isset($_POST['package_interest']) ? sanitize_text_field($_POST['package_interest']) : '';
    $travel_month = isset($_POST['travel_month']) ? sanitize_text_field($_POST['travel_month']) : '';
    $group_size = isset($_POST['group_size']) ? absint($_POST['group_size']) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
    $recipient = isset($_POST['email_recipient']) ? sanitize_email($_POST['email_recipient']) : get_option('admin_email');

    // Validate required fields
    if (empty($name)) {
        wp_send_json_error(array(
            'message' => __('Please enter your name.', 'trip-kailash')
        ));
        return;
    }

    if (empty($email) || !is_email($email)) {
        wp_send_json_error(array(
            'message' => __('Please enter a valid email address.', 'trip-kailash')
        ));
        return;
    }

    // Validate recipient email
    if (empty($recipient) || !is_email($recipient)) {
        $recipient = get_option('admin_email');
    }

    // Build email subject
    $site_name = get_bloginfo('name');
    $subject = sprintf(
        /* translators: 1: Site name, 2: Sender name */
        __('[%1$s] New Inquiry from %2$s', 'trip-kailash'),
        $site_name,
        $name
    );

    // Build email body
    $body = sprintf(__('You have received a new inquiry from your website.', 'trip-kailash')) . "\n\n";
    $body .= "================================\n\n";
    $body .= sprintf(__('Name: %s', 'trip-kailash'), $name) . "\n";
    $body .= sprintf(__('Email: %s', 'trip-kailash'), $email) . "\n";

    if (!empty($package)) {
        $body .= sprintf(__('Package Interest: %s', 'trip-kailash'), $package) . "\n";
    }

    if (!empty($travel_month)) {
        $body .= sprintf(__('Preferred Travel Month: %s', 'trip-kailash'), $travel_month) . "\n";
    }

    if (!empty($group_size)) {
        $body .= sprintf(__('Group Size: %d', 'trip-kailash'), $group_size) . "\n";
    }

    $body .= "\n" . __('Message:', 'trip-kailash') . "\n";
    $body .= "--------------------------------\n";
    $body .= (!empty($message) ? $message : __('(No message provided)', 'trip-kailash')) . "\n";
    $body .= "--------------------------------\n\n";

    $body .= sprintf(__('Sent from: %s', 'trip-kailash'), home_url()) . "\n";
    $body .= sprintf(__('Date: %s', 'trip-kailash'), wp_date('F j, Y \a\t g:i a')) . "\n";

    // Email headers
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>',
    );

    // Debug logging - helps identify issues
    error_log('Trip Kailash Form: Attempting to send email to: ' . $recipient);
    error_log('Trip Kailash Form: Subject: ' . $subject);
    error_log('Trip Kailash Form: From: ' . $name . ' <' . $email . '>');

    // Send email using wp_mail (WP Mail SMTP will intercept this)
    $sent = wp_mail($recipient, $subject, $body, $headers);

    // Debug: Log the result
    error_log('Trip Kailash Form: wp_mail returned: ' . ($sent ? 'true' : 'false'));

    if ($sent) {
        // Log successful submission (optional - can be removed in production)
        do_action('tk_contact_form_sent', array(
            'name' => $name,
            'email' => $email,
            'package' => $package,
        ));

        wp_send_json_success(array(
            'message' => __('Thank you for your message. We will get back to you soon!', 'trip-kailash')
        ));
    } else {
        // Get the last mail error if available
        global $phpmailer;
        $mail_error = '';
        if (isset($phpmailer) && is_object($phpmailer) && isset($phpmailer->ErrorInfo)) {
            $mail_error = $phpmailer->ErrorInfo;
        }

        // Log error for debugging
        error_log('Trip Kailash: Failed to send contact form email to ' . $recipient);
        error_log('Trip Kailash: Mail error: ' . $mail_error);

        wp_send_json_error(array(
            'message' => __('Sorry, there was an error sending your message. Please try again or contact us directly.', 'trip-kailash')
        ));
    }
}

// Register AJAX handlers for both logged-in and logged-out users
add_action('wp_ajax_tk_submit_contact_form', 'tk_handle_contact_form');
add_action('wp_ajax_nopriv_tk_submit_contact_form', 'tk_handle_contact_form');

/**
 * Add rate limiting to prevent form abuse
 */
function tk_check_form_rate_limit()
{
    $ip = $_SERVER['REMOTE_ADDR'];
    $transient_key = 'tk_form_limit_' . md5($ip);
    $submissions = get_transient($transient_key);

    if ($submissions >= 5) {
        wp_send_json_error(array(
            'message' => __('Too many submissions. Please try again later.', 'trip-kailash')
        ));
        exit;
    }

    // Increment counter (expires in 1 hour)
    set_transient($transient_key, ($submissions ? $submissions + 1 : 1), HOUR_IN_SECONDS);
}
add_action('wp_ajax_tk_submit_contact_form', 'tk_check_form_rate_limit', 5);
add_action('wp_ajax_nopriv_tk_submit_contact_form', 'tk_check_form_rate_limit', 5);
