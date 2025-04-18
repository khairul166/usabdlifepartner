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
					?>

<section id="center" class="center_about pt-4 theme-bg">
   <div class="container-xl">
    <div class="row center_price1 text-center">
	  <div class="col-md-12">
	   <b class="fs-5 d-block mb-3 text-warning">WE ARE HERE TO ASSIST YOU.</b>
	   <h1 class="text-white font_50">Contact us</h1>
<p class="mt-3 text-white mb-0 fs-5">Most Trusted and best Matrimony Service in the World.</p>
	  </div>
	</div>
   </div>
 </section>
 
 <section id="about_pg" class="pb-5">
   <div class="container-xl">
    <div class="row row-cols-1 row-cols-md-3 contact_1">
	  <div class="col">
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
	  <div class="col">
	    <div class="about_pg1_left shadow bg-white p-4 rounded-3 text-center">
		   <span class="text-danger font_50 mb-3 d-block"><i class="bi bi-person"></i></span>
		   <b class="d-block">CUSTOMER RELATIONS</b>
		   <p class="mb-0 mt-3">The most trusted wedding matrimony brand</p>
		   <span class="d-block mt-3 text-center"><a class="button rounded-pill" href="#">Get Support</a></span>
		</div>  
	  </div>
	  <div class="col">
	    <div class="about_pg1_left shadow bg-white p-4 rounded-3 text-center">
		   <span class="text-danger font_50 mb-3 d-block"><i class="bi bi-whatsapp"></i></span>
		   <b class="d-block">WHATSAPP SUPPORT</b>
		   <p class="mb-0 mt-3">The most trusted wedding matrimony brand</p>
		   <span class="d-block mt-3 text-center"><a class="button rounded-pill" href="#">Talk to sales</a></span>
		</div>  
	  </div>
	</div>
	<div class="row  contact_2  mt-5  mx-auto">
	  <div class="col-md-5 p-0">
	    <div class="contact_2_left bg_light py-5 px-4">
		 <h1 class="mb-4">Now
<span class="font_50">Contact to us</span>
Easy and fast.</h1>
      <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/image/3.jpg" class="img-fluid rounded-circle" alt="abc"></a>
	  <p class="mb-0 mt-4">Integer non nisl elit in ac tempor ante, eget iaculis augue. Nuncekon dolor mi, accumsan quis ante id, eleifend suscipit purus. Praesent augue eros, consectetur eu eleifend inno, eget condimentum auctor</p>
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
	<div class="row contact_3 mt-5">
    <div class="col-md-12">
	  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8355.952359412026!2d-85.62209517704407!3d42.22993140046881!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x881775e032936199%3A0x7209273f1339b392!2s2548%20Heverly%20Dr%20E%2C%20Portage%2C%20MI%2049024%2C%20USA!5e0!3m2!1sen!2sbd!4v1744303801416!5m2!1sen!2sbd" height="450" style="border:0; width:100%;" allowfullscreen=""></iframe>
	</div>
   </div>
   </div>
 </section>

<?php get_footer(); ?>