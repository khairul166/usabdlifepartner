<?php
/* Template Name: Reset Password */
get_header();

// Get user credentials from the reset link
$user = check_password_reset_key($_GET['key'] ?? '', $_GET['login'] ?? '');

$password_reset_success = false; // Flag to track if password is reset

if (!$user || is_wp_error($user)) {
    echo '<div class="alert alert-danger text-center">Invalid or expired reset link.</div>';
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
        $password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if (empty($password) || empty($confirm_password)) {
            $error_message = 'Please enter a new password.';
        } elseif ($password !== $confirm_password) {
            $error_message = 'Passwords do not match.';
        } else {
            reset_password($user, $password);
            $password_reset_success = true; // Set success flag
        }
    }
}
?>

<section id="center" class="search_form pt-5 pb-5">
    <div class="container-xl">
        <?php if (!$user || is_wp_error($user)) : ?>
            <!-- Invalid or Expired Link Message -->
            <div class="alert alert-danger text-center">Invalid or expired reset link.</div>
        <?php elseif ($password_reset_success) : ?>
            <!-- Success Message After Password Reset -->
            <p class="text-center">
                Your password has been reset.
                <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>">Go to Homepage</a>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/login')); ?>">Login here</a>
                <?php endif; ?>
                </p>
        <?php else : ?>
            <!-- Display Reset Password Form -->
            <h1 class="theme-text-color text-center mb-4">RESET YOUR PASSWORD</h1>
            <div class="row search_form1 shadow p-4 w-50 mx-auto">
                <form method="post" action="">
                    <div class="col-md-12">
                        <!-- Display Error Message if Any -->
                        <?php if (isset($error_message)) : ?>
                            <div class="alert alert-danger"><?php echo esc_html($error_message); ?></div>
                        <?php endif; ?>

                        <!-- New Password Field -->
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" required>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" name="reset_password" class="btn theme-btn w-50 text-white d-block mx-auto">RESET PASSWORD</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
