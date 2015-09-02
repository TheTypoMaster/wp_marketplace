<style>
<?php
global $wc_product_slider_admin_interface, $wc_product_slider_fonts_face;
?>
/* ------ START : WIDGET SKIN ------ */

/* Slider Dimensions */
<?php 
global $wc_product_slider_a3_widget_skin_dimensions_settings;
extract( $wc_product_slider_a3_widget_skin_dimensions_settings ); 
?>
<?php
$slider_container_tall = 'auto';
if ( $is_slider_tall_dynamic == 0 ) {
	$slider_container_tall = $slider_height_fixed.'px';
}
?>
.wc-product-slider-widget-skin-container .wc-product-slider {
	height: <?php echo $slider_container_tall; ?>;
}

/* Slider Controls */
<?php 
global $wc_product_slider_a3_widget_skin_control_settings;
extract( $wc_product_slider_a3_widget_skin_control_settings ); 
?>
.wc-product-slider-widget-skin-container .a3-cycle-controls {
<?php if ( $enable_slider_control != 0 ) { ?>
	display: inline !important;
<?php } ?>
<?php if ( $slider_control_transition == 'alway' ) { ?>
	opacity:1;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
	filter: alpha(opacity=1);
	-moz-opacity: 1;
	-khtml-opacity: 1;
<?php } ?>
}
.wc-product-slider-widget-skin-container .a3-cycle-controls .cycle-prev{
<?php if ( $control_previous_icon != '' ) { ?>
	background-image: url("<?php echo $control_previous_icon; ?>");
<?php } ?>
}
.wc-product-slider-widget-skin-container .a3-cycle-controls .cycle-next {
<?php if ( $control_next_icon != '' ) { ?>
    background-image: url("<?php echo $control_next_icon; ?>");
<?php } ?>
	
}
.wc-product-slider-widget-skin-container .a3-cycle-controls .cycle-pause {
<?php if ( $control_pause_icon != '' ) { ?>
    background-image: url("<?php echo $control_pause_icon; ?>");
<?php } ?>
}
.wc-product-slider-widget-skin-container .a3-cycle-controls .cycle-play {
<?php if ( $control_play_icon != '' ) { ?>
    background-image: url("<?php echo $control_play_icon; ?>");
<?php } ?>
}

/* Slider Pager */
<?php 
global $wc_product_slider_a3_widget_skin_pager_settings;
extract( $wc_product_slider_a3_widget_skin_pager_settings ); 
?>
.wc-product-slider-widget-skin-container .cycle-pager-container {
<?php if ( $enable_slider_pager != 0 ) { ?>
	display: inline !important;
<?php } ?>
<?php if ( $slider_pager_transition == 'alway' ) { ?>
	opacity:1;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
	filter: alpha(opacity=1);
	-moz-opacity: 1;
	-khtml-opacity: 1;
<?php } ?>
<?php if ( $slider_pager_position == 'top-left' ) { ?>
	top: 10px;
	right: auto;
	bottom: auto;
	left: 10px;
<?php } elseif ( $slider_pager_position == 'top-center' ) { ?>
	top: 10px;
	right: auto;
	bottom: auto;
	left: auto;
	width:100%;
<?php } elseif ( $slider_pager_position == 'top-right' ) { ?>
	top: 10px;
	right: 10px;
	bottom: auto;
	left: auto;
<?php } elseif ( $slider_pager_position == 'bottom-left' ) { ?>
	top: auto;
	right: auto;
	bottom: 10px;
	left: 10px;
<?php } elseif ( $slider_pager_position == 'bottom-center' ) { ?>
	top: auto;
	right: auto;
	bottom: 10px;
	left: auto;
	width:100%;
<?php } else { ?>
	top: auto;
	right: 10px;
	bottom: 10px;
	left: auto;
<?php } ?>
}
.wc-product-slider-widget-skin-container .cycle-pager-overlay {
	/*Background*/
	background-color: <?php echo $pager_background_colour; ?> !important;
	/* Shadow */
	<?php echo $wc_product_slider_admin_interface->generate_shadow_css( $pager_shadow ); ?>
	/*Border Corner*/
	<?php echo $wc_product_slider_admin_interface->generate_border_corner_css( $pager_border ); ?>
	
	/* Transparency */
	opacity:<?php echo $pager_background_transparency / 100; ?>;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=<?php echo $pager_background_transparency; ?>)";
	filter: alpha(opacity=<?php echo $pager_background_transparency / 100; ?>);
	-moz-opacity: <?php echo $pager_background_transparency / 100; ?>;
	-khtml-opacity: <?php echo $pager_background_transparency / 100; ?>;
}
.wc-product-slider-widget-skin-container .cycle-pager {
	/*Border*/
	<?php echo $wc_product_slider_admin_interface->generate_border_css( $pager_border ); ?> 
}
.wc-product-slider-widget-skin-container .cycle-pager span {
<?php if ( $slider_pager_direction == 'vertical' ) { ?>
	float: none !important;
<?php } ?>
	/*Background*/
	background-color: <?php echo $pager_item_background_colour; ?> !important;
	/*Border*/
	<?php echo $wc_product_slider_admin_interface->generate_border_css( $pager_item_border ); ?>
	/* Shadow */
	<?php echo $wc_product_slider_admin_interface->generate_shadow_css( $pager_item_shadow ); ?>
}
.wc-product-slider-widget-skin-container .cycle-pager span.cycle-pager-active {
	/*Background*/
	background-color: <?php echo $pager_activate_item_background_colour; ?> !important;
	/*Border*/
	<?php echo $wc_product_slider_admin_interface->generate_border_css( $pager_activate_item_border ); ?>
	/* Shadow */
	<?php echo $wc_product_slider_admin_interface->generate_shadow_css( $pager_activate_item_shadow ); ?>
}

/* Title Style */
<?php 
global $wc_product_slider_a3_widget_skin_title_settings;
extract( $wc_product_slider_a3_widget_skin_title_settings ); 
?>
.wc-product-slider-widget-skin-container .cycle-product-name {
<?php if ( $enable_slider_title == 0 ) { ?>
	display: none !important;
<?php } else { ?>
	display:block;
<?php } ?>
}
.wc-product-slider-widget-skin-container .cycle-product-name {
	padding:0 !important;
	margin: <?php echo $title_margin_top; ?>px <?php echo $title_margin_right; ?>px <?php echo $title_margin_bottom; ?>px <?php echo $title_margin_left; ?>px !important;
}
.wc-product-slider-widget-skin-container .cycle-product-name a {
	/* Font */
	<?php echo $wc_product_slider_fonts_face->generate_font_css( $title_font ); ?>
}
.wc-product-slider-widget-skin-container .cycle-product-name a:hover {
	color: <?php echo $title_font_hover_color; ?> !important;
}

/* Price Style */
<?php 
global $wc_product_slider_a3_widget_skin_price_settings;
extract( $wc_product_slider_a3_widget_skin_price_settings ); 
?>
.wc-product-slider-widget-skin-container .cycle-product-price {
<?php if ( $enable_slider_price == 0 ) { ?>
	display: none !important;
<?php } else { ?>
	display:block;
<?php } ?>
}
.wc-product-slider-widget-skin-container .cycle-product-price {
	padding:0 !important;
	margin: <?php echo $price_margin_top; ?>px <?php echo $price_margin_right; ?>px <?php echo $price_margin_bottom; ?>px <?php echo $price_margin_left; ?>px !important;
}
.wc-product-slider-widget-skin-container .cycle-product-price span, .wc-product-slider-widget-skin-container .cycle-product-price .amount  {
	/* Font */
	<?php echo $wc_product_slider_fonts_face->generate_font_css( $price_font ); ?>
}
.wc-product-slider-widget-skin-container .cycle-product-price del, .wc-product-slider-widget-skin-container .cycle-product-price del .amount {
	/* Font */
	<?php echo $wc_product_slider_fonts_face->generate_font_css( $old_price_font ); ?>
}

/* View Product Style */
<?php 
global $wc_product_slider_a3_widget_skin_product_link_settings;
extract( $wc_product_slider_a3_widget_skin_product_link_settings ); 
?>
.wc-product-slider-widget-skin-container .cycle-widget-skin-product-linked-container {
<?php if ( $enable_product_link == 0 ) { ?>
	display: none !important;
<?php } else { ?>
	display:block;
<?php } ?>
}
.wc-product-slider-widget-skin-container .cycle-widget-skin-product-linked-container {
	padding: <?php echo $product_link_padding_top; ?>px <?php echo $product_link_padding_right; ?>px <?php echo $product_link_padding_bottom; ?>px <?php echo $product_link_padding_left; ?>px !important;
	margin: <?php echo $product_link_margin_top; ?>px <?php echo $product_link_margin_right; ?>px <?php echo $product_link_margin_bottom; ?>px <?php echo $product_link_margin_left; ?>px !important;
	/*Background*/
	background-color: <?php echo $product_link_background_colour; ?> !important;
	/*Border*/
	<?php echo $wc_product_slider_admin_interface->generate_border_css( $product_link_border ); ?>
	/* Shadow */
	<?php echo $wc_product_slider_admin_interface->generate_shadow_css( $product_link_shadow ); ?>
	/* Alignment */
	text-align:<?php echo $product_link_alignment; ?> !important;
}
.wc-product-slider-widget-skin-container .cycle-widget-skin-product-linked-container a.cycle-product-linked {
	/* Font */
	<?php echo $wc_product_slider_fonts_face->generate_font_css( $product_link_font ); ?>
}
.wc-product-slider-widget-skin-container .cycle-widget-skin-product-linked-container a.cycle-product-linked:hover {
	/* Hover */
	color: <?php echo $product_link_font_hover_color; ?> !important;
}

/* Category Link Style */
<?php 
global $wc_product_slider_a3_widget_skin_category_tag_link_settings;
extract( $wc_product_slider_a3_widget_skin_category_tag_link_settings ); 
?>
.wc-product-slider-widget-skin-container .cycle-widget-skin-category-linked-container {
<?php if ( $enable_category_link == 0 ) { ?>
	display: none !important;
<?php } else { ?>
	display:block;
<?php } ?>
}
.wc-product-slider-widget-skin-container .cycle-widget-skin-category-linked-container {
	padding: <?php echo $category_link_padding_top; ?>px <?php echo $category_link_padding_right; ?>px <?php echo $category_link_padding_bottom; ?>px <?php echo $category_link_padding_left; ?>px !important;
	margin: <?php echo $category_link_margin_top; ?>px <?php echo $category_link_margin_right; ?>px <?php echo $category_link_margin_bottom; ?>px <?php echo $category_link_margin_left; ?>px !important;
	/*Background*/
	background-color: <?php echo $category_link_background_colour; ?> !important;
	/*Border*/
	<?php echo $wc_product_slider_admin_interface->generate_border_css( $category_link_border ); ?>
	/* Shadow */
	<?php echo $wc_product_slider_admin_interface->generate_shadow_css( $category_link_shadow ); ?>
	/* Alignment */
	text-align:<?php echo $category_link_alignment; ?> !important;
}
.wc-product-slider-widget-skin-container .cycle-widget-skin-category-linked-container a.cycle-category-linked {
	/* Font */
	<?php echo $wc_product_slider_fonts_face->generate_font_css( $category_link_font ); ?>
}
.wc-product-slider-widget-skin-container .cycle-widget-skin-category-linked-container a.cycle-category-linked:hover {
	/* Hover */
	color: <?php echo $category_link_font_hover_color; ?> !important;
}

/* Tag Link Style */
.wc-product-slider-widget-skin-container .cycle-widget-skin-tag-linked-container {
<?php if ( $enable_tag_link == 0 ) { ?>
	display: none !important;
<?php } else { ?>
	display:block;
<?php } ?>
}
.wc-product-slider-widget-skin-container .cycle-widget-skin-tag-linked-container {
	padding: <?php echo $tag_link_padding_top; ?>px <?php echo $tag_link_padding_right; ?>px <?php echo $tag_link_padding_bottom; ?>px <?php echo $tag_link_padding_left; ?>px !important;
	margin: <?php echo $tag_link_margin_top; ?>px <?php echo $tag_link_margin_right; ?>px <?php echo $tag_link_margin_bottom; ?>px <?php echo $tag_link_margin_left; ?>px !important;
	/*Background*/
	background-color: <?php echo $tag_link_background_colour; ?> !important;
	/*Border*/
	<?php echo $wc_product_slider_admin_interface->generate_border_css( $tag_link_border ); ?>
	/* Shadow */
	<?php echo $wc_product_slider_admin_interface->generate_shadow_css( $tag_link_shadow ); ?>
	/* Alignment */
	text-align:<?php echo $tag_link_alignment; ?> !important;
}
.wc-product-slider-widget-skin-container .cycle-widget-skin-tag-linked-container a.cycle-tag-linked {
	/* Font */
	<?php echo $wc_product_slider_fonts_face->generate_font_css( $tag_link_font ); ?>
}
.wc-product-slider-widget-skin-container .cycle-widget-skin-tag-linked-container a.cycle-tag-linked:hover {
	/* Hover */
	color: <?php echo $tag_link_font_hover_color; ?> !important;
}

/* ------ END : WIDGET SKIN -------- */


</style>