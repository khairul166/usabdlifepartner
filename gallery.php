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

get_header(); 

$opt_name = 'theme_admin_settings';
$theme_options = get_option($opt_name);
$section_info = $theme_options['section_info'] ?? 'Fusce imperdiet ullamcorper fringilla.';
?>
 
 <section id="center" class="pt-5 pb-5 gallery">
  <div class="container-xl">
    <div class="testim_1 row text-center mb-4">
      <div class="col-md-12">
        <h2 class="text-uppercase animate__animated animate__fadeInLeft"><span class="theme-text-color">Our</span> Gallery</h2>
        <span class="text-uppercase animate__animated animate__fadeInRight"><?php echo $section_info;?></span>
      </div>
    </div>

    <?php
$images = $theme_options['image'] ?? [];
$image_ids = explode(',', $images);
if (!empty($image_ids)) : ?>
  <div class="gallery-masonry">
    <?php foreach ($image_ids as $index => $image) : ?>
      <div class="masonry-item mb-4 animate__animated animate__fadeInUp" style="animation-delay: <?php echo ($index * 0.2) ?>s;">
        <a href="<?php echo wp_get_attachment_url($image); ?>" data-lightbox="gallery" data-title="<?php echo $caption; ?>">
          <img src="<?php echo wp_get_attachment_url($image); ?>" class="img-fluid w-100 rounded" alt="<?php echo wp_get_attachment_caption($image); ?>" loading="lazy">
        </a>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

  </div>
</section>


		
<?php get_footer();?>