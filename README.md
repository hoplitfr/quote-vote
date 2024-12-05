# Quote Vote

A plugin to submit, approve, and vote on quotes.

## Description

The Quote Vote plugin allows users to submit quotes, which can then be approved or rejected by administrators. Users can also vote on the quotes.

## Installation

1. Upload the `quote-vote` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

## Features

- **Custom Post Type**: Registers a custom post type for quotes.
- **Shortcodes**: Provides shortcodes for quote submission and displaying the latest quotes.
- **Voting System**: Allows users to upvote or downvote quotes.
- **Admin Approval**: Admins can approve or reject submitted quotes.

## Shortcodes

### `[quote_submission_form]`

Displays a form for users to submit new quotes.

### `[latest_quotes number="5"]`

Displays the latest quotes. The `number` attribute specifies the number of quotes to display (default is 5).

## Usage

### Submitting a Quote

1. Add the `[quote_submission_form]` shortcode to a page or post.
2. Users can fill out the form to submit a new quote.

### Displaying Latest Quotes

1. Add the `[latest_quotes]` shortcode to a page or post.
2. The latest quotes will be displayed with upvote and downvote buttons.

### Admin Approval

1. Navigate to the `Quote Vote` menu in the WordPress admin area.
2. Approve or reject pending quotes.

## Customization

### Styles

The plugin includes a custom stylesheet that can be enqueued using the following function:

```php
function quote_vote_enqueue_styles() {
    wp_enqueue_style( 'quote-vote-style', plugin_dir_url( __FILE__ ) . 'style.css' );
}
add_action( 'wp_enqueue_scripts', 'quote_vote_enqueue_styles' );
```

# TODO
* [ ] Prevent spamming of the voting buttons
* [ ] Improve the approve/reject interface design
