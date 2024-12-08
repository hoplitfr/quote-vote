jQuery(document).ready(function($) {
    $('.vote-button').on('click', function(e) {
        e.preventDefault();

        var $button = $(this);
        var post_id = $button.data('post-id');
        var vote_type = $button.data('vote-type');

        $.ajax({
            url: quoteVoteAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'quote_vote',
                post_id: post_id,
                vote_type: vote_type
            },
            success: function(response) {
                if (response.success) {
                    $('#vote-count-' + post_id).text(response.data.votes);
                    $button.prop('disabled', true);
                } else {
                    alert(response.data.message);
                }
            },
            error: function() {
                alert('An error occurred while processing your vote.');
            }
        });
    });
});
