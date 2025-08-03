<?php
// INCLUDES FILE PHP & JS
function flatsome_child_enqueue_scripts()
{
	wp_enqueue_script('flatsome-child-custom-js', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), '1.0', true);
}
foreach (glob(__DIR__ . '/includes/*.php') as $file) {
	include $file;
}
add_action('wp_enqueue_scripts', 'flatsome_child_enqueue_scripts', 999);
// THAY ĐỔI NỘI DUNG
function my_custom_translations($strings)
{
	$text = array();
	$strings = str_ireplace(array_keys($text), $text, $strings);
	return $strings;
}
add_filter('gettext', 'my_custom_translations', 20);

// 
function breadcrumb()
{
	if (!is_front_page()) {
		if (function_exists('rank_math_the_breadcrumbs')) {
			echo '<div class="breadcrumb-wrapper">';
			echo '<div class="container">';
			rank_math_the_breadcrumbs();
			echo '</div>';
			echo '</div>';
		} else {
			echo '<div class="breadcrumb-wrapper"><div class="container"><nav aria-label="breadcrumbs" class="rank-math-breadcrumb"><p><a href="https://kan.com.vn/">Trang chủ</a><span class="separator"> » </span><span class="last">Tuyển dụng</span></p></nav></div></div>';
		}
	}
}
add_action('flatsome_after_header', 'breadcrumb');
add_shortcode('breadcrumb', 'breadcrumb');

function ux_builder_element_breadcrumb()
{
	add_ux_builder_shortcode('breadcrumb', array(
		'name'      => __('Breadcrumb'),
		'category'  => __('Content'),
		'priority'  => 1,
	));
}
add_action('ux_builder_setup', 'ux_builder_element_breadcrumb');



// follow link
add_action('init', function () {
	flatsome_register_follow_link('zalo', 'Zalo', array(
		'icon'     => '<img src="/wp-content/uploads/2025/08/zalo-1.png" alt="Zalo">',
		'priority' => 201,
	));
	flatsome_register_follow_link('map', 'Map', array(
		'icon'     => '<img src="/wp-content/uploads/2025/08/map.png" alt="Map">',
		'priority' => 204,
	));
});

add_filter('flatsome_follow_links', function ($links, $args) {
	$links['instagram']['icon'] = '<img src="/wp-content/uploads/2025/06/instagram.png" alt="Instagram">';
	$links['twitter']['icon']   = '<img src="/wp-content/uploads/2025/06/twitter.png" alt="Twitter">';
	$links['facebook']['icon']  = '<img src="/wp-content/uploads/2025/08/fb.png" alt="Facebook">';
	$links['youtube']['icon']     = '<img src="/wp-content/uploads/2025/08/youtube.png" alt="Email">';
	$links['pinterest']['icon'] = '<img src="/wp-content/uploads/2025/06/pinterest.png" alt="Pinterest">';
	$links['tiktok']['icon'] = '<img src="/wp-content/uploads/2025/08/tiktik.png" alt="Tiktok">';

	return $links;
}, 10, 2);


add_filter('flatsome_follow_links', function ($links, $args) {
	$links['facebook']['priority']  = 200;
	$links['tiktok']['priority']  = 202;
	$links['youtube']['priority'] = 203;
	return $links;
}, 10, 2);


function stock_status_ct($atts)
{
	ob_start();
	$status = '';
	$product_DI = get_the_ID();
	$pro = new WC_Product($product_DI);
	if ($pro->is_in_stock()) {
		$status = '<div class="btn-status"><i class="fa fa-solid fa-check"></i>' . __('In stock', 'woocommerce') . '</div>';
	} else {
		$status =  '<div class="btn-status" style="background: #f00; "><i class="fa fa-solid fa-xmark"></i>' . __('Out of stock', 'woocommerce') . '</div>';
	}
	echo '<div class="v-status"><span class="tr">' . __('Status', 'woocommerce') . ': </span>' . $status . '</div>';

	return ob_get_clean();
}
add_shortcode('stock_status_ct', 'stock_status_ct');