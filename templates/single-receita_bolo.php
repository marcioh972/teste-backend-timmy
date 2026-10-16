<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
rdb_header();
?>
<main class="rdb-wrap">
	<?php
	while ( have_posts() ) :
		the_post();
		$tempo        = rdb_format_prep_time( rdb_get_prep_time() );
		$ingredientes = rdb_get_ingredients();
		?>
		<article <?php post_class( 'rdb-single' ); ?>>
			<header class="rdb-single__header">
				<h1><?php the_title(); ?></h1>
				<?php if ( $tempo ) : ?>
					<p class="rdb-single__time">⏱ Tempo de preparo: <strong><?php echo esc_html( $tempo ); ?></strong></p>
				<?php endif; ?>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="rdb-single__image"><?php the_post_thumbnail( 'large' ); ?></div>
			<?php endif; ?>

			<section class="rdb-single__section">
				<h2>Descrição</h2>
				<div class="rdb-single__content"><?php the_content(); ?></div>
			</section>

			<?php if ( $ingredientes ) : ?>
				<section class="rdb-single__section">
					<h2>Ingredientes</h2>
					<ul class="rdb-ingredients">
						<?php foreach ( $ingredientes as $item ) : ?>
							<li><?php echo esc_html( $item ); ?></li>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endif; ?>
		</article>

		<?php
		$related = rdb_get_related( get_the_ID(), 3 );
		if ( $related->have_posts() ) :
			?>
			<aside class="rdb-related">
				<h2>Veja mais</h2>
				<div class="rdb-grid">
					<?php
					while ( $related->have_posts() ) :
						$related->the_post();
						?>
						<article class="rdb-card">
							<a class="rdb-card__image" href="<?php the_permalink(); ?>">
								<?php rdb_the_thumbnail(); ?>
							</a>
							<div class="rdb-card__body">
								<h3 class="rdb-card__title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
			</aside>
			<?php
			wp_reset_postdata();
		endif;
	endwhile;
	?>
</main>
<?php rdb_footer(); ?>
