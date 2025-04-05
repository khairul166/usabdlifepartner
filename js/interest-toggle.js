jQuery(document).ready(function ($) {
    let processing = false;

    $('.interest-toggle-btn').on('click', function () {
        if (processing) return;
        processing = true;

        const button = $(this);
        const to_user_id = button.data('to-user-id');
        const action = button.data('action');

        $.ajax({
            type: 'POST',
            url: interest_ajax.ajax_url,
            data: {
                action: 'toggle_interest',
                to_user_id: to_user_id,
                type: action,
                security: interest_ajax.nonce
            },
            success: function (response) {
                processing = false;

                if (response.success) {
                    if (response.data.action === 'sent') {
                        button.text('Cancel Interest');
                        button.data('action', 'cancel');
                        button.removeClass('btn-primary').addClass('btn-danger');
                    } else {
                        button.text('Send Interest');
                        button.data('action', 'send');
                        button.removeClass('btn-danger').addClass('btn-primary');
                    }
                } else {
                    alert('Error: ' + (response.data?.message || 'Something went wrong.'));
                }
            },
            error: function () {
                processing = false;
                alert('AJAX request failed.');
            }
        });
    });
});
