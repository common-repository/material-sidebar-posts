<?php
/**
 * Plugin Name: Material Sidebar Posts
 * Plugin URI: http://www.siprasoft.in/material-sidebar-posts/
 * Description: material style display for your custom post type in sidebar, with different type of style and option to manage and show your posts in sidebar.
 * Version: 1.0
 * Author: Jetendra Pradhan
 * Author URI: http://siprasoft.in/
 * Developer: jetendra pradhan
 * Developer URI: http://siprasoft.in/
 * Text Domain: material-sidebar-posts
 * Domain Path: /languages
 *
 * Wordpress requires at least: 4.8.2
 * Wordpress tested up to: 4.8.3
 *
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
 if ( ! defined( 'ABSPATH' ) ) {
			exit;
		}
if( !defined( 'MATERIAL_SP_LIST_VERSION' ) ) {
	define( 'MATERIAL_SP_LIST_VERSION', '1.0' ); // Version of plugin
}	
class material_sp_list extends WP_Widget {
	// constructor of the widget
	function material_sp_list() {
		parent::WP_Widget(false, $name = __('Material Sidebar Posts', 'material_sidebar_posts') );
		add_action( 'wp_enqueue_scripts', array( $this, 'material_sp_register_plugin_styles' ) );
	}
	function material_sp_register_plugin_styles() {
		wp_register_style( 'material_sp_list_style_load', plugin_dir_url( __FILE__ ). 'assets/css/msp_style.css', array(), MATERIAL_SP_LIST_VERSION  );
		wp_enqueue_style( 'material_sp_list_style_load' );
	}	
	// widget form creation instance
	function form($instance) {	
    $title = esc_attr($instance['title']);
    $numberofListing = esc_attr($instance['numberofListing']);
	$msp_cpt = esc_attr($instance['msp_cpt']);
	$orderby = esc_attr($instance['orderby']);
	$imagestyle = esc_attr($instance['imagestyle']);
	$title_length = esc_attr($instance['title_length']);
	$content_length = esc_attr($instance['content_length']);
	$image_width = esc_attr($instance['image_width']);
	$image_height = esc_attr($instance['image_height']);
	$box_bg_color = esc_attr($instance['box_bg_color']);
	$align_image = esc_attr($instance['align_image']);	
?>

<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
    <?php _e('Widget Title', 'material_sidebar_posts'); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
  <label for="<?php echo $this->get_field_id('msp_cpt'); ?>">
    <?php _e('Select Post Type:', 'material_sidebar_posts'); ?>
  </label>
  <select id="<?php echo $this->get_field_id('msp_cpt'); ?>"  name="<?php echo $this->get_field_name('msp_cpt'); ?>" class="widefat">
    <?php $args = array('public'   => true);$post_types = get_post_types( $args, 'names' ); foreach ($post_types as $post_type ) { ?>
    <option <?php selected( $post_type, $msp_cpt ); ?> value="<?php echo $post_type; ?>"><?php echo $post_type;?></option>
    <?php } ?>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'orderby' ); ?>">
    <?php _e( 'Orderby', 'material_sidebar_posts' ); ?>
  </label>
  <select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
    <option value="ID" <?php selected( $instance['orderby'], 'ID' ); ?>>
    <?php _e( 'ID', 'material_sidebar_posts' ) ?>
    </option>
    <option value="title" <?php selected( $instance['orderby'], 'title' ); ?>>
    <?php _e( 'Title', 'material_sidebar_posts' ) ?>
    </option>
    <option value="date" <?php selected( $instance['orderby'], 'date' ); ?>>
    <?php _e( 'Date', 'material_sidebar_posts' ) ?>
    </option>
    <option value="rand" <?php selected( $instance['orderby'], 'rand' ); ?>>
    <?php _e( 'Random', 'material_sidebar_posts' ) ?>
    </option>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id('numberofListing'); ?>">
    <?php _e('Number of Posts:', 'material_sidebar_posts'); ?>
  </label>
  <select id="<?php echo $this->get_field_id('numberofListing'); ?>"  name="<?php echo $this->get_field_name('numberofListing'); ?>">
    <?php for($x=1;$x<=15;$x++): ?>
    <option <?php echo $x == $numberofListing ? 'selected="selected"' : '';?> value="<?php echo $x;?>"><?php echo $x; ?></option>
    <?php endfor;?>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'imagestyle' ); ?>">
    <?php _e( 'Image Style', 'material_sidebar_posts' ); ?>
  </label>
  <select class="widefat" id="<?php echo $this->get_field_id( 'imagestyle' ); ?>" name="<?php echo $this->get_field_name( 'imagestyle' ); ?>">
    <option value="square" <?php selected( $instance['imagestyle'], 'square' ); ?>>
    <?php _e( 'Square', 'material_sidebar_posts' ) ?>
    </option>
    <option value="circle" <?php selected( $instance['imagestyle'], 'circle' ); ?>>
    <?php _e( 'Circle', 'material_sidebar_posts' ) ?>
    </option>
  </select>
  <small>Select the display style of your post images and no image box.</small> </p>
<p>
  <label for="<?php echo $this->get_field_id('title_length'); ?>">
    <?php _e('Title Length (In Words)', 'material_sidebar_posts'); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id('title_length'); ?>" name="<?php echo $this->get_field_name('title_length'); ?>" type="number" value="<?php echo $title_length; ?>" />
  <small>Please enter the length of words (default 7) e.g->5,7 etc</small> </p>
<p>
  <label for="<?php echo $this->get_field_id('content_length'); ?>">
    <?php _e('Content Length (In Words)', 'material_sidebar_posts'); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id('content_length'); ?>" name="<?php echo $this->get_field_name('content_length'); ?>" type="number" value="<?php echo $content_length; ?>" />
  <small>Please enter the length of words (default 9) e.g->7, 9 etc.</small> </p>
<p>
  <label for="<?php echo $this->get_field_id('image_width'); ?>">
    <?php _e('Image Width', 'material_sidebar_posts'); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id('image_width'); ?>" name="<?php echo $this->get_field_name('image_width'); ?>" type="number" value="<?php echo $image_width; ?>" />
  <small>Display image width (default 90) e.g->120, 70.</small> </p>
<p>
  <label for="<?php echo $this->get_field_id('image_height'); ?>">
    <?php _e('Image Height', 'material_sidebar_posts'); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id('image_height'); ?>" name="<?php echo $this->get_field_name('image_height'); ?>" type="number" value="<?php echo $image_height; ?>" />
  <small>Display image height(default 90) e.g->120, 70.</small> </p>
<p>
  <label for="<?php echo $this->get_field_id('box_bg_color'); ?>">
    <?php _e('No Image Backgroud Color', 'material_sidebar_posts'); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id('box_bg_color'); ?>" name="<?php echo $this->get_field_name('box_bg_color'); ?>" type="text" value="<?php echo $box_bg_color; ?>" />
  <small>No thumb box background color (Default is #2979FF)</small> </p>
<p>
  <label for="<?php echo $this->get_field_id('align_image'); ?>">
    <?php _e('Image and No Thumbnail Align', 'material_sidebar_posts'); ?>
  </label>
  <select class="widefat" id="<?php echo $this->get_field_id( 'align_image' ); ?>" name="<?php echo $this->get_field_name( 'align_image' ); ?>">
    <option value="right" <?php selected( $instance['align_image'], 'right' ); ?>>
    <?php _e( 'Right', 'material_sidebar_posts' ) ?>
    </option>
    <option value="left" <?php selected( $instance['align_image'], 'left' ); ?>>
    <?php _e( 'Left', 'material_sidebar_posts' ) ?>
    </option>
  </select>
  <small>Default right align</small> </p>
<?php
	}
	// widget update new instance old instance
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['numberofListing'] = strip_tags($new_instance['numberofListing']);
		$instance['msp_cpt'] = strip_tags($new_instance['msp_cpt']);
		$instance['orderby'] = strip_tags($new_instance['orderby']);
		$instance['imagestyle'] = strip_tags($new_instance['imagestyle']);
		$instance['title_length'] = strip_tags($new_instance['title_length']);
		$instance['content_length'] = strip_tags($new_instance['content_length']);
		$instance['image_width'] = strip_tags($new_instance['image_width']);
		$instance['image_height'] = strip_tags($new_instance['image_height']);
		$instance['box_bg_color'] = strip_tags($new_instance['box_bg_color']);
		$instance['align_image'] = strip_tags($new_instance['align_image']);
		return $instance;
	}
	// widget display posts with the option
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$numberofListing = $instance['numberofListing'];
		$msp_cpt = $instance['msp_cpt'];
		$orderby = $instance['orderby'];
		$imagestyle = $instance['imagestyle'];
		$box_bg_color = $instance['box_bg_color'];
		$image_width = $instance['image_width'];
		$image_height = $instance['image_height'];
		$title_length = $instance['title_length'];
		$content_length = $instance['content_length'];
		$align_image = $instance['align_image'];
		if($title_length) {
		$title_length = $instance['title_length'];
		} else {
		$title_length = 7;
		}
		if($content_length) {
		$content_length = $instance['content_length'];
		} else {
		$content_length = 9;
		}
		if ($image_width) {
		$image_width = $instance['image_width'];
		} else {
		$image_width = 90;
		}
		if($image_height) {
		$image_height = $instance['image_height'];
		} else {
		$image_height = 90;
		}
		if($box_bg_color) {
	    $box_bg_color = $instance['box_bg_color'];
		} else {
		$box_bg_color = '#2979FF';
		}
		echo $before_widget;
		if ( $title ) {
		echo $before_title . $title . $after_title;
		}
			global $post;
			//add_image_size( 'msp_widget_size', $image_width, $image_height, true );
			$msp = new WP_Query();
			$msp->query('post_type='.$msp_cpt.'&posts_per_page=' . $numberofListing.'&orderby='.$orderby );
			//print_r($msp);
			if($msp->found_posts > 0) {
			echo '<div class="material_sp_widget"><ul>';
			while ($msp->have_posts()) {
			$msp->the_post();
			$str=get_the_title();
			if($imagestyle=='circle') {
			$image = (has_post_thumbnail($post->ID)) ? get_the_post_thumbnail($post->ID, array( $image_width, $image_height) , array( 'class' => 'circle '.$align_image.'' ) ) : '<div class="noThumb circle '.$align_image.'" style="background-color:'.$box_bg_color.';">'.$str['0'].'</div>';
			} else if ($imagestyle=='square') { 
			$image = (has_post_thumbnail($post->ID)) ? get_the_post_thumbnail($post->ID, array( $image_width, $image_height) , array( 'class' => 'square '.$align_image.'' ) ) : '<div class="noThumb square '.$align_image.'" style="background-color:'.$box_bg_color.';">'.$str['0'].'</div>';
			}
			$listItem = '<li><a href="' . get_permalink() . '">' . $image."</a>";
			$listItem .= '<a href="' . get_permalink() . '">';
			$listItem .= wp_trim_words( get_the_title(), $title_length, '...' ) . '</a>';
			$listItem .= '<p>' .wp_trim_words( get_the_content(), $content_length, '...' ) . '</p>';
			$listItem .= '</p>';
			$listItem .= '<span>' .esc_html( human_time_diff( get_the_time('U'), current_time('timestamp') ) ) . ' ago' . '</span></li>';
			
			echo $listItem;
			}
			echo '</ul></div>';
			wp_reset_postdata();
			}else{
			echo '<p">Add Some Listing to Show here</p>';
	     }
		echo $after_widget;
	}
	
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("material_sp_list");'));
?>
