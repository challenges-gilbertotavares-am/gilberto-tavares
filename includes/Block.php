<?php
/**
 * Block functionality.
 *
 * @package Gilberto_Tavares
 */

namespace Gilberto_Tavares;

defined( 'ABSPATH' ) || exit;

/**
 * Class Block handles the custom block registration and rendering.
 */
class Block {

	/**
	 * Block constructor.
	 * Registers the block on the 'init' action.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_block' ) );
	}

	/**
	 * Registers the custom block.
	 */
	public function register_block() {
		register_block_type(
			gilberto_tavares()->plugin_path() . '/build',
			array(
				'render_callback' => array( $this, 'render_block' ),
			)
		);

		$params = array(
			'ajaxurl' => gilberto_tavares()->ajax_url(),
			'nonce'   => wp_create_nonce( 'gilberto-tavares-nonce' ),
		);

		$params_view = array(
			'siteDateFormat' => get_option( 'date_format' ),
			'siteTimeFormat' => get_option( 'time_format' ),
		);
		foreach ( array( 'editor', 'view' ) as $type ) {
			if ( 'view' === $type ) {
				$params = array_merge( $params, $params_view );
			}
			wp_localize_script(
				"gilberto-tavares-json-table-$type-script",
				'gilbertoTavaresParams',
				$params
			);
		}
	}

	/**
	 * Renders the custom block.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The rendered block content.
	 */
	public function render_block( $attributes ) {
		$hidden_columns = array();
		if ( isset( $attributes['hiddenColumns'] ) ) {
			$hidden_columns = $attributes['hiddenColumns'];
		}

		$hidden_columns = implode( ',', $hidden_columns );
		ob_start();
		?>

		<div class="wp-block-gilberto-tavares-json-table" data-hidden_columns="<?php echo esc_attr( $hidden_columns ); ?>">
			<p><?php echo esc_html_e( 'Loading...', 'gilberto-tavares' ); ?></p>
		</div>

		<?php
		return ob_get_clean();
	}
}
