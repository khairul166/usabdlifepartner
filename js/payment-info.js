document.addEventListener('DOMContentLoaded', function () {
    const planSelect = document.getElementById('selected_plan_id'); // Plan selection dropdown
    const durationSelect = document.getElementById('plan_duration'); // Plan duration dropdown

    // Hidden fields to pass data to the payment gateway
    const hiddenPlanId = document.getElementById('hidden_selected_plan_id');
    const hiddenPlanPrice = document.getElementById('selected_plan_price');
    const hiddenDuration = document.getElementById('select_plan_duration');

    // Elements to show sub-total, tax, and total
    const subTotalElem = document.getElementById('sub_total');
    const taxElem = document.getElementById('tax_amount');
    const totalElem = document.getElementById('total_amount');

    // Function to calculate pricing (sub-total, tax, and total)
    function updatePricing() {
        const selectedPlan = planSelect.options[planSelect.selectedIndex];
        const planPrice = parseFloat(selectedPlan.getAttribute('data-price')); // Price in dollars
        const planDuration = parseInt(durationSelect.value); // Duration in months

        // Update the hidden fields with the selected values
        hiddenPlanId.value = planSelect.value; // Plan ID
        hiddenPlanPrice.value = planPrice; // Plan Price
        hiddenDuration.value = planDuration; // Plan Duration

        // Calculate Subtotal, Tax, and Total
        const subTotalValue = planPrice * planDuration;
        const taxValue = subTotalValue * 0.05; // 5% tax
        const totalValue = subTotalValue + taxValue;

        // Update the UI with calculated values
        subTotalElem.textContent = `$${subTotalValue.toFixed(2)}`;
        taxElem.textContent = `$${taxValue.toFixed(2)}`;
        totalElem.textContent = `$${totalValue.toFixed(2)}`;
    }

    // Check if the URL contains a plan ID parameter and update the form accordingly
    const urlParams = new URLSearchParams(window.location.search);
    const planIdFromURL = urlParams.get('plan');

    if (planIdFromURL) {
        // User comes with a pre-selected plan (plan ID in the URL)
        const selectedPlan = document.querySelector(`#selected_plan_id option[value="${planIdFromURL}"]`);
        
        if (selectedPlan) {
            // Set the plan based on the URL
            planSelect.value = planIdFromURL; // Set selected plan ID
            document.getElementById('selected_plan_text').textContent = selectedPlan.textContent; // Update plan name
            hiddenPlanPrice.value = selectedPlan.getAttribute('data-price'); // Set hidden price field
            hiddenPlanId.value = planIdFromURL; // Set hidden plan ID
        }

        // Set the default duration value when a plan is pre-selected (e.g., 1 month)
        hiddenDuration.value = 1; // Set default duration for pre-selected plan (or set it based on your logic)
                // Update hidden fields when duration is changed
                durationSelect.addEventListener('change', function() {
                    hiddenDuration.value = durationSelect.value; // Update hidden duration field
                });

        // Disable the plan selection dropdown since the plan is pre-selected
        planSelect.disabled = true;

        // Update pricing based on selected plan
        updatePricing();
    } else {
        // User comes without a selected plan, they can choose from dropdown
        planSelect.disabled = false; // Enable plan selection dropdown
        planSelect.addEventListener('change', function() {
            // Update hidden fields when plan is changed
            const selectedPlan = planSelect.options[planSelect.selectedIndex];
            hiddenPlanId.value = planSelect.value; // Update hidden plan ID
            hiddenPlanPrice.value = selectedPlan.getAttribute('data-price'); // Update hidden plan price
        });

        // Update hidden fields when duration is changed
        durationSelect.addEventListener('change', function() {
            hiddenDuration.value = durationSelect.value; // Update hidden duration field
        });

        // Initialize pricing calculation when the user changes the plan or duration
        updatePricing(); // Initialize pricing calculation
    }
});
