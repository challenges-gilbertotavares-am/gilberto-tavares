<?php
/**
 * List_Table class.
 *
 * @package Gilberto_Tavares\Admin
 */

namespace Gilberto_Tavares\Admin;

/**
 * Class List_Table extends WP_List_Table to display a table of data.
 */
class List_Table extends \WP_List_Table {

	/**
	 * Cached data used to populate the table.
	 *
	 * @var mixed
	 */
	private $cached_data;

	/**
	 * List_Table constructor.
	 *
	 * @param mixed $cached_data The cached data to display in the table.
	 */
	public function __construct( $cached_data ) {
		$this->cached_data = $cached_data;
		parent::__construct();
	}

	/**
	 * Get the columns for the table.
	 *
	 * @return array The table columns.
	 */
	public function get_columns() {
		$headers = array();

		if ( isset( $this->cached_data->data ) ) {
			$headers = $this->cached_data->data->headers;

			$first_row = current( $this->cached_data->data->rows );

			$headers = array_combine(
				array_keys( (array) $first_row ),
				$headers
			);
		}

		return $headers;
	}

	/**
	 * Prepare the table items.
	 */
	public function prepare_items() {
		$columns = $this->get_columns();

		if ( isset( $this->cached_data->data ) ) {
			$data = $this->cached_data->data->rows;

			$this->_column_headers = array( $columns, array(), array() );

			$this->items = array();
			foreach ( $data as $row ) {
				$item = array();
				foreach ( $columns as $column => $header ) {
					$item[ $column ] = $row->$column;
					// Note: Assuming the properties of the $row object correspond to the column names.
				}
				$this->items[] = $item;
			}
		}
	}

	/**
	 * Render the default column value.
	 *
	 * @param array  $item         The item being rendered.
	 * @param string $column_name  The name of the column being rendered.
	 *
	 * @return mixed The rendered column value.
	 */
	public function column_default( $item, $column_name ) {
		$column = $item[ $column_name ];
		if ( is_integer( $column ) && 'date' === $column_name ) {
			$date_format = get_option( 'date_format' );
			$time_format = get_option( 'time_format' );
			$site_format = "$date_format $time_format";

			$column = wp_date( $site_format, $column );
			// Note: Assuming the 'date' column contains a Unix timestamp.
		}
		return $column;
	}
}
