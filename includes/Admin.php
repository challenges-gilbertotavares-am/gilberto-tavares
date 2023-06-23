<?php
/**
 * Admin functionality.
 *
 * @package Gilberto_Tavares
 */

namespace Gilberto_Tavares;

defined( 'ABSPATH' ) || exit;

/**
 * Class Admin handles the administration-related functionality of the plugin.
 */
class Admin {
	/**
	 * Handles the assets (styles and scripts) for the admin area.
	 *
	 * @var Admin\Assets
	 */
	public $assets;

	/**
	 * Handles the plugin settings in the admin area.
	 *
	 * @var Admin\Settings
	 */
	public $settings;

	/**
	 * Admin constructor.
	 * Initializes the assets and settings objects.
	 */
	public function __construct() {
		$this->assets   = new Admin\Assets();
		$this->settings = new Admin\Settings();
	}
}
