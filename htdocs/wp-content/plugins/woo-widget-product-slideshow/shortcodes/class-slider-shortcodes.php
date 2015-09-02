<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WC Product Slider Shortcode
 *
 * Table Of Contents
 *
 * WC_Product_Slider_Shortcode()
 * init()
 * add_rslider_button()
 * rslider_generator_popup()
 * parse_shortcode_wc_product_slider()
 */
class WC_Product_Slider_Shortcode
{

	public function __construct () {
		$this->init();
	}

	public function init () {
		add_action( 'media_buttons', array( $this, 'add_slider_button' ), 99 );
		add_action( 'admin_footer', array( $this, 'slider_generator_popup' ) );
		add_shortcode( 'wc_product_slider', array( $this, 'parse_shortcode_wc_product_slider' ) );
		add_shortcode( 'wc_product_slider_carousel', array( $this, 'parse_shortcode_wc_product_slider_carousel' ) );
	}

	public function add_slider_button() {
		$is_post_edit_page = in_array( basename( $_SERVER['PHP_SELF'] ), array( 'post.php', 'page.php', 'page-new.php', 'post-new.php' ) );
        if ( ! $is_post_edit_page ) return;

		echo '<a href="#TB_inline?width=800&height=600&inlineId=wc-product-slider-wrap" class="thickbox button wc-product-slider-add-shortcode" title="' . __( 'Insert shortcode', 'wc_product_slider' ) . '"><span class="wc-product-slider-add-shortcode-icon"></span>'.__( 'Product Slider', 'wc_product_slider' ).'</a>';
	}

	public function slider_generator_popup() {
		$is_post_edit_page = in_array( basename( $_SERVER['PHP_SELF'] ), array( 'post.php', 'page.php', 'page-new.php', 'post-new.php' ) );
        if ( ! $is_post_edit_page ) return;

		?>
		<div id="wc-product-slider-wrap" style="display:none">

        	<fieldset id="wc_product_slider_upgrade_area"><legend><?php _e( 'Insert WC Product Slider', 'wc_product_slider' ); ?> - <?php _e('Upgrade to','wc_product_slider'); ?> <a href="<?php echo WC_PRODUCT_SLIDER_VERSION_URI; ?>" target="_blank"><?php _e('Product Slider Version', 'wc_product_slider'); ?></a> <?php _e('to activate', 'wc_product_slider'); ?></legend>
            <div id="wc-product-slider-content" class="wc-product-slider-content wc-product-slider-shortcode-popup-container" style="text-align:left;">
            	<p>
                    <label for="wc_product_slider_show_type"><strong><?php _e( 'Show Type:', 'wc_product_slider' ); ?></strong></label>
                    <select class="wc_product_slider_show_type" id="wc_product_slider_show_type" name="wc_product_slider_show_type" >
                        <option value="category" selected="selected"><?php _e( 'Category', 'wc_product_slider' ); ?></option>
                        <option value="tag"><?php _e( 'Tag', 'wc_product_slider' ); ?></option>
                        <option value="featured"><?php _e( 'Featured', 'wc_product_slider' ); ?></option>
                        <option value="onsale"><?php _e( 'On Sale', 'wc_product_slider' ); ?></option>
                    </select>
                </p>

                <p id="wc_product_slider_show_type_category" >
                	<label for="wc_product_slider_category_id"><?php _e('Category:', 'wc_product_slider'); ?></label>
                	<?php wp_dropdown_categories( array('orderby' => 'name', 'name' => 'wc_product_slider_category_id', 'id' => 'wc_product_slider_category_id', 'class' => 'wc_product_slider_category_id', 'depth' => true, 'taxonomy' => 'product_cat') ); ?>
                </p>

                <p id="wc_product_slider_show_type_tag" style="display:none" >
                	<label for="wc_product_slider_tag_id"><?php _e('Tag:', 'wc_product_slider'); ?></label>
                	<?php wp_dropdown_categories( array('orderby' => 'name', 'name' => 'wc_product_slider_tag_id', 'id' => 'wc_product_slider_tag_id', 'class' => 'wc_product_slider_tag_id', 'depth' => true, 'taxonomy' => 'product_tag') ); ?>
                </p>

                <p id="wc_product_slider_filter_type_container">
                    <label for="wc_product_slider_filter_type"><strong><?php _e('Filter:', 'wc_product_slider'); ?></strong></label>
                    <select id="wc_product_slider_filter_type" name="wc_product_slider_filter_type" >
                        <option value="" selected="selected"><?php _e( 'Recent', 'wc_product_slider' ); ?></option>
                        <option value="featured"><?php _e( 'Featured', 'wc_product_slider' ); ?></option>
                        <option value="onsale"><?php _e( 'On Sale', 'wc_product_slider' ); ?></option>
                    </select>
                </p>

                <p><label for="wc_product_slider_number_products"><?php _e('Number of products:', 'wc_product_slider'); ?></label> <input id="wc_product_slider_number_products" name="wc_product_slider_number_products" type="text" value="6" size="2" /><br />
                <span class="description"><?php _e('Important! Set -1 to show all products. Warning - Setting large numbers (unlimited) could / will have an  impact on page load speed on some sites.', 'wc_product_slider'); ?></span>
                </p>

                <div style="border-top:2px dashed #111111; height:4px;">&nbsp;</div>

                <fieldset id="wc_product_slider_upgrade_area">
                <legend><?php _e('Upgrade to','wc_product_slider'); ?> <a href="<?php echo WC_CAROUSEL_SLIDER_VERSION_URI; ?>" target="_blank"><?php _e('Carousel & Slider Version', 'wc_product_slider'); ?></a> <?php _e('to activate', 'wc_product_slider'); ?></legend>
                <p><label><strong><?php _e( 'Slider Type:', 'wc_product_slider' ); ?></strong></label>
                    <label><input type="radio" class="wc_product_slider_slider_type" name="wc_product_slider_slider_type" value="default" checked="checked" /> <?php _e( 'SLIDER', 'wc_product_slider' ); ?></label> &nbsp;&nbsp;&nbsp;
                    <label><input type="radio" class="wc_product_slider_slider_type" name="wc_product_slider_slider_type" value="carousel" /> <?php _e( 'CAROUSEL', 'wc_product_slider' ); ?></label>
                </p>

                <div id="wc_product_slider_slider_type_carousel" style="display:none;">
                	<p><label><strong><?php _e( 'Carousel Type:', 'wc_product_slider' ); ?></strong></label>
                        <label><input type="radio" class="wc_product_slider_slider_carousel_type" name="wc_product_slider_slider_carousel_type" value="horizontal" checked="checked" /> <?php _e( 'HORIZONTAL', 'wc_product_slider' ); ?></label> &nbsp;&nbsp;&nbsp;
                        <label><input type="radio" class="wc_product_slider_slider_carousel_type" name="wc_product_slider_slider_carousel_type" value="vertical" /> <?php _e( 'VERTICAL', 'wc_product_slider' ); ?></label>
                    </p>

                    <p><label for="wc_product_slider_slider_carousel_visible"><?php _e('Carousel number visible:', 'wc_product_slider'); ?></label> <input id="wc_product_slider_slider_carousel_visible" name="wc_product_slider_slider_carousel_visible" type="text" value="4" size="1" />
                    <span class="description"><?php _e('Number of slides to be displayed in the carousel.', 'wc_product_slider'); ?></span>
                    </p>
                </div>
                </fieldset>

                <div id="wc_product_slider_slider_type_default">
                    <p><label><strong><?php _e( 'Skin Type:', 'wc_product_slider' ); ?></strong></label>
                        <label><input type="radio" class="wc_product_slider_skin_type" name="wc_product_slider_skin_type" value="widget" checked="checked" /> <?php _e( 'WIDGET', 'wc_product_slider' ); ?></label> &nbsp;&nbsp;&nbsp;
                        <label><input type="radio" class="wc_product_slider_skin_type" name="wc_product_slider_skin_type" value="card" /> <?php _e( 'CARD', 'wc_product_slider' ); ?></label>
                    </p>

                    <div id="wc_product_slider_skin_type_widget">
                        <p><label for="wc_product_slider_widget_effect"><strong><?php _e('Effects Type:', 'wc_product_slider'); ?></strong></label>
                            <select id="wc_product_slider_widget_effect" name="wc_product_slider_widget_effect" >
                            <?php
                            $transitions_list = WC_Product_Slider_Functions::slider_transitions_list();
                            foreach ( $transitions_list as $effect_key => $effect_name ) {
                            ?>
                                <option value="<?php echo $effect_key; ?>" <?php if ( $effect_key == 'fade' ) { echo 'selected="selected"'; } ?>><?php echo $effect_name; ?></option>
                            <?php
                            }
                            ?>
                            </select>
                        </p>
                    </div>

                    <div id="wc_product_slider_skin_type_card" style="display:none">
                        <p><label><strong><?php _e('Effects Type:', 'wc_product_slider'); ?></strong></label>
                            <select id="wc_product_slider_card_effect" name="wc_product_slider_card_effect" >
                            <?php
                            $transitions_list = WC_Product_Slider_Functions::card_slider_transitions_list();
                            foreach ( $transitions_list as $effect_key => $effect_name ) {
                            ?>
                                <option value="<?php echo $effect_key; ?>" <?php if ( $effect_key == 'fade' ) { echo 'selected="selected"'; } ?>><?php echo $effect_name; ?></option>
                            <?php
                            }
                            ?>
                            </select>
                        </p>
                    </div>
                </div>

                <div style="border-top:2px dashed #111111; height:4px;">&nbsp;</div>

                <p><label><strong><?php _e( 'Transition Method:', 'wc_product_slider' ); ?></strong></label>
                    <label><input type="radio" class="wc_product_slider_auto_scroll" name="wc_product_slider_auto_scroll" value="no" checked="checked" /> <?php _e( 'MANUAL', 'wc_product_slider' ); ?></label> &nbsp;&nbsp;&nbsp;
                    <label><input type="radio" class="wc_product_slider_auto_scroll" name="wc_product_slider_auto_scroll" value="yes" /> <?php _e( 'AUTO', 'wc_product_slider' ); ?></label>
                </p>

                <div id="wc_product_slider_auto_scroll_auto" style="display:none;">
                    <p><label for="wc_product_slider_effect_delay"><?php _e('Auto Start Delay:', 'wc_product_slider'); ?></label> <input id="wc_product_slider_effect_delay" name="wc_product_slider_effect_delay" type="text" value="1" size="1" /> <?php _e('seconds', 'wc_product_slider'); ?></p>
                </div>

                <p><label for="wc_product_slider_effect_timeout"><?php _e('Time Between Transitions:', 'wc_product_slider'); ?></label> <input id="wc_product_slider_effect_timeout" name="wc_product_slider_effect_timeout" type="text" value="4" size="1" /> <?php _e('seconds', 'wc_product_slider'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="wc_product_slider_effect_speed"><?php _e('Transition Effect Speed:', 'wc_product_slider'); ?></label> <input id="wc_product_slider_effect_speed" name="wc_product_slider_effect_speed" type="text" value="2" size="1" /> <?php _e('seconds', 'wc_product_slider'); ?>
                </p>

				<div style="border-top:2px dashed #111111; height:4px;">&nbsp;</div>

                <p><label for="wc_product_slider_align"><?php _e( 'Slider Alignment', 'wc_product_slider' ); ?>:</label>
                <select style="width:120px" id="wc_product_slider_align" name="wc_product_slider_align">
                	<option value="none" selected="selected"><?php _e( 'None', 'wc_product_slider' ); ?></option>
                    <option value="left-wrap"><?php _e( 'Left - wrap', 'wc_product_slider' ); ?></option>
                    <option value="left"><?php _e( 'Left - no wrap', 'wc_product_slider' ); ?></option>
                    <option value="center"><?php _e( 'Center', 'wc_product_slider' ); ?></option>
                    <option value="right-wrap"><?php _e( 'Right - wrap', 'wc_product_slider' ); ?></option>
                    <option value="right"><?php _e( 'Right - no wrap', 'wc_product_slider' ); ?></option>
                </select> <span class="description"><?php _e( 'Wrap is text wrap like images', 'wc_product_slider' ); ?></span></p>
				<p><label for="wc_product_slider_width"><?php _e( 'Slider Width', 'wc_product_slider' ); ?>:</label> <input style="width:50px;" size="10" id="wc_product_slider_width" name="wc_product_slider_width" type="text" value="300" />
                <select style="width:60px" id="wc_product_slider_width_type" name="wc_product_slider_width_type">
                	<option value="px" selected="selected">px</option>
                    <option value="%">%</option>
                </select>
                </p>
                <p><label for=""><strong><?php _e( 'Slider Margin', 'wc_product_slider' ); ?></strong>:</label><br />
                        <label for="wc_product_slider_margin_top" style="width:auto; float:none"><?php _e( 'Above', 'wc_product_slider' ); ?>:</label><input style="width:50px;" size="10" id="wc_product_slider_margin_top" name="wc_product_slider_margin_top" type="text" value="10" />px &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="wc_product_slider_margin_bottom" style="width:auto; float:none"><?php _e( 'Below', 'wc_product_slider' ); ?>:</label> <input style="width:50px;" size="10" id="wc_product_slider_margin_bottom" name="wc_product_slider_margin_bottom" type="text" value="10" />px &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="wc_product_slider_margin_left" style="width:auto; float:none"><?php _e( 'Left', 'wc_product_slider' ); ?>:</label> <input style="width:50px;" size="10" id="wc_product_slider_margin_left" name="wc_product_slider_margin_left" type="text" value="10" />px &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="wc_product_slider_margin_right" style="width:auto; float:none"><?php _e( 'Right', 'wc_product_slider' ); ?>:</label> <input style="width:50px;" size="10" id="wc_product_slider_margin_right" name="wc_product_slider_margin_right" type="text" value="10" />px
                </p>
			</div>
            <div style="clear:both;height:0px"></div>
            <p><input type="button" class="button button-primary" value="<?php _e( 'Insert Shortcode', 'wc_product_slider' ); ?>" disabled="disabled" />
            <input type="button" class="button" onclick="tb_remove(); return false;" value="<?php _e('Cancel', 'wc_product_slider'); ?>" />
			</p>
            </fieldset>

		</div>
        <script type="text/javascript">
		(function($) {
		$(document).ready(function() {
			$("input.wc_product_slider_slider_type").change( function() {
				if ( $("input.wc_product_slider_slider_type:checked").val() == 'default') {
					$("#wc_product_slider_slider_type_carousel").slideUp();
				} else {
					$("#wc_product_slider_slider_type_carousel").slideDown();
				}
			});

			$("select.wc_product_slider_show_type").change( function() {
				if ( $("select.wc_product_slider_show_type").val() == 'category') {
					$("#wc_product_slider_show_type_category").slideDown();
					$("#wc_product_slider_show_type_tag").slideUp();
                    $("#wc_product_slider_filter_type_container").slideDown();
				} else if ( $("select.wc_product_slider_show_type").val() == 'tag') {
					$("#wc_product_slider_show_type_category").slideUp();
					$("#wc_product_slider_show_type_tag").slideDown();
                    $("#wc_product_slider_filter_type_container").slideDown();
				} else {
					$("#wc_product_slider_show_type_category").slideUp();
					$("#wc_product_slider_show_type_tag").slideUp();
                    $("#wc_product_slider_filter_type_container").slideUp();
				}
			});

			$("input.wc_product_slider_skin_type").change( function() {
				if ( $("input.wc_product_slider_skin_type:checked").val() == 'widget') {
					$("#wc_product_slider_skin_type_widget").slideDown();
					$("#wc_product_slider_skin_type_card").slideUp();
				} else {
					$("#wc_product_slider_skin_type_widget").slideUp();
					$("#wc_product_slider_skin_type_card").slideDown();
				}
			});

			$("input.wc_product_slider_auto_scroll").change( function() {
				if ( $("input.wc_product_slider_auto_scroll:checked").val() == 'yes') {
					$("#wc_product_slider_auto_scroll_auto").slideDown();
				} else {
					$("#wc_product_slider_auto_scroll_auto").slideUp();
				}
			});

		});
		})(jQuery);

		</script>
		<?php
	}

	public function parse_shortcode_wc_product_slider( $attributes ) {
		return '';
	}

	public function parse_shortcode_wc_product_slider_carousel( $attributes ) {
		return '';
	}

}
?>
