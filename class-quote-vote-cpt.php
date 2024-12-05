<?php

/**
 * Class Quote_Vote_CPT
 *
 * This class handles the registration of the custom post type for quotes.
 */
class Quote_Vote_CPT
{
    /**
     * Initialize the custom post type.
     *
     * @return void
     */
    public static function init()
    {
        add_action('init', array( __CLASS__, 'register_post_type' ));
    }

    /**
     * Register the custom post type for quotes.
     *
     * @return void
     */
    public static function register_post_type()
    {
        $labels = array(
            'name'               => _x('Quotes', 'post type general name', 'quote-vote'),
            'singular_name'      => _x('Quote', 'post type singular name', 'quote-vote'),
            'menu_name'          => _x('Quotes', 'admin menu', 'quote-vote'),
            'name_admin_bar'     => _x('Quote', 'add new on admin bar', 'quote-vote'),
            'add_new'            => _x('Add New', 'quote', 'quote-vote'),
            'add_new_item'       => __('Add New Quote', 'quote-vote'),
            'new_item'           => __('New Quote', 'quote-vote'),
            'edit_item'          => __('Edit Quote', 'quote-vote'),
            'view_item'          => __('View Quote', 'quote-vote'),
            'all_items'          => __('All Quotes', 'quote-vote'),
            'search_items'       => __('Search Quotes', 'quote-vote'),
            'parent_item_colon'   => __('Parent Quotes:', 'quote-vote'),
            'not_found'          => __('No quotes found.', 'quote-vote'),
            'not_found_in_trash' => __('No quotes found in Trash.', 'quote-vote')
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'quote' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
        );

        register_post_type('quote', $args);
    }
}
