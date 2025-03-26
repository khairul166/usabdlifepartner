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
 * Template Name: About Us
 */

get_header(); 

$phone = get_theme_mod('contact_phone', '+1 234 567 890');
$email = get_theme_mod('contact_email', 'info@yourdomain.com');?>

<section id="center" class="center_about pt-4 theme-bg">
   <div class="container-xl">
    <div class="row center_price1 text-center">
	  <div class="col-md-12">
	   <b class="fs-5 d-block mb-3 text-warning">#1 WEDDING WEBSITE</b>
	   <h1 class="text-white font_50">About Us</h1>
<p class="mt-3 text-white mb-0 fs-5">Most Trusted and best Matrimony Service in the World.</p>
	  </div>
	</div>
   </div>
 </section>
 
 <section id="about_pg" class="pb-5">
   <div class="container-xl">
    <div class="row row-cols-1 row-cols-md-3 about_pg1  mx-auto">
	  <div class="col">
	    <div class="about_pg1_left shadow bg-white p-4 rounded-3 text-center hvr-grow mx-2">
		   <span class="theme-text-color fs-1 mb-3 d-block"><i class="bi bi-person-check"></i></span>
		   <b class="d-block fs-5">Genuine profiles</b>
		   <p class="mb-0 mt-3">The most trusted wedding matrimony brand</p>
		</div>  
	  </div>
	  <div class="col">
	    <div class="about_pg1_left shadow bg-white p-4 rounded-3 text-center hvr-grow  mx-2">
		   <span class="theme-text-color fs-1 mb-3 d-block"><i class="bi bi-shield-lock"></i></span>
		   <b class="d-block fs-5">Most trusted</b>
		   <p class="mb-0 mt-3">The most trusted wedding matrimony brand</p>
		</div>  
	  </div>
	  <div class="col">
	    <div class="about_pg1_left shadow bg-white p-4 rounded-3 text-center hvr-grow  mx-2">
		   <span class="theme-text-color fs-1 mb-3 d-block"><i class="bi bi-arrow-through-heart"></i></span>
		   <b class="d-block fs-5">1200+ weddings</b>
		   <p class="mb-0 mt-3">The most trusted wedding matrimony brand</p>
		</div>  
	  </div>
	</div>
	<div class="row row-cols-1 row-cols-md-2 about_pg2 mt-5">
	  <div class="col">
	     <div class="about_pg2_left position-relative">
		    <div class="about_pg2_left1">
			  <img src="<?php echo get_template_directory_uri(); ?>/image/32.jpg" alt="abc" class="w-75 rounded-3">
			</div>
			<div class="about_pg2_left2 position-absolute bottom-0 text-end">
			   <img src="<?php echo get_template_directory_uri(); ?>/image/33.jpg" alt="abc" class="w-75">
			</div>
		 </div>
	  </div>
	  <div class="col">
	     <div class="about_pg2_right">
		   <h1 class="text-uppercase font_50">Welcome to</h1>
		   <h2 class="theme-text-color text-uppercase">Wedding matrimony</h2>
		   <p class="mt-4 mb-4">Best wedding matrimony It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
		   <span><a class="theme-text-color" href="#">Click here</a> to Start you matrimony service now.</span>
		   <p class="border-top mt-4 pt-4 mb-4">Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa.Vestibulum lacinia arcu eget nulla.Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitursodales ligula in libero. Sed dignissim lacinia nunc.</p>
		    <ul class="mb-0 d-flex justify-content-between flex-wrap">
			 <li class="d-flex">
			  <span class="d-inline-block text-center bg_blue text-white rounded-circle cont_icon me-3"><i class="bi bi-telephone"></i></span>
			   <span class="flex-column">
			    <span class="text-muted d-block"> Enquiry</span>
				<b class="d-block fs-5"><?php echo esc_html($phone); ?></b>
			   </span>
			 </li>
			 <li class="d-flex">
			  <span class="d-inline-block text-center bg_blue text-white rounded-circle cont_icon me-3"><i class="bi bi-envelope"></i></span>
			   <span class="flex-column">
			    <span class="text-muted d-block"> Get Support</span>
				<b class="d-block fs-5"> <?php echo esc_html($email); ?></b>
			   </span>
			 </li>
			</ul>
		 </div>
	  </div>
	</div>
	<div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 about_pg3 mt-5 border-top border-bottom">
		<div class="col">
		   <div class="about_pg3_left border-end py-4 px-3">
			   <ul class="mb-0 d-flex">
			   <li class="d-flex">
				<span class="d-inline-block text-center theme-bg text-white rounded-circle cont_icon me-3 fs-5"><i class="bi bi-heart"></i></span>
				 <span class="flex-column lh-1">
				  <b class="fs-1 d-block count" data-target="3000">0</b>
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
				<span class="d-inline-block text-center theme-bg text-white rounded-circle cont_icon me-3 fs-5"><i class="bi bi-people"></i></span>
				 <span class="flex-column lh-1">
				  <b class="fs-1 d-block count" data-target="3000">0</b>
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
				<span class="d-inline-block text-center theme-bg text-white rounded-circle cont_icon me-3 fs-5"><i class="bi bi-gender-male"></i></span>
				 <span class="flex-column lh-1">
				  <b class="fs-1 d-block count" data-target="1200">0</b>
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
				<span class="d-inline-block text-center theme-bg text-white rounded-circle cont_icon me-3 fs-5"><i class="bi bi-gender-female"></i></span>
				 <span class="flex-column lh-1">
				  <b class="fs-1 d-block count" data-target="1700">0</b>
				  <span class="d-block text-uppercase text-muted mt-2 font_13">WOMENS</span>
				 </span>
			   </li>
			  </ul>
		   </div>
		</div>
	  </div>
   </div>
 </section>
 
 <section id="testim" class="pb-5 pt-5 bg_light">
	<div class="container-xl">
	  <div class="testim_1 row text-center mb-4">
	   <div class="col-md-12">
		<h2><span class="theme-text-color">CUSTOMER</span> TESTIMONIALS</h2>
		<span class="text-uppercase">FUSCE IMPERDIET ULLAMCORPER FRINGILLA.</span>
	   </div>
	  </div>
 
	  <!-- Slider Container -->
	  <div class="testim-slider">
	   <!-- Testimonial 1 -->
	   <div class="testim-slide">
		 <div class="testim_2_left">
			<div class="testim_2_left1 bg-white py-5 px-4 rounded-3 shadow">
			<span class="text-warning">
			  <i class="bi bi-star-fill"></i>
			   <i class="bi bi-star-fill"></i>
				<i class="bi bi-star-fill"></i>
				 <i class="bi bi-star-fill"></i>
				  <i class="bi bi-star"></i>
			   <span class="font_14 text-muted ms-2">(50 Reviews)</span>
			</span>
			<p class="mb-0 mt-3">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
		   </div>
			<ul class="mb-0 px-4 mt-4">
			  <li class="d-flex mb-0">
				<span><a href="#"><img class="rounded-circle" alt="abc" src="<?php echo get_template_directory_uri(); ?>/image//27.jpg"></a></span>
				<span class="flex-column ms-3 lh-1">
				   <b class="d-block fs-6"><a class="yellow" href="#">Nulla Quis</a></b>
				  <span class="font_12 d-block text-uppercase mt-2">IT PROFESSION</span>
				</span>
			  </li>
			</ul>
		 </div>
	   </div>
 
	   <!-- Testimonial 2 -->
	   <div class="testim-slide">
		 <div class="testim_2_left">
			<div class="testim_2_left1 bg-white py-5 px-4 rounded-3 shadow">
			<span class="text-warning">
			  <i class="bi bi-star-fill"></i>
			   <i class="bi bi-star-fill"></i>
				<i class="bi bi-star-fill"></i>
				 <i class="bi bi-star-fill"></i>
				  <i class="bi bi-star-fill"></i>
			   <span class="font_14 text-muted ms-2">(40 Reviews)</span>
			</span>
			<p class="mb-0 mt-3">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
		   </div>
			<ul class="mb-0 px-4 mt-4">
			  <li class="d-flex mb-0">
				<span><a href="#"><img class="rounded-circle" alt="abc" src="<?php echo get_template_directory_uri(); ?>/image//28.jpg"></a></span>
				<span class="flex-column ms-3 lh-1">
				   <b class="d-block fs-6"><a class="yellow" href="#">Dolor Amet</a></b>
				  <span class="font_12 d-block text-uppercase mt-2">GOVERNMENT STAFF</span>
				</span>
			  </li>
			</ul>
		 </div>
	   </div>
 
	   <!-- Testimonial 3 -->
	   <div class="testim-slide">
		 <div class="testim_2_left">
			<div class="testim_2_left1 bg-white py-5 px-4 rounded-3 shadow">
			<span class="text-warning">
			  <i class="bi bi-star-fill"></i>
			   <i class="bi bi-star-fill"></i>
				<i class="bi bi-star-fill"></i>
				 <i class="bi bi-star-fill"></i>
				  <i class="bi bi-star-half"></i>
			   <span class="font_14 text-muted ms-2">(55 Reviews)</span>
			</span>
			<p class="mb-0 mt-3">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
		   </div>
			<ul class="mb-0 px-4 mt-4">
			  <li class="d-flex mb-0">
				<span><a href="#"><img class="rounded-circle" alt="abc" src="<?php echo get_template_directory_uri(); ?>/image//29.jpg"></a></span>
				<span class="flex-column ms-3 lh-1">
				   <b class="d-block fs-6"><a class="yellow" href="#">Lorem Porta</a></b>
				  <span class="font_12 d-block text-uppercase mt-2">Teacher</span>
				</span>
			  </li>
			</ul>
		 </div>
	   </div>

	   	   <!-- Testimonial 3 -->
			  <div class="testim-slide">
				<div class="testim_2_left">
				   <div class="testim_2_left1 bg-white py-5 px-4 rounded-3 shadow">
				   <span class="text-warning">
					 <i class="bi bi-star-fill"></i>
					  <i class="bi bi-star-fill"></i>
					   <i class="bi bi-star-fill"></i>
						<i class="bi bi-star-fill"></i>
						 <i class="bi bi-star-half"></i>
					  <span class="font_14 text-muted ms-2">(55 Reviews)</span>
				   </span>
				   <p class="mb-0 mt-3">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
				  </div>
				   <ul class="mb-0 px-4 mt-4">
					 <li class="d-flex mb-0">
					   <span><a href="#"><img class="rounded-circle" alt="abc" src="<?php echo get_template_directory_uri(); ?>/image//29.jpg"></a></span>
					   <span class="flex-column ms-3 lh-1">
						  <b class="d-block fs-6"><a class="yellow" href="#">Lorem Porta</a></b>
						 <span class="font_12 d-block text-uppercase mt-2">Teacher</span>
					   </span>
					 </li>
				   </ul>
				</div>
			  </div>

			  	   <!-- Testimonial 3 -->
	   <div class="testim-slide">
		<div class="testim_2_left">
		   <div class="testim_2_left1 bg-white py-5 px-4 rounded-3 shadow">
		   <span class="text-warning">
			 <i class="bi bi-star-fill"></i>
			  <i class="bi bi-star-fill"></i>
			   <i class="bi bi-star-fill"></i>
				<i class="bi bi-star-fill"></i>
				 <i class="bi bi-star-half"></i>
			  <span class="font_14 text-muted ms-2">(55 Reviews)</span>
		   </span>
		   <p class="mb-0 mt-3">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
		  </div>
		   <ul class="mb-0 px-4 mt-4">
			 <li class="d-flex mb-0">
			   <span><a href="#"><img class="rounded-circle" alt="abc" src="<?php echo get_template_directory_uri(); ?>/image//29.jpg"></a></span>
			   <span class="flex-column ms-3 lh-1">
				  <b class="d-block fs-6"><a class="yellow" href="#">Lorem Porta</a></b>
				 <span class="font_12 d-block text-uppercase mt-2">Teacher</span>
			   </span>
			 </li>
		   </ul>
		</div>
	  </div>

	  	   <!-- Testimonial 3 -->
			 <div class="testim-slide">
				<div class="testim_2_left">
				   <div class="testim_2_left1 bg-white py-5 px-4 rounded-3 shadow">
				   <span class="text-warning">
					 <i class="bi bi-star-fill"></i>
					  <i class="bi bi-star-fill"></i>
					   <i class="bi bi-star-fill"></i>
						<i class="bi bi-star-fill"></i>
						 <i class="bi bi-star-half"></i>
					  <span class="font_14 text-muted ms-2">(55 Reviews)</span>
				   </span>
				   <p class="mb-0 mt-3">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
				  </div>
				   <ul class="mb-0 px-4 mt-4">
					 <li class="d-flex mb-0">
					   <span><a href="#"><img class="rounded-circle" alt="abc" src="<?php echo get_template_directory_uri(); ?>/image//29.jpg"></a></span>
					   <span class="flex-column ms-3 lh-1">
						  <b class="d-block fs-6"><a class="yellow" href="#">Lorem Porta</a></b>
						 <span class="font_12 d-block text-uppercase mt-2">Teacher</span>
					   </span>
					 </li>
				   </ul>
				</div>
			  </div>
	  </div>
	</div>
  </section>
 
 <section id="team" class="pb-5 pt-5">
   <div class="container-xl">
     <div class="testim_1 row text-center mb-4">
	  <div class="col-md-12">
	   <h2 class="text-uppercase">Meet  <span class="theme-text-color">Our Team</span></h2>
	   <span class="text-uppercase">OUR PROFESSIONALS</span>
	  </div>
	 </div>
	 <div class="row team_1 mx-3">
   <div class="col-md-6">
    <div class="team_1i">
	   <div class="team_1i1 row">
	    <div class="col-md-6 pe-0 col-sm-6">
		 <div class="team_1i1l position-relative">
		  <div class="team_1i1li">
		    <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/image/12.jpg" class="img-fluid" alt="abc"></a>
		  </div>
		  <div class="team_1i1li1 position-absolute w-100 h-100 bg_back top-0 text-center">
		      <div class="top_1r">
      <ul class="mb-0">
		<li class="d-inline-block"><a class="bg-white d-block rounded-circle text-center theme-text-color" href="#"><i class="bi bi-facebook"></i></a>  </li>
		<li class="d-inline-block"><a class="bg-white d-block rounded-circle text-center theme-text-color" href="#"><i class="bi bi-twitter"></i></a>  </li>
		<li class="d-inline-block"><a class="bg-white d-block rounded-circle text-center theme-text-color" href="#"><i class="bi bi-linkedin"></i></a>  </li>
		<li class="d-inline-block"><a class="bg-white d-block rounded-circle text-center theme-text-color" href="#"><i class="bi bi-instagram"></i></a>  </li>
		<li class="d-inline-block"><a class="bg-white d-block rounded-circle text-center theme-text-color" href="#"><i class="bi bi-youtube"></i></a>  </li>
	</ul>
   </div>
		  </div>
		 </div>
		</div>
		<div class="col-md-6 ps-0 col-sm-6">
		 <div class="team_1i1r bg_light  px-4">
		  <h5>Lorem Quis</h5>
		  <h6 class="font_14">Masters in Website</h6>
		  <hr class="line">
		  <h6 class="font_14"><span class="fw-bold">Qualification:</span> Bsc., BEd., Phd</h6>
		  <h6 class="font_14 mb-0 mt-2"><span class="fw-bold">Experience:</span> 16 Years</h6>
		  <p class="mb-0 mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero.</p>
		 </div>
		</div>
	   </div>
	</div>
   </div>
   <div class="col-md-6">
    <div class="team_1i">
	   <div class="team_1i1 row">
	    <div class="col-md-6 pe-0 col-sm-6">
		 <div class="team_1i1l position-relative">
		  <div class="team_1i1li">
		    <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/image/13.jpg" class="img-fluid" alt="abc"></a>
		  </div>
		  <div class="team_1i1li1 position-absolute w-100 h-100 bg_back top-0 text-center">
		      <div class="top_1r">
      <ul class="mb-0">
		<li class="d-inline-block"><a class="bg-white d-block rounded-circle text-center theme-text-color" href="#"><i class="bi bi-facebook"></i></a>  </li>
		<li class="d-inline-block"><a class="bg-white d-block rounded-circle text-center theme-text-color" href="#"><i class="bi bi-twitter"></i></a>  </li>
		<li class="d-inline-block"><a class="bg-white d-block rounded-circle text-center theme-text-color" href="#"><i class="bi bi-linkedin"></i></a>  </li>
		<li class="d-inline-block"><a class="bg-white d-block rounded-circle text-center theme-text-color" href="#"><i class="bi bi-instagram"></i></a>  </li>
		<li class="d-inline-block"><a class="bg-white d-block rounded-circle text-center theme-text-color" href="#"><i class="bi bi-youtube"></i></a>  </li>
	</ul>
   </div>
		  </div>
		 </div>
		</div>
		<div class="col-md-6 ps-0 col-sm-6">
		 <div class="team_1i1r bg_light  px-4">
		  <h5>Semper Amet</h5>
		  <h6 class="font_14">Manager</h6>
		  <hr class="line">
		  <h6 class="font_14"><span class="fw-bold">Qualification:</span> Bba., BEd., Phd</h6>
		  <h6 class="font_14 mb-0 mt-2"><span class="fw-bold">Experience:</span> 18 Years</h6>
		  <p class="mb-0 mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero.</p>
		 </div>
		</div>
	   </div>
	</div>
   </div>
 </div>
   </div>
 </section>
 
 <section id="faq" class="pb-5 pt-5 bg_light">
   <div class="container-xl">
     <div class="testim_1 row text-center mb-4">
	  <div class="col-md-12">
	   <h2 class="text-uppercase">KNOWLEDGE  <span class="theme-text-color">Faq</span></h2>
	   <span class="text-uppercase">FUSCE IMPERDIET ULLAMCORPER FRINGILLA</span>
	  </div>
	 </div>
	 <div class="testim_2 row row-cols-1 row-cols-md-2">
	  <div class="col">
	   <div class="testim_2_left">
	     <div class="accordion" id="accordionExample">
  <div class="accordion-item">
   <h2 class="accordion-header" id="headingOne">
     <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
       <i class="bi bi-check-circle me-2 align-middle"></i> It is a long established fact
     </button>
   </h2>
   <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
     <div class="accordion-body">
       <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
     </div>
   </div>
  </div>
   
  <div class="accordion-item">
   <h2 class="accordion-header" id="headingTwo">
     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
       <i class="bi bi-check-circle me-2 align-middle"></i> Where can I get some?
     </button>
   </h2>
   <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
     <div class="accordion-body">
       <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
     </div>
   </div>
 </div>
  
  <div class="accordion-item">
   <h2 class="accordion-header" id="headingThree">
     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
       <i class="bi bi-check-circle me-2 align-middle"></i> Where does it come from?
     </button>
   </h2>
   <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
     <div class="accordion-body">
        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
     </div>
   </div>
 </div>
 
 <div class="accordion-item">
   <h2 class="accordion-header" id="headingFour">
     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
       <i class="bi bi-check-circle me-2 align-middle"></i> Why do we use it?
     </button>
   </h2>
   <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
     <div class="accordion-body">
       <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
     </div>
   </div>
 </div>

 <div class="accordion-item">
   <h2 class="accordion-header" id="headingFive">
     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
       <i class="bi bi-check-circle me-2 align-middle"></i> What is Lorem Ipsum?
     </button>
   </h2>
   <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
     <div class="accordion-body">
    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
     </div>
   </div>
 </div>
 
 <div class="accordion-item">
   <h2 class="accordion-header" id="headingSix">
     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
       <i class="bi bi-check-circle me-2 align-middle"></i> Contrary to popular belief
     </button>
   </h2>
   <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
     <div class="accordion-body">
    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
     </div>
   </div>
 </div>
</div>
	   </div>
	  </div>
	  <div class="col">
	   <div class="testim_2_right">
	       <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/image/34.jpg" class="img-fluid" alt="abc"></a>
	   </div>
	  </div>
	 </div>  
   </div>
 </section>

 
<?php get_footer(); ?>