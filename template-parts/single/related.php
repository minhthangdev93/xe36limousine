<?php
/**
 * Single: Related posts.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$related = xe36_single_related_posts( 3 );
if ( empty( $related ) ) {
	return;
}

$cats = get_the_category();
$cat  = ! empty( $cats ) ? $cats[0] : null;
?>
<section class="single-section single-related" id="single-related">
	<div class="single-section__inner">
		<header class="single-related__header">
			<p class="single-related__eyebrow">Gợi ý</p>
			<h2 class="single-related__title">Bài viết liên quan</h2>
			<?php if ( $cat ) : ?>
				<a class="single-related__all" href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
					Xem tất cả <?php echo esc_html( $cat->name ); ?>
				</a>
			<?php endif; ?>
		</header>

		<ul class="archive-grid">
			<?php
			global $post;
			foreach ( $related as $post ) :
				setup_postdata( $post );
				get_template_part( 'template-parts/archive/card' );
			endforeach;
			wp_reset_postdata();
			?>
		</ul>
	</div>
</section>
