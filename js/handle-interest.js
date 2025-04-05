jQuery(document).ready(function($) {
    $('.respond-interest').on('click', function() {
        var button = $(this);
        var interest_id = button.data('id');
        var action = button.data('action');

        $.ajax({
            type: 'POST',
            url: interest_ajax.ajax_url,
            data: {
                action: 'respond_to_interest',
                security: interest_ajax.nonce,
                interest_id: interest_id,
                response: action
            },
            success: function(response) {
                if (response.success) {
                    button.closest('.card').fadeOut(); // Optional: remove from list
                    alert("Response recorded: " + action);
                } else {
                    alert('Something went wrong!');
                }
            }
        });
    });
});
