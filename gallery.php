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
 * Template Name: Gallary
 */

get_header(); ?>
 
 <section id="center" class="pt-5 pb-5 gallery">
   <div class="container-xl">
    <div class="testim_1 row text-center mb-4">
	  <div class="col-md-12">
	   <h2 class="text-uppercase"><span class="theme-text-color">Our</span> Gallery</h2>
	   <span class="text-uppercase">FUSCE IMPERDIET ULLAMCORPER FRINGILLA.</span>
	  </div>
	 </div>
	 <div class="row moment_1">
      <div class="col-md-4">
	   <div class="moment_1l">
	     <div class="moment_1li position-relative">
		    <div class="moment_1li1">
		      <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/image//35.jpg" class="img-fluid" alt="img25"></a>
		 </div>
		    <div class="moment_1li2 position-absolute text-center">
		      <span class="font_50"><a data-bs-target="#exampleModal1" data-bs-toggle="modal" href="#"><i class="bi bi-plus"></i></a></span>
			  
		 </div>
		 </div>
		 <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			  </div>
			  <div class="modal-body">
				<img src="<?php echo get_template_directory_uri(); ?>/image//35.jpg" class="img-fluid" alt="abc">
			  </div>
			</div>
		  </div>
		</div>
	   </div>
	   <div class="moment_1l mt-3">
	     <div class="moment_1li position-relative">
		    <div class="moment_1li1">
		      <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/image//36.jpg" class="img-fluid" alt="img25"></a>
		 </div>
		    <div class="moment_1li2 position-absolute text-center moment_1li2o">
		      <span class="font_50"><a data-bs-target="#exampleModal2" data-bs-toggle="modal" href="#"><i class="bi bi-plus"></i></a></span>
			  
		 </div>
		 </div>
		 <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			  </div>
			  <div class="modal-body">
				<img src="<?php echo get_template_directory_uri(); ?>/image//36.jpg" class="img-fluid" alt="abc">
			  </div>
			</div>
		  </div>
		</div>
	   </div>
	  </div>
	  <div class="col-md-4">
	   <div class="moment_1l">
	     <div class="moment_1li position-relative">
		    <div class="moment_1li1">
		      <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/image//37.jpg" class="img-fluid" alt="img25"></a>
		 </div>
		    <div class="moment_1li2 position-absolute text-center moment_1li2o">
		      <span class="font_50"><a data-bs-target="#exampleModal3" data-bs-toggle="modal" href="#"><i class="bi bi-plus"></i></a></span>
			  
		 </div>
		 </div>
		 <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			  </div>
			  <div class="modal-body">
				<img src="<?php echo get_template_directory_uri(); ?>/image//37.jpg" class="img-fluid" alt="abc">
			  </div>
			</div>
		  </div>
		</div>
	   </div>
	   <div class="moment_1l mt-3">
	     <div class="moment_1li position-relative">
		    <div class="moment_1li1">
		      <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/image//38.jpg" class="img-fluid" alt="img25"></a>
		 </div>
		    <div class="moment_1li2 position-absolute text-center">
		      <span class="font_50"><a data-bs-target="#exampleModal4" data-bs-toggle="modal" href="#"><i class="bi bi-plus"></i></a></span>
			  
		 </div>
		 </div>
		 <div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			  </div>
			  <div class="modal-body">
				<img src="<?php echo get_template_directory_uri(); ?>/image//38.jpg" class="img-fluid" alt="abc">
			  </div>
			</div>
		  </div>
		</div>
	   </div>
	  </div>
	  <div class="col-md-4">
	   <div class="moment_1l">
	     <div class="moment_1li position-relative">
		    <div class="moment_1li1">
		      <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/image//39.jpg" class="img-fluid" alt="img25"></a>
		 </div>
		    <div class="moment_1li2 position-absolute text-center">
		      <span class="font_50"><a data-bs-target="#exampleModal5" data-bs-toggle="modal" href="#"><i class="bi bi-plus"></i></a></span>
			  
		 </div>
		 </div>
		 <div class="modal fade" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			  </div>
			  <div class="modal-body">
				<img src="<?php echo get_template_directory_uri(); ?>/image//39.jpg" class="img-fluid" alt="abc">
			  </div>
			</div>
		  </div>
		</div>
	   </div>
	   <div class="moment_1l mt-3">
	     <div class="moment_1li position-relative">
		    <div class="moment_1li1">
		      <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/image//40.jpg" class="img-fluid" alt="img25"></a>
		 </div>
		    <div class="moment_1li2 position-absolute text-center moment_1li2o">
		      <span class="font_50"><a data-bs-target="#exampleModal6" data-bs-toggle="modal" href="#"><i class="bi bi-plus"></i></a></span>
			  
		 </div>
		 </div>
		 <div class="modal fade" id="exampleModal6" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			  </div>
			  <div class="modal-body">
				<img src="<?php echo get_template_directory_uri(); ?>/image//40.jpg" class="img-fluid" alt="abc">
			  </div>
			</div>
		  </div>
		</div>
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

		
<?php get_footer();?>