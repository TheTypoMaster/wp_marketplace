<?php
/**
 * WC Product Slider Uninstall
 *
 * Uninstalling deletes options, tables, and pages.
 *
 */
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit();

if ( get_option('wc_widget_product_slider_lite_clean_on_deletion') == 1) {

delete_option( 'wc_product_slider_a3_widget_skin_global_settings' );
delete_option( 'wc_product_slider_a3_widget_skin_title_settings' );
delete_option( 'wc_product_slider_a3_widget_skin_dimensions_settings' );
delete_option( 'wc_product_slider_a3_widget_skin_category_tag_link_settings' );
delete_option( 'wc_product_slider_a3_widget_skin_control_settings' );
delete_option( 'wc_product_slider_a3_widget_skin_pager_settings' );
delete_option( 'wc_product_slider_a3_widget_skin_price_settings' );
delete_option( 'wc_product_slider_a3_widget_skin_product_link_settings' );

delete_option( 'wc_product_slider_a3_card_skin_global_settings' );
delete_option( 'wc_product_slider_a3_card_skin_card_layout_settings' );
delete_option( 'wc_product_slider_a3_card_skin_card_style_settings' );
delete_option( 'wc_product_slider_a3_card_skin_control_settings' );
delete_option( 'wc_product_slider_a3_card_skin_description_settings' );
delete_option( 'wc_product_slider_a3_card_skin_footer_cell_settings' );
delete_option( 'wc_product_slider_a3_card_skin_pager_settings' );
delete_option( 'wc_product_slider_a3_card_skin_price_settings' );
delete_option( 'wc_product_slider_a3_card_skin_title_settings' );

delete_option( 'wc_product_slider_a3_mobile_skin_card_container_settings' );
delete_option( 'wc_product_slider_a3_mobile_skin_category_tag_link_settings' );
delete_option( 'wc_product_slider_a3_mobile_skin_pager_settings' );
delete_option( 'wc_product_slider_a3_mobile_skin_price_settings' );
delete_option( 'wc_product_slider_a3_mobile_skin_title_settings' );

delete_option( 'wc_product_slider_a3_carousel_global_settings' );
delete_option( 'wc_product_slider_a3_carousel_container_settings' );
delete_option( 'wc_product_slider_a3_carousel_control_settings' );
delete_option( 'wc_product_slider_a3_carousel_pager_settings' );

}