<?php
// Add plugin settings page
function tiktok_live_stream_plugin_settings_page() {
    add_options_page(
        'TikTok Live Stream Plugin Settings',
        'TikTok Live Settings',
        'manage_options',
        'tiktok-live-stream-plugin',
        'tiktok_live_stream_plugin_settings_page_content'
    );
}
add_action('admin_menu', 'tiktok_live_stream_plugin_settings_page');

// Render plugin settings page content
function tiktok_live_stream_plugin_settings_page_content() {
    ?>
    <div class="wrap">
        <h1>TikTok Live Stream Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('tiktok_live_stream_settings_group'); ?>
            <?php do_settings_sections('tiktok-live-stream-plugin'); ?>
            <?php submit_button('Save Settings'); ?>
        </form>
        <p>To display the TikTok Live stream on your website, use the following shortcode on any page or post:</p>
        <pre>[tiktok_live_stream username="USERNAME"]</pre>
        <p>Replace "USERNAME" with your TikTok username (without the @ symbol).</p>
        <p>To display the TikTok Live stream and feedback form on your website, use the following shortcode on any page or post:</p>
        <pre>[tiktok_live_stream_with_feedback username="USERNAME"]</pre>
        <p>Replace "USERNAME" with your TikTok username (without the @ symbol).</p>
        <p>If you find this plugin helpful, consider buying us a coffee!</p>
        <a href="https://www.buymeacoffee.com/designolabs" target="_blank">
            <img src="https://img.buymeacoffee.com/button-api/?text=Buy%20us%20a%20coffee&emoji=&slug=yourusername&button_colour=FFDD00&font_colour=000000&font_family=Cookie&outline_colour=000000&coffee_colour=ffffff">
        </a>
        <p>This plugin was developed by <a href="https://github.com/rizennews/" target="_blank">Designolabs Studio</a>.</p>
    </div>
    <?php
}

// Initialize plugin settings
function tiktok_live_stream_plugin_initialize_settings() {
    register_setting(
        'tiktok_live_stream_settings_group',
        'tiktok_live_stream_settings'
    );

    add_settings_section(
        'tiktok_live_stream_settings_section',
        'TikTok Live Stream Settings',
        'tiktok_live_stream_settings_section_callback',
        'tiktok-live-stream-plugin'
    );

    add_settings_field(
        'tiktok_live_stream_settings_field',
        'TikTok Live Stream Settings',
        'tiktok_live_stream_settings_field_callback',
        'tiktok-live-stream-plugin',
        'tiktok_live_stream_settings_section'
    );
}
add_action('admin_init', 'tiktok_live_stream_plugin_initialize_settings');

// Callback function to render TikTok Live Stream Settings field
function tiktok_live_stream_settings_field_callback() {
    $settings = get_option('tiktok_live_stream_settings');
    ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">TikTok Username (without @)</th>
            <td><input type="text" name="tiktok_live_stream_settings[tiktok_username]" value="<?php echo esc_attr($settings['tiktok_username']); ?>" /></td>
        </tr>
    </table>
    <?php
}

// Callback function to render TikTok Live Stream Settings section
function tiktok_live_stream_settings_section_callback() {
    echo '<p>Enter your TikTok username below (without the @ symbol).</p>';
}
?>
