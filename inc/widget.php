<?php 
function custom_theme_widgets_init() {
    register_sidebar(array(
        'name'          => __('Footer Column 1', 'textdomain'),
        'id'            => 'footer-1',
        'description'   => __('Widgets for the first column in the footer.', 'textdomain'),
        'before_widget' => '<div class="footer_widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<b class="fs-5 d-block text-white mb-3">',
        'after_title'   => '</b>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Column 2', 'textdomain'),
        'id'            => 'footer-2',
        'description'   => __('Widgets for the second column in the footer.', 'textdomain'),
        'before_widget' => '<div class="footer_widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<b class="fs-5 d-block text-white mb-3">',
        'after_title'   => '</b>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Column 3', 'textdomain'),
        'id'            => 'footer-3',
        'description'   => __('Widgets for the third column in the footer.', 'textdomain'),
        'before_widget' => '<div class="footer_widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<b class="fs-5 d-block text-white mb-3">',
        'after_title'   => '</b>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Column 4', 'textdomain'),
        'id'            => 'footer-4',
        'description'   => __('Widgets for the fourth column in the footer.', 'textdomain'),
        'before_widget' => '<div class="footer_widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<b class="fs-5 d-block text-white mb-3">',
        'after_title'   => '</b>',
    ));
}
add_action('widgets_init', 'custom_theme_widgets_init');




class About_Widget extends WP_Widget {

    // Constructor
    public function __construct() {
        parent::__construct(
            'about_widget',  
            __('About Section', 'textdomain'), 
            ['description' => __('A custom About widget with social media links.', 'textdomain')]
        );
    }

    // Display widget frontend
    public function widget($args, $instance) {
        echo $args['before_widget'];
        ?>
        <div class="col footer_widget">
            <div class="footer_2_left">
                <?php if (!empty($instance['title'])) : ?>
                    <b class="fs-5 d-block text-white mb-3"><?php echo esc_html($instance['title']); ?></b>
                <?php endif; ?>
                
                <?php if (!empty($instance['description'])) : ?>
                    <div class="text-white justify-content-center font_14">
                        <?php echo esc_html($instance['description']); ?>
                    </div>
                <?php endif; ?>

                <ul class="mb-0 mt-2 d-flex social_brands">
                    <?php if (!empty($instance['facebook'])) : ?>
                        <li><a class="bg-primary d-inline-block text-white text-center" href="<?php echo esc_url($instance['facebook']); ?>" target="_blank"><i class="bi bi-facebook"></i></a></li>
                    <?php endif; ?>

                    <?php if (!empty($instance['instagram'])) : ?>
                        <li class="ms-2"><a class="bg-success d-inline-block text-white text-center" href="<?php echo esc_url($instance['instagram']); ?>" target="_blank"><i class="bi bi-instagram"></i></a></li>
                    <?php endif; ?>

                    <?php if (!empty($instance['linkedin'])) : ?>
                        <li class="ms-2"><a class="bg-warning d-inline-block text-white text-center" href="<?php echo esc_url($instance['linkedin']); ?>" target="_blank"><i class="bi bi-linkedin"></i></a></li>
                    <?php endif; ?>

                    <?php if (!empty($instance['pinterest'])) : ?>
                        <li class="ms-2"><a class="bg-info d-inline-block text-white text-center" href="<?php echo esc_url($instance['pinterest']); ?>" target="_blank"><i class="bi bi-pinterest"></i></a></li>
                    <?php endif; ?>

                    <?php if (!empty($instance['youtube'])) : ?>
                        <li class="ms-2"><a class="theme-bg d-inline-block text-white text-center" href="<?php echo esc_url($instance['youtube']); ?>" target="_blank"><i class="bi bi-youtube"></i></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    // Widget settings form in WP Admin
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('About Us', 'textdomain');
        $description = !empty($instance['description']) ? $instance['description'] : __('Our platform is designed to be flexible for both men and women.', 'textdomain');
        $facebook = !empty($instance['facebook']) ? $instance['facebook'] : '';
        $instagram = !empty($instance['instagram']) ? $instance['instagram'] : '';
        $linkedin = !empty($instance['linkedin']) ? $instance['linkedin'] : '';
        $pinterest = !empty($instance['pinterest']) ? $instance['pinterest'] : '';
        $youtube = !empty($instance['youtube']) ? $instance['youtube'] : '';

        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('description')); ?>">Description:</label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description')); ?>"
                      name="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php echo esc_attr($description); ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('facebook')); ?>">Facebook URL:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('facebook')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('facebook')); ?>" type="text"
                   value="<?php echo esc_attr($facebook); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('instagram')); ?>">Instagram URL:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('instagram')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('instagram')); ?>" type="text"
                   value="<?php echo esc_attr($instagram); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('linkedin')); ?>">LinkedIn URL:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('linkedin')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('linkedin')); ?>" type="text"
                   value="<?php echo esc_attr($linkedin); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('pinterest')); ?>">Pinterest URL:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('pinterest')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('pinterest')); ?>" type="text"
                   value="<?php echo esc_attr($pinterest); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('youtube')); ?>">YouTube URL:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('youtube')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('youtube')); ?>" type="text"
                   value="<?php echo esc_attr($youtube); ?>">
        </p>
        <?php
    }

    // Save widget settings
    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['description'] = (!empty($new_instance['description'])) ? sanitize_text_field($new_instance['description']) : '';
        $instance['facebook'] = (!empty($new_instance['facebook'])) ? esc_url_raw($new_instance['facebook']) : '';
        $instance['instagram'] = (!empty($new_instance['instagram'])) ? esc_url_raw($new_instance['instagram']) : '';
        $instance['linkedin'] = (!empty($new_instance['linkedin'])) ? esc_url_raw($new_instance['linkedin']) : '';
        $instance['pinterest'] = (!empty($new_instance['pinterest'])) ? esc_url_raw($new_instance['pinterest']) : '';
        $instance['youtube'] = (!empty($new_instance['youtube'])) ? esc_url_raw($new_instance['youtube']) : '';
        return $instance;
    }
}

// Register the widget
function register_about_widget() {
    register_widget('About_Widget');
}
add_action('widgets_init', 'register_about_widget');
