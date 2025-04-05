$('.interest-toggle-btn').click(function(e) {
    e.preventDefault();

    const btn = $(this);
    const to_user_id = btn.data('to-user-id');
    const actionType = btn.data('action');

    $.ajax({
        url: interest_ajax_object.ajax_url,
        type: 'POST',
        data: {
            action: 'toggle_interest',
            to_user_id: to_user_id,
            type: actionType,
            security: interest_ajax_object.nonce
        },
        success: function(response) {
            alert(response.data.message);
            if (response.success) {
                if (actionType === 'send') {
                    btn.text('Cancel Interest');
                    btn.data('action', 'cancel');
                } else {
                    btn.text('Send Interest');
                    btn.data('action', 'send');
                }
            }
        }
    });
});
