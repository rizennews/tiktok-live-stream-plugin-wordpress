<?php
class TikTokLiveStreamWidget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'tiktok_live_stream_widget',
            'TikTok Live Stream Widget',
            array('description' => 'A widget to display TikTok live streams')
        );
    }

    public function widget($args, $instance) {
        $username = !empty($instance['username']) ? $instance['username'] : 'default_username';
        $liveStreamId = getTikTokLiveStreamData($username);

        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        if ($liveStreamId) {
            echo '<iframe src="https://www.tiktok.com/live/' . esc_attr($liveStreamId) . '" width="600" height="400"></iframe>';
        } else {
            echo handleTikTokError();
        }
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $username = !empty($instance['username']) ? $instance['username'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('username'); ?>">TikTok Username:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo esc_attr($username); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['username'] = sanitize_text_field($new_instance['username']);
        return $instance;
    }
}

function register_tiktok_live_stream_widget() {
    register_widget('TikTokLiveStreamWidget');
}
add_action('widgets_init', 'register_tiktok_live_stream_widget');
?>