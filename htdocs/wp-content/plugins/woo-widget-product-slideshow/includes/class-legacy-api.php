<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Product Slider Legacy API Class
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WC_Product_Slider_Legacy_API {

	/** @var string $base the route base */
	protected $base = '/wc_product_slider_legacy_api';
	protected $base_tag = 'wc_product_slider_legacy_api';
	
	/**
	* Default contructor
	*/
	public function __construct() {
		add_action( 'woocommerce_api_' . $this->base_tag, array( $this, 'api_handler' ) );
	}
	
	public function get_legacy_api_url() {
		$legacy_api_url = WC()->api_request_url( $this->base_tag );
		$legacy_api_url = str_replace( array( 'https:', 'http:' ), '', $legacy_api_url );

		return $legacy_api_url;
	}
	
	public function api_handler() {
		if ( isset( $_REQUEST['action'] ) ) {
			$action = addslashes( trim( $_REQUEST['action'] ) );
			switch ( $action ) {
				case 'get_slider_items' :
					$this->get_slider_items();
				break;
			}
		}
	}
	
	public function get_slider_items() {
		if ( ! defined('SCRIPT_DEBUG') || ! SCRIPT_DEBUG ) @ini_set('display_errors', false );
		global $wc_product_slider_a3_card_skin_card_layout_settings;
		
		$woocommerce_db_version = get_option( 'woocommerce_db_version', null );
		
		$slider_query_string = base64_decode( $_REQUEST['slider_id'] );
		$slider_settings = array();
		if ( isset( $_REQUEST['slider_settings'] ) ) $slider_settings = $_REQUEST['slider_settings'];
		
		$slider_data = array();
		parse_str( $slider_query_string, $slider_data );

		extract( $slider_data );

		$product_results = $this->get_products_cat( $category_id, $filter_type, 'title menu_order', $number_products, 0 );
		
		$image_size = 'full';
		$slider_items = array();
		if ( is_array( $product_results ) && count( $product_results ) > 0 ) {
			$index_product = 0;
			foreach ( $product_results as $product ) {
				$index_product++;
				$product_id = $product->ID;
				if ( version_compare( $woocommerce_db_version, '2.0', '<' ) && null !== $woocommerce_db_version ) {
					$product_data = new WC_Product( $product_id ); 
				} elseif ( version_compare( WC()->version, '2.2.0', '<' ) ) {
					$product_data = get_product( $product_id );
				} else {
					$product_data = wc_get_product( $product_id );
				}
				
				$product_price = $product_data->get_price_html();
				
				$thumb_image_info = $this->get_image_info( $product_id,  $image_size );
				$thumb_image_url = $thumb_image_info['url'];
				
				$slide_data = array(
					'item_title'		=> $product->post_title,
					'item_link'			=> get_permalink( $product_id ),
					'product_price'		=> $product_price,
					'img_url'			=> $thumb_image_url,
					'index_product' 	=> $index_product
				);
				
				if ( isset( $slider_settings['skin_type'] ) ) {
					switch( $slider_settings['skin_type'] ) {
						
						// For Mobile
						case 'mobile':
							$slide_data['is_used_mobile_skin'] = $slider_settings['is_used_mobile_skin'];
							$slide_data['category_link'] = $slider_settings['category_link'];
							$slide_data['tag_link'] = $slider_settings['tag_link'];
						break;
						
						// For Widget
						default:
							if ( isset( $slider_data['widget_effect'] ) && $slider_data['widget_effect'] == 'random' ) {
								$slide_data['extra_attributes'] = WC_Product_Slider_Functions::get_transition_random( $slider_settings );
							}
						break;	
					}
				}
				
				$slider_items[] = $slide_data;
			}	
		}
		
		header( 'Content-Type: application/json', true, 200 );
		die( json_encode( $slider_items ) );
	}

	public function add_featured_args_query( $args=array() ) {
		$woocommerce_db_version = get_option( 'woocommerce_db_version', null );

		// Delete featured cached
		delete_transient( 'wc_featured_products' );

		// Get featured products
		$product_ids_featured = ( ( version_compare( $woocommerce_db_version, '2.1', '<' ) ) ? woocommerce_get_featured_product_ids() : wc_get_featured_product_ids() );

		$meta_query = array();
		if ( version_compare( $woocommerce_db_version, '2.1', '<' ) ) {
			global $woocommerce;
			$meta_query[] = $woocommerce->query->visibility_meta_query();
	    	$meta_query[] = $woocommerce->query->stock_status_meta_query();
		} else {
			$meta_query[] = WC()->query->visibility_meta_query();
	    	$meta_query[] = WC()->query->stock_status_meta_query();
		}

		$args['meta_query'] = $meta_query;
		$args['post__in']   = $product_ids_featured;

		return $args;
	}

	public function add_onsale_args_query( $args=array() ) {
		$woocommerce_db_version = get_option( 'woocommerce_db_version', null );

		if ( version_compare( $woocommerce_db_version, '2.0', '<' ) && null !== $woocommerce_db_version ) {

			$meta_query = array();

			$meta_query[] = array(
				'key' => '_sale_price',
				'value' 	=> 0,
				'compare' 	=> '>',
				'type'		=> 'NUMERIC'
			);

			$on_sale = get_posts( array(
				'numberposts'	=> -1,
				'post_type'		=> array('product', 'product_variation'),
				'post_status'	=> 'publish',
				'meta_query'	=> $meta_query,
				'fields'		=> 'id=>parent'
			) );

			$product_ids 	= array_keys( $on_sale );
			$parent_ids		= array_values( $on_sale );

			// Check for scheduled sales which have not started
			foreach ( $product_ids as $key => $id )
				if ( get_post_meta( $id, '_sale_price_dates_from', true ) > current_time('timestamp') )
					unset( $product_ids[ $key ] );

			$product_ids_on_sale = array_unique( array_merge( $product_ids, $parent_ids ) );

			$product_ids_on_sale[] = 0;

		} else {
			// Get products on sale
			$product_ids_on_sale = ( ( version_compare( $woocommerce_db_version, '2.1', '<' ) ) ? woocommerce_get_product_ids_on_sale() : wc_get_product_ids_on_sale() );
		}

		$meta_query = array();
		if ( version_compare( $woocommerce_db_version, '2.1', '<' ) ) {
			global $woocommerce;
			$meta_query[] = $woocommerce->query->visibility_meta_query();
	    	$meta_query[] = $woocommerce->query->stock_status_meta_query();
		} else {
			$meta_query[] = WC()->query->visibility_meta_query();
	    	$meta_query[] = WC()->query->stock_status_meta_query();
		}

		$args['meta_query'] = $meta_query;
		$args['post__in']   = $product_ids_on_sale;

		return $args;
	}

	public function get_products_cat($catid = 0, $filter_type='', $orderby='title menu_order', $number = -1, $offset = 0) {
		$args = array(
			'numberposts'	=> $number,
			'offset'		=> $offset,
			'orderby'		=> $orderby,
			'order'			=> 'ASC',
			'post_type'		=> 'product',
			'post_status'	=> 'publish'
		);
		if ($catid > 0) {
			$args['tax_query'] = array(
						array(
							'taxonomy'			=> 'product_cat',
							'field'				=> 'id',
							'terms'				=> $catid,
							'include_children'	=> false
						)
			);
		}

		if ( 'featured' == $filter_type ) {
			$args = $this->add_featured_args_query( $args );
		} elseif ( 'onsale' == $filter_type ) {
			$args = $this->add_onsale_args_query( $args );
		}

		$results = get_posts($args);
		if ( $results && is_array($results) && count($results) > 0) {
			return $results;
		} else {
			return array();
		}
	}

	public function get_image_info( $id, $size = 'full' ) {
		$thumbid = 0;
		if ( has_post_thumbnail($id) ) {
			$thumbid = get_post_thumbnail_id($id);
		} else {
			$args = array( 'post_parent' => $id ,'numberposts' => 1, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'DESC', 'orderby' => 'ID', 'post_status' => null); 
			$attachments = get_posts($args);
			if ($attachments) {
				foreach ( $attachments as $attachment ) {
					$thumbid = $attachment->ID;
					break;
				}
			}
		}
		$image_info = array();
		if ( $thumbid > 0 ) {
			$image_attribute = wp_get_attachment_image_src( $thumbid, $size);
			$image_info['url'] = $image_attribute[0];
			$image_info['width'] = $image_attribute[1];
			$image_info['height'] = $image_attribute[2];
		} else {
			$image_info = WC_Product_Slider_Functions::get_template_image_file_info('no-image.gif');
		}

		return $image_info;
	}
}

global $wc_product_slider_legacy_api;
$wc_product_slider_legacy_api = new WC_Product_Slider_Legacy_API();
