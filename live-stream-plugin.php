<?php
/*
Plugin Name: TikTok Live Stream Plugin
Plugin URI: https://github.com/rizennews/tiktok-live-stream-plugin-wordpress
Description: Custom Plugin to embed live streams from TikTok.
Version: 1.0
Author: Padmore Aning
Author URI: https://github.com/rizennews
*/

// Include plugin settings page
require_once plugin_dir_path(__FILE__) . 'includes/settings-page.php';

// Include additional functions
require_once plugin_dir_path(__FILE__) . 'includes/additional-functions.php';

// Include plugin functions
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';

// Include plugin widget
require_once plugin_dir_path(__FILE__) . 'includes/widget.php';

// Load text domain for translations
function loadTikTokLiveStreamTextDomain() {
    load_plugin_textdomain('tiktok-live-stream', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'loadTikTokLiveStreamTextDomain');
