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

get_header(); ?>

<div class="container text-center mt-5 mb-5">
    <h1 class="display-3 text-danger">404</h1>
    <h2 class="mb-4">Oops! Page Not Found</h2>
    <p class="mb-4">The page you’re looking for doesn’t exist. It might have been moved or deleted.</p>

    <!-- Action Buttons -->
    <div class="mt-4">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn theme-btn">Go to Homepage</a>
    </div>

</div>

<?php get_footer();