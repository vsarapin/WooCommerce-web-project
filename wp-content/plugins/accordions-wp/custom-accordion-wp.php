<?php

	/*
	Plugin Name: Accordion-Wp
	Plugin URI: https://themepoints.com/product/wp-accordions-pro
	Description: Wp Accordions is a component ready to use on mobile devices and desktop devices. It’s a fluid component and easy to use. It provides various skins, options and features for data organization and it comes with many different styles.
	Version: 2.4
	Author: themepoints
	Author URI: https://themepoints.com
	TextDomain: tcaccordion
	License: GPLv2
	*/


	if ( ! defined( 'ABSPATH' ) )
	die( "Can't load this file directly" );

	/***************************************
	wp accordion plugins path register
	***************************************/


	define('CUSTOM_ACCORDION_PLUGIN_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

	# Include Meta Box Class File
	include( plugin_dir_path( __FILE__ ) . 'metabox/custom-meta-boxes.php' );
	include( plugin_dir_path( __FILE__ ) . 'inc/accordions-wp-post-type.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'theme/custom-wp-accordion-themes.php');


	# wp accordion admin enqueue scripts
	function custom_accordion_active_script(){
		wp_enqueue_script('jquery');
		wp_enqueue_script('accordion-responsive-js', plugins_url( '/js/responsive-accordion.min.js', __FILE__ ), array('jquery'), '1.0', false);
		wp_enqueue_style('accordion-responsive-css', CUSTOM_ACCORDION_PLUGIN_PATH.'css/responsive-accordion.css');
		wp_enqueue_style('accordion-main-css', CUSTOM_ACCORDION_PLUGIN_PATH.'css/style.css');
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('accordion-wp-color-picker', plugins_url(), array( 'wp-color-picker' ), false, true );
	}
	add_action('init', 'custom_accordion_active_script');
	
	
	# Wp Accordion Admin enqueue Scripts
	function custom_accordion_admin_enqueue_scripts(){
		global $typenow;
		if(($typenow == 'accordion_tp')){
			wp_enqueue_script('jquery');
			wp_enqueue_style('accordion-admin-css', CUSTOM_ACCORDION_PLUGIN_PATH.'admin/css/accordion-backend-admin.css');
			wp_enqueue_script('accordion-admin-js', CUSTOM_ACCORDION_PLUGIN_PATH.'admin/js/accordion-backend-admin.js', array('jquery'), '1.0.0', true );

			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script( 'accordion_color_picker', plugins_url('admin/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
			wp_enqueue_script("jquery-ui-sortable");
			wp_enqueue_script("jquery-ui-draggable");
			wp_enqueue_script("jquery-ui-droppable");
		}
	}
	add_action('admin_enqueue_scripts', 'custom_accordion_admin_enqueue_scripts');	


	function tps_accordion_prover_action_links( $links ) {
		$links[] = '<a href="https://themepoints.com/product/wp-accordions-pro" style="color: red; font-weight: bold;" target="_blank">Buy Pro!</a>';
		return $links;
	}
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'tps_accordion_prover_action_links' );


	# Register Meta Boxes
	function custom_accordion_wordpress_filter_meta_box( $meta_boxes ) {
	  $meta_boxes[] = array(
		'id'          => 'custom_accordion_wordpress_feature',
		'title'       => 'Accordion',
		'pages'       => array('accordion_tp'),
		'context'     => 'normal',
		'priority'    => 'high',
		'show_names'  => true, 
		'fields' 	  => array(

			array(
				'id'   => 'custom_accordion_wordpresspro_columns',
				'name'    => 'Accordion Item Details',
				'type' => 'group',
				'repeatable'     => true,
				'sortable'       => true,			
				'repeatable_max' => 5,

				'fields' => array(
					array(
						'id'              => 'custom_accordions_pro_title',
						'name'            => 'Accordion Title',                
						'type'            => 'text',
						'cols'            => 4
					),
					array(
						'id'              => 'custom_accordions_pro_details',
						'name'            => 'Description',                
						'type'            => 'wysiwyg',
						'sanitization_cb' => false,
						'options' => array( 'textarea_rows' => 8, ),
						'default'         => 'Insert Your Description Here?',
					),
				)
			)
		)
	);

	return $meta_boxes;
	}
	add_filter( 'cmb_meta_boxes', 'custom_accordion_wordpress_filter_meta_box' );


	# Accordion Custom Title Filter
	function custom_accordion_wordpress_title( $title ){
	  $screen = get_current_screen();
	  if  ( 'accordion_tp' == $screen->post_type ) {
		$title = 'Accordion Group Title';
	  }  
	  return $title;
	}	
	add_filter( 'enter_title_here', 'custom_accordion_wordpress_title' );	
	

	function custom_accordion_free_redirect_options_page( $plugin ) {
		if ( $plugin == plugin_basename( __FILE__ ) ) {
			exit( wp_redirect( admin_url( 'options-general.php' ) ) );
		}
	}
	add_action( 'activated_plugin', 'custom_accordion_free_redirect_options_page' );	


	# admin menu
	function custom_accordion_free_plugins_options_framwrork() {
		add_options_page( 'Accordion Pro Version Help & Features', '', 'manage_options', 'accordion-free-features', 'tp_accordions_frees_options_framework' );
	}
	add_action( 'admin_menu', 'custom_accordion_free_plugins_options_framwrork' );


	if ( is_admin() ) : // Load only if we are viewing an admin page

	function tp_accordions_options_framework_settings() {
		// Register settings and call sanitation functions
		register_setting( 'accordion_free_options', 'tp_accordion_free_options', 'tpls_accordion_free_options' );
	}
	add_action( 'admin_init', 'tp_accordions_options_framework_settings' );


	function tp_accordions_frees_options_framework() {

		if ( ! isset( $_REQUEST['updated'] ) ) {
			$_REQUEST['updated'] = false;
		} ?>


		<div class="wrap about-wrap">
			<h1>Welcome To Accordion - Version - 2.4</h1>
			<div class="about-text">Thank you for using our Accordion Wp plugin free version. if you really love this plugin please give us a <a style="color:red" target="_blank" href="https://wordpress.org/plugins/accordions-wp/">Five Stars Feedback</a> with some valuable comments.</div>
			<hr>
			<h3>We create a <a target="_blank" href="https://themepoints.com/product/wp-accordions-pro/">premium version</a> of this plugin with some amazing cool features?</h3>
			<br>
			<hr>
			<div class="feature-section two-col">
				<h2>Premium Version Amazing Features</h2>
				<div class="col">
					<ul>
						<li><span class="dashicons dashicons-yes"></span> All Features of the free version.</li>
						<li><span class="dashicons dashicons-yes"></span> Fully Responsive Design.</li>
						<li><span class="dashicons dashicons-yes"></span> Create Your Own Style.</li>
						<li><span class="dashicons dashicons-yes"></span> Highly customized for User Experience.</li>
						<li><span class="dashicons dashicons-yes"></span> Widget Ready.</li>
						<li><span class="dashicons dashicons-yes"></span> Unlimited Domain Support.</li>
						<li><span class="dashicons dashicons-yes"></span> Unlimited Accordions Support.</li>
						<li><span class="dashicons dashicons-yes"></span> Support wysiwyg text editor.</li>
						<li><span class="dashicons dashicons-yes"></span> Create accordions by group.</li>
						<li><span class="dashicons dashicons-yes"></span> Cross-browser compatibility.</li>
						<li><span class="dashicons dashicons-yes"></span> Drag & Drop accordion items sorting.</li>
						<li><span class="dashicons dashicons-yes"></span> Multi-level Accordion Support.</li>
						<li><span class="dashicons dashicons-yes"></span> Auto Open Accordion Items Options.</li>
						<li><span class="dashicons dashicons-yes"></span> Accordion Icon Insert Options.</li>
						<li><span class="dashicons dashicons-yes"></span> Choose Accordion Plus Icon.</li>
						<li><span class="dashicons dashicons-yes"></span> Choose Accordion Minus Icon.</li>
						<li><span class="dashicons dashicons-yes"></span> Accordion Fontawesome Icon Support.</li>
						<li><span class="dashicons dashicons-yes"></span> Accordion Icon Position Left/Right.</li>
						<li><span class="dashicons dashicons-yes"></span> Accordion Icon Color Options.</li>
						<li><span class="dashicons dashicons-yes"></span> Accordion CloseAble Options.</li>
						<li><span class="dashicons dashicons-yes"></span> Accordion Close Other Items Options.</li>
					</ul>
				</div>
				<div class="col">
					<ul>
						<li><span class="dashicons dashicons-yes"></span> Expand/collapse Slide speed of Animation Options.</li>
						<li><span class="dashicons dashicons-yes"></span> Add and remove accordion item from backend.</li>
						<li><span class="dashicons dashicons-yes"></span> Accordion header title font size.</li>
						<li><span class="dashicons dashicons-yes"></span> Accordion header title font color.</li>
						<li><span class="dashicons dashicons-yes"></span> Accordion header title text position.</li>
						<li><span class="dashicons dashicons-yes"></span> Accordion header title background color.</li>
						<li><span class="dashicons dashicons-yes"></span> Accordion content font size.</li>
						<li><span class="dashicons dashicons-yes"></span> Accordion content font color.</li>
						<li><span class="dashicons dashicons-yes"></span> Accordion content background.</li>
						<li><span class="dashicons dashicons-yes"></span> Custom Accordion Padding Options.</li>
						<li><span class="dashicons dashicons-yes"></span> Accordion area background image Options.</li>
						<li><span class="dashicons dashicons-yes"></span> Accordions Area Padding Options.</li>
						<li><span class="dashicons dashicons-yes"></span> Support Any videos (Ex: youtube, vimeo )</li>
						<li><span class="dashicons dashicons-yes"></span> Valid HTML5 & CSS3 layout.</li>
						<li><span class="dashicons dashicons-yes"></span> Use via short-codes.</li>
						<li><span class="dashicons dashicons-yes"></span> Clean Design & Code.</li>
						<li><span class="dashicons dashicons-yes"></span> Unlimited accordion anywhere in the themes or template.</li>
						<li><span class="dashicons dashicons-yes"></span> Life Time Self hosted auto updated enable.</li>
						<li><span class="dashicons dashicons-yes"></span> Online Documentation.</li>
						<li><span class="dashicons dashicons-yes"></span> 24/7 Dedicated support forum.</li>
						<li><span class="dashicons dashicons-yes"></span> And Many More</li>
					</ul>
				</div>
			</div>
			<h2>
				<a href="https://themepoints.com/product/wp-accordions-pro/" class="button button-primary button-hero" target="_blank">Buy Premium Version Only $8</a>
			</h2>
			<br>
			<br>
			<br>
			<br>
		</div>
		<?php
	}


	endif;  // EndIf is_admin()

	register_activation_hook( __FILE__, 'accordion_pro_free_plugin_active_hook' );
	add_action( 'admin_init', 'accordion_pro_free_main_active_redirect_hook' );

	function accordion_pro_free_plugin_active_hook() {
		add_option( 'accordion_pro_plugin_active_free_redirect_hook', true );
	}

	function accordion_pro_free_main_active_redirect_hook() {
		if ( get_option( 'accordion_pro_plugin_active_free_redirect_hook', false ) ) {
			delete_option( 'accordion_pro_plugin_active_free_redirect_hook' );
			if ( ! isset( $_GET['activate-multi'] ) ) {
				wp_redirect( "options-general.php?page=accordion-free-features" );
			}
		}
	}

	/***************************************
	wp accordion option init
	***************************************/
	function themepoints_custom_accordion_option_init(){
		register_setting( 'custom_accordion_options_setting', 'themepoints_accordion_theme');
		register_setting( 'custom_accordion_options_setting', 'accordion_content_font_pages');
	}
	add_action('admin_init', 'themepoints_custom_accordion_option_init' );


	function themepoints_custom_accordion_submenu_pages() {
		add_submenu_page( 'edit.php?post_type=accordion_tp', __('Help & Support', 'tcaccordion'), __('Help & Support', 'tcaccordion'), 'manage_options', 'support', 'themepoints_custom_accordion_support_callback' );
	}

	function themepoints_custom_accordion_support_callback() {
		require_once(plugin_dir_path(__FILE__).'custom-accordion-admin.php');
	}
	add_action('admin_menu', 'themepoints_custom_accordion_submenu_pages');


	/*==========================================================================
		Custom Accordion register shortcode
	==========================================================================*/
	function custom_accordion_shortcode_register($atts, $content = null){
		$atts = shortcode_atts(
			array(
				'id' => "",
			), $atts);
			global $post;
			$post_id = $atts['id'];
			
			$content = '';
			$content.= TCP_accordions_wordpress_table_body($post_id);
			return $content;
	}// shortcode hook
	add_shortcode('tcpaccordion', 'custom_accordion_shortcode_register');

?>