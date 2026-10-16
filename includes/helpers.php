<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Tempo de preparo (em minutos) de uma receita.
 */
function rdb_get_prep_time( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	return (int) get_post_meta( $post_id, '_rdb_tempo_preparo', true );
}

/**
 * Tempo de preparo formatado: "45 min", "1h", "1h30".
 */
function rdb_format_prep_time( $minutes ) {
	$minutes = (int) $minutes;
	if ( $minutes <= 0 ) {
		return '';
	}
	if ( $minutes < 60 ) {
		return $minutes . ' min';
	}
	$h = intdiv( $minutes, 60 );
	$m = $minutes % 60;
	return $m ? sprintf( '%dh%02d', $h, $m ) : $h . 'h';
}

/**
 * Ingredientes como array (um por linha).
 */
function rdb_get_ingredients( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$raw     = (string) get_post_meta( $post_id, '_rdb_ingredientes', true );
	$lines   = preg_split( '/\r\n|\r|\n/', $raw );
	return array_values( array_filter( array_map( 'trim', $lines ), 'strlen' ) );
}

/**
 * Imagem da receita (ou placeholder).
 */
function rdb_the_thumbnail( $size = 'medium_large' ) {
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( $size, array( 'loading' => 'lazy' ) );
	} else {
		echo '<span class="rdb-placeholder" aria-hidden="true">🎂</span>';
	}
}

/**
 * Receitas sugeridas (aleatórias, exceto a atual).
 */
function rdb_get_related( $current_id, $limit = 3 ) {
	return new WP_Query( array(
		'post_type'           => RDB_POST_TYPE,
		'post_status'         => 'publish',
		'posts_per_page'      => $limit,
		'post__not_in'        => array( $current_id ),
		'orderby'             => 'rand',
		'no_found_rows'       => true,
		'ignore_sticky_posts' => true,
	) );
}

/**
 * Cabeçalho/rodapé compatíveis com temas clássicos e de blocos (FSE).
 */
function rdb_header() {
	if ( function_exists( 'wp_is_block_theme' ) && wp_is_block_theme() ) {
		?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="wp-site-blocks">
<?php
		echo do_blocks( '<!-- wp:template-part {"slug":"header","tagName":"header"} /-->' ); // phpcs:ignore
	} else {
		get_header();
	}
}

function rdb_footer() {
	if ( function_exists( 'wp_is_block_theme' ) && wp_is_block_theme() ) {
		echo do_blocks( '<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->' ); // phpcs:ignore
		echo '</div>';
		wp_footer();
		echo '</body></html>';
	} else {
		get_footer();
	}
}
