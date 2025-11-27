<?php
/**
 * Server-side rendering of the Reading List block.
 *
 * @package ReadingList
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get block attributes with defaults.
$limit   = isset( $attributes['limit'] ) ? intval( $attributes['limit'] ) : -1;
$orderby = isset( $attributes['orderby'] ) ? sanitize_text_field( $attributes['orderby'] ) : 'date_read';
$order   = isset( $attributes['order'] ) ? sanitize_text_field( $attributes['order'] ) : 'DESC';

// Use the existing shortcode function to render the content.
$content = reading_list_shortcode(
	array(
		'limit'   => $limit,
		'orderby' => $orderby,
		'order'   => $order,
	)
);

// Get wrapper attributes for block support.
$wrapper_attributes = get_block_wrapper_attributes();

// Output the block content.
printf(
	'<div %1$s>%2$s</div>',
	$wrapper_attributes,
	$content
);
