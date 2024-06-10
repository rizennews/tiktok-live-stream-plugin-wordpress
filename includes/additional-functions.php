<?php
// Error Handling Function
function handleTikTokError() {
    return '<p>There was an error fetching the TikTok live stream data. Please try again later.</p>';
}

// Translation Function
function loadTikTokLiveStreamTextDomain() {
    load_plugin_textdomain( 'tiktok-live-stream', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'loadTikTokLiveStreamTextDomain' );

// Caching Function
function getTikTokLiveStreamDataWithCache($username) {
    $cache_key = 'tiktok_live_stream_' . $username;
    $liveStreamId = get_transient($cache_key);

    if (false === $liveStreamId) {
        // Fetch data from TikTok
        $liveStreamId = fetchTikTokLiveStreamData($username);

        // Cache the data for 1 hour
        set_transient($cache_key, $liveStreamId, HOUR_IN_SECONDS);
    }

    return $liveStreamId;
}

// Compatibility Function
function checkTikTokLiveStreamCompatibility() {
    // Check if the active theme is Hello Elementor
    $theme = wp_get_theme();
    $theme_name = $theme->get('Name');
    if ($theme_name === 'Hello Elementor') {
        echo '<p>For optimal performance with the Hello Elementor theme, make sure to enable the plugin settings in the theme options panel.</p>';
    }

    // Check if the Live Stream plugin is active
    if (is_plugin_active('livestream/livestream.php')) {
        echo '<p>For compatibility with the Live Stream plugin, ensure that the plugin settings are configured correctly in the Live Stream settings page.</p>';
    }

    // Check for other themes or plugins and provide guidance accordingly
    if (is_plugin_active('another-plugin/another-plugin.php')) {
        echo '<p>For compatibility with Another Plugin, ensure that the plugin settings are configured correctly in the Another Plugin settings page.</p>';
    }

    if ($theme_name === 'Another Theme') {
        echo '<p>For optimal performance with Another Theme, make sure to customize the plugin settings according to the theme requirements.</p>';
    }
}

// Security Function
function sanitizeTikTokLiveStreamData($data) {
    return wp_kses_post($data);
}

// Feedback Function
function displayTikTokFeedbackForm() {
    ?>
    <div class="tiktok-feedback-form">
        <h2>Feedback Form</h2>
        <p>We value your feedback! Please use the form below to submit your suggestions and requests:</p>
        <form id="tiktok-feedback-form" method="post">
            <label for="feedback-name">Name:</label>
            <input type="text" id="feedback-name" name="feedback-name" required>
            <label for="feedback-email">Email:</label>
            <input type="email" id="feedback-email" name="feedback-email" required>
            <label for="feedback-message">Message:</label>
            <textarea id="feedback-message" name="feedback-message" rows="4" required></textarea>
            <input type="submit" value="Submit">
        </form>
    </div>
    <?php
}

// Form Submission Handler
function handleTikTokFeedbackFormSubmission() {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback-name'], $_POST['feedback-email'], $_POST['feedback-message'])) {
        // Retrieve and sanitize form data
        $name = sanitize_text_field($_POST['feedback-name']);
        $email = sanitize_email($_POST['feedback-email']);
        $message = sanitize_textarea_field($_POST['feedback-message']);

        // Send email notification to site admin
        $to = get_option('admin_email');
        $subject = 'Feedback from TikTok Live Stream Plugin';
        $body = "Name: $name\nEmail: $email\n\n$message";
        $headers = array('Content-Type: text/html; charset=UTF-8');

        // Send email
        wp_mail($to, $subject, $body, $headers);

        // Display success message
        echo '<p>Your feedback has been submitted successfully. Thank you!</p>';
    }
}
add_action('init', 'handleTikTokFeedbackFormSubmission');

// Shortcode to display TikTok Live stream and feedback form
function tiktokLiveStreamWithFeedbackShortcode() {
    $output = '<div class="livestream-container">';
    $output .= displayTikTokLiveStream('');
    $output .= '</div>';
    $output .= '<div class="feedback-form-container">';
    $output .= displayTikTokFeedbackForm();
    $output .= '</div>';

    return $output;
}
add_shortcode('tiktok_live_stream_with_feedback', 'tiktokLiveStreamWithFeedbackShortcode');
