document.addEventListener('DOMContentLoaded', function () {
    const planSelect = document.getElementById('selected_plan_id');
    const planText = document.getElementById('selected_plan_text');
    const durationSelect = document.getElementById('plan_duration');
    const subTotal = document.getElementById('sub_total');
    const tax = document.getElementById('tax_amount');
    const total = document.getElementById('total_amount');

    function getPlanDetails() {
        if (planSelect && planSelect.selectedIndex >= 0) {
            const selected = planSelect.options[planSelect.selectedIndex];
            return {
                price: parseFloat(selected.getAttribute('data-price')) || 0,
                name: selected.getAttribute('data-name') || 'N/A'
            };
        } else {
            const price = parseFloat(document.getElementById('selected_plan_price')?.value || 0);
            const name = planText?.textContent || 'N/A';
            return { price, name };
        }
    }

    function updateButtonLabel(price) {
        const registerLabel = document.getElementById('register_btn_label');
        if (!registerLabel) return;

        if (price > 0) {
            registerLabel.textContent = 'Pay & Register Now';
        } else {
            registerLabel.textContent = 'Register For Free';
        }
    }

    function updatePricing() {
        const months = parseInt(durationSelect?.value || 1);
        const { price, name } = getPlanDetails();

        const subtotalVal = price * months;
        const taxVal = +(subtotalVal * 0.05).toFixed(2);
        const totalVal = +(subtotalVal + taxVal).toFixed(2);

        subTotal.textContent = `$${subtotalVal.toFixed(2)}`;
        tax.textContent = `$${taxVal.toFixed(2)}`;
        total.textContent = `$${totalVal.toFixed(2)}`;

        if (planText && name) {
            planText.textContent = name;
        }

        updateButtonLabel(price);
    }

    // Attach event listeners
    if (planSelect) planSelect.addEventListener('change', updatePricing);
    if (durationSelect) durationSelect.addEventListener('change', updatePricing);

    function validateField(inputId, fieldName, emptyMsg, successMsg, errorMsg) {
        const input = document.getElementById(inputId);
        if (!input) return;
    
        const wrapper = input.closest('.mb-3');
        const validFeedback = wrapper?.querySelector('.valid-feedback');
        const invalidFeedback = wrapper?.querySelector('.invalid-feedback');
    
        input.addEventListener('blur', function () {
            const value = input.value.trim();
    
            // Case 1: Empty field
            if (!value) {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                if (invalidFeedback) invalidFeedback.textContent = emptyMsg;
                return;
            }
    
            // Case 2: AJAX check
            fetch(`${ajax_object.ajax_url}?action=check_duplicate&field=${fieldName}&value=${encodeURIComponent(value)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.exists) {
                        // Already exists
                        input.classList.remove('is-valid');
                        input.classList.add('is-invalid');
                        if (invalidFeedback) invalidFeedback.textContent = errorMsg;
                    } else {
                        // Unique and valid
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                        if (validFeedback) validFeedback.textContent = successMsg;
                    }
                });
        });
    }
    
    function validateEmailField() {
        const input = document.getElementById('email');
        if (!input) return;
    
        const wrapper = input.closest('.col-md-6');
        const validFeedback = wrapper.querySelector('.valid-feedback') || createFeedback(wrapper, 'valid-feedback');
        const invalidFeedback = wrapper.querySelector('.invalid-feedback');
    
        input.addEventListener('blur', function () {
            const value = input.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
            // Case 1: Empty
            if (!value) {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                invalidFeedback.textContent = "Please enter an email.";
                return;
            }
    
            // Case 2: Invalid format
            if (!emailRegex.test(value)) {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                invalidFeedback.textContent = "Please enter a valid email address.";
                return;
            }
    
            // Case 3: Check if email already exists
            fetch(`${ajax_object.ajax_url}?action=check_duplicate&field=email&value=${encodeURIComponent(value)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.data.exists) {
                        input.classList.remove('is-valid');
                        input.classList.add('is-invalid');
                        invalidFeedback.textContent = "Email already exists.";
                    } else {
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                        validFeedback.textContent = "";
                    }
                });
        });
    }
    
    // Optional helper to add valid-feedback if missing
    function createFeedback(wrapper, className) {
        const div = document.createElement('div');
        div.className = className;
        wrapper.appendChild(div);
        return div;
    }
    
    function validatePhoneField(inputId, fieldName, emptyMsg, invalidMsg, duplicateMsg, successMsg) {
        const input = document.getElementById(inputId);
        if (!input) return;
    
        const wrapper = input.closest('.input-group');
        const validFeedback = wrapper.querySelector('.valid-feedback') || createFeedback(wrapper, 'valid-feedback');
        const invalidFeedback = wrapper.querySelector('.invalid-feedback');
    
        input.addEventListener('blur', function () {
            const value = input.value.trim();
    
            // Case 1: Empty
            if (!value) {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                invalidFeedback.textContent = emptyMsg;
                return;
            }
    
            // Case 2: Invalid format (non-numeric)
            if (!/^\d{5,15}$/.test(value)) {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                invalidFeedback.textContent = invalidMsg;
                return;
            }
    
            // Case 3: Check if phone number already exists
            fetch(`${ajax_object.ajax_url}?action=check_duplicate&field=${fieldName}&value=${encodeURIComponent(value)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.data.exists) {
                        input.classList.remove('is-valid');
                        input.classList.add('is-invalid');
                        invalidFeedback.textContent = duplicateMsg;
                    } else {
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                        
                    }
                });
        });
    }

    function createFeedback(wrapper, className) {
        const div = document.createElement('div');
        div.className = className;
        wrapper.appendChild(div);
        return div;
    }
    
    
    
    

    // ✅ Call this once on load
    updatePricing();

    validateEmailField();

    validateField('username', 'username', 'Please choose a username.', 'Username is available!', 'Username already exists.');
    validatePhoneField(
        'user_phone', 'user_phone',
        'Please enter candidate phone number.',
        'Enter valid digits only.',
        'Candidate phone number is already used.',
        'Candidate phone number is available!'
    );
    
    validatePhoneField(
        'user_g_phone', 'user_phone',
        'Please enter guardian phone number.',
        'Enter valid digits only.',
        'Guardian phone number is already used.',
        'Guardian phone number is available!'
    );
    
    

});
