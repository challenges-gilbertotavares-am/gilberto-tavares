<?php
/**
 * Settings class for admin.
 *
 * @package Gilberto_Tavares\Admin
 */

namespace Gilberto_Tavares\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Class Settings handles the admin settings and page for the plugin.
 */
class Settings {

	/**
	 * Settings constructor.
	 * Initializes the class and adds the necessary action hooks.
	 */
	public function __construct() {
		add_action( 'load-toplevel_page_gilberto-tavares', array( $this, 'update' ) );

		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_filter( 'plugin_action_links', array( $this, 'settings_link' ), 10, 2 );
	}

	/**
	 * Updates the data when the update action is triggered.
	 */
	public function update() {
		if ( ! check_ajax_referer( 'gilberto-tavares-update', '_action_nonce', false ) ) {
			return;
		}

		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';

		$is_screen = 'toplevel_page_gilberto-tavares' === $screen_id;
		$action    = isset( $_REQUEST['action'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) : '';

		if ( ! $is_screen || 'update' !== $action ) {
			return;
		}

		\gilberto_tavares()->cli->flush_data();
	}

	/**
	 * Adds the admin menu page for the plugin.
	 */
	public function add_admin_menu() {
		$icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="currentColor">
			<path d="M19.832 36.352v-4.86q-.608 1.263-1.52 2.206-.91.928-2.028 1.534-1.118.608-2.396.912-1.263.304-2.574.304-2.365 0-4.362-.784-1.997-.798-3.626-2.525Q1.711 31.413.85 29.05 0 26.685 0 24.11q0-2.586.85-4.887.86-2.301 2.397-4.012 1.548-1.708 3.674-2.682 2.138-.977 4.633-.977 2.3 0 3.947.657 1.662.655 2.83 1.598 1.18.927 1.883 1.773h1.55v2.844H18.33q-1.072-1.821-2.844-2.875-1.758-1.057-3.948-1.023-1.837 0-3.37.783-1.536.78-2.639 2.108-1.084 1.327-1.692 3.053-.608 1.726-.608 3.64 0 2.127.67 3.948.672 1.822 1.71 2.956Q6.65 32.147 8.168 32.9q1.533.734 3.386.734 3.066 0 5.034-1.484 1.964-1.502 2.747-4.666h-6.774v-2.75h10.242v11.618z"/>
			<path d="M32.98 33.508h2.222V14.652h-5.53v3.772H26.4v-6.39H48v6.39h-3.275v-3.772h-6.39v18.856h2.492v2.746H32.98z"/>
		</svg>';

		add_menu_page(
			'Gilberto Tavares',
			'Gilberto Tavares',
			'manage_options',
			'gilberto-tavares',
			array( $this, 'admin_page' ),
			'data:image/svg+xml;base64,' . base64_encode( preg_replace( '/\s+/', ' ', $icon ) ), // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode
		);
	}

	/**
	 * Adds the settings link to the plugin's action links.
	 *
	 * @param array  $links The plugin's action links.
	 * @param string $file  The plugin file.
	 *
	 * @return array The updated action links.
	 */
	public function settings_link( $links, $file ) {
		if ( plugin_basename( GILBERTO_TAVARES_PLUGIN_FILE ) === $file ) {
			$settings_link = sprintf(
				'<a href="%s">%s</a>',
				esc_url( admin_url( 'admin.php?page=gilberto-tavares' ) ),
				__( 'Settings', 'gilberto-tavares' )
			);
			array_unshift( $links, $settings_link );
		}
		return $links;
	}

	/**
	 * Displays the admin page for the plugin.
	 */
	public function admin_page() {
		$cached_data = \gilberto_tavares()->ajax->get_data();

		$data_title = __( 'Data table', 'gilberto-tavares' );
		if ( isset( $cached_data->title ) ) {
			$data_title = $cached_data->title;
		}
		?>

		<div class="wrap" id="gilberto-tavares">
			<div class="gilberto-tavares-page-content">
				<div id="gilberto-tavares-header">
					<h1>Gilberto Tavares</h1>
				</div>

				<form method="POST" action="">
					<?php wp_nonce_field( 'gilberto-tavares-update', '_action_nonce' ); ?>
					<input type="hidden" name="action" value="update">

					<!-- Data Section Title -->
					<div class="gilberto-tavares-setting-row gilberto-tavares-setting-row-content gilberto-tavares-clear section-heading" id="gilberto-tavares-setting-row-license-heading">
						<div class="gilberto-tavares-setting-field">
							<h2><?php esc_html_e( 'Data', 'gilberto-tavares' ); ?></h2>

							<p class="desc">
								<?php esc_html_e( 'Cached data retrieved from external API.', 'gilberto-tavares' ); ?>
							</p>
						</div>
					</div>

					<!-- Data Table -->
					<div id="gilberto-tavares-setting-row-license_key" class="gilberto-tavares-setting-row gilberto-tavares-setting-row-license_key gilberto-tavares-clear">
						<div class="gilberto-tavares-setting-label">
							<label for="gilberto-tavares-setting-license_key"><?php echo esc_html( $data_title ); ?></label>
						</div>
						<div class="gilberto-tavares-setting-field">

							<?php
							$table = new List_Table( $cached_data );
							$table->prepare_items();
							$table->display();
							?>

						</div>
					</div>

					<!-- Update Section Title -->
					<div class="gilberto-tavares-setting-row gilberto-tavares-setting-row-content gilberto-tavares-clear section-heading no-desc" id="gilberto-tavares-setting-row-email-heading">
						<div class="gilberto-tavares-setting-field">
							<h2><?php echo esc_html_e( 'Update Data', 'gilberto-tavares' ); ?></h2>
						</div>
					</div>

					<!-- Update button -->
					<div id="gilberto-tavares-setting-row-setup-wizard-button" class="gilberto-tavares-setting-row gilberto-tavares-setting-row-email gilberto-tavares-clear">
						<div class="gilberto-tavares-setting-label">
							<label for="gilberto-tavares-setting-from_email">
								<?php echo esc_html_e( 'Force Update', 'gilberto-tavares' ); ?>
							</label>
						</div>
						<div class="gilberto-tavares-setting-field">
							<button class="button button-md button-primary">
								<?php echo esc_html_e( 'Force Update Data', 'gilberto-tavares' ); ?>
							</button>
							<p class="desc">

								<?php
								echo esc_html_e(
									'Transient cached data will be deleted and updated data will be retrieved from the API.',
									'gilberto-tavares'
								);
								?>

							</p>
						</div>
					</div>
				</form>
			</div>
		</div>

		<?php
	}
}
