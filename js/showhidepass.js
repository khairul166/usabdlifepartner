document.addEventListener('DOMContentLoaded', function () {
    // Password Show/Hide Toggle
        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', () => {
                const targetId = toggle.dataset.target;
                const input = document.getElementById(targetId);
                if (!input) return;
        
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
        
                toggle.classList.toggle('dashicons-visibility');
                toggle.classList.toggle('dashicons-hidden');
            });
        });

    });