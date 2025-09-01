<?php
get_header();

if (have_posts()) :
    while (have_posts()) : the_post(); ?>
    <section id="center" class="team_pg  pt-5 pb-5">
   <div class="container-xl">
	    <h1 class="text-danger text-center mb-4"><?php the_title(); ?></h1>
        <div class="entry-content">
                <?php the_content(); ?>
            </div>
   </div>
 </section>
    <?php endwhile;
else :
    echo '<p>No content found</p>';
endif; 

get_footer();