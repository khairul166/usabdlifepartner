<?php
/* Template Name: Forget Password */

get_header();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['forgot_password'])) {
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';

    if (empty($email)) {
        $error_message = 'Please enter your email address.';
    } elseif (!is_email($email)) {
        $error_message = 'Invalid email address.';
    } else {
        // Check if the email exists in the database
        $user = get_user_by('email', $email);

        if ($user) {

            $result = retrieve_password($user->user_login);


            if (is_wp_error($result)) {
                $error_message = $result->get_error_message();
            } else {
                $success_message = 'A password reset link has been sent to your email address.';
            }
        } else {
            $error_message = 'No user found with this email address.';
        }
    }
}
?>

<section id="center" class="search_form pt-5 pb-5">
    <div class="container-xl">
        <h1 class="theme-text-color text-center mb-4">RECOVER YOUR PASSWORD</h1>
        <form method="post" action="">
            <div class="row search_form1 shadow p-4 w-50 mx-auto">
                <div class="col-md-12">
                    <!-- Display Success/Error Messages -->
                    <?php if (isset($success_message)) : ?>
                        <div class="alert alert-success"><?php echo esc_html($success_message); ?></div>
                    <?php endif; ?>

                    <?php if (isset($error_message)) : ?>
                        <div class="alert alert-danger"><?php echo esc_html($error_message); ?></div>
                    <?php endif; ?>

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Type your email" required>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" name="forgot_password" class="btn theme-btn w-50 text-white d-block mx-auto">SEND RESET LINK</button>
                </div>
            </div>
        </form>
    </div>
</section>

<?php get_footer(); ?>