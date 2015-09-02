<?php
/*
Plugin Name: WooCommerce Widget Product Slider LITE
Description: Adds visually stunning WooCommerce product sliders to any widgeted area. Fully customizable, Widget Skin. Fully mobile responsive. Show any number of products from a selected product category.
Version: 1.2.5
Author: A3 Revolution
Author URI: http://www.a3rev.com/
Requires at least: 3.7
Tested up to: 4.3
License: GPLv2 or later

	WooCommerce Widget Product Slider Lite plugin.
	Copyright © 2011 A3 Revolution Software Development team

	A3 Revolution Software Development team
	admin@a3rev.com
	PO Box 1170
	Gympie 4570
	QLD Australia
*/
?>
<?php
define('WC_PRODUCT_SLIDER_FILE_PATH', dirname(__FILE__));
define('WC_PRODUCT_SLIDER_DIR_NAME', basename(WC_PRODUCT_SLIDER_FILE_PATH));
define('WC_PRODUCT_SLIDER_FOLDER', dirname(plugin_basename(__FILE__)));
define('WC_PRODUCT_SLIDER_NAME', plugin_basename(__FILE__));
define('WC_PRODUCT_SLIDER_URL', untrailingslashit(plugins_url('/', __FILE__)));
define('WC_PRODUCT_SLIDER_DIR', WP_PLUGIN_DIR . '/' . WC_PRODUCT_SLIDER_FOLDER);
define('WC_PRODUCT_SLIDER_IMAGES_URL', WC_PRODUCT_SLIDER_URL . '/assets/images');
define('WC_PRODUCT_SLIDER_JS_URL', WC_PRODUCT_SLIDER_URL . '/assets/js');
define('WC_PRODUCT_SLIDER_EXTENSION_JS_URL', WC_PRODUCT_SLIDER_JS_URL . '/cycle2-extensions');
define('WC_PRODUCT_SLIDER_CSS_URL', WC_PRODUCT_SLIDER_URL . '/assets/css');

if (!defined("WC_PRODUCT_SLIDER_DOCS_URI")) define("WC_PRODUCT_SLIDER_DOCS_URI", "http://docs.a3rev.com/user-guides/woocommerce/woo-widget-product-slideshow/");
if (!defined("WC_WIDGET_PRODUCT_SLIDER_VERSION_URI")) define("WC_WIDGET_PRODUCT_SLIDER_VERSION_URI", "http://a3rev.com/shop/woocommerce-widget-product-slider/");
if (!defined("WC_PRODUCT_SLIDER_VERSION_URI")) define("WC_PRODUCT_SLIDER_VERSION_URI", "http://a3rev.com/shop/woocommerce-product-slider/");
if (!defined("WC_CAROUSEL_SLIDER_VERSION_URI")) define("WC_CAROUSEL_SLIDER_VERSION_URI", "http://a3rev.com/shop/woocommerce-carousel-slider/");

// Product Slider API
include ('includes/class-legacy-api.php');

include ('admin/admin-ui.php');
include ('admin/admin-interface.php');

include ('admin/admin-pages/admin-widget-skin-page.php');
include ('admin/admin-pages/admin-card-skin-page.php');
include ('admin/admin-pages/admin-mobile-skin-page.php');
include ('admin/admin-pages/admin-carousel-page.php');

include ('admin/admin-init.php');
include ('admin/less/sass.php');

include 'classes/class-slider-display.php';
include 'classes/class-slider-functions.php';
include 'classes/class-slider-hook-filter.php';

include 'shortcodes/class-slider-shortcodes.php';

include 'classes/class-slider-backbone.php';

include 'widget/class-slider-widget.php';
include 'widget/class-carousel-widget.php';

include 'admin/plugin-init.php';

/**
 * Call when the plugin is activated
 */
register_activation_hook(__FILE__, 'wc_product_slider_activated');
?>
