<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package YourThemeName
 * 
 * Template Name: Home Page
 */

get_header();
$opt_name = 'theme_admin_settings'; // Your defined option name

// Retrieve the entire option value directly from the WordPress database
$theme_options = get_option( $opt_name );

$welcome_heading = $theme_options['welcome_heading'] ?? 'Welcome to USABDLifepartner';
$welcome_subheading = $theme_options['welcome_subheading'] ?? 'Finding your perfect match just became easier';
$bg_color= $theme_options['welcome_bg'] ?? [];
$bg_image = isset($bg_color['background-image']) ? $bg_color['background-image'] : ''; 
$bg_color_value = isset($bg_color['background-color']) ? $bg_color['background-color'] : ''; 


$query = new WP_Query(array(
	'post_type' => 'carousel',
	'posts_per_page' => -1,
	'orderby' => 'date',
	'order' => 'DESC'
));

if ($query->have_posts()): // Check if there are any carousel posts
?>
	<section id="carousel">
		<div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">
			<div class="carousel-inner">
				<?php
				$count = 0;
				while ($query->have_posts()):
					$query->the_post();
					$image = get_the_post_thumbnail_url(get_the_ID(), 'full');
				?>
					<div class="carousel-item <?php echo ($count == 0) ? 'active' : ''; ?>">
						<img src="<?php echo esc_url($image); ?>" class="d-block w-100" alt="<?php the_title(); ?>">
						<div class="carousel-caption text-start d-md-block custom-caption">

						</div>
					</div>
				<?php $count++;
				endwhile; ?>
			</div>

			<button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</button>
		</div>
	</section>
<?php
endif; // End of if condition
wp_reset_postdata(); // Reset the post data
?>


<section id="center" class="center_home" style="
  <?php if (!empty($bg_image)) : ?>
    background-color: <?php echo esc_attr($bg_color_value); ?>;
    background-image: url('<?php echo esc_url($bg_image); ?>');
    background-repeat: <?php echo esc_attr($bg_color['background-repeat']); ?>;
    background-size: <?php echo esc_attr($bg_color['background-size']); ?>;
    background-attachment: <?php echo esc_attr($bg_color['background-attachment']); ?>;
    background-position: <?php echo esc_attr($bg_color['background-position']); ?>;
  <?php else : ?>
    background-color: <?php echo esc_attr($bg_color_value); ?>;
  <?php endif; ?>
">
	<div class="center_m bg_back">
		<div class="container-xl">
			<div class="row center_home1">
				<div class="col-md-8">
					<div class="center_home1_left text-center">
						<h1 class="usbdfont text-white"><?php echo $welcome_heading; ?></h1>
						<b class="text-white"><?php echo $welcome_subheading; ?></b>
					</div>
				</div>
				<div class="col-md-4">
					<div class="center_home1_right p-3 bg-white rounded-3">
						<!-- Text Above Search Form -->
						<h2 class="text-center mb-4 theme-text-color">Find Your Partner</h2>

						<!-- Search Form -->
						<form action="<?php echo site_url('/search-user/'); ?>" method="GET">
							<!-- Other Fields (2 Columns) -->
							<div class="row">
								<!-- Column 1 -->
								<div class="col-md-6">
									<b class="text-capitalize d-block font_13 mb-2">Country</b>
									<select id="country" name="country" class="form-select mb-3">
										<option value="" selected>All</option>
										<option value="bangladesh">Bangladesh</option>
										<option value="usa">USA</option>
									</select>

									<b class="text-capitalize d-block font_13 mb-2">Profession</b>
									<select id="profession" name="profession" class="form-select mb-3">
										<option value="">All</option>
										<option value="accountant">Accountant</option>
										<option value="architect">Architect</option>
										<option value="artist">Artist</option>
										<option value="banker">Banker</option>
										<option value="doctor">Doctor</option>
										<option value="engineer">Engineer</option>
										<option value="teacher">Teacher</option>
										<option value="web_developer">Web Developer</option>
									</select>

									<b class="text-capitalize d-block font_13 mb-2">Marital Status</b>
									<select id="marital_status" name="marital_status" class="form-select mb-3">
										<option value="" selected>All</option>
										<option value="Never Married">Single</option>
										<option value="Widowed">Widowed</option>
										<option value="Awaiting Divorce">Awaiting Divorce</option>
										<option value="Divorced">Divorced</option>
									</select>
								</div>

								<!-- Column 2 -->
								<div class="col-md-6">
									<b class="text-capitalize d-block font_13 mb-2">Looking For</b>
									<select id="lookingfor" name="looking_for" class="form-select mb-3">
										<option value="" selected>All</option>
										<option value="bride">Bride</option>
										<option value="groom">Groom</option>
									</select>

									<b class="text-capitalize d-block font_13 mb-2">Smoking Habits</b>
									<select id="smoking_status" name="smoking_status" class="form-select mb-3">
										<option value="" selected>All</option>
										<option value="Never">Never</option>
										<option value="Occasionally">Occasionally</option>
										<option value="Regularly">Regularly</option>
									</select>

									<b class="text-capitalize d-block font_13 mb-2">Drinking Status</b>
									<select id="drinking_status" name="drinking_status" class="form-select mb-3">
										<option value="" selected>All</option>
										<option value="Never">Never</option>
										<option value="Occasionally">Occasionally</option>
										<option value="Regularly">Regularly</option>
									</select>
								</div>
							</div>

							<!-- Search Button -->
							<button type="submit" class="btn theme-btn w-100 mt-3 text-white">Search</button>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
// Count all approved users
$approved_users = count(get_users([
	'meta_key' => 'approval_status',
	'meta_value' => 'approved',
	'number' => -1,
]));

// Count approved male users
$approved_males = count(get_users([
	'meta_query' => [
		[
			'key' => 'approval_status',
			'value' => 'approved',
			'compare' => '='
		],
		[
			'key' => 'user_gender',
			'value' => 'Male',
			'compare' => '='
		]
	],
	'number' => -1,
]));

// Count approved female users
$approved_females = count(get_users([
	'meta_query' => [
		[
			'key' => 'approval_status',
			'value' => 'approved',
			'compare' => '='
		],
		[
			'key' => 'user_gender',
			'value' => 'Female',
			'compare' => '='
		]
	],
	'number' => -1,
]));

// Count success stories (published)
$success_stories = wp_count_posts('success_story')->publish;
?>


<section id="exep" class="pt-4 pb-5">
	<div class="container-xl">
		<?php

		// Ensure ReduxFramework class exists, if you depend on Redux for setup
		if (! class_exists('ReduxFramework')) {
			// You might want a different fallback or error message if Redux is critical
			// for this section to display.
			// For now, it will just proceed with empty arrays/default values if Redux isn't active.
		}


		// Retrieve the entire option value directly from the WordPress database
		$theme_options = get_option($opt_name);

		// Ensure $theme_options is an array
		if (! is_array($theme_options)) {
			$theme_options = []; // Initialize as an empty array if not found or corrupted
		}

		// Get the main subtitle and title
		$benefits_subtitle = isset($theme_options['benefits_subtitle']) ? esc_html($theme_options['benefits_subtitle']) : 'Default Subtitle Here';
		$benefits_title    = isset($theme_options['benefits_title']) ? esc_html($theme_options['benefits_title']) : 'Default Heading Here';

		// Retrieve the components of the 'benefits_groups' repeater directly from $theme_options
		$benefits_icons        = isset($theme_options['icon']) && is_array($theme_options['icon']) ? $theme_options['icon'] : [];
		$benefits_titles       = isset($theme_options['title']) && is_array($theme_options['title']) ? $theme_options['title'] : [];
		$benefits_descriptions = isset($theme_options['description']) && is_array($theme_options['description']) ? $theme_options['description'] : [];

		$processed_benefits_groups = [];

		// Determine the number of repeater items by counting one of the sub-fields
		$num_groups = count($benefits_icons);

		if ($num_groups > 0) {
			for ($i = 0; $i < $num_groups; $i++) {
				$processed_benefits_groups[] = [
					'icon'        => isset($benefits_icons[$i]) ? $benefits_icons[$i] : '',
					'title'       => isset($benefits_titles[$i]) ? $benefits_titles[$i] : '',
					'description' => isset($benefits_descriptions[$i]) ? $benefits_descriptions[$i] : '',
				];
			}
		}

		?>

		<div class="exep_m bg-white p-4 shadow animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
			<div class="row exep_1 mb-4">
				<div class="col-md-12">
					<span class="text-uppercase text-muted d-block"><?php echo $benefits_subtitle; ?></span>
					<b class="d-block fs-3 mt-2"><?php echo $benefits_title; ?></span></b>
				</div>
			</div>
			<div class="row row-cols-1 row-cols-md-3 exep_2">
				<?php if (! empty($processed_benefits_groups)) : ?>
					<?php foreach ($processed_benefits_groups as $group) : ?>
						<div class="col">
							<div class="exep_2_left">
								<span class="font_50 theme-text-color">
									<i class="<?php echo esc_attr($group['icon']); ?>"></i>
								</span>
								<b class="d-block"><?php echo esc_html($group['title']); ?></b>
								<hr class="line">
								<p class="mb-0"><?php echo esc_html($group['description']); ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				<?php else : ?>
					<div class="col-12">
						<p>No benefit groups configured.</p>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 about_pg3 mt-5 border-top border-bottom animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
			<div class="col">
				<div class="about_pg3_left border-end py-4 px-3">
					<ul class="mb-0 d-flex">
						<li class="d-flex">
							<span
								class="d-inline-block text-center theme-bg text-white rounded-circle cont_icon me-3 fs-5"><i
									class="bi bi-heart"></i></span>
							<span class="flex-column lh-1">
								<b class="fs-1 d-block count" data-target="<?php echo esc_attr($success_stories); ?>">0</b>
								<span class="d-block text-uppercase text-muted mt-2 font_13">COUPLES PARED</span>
							</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="col">
				<div class="about_pg3_left border-end py-4 px-3">
					<ul class="mb-0 d-flex">
						<li class="d-flex">
							<span
								class="d-inline-block text-center theme-bg text-white rounded-circle cont_icon me-3 fs-5"><i
									class="bi bi-people"></i></span>
							<span class="flex-column lh-1">
								<b class="fs-1 d-block count" data-target="<?php echo esc_attr($approved_users); ?>">0</b>
								<span class="d-block text-uppercase text-muted mt-2 font_13">REGISTERED USERS</span>
							</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="col">
				<div class="about_pg3_left border-end py-4 px-3">
					<ul class="mb-0 d-flex">
						<li class="d-flex">
							<span
								class="d-inline-block text-center theme-bg text-white rounded-circle cont_icon me-3 fs-5"><i
									class="bi bi-gender-male"></i></span>
							<span class="flex-column lh-1">
								<b class="fs-1 d-block count" data-target="<?php echo esc_attr($approved_males); ?>">0</b>
								<span class="d-block text-uppercase text-muted mt-2 font_13">Mens</span>
							</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="col">
				<div class="about_pg3_left py-4 px-3">
					<ul class="mb-0 d-flex">
						<li class="d-flex">
							<span
								class="d-inline-block text-center theme-bg text-white rounded-circle cont_icon me-3 fs-5"><i
									class="bi bi-gender-female"></i></span>
							<span class="flex-column lh-1">
								<b class="fs-1 d-block count" data-target="<?php echo esc_attr($approved_females); ?>">0</b>
								<span class="d-block text-uppercase text-muted mt-2 font_13">WOMENS</span>
							</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="meet" class="pt-5 pb-5 bg_light">
	<div class="container-xl">
		<div class="row exep_1 mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
			<div class="col-md-12">
				<?php
				// Retrieve the theme options
				$settings = get_option('theme_admin_settings');

				// Get the subheading and heading
				$feature_subheading = isset($settings['feature_subheading']) ? esc_html($settings['feature_subheading']) : 'Meet from Home';
				$feature_heading = isset($settings['feature_heading']) ? esc_html($settings['feature_heading']) : 'Impress them Over the Distance';
				// $feature_detail_headings= $settings['feature_detail_heading'];
				// $feature_detail_text= $settings['feature_detail_text'];

				?>
				<span class="text-uppercase text-muted d-block"><?php echo $feature_subheading; ?></span>
				<b class="d-block fs-3 mt-2"><?php echo $feature_heading; ?></b>
			</div>
		</div>
		<div class="row  meet_1">
			<div class="col-md-7 animate__animated animate__fadeInLeft" style="animation-delay: 0.4s;">
				<div class="meet_1_left">
					<?php
					// Get the feature details heading and text from the settings
					$feature_detail_headings = isset($settings['feature_detail_heading']) ? $settings['feature_detail_heading'] : [];
					$feature_detail_texts    = isset($settings['feature_detail_text']) ? $settings['feature_detail_text'] : [];

					// Loop through the headings and text
					if (! empty($feature_detail_headings) && ! empty($feature_detail_texts)) :
						foreach ($feature_detail_headings as $index => $heading) :
							// Make sure both arrays have the same length
							if (isset($feature_detail_texts[$index])) :
					?>
								<b class="d-block fs-5"><?php echo esc_html($heading); ?></b>
								<hr class="line">
								<p class="mb-0 w-75"><?php echo esc_html($feature_detail_texts[$index]); ?></p>

					<?php
							endif;
						endforeach;
					endif;
					?>
				</div>
			</div>
			<?php
// Get the feature images array
$feature_images = $settings['feature_images'];

// Reset array keys to 0,1,2... for proper slide indexing
$images = array_values($feature_images);
?>

<div class="col-md-5 animate__animated animate__fadeInRight" style="animation-delay: 0.4s;">
    <div class="meet_1_right">
        <div id="carouselExampleCaptions1" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php foreach ($images as $i => $image): ?>
                    <button 
                        type="button" 
                        data-bs-target="#carouselExampleCaptions1" 
                        data-bs-slide-to="<?= $i ?>" 
                        <?= ($i === 0) ? 'class="active" aria-current="true"' : '' ?> 
                        aria-label="Slide <?= $i + 1 ?>"
                    ></button>
                <?php endforeach; ?>
            </div>
            <div class="carousel-inner">
                <?php foreach ($images as $i => $image): ?>
                    <div class="carousel-item <?= ($i === 0) ? 'active' : '' ?>">
                        <img 
                            src="<?= esc_url($image) ?>" 
                            class="img-fluid" 
                            alt="Feature image <?= $i + 1 ?>"
                        >
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
		</div>
	</div>
</section>


<section id="find" class="pt-5 pb-5">
	<div class="container-xl">
		<div class="row exep_1 mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.5s;">
			<div class="col-md-12">
				<span class="text-uppercase text-muted d-block">Three simple steps to</span>
				<b class="d-block fs-3 mt-2">Find the <span class="theme-text-color">One for You</span></b>
			</div>
		</div>
		<div class="row row-cols-1 row-cols-md-3 find_1">
			<div class="col animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
				<div class="find_1_left">
					<a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/image/5.jpg" class="img-fluid"
							alt="abc"></a>
					<b class="d-block d-flex mt-2"><span class="theme-text-color me-1">01.</span> Define Your Partner
						Preferences</b>

				</div>
			</div>
			<div class="col animate__animated animate__fadeInUp" style="animation-delay: 0.7s;">
				<div class="find_1_left">
					<a href="<?php echo esc_url(home_url('/search-user')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/image/6.jpg" class="img-fluid"
							alt="abc"></a>
					<b class="d-block d-flex mt-2"><span class="theme-text-color me-1">02.</span> Browse Profiles</b>
				</div>
			</div>
			<div class="col animate__animated animate__fadeInUp" style="animation-delay: 0.8s;">
				<div class="find_1_left">
					<a href="<?php echo esc_url(home_url('/search-user')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/image/7.jpg" class="img-fluid"
							alt="abc"></a>
					<b class="d-block d-flex mt-2"><span class="theme-text-color me-1">03.</span> Send Interests &
						Connect</b>
				</div>
			</div>
		</div>
		<div class="row find_2 text-center mt-4 animate__animated animate__fadeInUp" style="animation-delay: 0.9s;">
			<div class="col-md-12">
				<span class="d-block mt-3 text-center"><a class="button" href="<?php echo esc_url(home_url('/signup')); ?>">Get
						Started</a></span>
			</div>
		</div>
	</div>
</section>


<?php

// Ensure ReduxFramework class exists, if you depend on Redux for setup
if ( ! class_exists( 'ReduxFramework' ) ) {
    echo '<p>Theme options may not display correctly as Redux Framework class was not found.</p>';
}



// Ensure $theme_options is an array
if ( ! is_array( $theme_options ) ) {
    $theme_options = [];
}

// --- Retrieve Membership Plans section data ---
$membership_title       = isset( $theme_options['membership_title'] ) ? esc_html( $theme_options['membership_title'] ) : 'Membership Plans';
$membership_description = isset( $theme_options['membership_description'] ) ? esc_html( $theme_options['membership_description'] ) : 'Lorem ipsum dolor sit amet...';

// Retrieve the repeater's sub-fields directly from $theme_options (as siblings)
$features_list_names = isset( $theme_options['feature'] ) && is_array( $theme_options['feature'] ) ? $theme_options['feature'] : [];
$features_plan_selection = isset( $theme_options['plan_selection'] ) && is_array( $theme_options['plan_selection'] ) ? $theme_options['plan_selection'] : [];

// Retrieve page IDs and convert to URLs
$signup_button_page_id = isset( $theme_options['signup_button_page'] ) ? $theme_options['signup_button_page'] : '';
$signup_button_url = '';
if ( ! empty( $signup_button_page_id ) ) {
    $signup_button_url = get_permalink( $signup_button_page_id );
} else {
    // Fallback if no page is selected
    $signup_button_url = home_url( '/signup' ); // Or any default URL
}

$membership_target_page_id = isset( $theme_options['membership_target_page'] ) ? $theme_options['membership_target_page'] : '';
$membership_target_url = '';
if ( ! empty( $membership_target_page_id ) ) {
    $membership_target_url = get_permalink( $membership_target_page_id );
} else {
    // Fallback if no page is selected
    $membership_target_url = home_url( '/pricing' ); // Or any default URL
}


// --- Build the dynamic feature lists ---
$free_plan_features_html = '';
$paid_plan_features_html = '';

$num_features = count( $features_list_names );

if ( $num_features > 0 ) {
    for ( $i = 0; $i < $num_features; $i++ ) {
        $feature_name = isset( $features_list_names[$i] ) ? esc_html( $features_list_names[$i] ) : '';
        $plan_status  = isset( $features_plan_selection[$i] ) ? $features_plan_selection[$i] : [];

        // For Free Plan
        $is_free_available = isset( $plan_status['free'] ) && $plan_status['free'] === '1';
        $free_icon_class   = $is_free_available ? 'bi bi-check-circle fs-5 theme-text-color' : 'bi bi-x-circle fs-5';
        $free_text_class   = $is_free_available ? '' : 'text-muted';

        $free_plan_features_html .= '<li class="d-flex mt-2 ' . $free_text_class . '"><i class="' . $free_icon_class . ' align-middle me-2"></i> ' . $feature_name . '</li>';

        // For Paid Plan
        $is_paid_available = isset( $plan_status['paid'] ) && $plan_status['paid'] === '1';
        $paid_icon_class   = $is_paid_available ? 'bi bi-check-circle fs-5' : 'bi bi-x-circle fs-5'; // Note: Assuming paid plan checkmark is white, so no theme-text-color
        $paid_text_class   = $is_paid_available ? '' : 'text-muted'; // Though paid plan usually has all features

        $paid_plan_features_html .= '<li class="d-flex mt-2 ' . $paid_text_class . '"><i class="' . $paid_icon_class . ' align-middle me-2"></i> ' . $feature_name . '</li>';
    }
}

?>
<?php 
$enable_payment = intval(get_option('enable_payment', 1));
if($enable_payment){
 ?>
<section id="pricing" class="pt-5 pb-5 bg_light">
	<div class="container-xl">
		<div class="row pricing_1 mb-4 text-center animate__animated animate__fadeInUp" style="animation-delay: 1s;">
			<div class="col-md-12">
				<b class="d-block fs-3 mb-2"> <span class="theme-text-color"><?php echo $membership_title; ?></span> Plans</b>
				<p class="mb-0 w-75 mx-auto"><?php echo $membership_description; ?></p>
			</div>
		</div>
		<div class="row row-cols-1 row-cols-md-2 row-cols-sm-2 pricing_2 w-75 mx-auto">
			<div class="col p-0 animate__animated animate__fadeInUp" style="animation-delay: 1.1s;">
				<div class="pricing_2_left bg-white py-4 px-3 rounded_left pricing_2_lefto">
					<hr class="line">
					<b class="d-block fs-4 mb-3">Free</b>
					<ul>
						<?php
                        // The first li for "Browse Profiles" doesn't have mt-2 in original, handle this
                        // This assumes "Browse Profiles" is the first feature in your Redux setup
                        if (!empty($features_list_names[0]) && isset($features_plan_selection[0])) {
                            $feature_name_first = esc_html($features_list_names[0]);
                            $plan_status_first = $features_plan_selection[0];
                            $is_free_available_first = isset($plan_status_first['free']) && $plan_status_first['free'] === '1';
                            $free_icon_class_first = $is_free_available_first ? 'bi bi-check-circle fs-5 theme-text-color' : 'bi bi-x-circle fs-5';
                            $free_text_class_first = $is_free_available_first ? '' : 'text-muted';
                            echo '<li class="d-flex ' . $free_text_class_first . '"><i class="' . $free_icon_class_first . ' align-middle me-2"></i> ' . $feature_name_first . '</li>';

                            // Remove the first feature from the html string for the loop below
                            $free_plan_features_html = preg_replace('/^<li[^>]*>/', '', $free_plan_features_html); // Remove first <li> tag
                            $free_plan_features_html = substr($free_plan_features_html, strpos($free_plan_features_html, '</li>') + 5); // Remove its closing tag and content
                        }
                        ?>
						<?php echo $free_plan_features_html; ?>
					</ul>
					<span class="d-block mt-3 text-center"><a class="d-block button"
							href="<?php echo esc_url($signup_button_url); ?>">Register Free</a></span>
				</div>
			</div>
			<div class="col p-0 animate__animated animate__fadeInUp" style="animation-delay: 1.2s;">
				<div class="pricing_2_left theme-bg py-4 px-3 rounded_right">
					<hr class="line bg-white">
					<b class="d-block fs-4 mb-3 text-white">Paid</b>
					<ul class="text-white">
						<?php
                        // The first li for "Browse Profiles" doesn't have mt-2 in original, handle this for Paid too
                        if (!empty($features_list_names[0]) && isset($features_plan_selection[0])) {
                            $feature_name_first = esc_html($features_list_names[0]);
                            $plan_status_first = $features_plan_selection[0];
                            $is_paid_available_first = isset($plan_status_first['paid']) && $plan_status_first['paid'] === '1';
                            $paid_icon_class_first = $is_paid_available_first ? 'bi bi-check-circle fs-5' : 'bi bi-x-circle fs-5';
                            $paid_text_class_first = $is_paid_available_first ? '' : 'text-muted';
                            echo '<li class="d-flex ' . $paid_text_class_first . '"><i class="' . $paid_icon_class_first . ' align-middle me-2"></i> ' . $feature_name_first . '</li>';

                            // Remove the first feature from the html string for the loop below
                            $paid_plan_features_html = preg_replace('/^<li[^>]*>/', '', $paid_plan_features_html); // Remove first <li> tag
                            $paid_plan_features_html = substr($paid_plan_features_html, strpos($paid_plan_features_html, '</li>') + 5); // Remove its closing tag and content
                        }
                        ?>
						<?php echo $paid_plan_features_html; ?>
					</ul>
					<span class="d-block mt-3 text-center"><a class="d-block button bg-white theme-text-color"
							href="<?php echo esc_url($membership_target_url); ?>">Browse Membership Plans</a></span>
				</div>
			</div>
		</div>
	</div>
</section>
<?php } ?>

<section id="match" class="pt-5 pb-5">
	<div class="container-xl">
		<div class="row exep_1 mb-4 text-center">
			<div class="col-md-12 animate__animated animate__fadeInUp" style="animation-delay: 1.3s;">
				<span class="text-uppercase text-muted d-block">PERSONALISED MATCH-MAKING SERVICE</span>
				<b class="d-block fs-3 mt-2 mb-3">Introducing <span class="theme-text-color">Exclusive</span></b>
				<span
					class="d-inline-block theme-bg text-white py-2 px-3 font_14 text-uppercase rounded-3 mb-4">Exclusive</span><br>
					<?php
			$args = array(
				'post_type' => 'success_story',
				'posts_per_page' => 1, // Number of stories to display
			);

			$success_stories = new WP_Query($args);

			if ($success_stories->have_posts()):
				while ($success_stories->have_posts()):
					$success_stories->the_post();
			?>
				<div class="news_1_left2_inner position-relative w-75 mx-auto animate__animated animate__fadeInUp" style="animation-delay: 1.4s;">
					<div class="news_1_left2_inner1">
						<a href="<?php the_permalink(); ?>"><img src="<?php if (has_post_thumbnail()) {
													echo get_the_post_thumbnail_url(get_the_ID(), 'full');
												} else {
													echo 'https://placehold.co/420x280?text=Add+Image';
												} ?>" class="img-fluid"
								alt="abc"></a>
					</div>
					<div class="news_1_left2_inner2 position-absolute bottom-0 px-4 bg_back w-100 mx-auto p-3">
						<ul class="mb-0">
							<li class="d-flex">
								<span class="flex-column">
									<b
										class="d-inline-block theme-bg text-white p-1 px-3 font_12 text-uppercase rounded-1">Relationship</b>
									<b class="d-block fs-4  mt-2 mb-2"><a class="text-white" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></b>
									<p class="text-light  mt-3"><?php
echo wp_trim_words( get_the_content(), 40, '...' );
?></p>
									<span class="text-light font_12  text-uppercase">
										<i class="bi bi-calendar me-1 theme-text-color align-middle"></i> <?php echo get_the_date('M d, Y'); ?>
										
									</span>
								</span>
							</li>
						</ul>
					</div>
				</div>
				<?php
				endwhile;
				wp_reset_postdata();
			else:
				echo '<p>No success stories found.</p>';
			endif;
			?>
			</div>
		</div>
		<?php

// Ensure ReduxFramework class exists, if you depend on Redux for setup
if ( ! class_exists( 'ReduxFramework' ) ) {
    echo '<p>Theme options may not display correctly as Redux Framework class was not found.</p>';
}

// Ensure $theme_options is an array
if ( ! is_array( $theme_options ) ) {
    $theme_options = [];
}

// --- Retrieve Introduc Section data ---
// The repeater ID is 'introduc_repeater', but the *fields* within it are directly under $theme_options
$introduc_icons        = isset( $theme_options['introduc_icon'] ) && is_array( $theme_options['introduc_icon'] ) ? $theme_options['introduc_icon'] : [];
$introduc_titles       = isset( $theme_options['introduc_title'] ) && is_array( $theme_options['introduc_title'] ) ? $theme_options['introduc_title'] : [];
$introduc_descriptions = isset( $theme_options['introduc_description'] ) && is_array( $theme_options['introduc_description'] ) ? $theme_options['introduc_description'] : [];


// --- Prepare HTML output ---
$html_output = '';

$num_groups = count( $introduc_icons ); // Since limit is 3, this will be at most 3

if ( $num_groups > 0 ) {
    $html_output .= '<div class="row row-cols-1 row-cols-md-3 match_1 w-75 mx-auto animate__animated animate__fadeInUp" style="animation-delay: 1.5s;">';
    for ( $i = 0; $i < $num_groups; $i++ ) {
        $icon        = isset( $introduc_icons[$i] ) ? esc_attr( $introduc_icons[$i] ) : '';
        $title       = isset( $introduc_titles[$i] ) ? esc_html( $introduc_titles[$i] ) : '';
        $description = isset( $introduc_descriptions[$i] ) ? esc_html( $introduc_descriptions[$i] ) : '';

        $html_output .= '<div class="col">';
        $html_output .= '<div class="match_1_left">';
        $html_output .= '<b class="d-flex"><i class="' . $icon . ' me-2 fs-5 theme-text-color"></i>' . $title . '</b>';
        $html_output .= '<hr class="line">';
        $html_output .= '<p class="mb-0">' . $description . '</p>';
        $html_output .= '</div>';
        $html_output .= '</div>';
    }
    $html_output .= '</div>';
} else {
    $html_output .= '<p>No "Introduc Section" data found.</p>'; // Handle the case where no data is set
}

echo $html_output;

?>

	</div>
</section>


<section id="couple" class="pt-5 pb-5 bg_light animate__animated animate__fadeInUp" style="animation-delay: 1.6s;">
	<div class="container-xl">
		<div class="row exep_1 mb-4">
			<div class="col-md-12">
				<span class="text-uppercase text-muted d-block">HUNDREDS OF HAPPY COUPLES</span>
				<b class="d-block fs-3 mt-2">Matched by <span class="theme-text-color">Matrimonials</span></b>
			</div>
		</div>

		<!-- Slider Container -->
		<div class="couple-slider">

			<?php
			$args = array(
				'post_type' => 'success_story',
				'posts_per_page' => 10, // Number of stories to display
			);

			$success_stories = new WP_Query($args);

			if ($success_stories->have_posts()):
				while ($success_stories->have_posts()):
					$success_stories->the_post();
			?>

					<!-- Slide 1 -->
					<div class="couple-slide">
						<div class="couple_1_left position-relative">
							<div class="couple_1_left1">
								<a href="<?php the_permalink(); ?>"><img
										src="<?php if (has_post_thumbnail()) {
													echo get_the_post_thumbnail_url(get_the_ID(), 'full');
												} else {
													echo 'https://placehold.co/420x280?text=Add+Image';
												} ?>"
										class="img-fluid" alt="abc"></a>
							</div>
							<div class="couple_1_left2 position-absolute bg_back w-100 h-100 px-3 text-center top-0">
								<b class="fst-italic d-block fs-3 text-white"><?php the_title(); ?></b>
								<hr class="bg-white w-100 line_1 mt-1 mb-1">
								<?php $marriage_date = get_post_meta(get_the_ID(), '_marriage_date', true);
								$formatted_date = date('j F, Y', strtotime($marriage_date));
								?>
								<span class="font_13 text-uppercase text-white">Marriage Date
									<?php echo $formatted_date; ?></span>
							</div>
							<div class="couple_1_left3 position-absolute top-0 bg_back w-100 h-100 p-3">
								<p class="mb-0 text-white"><?php echo wp_strip_all_tags(get_the_content()); ?></p>
								<span class="d-block mt-3"><a class="button" href="<?php the_permalink(); ?>">View More <i
											class="bi bi-arrow-right ms-2"></i></a></span>
							</div>
						</div>
					</div>
			<?php
				endwhile;
				wp_reset_postdata();
			else:
				echo '<p>No success stories found.</p>';
			endif;
			?>
		</div>
	</div>
</section>

<?php usabdlp_render_profile_tabs(); ?>

<section id="about" class="pt-5 pb-5 bg_light animate__animated animate__fadeInUp" style="animation-delay: 1.7s;">
	<div class="container-xl">
		<div class="row about_1">
			<div class="col-md-12">
				<b class="fs-3 d-block"><i class="bi bi-arrow-through-heart theme-text-color me-1 align-middle"></i>
					USALifepartner.Com</b>
					<?php 
    // Assuming $opt_name is already defined


    // Retrieve the entire option value
    $theme_options = get_option( $opt_name );

    // Ensure $theme_options is an array
    if ( ! is_array( $theme_options ) ) {
        $theme_options = [];
    }

    // --- Retrieve About Section data ---
    // Use wp_kses_post() to allow safe HTML tags to be rendered
    $about_content = isset( $theme_options['about_site'] ) ? wp_kses_post( $theme_options['about_site'] ) : 'Default About content here. You can add <strong>strong tags</strong> or other basic HTML.'; 

    // Output the content with HTML tags preserved
    if( !empty($about_content)) {
        echo '<p class="mb-0">' . $about_content . '</p>';
    } else {
        echo '<p class="mb-0">Default about text here.</p>';
    }
?>

			</div>
		</div>

	</div>
</section>

<?php get_footer(); ?>