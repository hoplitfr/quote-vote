<?php

/**
 * Class Quote_Vote_Shortcodes
 *
 * This class handles the shortcodes for the Quote Vote plugin.
 */
class Quote_Vote_Shortcodes
{
    /**
     * Initialize the shortcodes.
     *
     * @return void
     */
    public static function init()
    {
        add_shortcode('quote_submission_form', array( __CLASS__, 'quote_submission_form' ));
        add_shortcode('latest_quotes', array( __CLASS__, 'latest_quotes' ));
    }

    /**
     * Render the quote submission form.
     *
     * @return string The HTML for the quote submission form.
     */
    public static function quote_submission_form()
    {
        ob_start();
        ?>
        <form id="quote-submission-form" method="post">
            <label for="quote-title">Title:</label>
            <input type="text" id="quote-title" name="quote_title" required>
            <label for="quote-content">Content:</label>
            <textarea id="quote-content" name="quote_content" required></textarea>
            <input type="submit" value="Submit">
        </form>
        <?php
        return ob_get_clean();
    }

    /**
     * Handle the submission of a new quote.
     *
     * @return void
     */
    public static function handle_submission()
    {
        if (isset($_POST['quote_title']) && isset($_POST['quote_content'])) {
            $quote_title = sanitize_text_field($_POST['quote_title']);
            $quote_content = sanitize_textarea_field($_POST['quote_content']);

            $post_data = array(
                'post_title'   => $quote_title,
                'post_content' => $quote_content,
                'post_status'  => 'pending',
                'post_type'    => 'quote'
            );

            wp_insert_post($post_data);
        }
    }

    /**
     * Render the latest quotes.
     *
     * @param array $atts The shortcode attributes.
     * @return string The HTML for the latest quotes.
     */
    public static function latest_quotes($atts)
    {
        $atts = shortcode_atts(array(
            'number' => 5,
        ), $atts);

        $args = array(
            'post_type' => 'quote',
            'post_status' => 'publish',
            'posts_per_page' => $atts['number'],
        );

        $query = new WP_Query($args);

        ob_start();

        if ($query->have_posts()) {
            echo '<div class="latest-quotes">';
            while ($query->have_posts()) {
                $query->the_post();
                ?>
                <div class="quote-item">
                    <h2><?php the_title(); ?></h2>
                    <p><?php the_content(); ?></p>
                    <?php
                    $votes = get_post_meta(get_the_ID(), 'quote_votes', true);
                $votes = $votes ? $votes : 0;
                ?>
                    <div class="quote-vote">
                        <button class="vote-button" data-post-id="<?php the_ID(); ?>" data-vote-type="upvote">Upvote</button>
                        <button class="vote-button" data-post-id="<?php the_ID(); ?>" data-vote-type="downvote">Downvote</button>
                        <span id="vote-count-<?php the_ID(); ?>"><?php echo $votes; ?></span>
                    </div>
                </div>
                <?php
            }
            echo '</div>';
        } else {
            echo '<p>No quotes found.</p>';
        }

        wp_reset_postdata();

        return ob_get_clean();
    }
}
add_action('init', array( 'Quote_Vote_Shortcodes', 'handle_submission' ));
