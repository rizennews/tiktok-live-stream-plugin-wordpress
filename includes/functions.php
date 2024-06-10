<?php
// Function to fetch TikTok Live stream data
function fetchTikTokLiveStreamData($username) {
    // Construct URL for TikTok Live stream
    $url = "https://www.tiktok.com/@{$username}?is_copy_url=0&is_from_webapp=v1&lang=en";

    // Make request to TikTok profile page
    $response = wp_remote_get($url);

    // Check for successful response
    if (!is_wp_error($response)) {
        $body = wp_remote_retrieve_body($response);
        preg_match('/"id":"(.*?)"/', $body, $matches);
        
        // Check if live video data exists
        if (isset($matches[1])) {
            return $matches[1];
        }
    }
    
    return false;
}

// Function to generate HTML output with embedded TikTok live stream
function displayTikTokLiveStream($username) {
    // Get TikTok Live stream data
    $liveStreamId = getTikTokLiveStreamDataWithCache($username);

    // Generate HTML output with embedded live stream
    if ($liveStreamId) {
        $output = '<div class="tiktok-live-stream">';
        $output .= '<h2>TikTok Live Stream</h2>';
        $output .= '<p>ID: ' . sanitize_text_field($liveStreamId) . '</p>';
        $output .= '</div>';
        return $output;
    } else {
        return '<p>No live stream available at the moment.</p>';
    }
}

// Shortcode to display TikTok Live stream
function tiktokLiveStreamShortcode($atts) {
    $atts = shortcode_atts(array(
        'username' => ''
    ), $atts);
    
    return displayTikTokLiveStream($atts['username']);
}
add_shortcode('tiktok_live_stream', 'tiktokLiveStreamShortcode');
