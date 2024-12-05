<?php

/**
 * Class Quote_Vote_Admin
 *
 * This class handles the administration of quote votes in the WordPress admin area.
 */
class Quote_Vote_Admin
{
    /**
     * Initialize the admin menu and handle approval actions.
     *
     * @return void
     */
    public static function init()
    {
        add_action('admin_menu', array( __CLASS__, 'add_admin_menu' ));
        add_action('admin_init', array( __CLASS__, 'handle_approval' ));
    }

    /**
     * Add the admin menu for quote votes.
     *
     * @return void
     */
    public static function add_admin_menu()
    {
        add_menu_page(
            'Quote Vote',
            'Quote Vote',
            'manage_options',
            'quote-vote',
            array( __CLASS__, 'admin_page' ),
            'dashicons-admin-comments',
            6
        );
    }

    /**
     * Display the admin page for quote votes.
     *
     * @return void
     */
    public static function admin_page()
    {
        ?>
        <div class="wrap">
            <h1>Quote Vote Administration</h1>
            <form method="post">
                <?php
                $args = array(
                    'post_type' => 'quote',
                    'post_status' => 'pending',
                    'posts_per_page' => -1
                );
        $quotes = new WP_Query($args);

        if ($quotes->have_posts()) {
            while ($quotes->have_posts()) {
                $quotes->the_post();
                ?>
                        <div>
                            <h2><?php the_title(); ?></h2>
                            <p><?php the_content(); ?></p>
                            <input type="hidden" name="quote_id[]" value="<?php the_ID(); ?>">
                            <label>
                                <input type="radio" name="quote_action[<?php the_ID(); ?>]" value="approve"> Approve
                            </label>
                            <label>
                                <input type="radio" name="quote_action[<?php the_ID(); ?>]" value="reject"> Reject
                            </label>
                        </div>
                        <?php
            }
            ?>
                    <input type="submit" value="Save Changes">
                    <?php
        } else {
            echo '<p>No pending quotes found.</p>';
        }
        wp_reset_postdata();
        ?>
            </form>
        </div>
        <?php
    }

    /**
     * Handle the approval or rejection of quotes.
     *
     * @return void
     */
    public static function handle_approval()
    {
        if (isset($_POST['quote_id']) && isset($_POST['quote_action'])) {
            foreach ($_POST['quote_id'] as $quote_id) {
                $action = sanitize_text_field($_POST['quote_action'][$quote_id]);
                if ($action === 'approve') {
                    wp_update_post(array(
                        'ID' => $quote_id,
                        'post_status' => 'publish'
                    ));
                } elseif ($action === 'reject') {
                    wp_update_post(array(
                        'ID' => $quote_id,
                        'post_status' => 'trash'
                    ));
                }
            }
        }
    }
}
