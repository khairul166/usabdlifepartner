<?php
/**
 * Template for Category Archive
 * This template is used when a category page is accessed.
 */

get_header(); ?>

<section id="center" class="blog_pg pt-5 pb-5">
    <div class="container-xl">
        <h1 class="text-danger text-center mb-4 text-uppercase">Category: <?php single_cat_title(); ?></h1>
        <div class="row blog_pg1">
            <div class="col-lg-9 col-md-8">
                <div class="blog_pg1_left">

                    <?php
                    if (have_posts()) :
                        while (have_posts()) : the_post();
                            ?>
                            <div class="blog_pg1_left1 mt-4 position-relative">
                                <div class="blog_pg1_left1_inner">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if (has_post_thumbnail()): ?>
                                            <?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?>
                                        <?php else: ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/image/placeholder.jpg"
                                                class="img-fluid" alt="Placeholder">
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="blog_pg1_left1_inner1 p-3 position-absolute top-0 w-100">
                                    <ul class="mb-0 font_14">
                                        <li class="d-inline-block bg-danger text-white p-1 px-3 rounded-1">
                                            <?php echo get_the_date('d, M Y'); ?>
                                        </li>
                                        <li class="d-inline-block float-end">
                                            <a class="share_link d-block bg_blue text-white rounded-circle text-center"
                                                href="<?php the_permalink(); ?>">
                                                <i class="bi bi-share"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="blog_pg1_left1_inner2 p-4 shadow">
                                    <ul class="font_12 text-uppercase d-flex flex-wrap">
                                        <?php
                                        $categories = get_the_category();
                                        if (!empty($categories)):
                                            foreach ($categories as $category):
                                                ?>
                                                <li class="me-2">
                                                    <a class="bg-danger text-white py-1 px-2"
                                                        href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                                        <?php echo esc_html($category->name); ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                    <h4 class="mt-3">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                    <p class="mt-3"><?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?></p>
                                    <ul class="mb-0">
                                        <li class="d-flex mb-0">
                                            <span>
                                                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                                    <?php echo get_avatar(get_the_author_meta('ID'), 50, '', '', array('class' => 'rounded-circle')); ?>
                                                </a>
                                            </span>
                                            <span class="flex-column ms-3">
                                                <b class="d-block font_14">
                                                    <a class="yellow"
                                                        href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                                        <?php the_author(); ?>
                                                    </a>
                                                </b>
                                                <span class="font_13 d-block">Author</span>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <?php endwhile; ?>

                        <!-- Pagination -->
                        <div class="paging">
                            <ul class="mb-0 paginate text-center mt-4">
                                <?php
                                the_posts_pagination(array(
                                    'prev_text' => '<i class="bi bi-chevron-left"></i>',
                                    'next_text' => '<i class="bi bi-chevron-right"></i>',
                                    'mid_size' => 2,
                                ));
                                ?>
                            </ul>
                        </div>

                    <?php else: ?>
                        <p class="text-center">No posts found.</p>
                    <?php endif; ?>
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
