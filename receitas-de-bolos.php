<?php
/**
 * Plugin Name:       Receitas de Bolos
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Márcio
 * License:           GPL-2.0-or-later
 * Text Domain:       receitas-de-bolos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RDB_VERSION', '1.0.0' );
define( 'RDB_PATH', plugin_dir_path( __FILE__ ) );
define( 'RDB_URL', plugin_dir_url( __FILE__ ) );
define( 'RDB_POST_TYPE', 'receita_bolo' );

require_once RDB_PATH . 'includes/helpers.php';
require_once RDB_PATH . 'includes/class-rdb-post-type.php';
require_once RDB_PATH . 'includes/class-rdb-meta-boxes.php';
require_once RDB_PATH . 'includes/class-rdb-templates.php';

add_action( 'plugins_loaded', function () {
	RDB_Post_Type::init();
	RDB_Meta_Boxes::init();
	RDB_Templates::init();
} );

register_activation_hook( __FILE__, function () {
	RDB_Post_Type::register();
	flush_rewrite_rules();
} );

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
