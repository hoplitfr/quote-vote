<?php

/**
 * Class Quote_Vote_Voting
 *
 * This class handles the voting functionality for quotes.
 */
class Quote_Vote_Voting
{
    /**
     * Initialize the voting functionality.
     *
     * @return void
     */
    public static function init()
    {
        add_action('wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ));
        add_action('wp_ajax_quote_vote', array( __CLASS__, 'handle_vote' ));
        add_action('wp_ajax_nopriv_quote_vote', array( __CLASS__, 'handle_vote' ));
        add_filter('the_content', array( __CLASS__, 'add_vote_buttons' ));
    }

    /**
     * Enqueue the necessary scripts for voting.
     *
     * @return void
     */
    public static function enqueue_scripts()
    {
        wp_enqueue_script('quote-vote-js', plugin_dir_url(__FILE__) . 'quote-vote.js', array( 'jquery' ), null, true);
        wp_localize_script('quote-vote-js', 'quoteVoteAjax', array( 'ajax_url' => admin_url('admin-ajax.php') ));
    }

    /**
     * Check if the user has already voted for a quote.
     *
     * @param int $post_id The ID of the quote.
     * @return bool True if the user has already voted, false otherwise.
     */
    public static function has_voted($post_id)
    {
        if (!session_id()) {
            session_start();
        }
        return isset($_SESSION['quote_vote_' . $post_id]);
    }

    /**
     * Handle the vote submission via AJAX.
     *
     * @return void
     */
    public static function handle_vote()
    {
        if (isset($_POST['post_id']) && isset($_POST['vote_type'])) {
            $post_id = intval($_POST['post_id']);
            $vote_type = sanitize_text_field($_POST['vote_type']);

            // Check if the user has already voted
            if (self::has_voted($post_id)) {
                wp_send_json_error(array( 'message' => 'You have already voted for this quote.' ));
                return;
            }

            $current_votes = get_post_meta($post_id, 'quote_votes', true);
            $current_votes = $current_votes ? $current_votes : 0;

            if ($vote_type === 'upvote') {
                $current_votes++;
            } elseif ($vote_type === 'downvote') {
                $current_votes--;
            }

            update_post_meta($post_id, 'quote_votes', $current_votes);

            // Set a session variable to indicate that the user has voted
            if (!session_id()) {
                session_start();
            }
            $_SESSION['quote_vote_' . $post_id] = 'voted';

            wp_send_json_success(array( 'votes' => $current_votes ));
        }

        wp_send_json_error();
    }


    /**
     * Add vote buttons to the content of quote posts.
     *
     * @param string $content The content of the post.
     * @return string The modified content with vote buttons.
     */
    public static function add_vote_buttons($content)
    {
        if (is_singular('quote')) {
            $post_id = get_the_ID();
            $votes = get_post_meta($post_id, 'quote_votes', true);
            $votes = $votes ? $votes : 0;

            $has_voted = self::has_voted($post_id);

            $vote_buttons = '
            <div class="quote-vote">
                <button class="vote-button" data-post-id="' . $post_id . '" data-vote-type="upvote" ' . ($has_voted ? 'disabled' : '') . '>Upvote</button>
                <button class="vote-button" data-post-id="' . $post_id . '" data-vote-type="downvote" ' . ($has_voted ? 'disabled' : '') . '>Downvote</button>
                <span id="vote-count-' . $post_id . '">' . $votes . '</span>
            </div>';

            $content .= $vote_buttons;
        }
        return $content;
    }

}
