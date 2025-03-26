jQuery(document).ready(function($) {
    function loadProfiles(page = 1) {
        var lookingFor = $('#lookingfor').val();
        var country = $('#country').val();
        var maritalStatus = $('#marital_status').val();
        var religion = $('#religion').val();
        var profession = $('#profession').val();
        var smokingStatus = $('#smoking_status').val();
        var drinkingStatus = $('#drinking_status').val();

        $.ajax({
            type: 'GET',
            url: matrimonial_search_params.ajax_url,
            data: {
                action: 'filter_profiles',
                looking_for: lookingFor,
                country: country,
                marital_status: maritalStatus,
                religion: religion,
                profession: profession,
                smoking_status: smokingStatus,
                drinking_status: drinkingStatus,
                paged: page
            },
            success: function(response) {
                console.log("AJAX Response:", response);

                if (response.success) {
                    $('.list_1_right').html(response.data.profiles);

                    if (response.data.pagination && response.data.pagination.trim() !== "") {
                        console.log("Pagination received:", response.data.pagination); 
                        if ($('.paging').length === 0) {
                            console.log("Pagination container missing, creating .paging div...");
                            $('.list_1_right').after('<div class="paging"></div>'); // Add it dynamically
                        }
                        $('.paging').html(response.data.pagination).css("display", "block").show();
                    } else {
                        console.log("No pagination received! Hiding pagination.");
                        $('.paging').html('').hide();
                    }
                } else {
                    $('.list_1_right').html('<p class="col-12 text-center">No profiles found.</p>');
                    $('.paging').html('').hide();
                }
            }
        });
    }

    // When filter is changed
    $('.form-select').on('change', function() {
        loadProfiles(1);
    });

    // ✅ Fix Pagination Click Event
    $(document).on('click', '.ajax-pagination', function(e) {
        e.preventDefault();
        
        var page = $(this).attr('href').split('paged=')[1] || 1;
        console.log("Clicked pagination: Loading page " + page);
        loadProfiles(page);
    });
});
