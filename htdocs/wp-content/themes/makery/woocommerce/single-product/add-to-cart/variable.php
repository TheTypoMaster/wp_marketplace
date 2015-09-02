<?php
/*
@version 3.0.0
*/

if(!defined('ABSPATH')){
    exit;
}

global $product, $post;
?>
<?php do_action('woocommerce_before_add_to_cart_form'); ?>
<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr(json_encode($available_variations))?>">
	<?php if(!empty($available_variations)) { ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php $loop=0; foreach($attributes as $name => $options): $loop++; ?>
					<tr>
						<th class="label"><label for="<?php echo sanitize_title($name); ?>"><?php echo wc_attribute_label($name); ?></label></th>
						<td class="value">
							<div class="element-select">
								<span></span>
								<select id="<?php echo esc_attr(sanitize_title($name)); ?>" name="attribute_<?php echo sanitize_title($name); ?>">
									<option value=""><?php echo __('Choose an option', 'makery')?>&hellip;</option>
									<?php
									if(is_array($options)){

										if(isset($_REQUEST[ 'attribute_'.sanitize_title($name)])){
											$selected_value=$_REQUEST[ 'attribute_'.sanitize_title($name)];
										} elseif(isset($selected_attributes[ sanitize_title($name)])){
											$selected_value=$selected_attributes[ sanitize_title($name)];
										} else {
											$selected_value='';
										}

										if(taxonomy_exists(sanitize_title($name))){

											$orderby=wc_attribute_orderby(sanitize_title($name));

											switch($orderby){
												case 'name' :
													$args=array('orderby' => 'name', 'hide_empty' => false, 'menu_order' => false);
												break;
												case 'id' :
													$args=array('orderby' => 'id', 'order' => 'ASC', 'menu_order' => false, 'hide_empty' => false);
												break;
												case 'menu_order' :
													$args=array('menu_order' => 'ASC', 'hide_empty' => false);
												break;
											}

											$terms=get_terms(sanitize_title($name), $args);

											foreach($terms as $term){
												if(! in_array($term->slug, $options))
													continue;

												echo '<option value="'.esc_attr($term->slug). '" '.selected(sanitize_title($selected_value), sanitize_title($term->slug), false). '>'.apply_filters('woocommerce_variation_option_name', $term->name). '</option>';
											}
										} else {
											foreach($options as $option){
												echo '<option value="'.esc_attr(sanitize_title($option)). '" '.selected(sanitize_title($selected_value), sanitize_title($option), false). '>'.esc_html(apply_filters('woocommerce_variation_option_name', $option)). '</option>';
											}
										}
									}
									?>
								</select>
							</div>
						</td>
					</tr>
		        <?php endforeach;?>
			</tbody>
		</table>
		<div class="item-options clearfix">
			<?php do_action('woocommerce_before_add_to_cart_button'); ?>
			<div class="single_variation_wrap clearfix" style="display:none;">
				<?php do_action('woocommerce_before_single_variation'); ?>
				<?php if(strpos($product->get_price_html(), '&ndash')==false) { ?>
				<div class="item-price"><?php echo $product->get_price_html(); ?></div>
				<?php } else { ?>
				<div class="single_variation item-price"></div>
				<?php } ?>
				<?php woocommerce_quantity_input(); ?>
				<a href="#" class="element-button element-submit primary"><?php echo $product->single_add_to_cart_text(); ?></a>
				<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
				<input type="hidden" name="product_id" value="<?php echo esc_attr($post->ID); ?>" />
				<input type="hidden" name="variation_id" value="" />
				<?php do_action('woocommerce_after_single_variation'); ?>
				<?php if(is_user_logged_in()) { ?>
					<?php if(!ThemexCore::checkOption('product_favorites')) { ?>
						<?php if(in_array($product->id, ThemexUser::$data['current']['favorites'])) { ?>
						<a href="#favorite_form" title="<?php _e('Remove from Favorites', 'makery'); ?>" class="element-button element-submit secondary active" data-title="<?php _e('Add to Favorites', 'makery'); ?>"><span class="fa fa-heart"></span></a>
						<?php } else { ?>
						<a href="#favorite_form" title="<?php _e('Add to Favorites', 'makery'); ?>" class="element-button element-submit secondary" data-title="<?php _e('Remove from Favorites', 'makery'); ?>"><span class="fa fa-heart"></span></a>
						<?php } ?>
					<?php } ?>
					<?php if(!ThemexCore::checkOption('product_questions')) { ?>
					<a href="#contact_form_<?php echo $product->id; ?>" class="element-button element-colorbox square secondary" title="<?php _e('Ask a Question', 'makery'); ?>"><span class="fa fa-comment"></span></a>
					<?php } ?>
				<?php } else { ?>
					<?php if(!ThemexCore::checkOption('product_favorites')) { ?>
					<a href="<?php echo ThemexCore::getURL('register'); ?>" title="<?php _e('Add to Favorites', 'makery'); ?>" class="element-button secondary"><span class="fa fa-heart"></span></a>
					<?php } ?>
					<?php if(!ThemexCore::checkOption('product_questions')) { ?>
					<a href="<?php echo ThemexCore::getURL('register'); ?>" class="element-button square secondary" title="<?php _e('Ask a Question', 'makery'); ?>"><span class="fa fa-comment"></span></a>
					<?php } ?>
				<?php } ?>
			</div>
			<?php do_action('woocommerce_after_add_to_cart_button'); ?>			
		</div>
	<?php } else { ?>
		<p class="stock out-of-stock secondary"><?php _e('This product is currently out of stock and unavailable.', 'makery'); ?></p>
	<?php } ?>
</form>
<?php if(!ThemexCore::checkOption('product_favorites')) { ?>
<form id="favorite_form" class="element-form" method="POST" action="<?php echo AJAX_URL; ?>">
	<?php if(in_array($product->id, ThemexUser::$data['current']['favorites'])) { ?>
	<input type="hidden" name="user_action" class="toggle" value="remove_relation" data-value="add_relation" />
	<?php } else { ?>
	<input type="hidden" name="user_action" class="toggle" value="add_relation" data-value="remove_relation" />
	<?php } ?>
	<input type="hidden" name="relation_type" value="product" />
	<input type="hidden" name="relation_id" value="<?php echo $product->id; ?>" />
	<input type="hidden" name="action" class="action" value="<?php echo THEMEX_PREFIX; ?>update_user" />
</form>
<?php } ?>
<div class="site-popups hidden">
	<?php if(!ThemexCore::checkOption('product_questions')) { ?>
	<div id="contact_form_<?php echo $product->id; ?>">
		<div class="site-popup medium">
			<form class="site-form element-form" method="POST" action="<?php echo AJAX_URL; ?>">
				<div class="field-wrap">
					<input type="text" name="email" readonly="readonly" value="<?php echo esc_attr(ThemexUser::$data['current']['email']); ?>" />
				</div>
				<div class="field-wrap">
					<textarea name="question" cols="30" rows="5" placeholder="<?php _e('Question', 'makery'); ?>"></textarea>
				</div>
				<a href="#" class="element-button element-submit primary"><?php _e('Send Question', 'makery'); ?></a>				
				<input type="hidden" name="product_id" value="<?php echo $product->id; ?>" />
				<input type="hidden" name="shop_action" value="submit_question" />
				<input type="hidden" name="action" class="action" value="<?php echo THEMEX_PREFIX; ?>update_shop" />
			</form>
		</div>
	</div>
	<?php } ?>
</div>
<!-- /popups -->
<?php do_action('woocommerce_after_add_to_cart_form'); ?>