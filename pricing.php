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
	  <div class="col">
	    <div class="price_1_left shadow bg-white py-5 px-4 rounded_30 text-center mt-5">
		   <b class="d-block fs-4">Free</b>
		   <p class="mt-2">Printer took a type and scrambled</p>
		   <span class="d-block text-center"><a class="button w-75 mx-auto" href="#">Get Started</a></span>
		   <b class="fs-3 d-block mt-3">$0<span class="text-muted fw-normal">/mo</span></b>
		   <ul class="mt-3 font_14 text-start px-4 mb-0">
		    <li><i class="bi bi-x price_icon theme-bg rounded-circle text-white text-center d-inline-block fw-bold me-2"></i> 5 Premium Profiles view /mo</li>
			<li class="mt-2"><i class="bi bi-check price_icon bg-success rounded-circle text-white text-center d-inline-block fw-bold me-2"></i> Free user profile can view</li>
			<li class="mt-2"><i class="bi bi-x price_icon theme-bg rounded-circle text-white text-center d-inline-block fw-bold me-2"></i> View contact details</li>
			<li class="mt-2"><i class="bi bi-x price_icon theme-bg rounded-circle text-white text-center d-inline-block fw-bold me-2"></i> Send interest</li>
			<li class="mt-2"><i class="bi bi-x price_icon theme-bg rounded-circle text-white text-center d-inline-block fw-bold me-2"></i> Start Chat</li>
		   </ul>
		</div>  
	  </div>
	  <div class="col">
	    <div class="price_1_left shadow bg-white py-5 px-4 rounded_30 text-center">
		  <span class="d-inline-block bg-danger text-white rounded-pill py-2 px-3 font_14 mb-3">Most popular plan</span>
		   <b class="d-block fs-4">Gold</b>
		   <p class="mt-2">Printer took a type and scrambled</p>
		   <span class="d-block text-center"><a class="button button_1 w-75 mx-auto" href="#">Get Started</a></span>
		   <b class="fs-3 d-block mt-3">$349<span class="text-muted fw-normal">/mo</span></b>
		   <ul class="mt-3 font_14 text-start px-4 mb-0">
		    <li><i class="bi bi-check price_icon bg-success rounded-circle text-white text-center d-inline-block fw-bold me-2"></i> 22 Premium Profiles view /mo</li>
			<li class="mt-2"><i class="bi bi-check price_icon bg-success rounded-circle text-white text-center d-inline-block fw-bold me-2"></i> Free user profile can view</li>
			<li class="mt-2"><i class="bi bi-check price_icon bg-success rounded-circle text-white text-center d-inline-block fw-bold me-2"></i> View contact details</li>
			<li class="mt-2"><i class="bi bi-check price_icon bg-success rounded-circle text-white text-center d-inline-block fw-bold me-2"></i> Send interest</li>
			<li class="mt-2"><i class="bi bi-check price_icon bg-success rounded-circle text-white text-center d-inline-block fw-bold me-2"></i> Start Chat</li>
		   </ul>
		</div>  
	  </div>
	  <div class="col">
	    <div class="price_1_left shadow bg-white py-5 px-4 rounded_30 text-center mt-5">
		   <b class="d-block fs-4">Platinum</b>
		   <p class="mt-2">Printer took a type and scrambled</p>
		   <span class="d-block text-center"><a class="button  w-75 mx-auto" href="#">Get Started</a></span>
		   <b class="fs-3 d-block mt-3">$529<span class="text-muted fw-normal">/mo</span></b>
		   <ul class="mt-3 font_14 text-start px-4 mb-0">
		    <li><i class="bi bi-check price_icon bg-success rounded-circle text-white text-center d-inline-block fw-bold me-2"></i> 55 Premium Profiles view /mo</li>
			<li class="mt-2"><i class="bi bi-check price_icon bg-success rounded-circle text-white text-center d-inline-block fw-bold me-2"></i> Free user profile can view</li>
			<li class="mt-2"><i class="bi bi-check price_icon bg-success rounded-circle text-white text-center d-inline-block fw-bold me-2"></i> View contact details</li>
			<li class="mt-2"><i class="bi bi-check price_icon bg-success rounded-circle text-white text-center d-inline-block fw-bold me-2"></i> Send interest</li>
			<li class="mt-2"><i class="bi bi-check price_icon bg-success rounded-circle text-white text-center d-inline-block fw-bold me-2"></i> Start Chat</li>
		   </ul>
		</div>  
	  </div>
	</div>
   </div>
 </section>

 <section id="footer" class="pt-5 pb-5 bg_blue">
	<div class="container-xl">
   
	 <div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 footer_2 mt-4  mx-0">
		<div class="col p-0">
		  <div class="footer_2_left">
		   <b class="fs-5 d-block text-white mb-3"> Matrimony Services</b>
		   <ul class="mb-0 font_14">
			<li><a  class="text-white link" href="#">Assamese Matrimony</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Gujarati Matrimony</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Bengali Matrimony</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Kerala Matrimony</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Oriya Matrimony</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Kannada Matrimony</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Parsi Matrimony</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Tamil Matrimony</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Telugu Matrimony</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Punjabi Matrimony</a></li>
		   </ul>
		  </div>  
		</div>
		<div class="col p-0">
		  <div class="footer_2_left border-start-0">
		   <b class="fs-5 d-block text-white mb-3"> Help & Support</b>
		   <ul class="mb-0 font_14">
			<li><a  class="text-white link" href="#">Contact Us</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Feedback</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">FAQs</a></li>
		   </ul>
		   <b class="fs-5 d-block text-white mb-3 mt-3"> Other Services</b>
		   <ul class="mb-0 font_14">
			<li><a  class="text-white link" href="#">Info@gmail.com</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Lorem</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Porta</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Ipsum</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Dolor</a></li>
		   </ul>
		   
		  </div>  
		</div>
		<div class="col p-0">
		  <div class="footer_2_left border-start-0">
		   <b class="fs-5 d-block text-white mb-3"> Information</b>
		   <ul class="mb-0 font_14">
			<li><a  class="text-white link" href="#">About Us</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Awards</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Milestones</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Partner</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Stories</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Payment</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Careers</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Commercials</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Terms & Conditions</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Privacy Policy</a></li>
		   </ul>
		  </div>  
		</div>
		<div class="col p-0">
		  <div class="footer_2_left border-start-0">
		   <b class="fs-5 d-block text-white mb-3"> Related  Services</b>
		   <ul class="mb-0 font_14">
			<li><a  class="text-white link" href="#">Connect Us</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Faqs</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Partner Sites</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Ipsum Porta</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">World Tour</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Prize</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Award Winnind</a></li>
			<li class="mt-2"><a  class="text-white link" href="#">Discount</a></li>
		   </ul>
		  </div>  
		</div>
	 </div>
	 <div class="footer_bottom_1 row  mt-4">
			 <div class="col-md-8">
			 <div class="footer_bottom_1_left pt-2">
			   <p class="mb-0 text-white-50">© <span id="currentYear"></span> Your Website Name. All Rights Reserved | Design by <a class="theme-text-color fw-bold" href="https://www.linkedin.com/in/khirul166/">Khairul</a></p>
			 </div>
		   </div>
		   <div class="col-md-4">
			 <div class="footer_bottom_1_right">
			   <ul class="mb-0 d-flex social_brands justify-content-end">
				   <li><a class="bg-primary d-inline-block text-white text-center" href="#"><i class="bi bi-facebook"></i></a></li>
				   <li class="ms-2"><a class="bg-success d-inline-block text-white text-center" href="#"><i class="bi bi-instagram"></i></a></li>
				   <li class="ms-2"><a class="bg-warning d-inline-block text-white text-center" href="#"><i class="bi bi-linkedin"></i></a></li>
				   <li class="ms-2"><a class="bg-info d-inline-block text-white text-center" href="#"><i class="bi bi-pinterest"></i></a></li>
				   <li class="ms-2"><a class="theme-bg d-inline-block text-white text-center" href="#"><i class="bi bi-youtube"></i></a></li>
				 </ul>
			 </div>
		   </div>
		</div>
	</div>
   </section>

		
<?php get_footer(); ?>