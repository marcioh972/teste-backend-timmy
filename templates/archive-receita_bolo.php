<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
rdb_header();
?>
<main class="rdb-wrap">
	<header class="rdb-archive-header">
		<h1><?php post_type_archive_title(); ?></h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="rdb-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				$tempo = rdb_format_prep_time( rdb_get_prep_time() );
				?>
				<article class="rdb-card">
					<a class="rdb-card__image" href="<?php the_permalink(); ?>">
						<?php rdb_the_thumbnail(); ?>
					</a>
					<div class="rdb-card__body">
						<h2 class="rdb-card__title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<?php if ( $tempo ) : ?>
							<p class="rdb-card__time">⏱ <?php echo esc_html( $tempo ); ?></p>
						<?php endif; ?>
					</div>
				</article>
			<?php endwhile; ?>
		</div>

		<?php
		the_posts_pagination( array(
			'mid_size'  => 1,
			'prev_text' => '&larr; Anterior',
			'next_text' => 'Próxima &rarr;',
		) );
		?>
	<?php else : ?>
		<p class="rdb-empty">Nenhuma receita cadastrada ainda.</p>
	<?php endif; ?>
</main>
<?php rdb_footer(); ?>
