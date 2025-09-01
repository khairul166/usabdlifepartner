document.addEventListener('DOMContentLoaded', function () {

    // Helper to create feedback div if not exists
    function createFeedback(wrapper, className) {
        const div = document.createElement('div');
        div.className = className;
        wrapper.appendChild(div);
        return div;
    }

    // First/Last Name Validation (no numbers allowed)
    function validateNameField(inputId, emptyMsg = "This field is required.", invalidMsg = "Please enter a valid name.") {
        const input = document.getElementById(inputId);
        if (!input) return;

        const wrapper = input.closest('.col-md-6, .mb-3, .form-group');
        const invalidFeedback = wrapper.querySelector('.invalid-feedback');
        const validFeedback = wrapper.querySelector('.valid-feedback') || createFeedback(wrapper, 'valid-feedback');

        input.addEventListener('blur', () => {
            const value = input.value.trim();
            if (!value) {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                invalidFeedback.textContent = emptyMsg;
            } else if (!/^[a-zA-Z\s'-]+$/.test(value)) {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                invalidFeedback.textContent = invalidMsg;
            } else {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                
            }
        });
    }

    // Password Validation
    function validatePasswordField() {
        const input = document.getElementById('password');
        if (!input) return;

        const wrapper = input.closest('.col-md-6, .mb-3, .form-group');
        const invalidFeedback = wrapper.querySelector('.invalid-feedback');
        const validFeedback = wrapper.querySelector('.valid-feedback') || createFeedback(wrapper, 'valid-feedback');

        input.addEventListener('blur', () => {
            const value = input.value;
            const isValid = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);

            if (!value) {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                invalidFeedback.textContent = "Password is required.";
                invalidFeedback.style.display = 'block';
            } else if (!isValid) {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                invalidFeedback.textContent = "At least 8 chars, incl. upper, lower, number, special char.";
                invalidFeedback.style.display = 'block';
            } else {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                validFeedback.textContent = "Strong password!";
                invalidFeedback.style.display = 'none';
            }
        });
    }

    // Confirm Password Match
    function validateConfirmPassword() {
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('repassword');
        if (!confirmInput || !passwordInput) return;

        const wrapper = confirmInput.closest('.col-md-6, .mb-3, .form-group');
        const invalidFeedback = wrapper.querySelector('.invalid-feedback');
        const validFeedback = wrapper.querySelector('.valid-feedback') || createFeedback(wrapper, 'valid-feedback');

        confirmInput.addEventListener('blur', () => {
            if (!confirmInput.value) {
                confirmInput.classList.remove('is-valid');
                confirmInput.classList.add('is-invalid');
                invalidFeedback.textContent = "Please confirm your password.";
                invalidFeedback.style.display = 'block';
            } else if (confirmInput.value !== passwordInput.value) {
                confirmInput.classList.remove('is-valid');
                confirmInput.classList.add('is-invalid');
                invalidFeedback.textContent = "Passwords do not match.";
                invalidFeedback.style.display = 'block';
            } else {
                confirmInput.classList.remove('is-invalid');
                confirmInput.classList.add('is-valid');
                validFeedback.textContent = "Passwords match!";
                invalidFeedback.style.display = 'none';
            }
        });
    }



    // Run All Validators
    validateNameField('fname');
    validateNameField('lname');
    validatePasswordField();
    validateConfirmPassword();

});