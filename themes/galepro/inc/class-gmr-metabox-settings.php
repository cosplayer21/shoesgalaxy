<?php
/**
 * Add Simple Metaboxes Settings
 *
 * @package Galepro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register a meta box using a class.
 *
 * @since 1.0.0
 */
class GMR_Metabox_Settings {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Adds the meta box.
	 *
	 * @param string $post_type Post type.
	 */
	public function add_meta_box( $post_type ) {
		$post_types = array( 'post', 'page' );
		if ( in_array( $post_type, $post_types, true ) ) {
			add_meta_box(
				'gmr_header_metabox',
				__( 'Theme Settings', 'galepro' ),
				array( $this, 'render_meta_box_content' ),
				$post_type,
				'side',
				'low'
			);
		}
	}

	/**
	 * Save the meta box.
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return int $post_id
	 */
	public function save( $post_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST['gmr_header_box_nonce'] ) ) {
			return $post_id;
		}

		$nonce = sanitize_text_field( wp_unslash( $_POST['gmr_header_box_nonce'] ) );

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'gmr_header_box' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'page' === $_POST['post_type'] ) { // phpcs:ignore
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		// Sanitize the user input using boolean.
		$mydata_sidebar = isset( $_POST['gmr_sidebar_field'] ) ? (bool) $_POST['gmr_sidebar_field'] : false;

		// Update the meta field.
		update_post_meta( $post_id, '_gmr_sidebar_key', $mydata_sidebar );
	}

	/**
	 * Renders the meta box.
	 *
	 * @param string $post Post Object.
	 *
	 * @return void
	 */
	public function render_meta_box_content( $post ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'gmr_header_box', 'gmr_header_box_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$value_sidebar = get_post_meta( $post->ID, '_gmr_sidebar_key', true );
		?>
		<p>
			<input type="checkbox" class="checkbox" id="gmr_sidebar_field" name="gmr_sidebar_field" <?php checked( $value_sidebar ); ?> />
			<label for="gmr_sidebar_field"><?php esc_html_e( 'Disable the sidebar for this page?', 'galepro' ); ?></label>
		</p>
		<p><?php esc_html_e( 'Page template builder is fullwidth so you no need check disable sidebar.', 'galepro' ); ?></p>
		<?php
	}
}


/**
 * Load class GMR_Metabox_Settings
 */
function gmr_metaboxes_settings_init() {
	new GMR_Metabox_Settings();
}

// Load only if dashboard.
if ( is_admin() ) {
	add_action( 'load-post.php', 'gmr_metaboxes_settings_init' );
	add_action( 'load-post-new.php', 'gmr_metaboxes_settings_init' );
}
