<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
Slider Card Skin Footer Cell Settings

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

class WC_Product_Slider_Card_Skin_Footer_Cell_Settings extends WC_Product_Slider_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'footer-cell-card';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wc_product_slider_a3_card_skin_footer_cell_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_product_slider_a3_card_skin_footer_cell_settings';
	
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
				'success_message'	=> __( 'Footer Cell Style successfully saved.', 'wc_product_slider' ),
				'error_message'		=> __( 'Error: Footer Cell Style can not save.', 'wc_product_slider' ),
				'reset_message'		=> __( 'Footer Cell Style successfully reseted.', 'wc_product_slider' ),
			);
									
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
			'name'				=> 'footer-cell-card',
			'label'				=> __( 'Footer Cell', 'wc_product_slider' ),
			'callback_function'	=> 'wc_product_slider_card_skin_footer_cell_settings_form',
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
				'name'		=> __( 'Product Card - Footer Cell Style', 'wc_product_slider' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Footer Cell Background Colour', 'a3_responsive_slider' ),
				'desc' 		=> __( 'Default', 'a3_responsive_slider' ) . ' [default_value]',
				'id' 		=> 'footer_cell_background_colour',
				'type' 		=> 'color',
				'default'	=> '#F8F8F8'
			),
			array(  
				'name' 		=> __( 'Footer Cell Top Border', 'a3_responsive_slider' ),
				'id' 		=> 'footer_cell_top_border',
				'type' 		=> 'border_styles',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#000000' )
			),
			array(  
				'name' 		=> __( 'Cell Border Padding (Inside)', 'wc_product_slider' ),
				'id' 		=> 'footer_cell_padding',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array( 
											'id' 		=> 'footer_cell_padding_top',
	 										'name' 		=> __( 'Top', 'wc_product_slider' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
	 
	 								array(  'id' 		=> 'footer_cell_padding_bottom',
	 										'name' 		=> __( 'Bottom', 'wc_product_slider' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
											
									array( 
											'id' 		=> 'footer_cell_padding_left',
	 										'name' 		=> __( 'Left', 'wc_product_slider' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
											
									array( 
											'id' 		=> 'footer_cell_padding_right',
	 										'name' 		=> __( 'Right', 'wc_product_slider' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
	 							)
			),
			array(  
				'name' 		=> __( 'Footer Cell Content Alignment', 'wc_product_slider' ),
				'id' 		=> 'footer_cell_alignment',
				'type' 		=> 'onoff_radio',
				'default' 	=> 'center',
				'onoff_options' => array(
					array(
						'val' 				=> 'left',
						'text' 				=> __( 'Left', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
					array(
						'val' 				=> 'center',
						'text' 				=> __( 'Center', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
					array(
						'val' 				=> 'right',
						'text' 				=> __( 'Right', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
					array(
						'val' 				=> 'justify',
						'text' 				=> __( 'Justify', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
				),
			),
			
        ));
	}
	
}

global $wc_product_slider_card_skin_footer_cell_settings;
$wc_product_slider_card_skin_footer_cell_settings = new WC_Product_Slider_Card_Skin_Footer_Cell_Settings();

/** 
 * wc_product_slider_card_skin_footer_cell_settings_form()
 * Define the callback function to show subtab content
 */
function wc_product_slider_card_skin_footer_cell_settings_form() {
	global $wc_product_slider_card_skin_footer_cell_settings;
	$wc_product_slider_card_skin_footer_cell_settings->settings_form();
}

?>