<?php
/**
 * Assets class for admin.
 *
 * @package Gilberto_Tavares\Admin
 */

namespace Gilberto_Tavares\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Class Assets handles the assets (styles and scripts) for the admin area.
 */
class Assets {

	/**
	 * Assets constructor.
	 * Initializes the class and adds the necessary action hooks.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueues the necessary scripts and styles for the admin area.
	 */
	public function enqueue_scripts() {
		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';

		// Enqueue styles only on the plugin's top-level page.
		if ( 'toplevel_page_gilberto-tavares' === $screen_id ) {
			wp_enqueue_style(
				'gilberto-tavares-admin',
				gilberto_tavares()->plugin_url() . '/css/gilberto-tavares-admin.css',
				array(),
				filemtime( gilberto_tavares()->plugin_path() . '/css/gilberto-tavares-admin.css' )
			);
		}
	}
}
