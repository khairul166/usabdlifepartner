<?php
// Register the custom widget
function register_dynamic_blog_categories_widget() {
    register_widget('Dynamic_Blog_Categories_Widget');
}
add_action('widgets_init', 'register_dynamic_blog_categories_widget');

// Define the Dynamic Blog Categories Widget class
class Dynamic_Blog_Categories_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'dynamic_blog_categories_widget', // Widget ID
            __('Dynamic Blog Categories', 'text_domain'), // Widget Name
            array('description' => __('Displays blog categories dynamically with custom styling', 'text_domain'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        // Get all blog categories
        $categories = get_categories();
        if (!empty($categories)) {
            ?>
            <div class="blog_pg1_right2 mt-4">
                <h3>Category</h3>
                <hr class="line mb-4">
                <ul class="mb-0 fs-6">
                    <?php
                    $count = 1;
                    foreach ($categories as $category) {
                        $category_link = get_category_link($category->term_id);
                        ?>
                        <li class="mt-2">
                            <a class="d-block bg_light py-2 px-3" href="<?php echo esc_url($category_link); ?>">
                                <span class="d-inline-block bg-danger rounded-circle text-white text-center num me-2"><?php echo $count; ?></span>
                                <span><?php echo esc_html($category->name); ?></span>
                                <span class="float-end mt-1"><i class="bi bi-arrow-right"></i></span>
                            </a>
                        </li>
                        <?php
                        $count++;
                    }
                    ?>
                </ul>
            </div>
            <?php
        } else {
            echo "<p>No categories found.</p>";
        }

        echo $args['after_widget'];
    }
}





// Register the Trending Posts widget
function register_trending_posts_widget() {
    register_widget('Trending_Posts_Widget');
}
add_action('widgets_init', 'register_trending_posts_widget');

// Define the Trending Posts Widget class
class Trending_Posts_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'trending_posts_widget', // Widget ID
            __('Recent News', 'text_domain'), // Widget Name
            array('description' => __('Displays recent posts with a customizable number', 'text_domain'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];

        // Set default post count
        $post_count = !empty($instance['post_count']) ? absint($instance['post_count']) : 4;

        // Fetch recent posts
        $query_args = array(
            'posts_per_page' => $post_count,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC'
        );
        $recent_posts = new WP_Query($query_args);

        if ($recent_posts->have_posts()) :
            ?>
            <div class="blog_pg1_right2 mt-4">
                <h3>Recent News</h3>
                <hr class="line mb-4">
                <ul class="mb-0">
                    <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                        <li class="d-flex border-bottom pb-3 mb-3">
                            <span>
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('thumbnail', array('width' => 100, 'alt' => get_the_title())); ?>
                                    <?php else : ?>
                                        <img width="100" alt="No Image" src="<?php echo get_template_directory_uri(); ?>/images/default-thumbnail.png">
                                    <?php endif; ?>
                                </a>
                            </span>
                            <span class="flex-column ms-3">
                                <b class="d-block font_14">
                                    <a class="yellow" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </b>
                                <span class="mt-1 font_14 d-block"><?php echo get_the_date('M d, Y'); ?></span>
                            </span>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <?php
            wp_reset_postdata();
        else :
            echo "<p>No trending posts found.</p>";
        endif;

        echo $args['after_widget'];
    }

    public function form($instance) {
        $post_count = !empty($instance['post_count']) ? absint($instance['post_count']) : 4;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('post_count')); ?>">
                <?php _e('Number of Posts:', 'text_domain'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('post_count')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('post_count')); ?>"
                   type="number" value="<?php echo esc_attr($post_count); ?>" min="1">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['post_count'] = (!empty($new_instance['post_count'])) ? absint($new_instance['post_count']) : 4;
        return $instance;
    }
}




// Register the Recent Profiles Widget
class Recent_Profiles_Widget extends WP_Widget {

    // Constructor
    function __construct() {
        parent::__construct(
            'recent_profiles_widget', // Base ID
            __('Recent Profiles', 'text_domain'), // Name
            array( 'description' => __( 'Displays recent profiles', 'text_domain' ), ) // Args
        );
    }

    // Widget Output
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        $number_of_profiles = isset( $instance['number_of_profiles'] ) ? $instance['number_of_profiles'] : 4;

        // Fetch recent profiles (replace with your actual query)
        $recent_profiles = $this->get_recent_profiles($number_of_profiles);

        echo $args['before_widget'];

        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        // Display profiles
        echo '<div class="recent-profiles">';

        if ($recent_profiles) {
            foreach ($recent_profiles as $profile) {
                // You can fetch user data such as name, image, etc.
                // Inside the widget function
echo '<div class="col-9">';
echo '<b class="d-block mb-0 fs-5"><a href="' . esc_url(home_url('/user-details/')) . '?user_id=' . esc_attr($profile->ID) . '">' . esc_html($profile->first_name . ' ' . $profile->last_name) . '</a></b>';
echo '<ul class="font_15 mb-0">';
echo '<li class="d-flex"><b class="me-2">Age:</b><span>' . esc_html(get_user_meta($profile->ID, 'age', true)) . ' Yrs</span></li>';
echo '<li class="d-flex"><b class="me-2">Location:</b><span>' . esc_html(get_user_meta($profile->ID, 'location', true)) . '</span></li>';
echo '</ul>';
echo '</div>';

            }
        }

        echo '</div>';
        echo $args['after_widget'];
    }

    // Form for widget settings
    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $number_of_profiles = isset( $instance['number_of_profiles'] ) ? $instance['number_of_profiles'] : 4;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'number_of_profiles' ); ?>"><?php _e( 'Number of Profiles to Display:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'number_of_profiles' ); ?>" name="<?php echo $this->get_field_name( 'number_of_profiles' ); ?>" type="number" value="<?php echo esc_attr( $number_of_profiles ); ?>" min="1" />
        </p>
        <?php
    }

    // Update widget settings
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['number_of_profiles'] = (int) $new_instance['number_of_profiles'];
        return $instance;
    }

    // Fetch recent profiles
    private function get_recent_profiles($number_of_profiles = 4) {
        // Example query to get recent users. Customize this according to your needs.
        $args = array(
            'role' => 'subscriber', // Adjust to match your user role
            'number' => $number_of_profiles,
            'orderby' => 'registered',
            'order' => 'DESC'
        );
        $user_query = new WP_User_Query( $args );

        return $user_query->get_results();
    }
}

// Register the widget
function register_recent_profiles_widget() {
    register_widget( 'Recent_Profiles_Widget' );
}
add_action( 'widgets_init', 'register_recent_profiles_widget' );

?>





