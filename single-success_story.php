<?php
/**
 * Template Name: Success Story Single
 *
 * This template is used to display a single success story post.
 *
 * @package YourThemeName
 */

get_header(); ?>

<section id="center" class="blog_pg  pt-5 pb-5">
	<div class="container-xl">
		<h1 class="text-danger text-center mb-4 text-uppercase"><?php the_title(); ?></h1>
		<div class="row blog_pg1">
			<div class="col-lg-9 col-md-8">
				<div class="blog_pg1_left">
					<div class="blog_pg1_left1 position-relative">
						<div class="blog_pg1_left1_inner">
							<?php if (has_post_thumbnail()): ?>
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?></a>
							<?php endif; ?>
						</div>
						<div class="blog_pg1_left1_inner1 p-3 position-absolute top-0 w-100">
							<ul class="mb-0 font_14">
								<li class="d-inline-block bg-danger text-white p-1 px-3 rounded-1">
									<?php echo get_the_date('d, M Y'); ?>
								</li>
							</ul>
						</div>

						<div class="blog_pg1_left1_inner2 p-4 shadow">
							<h4 class="mt-3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<div class="mt-3"><?php the_content(); ?></div>

							<b class="d-block  fs-5 mt-3">Like This?</b>
							<ul class="mb-0 d-flex social_brands mt-3">
    <li><a class="bg_blue d-inline-block text-white text-center" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(get_permalink()); ?>" target="_blank"><i class="bi bi-facebook"></i></a></li>
    <li class="ms-2"><a class="bg-success d-inline-block text-white text-center" href="https://www.instagram.com" target="_blank"><i class="bi bi-instagram"></i></a></li>
    <li class="ms-2"><a class="bg-warning d-inline-block text-white text-center" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url(get_permalink()); ?>&title=<?php echo esc_attr(get_the_title()); ?>" target="_blank"><i class="bi bi-linkedin"></i></a></li>
    <li class="ms-2"><a class="bg-info d-inline-block text-white text-center" href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&media=<?php echo esc_url(get_the_post_thumbnail_url()); ?>&description=<?php echo esc_attr(get_the_title()); ?>" target="_blank"><i class="bi bi-pinterest"></i></a></li>
</ul>

							<b class="d-block  fs-5 mt-3 mb-3">Related Success Stories</b>
							<div class="row row-cols-1 row-cols-md-2 row-cols-sm-2">
								<?php
								$related = get_posts(array('post_type' => 'success_story', 'numberposts' => 2, 'post__not_in' => array($post->ID)));
								if ($related) {
									foreach ($related as $post) {
										setup_postdata($post); ?>
										<div class="col">
											<div class="profile1_left">
												<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?></a>
												<b class="fs-5 d-block mt-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></b>
												<span class="font_14 d-block mt-2"><b><?php the_author(); ?></b> - <?php the_date(); ?></span>
												<p class="mb-0 mt-3"><?php the_excerpt(); ?></p>
											</div>
										</div>
									<?php }
									wp_reset_postdata();
								} ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Sidebar -->
			<div class="col-lg-3 col-md-4">
				<div class="blog_pg1_right">
					<?php if (is_active_sidebar('blog-sidebar')): ?>
						<?php dynamic_sidebar('blog-sidebar'); ?>
					<?php else: ?>
						<p>No widgets added yet. Add some from WordPress admin.</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>