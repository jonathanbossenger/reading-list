# Copilot Instructions for Reading List WordPress Plugin

## Project Overview

This is a WordPress plugin called "Reading List" that allows users to manage a list of books they've read on their WordPress site.

## Technology Stack

- **Language**: PHP 7.0+
- **Platform**: WordPress 5.0+
- **License**: GPL-2.0+

## Code Structure

- `reading-list.php` - Main plugin file containing all plugin logic
- `assets/css/reading-list.css` - Frontend styles for the shortcode display

## Key Components

### Custom Post Type
- Post type slug: `reading_list_book`
- Supports: title, editor (for notes), thumbnail (for book covers)

### Meta Fields
All book metadata is stored as post meta with the following keys:
- `_reading_list_author` - Book author name
- `_reading_list_isbn` - Book ISBN
- `_reading_list_date_read` - Date the book was read
- `_reading_list_rating` - Rating from 1-5

### Shortcode
- `[reading_list]` - Displays the reading list on the frontend
- Attributes: `limit`, `orderby`, `order`

## WordPress Coding Standards

When contributing to this plugin, follow the [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/):

- Use tabs for indentation, not spaces
- Use single quotes for strings unless you need to include variables
- Add docblocks for all functions
- Prefix all function names with `reading_list_`
- Prefix all meta keys with `_reading_list_`
- Use WordPress escaping functions (`esc_html`, `esc_attr`, `wp_kses_post`, etc.)
- Use WordPress sanitization functions when saving data
- Always verify nonces for form submissions
- Check user capabilities before performing actions

## Security Practices

- Always sanitize input data using appropriate WordPress functions
- Always escape output using appropriate WordPress functions
- Verify nonces for all form submissions
- Check user capabilities before performing privileged actions
- Use prepared statements for any direct database queries

## Internationalization

- Text domain: `reading-list`
- All user-facing strings should be translatable using `__()`, `_e()`, `_x()`, etc.
