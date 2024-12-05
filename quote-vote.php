<?php

/**
 * Plugin Name: Quote Vote
 * Description: A plugin to submit, approve, and vote on quotes.
 * Version: 1.0
 * Author: Hoplit.fr
 * Author URI: https://www.hoplit.fr/
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include the necessary files
require_once plugin_dir_path(__FILE__) . 'class-quote-vote-cpt.php';
require_once plugin_dir_path(__FILE__) . 'class-quote-vote-shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'class-quote-vote-voting.php';
require_once plugin_dir_path(__FILE__) . 'class-quote-vote-admin.php';

/**
 * Initialize the plugin.
 *
 * This function initializes the various components of the Quote Vote plugin.
 *
 * @return void
 */
function quote_vote_init()
{
    Quote_Vote_CPT::init();
    Quote_Vote_Shortcodes::init();
    Quote_Vote_Voting::init();
    Quote_Vote_Admin::init();
}
add_action('plugins_loaded', 'quote_vote_init');

/**
 * Enqueue the custom stylesheet.
 *
 * This function enqueues the custom stylesheet for the Quote Vote plugin.
 *
 * @return void
 */
function quote_vote_enqueue_styles()
{
    wp_enqueue_style('quote-vote-style', plugin_dir_url(__FILE__) . 'style.css');
}
add_action('wp_enqueue_scripts', 'quote_vote_enqueue_styles');
