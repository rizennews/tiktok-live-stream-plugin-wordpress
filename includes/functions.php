<?php
// Caching Function
function getTikTokLiveStreamData($username) {
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
    $url = "https://www.tiktok.com/@$username/live"; // Hypothetical URL

    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
        return false;
    }

    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code == 404) {
        return false;
    }

    $body = wp_remote_retrieve_body($response);

    // Load the HTML into a DOMDocument
    $dom = new DOMDocument();
    @$dom->loadHTML($body); // Suppress warnings from malformed HTML

    // Use DOMXPath to query the DOM
    $xpath = new DOMXPath($dom);

    // Hypothetical query to find the live stream ID
    $nodes = $xpath->query("//div[@class='live-stream-id']");

    if ($nodes->length > 0) {
        return $nodes->item(0)->nodeValue;
    }

    return false;
}

// Shortcode Function
function displayTikTokLiveStream($atts) {
    $atts = shortcode_atts(array(
        'username' => 'default_username',
    ), $atts, 'tiktok_live_stream');

    $username = sanitize_text_field($atts['username']);
    $liveStreamId = getTikTokLiveStreamData($username);

    if ($liveStreamId) {
        return '<iframe src="https://www.tiktok.com/live/' . esc_attr($liveStreamId) . '" width="600" height="400" frameborder="0" allowfullscreen></iframe>';
    } else {
        return '<div class="no-live-stream" style="text-align:center; padding:20px; border:2px solid #ccc; border-radius:10px; background-color:#f9f9f9;">
                  <p style="font-size:18px; color:#555;">No live stream is currently available. Please check back later.</p>
                </div>';
    }
}
add_shortcode('tiktok_live_stream', 'displayTikTokLiveStream');

// Shortcode Function with Feedback Form
function displayTikTokLiveStreamWithFeedback($atts) {
    $atts = shortcode_atts(array(
        'username' => 'default_username',
    ), $atts, 'tiktok_live_stream_with_feedback');

    $username = sanitize_text_field($atts['username']);
    $liveStreamId = getTikTokLiveStreamData($username);

    ob_start();
    if ($liveStreamId) {
        echo '<iframe src="https://www.tiktok.com/live/' . esc_attr($liveStreamId) . '" width="600" height="400" frameborder="0" allowfullscreen></iframe>';
    } else {
        echo '<div class="no-live-stream" style="text-align:center; padding:20px; border:2px solid #ccc; border-radius:10px; background-color:#f9f9f9;">
                  <p style="font-size:18px; color:#555;">No live stream is currently available. Please check back later.</p>
                </div>';
    }
    displayTikTokFeedbackForm();
    return ob_get_clean();
}
add_shortcode('tiktok_live_stream_with_feedback', 'displayTikTokLiveStreamWithFeedback');
?>
