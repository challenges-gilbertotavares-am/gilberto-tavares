/* global gilbertoTavaresParams */
/**
 * WordPress dependencies
 */
import { useEntityProp } from '@wordpress/core-data';
import { dateI18n, getSettings as getDateSettings } from '@wordpress/date';
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';

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
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               - Component props.
 * @param {Object}   props.attributes    - Block attributes.
 * @param {Function} props.setAttributes - Function to set block attributes.
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const { hiddenColumns } = attributes;
	const [ data, setData ] = useState( null );

	useEffect( () => {
		const fetchData = async () => {
			const { ajaxurl, nonce } = gilbertoTavaresParams;
			const response = await fetch(
				`${ ajaxurl }?action=gilberto_tavares_get_data&security=${ nonce }`
			);
			const responseData = await response.json();
			setData( responseData.data );
		};

		fetchData();
	}, [] );

	const handleToggleColumn = ( columnKey ) => {
		const updatedColumns = hiddenColumns.includes( columnKey )
			? hiddenColumns.filter( ( col ) => col !== columnKey )
			: [ ...hiddenColumns, columnKey ];

		setAttributes( { hiddenColumns: updatedColumns } );
	};

	const blockProps = useBlockProps();
	const [ siteDateFormat = getDateSettings().formats.date ] = useEntityProp(
		'root',
		'site',
		'date_format'
	);
	const [ siteTimeFormat = getDateSettings().formats.time ] = useEntityProp(
		'root',
		'site',
		'time_format'
	);

	const siteFormat = `${ siteDateFormat } ${ siteTimeFormat }`;

	if ( ! data ) {
		return (
			<div { ...blockProps }>
				<p>{ __( 'Loading…', 'gilberto-tavares' ) }</p>
			</div>
		);
	}

	if ( ! data.data || ! data.data.headers ) {
		return (
			<div { ...blockProps }>
				<p>{ __( 'Data not loaded.', 'gilberto-tavares' ) }</p>
			</div>
		);
	}

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

	return (
		<div { ...blockProps }>
			<InspectorControls group="settings">
				<PanelBody
					title={ __( 'Column Visibility', 'gilberto-tavares' ) }
				>
					{ headers.map( ( header ) => {
						const headerKey = Object.keys( header )[ 0 ];
						return (
							<ToggleControl
								key={ headerKey }
								label={ header[ headerKey ] }
								checked={
									! hiddenColumns.includes( headerKey )
								}
								onChange={ () =>
									handleToggleColumn( headerKey )
								}
							/>
						);
					} ) }
				</PanelBody>
			</InspectorControls>
			<table>
				<caption>{ data.title }</caption>
				<thead>
					<tr>
						{ headers
							.filter(
								( header ) =>
									! hiddenColumns.includes(
										Object.keys( header )[ 0 ]
									)
							)
							.map( ( header ) => {
								const headerKey = Object.keys( header )[ 0 ];
								return (
									<th key={ headerKey }>
										{ header[ headerKey ] }
									</th>
								);
							} ) }
					</tr>
				</thead>
				<tbody>
					{ Object.entries( rows ).map( ( [ rowKey, row ] ) => (
						<tr key={ rowKey }>
							{ headers
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
									if (
										Number.isInteger( column ) &&
										'date' === Object.keys( header )[ 0 ]
									) {
										column = formattedDate( column );
										column = (
											<time
												dateTime={ dateI18n(
													'c',
													column
												) }
											>
												{ dateI18n(
													siteFormat,
													column
												) }
											</time>
										);
									}
									return (
										<td key={ headerKey }>{ column }</td>
									);
								} ) }
						</tr>
					) ) }
				</tbody>
			</table>
		</div>
	);
}
