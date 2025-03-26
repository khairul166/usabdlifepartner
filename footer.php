
<section id="footer" class="pt-5 pb-5 bg_blue">
 <div class="container-xl">

 <div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 footer_2 mt-4 mx-0">
    <div class="col footer_widget">
        <?php if (is_active_sidebar('footer-1')) {
            dynamic_sidebar('footer-1');
        } ?>
    </div>
    
    <div class="col footer_widget">
        <?php if (is_active_sidebar('footer-2')) {
            dynamic_sidebar('footer-2');
        } ?>
    </div>

    <div class="col footer_widget">
        <?php if (is_active_sidebar('footer-3')) {
            dynamic_sidebar('footer-3');
        } ?>
    </div>

    <div class="col footer_widget">
        <?php if (is_active_sidebar('footer-4')) {
            dynamic_sidebar('footer-4');
        } ?>
    </div>
</div>

  <div class="footer_bottom_1 row  mt-4">
      	<div class="col-md-8">
		  <div class="footer_bottom_1_left pt-2">
          <p class="mb-0 text-white">© <span id="currentYear"></span> <?php echo esc_html(get_bloginfo('name')); ?>. All Rights Reserved | Designed & Developed by <a class="theme-text-color fw-bold" href="<?php echo esc_url('https://www.linkedin.com/in/khirul166/'); ?>">Khairul</a></p>
<script>
  document.getElementById('currentYear').textContent = new Date().getFullYear();
</script>
		  </div>
		</div>

 	</div>
	
 </div>
</section>
 	<div class="container">
     <a id="bctbutton" class="theme-bg text-white text-center"><i class="bi bi-caret-up-fill"></i></a>
    </div>

<?php wp_footer(); ?>
</body>
</html>