<?php
// Caching Function
function getTikTokLiveStreamData($username) {
    $username = ltrim($username, '@'); // Ensure the username does not start with @
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

// Function to fetch TikTok live stream data
function fetchTikTokLiveStreamData($username) {
    // Fetch data from TikTok API or perform web scraping to get the live stream data
    // For demonstration purposes, we'll return a mock data
    $liveStreamId = '123456789';
    return $liveStreamId;
}

// Shortcode Function
function displayTikTokLiveStream($atts) {
    $atts = shortcode_atts(array(
        'username' => 'default_username',
    ), $atts, 'tiktok_live_stream');

    $username = ltrim(sanitize_text_field($atts['username']), '@'); // Sanitize and remove @ if present
    $liveStreamId = getTikTokLiveStreamData($username);

    if ($liveStreamId) {
        return '<iframe src="https://www.tiktok.com/live/' . esc_attr($liveStreamId) . '" width="600" height="400"></iframe>';
    } else {
        return handleTikTokError();
    }
}
add_shortcode('tiktok_live_stream', 'displayTikTokLiveStream');

// Shortcode Function with Feedback Form
function displayTikTokLiveStreamWithFeedback($atts) {
    $atts = shortcode_atts(array(
        'username' => 'default_username',
    ), $atts, 'tiktok_live_stream_with_feedback');

    $username = ltrim(sanitize_text_field($atts['username']), '@'); // Sanitize and remove @ if present
    $liveStreamId = getTikTokLiveStreamData($username);

    ob_start();
    if ($liveStreamId) {
        echo '<iframe src="https://www.tiktok.com/live/' . esc_attr($liveStreamId) . '" width="600" height="400"></iframe>';
    } else {
        echo handleTikTokError();
    }
    displayTikTokFeedbackForm();
    return ob_get_clean();
}
add_shortcode('tiktok_live_stream_with_feedback', 'displayTikTokLiveStreamWithFeedback');
?>
