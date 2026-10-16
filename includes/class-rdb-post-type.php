<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RDB_Post_Type {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'archive_query' ) );
	}

	public static function register() {
		$labels = array(
			'name'               => 'Receitas de Bolos',
			'singular_name'      => 'Receita de Bolo',
			'menu_name'          => 'Receitas de Bolos',
			'add_new'            => 'Adicionar nova',
			'add_new_item'       => 'Adicionar nova receita',
			'edit_item'          => 'Editar receita',
			'new_item'           => 'Nova receita',
			'view_item'          => 'Ver receita',
			'search_items'       => 'Buscar receitas',
			'not_found'          => 'Nenhuma receita encontrada',
			'not_found_in_trash' => 'Nenhuma receita na lixeira',
			'all_items'          => 'Todas as receitas',
			'featured_image'     => 'Imagem da receita',
			'set_featured_image' => 'Definir imagem da receita',
		);

		register_post_type( RDB_POST_TYPE, array(
			'labels'        => $labels,
			'public'        => true,
			'has_archive'   => 'receitas-de-bolos',
			'rewrite'       => array( 'slug' => 'receitas-de-bolos', 'with_front' => false ),
			'menu_icon'     => 'dashicons-carrot',
			'menu_position' => 5,
			'show_in_rest'  => true,
			// "editor" = descrição da receita; "thumbnail" = imagem.
			'supports'      => array( 'title', 'editor', 'thumbnail' ),
		) );
	}

	/**
	 * 9 receitas por página no archive (grid 3x3).
	 */
	public static function archive_query( $query ) {
		if ( ! is_admin() && $query->is_main_query() && $query->is_post_type_archive( RDB_POST_TYPE ) ) {
			$query->set( 'posts_per_page', 9 );
		}
	}
}
