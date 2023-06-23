/* global gilbertoTavaresParams */
/**
 * Function to format a timestamp into a formatted date string.
 *
 * @param {number} timestamp - The timestamp to format.
 * @return {string} The formatted date string.
 */
const formattedDate = ( timestamp ) => {
	const date = new Date( timestamp * 1000 ); // Multiply by 1000 to convert from seconds to milliseconds
	const year = date.getFullYear();

	let day = date.getDate();
	let month = date.getMonth() + 1;
	let hour = date.getHours();
	let minute = date.getMinutes();
	let second = date.getSeconds(); // Months in JavaScript are zero-based, so we add 1

	if ( day <= 9 ) {
		day = `0${ day }`;
	}

	if ( month <= 9 ) {
		month = `0${ month }`;
	}

	if ( hour <= 9 ) {
		hour = `0${ hour }`;
	}

	if ( minute <= 9 ) {
		minute = `0${ minute }`;
	}

	if ( second <= 9 ) {
		second = `0${ second }`;
	}

	return `${ year }-${ month }-${ day } ${ hour }:${ minute }:${ second }`;
};

/**
 * WordPress dependencies
 */
import { dateI18n } from '@wordpress/date';

document.addEventListener( 'DOMContentLoaded', () => {
	const { ajaxurl, nonce, siteDateFormat, siteTimeFormat } =
		gilbertoTavaresParams;
	const siteFormat = `${ siteDateFormat } ${ siteTimeFormat }`;
	// Make an AJAX request to retrieve data and populate the table.
	fetch( `${ ajaxurl }?action=gilberto_tavares_get_data&security=${ nonce }` )
		.then( ( response ) => response.json() )
		.then( ( response ) => {
			if ( response.success ) {
				const data = response.data;

				const blocks = document.querySelectorAll(
					'.wp-block-gilberto-tavares-json-table'
				);

				if ( ! data.data || ! data.data.headers ) {
					blocks.forEach( ( element ) => {
						element.querySelector( 'p' ).innerText = 'Not loaded';
					} );
				} else {
					const rows = data.data.rows;

					const headers = Object.entries(
						Object.fromEntries(
							Object.keys( Object.values( rows )[ 0 ] ).map(
								( headerKey, index ) => [
									headerKey,
									data.data.headers[ index ],
								]
							)
						)
					).map( ( [ headerKey, headerValue ] ) => ( {
						[ headerKey ]: headerValue,
					} ) );

					/**
					 * Function to render the table with the given hidden columns.
					 *
					 * @param {Array} hiddenColumns - An array of hidden column keys.
					 * @return {HTMLElement} The rendered table element.
					 */
					const renderTable = ( hiddenColumns ) => {
						const table = document.createElement( 'table' );

						const caption = document.createElement( 'caption' );
						caption.innerText = data.title;

						const thead = document.createElement( 'thead' );
						const headerRow = document.createElement( 'tr' );

						headers
							.filter(
								( header ) =>
									! hiddenColumns.includes(
										Object.keys( header )[ 0 ]
									)
							)
							.map( ( header ) => {
								const headerKey = Object.keys( header )[ 0 ];
								const headerCol =
									document.createElement( 'th' );
								headerCol.innerText = header[ headerKey ];
								headerRow.appendChild( headerCol );
								return header;
							} );

						thead.appendChild( headerRow );

						const tbody = document.createElement( 'tbody' );
						Object.entries( data.data.rows ).map(
							( [ rowKey, row ] ) => {
								const bodyRow = document.createElement( 'tr' );
								headers
									.filter(
										( header ) =>
											! hiddenColumns.includes(
												Object.keys( header )[ 0 ]
											)
									)
									.map( ( header ) => {
										const headerKey =
											Object.keys( header )[ 0 ];
										let column = row[ headerKey ];
										const bodyCol =
											document.createElement( 'td' );
										if (
											Number.isInteger( column ) &&
											'date' ===
												Object.keys( header )[ 0 ]
										) {
											column = formattedDate( column );
											const time =
												document.createElement(
													'time'
												);
											time.setAttribute(
												'datetime',
												dateI18n( 'c', column )
											);
											time.innerText = dateI18n(
												siteFormat,
												column
											);
											bodyCol.appendChild( time );
										} else {
											bodyCol.innerText = column;
										}
										bodyRow.appendChild( bodyCol );
										return header;
									} );
								tbody.appendChild( bodyRow );
								return rowKey;
							}
						);

						table.appendChild( caption );
						table.appendChild( thead );
						table.appendChild( tbody );
						return table;
					};

					blocks.forEach( ( element ) => {
						const hiddenColumns =
							element.dataset.hidden_columns.split( ',' );
						element.innerHTML = '';
						element.appendChild( renderTable( hiddenColumns ) );
					} );
				}
			}
		} );
} );
