# Reading List

A WordPress plugin to manage a list of books you've read on your WordPress site.

## Features

- **Custom Post Type**: Books are stored as a custom post type with full WordPress integration.
- **Book Details**: Track author, ISBN, date read, and rating (1-5 stars) for each book.
- **Book Cover**: Use WordPress featured images to display book covers.
- **Notes**: Add personal notes or reviews using the standard WordPress editor.
- **Admin List View**: Custom columns in the admin showing author, date read, and rating.
- **Sortable Columns**: Sort your book list by author, date read, or rating.
- **Gutenberg Block**: Add a Reading List block to display your books in the block editor.
- **Frontend Shortcode**: Display your reading list on any page or post.
- **Responsive Design**: Mobile-friendly display with clean, modern styling.

## Installation

1. Download or clone this repository.
2. Upload the `reading-list` folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

### Adding Books

1. In WordPress admin, go to **Reading List > Add New**.
2. Enter the book title in the title field.
3. Add any notes or reviews in the content editor.
4. Fill in the book details: Author, ISBN, Date Read, and Rating.
5. Optionally add a book cover using the Featured Image.
6. Click **Publish** to save the book.

### Displaying Your Reading List

You can display your reading list using either the Gutenberg block or the classic shortcode.

#### Using the Block (Recommended)

1. Edit any page or post using the block editor.
2. Click the **+** button to add a new block.
3. Search for "Reading List" and select the block.
4. Use the block settings in the sidebar to configure:
   - **Number of books**: How many books to display (0 for all)
   - **Order by**: Sort by date read, title, or rating
   - **Order**: Ascending or descending

#### Using the Shortcode

Use the `[reading_list]` shortcode on any page or post to display your reading list.

#### Shortcode Attributes

- `limit`: Number of books to display (default: all books, use `-1` for all)
- `orderby`: Sort by `date_read`, `title`, or `rating` (default: `date_read`)
- `order`: Sort order `ASC` or `DESC` (default: `DESC`)

#### Examples

```
[reading_list]
[reading_list limit="5"]
[reading_list orderby="rating" order="DESC"]
[reading_list limit="10" orderby="title" order="ASC"]
```

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher

## License

GPL-2.0+ - http://www.gnu.org/licenses/gpl-2.0.txt
