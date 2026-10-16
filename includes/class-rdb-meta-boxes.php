<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RDB_Meta_Boxes {

	const NONCE_ACTION = 'rdb_save_receita';
	const NONCE_NAME   = 'rdb_nonce';

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_meta' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'add' ) );
		add_action( 'save_post_' . RDB_POST_TYPE, array( __CLASS__, 'save' ) );
	}

	public static function register_meta() {
		register_post_meta( RDB_POST_TYPE, '_rdb_tempo_preparo', array(
			'type'              => 'integer',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'absint',
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		) );
		register_post_meta( RDB_POST_TYPE, '_rdb_ingredientes', array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_textarea_field',
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		) );
	}

	public static function add() {
		add_meta_box( 'rdb_detalhes', 'Detalhes da receita', array( __CLASS__, 'render' ), RDB_POST_TYPE, 'normal', 'high' );
	}

	public static function render( $post ) {
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME );
		$tempo        = rdb_get_prep_time( $post->ID );
		$ingredientes = get_post_meta( $post->ID, '_rdb_ingredientes', true );
		?>
		<p>
			<label for="rdb_tempo_preparo"><strong>Tempo de preparo (em minutos)</strong></label><br>
			<input type="number" min="0" step="1" id="rdb_tempo_preparo" name="rdb_tempo_preparo"
				value="<?php echo $tempo ? esc_attr( $tempo ) : ''; ?>" class="small-text" placeholder="60">
		</p>
		<p>
			<label for="rdb_ingredientes"><strong>Ingredientes</strong></label><br>
			<span class="description">Um ingrediente por linha.</span>
			<textarea id="rdb_ingredientes" name="rdb_ingredientes" rows="8" class="widefat"
				placeholder="3 ovos&#10;2 xícaras de farinha de trigo&#10;1 xícara de açúcar"><?php echo esc_textarea( $ingredientes ); ?></textarea>
		</p>
		<p class="description">A <strong>descrição</strong> é o editor principal acima e a <strong>imagem</strong> é definida em "Imagem da receita".</p>
		<?php
	}

	public static function save( $post_id ) {
		if ( ! isset( $_POST[ self::NONCE_NAME ] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ self::NONCE_NAME ] ) ), self::NONCE_ACTION ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$tempo = isset( $_POST['rdb_tempo_preparo'] ) ? absint( $_POST['rdb_tempo_preparo'] ) : 0;
		update_post_meta( $post_id, '_rdb_tempo_preparo', $tempo );

		$ingredientes = isset( $_POST['rdb_ingredientes'] )
			? sanitize_textarea_field( wp_unslash( $_POST['rdb_ingredientes'] ) )
			: '';
		update_post_meta( $post_id, '_rdb_ingredientes', $ingredientes );
	}
}
