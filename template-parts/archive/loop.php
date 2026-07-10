<?php
/**
 * Archive: Post grid loop.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="archive-section archive-loop" id="archive-loop">
	<div class="archive-section__inner">
		<?php if ( have_posts() ) : ?>
			<ul class="archive-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/archive/card' );
				endwhile;
				?>
			</ul>

			<?php
			$pagination = paginate_links(
				array(
					'type'      => 'array',
					'prev_text' => '‹',
					'next_text' => '›',
				)
			);
			?>
			<?php if ( ! empty( $pagination ) && is_array( $pagination ) ) : ?>
				<nav class="archive-pagination" aria-label="<?php esc_attr_e( 'Phân trang', 'oceanwp-child' ); ?>">
					<ul class="archive-pagination__list">
						<?php foreach ( $pagination as $link ) : ?>
							<li class="archive-pagination__item"><?php echo wp_kses_post( $link ); ?></li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endif; ?>
		<?php else : ?>
			<div class="archive-empty">
				<p class="archive-empty__text">Chưa có bài viết trong mục này.</p>
				<a class="btn archive-empty__btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">Về trang chủ</a>
			</div>
		<?php endif; ?>
	</div>
</section>
