<?php get_header(); ?>
<div class="woocommerce">
	<?php	
	$woocommerce_loop['single']=true;
	$woocommerce_loop['columns']=4;	
	$products=array_merge(ThemexShop::$data['products'], array(0));
	$limit=intval(themex_value('limit', $_GET, ThemexCore::getOption('products_per_page', 9)));
	$order=ThemexWoo::getSorting();
	
	query_posts(array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'paged' => themex_paged(),
		'posts_per_page' => $limit,
		'post__in' => $products,
		'orderby' => $order['orderby'],
		'order' => $order['order'],
		'meta_key' => $order['meta_key'],
	));
	
	$layout='full';
	$shop=$post->ID;
	
	ThemexWoo::getTemplate('archive-product.php');
	?>
</div>
<?php get_footer(); ?>