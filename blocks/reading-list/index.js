/**
 * Reading List Block
 *
 * A block to display the reading list of books.
 */

( function ( blocks, element, blockEditor, components, serverSideRender, i18n ) {
	const { registerBlockType } = blocks;
	const { createElement: el, Fragment } = element;
	const { InspectorControls, useBlockProps } = blockEditor;
	const { PanelBody, SelectControl, RangeControl } = components;
	const { __ } = i18n;
	const ServerSideRender = serverSideRender;

	registerBlockType( 'reading-list/reading-list', {
		edit: function ( props ) {
			const { attributes, setAttributes } = props;
			const { limit, orderby, order } = attributes;
			const blockProps = useBlockProps();

			return el(
				Fragment,
				{},
				el(
					InspectorControls,
					{},
					el(
						PanelBody,
						{
							title: __( 'Reading List Settings', 'reading-list' ),
							initialOpen: true,
						},
						el( RangeControl, {
							label: __( 'Number of books', 'reading-list' ),
							value: limit === -1 ? 0 : limit,
							onChange: function ( value ) {
								setAttributes( { limit: value === 0 ? -1 : value } );
							},
							min: 0,
							max: 50,
							help: __( 'Set to 0 to show all books.', 'reading-list' ),
						} ),
						el( SelectControl, {
							label: __( 'Order by', 'reading-list' ),
							value: orderby,
							options: [
								{
									label: __( 'Date Read', 'reading-list' ),
									value: 'date_read',
								},
								{
									label: __( 'Title', 'reading-list' ),
									value: 'title',
								},
								{
									label: __( 'Rating', 'reading-list' ),
									value: 'rating',
								},
							],
							onChange: function ( value ) {
								setAttributes( { orderby: value } );
							},
						} ),
						el( SelectControl, {
							label: __( 'Order', 'reading-list' ),
							value: order,
							options: [
								{
									label: __( 'Descending', 'reading-list' ),
									value: 'DESC',
								},
								{
									label: __( 'Ascending', 'reading-list' ),
									value: 'ASC',
								},
							],
							onChange: function ( value ) {
								setAttributes( { order: value } );
							},
						} )
					)
				),
				el(
					'div',
					blockProps,
					el( ServerSideRender, {
						block: 'reading-list/reading-list',
						attributes: attributes,
					} )
				)
			);
		},
		save: function () {
			// Server-side rendered block.
			return null;
		},
	} );
} )(
	window.wp.blocks,
	window.wp.element,
	window.wp.blockEditor,
	window.wp.components,
	window.wp.serverSideRender,
	window.wp.i18n
);
