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
					<?php $count++; endwhile; ?>
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


<section id="center" class="center_home">
	<div class="center_m bg_back">
		<div class="container-xl">
			<div class="row center_home1">
				<div class="col-md-8">
					<div class="center_home1_left text-center">
						<h1 class="font_50 text-white">Welcome to USABDLifepartner</h1>
						<b class="text-white">Finding your perfect match just became easier</b>
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
		<div class="exep_m bg-white p-4 shadow">
			<div class="row exep_1 mb-4">
				<div class="col-md-12">
					<span class="text-uppercase text-muted d-block">More Than 25 years of</span>
					<b class="d-block fs-3 mt-2">Bringing People <span class="theme-text-color">Together</span></b>
				</div>
			</div>
			<div class="row row-cols-1 row-cols-md-3 exep_2">
				<div class="col">
					<div class="exep_2_left">
						<span class="font_50 theme-text-color"><i class="bi bi-person-circle
"></i></span>
						<b class="d-block">100% Screened Profiles</b>
						<hr class="line">
						<p class="mb-0">Lorem Ipsum Dolor Nec Zril Timeam In. Omnes Nostro Virtute Qui Te, Sed Ex
							Oblique Labitur. </p>
					</div>
				</div>
				<div class="col">
					<div class="exep_2_left">
						<span class="font_50 theme-text-color"><i class="bi bi-shield-check
"></i></span>
						<b class="d-block">Verifications by Personal Visit</b>
						<hr class="line">
						<p class="mb-0">Lorem Ipsum Dolor Nec Zril Timeam In. Omnes Nostro Virtute Qui Te, Sed Ex
							Oblique Labitur. </p>
					</div>
				</div>
				<div class="col">
					<div class="exep_2_left">
						<span class="font_50 theme-text-color"><i class="bi bi-lock
"></i></span>
						<b class="d-block">Control over Privacy</b>
						<hr class="line">
						<p class="mb-0">Lorem Ipsum Dolor Nec Zril Timeam In. Omnes Nostro Virtute Qui Te, Sed Ex
							Oblique Labitur. </p>
					</div>
				</div>
			</div>
		</div>
		<div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 about_pg3 mt-5 border-top border-bottom">
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
		<div class="row exep_1 mb-4">
			<div class="col-md-12">
				<span class="text-uppercase text-muted d-block">Meet from home</span>
				<b class="d-block fs-3 mt-2">Impress them Over the <span class="theme-text-color">Distance</span></b>
			</div>
		</div>
		<div class="row  meet_1">
			<div class="col-md-7">
				<div class="meet_1_left">
					<b class="d-block fs-5">Jeevansathi Match Hour</b>
					<hr class="line">
					<p class="mb-0 w-75">Ne Mei Sanctus Laoreet, Mel Ne Tollit Nominavi, Graece Utamur Ea Has. Cu Inani
						Intellegam Mel, Ne Pri Audiam Urbanitas Accommodare.Per Ex Facer Ornatus Delenit. </p>
					<b class="d-block fs-5 mt-4">Voice & Video Calling</b>
					<hr class="line">
					<p class="mb-0 w-75">Ne Mei Sanctus Laoreet, Mel Ne Tollit Nominavi, Graece Utamur Ea Has. Cu Inani
						Intellegam Mel, Ne Pri Audiam Urbanitas Accommodare.Per Ex Facer Ornatus Delenit. </p>
					<b class="d-block fs-5 mt-4">Introducing Video Profiles</b>
					<hr class="line">
					<p class="mb-0 w-75">Ne Mei Sanctus Laoreet, Mel Ne Tollit Nominavi, Graece Utamur Ea Has. Cu Inani
						Intellegam Mel, Ne Pri Audiam Urbanitas Accommodare.Per Ex Facer Ornatus Delenit. </p>
				</div>
			</div>
			<div class="col-md-5">
				<div class="meet_1_right">
					<div id="carouselExampleCaptions1" class="carousel slide" data-bs-ride="carousel">
						<div class="carousel-indicators">
							<button type="button" data-bs-target="#carouselExampleCaptions1" data-bs-slide-to="0"
								class="active" aria-label="Slide 1" aria-current="true"></button>
							<button type="button" data-bs-target="#carouselExampleCaptions1" data-bs-slide-to="1"
								aria-label="Slide 2" class=""></button>
							<button type="button" data-bs-target="#carouselExampleCaptions1" data-bs-slide-to="1"
								aria-label="Slide 3" class=""></button>
						</div>
						<div class="carousel-inner">
							<div class="carousel-item active">
								<img src="<?php echo get_template_directory_uri(); ?>/image/2.jpg" class="img-fluid"
									alt="abc">
							</div>
							<div class="carousel-item">
								<img src="<?php echo get_template_directory_uri(); ?>/image/3.jpg" class="img-fluid"
									alt="abc">
							</div>
							<div class="carousel-item">
								<img src="<?php echo get_template_directory_uri(); ?>/image/4.jpg" class="img-fluid"
									alt="abc">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="find" class="pt-5 pb-5">
	<div class="container-xl">
		<div class="row exep_1 mb-4">
			<div class="col-md-12">
				<span class="text-uppercase text-muted d-block">Three simple steps to</span>
				<b class="d-block fs-3 mt-2">Find the <span class="theme-text-color">One for You</span></b>
			</div>
		</div>
		<div class="row row-cols-1 row-cols-md-3 find_1">
			<div class="col">
				<div class="find_1_left">
					<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/image/5.jpg" class="img-fluid"
							alt="abc"></a>
					<b class="d-block d-flex mt-2"><span class="theme-text-color me-1">01.</span> Define Your Partner
						Preferences</b>

				</div>
			</div>
			<div class="col">
				<div class="find_1_left">
					<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/image/6.jpg" class="img-fluid"
							alt="abc"></a>
					<b class="d-block d-flex mt-2"><span class="theme-text-color me-1">02.</span> Browse Profiles</b>
				</div>
			</div>
			<div class="col">
				<div class="find_1_left">
					<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/image/7.jpg" class="img-fluid"
							alt="abc"></a>
					<b class="d-block d-flex mt-2"><span class="theme-text-color me-1">03.</span> Send Interests &
						Connect</b>
				</div>
			</div>
		</div>
		<div class="row find_2 text-center mt-4">
			<div class="col-md-12">
				<span class="d-block mt-3 text-center"><a class="button" href="<?php echo wp_registration_url(); ?>">Get
						Started</a></span>
			</div>
		</div>
	</div>
</section>

<section id="pricing" class="pt-5 pb-5 bg_light">
	<div class="container-xl">
		<div class="row pricing_1 mb-4 text-center">
			<div class="col-md-12">
				<b class="d-block fs-3 mb-2"> <span class="theme-text-color">Membership</span> Plans</b>
				<p class="mb-0 w-75 mx-auto">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
					exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
			</div>
		</div>
		<div class="row row-cols-1 row-cols-md-2 row-cols-sm-2 pricing_2 w-75 mx-auto">
			<div class="col p-0">
				<div class="pricing_2_left bg-white py-4 px-3  rounded_left pricing_2_lefto">
					<hr class="line">
					<b class="d-block fs-4 mb-3">Free</b>
					<ul>
						<li class="d-flex"><i class="bi bi-check-circle fs-5 theme-text-color align-middle me-2"></i>
							Browse Profiles</li>
						<li class="d-flex mt-2"><i
								class="bi bi-check-circle fs-5 theme-text-color align-middle me-2"></i> Shortlist & Send
							Interest</li>
						<li class="d-flex mt-2"><i
								class="bi bi-check-circle fs-5 theme-text-color align-middle me-2"></i> Message & chat
							with unlimited users</li>
						<li class="d-flex mt-2 text-muted"><i class="bi bi-x-circle fs-5  align-middle me-2"></i> Get up
							to 3x more matches daily</li>
						<li class="d-flex mt-2 text-muted"><i class="bi bi-x-circle fs-5  align-middle me-2"></i> Unlock
							access to advanced search</li>
						<li class="d-flex mt-2 text-muted"><i class="bi bi-x-circle fs-5  align-middle me-2"></i> View
							contact details</li>
						<li class="d-flex mt-2 text-muted"><i class="bi bi-x-circle fs-5  align-middle me-2"></i> Make
							unlimited voice and video calls</li>
						<li class="d-flex mt-2 text-muted"><i class="bi bi-x-circle fs-5  align-middle me-2"></i> Get 3
							free Spotlights</li>
					</ul>
					<span class="d-block mt-3 text-center"><a class="d-block button"
							href="<?php echo esc_url(home_url('/signup')); ?>">Register Free</a></span>
				</div>
			</div>
			<div class="col p-0">
				<div class="pricing_2_left theme-bg py-4 px-3 rounded_right">
					<hr class="line bg-white">
					<b class="d-block fs-4 mb-3 text-white">Paid</b>
					<ul class="text-white">
						<li class="d-flex"><i class="bi bi-check-circle fs-5  align-middle me-2"></i> Browse Profiles
						</li>
						<li class="d-flex mt-2"><i class="bi bi-check-circle fs-5 align-middle me-2"></i> Shortlist &
							Send Interest</li>
						<li class="d-flex mt-2"><i class="bi bi-check-circle fs-5  align-middle me-2"></i> Message &
							chat with unlimited users</li>
						<li class="d-flex mt-2"><i class="bi bi-check-circle fs-5  align-middle me-2"></i> Get up to 3x
							more matches daily</li>
						<li class="d-flex mt-2"><i class="bi bi-check-circle fs-5  align-middle me-2"></i> Unlock access
							to advanced search</li>
						<li class="d-flex mt-2"><i class="bi bi-check-circle fs-5  align-middle me-2"></i> View contact
							details</li>
						<li class="d-flex mt-2"><i class="bi bi-check-circle fs-5  align-middle me-2"></i> Make
							unlimited voice and video calls</li>
						<li class="d-flex mt-2"><i class="bi bi-check-circle fs-5  align-middle me-2"></i> Get 3 free
							Spotlights</li>
					</ul>
					<span class="d-block mt-3 text-center"><a class="d-block button bg-white theme-text-color"
							href="#">Browse Membership Plans</a></span>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="match" class="pt-5 pb-5">
	<div class="container-xl">
		<div class="row exep_1 mb-4 text-center">
			<div class="col-md-12">
				<span class="text-uppercase text-muted d-block">PERSONALISED MATCH-MAKING SERVICE</span>
				<b class="d-block fs-3 mt-2 mb-3">Introducing <span class="theme-text-color">Exclusive</span></b>
				<span
					class="d-inline-block theme-bg text-white py-2 px-3 font_14 text-uppercase rounded-3 mb-4">Exclusive</span><br>
				<div class="news_1_left2_inner position-relative w-75 mx-auto">
					<div class="news_1_left2_inner1">
						<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/image/8.jpg" class="img-fluid"
								alt="abc"></a>
					</div>
					<div class="news_1_left2_inner2 position-absolute bottom-0 px-4 bg_back w-100 mx-auto p-3">
						<ul class="mb-0">
							<li class="d-flex">
								<span class="flex-column">
									<b
										class="d-inline-block theme-bg text-white p-1 px-3 font_12 text-uppercase rounded-1">Relationship</b>
									<b class="d-block fs-4  mt-2 mb-2"><a class="text-white" href="#">Vivamus minim nemo
											<span class="theme-text-color">rem quos
												voluptatibus</span> gravida lobortis</a></b>
									<p class="text-light  mt-3">Vestibulum quis odio ut dui malesuada ornare ut id
										tellus. Curabitur viverra at magna ac bibendum. Aliquam erat volutpat. Proin
										rhoncus est ac ipsum varius fermentum. Integer a odio ornare mauris pharetra
										suscipitot. Integer vulputate elit erat. Vestibulum quam velit, sagittis et
										ipsum id.</p>
									<span class="text-light font_12  text-uppercase">
										<i class="bi bi-calendar me-1 theme-text-color align-middle"></i> Aug 16, 2016
										<i class="bi bi-heart me-1 theme-text-color ms-2 align-middle"></i> 12
									</span>
								</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row row-cols-1 row-cols-md-3 match_1 w-75 mx-auto">
			<div class="col">
				<div class="match_1_left">
					<b class="d-flex"><i class="bi bi-person-circle me-2 fs-5 theme-text-color
"></i> Meet Your Relationship Manager</b>
					<hr class="line">
					<p class="mb-0">Connect with our highly experienced advisor who manages your profile.</p>
				</div>
			</div>
			<div class="col">
				<div class="match_1_left">
					<b class="d-flex"><i class="bi bi-sliders2 me-2 fs-5  theme-text-color
"></i> Meet Your Relationship Manager</b>
					<hr class="line">
					<p class="mb-0">Consultation to understand your expectations in a prospective partner.</p>
				</div>
			</div>
			<div class="col">
				<div class="match_1_left">
					<b class="d-flex"><i class="bi bi-person-check me-2 fs-5  theme-text-color
"></i> Choose from handpicked profiles</b>
					<hr class="line">
					<p class="mb-0">Connect with our highly experienced advisor who manages your profile.</p>
				</div>
			</div>
		</div>
	</div>
</section>


<section id="couple" class="pt-5 pb-5 bg_light">
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


<!-- <section id="profile" class="pt-5 pb-5">
	<div class="container-xl">
		<div class="row exep_1 mb-4 text-center">
			<div class="col-md-12">
				<span class="text-uppercase text-muted d-block">Browse</span>
				<b class="d-block fs-3 mt-2">Profiles by <span class="theme-text-color">Matrimonials</span></b>
			</div>
		</div>
		<div class="row profile_1">
			<div class="col-md-12">
				<ul class="nav nav-tabs mb-0  flex-wrap font_15 justify-content-center border-0 tab_click">
					<li class="nav-item">
						<a href="#profile1" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
							<span class="d-md-block">Mother Tongue</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="#profile3" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
							<span class="d-md-block">Religion</span>
						</a>
					</li>

					<li class="nav-item">
						<a href="#profile4" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
							<span class="d-md-block">City</span>
						</a>
					</li>

					<li class="nav-item">
						<a href="#profile5" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
							<span class="d-md-block">Occupation</span>
						</a>
					</li>


				</ul>
				<div class="tab-content mt-4">

					<div class="tab-pane active" id="profile1">
						<div class="profile1_inner">
							<ul class="mb-0 d-flex flex-wrap justify-content-center">
								<li><a href="#">Bihari</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Bengali</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Gujarati</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Hindi</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Kannada</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Malayalam</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Marathi</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Oriya</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Punjabi</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Rajasthani</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Tamil</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Telugu</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Konkani</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Haryanvi</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Kashmiri</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Nepali</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Assamese</a></li>
								<li class="text-muted mx-3">|</li>
							</ul>
						</div>
					</div>

					<div class="tab-pane" id="profile3">
						<div class="profile1_inner">
							<ul class="mb-0 d-flex flex-wrap justify-content-center">
								<li><a href="#">Hindu</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Muslim</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Christian</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Sikh</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Buddhist</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Jain</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Bahai</a></li>

							</ul>
						</div>

					</div>

					<div class="tab-pane" id="profile4">
						<div class="profile1_inner">
							<ul class="mb-0 d-flex flex-wrap justify-content-center">
								<li><a href="#">Kanpur</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Lucknow</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Mumbai</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Delhi</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Agra</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Nagpur</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Ludhiana</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Jaipur</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Noida</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Patna</a></li>
							</ul>
						</div>

					</div>

					<div class="tab-pane" id="profile5">
						<div class="profile1_inner">
							<ul class="mb-0 d-flex flex-wrap justify-content-center">
								<li><a href="#">Businessman</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Teacher</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">IT Software</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Police</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Doctor</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Nurse</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">IAS</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">PCS</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Ngo</a></li>
								<li class="text-muted mx-3">|</li>
								<li><a href="#">Engineers</a></li>
							</ul>
						</div>

					</div>




				</div>
			</div>
		</div>
	</div>
</section> -->
<?php usabdlp_render_profile_tabs(); ?>

<section id="about" class="pt-5 pb-5 bg_light">
	<div class="container-xl">
		<div class="row about_1">
			<div class="col-md-12">
				<b class="fs-3 d-block"><i class="bi bi-arrow-through-heart theme-text-color me-1 align-middle"></i>
					USALifepartner.Com</b>
				<p class="mt-3">USALifepartner.com, established on February 1st, 2025, is the largest matrimonial
					platform in USA & Bangladesh, operating under a prominent corporate entity. Its mission is to cater
					to the matrimonial needs of Bangladeshis & USA worldwide, offering a secure and confidential
					environment. The platform is dedicated to providing professional matchmaking services, connecting
					individuals with genuine prospects who are earnestly seeking life partners.
				</p>
				USALifepartner.com empowers its members to search, communicate, and engage with potential matches,
				facilitating the journey to finding the right life partner for themselves or their loved ones. We firmly
				believe in the sanctity of marriage and strive to fulfill the aspirations of those seeking their
				soulmates. USALifepartner.com is designed to serve both the present and future generations, offering a
				contemporary approach to arranged marriages.
			</div>
		</div>

	</div>
</section>

<?php get_footer(); ?>