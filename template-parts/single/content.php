<?php
/**
 * Single: Featured image + content.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$thumb = get_the_post_thumbnail_url( get_the_ID(), 'large' );
?>
<section class="single-section single-body" id="single-body">
	<div class="single-section__inner single-body__inner">
		<?php if ( $thumb ) : ?>
			<figure class="single-body__media">
				<img
					src="<?php echo esc_url( $thumb ); ?>"
					alt="<?php echo esc_attr( get_the_title() ); ?>"
					loading="eager"
					decoding="async"
				/>
			</figure>
		<?php endif; ?>

		<article <?php post_class( 'single-article' ); ?>>
			<div class="single-article__content entry-content">
				<?php the_content(); ?>
			</div>

			<?php
			$tags = get_the_tags();
			if ( $tags ) :
				?>
				<ul class="single-article__tags">
					<?php foreach ( $tags as $tag ) : ?>
						<li>
							<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>">
								<?php echo esc_html( $tag->name ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<nav class="single-nav" aria-label="<?php esc_attr_e( 'Bài viết liền kề', 'oceanwp-child' ); ?>">
				<?php
				$prev = get_previous_post();
				$next = get_next_post();
				?>
				<?php if ( $prev ) : ?>
					<a class="single-nav__link single-nav__link--prev" href="<?php echo esc_url( get_permalink( $prev ) ); ?>">
						<span class="single-nav__label">← Bài trước</span>
						<span class="single-nav__title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
					</a>
				<?php else : ?>
					<span class="single-nav__link single-nav__link--empty"></span>
				<?php endif; ?>

				<?php if ( $next ) : ?>
					<a class="single-nav__link single-nav__link--next" href="<?php echo esc_url( get_permalink( $next ) ); ?>">
						<span class="single-nav__label">Bài sau →</span>
						<span class="single-nav__title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
					</a>
				<?php endif; ?>
			</nav>
		</article>
	</div>
</section>
