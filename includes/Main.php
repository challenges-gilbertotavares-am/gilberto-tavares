<?php
/**
 * Main class.
 *
 * @package Gilberto_Tavares
 */

namespace Gilberto_Tavares;

defined( 'ABSPATH' ) || exit;

/**
 * Main class responsible for initializing the plugin.
 */
final class Main {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * The instance of the Main class.
	 *
	 * @var Main|null
	 */
	protected static $instance = null;

	/**
	 * The Ajax object.
	 *
	 * @var Ajax
	 */
	public $ajax;

	/**
	 * The Block object.
	 *
	 * @var Block
	 */
	public $block;

	/**
	 * The CLI object.
	 *
	 * @var Cli
	 */
	public $cli;

	/**
	 * The Admin object.
	 *
	 * @var Admin
	 */
	public $admin;

	/**
	 * Get the instance of the Main class.
	 *
	 * @return Main The Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Main constructor.
	 */
	public function __construct() {
		$this->ajax  = new Ajax();
		$this->block = new Block();
		$this->cli   = new Cli();
		$this->admin = new Admin();
	}

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', GILBERTO_TAVARES_PLUGIN_FILE ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( GILBERTO_TAVARES_PLUGIN_FILE ) );
	}

	/**
	 * Get Ajax URL.
	 *
	 * @return string
	 */
	public function ajax_url() {
		return admin_url( 'admin-ajax.php', 'relative' );
	}
}
