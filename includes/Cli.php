<?php
/**
 * CLI functionality.
 *
 * @package Gilberto_Tavares
 */

namespace Gilberto_Tavares;

defined( 'ABSPATH' ) || exit;

/**
 * Class Cli handles the WP-CLI commands for the plugin.
 */
class Cli {

	/**
	 * Cli constructor.
	 * Registers commands if WP-CLI is active.
	 */
	public function __construct() {
		if ( defined( 'WP_CLI' ) && \WP_CLI ) {
			\WP_CLI::add_hook( 'after_wp_load', array( $this, 'register_commands' ) );
		}
	}

	/**
	 * Flushes the transient data.
	 */
	public function flush_data() {
		delete_transient( 'gilberto_tavares_data' );
	}

	/**
	 * Registers WP-CLI commands.
	 */
	public function register_commands() {
		\WP_CLI::add_command( 'gilberto-tavares flush', array( $this, 'flush_command' ) );
	}

	/**
	 * Deletes transient data.
	 *
	 * ## EXAMPLES
	 *
	 *     $ wp gilberto-tavares flush
	 *     Success: The data was flushed.
	 *
	 * @param array $args        Positional arguments passed to the command.
	 * @param array $assoc_args  Associative arguments (options) passed to the command.
	 */
	public function flush_command( $args = array(), $assoc_args = array() ) {
		$this->flush_data();
		\WP_CLI::success( 'The data was flushed.' );
	}
}
