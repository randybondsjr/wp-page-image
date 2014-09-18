<?php
   /*
   Plugin Name: Page Image
   Plugin URI: http://www.yakimawa.gov
   Description: Allows for image to be uploaded for the subpages of the site
   Version: 1.0
   Author: Randy Bonds Jr.
   Author URI: http://www.rbjdesigns.com
   License: GPL2
   */
   
	function custom_page_image() {
		$labels = array(
			'name'               => _x( 'Page Image', 'post type general name' ),
			'singular_name'      => _x( 'Page Image', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'page-image' ),
			'add_new_item'       => __( 'Add New Page Image' ),
			'edit_item'          => __( 'Edit Page Image' ),
			'new_item'           => __( 'New Page Image' ),
			'all_items'          => __( 'All Images' ),
			'view_item'          => __( 'View Image' ),
			'search_items'       => __( 'Search Images' ),
			'not_found'          => __( 'No images found' ),
			'not_found_in_trash' => __( 'No images found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Page Image'
		);
		$args = array(
			'labels'        => $labels,
			'description'   => 'Holds our products and product specific data',
			'public'        => true,
			'menu_position' => 47,
			'supports'      => array( 'title', 'editor', 'thumbnail' ),
			'has_archive'   => false
		);
		register_post_type( 'page-image', $args );	
	}
	
	add_action( 'init', 'custom_page_image' );
	
	function my_page_updated_messages( $messages ) {
		global $post, $post_ID;
		$messages['page-image'] = array(
			0 => '', 
			1 => __('Home Page Image updated.'),
			2 => __('Custom field updated.'),
			3 => __('Custom field deleted.'),
			4 => __('Home Page Image updated.'),
			5 => isset($_GET['revision']) ? sprintf( __('Home Page Image restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 =>  __('Home Page Image published'),
			7 => __('Home Page Image saved.'),
			8 => sprintf( __('Home Page Image submitted. <a target="_blank" href="%s">Preview product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
			9 => sprintf( __('Home Page Image scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview product</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( __('Home Page Image draft updated. <a target="_blank" href="%s">Preview product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		);
		return $messages;
	}
	add_filter( 'post_updated_messages', 'my_page_updated_messages' );
	
	
	
	 
	 
	/**
	* Hides the 'view' button in the post edit page
	*
	*/
	function hv_page_hide_view_button() {
		$current_screen = get_current_screen();
		 
		if( $current_screen->post_type === 'page-image' ) {
		echo '<style>#edit-slug-box{display: none;}</style>';
		}
		return;
	}
	add_action( 'admin_head', 'hv_hide_view_button' );
 
	/**
	* Removes the 'view' link in the admin bar
	*
	*/
	function hv_page_remove_view_button_admin_bar() {
		global $wp_admin_bar;
		 
		if( get_post_type() === 'page-image'){
		 
			$wp_admin_bar->remove_menu('view');
		 
		}
	 
	}
	add_action( 'wp_before_admin_bar_render', 'hv_page_remove_view_button_admin_bar' );
 
	/**
	* Removes the 'view' button in the posts list page
	*
	* @param $actions
	*/
	function hv_page_remove_view_row_action( $actions ) {
	 
		if( get_post_type() === 'page-image' )
		unset( $actions['view'] );
		return $actions;
	 
	}
	add_filter( 'post_row_actions', 'hv_page_remove_view_row_action', 10, 1 );
/*

function check_post_type_and_remove_media_buttons() {
	global $current_screen;
 
	if( $current_screen->post_type === 'page-image' ) {
		remove_action( 'media_buttons', 'media_buttons' );
	}
}
add_action('init','check_post_type_and_remove_media_buttons');
*/
function check_page_post_type_and_remove_media_buttons() {
	global $current_screen;
	if( 'page-image' == $current_screen->post_type ) {
		remove_action( 'media_buttons', 'media_buttons' );
	}
}
add_action('admin_head','check_page_post_type_and_remove_media_buttons');

?>