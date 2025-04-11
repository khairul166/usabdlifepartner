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

    <?php
    $gallery_items = cs_get_option('gallery_items');
    if (!empty($gallery_items)) : ?>
      <div class="gallery-masonry">
        <?php foreach ($gallery_items as $index => $item) :
          $img = esc_url($item['image']);
          $caption = esc_html($item['caption'] ?? '');
          ?>
          <div class="masonry-item mb-4">
            <a href="<?php echo $img; ?>" data-lightbox="gallery" data-title="<?php echo $caption; ?>">
              <img src="<?php echo $img; ?>" class="img-fluid w-100 rounded" alt="Gallery" loading="lazy">
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>


		
<?php get_footer();?>