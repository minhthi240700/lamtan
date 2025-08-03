<?php

/**
 * Posts layout left sidebar.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

do_action('flatsome_before_blog');
?>

<?php if (!is_single() && get_theme_mod('blog_featured', '') == 'top') {
	get_template_part('template-parts/posts/featured-posts');
} ?>
<div class="row <?php if (get_theme_mod('blog_layout_divider', 1)) echo 'row-divided '; ?>">

	<div class="post-sidebar large-3 col">
		<?php flatsome_sticky_column_open('blog_sticky_sidebar'); ?>
		<?php get_sidebar(); ?>
		<?php flatsome_sticky_column_close('blog_sticky_sidebar'); ?>
	</div>

	<div class="large-9 col medium-col-first">
		<?php if (!is_single() && get_theme_mod('blog_featured', '') == 'content') {
			get_template_part('template-parts/posts/featured-posts');
		} ?>
		<?php
		if (is_single()) {
			get_template_part('template-parts/posts/single');
		} elseif (get_theme_mod('blog_style_archive', '') && (is_archive() || is_search())) {
			get_template_part('template-parts/posts/archive', get_theme_mod('blog_style_archive', ''));
		} else {
			get_template_part('template-parts/posts/archive', get_theme_mod('blog_style', 'normal'));
		}	?>
	</div>

</div>


<?php if (is_single()) : ?>
<?php
	$categories = get_the_category(get_the_ID());
	if ($categories) {
		$category_ids = wp_list_pluck($categories, 'term_id');

		$args = array(
			'category__in'   => $category_ids,
			'post__not_in'   => array(get_the_ID()),
			'posts_per_page' => 6,
			'fields'         => 'ids' // chỉ lấy ID
		);
		$related_ids = get_posts($args);
		if (!empty($related_ids)) {
			echo '<section>';
			echo '<div class="row">';
			echo '<div class="col large-12">';
			echo '<div class="block-related">';
			echo '<h2 class="section-title">Bài viết liên quan</h2>';

			echo flatsome_apply_shortcode('blog_posts', array(
				'type'                => 'slider',
				'depth'               => get_theme_mod('blog_posts_depth', 0),
				'depth_hover'         => get_theme_mod('blog_posts_depth_hover', 0),
				'text_align'          => get_theme_mod('blog_posts_title_align', 'center'),
				'columns'             => '3',
				'show_date'           => get_theme_mod('blog_badge', 1) ? 'true' : 'false',
				'ids'                 => implode(',', $related_ids),
				'excerpt_length' => 100,
				'readmore' => 'Xem thêm',
				'slider_nav_style'    => 'circle',
				'slider_nav_position' => 'outside',
			));

			echo '</div>'; // .block-related
			echo '</div>'; // .col.large-12
			echo '</div>'; // .row
			echo '</section>';
		}
	}
endif;
?>

<?php
do_action('flatsome_after_blog');
?>