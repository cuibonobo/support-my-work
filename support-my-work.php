<?php
/*
Plugin Name: Support My Work
Plugin URI: https://github.com/jenmontes/support-my-work
Description: Display a "Buy Now" PayPal button where users can enter they amount.
Version: 0.1
Author: Jen Montes
Author URI: http://jenmontes.com
License: CC0
*/

class Support_My_Work extends WP_Widget {
	function __construct() {
		parent::__construct(false, $name = 'Support My Work', array( 'description' => 'A variable amount "Buy Now" PayPal button.' ) );
	}
	
	/*
	 * Displays the widget form in the admin panel
	 */
	function form( $instance ) {
		$widget_title = esc_attr( $instance['widget_title'] );
		$input_label = esc_attr( $instance['input_label'] );
		$business_id = esc_attr( $instance['business_id'] );
		$custom_button = esc_attr( $instance['custom_button'] );
		$item_name = "Support my work";
		
		if (isset( $instance['item_name'] )) {
			$item_name = esc_attr( $instance['item_name']);
		}
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'widget_title' ); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'widget_title' ); ?>" name="<?php echo $this->get_field_name( 'widget_title' ); ?>" type="text" value="<?php echo $widget_title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'input_label' ); ?>">Input label:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'input_label' ); ?>" name="<?php echo $this->get_field_name( 'input_label' ); ?>" type="text" value="<?php echo $input_label; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'business_id' ); ?>">PayPal email address:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'business_id' ); ?>" name="<?php echo $this->get_field_name( 'business_id' ); ?>" type="text" value="<?php echo $business_id; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'custom_button' ); ?>">Custom button image URL:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'custom_button' ); ?>" name="<?php echo $this->get_field_name( 'custom_button' ); ?>" type="text" value="<?php echo $custom_button; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'item_name' ); ?>">Name of the item (defaults to "Support my work"):</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'item_name' ); ?>" name="<?php echo $this->get_field_name( 'item_name' ); ?>" type="text" value="<?php echo $item_name; ?>" />
		</p>
		
		<?php
	}
	
	/*
	 * Renders the widget in the sidebar
	 */
	function widget( $args, $instance ) {
		echo $args['before_widget'];
		?>
		<?php if ($instance['widget_title']): ?>
		<h5 class="widget-title"><?php echo $instance['widget_title']; ?></h5>
		<?php endif; ?>
		<form id="support-my-work-form" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="paypal">
		<p><?php echo(isset($instance['input_label']) ? $instance['input_label'] : "Pay what you want:"); ?></p>
		<input type="text" name="amount" style="margin-bottom: 5px;">
		<input type="image" src="<?php if ($instance['custom_button'] != "") {echo $instance['custom_button'];} else {echo "https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif";} ?>" border="0" name="submit">
		<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="business" value="<?php echo $instance['business_id']; ?>">
		<input type="hidden" name="item_name" value="<?php echo $instance['item_name']; ?>">
		<input type="hidden" name="item_number" value="">
		<input type="hidden" name="no_shipping" value="1">
		<input type="hidden" name="shipping" value="0.00">
		<input type="hidden" name="tax" value="0.00">
		<input type="hidden" name="button_subtype" value="services">
		<input type="hidden" name="no_note" value="0">
		<input type="hidden" name="cn" value="Add special instructions to the seller:">
		<input type="hidden" name="country" value="US">
		<input type="hidden" name="currency_code" value="USD">
		<input type="hidden" name="lc" value="US">
		<input type="hidden" name="bn" value="PP-BuyNowBF:btn_paynowCC_LG.gif:NonHosted">
		</form>
		
		<?php
		echo $args['after_widget'];
	}
};

// Initialize the widget
add_action( 'widgets_init', create_function( '', 'return register_widget( "Support_My_Work" );' ) );