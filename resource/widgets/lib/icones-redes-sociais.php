<?php

/*

Plugin Name: Flickr
Plugin URI: http://themeforest.net/user/Tauris/
Description: Display images from Flickr.
Version: 1.0
Author: Tauris
Author URI: http://themeforest.net/user/Tauris/

*/


/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'vntd_widget_social_icons' );

/* Function that registers our widget. */
function vntd_widget_social_icons() {
	register_widget( 'Vntd_Widget_social_icons' );
}

// Widget class.
class Vntd_Widget_social_icons extends WP_Widget {


	function Vntd_Widget_social_icons() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'pr_widget_social_icons', 'description' => 'Display your Social Icons.' );

		/* Create the widget. */
		$this->WP_Widget( 'vntd_widget_social_icons', 'Veented Social Icons', $widget_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$address = $instance['address'];
		$phone = $instance['phone'];
		$email = $instance['email'];
		$website = $instance['website'];
		$showmap = $instance['showmap'];
		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display name from widget settings. */

		?>
        
        <div class="widget-social-icons">
        	<?php
        	
        	vntd_print_social_icons('rounded');

        	?>
        </div> 
                 
                        
        <?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}
	
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Follow Us');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
        
        
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>">Widget Title:</label>
        <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p> 

        
        <?php
	}
}

	
