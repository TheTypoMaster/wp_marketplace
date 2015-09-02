<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
Slider Card Skin Global Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class WC_Product_Slider_Card_Skin_Global_Settings extends WC_Product_Slider_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'skin-settings';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wc_product_slider_a3_card_skin_global_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_product_slider_a3_card_skin_global_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 1;
	
	/**
	 * @var array
	 */
	public $form_fields = array();
	
	/**
	 * @var array
	 */
	public $form_messages = array();
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->init_form_fields();
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Skin Settings successfully saved.', 'wc_product_slider' ),
				'error_message'		=> __( 'Error: Skin Settings can not save.', 'wc_product_slider' ),
				'reset_message'		=> __( 'Skin Settings successfully reseted.', 'wc_product_slider' ),
			);
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
							
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
				
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
				
		//add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {
		
		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {
		global $wc_product_slider_admin_interface;
		
		$wc_product_slider_admin_interface->reset_settings( $this->form_fields, $this->option_name, false );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* reset_default_settings()
	/* Reset default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function reset_default_settings() {
		global $wc_product_slider_admin_interface;
		
		$wc_product_slider_admin_interface->reset_settings( $this->form_fields, $this->option_name, true, true );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
		global $wc_product_slider_admin_interface;
		
		$wc_product_slider_admin_interface->get_settings( $this->form_fields, $this->option_name );
	}
	
	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array ( 
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {
		
		$subtab_data = array( 
			'name'				=> 'skin-settings',
			'label'				=> __( 'Skin Settings', 'wc_product_slider' ),
			'callback_function'	=> 'wc_product_slider_card_skin_global_settings_form',
		);
		
		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {
	
		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();
		
		return $subtabs_array;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {
		global $wc_product_slider_admin_interface;
		
		add_filter( $this->plugin_name . '_widget_touch_mobile_skin' . '_pro_version_name', array( $this, 'get_product_slider_version_name' ) );
		add_filter( $this->plugin_name . '_widget_touch_mobile_skin' . '_pro_plugin_page_url', array( $this, 'get_product_slider_page_url' ) );
		
		$output = '';
		$output .= $wc_product_slider_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	public function get_product_slider_version_name( $pro_version_name ) {
		return __( 'WooCommerce Product Slider Version', 'wc_product_slider' );
	}
	
	public function get_product_slider_page_url( $pro_plugin_page_url ) {
		return $this->slider_plugin_page_url;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
		
			array(
				'name' 		=> __( 'Card Skin', 'wc_product_slider' ),
                'type' 		=> 'heading',
				'class'		=> 'pro_feature_fields',
				'desc'		=> __( 'Use these Card Skin settings to create your own custom product card style and layout which can be selected when creating a Slider by Widget or via the Slider Shortcode function. The Product card style and layout that is created here is also used as the product display in the Carousel.', 'wc_product_slider' ),
           	),
			
			array(  
				'name' 		=> __( 'Slider Touch', 'wc_product_slider' ),
				'desc'		=> __( 'Support for Mobile', 'wc_product_slider' ),
				'id' 		=> 'enable_slider_touch',
				'class'		=> 'enable_slider_touch',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 1,
				'unchecked_value'	=> 0,
				'checked_label'		=> __( 'ON', 'wc_product_slider' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_product_slider' ),	
			),
			
			array(
                'type' 		=> 'heading',
           	),
			
			array(
                'type' 		=> 'heading',
				'class'		=> 'pro_feature_fields slider_touch_container',
				'id'		=> 'widget_touch_mobile_skin',
           	),
			array(  
				'name' 		=> __( 'Touch Mobile Skin', 'wc_product_slider' ),
				'desc'		=> __( 'Active custom mobile skin', 'wc_product_slider' ),
				'id' 		=> 'is_used_mobile_skin',
				'class'		=> 'is_used_mobile_skin',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 0,
				'checked_value'		=> 1,
				'unchecked_value'	=> 0,
				'checked_label'		=> __( 'ON', 'wc_product_slider' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_product_slider' ),	
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	
	if ( $("input.enable_slider_touch:checked").val() == '1') {
		$(".slider_touch_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$(".slider_touch_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.enable_slider_touch', function( event, value, status ) {
		$(".slider_touch_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true' ) {
			$(".slider_touch_container").slideDown();
		} else {
			$(".slider_touch_container").slideUp();
		}
	});
	
});
})(jQuery);
</script>
    <?php	
	}
	
}

global $wc_product_slider_card_skin_global_settings;
$wc_product_slider_card_skin_global_settings = new WC_Product_Slider_Card_Skin_Global_Settings();

/** 
 * wc_product_slider_card_skin_global_settings_form()
 * Define the callback function to show subtab content
 */
function wc_product_slider_card_skin_global_settings_form() {
	global $wc_product_slider_card_skin_global_settings;
	$wc_product_slider_card_skin_global_settings->settings_form();
}

?>