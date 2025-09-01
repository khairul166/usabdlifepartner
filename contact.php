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
 * Template Name: Contact Us
 */

get_header(); 

$phone = get_theme_mod('contact_phone', '+1 234 567 890');
$email = get_theme_mod('contact_email', 'info@yourdomain.com');
$address = get_theme_mod('contact_address', '2548 Heverly United States');

$opt_name = 'theme_admin_settings';
$theme_options = get_option($opt_name);
$contact_us_top_text = $theme_options['contact_us_top_text'] ?? [];
$contact_us_heading_text = $theme_options['contact_us_heading_text'] ?? [];
$contact_us_subheading_text = $theme_options['contact_us_subheading_text'] ?? [];

$contact_features_icon = $theme_options['contact_features_icon'] ?? [];
$contact_features_title = $theme_options['contact_features_title'] ?? [];
$contact_features_description = $theme_options['contact_features_description'] ?? [];
$contact_features_link = $theme_options['contact_features_link'] ?? [];
$contact_us_features = [];
$count = count($contact_features_icon);
for ($i = 0; $i < $count; $i++) {
	$contact_us_features[] = [
		'contact_features_icon'         => $contact_features_icon[$i] ?? '',
		'contact_features_title'  => $contact_features_title[$i] ?? '',
		'contact_features_description' => $contact_features_description[$i] ?? '',
		'contact_features_link' => $contact_features_link[$i] ?? '',
	];
}

$contact_left_side_heading = $theme_options['contact_left_side_heading'] ?? [];
$contact_left_side_image = $theme_options['contact_left_side_image'] ?? [];
$contact_left_side_text = $theme_options['contact_left_side_text'] ?? [];
$google_maps_link = $theme_options['google_maps_link'] ?? [];
					?>

<section id="center" class="center_about pt-4 theme-bg">
   <div class="container-xl">
    <div class="row center_price1 text-center">
      <div class="col-md-12">
        <b class="fs-5 d-block mb-3 text-warning animate__animated animate__fadeInDown">
          <?php echo $contact_us_top_text; ?>
        </b>
        <h1 class="text-white font_50 animate__animated animate__fadeInDown" style="animation-delay: 0.2s;">
          <?php echo $contact_us_heading_text; ?>
        </h1>
        <p class="mt-3 text-white mb-0 fs-5 animate__animated animate__fadeInDown" style="animation-delay: 0.4s;">
          <?php echo $contact_us_subheading_text; ?>
        </p>
      </div>
    </div>
   </div>
</section>


 
 <section id="about_pg" class="pb-5">
   <div class="container-xl">
    <div class="row row-cols-1 row-cols-md-3 contact_1">
	  <div class="col animate__animated animate__fadeInUp">
	    <div class="about_pg1_left shadow bg-white p-4 rounded-3">
		   <b class="fs-4">OUR OFFICE</b>
		   <p class="mt-3">Most Trusted and premium Matrimony Service in the World.</p>
		   <ul class="mb-0">
		    <li class="d-flex">
			  <span class="d-inline-block text-center bg_blue text-white rounded-circle cont_icon me-3"><i class="bi bi-telephone"></i></span>
			   <span class="d-block text-muted mt-2"><?php echo $phone; ?></span>
			 </li>
			 <li class="d-flex mt-2">
			  <span class="d-inline-block text-center bg_blue text-white rounded-circle cont_icon me-3"><i class="bi bi-envelope"></i></span>
			   <span class="d-block text-muted mt-2"><?php echo $email; ?></span>
			 </li>
			 <li class="d-flex mt-2">
			  <span class="d-inline-block text-center bg_blue text-white rounded-circle cont_icon me-3"><i class="bi bi-map"></i></span>
			   <span class="d-block text-muted mt-2"><?php echo $address; ?></span>
			 </li>
		   </ul>
		</div>  
	  </div>
	  <?php 
	 if(!empty($contact_us_features)) :
	  foreach ($contact_us_features as $index => $contact_feature) : ?>
	  <div class="col animate__animated animate__fadeInUp" style="animation-delay: <?php echo ($index * 0.1) ?>s;">
	    <div class="about_pg1_left shadow bg-white p-4 rounded-3 text-center">
		   <span class="text-danger font_50 mb-3 d-block"><i class="<?php echo $contact_feature['contact_features_icon']; ?>"></i></span>
		   <b class="d-block"><?php echo $contact_feature['contact_features_title']; ?></b>
		   <p class="mb-0 mt-3"><?php echo $contact_feature['contact_features_description']; ?></p>
		   <span class="d-block mt-3 text-center"><a class="button rounded-pill" href="<?php echo $contact_feature['contact_features_link']; ?>">Get Support</a></span>
		</div>  
	  </div>
	  <?php endforeach;
	  endif; ?>
	</div>
	<div class="row  contact_2  mt-5  mx-auto animate__animated animate__fadeInUp">
	  <div class="col-md-5 p-0">
	    <div class="contact_2_left bg_light py-5 px-4">
		 <h1 class="mb-4"><?php echo $contact_left_side_heading; ?></h1>
      <a href="#"><img src="<?php echo wp_get_attachment_url($contact_left_side_image['id']); ?>
" class="img-fluid rounded-circle" alt="<?php echo wp_get_attachment_caption($contact_left_side_image['id']); ?>"></a>
	  <p class="mb-0 mt-4"><?php echo $contact_left_side_text; ?></p>
		</div>
	  </div>
	  <div class="col-md-7 p-0">
	    <div class="contact_2_right shadow py-5 px-4">
		 <span>LET'S TALK</span>
		 <h4 class="mt-3">Send your enquiry now</h4>
		 <hr class="mt-3 mb-3 line">
		 <?php echo do_shortcode('[contact-form-7 id="0a571a2" title="USABDLifepartner Contact Form"]'); ?>
		</div>
	  </div>
	</div>
	<div class="row contact_3 mt-5 animate__animated animate__fadeInUp">
    <div class="col-md-12">
	<?php echo $google_maps_link; ?>
	</div>
   </div>
   </div>
 </section>

<?php get_footer(); ?>