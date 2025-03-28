jQuery(document).ready(function($) {
    $('.send-interest-btn').click(function(e) {
        e.preventDefault();
        var to_user_id = $(this).data('to-user-id');

        $.ajax({
            url: interest_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'send_interest',
                to_user_id: to_user_id,
                security: interest_ajax_object.nonce
            },
            success: function(response) {
                alert(response.data.message);
                if (response.success) {
                    location.reload();
                }
            }
        });
    });
});
