<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Carrega os templates do plugin. O tema pode sobrescrevê-los criando
 * archive-receita_bolo.php / single-receita_bolo.php na raiz do tema.
 */
class RDB_Templates {

	public static function init() {
		add_filter( 'template_include', array( __CLASS__, 'template_include' ), 99 );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'assets' ) );
	}

	public static function template_include( $template ) {
		if ( is_post_type_archive( RDB_POST_TYPE ) ) {
			return self::locate( 'archive-receita_bolo.php', $template );
		}
		if ( is_singular( RDB_POST_TYPE ) ) {
			return self::locate( 'single-receita_bolo.php', $template );
		}
		return $template;
	}

	private static function locate( $file, $fallback ) {
		$theme = locate_template( array( $file ) );
		if ( $theme ) {
			return $theme;
		}
		$plugin = RDB_PATH . 'templates/' . $file;
		return file_exists( $plugin ) ? $plugin : $fallback;
	}

	public static function assets() {
		if ( is_post_type_archive( RDB_POST_TYPE ) || is_singular( RDB_POST_TYPE ) ) {
			wp_enqueue_style( 'rdb-style', RDB_URL . 'assets/css/style.css', array(), RDB_VERSION );
		}
	}
}
