<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * Install Database, settings option
 */
function wc_product_slider_activated(){
	update_option('woo_gallery_widget_lite_version', '1.2.5');

	// Set Settings Default from Admin Init
	global $wc_product_slider_admin_init;
	$wc_product_slider_admin_init->set_default_settings();

	// Build sass
	global $wc_product_slider_less;
	$wc_product_slider_less->plugin_build_sass();

	update_option( 'wc_widget_product_slider_lite_clean_on_deletion', 1 );

	update_option('a3_wc_widget_product_slider_just_installed', true);
}

update_option('woo_gallery_widget_plugin', 'woo_gallery_widget');

function wc_product_slider_init() {
	if ( get_option( 'a3_wc_widget_product_slider_just_installed' ) ) {
		delete_option( 'a3_wc_widget_product_slider_just_installed' );
		wp_redirect( admin_url( 'admin.php?page=wc-product-slider-widget-skin-page', 'relative' ) );
		exit;
	}

	load_plugin_textdomain( 'wc_product_slider', false, WC_PRODUCT_SLIDER_FOLDER.'/languages' );
}

add_action( 'init', 'wc_product_slider_init' );

// Add custom style to dashboard
add_action( 'admin_enqueue_scripts', array( 'WC_Product_Slider_Hook_Filter', 'a3_wp_admin' ) );

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array('WC_Product_Slider_Hook_Filter', 'plugin_extra_links'), 10, 2 );

// Add admin sidebar menu css
add_action( 'admin_enqueue_scripts', array( 'WC_Product_Slider_Hook_Filter', 'admin_sidebar_menu_css' ) );

global $wc_product_slider_admin_init;
$wc_product_slider_admin_init->init();

// Add upgrade notice to Dashboard pages
add_filter( $wc_product_slider_admin_init->plugin_name . '_plugin_extension', array( 'WC_Product_Slider_Hook_Filter', 'plugin_extension' ) );

// Add extra link on left of Deactivate link on Plugin manager page
add_action('plugin_action_links_' . WC_PRODUCT_SLIDER_NAME, array( 'WC_Product_Slider_Hook_Filter', 'settings_plugin_links' ) );

add_action( 'wp_head', array( 'WC_Product_Slider_Hook_Filter', 'frontend_scripts_register' ), 20 );

// Include google fonts into header
add_action( 'wp_head', array( 'WC_Product_Slider_Hook_Filter', 'add_google_fonts'), 10 );


$GLOBALS['wc_product_slider_shortcode'] = new WC_Product_Slider_Shortcode();

// Registry Widgets
add_action( 'widgets_init', create_function('', 'return register_widget("WC_Product_Slider_Widget");') );
add_action( 'widgets_init', create_function('', 'return register_widget("WC_Product_Slider_Carousel_Widget");') );

if ( in_array( basename( $_SERVER['PHP_SELF'] ), array( 'widgets.php' ) ) ) {
	add_action( 'admin_footer', array( 'WC_Product_Slider_Hook_Filter', 'include_admin_script' ) );
}

// Check upgrade functions
add_action( 'init', 'wc_product_slider_lite_upgrade_plugin' );
function wc_product_slider_lite_upgrade_plugin () {
	if( version_compare(get_option('woo_gallery_widget_lite_version'), '1.2.1') === -1 ){
		update_option('woo_gallery_widget_lite_version', '1.2.1');

		// Build sass
		global $wc_product_slider_less;
		$wc_product_slider_less->plugin_build_sass();
	}

	update_option('woo_gallery_widget_lite_version', '1.2.5');
}

?>