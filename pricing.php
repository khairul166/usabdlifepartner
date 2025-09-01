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
 * Template Name: Pricing
 */

get_header(); ?>

<section id="center" class="center_price pt-4 theme-bg">
	<div class="container-xl">
		<div class="row center_price1 text-center">
			<div class="col-md-12">
				<b class="text-white">PRICING</b>
				<h1 class="mt-3 text-white">Get Started <br>
					Pick your Plan Now</h1>
				<p class="mt-3 text-white">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
				<span class="d-inline-block bg_blue text-white rounded-pill py-2 px-3 font_14">No credit card required</span>
			</div>
		</div>
	</div>
</section>


<section id="price" class="pb-5">
	<div class="container-xl">
		<div class="row row-cols-1 row-cols-md-3 price_1">
			<?php
			global $wpdb;
			$table = $wpdb->prefix . 'membership_plans';
			$plans = $wpdb->get_results("SELECT * FROM $table ORDER BY price ASC");
			?>

			<?php foreach ($plans as $index => $plan): ?>
				<div class="col">
					<div class="price_1_left shadow bg-white py-5 px-4 rounded_30 text-center mt-5 animate__animated animate__fadeInUp" style="animation-delay: <?php echo ($index * 0.1) ?>s;">
						<?php if ($index === 1): // Highlight second plan as "Most popular" 
						?>
							<span class="d-inline-block bg-danger text-white rounded-pill py-2 px-3 font_14 mb-3">Most popular plan</span>
						<?php endif; ?>

						<b class="d-block fs-4"><?php echo esc_html($plan->name); ?></b>
						<p class="mt-2">Best for your needs</p>

						<span class="d-block text-center">
						<a class="button w-75 mx-auto" href="<?php echo site_url('/signup?plan=' . $plan->id); ?>">Get Started</a>

						</span>

						<b class="fs-3 d-block mt-3">$<?php echo esc_html($plan->price); ?><span class="text-muted fw-normal">/mo</span></b>

						<ul class="mt-3 font_14 text-start px-4 mb-0">
							<li>
								<i class="bi <?php echo ($plan->premium_views > 0) ? 'bi-check bg-success' : 'bi-x theme-bg'; ?> price_icon rounded-circle text-white text-center d-inline-block fw-bold me-2"></i>
								<?php echo $plan->premium_views > 0 ? esc_html($plan->premium_views) . ' Premium Profiles view /mo' : 'Premium Profiles view /mo'; ?>
							</li>

							<li class="mt-2">
								<i class="bi <?php echo $plan->can_view_profiles ? 'bi-check bg-success' : 'bi-x theme-bg'; ?> price_icon rounded-circle text-white text-center d-inline-block fw-bold me-2"></i>
								Free user profile can view
							</li>

							<li class="mt-2">
								<i class="bi <?php echo $plan->can_view_contact ? 'bi-check bg-success' : 'bi-x theme-bg'; ?> price_icon rounded-circle text-white text-center d-inline-block fw-bold me-2"></i>
								View contact details
							</li>

							<li class="mt-2">
								<i class="bi <?php echo $plan->can_send_interest ? 'bi-check bg-success' : 'bi-x theme-bg'; ?> price_icon rounded-circle text-white text-center d-inline-block fw-bold me-2"></i>
								Send interest
							</li>

							<li class="mt-2">
								<i class="bi <?php echo $plan->can_start_chat ? 'bi-check bg-success' : 'bi-x theme-bg'; ?> price_icon rounded-circle text-white text-center d-inline-block fw-bold me-2"></i>
								Start Chat
							</li>
						</ul>
					</div>
				</div>
			<?php endforeach; ?>

		</div>
	</div>
</section>




<?php get_footer(); ?>