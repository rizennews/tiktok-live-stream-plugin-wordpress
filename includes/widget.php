<?php
// Widget Class
class TikTok_Live_Stream_Widget extends WP_Widget {
    // Constructor
    public function __construct() {
        parent::__construct(
            'tiktok_live_stream_widget',
            'TikTok Live Stream Widget',
            array( 'description' => 'Display TikTok Live Stream' )
        );
    }

    // Widget Output
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo $args['before_title'] . 'TikTok Live Stream' . $args['after_title'];
        echo '[tiktok_live_stream username="' . esc_attr( $instance['username'] ) . '"]';
        echo $args['after_widget'];
    }

    // Widget Form
    public function form( $instance ) {
        $username = ! empty( $instance['username'] ) ? $instance['username'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'username' ); ?>">TikTok Username:</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>">
        </p>
        <?php
    }

    // Update Widget
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['username'] = ( ! empty( $new_instance['username'] ) ) ? sanitize_text_field( $new_instance['username'] ) : '';
        return $instance;
    }
}

// Register Widget
function register_tiktok_live_stream_widget() {
    register_widget( 'TikTok_Live_Stream_Widget' );
}
add_action( 'widgets_init', 'register_tiktok_live_stream_widget' );
