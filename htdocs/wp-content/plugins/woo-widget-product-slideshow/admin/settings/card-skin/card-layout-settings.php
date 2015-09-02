<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
Slider Card Skin Card Layout Settings

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

class WC_Product_Slider_Card_Skin_Card_Layout_Settings extends WC_Product_Slider_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'card-layout';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wc_product_slider_a3_card_skin_card_layout_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_product_slider_a3_card_skin_card_layout_settings';
	
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
				'success_message'	=> __( 'Card Layout Settings successfully saved.', 'wc_product_slider' ),
				'error_message'		=> __( 'Error: Card Layout Settings can not save.', 'wc_product_slider' ),
				'reset_message'		=> __( 'Card Layout Settings successfully reseted.', 'wc_product_slider' ),
			);
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
				
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
				
		//add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_start', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_end', array( $this, 'pro_fields_after' ) );
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
			'name'				=> 'card-layout',
			'label'				=> __( 'Card Layout', 'wc_product_slider' ),
			'callback_function'	=> 'wc_product_slider_card_skin_card_layout_settings_form',
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
		
		$output = '';
		$output .= $wc_product_slider_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
		
			array(
                'type' 		=> 'heading',
				'name' 		=> __( 'Product Card - Image Height', 'wc_product_slider' ),
           	),
			array(  
				'name' 		=> __( 'Tall Type', 'wc_product_slider' ),
				'id' 		=> 'is_img_tall_dynamic',
				'class'		=> 'is_img_tall_dynamic',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 0,
				'checked_value'		=> 0,
				'unchecked_value'	=> 1,
				'checked_label'		=> __( 'Fixed', 'wc_product_slider' ),
				'unchecked_label' 	=> __( 'Dynamic', 'wc_product_slider' ),	
			),
			
			array(
                'type' 		=> 'heading',
				'class'		=> 'is_img_tall_dynamic_off',
           	),
			array(  
				'name' 		=> __( 'Height', 'wc_product_slider' ),
				'desc'		=> 'px',
				'id' 		=> 'img_height_fixed',
				'type' 		=> 'text',
				'default'	=> 250,
				'css'		=> 'width:40px;',
			),
			
			array(
                'type' 		=> 'heading',
				'name' 		=> __( 'Product Card - Product Title', 'wc_product_slider' ),
           	),
			array(  
				'name' 		=> __( 'Product Title', 'wc_product_slider' ),
				'id' 		=> 'enable_slider_title',
				'class'		=> 'enable_slider_title',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'wc_product_slider' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_product_slider' ),
			),
			
			array(
                'type' 		=> 'heading',
				'class'		=> 'slider_title_container'
           	),
			array(  
				'name' 		=> __( 'Product Title Line Wrap', 'wc_product_slider' ),
				'desc'		=> __( 'Set the number of lines that the Product Title can wrap to on the Product Card.', 'wc_product_slider' ),
				'id' 		=> 'product_title_line_wrap',
				'type' 		=> 'onoff_radio',
				'default' 	=> 'auto',
				'onoff_options' => array(
					array(
						'val' 				=> 'auto',
						'text' 				=> __( 'Auto height', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
					array(
						'val' 				=> '1',
						'text' 				=> __( '1 Line', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
					array(
						'val' 				=> '2',
						'text' 				=> __( '2 Lines', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
					array(
						'val' 				=> '3',
						'text' 				=> __( '3 Lines', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
				),
			),
			
			array(
                'type' 		=> 'heading',
				'name' 		=> __( 'Product Card - Product Rating', 'wc_product_slider' ),
           	),
			array(  
				'name' 		=> __( 'Product Rating', 'wc_product_slider' ),
				'id' 		=> 'enable_product_rating',
				'class'		=> 'enable_product_rating',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'wc_product_slider' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_product_slider' ),
			),
			
			array(
                'type' 		=> 'heading',
				'name' 		=> __( 'Product Card - Product Price', 'wc_product_slider' ),
           	),
			array(  
				'name' 		=> __( 'Product Price', 'wc_product_slider' ),
				'id' 		=> 'enable_slider_price',
				'class'		=> 'enable_slider_price',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'wc_product_slider' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_product_slider' ),
			),
			
			array(
                'type' 		=> 'heading',
				'class'		=> 'slider_price_container'
           	),
			array(  
				'name' 		=> __( 'Price Position on Product Card', 'wc_product_slider' ),
				'id' 		=> 'product_price_position',
				'type' 		=> 'onoff_radio',
				'default' 	=> 'under_title',
				'onoff_options' => array(
					array(
						'val' 				=> 'under_title',
						'text' 				=> __( 'Under Title', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
					array(
						'val' 				=> 'under_desc',
						'text' 				=> __( 'Under Description', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
				),
			),
			
			array(
                'type' 		=> 'heading',
				'name' 		=> __( 'Product Card - Product Description Extract', 'wc_product_slider' ),
           	),
			array(  
				'name' 		=> __( 'Product Description Extract', 'wc_product_slider' ),
				'id' 		=> 'enable_product_description',
				'class'		=> 'enable_product_description',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'wc_product_slider' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_product_slider' ),
			),
			
			array(
                'type' 		=> 'heading',
				'class'		=> 'product_description_container'
           	),
			array(  
				'name' 		=> __( 'Pull Product Description From', 'wc_product_slider' ),
				'id' 		=> 'product_description_type',
				'type' 		=> 'onoff_radio',
				'default' 	=> 'short_desc',
				'onoff_options' => array(
					array(
						'val' 				=> 'short_desc',
						'text' 				=> __( 'Product Short Description', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
					array(
						'val' 				=> 'full_desc',
						'text' 				=> __( 'Full Description', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
				),
			),
			array(  
				'name' 		=> __( 'Product Description Line Wrap', 'wc_product_slider' ),
				'desc'		=> __( 'Set the number of lines that the Product description text can wrap to on Product Card.', 'wc_product_slider' ),
				'id' 		=> 'product_description_line_wrap',
				'type' 		=> 'onoff_radio',
				'default' 	=> '1',
				'onoff_options' => array(
					array(
						'val' 				=> '1',
						'text' 				=> __( '1 Line', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
					array(
						'val' 				=> '2',
						'text' 				=> __( '2 Lines', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
					array(
						'val' 				=> '3',
						'text' 				=> __( '3 Lines', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
					array(
						'val' 				=> '4',
						'text' 				=> __( '4 Lines', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
				),
			),
			
			array(
                'type' 		=> 'heading',
				'name' 		=> __( 'Product Card - Product Footer Cell', 'wc_product_slider' ),
           	),
			array(  
				'name' 		=> __( 'Product Footer Cell', 'wc_product_slider' ),
				'id' 		=> 'enable_footer_cell',
				'class'		=> 'enable_footer_cell',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'wc_product_slider' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_product_slider' ),
			),
			
			array(
                'type' 		=> 'heading',
				'class'		=> 'footer_cell_container'
           	),
			array(  
				'name' 		=> __( 'Product Category', 'wc_product_slider' ),
				'id' 		=> 'enable_product_category',
				'class'		=> 'enable_product_category',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'wc_product_slider' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_product_slider' ),
			),
			array(  
				'name' 		=> __( 'Product Tag', 'wc_product_slider' ),
				'id' 		=> 'enable_product_tag',
				'class'		=> 'enable_product_tag',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
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
	if ( $("input.is_img_tall_dynamic:checked").val() == '0') {
		$(".is_img_tall_dynamic_off").show();
	} else {
		$(".is_img_tall_dynamic_off").hide();
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.is_img_tall_dynamic', function( event, value, status ) {
		if ( status == 'true' ) {
			$(".is_img_tall_dynamic_off").slideDown();
		} else {
			$(".is_img_tall_dynamic_off").slideUp();
		}
	});
	
	if ( $("input.enable_slider_title:checked").val() == '1') {
		$(".slider_title_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$(".slider_title_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.enable_slider_title', function( event, value, status ) {
		$(".slider_title_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true' ) {
			$(".slider_title_container").slideDown();
		} else {
			$(".slider_title_container").slideUp();
		}
	});
	
	if ( $("input.enable_slider_price:checked").val() == '1') {
		$(".slider_price_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$(".slider_price_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.enable_slider_price', function( event, value, status ) {
		$(".slider_price_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true' ) {
			$(".slider_price_container").slideDown();
		} else {
			$(".slider_price_container").slideUp();
		}
	});
	
	if ( $("input.enable_product_description:checked").val() == '1') {
		$(".product_description_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$(".product_description_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.enable_product_description', function( event, value, status ) {
		$(".product_description_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true' ) {
			$(".product_description_container").slideDown();
		} else {
			$(".product_description_container").slideUp();
		}
	});
	
	if ( $("input.enable_footer_cell:checked").val() == '1') {
		$(".footer_cell_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$(".footer_cell_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.enable_footer_cell', function( event, value, status ) {
		$(".footer_cell_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true' ) {
			$(".footer_cell_container").slideDown();
		} else {
			$(".footer_cell_container").slideUp();
		}
	});
	
});
})(jQuery);
</script>
    <?php	
	}
}

global $wc_product_slider_card_skin_card_layout_settings;
$wc_product_slider_card_skin_card_layout_settings = new WC_Product_Slider_Card_Skin_Card_Layout_Settings();

/** 
 * wc_product_slider_card_skin_card_layout_settings_form()
 * Define the callback function to show subtab content
 */
function wc_product_slider_card_skin_card_layout_settings_form() {
	global $wc_product_slider_card_skin_card_layout_settings;
	$wc_product_slider_card_skin_card_layout_settings->settings_form();
}

?>