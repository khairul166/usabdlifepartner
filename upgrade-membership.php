<?php
get_header();
$current_user = wp_get_current_user();
$enable_payment = intval(get_option('enable_payment', 1));
if (is_user_logged_in()) {
    if ($enable_payment) {
        global $wpdb;

        $membership_info = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM {$wpdb->prefix}memberships WHERE user_id = %d AND status = 'active'", $current_user->ID)
        );

        $membership_plan_name = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM {$wpdb->prefix}membership_plans WHERE id = %d", $membership_info->membership_type)
        );

        if ($membership_info) {
            $current_plan_price = $wpdb->get_var(
                $wpdb->prepare("SELECT price FROM {$wpdb->prefix}membership_plans WHERE id = %d", $membership_info->membership_type)
            );

            $available_plans = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM {$wpdb->prefix}membership_plans WHERE price > %f", $current_plan_price)
            );
?>
            <section id="upgrade-section" class="pt-5 pb-5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 mx-auto">
                            <div class="card shadow-lg border-light rounded">
                                <div class="card-header theme-bg text-white text-center">
                                    <h4 class="card-title mb-0">Upgrade Your Membership Plan</h4>
                                </div>
                                <div class="card-body">
                                    <p><strong>Current Plan:</strong> <?php echo esc_html($membership_plan_name->name); ?></p>

                                    <form method="POST" id="upgrade-form" action="<?php echo get_template_directory_uri(); ?>/upgrade_plan_processing.php">
                                        <div class="form-group mb-3">
                                            <label for="selected_plan" class="form-label">Select New Plan</label>
                                            <select name="selected_plan" id="selected_plan" class="form-select" required>
                                                <?php foreach ($available_plans as $plan): ?>
                                                    <option value="<?php echo $plan->id; ?>" data-price="<?php echo $plan->price; ?>">
                                                        <?php echo esc_html($plan->name); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="plan_duration" class="form-label">Choose Plan Duration:</label>
                                            <select id="plan_duration" class="form-select" name="plan_duration" required>
                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?> Month<?php echo $i > 1 ? 's' : ''; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="col-4 pt-1 pb-2"><label class="form-label">Sub Total:</label></div>
                                            <div class="col-8 pt-1 pb-2"><span id="sub_total">$0.00</span></div>

                                            <div class="col-4 pt-1 pb-2"><label class="form-label">Tax:</label></div>
                                            <div class="col-8 pt-1 pb-2"><span id="tax_amount">$0.00</span></div>

                                            <div class="col-4 pt-1 pb-2"><label class="form-label fw-bold">Total:</label></div>
                                            <div class="col-8 pt-1 pb-2"><span id="total_amount" class="fw-bold">$0.00</span></div>
                                        </div>

                                        <input type="hidden" name="current_plan_id" value="<?php echo esc_attr($membership_info->membership_type); ?>">
                                        <?php
                                        $current_plan_price = $wpdb->get_var(
                                            $wpdb->prepare("SELECT price FROM {$wpdb->prefix}membership_plans WHERE id = %d", $membership_info->membership_type)
                                        );
                                        $current_plan_duration = 12; // assume 12 months, or fetch dynamically if stored
                                        $current_paid_amount = ($current_plan_price * $current_plan_duration) * 1.05; // includes 5% VAT
                                        ?>
                                        <input type="hidden" name="current_plan_paid_amount" value="<?php echo esc_attr($current_paid_amount); ?>">

                                        <input type="hidden" name="current_plan_start_date" value="<?php echo esc_attr($membership_info->start_date); ?>">

                                        <input type="hidden" name="selected_plan_price" id="selected_plan_price" value="">
                                        <input type="hidden" name="selected_plan_id" id="upgrade_plan_id" value="">
                                        <input type="hidden" name="plan_duration" id="upgrade_plan_duration" value="1">

                                        <div class="text-center mt-4">
                                            <button type="submit" name="upgrade_plan" class="btn theme-btn w-50">Upgrade Plan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <script>
                const selectedPlan = document.getElementById('selected_plan');
                const planDuration = document.getElementById('plan_duration');
                const subTotal = document.getElementById('sub_total');
                const taxAmount = document.getElementById('tax_amount');
                const totalAmount = document.getElementById('total_amount');
                const selectedPlanPrice = document.getElementById('selected_plan_price');
                const upgrade_plan_id = document.getElementById('upgrade_plan_id');
                const upgrade_plan_duration = document.getElementById('upgrade_plan_duration');

                function updatePricing() {
                    const price = parseFloat(selectedPlan.selectedOptions[0].getAttribute('data-price'));
                    const duration = parseInt(planDuration.value);
                    const subtotal = price * duration;
                    const tax = subtotal * 0.05;
                    const total = subtotal + tax;

                    subTotal.textContent = `$${subtotal.toFixed(2)}`;
                    taxAmount.textContent = `$${tax.toFixed(2)}`;
                    totalAmount.textContent = `$${total.toFixed(2)}`;

                    selectedPlanPrice.value = price;
                    upgrade_plan_id.value = selectedPlan.value;
                    upgrade_plan_duration.value = duration;
                }

                selectedPlan.addEventListener('change', updatePricing);
                planDuration.addEventListener('change', updatePricing);
                updatePricing();
            </script>
<?php
        } else {
            echo '<section id="upgrade-section" class="text-center pt-5 pb-5">
                <div class="container"><div class="col-12">No active membership found. Please contact support.</div></div>
              </section>';
        }
    } else {
        echo '<section id="upgrade-section" class="text-center pt-5 pb-5">
                <div class="container"><div class="col-12">Membership upgrade is currently disabled. Please try again later.</div></div>
              </section>';
    }
} else {
    echo '<section id="upgrade-section" class="text-center pt-5 pb-5">
                <div class="container"><div class="col-12">You must be logged in to upgrade your membership.</div></div>
              </section>';
}

get_footer();
