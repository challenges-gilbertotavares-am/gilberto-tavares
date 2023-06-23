<?php
/**
 * Ajax functionality.
 *
 * @package Gilberto_Tavares
 */

namespace Gilberto_Tavares;

defined( 'ABSPATH' ) || exit;

/**
 * Class Ajax handles AJAX requests for retrieving data.
 */
class Ajax {

	/**
	 * Ajax constructor.
	 * Registers the AJAX action hooks.
	 */
	public function __construct() {
		add_action( 'wp_ajax_gilberto_tavares_get_data', array( $this, 'ajax_get_data' ) );
		add_action( 'wp_ajax_nopriv_gilberto_tavares_get_data', array( $this, 'ajax_get_data' ) );
	}

	/**
	 * Retrieves the data from the API or cache.
	 *
	 * @return mixed The retrieved data.
	 */
	public function get_data() {
		$cached_data = get_transient( 'gilberto_tavares_data' );

		if ( false === $cached_data ) {
			$response = wp_remote_get( 'https://miusage.com/v1/challenge/1/' );

			if ( is_wp_error( $response ) ) {
				wp_send_json_error( 'Error retrieving data.' );
			}

			$body = wp_remote_retrieve_body( $response );
			$data = json_decode( $body );

			if ( empty( $data ) ) {
				wp_send_json_error( 'Invalid data.' );
			}

			$cached_data = $data;
			set_transient( 'gilberto_tavares_data', $data, HOUR_IN_SECONDS );
		}

		return $cached_data;
	}

	/**
	 * Handles the AJAX request for retrieving data.
	 */
	public function ajax_get_data() {
		if ( ! check_ajax_referer( 'gilberto-tavares-nonce', 'security', false ) ) {
			wp_send_json_error( 'Invalid nonce.' );
		}

		$cached_data = $this->get_data();

		wp_send_json_success( $cached_data );
	}
}
