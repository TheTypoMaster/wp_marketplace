<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Product Slider Widget Hook Filter
 *
 * Hook anf Filter into woocommerce plugin
 *
 * Table Of Contents
 *
 *
 * frontend_scripts_register()
 * include_slider_widget_scripts()
 * include_slider_card_scripts()
 * include_slider_mobile_scripts()
 * add_google_fonts()
 * a3_wp_admin()
 * admin_sidebar_menu_css()
 * plugin_extra_links()
 */
class WC_Product_Slider_Hook_Filter
{

	public static function frontend_scripts_register() {
		global $wp_scripts;

		$_upload_dir = wp_upload_dir();

		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		wp_register_style( 'wc-product-slider-styles', WC_PRODUCT_SLIDER_CSS_URL . '/wc-product-slider'.$suffix.'.css' );

        if ( file_exists( $_upload_dir['basedir'] . '/sass/wc_widget_product_slider_lite'.$suffix.'.css' ) )
		wp_register_style( 'wc_widget_product_slider_lite', str_replace(array('http:','https:'), '', $_upload_dir['baseurl'] ) . '/sass/wc_widget_product_slider_lite'.$suffix.'.css' );

		wp_register_script( 'a3-cycle2-script', WC_PRODUCT_SLIDER_JS_URL . '/jquery.cycle2'. $suffix .'.js', array('jquery'), '2.1.2' );
		wp_register_script( 'a3-cycle2-center-script', WC_PRODUCT_SLIDER_EXTENSION_JS_URL . '/jquery.cycle2.center'. $suffix .'.js', array('jquery'), '2.1.2' );
		wp_register_script( 'a3-cycle2-caption2-script', WC_PRODUCT_SLIDER_EXTENSION_JS_URL . '/jquery.cycle2.caption2'. $suffix .'.js', array('jquery'), '2.1.2' );
		wp_register_script( 'a3-cycle2-swipe-script', WC_PRODUCT_SLIDER_EXTENSION_JS_URL . '/jquery.cycle2.swipe'. $suffix .'.js', array('jquery'), '2.1.2' );

		wp_register_script( 'a3-cycle2-flip-script', WC_PRODUCT_SLIDER_EXTENSION_JS_URL . '/jquery.cycle2.flip'. $suffix .'.js', array('jquery'), '2.1.2' );
		wp_register_script( 'a3-cycle2-scrollVert-script', WC_PRODUCT_SLIDER_EXTENSION_JS_URL . '/jquery.cycle2.scrollVert'. $suffix .'.js', array('jquery'), '2.1.2' );
		wp_register_script( 'a3-cycle2-ie-fade-script', WC_PRODUCT_SLIDER_EXTENSION_JS_URL . '/jquery.cycle2.ie-fade'. $suffix .'.js', array('jquery'), '2.1.2' );
		$wp_scripts->add_data( 'a3-cycle2-ie-fade-script', 'conditional', 'IE' );

		wp_register_script( 'jquery-imagesloaded', WC_PRODUCT_SLIDER_JS_URL . '/imagesloaded.pkgd' . $suffix . '.js', array('jquery'), '3.1.8' );

		wp_register_script( 'wc-product-slider-script', WC_PRODUCT_SLIDER_JS_URL . '/wc-product-slider-script.js', array('jquery') );

	}

	public static function include_slider_widget_scripts( $script_settings = array() ) {
		global $wc_product_slider_hook_backbone;

		wp_enqueue_style( 'wc-product-slider-styles');
		wp_enqueue_style( 'wc_widget_product_slider_lite');

		wp_enqueue_script('jquery');
		wp_enqueue_script( 'a3-cycle2-script' );
		wp_enqueue_script( 'a3-cycle2-center-script' );
		wp_enqueue_script( 'a3-cycle2-caption2-script' );
		wp_enqueue_script( 'jquery-imagesloaded' );

		if ( in_array( $script_settings['fx'], array( 'random', 'flipHorz', 'flipVert' ) ) ) {
			wp_enqueue_script( 'a3-cycle2-flip-script' );
		}
		if ( in_array( $script_settings['fx'], array( 'random', 'scrollHorz', 'scrollVert' ) ) ) {
			wp_enqueue_script( 'a3-cycle2-scrollVert-script' );
		}
		if ( in_array( $script_settings['fx'], array( 'random', 'fade', 'fadeout' ) ) ) {
			wp_enqueue_script( 'a3-cycle2-ie-fade-script' );
		}

		$wc_product_slider_hook_backbone->enqueue_plugin_scripts();

		wp_enqueue_script( 'wc-product-slider-script' );
	}

	public static function include_slider_mobile_scripts() {
		global $wc_product_slider_hook_backbone;

		wp_enqueue_style( 'wc-product-slider-styles' );

		wp_enqueue_script('jquery');
		wp_enqueue_script( 'a3-cycle2-script' );
		wp_enqueue_script( 'a3-cycle2-center-script' );
		wp_enqueue_script( 'a3-cycle2-caption2-script' );
		wp_enqueue_script( 'a3-cycle2-swipe-script' );
		wp_enqueue_script( 'jquery-imagesloaded' );

		$wc_product_slider_hook_backbone->enqueue_plugin_scripts();

	}

	public static function add_google_fonts() {
		global $wc_product_slider_fonts_face;

		global $wc_product_slider_a3_widget_skin_title_settings;
		global $wc_product_slider_a3_widget_skin_price_settings;
		global $wc_product_slider_a3_widget_skin_product_link_settings;
		global $wc_product_slider_a3_widget_skin_category_tag_link_settings;

		$google_fonts = array( );

		extract( $wc_product_slider_a3_widget_skin_title_settings );
		extract( $wc_product_slider_a3_widget_skin_price_settings );
		extract( $wc_product_slider_a3_widget_skin_product_link_settings );
		extract( $wc_product_slider_a3_widget_skin_category_tag_link_settings );

		$google_fonts[] = $title_font['face'];
		$google_fonts[] = $price_font['face'];
		$google_fonts[] = $old_price_font['face'];
		$google_fonts[] = $product_link_font['face'];
		$google_fonts[] = $category_link_font['face'];
		$google_fonts[] = $tag_link_font['face'];

		if ( count( $google_fonts ) > 0 ) $wc_product_slider_fonts_face->generate_google_webfonts( $google_fonts );
	}

	public static function include_admin_script() {
		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'wc-product-slider-admin-script', WC_PRODUCT_SLIDER_JS_URL.'/wc-product-slider-admin-script.js' );
	}

	public static function a3_wp_admin() {
		wp_enqueue_style( 'a3rev-wp-admin-style', WC_PRODUCT_SLIDER_CSS_URL . '/a3_wp_admin.css' );
	}

	public static function admin_sidebar_menu_css() {
		wp_enqueue_style( 'a3rev-wc-product-slider-admin-sidebar-menu-style', WC_PRODUCT_SLIDER_CSS_URL . '/admin_sidebar_menu.css' );
	}

	public static function plugin_extension() {
		$html = '';
		$html .= '<a href="http://a3rev.com/shop/" target="_blank" style="float:right;margin-top:5px; margin-left:10px; clear:right;" ><div class="a3-plugin-ui-icon a3-plugin-ui-a3-rev-logo"></div></a>';
		$html .= '<h3>'.__('Thanks for choosing the WooCommerce Widget Product Slider.', 'wc_product_slider').'</h3>';
		$html .= '<p>'.__('All of that plugins features have been activated and are ready for you to use.', 'wc_product_slider').':</p>';
		$html .= '<h3>'.__('What is the Yellow border sections about?', 'wc_product_slider').'</h3>';
		$html .= '<p>'.__('Inside the Yellow border you will see the settings for the 3 available upgrade versions for the lite version. You can see the settings but they are not active.', 'wc_product_slider' ).'</p>';

		$html .= '<h3>'.__('Upgrades Available For more Functionality', 'wc_product_slider').'</h3>';

		$html .= '<p><strong><a href="'.WC_WIDGET_PRODUCT_SLIDER_VERSION_URI.'" target="_blank">'.__('WooCommerce Widget Product Slider', 'wc_product_slider' ).'</a></strong><br />';
		$html .= '* '.__('Activates the beautiful Product Card Skin.', 'wc_product_slider' ).'<br />';
		$html .= '* '.__('Create Sliders from Product tags.', 'wc_product_slider' ).'<br />';
		$html .= '* '.__('Create Sliders from ON-SALE feature.', 'wc_product_slider' ).'<br />';
		$html .= '* '.__('Create Sliders from Featured products.', 'wc_product_slider' );
		$html .= '</p>';

		$html .= '<p><strong><a href="'.WC_PRODUCT_SLIDER_VERSION_URI.'" target="_blank">'.__('WooCommerce Product Slider', 'wc_product_slider' ).'</a></strong><br />';
		$html .= '* '.__('Includes all the features of lesser versions.', 'wc_product_slider' ).'<br />';
		$html .= '* '.__('Activates Touch Mobile Skin.', 'wc_product_slider' ).'<br />';
		$html .= '* '.__('Superb presentation on mobile devices.', 'wc_product_slider' ).'<br />';
		$html .= '* '.__('Activates adding sliders by shortcode.', 'wc_product_slider' );
		$html .= '</p>';

		$html .= '<p><strong><a href="'.WC_CAROUSEL_SLIDER_VERSION_URI.'" target="_blank">'.__('WooCommerce Carousel and Slider', 'wc_product_slider' ).'</a></strong><br />';
		$html .= '* '.__('Top of the range with all features.', 'wc_product_slider' ).'<br />';
		$html .= '* '.__('Activates the Product Carousel feature.', 'wc_product_slider' ).'<br />';
		$html .= '* '.__('Insert Product Carousels by widget.', 'wc_product_slider' ).'<br />';
		$html .= '* '.__('Insert Product carousels by shortcode.', 'wc_product_slider' ).'<br />';
		$html .= '* '.__('Fully mobile responsive Carousel sliders.', 'wc_product_slider' );
		$html .= '</p>';

		$html .= '<h3>'.__('Important!', 'wc_product_slider').'</h3>';
		$html .= '<p>'.__("If you are upgrading to any of the Pro Versions you will need to:", 'wc_product_slider').'<br />';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>1. '.__('DEACTIVATE this plugin BEFORE installing and activating another version.', 'wc_product_slider').'</li>';
		$html .= '<li>2. '.__("If you don't you will get a FATAL ERROR.", 'wc_product_slider').'</li>';
		$html .= '<li>3. '.__('All data - sliders, settings and activations will be present in the newly activated version.', 'wc_product_slider').'</li>';
		$html .= '<li>4. '.__('WARNING - If you DELETE this plugin BEFORE you activate another version of the slider, all slider settings will be lost.', 'wc_product_slider').'</li>';
		$html .= '</ul>';
		$html .= '</p>';

		$html .= '<h3>'.__('More FREE a3rev WooCommerce Plugins', 'wc_product_slider').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/plugins/woocommerce-product-sort-and-display/" target="_blank">'.__('WooCommerce Product Sort & Display', 'wc_product_slider').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/woocommerce-products-quick-view/" target="_blank">'.__('WooCommerce Products Quick View', 'wc_product_slider').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/woocommerce-dynamic-gallery/" target="_blank">'.__('WooCommerce Dynamic Products Gallery', 'wc_product_slider').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/woocommerce-compare-products/" target="_blank">'.__('WooCommerce Compare Products', 'wc_product_slider').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/woocommerce-predictive-search/" target="_blank">'.__('WooCommerce Predictive Search', 'wc_product_slider').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/woocommerce-email-inquiry-cart-options/" target="_blank">'.__('WooCommerce Email Inquiry & Cart Options', 'wc_product_slider').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('FREE a3rev WordPress Plugins', 'wc_product_slider').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="https://wordpress.org/plugins/a3-lazy-load/" target="_blank">'.__('a3 Lazy Load', 'wc_product_slider').'</a> ('.__( 'WooCommerce Compatible' , 'wc_product_slider' ).')</li>';
		$html .= '<li>* <a href="https://wordpress.org/plugins/a3-portfolio/" target="_blank">'.__('a3 Portfolio', 'wc_product_slider').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/a3-responsive-slider/" target="_blank">'.__('a3 Responsive Slider', 'wc_product_slider').'</a>&nbsp;&nbsp;&nbsp;'.__( 'New Release!' , 'wc_product_slider' ).'</li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/contact-us-page-contact-people/" target="_blank">'.__('Contact Us Page - Contact People', 'wc_product_slider').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/wp-email-template/" target="_blank">'.__('WordPress Email Template', 'wc_product_slider').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/page-views-count/" target="_blank">'.__('Page View Count', 'wc_product_slider').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';

		return $html;
	}

	public static function plugin_extra_links($links, $plugin_name) {
		if ( $plugin_name != WC_PRODUCT_SLIDER_NAME) {
			return $links;
		}
		$links[] = '<a href="'.WC_PRODUCT_SLIDER_DOCS_URI.'" target="_blank">'.__('Documentation', 'wc_product_slider').'</a>';
		$links[] = '<a href="http://wordpress.org/support/plugin/woo-widget-product-slideshow/" target="_blank">'.__('Support', 'wc_product_slider').'</a>';
		return $links;
	}

	public static function settings_plugin_links($actions) {
		$actions = array_merge( array( 'settings' => '<a href="admin.php?page=wc-product-slider-widget-skin-page">' . __( 'Skins', 'wc_product_slider' ) . '</a>' ), $actions );

		return $actions;
	}
}
?>
