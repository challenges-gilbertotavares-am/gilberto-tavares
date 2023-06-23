<?php
/**
 * Plugin Name: Gilberto Tavares
 * Description: Awesome Motive Developer Applicant Challenge part 1
 * Requires at least: 6.1
 * Requires PHP: 7.4
 * Version: 1.0.0
 * Plugin URI: https://github.com/challenges-gilbertotavares-am/gilberto-tavares
 * Author: Gilberto Tavares
 * Author URI: https://github.com/camaleaun
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: gilberto-tavares
 * Domain Path: /languages
 *
 * @package Gilberto_Tavares
 */

if ( ! defined( 'GILBERTO_TAVARES_PLUGIN_FILE' ) ) {
	define( 'GILBERTO_TAVARES_PLUGIN_FILE', __FILE__ );
}

require __DIR__ . '/vendor/autoload.php';

/**
 * Returns an instance of the Gilberto Tavares main class.
 *
 * @return \Gilberto_Tavares\Main Instance of the Gilberto Tavares main class.
 */
function gilberto_tavares() {
	return Gilberto_Tavares\Main::instance();
}

gilberto_tavares();
