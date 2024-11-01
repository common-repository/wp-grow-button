<?php


class Growbutton_Widget extends WP_Widget {
	function Growbutton_Widget() {
		// widget actual processes
		$widget_ops = array('classname' => 'wp-grow-button-area', 'description' => 'This makes it easy to add the Grow! button' );
		$control_ops = array('width' => '100%');
		$this->WP_Widget('GrowbuttonWidget', 'Grow Button Widget', $widget_ops, $control_ops);
	}

	function form($instance) {
		echo 'Please set the Grow button than a setting window.';
		
		echo '<a href="';
		echo get_bloginfo('home');
		echo '/wp-admin/options-general.php?page=wp-grow-button/wp-grow-button.php">setting page.</a>';
	}

	function update($new_instance, $old_instance) {
		// processes widget options to be saved
		
	}

	function widget($args, $instance) {
		extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		$site_name   = get_bloginfo('name');
		$site_name   = get_bloginfo('name');
		$link        = get_bloginfo('home');
		$button_type = get_option(WP_GROWBUTTON_OPTIONS_BUTTON_TYPE);
		
		$out = wp_growbutton_the_content_out($title , $site_name , $link , $title , $button_type);
		
		echo $args['before_widget']."\n";
		echo $args['before_title']. 'Grow!' .$args['after_title']."\n";
		echo $out."\n";
		echo $args['after_widget']."\n";
	}

}

/**
 * growbutton_widget初期化
 */
function growbutton_widget_init() {
	register_widget('Growbutton_Widget');
}
//widgets_initアクション時にMyWidgetInit関数を実行
add_action('widgets_init', 'growbutton_widget_init');
?>