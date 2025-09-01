<?php
/* Template Name: Payment Cancel */
// Simple message if the user cancels the payment
get_header();

?>
 <section id="center" class="search_form pt-5 pb-5">
	<div class="container-xl">
	   <div class="row search_form1 p-4 w-50 mx-auto">

			<div class="col-md-12 text-center">
				<img src="<?php echo get_template_directory_uri(); ?>/image/icons8-close.gif" alt="Loading..." class="text-cnter==" width="100" height="">
				 <h2 class=""> Your payment was Unsuccessful. </h2>
			  </div>
			  <a href="<?php echo site_url('/my-account'); ?>" class="btn theme-btn mt-3">Go to Dashboard</a>
	   </div>
	</div>
 </section>

 <?php get_footer(); ?>