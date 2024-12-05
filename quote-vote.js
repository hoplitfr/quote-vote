jQuery(document).ready(function($) {
    $('.vote-button').on('click', function() {
        var post_id = $(this).data('post-id');
        var vote_type = $(this).data('vote-type');

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
                }
            }
        });
    });
});
