document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.shortlist-btn').forEach(button => {
        button.addEventListener('click', () => {
            const userId = button.dataset.userid;
            fetch(my_ajax_object.ajax_url, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: new URLSearchParams({
                    action: 'toggle_shortlist',
                    shortlisted_user_id: userId
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (data.data.action === 'added') {
                        button.textContent = 'Remove Shortlist';
                    } else {
                        button.textContent = 'Shortlist';
                    }
                }
            });
        });
    });
});
