<?php
/* Template Name: Custom Login */
ob_start(); // Start output buffering at the very beginning
get_header();
?>

<section id="center" class="search_form pt-5 pb-5">
    <div class="container-xl">
        <h1 class="theme-text-color text-center mb-4">LOGIN</h1>
        <div class="row search_form1 shadow p-4 w-50 mx-auto">
            <?php
            // Check if the user is already logged in
            if (is_user_logged_in()) {
                wp_redirect(home_url('/my-account')); // Redirect logged-in users to my-account or dashboard
                exit;
            } else {
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["wp-submit"])) {
                    $creds = array();
                    $creds['user_login'] = sanitize_text_field($_POST['log']);
                    $creds['user_password'] = sanitize_text_field($_POST['pwd']);
                    $creds['remember'] = isset($_POST['rememberme']) ? true : false;
                    $secure_cookie = is_ssl(); // Only true if running over HTTPS
                    $user = wp_signon($creds, $secure_cookie);

                    if (is_wp_error($user)) {
                        echo '<div class="alert alert-danger">' .$user->get_error_message() . '</div>';
                    } else {
                        $user_id = $user->ID;
                        $approval_status = get_user_meta($user_id, 'approval_status', true);
                    
                        if ($approval_status === 'rejected') {
                            wp_logout();
                            echo '<div class="alert alert-danger">❌ Oops! Your account has been rejected and you can\'t login.</div>';
                        } elseif ($approval_status === 'banned') {
                            wp_logout();
                            echo '<div class="alert alert-danger">🚫 Your account has been banned by the admin. Please contact support.</div>';
                        } else {
                            wp_redirect(home_url('/my-account')); // Successful login and approved
                            exit;
                        }
                    }
                }
                if (isset($_GET['reset']) && $_GET['reset'] === 'success') : ?>
                    <div class="alert alert-success text-center">
                        ✅ Your password has been reset successfully. Please log in.
                    </div>
               <?php endif; 
                
            ?>
                <form method="post">
                    <div class="col-md-12">
                        <span class="text-center d-block mb-2">START FOR FREE</span>
                        <h4 class="text-center mb-2">Sign in to USABDLifepartner</h4>
                        <span class="d-block text-center">Not a member? <a class="theme-text-color" href="<?php echo esc_url(get_custom_registration_url()); ?>">Sign up now</a></span>

                        <!-- Username Field -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="log" id="username" placeholder="Type your username" required>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3 position-relative">
    <label for="password" class="form-label">Password</label>
    <div class="position-relative">
        <input type="password" class="form-control pe-5" name="pwd" id="password" placeholder="Type your password" required>
        <span class="dashicons dashicons-visibility toggle-password"
              data-target="password"
              style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; font-size: 18px;"></span>
    </div>
</div>


                        <!-- Remember Me and Forgot Password Row -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="rememberme" id="rememberMe" value="forever">
                                <label class="form-check-label" for="rememberMe">Remember me</label>
                            </div>
                            <div>
                            <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="theme-text-color">Forgot password?</a>
                            </div>
                        </div>

                        <input type="hidden" name="redirect_to" value="<?php echo esc_url(home_url('/my-account')); ?>">
                        <button type="submit" name="wp-submit" class="btn theme-btn text-white btn-md pl-5 signin d-flex justify-content-between">SIGN IN</button>
                    </div>
                </form>
                            				 <!-- Or Sign Up Using Section -->
				 <!-- <div class="text-center mt-4">
					<span class="text-muted">Or Sign Up Using</span>
				 </div> -->
	 
				<!-- Social Login Buttons -->
				<!-- <div class="row mt-3 justify-content-center">
					<div class="col-auto text-center">
					<a href="#" class="btn btn-circle btn-outline-danger">
						<i class="bi bi-google"></i>
					</a>
					</div>
					<div class="col-auto text-center">
					<a href="#" class="btn btn-circle btn-outline-primary">
						<i class="bi bi-facebook"></i>
					</a>
					</div>
					<div class="col-auto text-center">
						<a href="#" class="btn btn-circle btn-outline-primary">
							<i class="bi bi-linkedin"></i>
						</a>
						</div>
				</div> -->
            <?php } ?>

        </div>
    </div>
</section>

<?php get_footer(); ?>