<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
Slider Widget Skin Dimensions Settings

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

class WC_Product_Slider_Widget_Skin_Dimensions_Settings extends WC_Product_Slider_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'dimensions';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wc_product_slider_a3_widget_skin_dimensions_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_product_slider_a3_widget_skin_dimensions_settings';
	
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
				'success_message'	=> __( 'Dimensions Settings successfully saved.', 'wc_product_slider' ),
				'error_message'		=> __( 'Error: Dimensions Settings can not save.', 'wc_product_slider' ),
				'reset_message'		=> __( 'Dimensions Settings successfully reseted.', 'wc_product_slider' ),
			);
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
				
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
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
			'name'				=> 'dimensions',
			'label'				=> __( 'Dimensions', 'wc_product_slider' ),
			'callback_function'	=> 'wc_product_slider_widget_skin_dimensions_settings_form',
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
           	),
			array(  
				'name' 		=> __( 'Tall Type', 'wc_product_slider' ),
				'id' 		=> 'is_slider_tall_dynamic',
				'class'		=> 'is_slider_tall_dynamic',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 0,
				'checked_value'		=> 0,
				'unchecked_value'	=> 1,
				'checked_label'		=> __( 'Fixed', 'wc_product_slider' ),
				'unchecked_label' 	=> __( 'Dynamic', 'wc_product_slider' ),	
			),
			
			array(
                'type' 		=> 'heading',
				'class'		=> 'is_slider_tall_dynamic_off',
           	),
			array(  
				'name' 		=> __( 'Height', 'wc_product_slider' ),
				'desc'		=> 'px',
				'id' 		=> 'slider_height_fixed',
				'type' 		=> 'text',
				'default'	=> 250,
				'css'		=> 'width:40px;',
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input.is_slider_tall_dynamic:checked").val() == '0') {
		$(".is_slider_tall_dynamic_off").show();
	} else {
		$(".is_slider_tall_dynamic_off").hide();
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.is_slider_tall_dynamic', function( event, value, status ) {
		if ( status == 'true' ) {
			$(".is_slider_tall_dynamic_off").slideDown();
		} else {
			$(".is_slider_tall_dynamic_off").slideUp();
		}
	});
	
});
})(jQuery);
</script>
    <?php	
	}
}

global $wc_product_slider_widget_skin_dimensions_settings;
$wc_product_slider_widget_skin_dimensions_settings = new WC_Product_Slider_Widget_Skin_Dimensions_Settings();

/** 
 * wc_product_slider_widget_skin_dimensions_settings_form()
 * Define the callback function to show subtab content
 */
function wc_product_slider_widget_skin_dimensions_settings_form() {
	global $wc_product_slider_widget_skin_dimensions_settings;
	$wc_product_slider_widget_skin_dimensions_settings->settings_form();
}

?>