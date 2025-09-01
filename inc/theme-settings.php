<?php

if ( !class_exists( 'ReduxFramework' ) ) {  // Added missing parenthesis
    return; // Exit if Redux isn't active
}
$fa_icons = include get_template_directory() . '/inc/fa-icons.php';

$opt_name = 'theme_admin_settings'; // Define the option name for Redux

$args = array(
    'opt_name'    => $opt_name,
    'display_name' => 'Theme Settings',
    'menu_type'   => 'menu', // Shows in admin sidebar
    'dev_mode'    => false,
    'menu_title'  => 'Theme Settings',
    'menu_icon'   => 'dashicons-admin-settings',
);

Redux::set_args( $opt_name, $args );

Redux::set_section( $opt_name, array(
    'title'  => 'Teams',
    'id'     => 'teams-section',
    'icon'   => 'el el-group',
    'fields' => array(
        array(
            'id'       => 'team_members',
            'type'     => 'repeater',
            'title'    => 'Team Members',
            'group_values' => true,
            'item_name' => 'Member',
            'fields'   => array(
                array(
                    'id'    => 'name',
                    'type'  => 'text',
                    'title' => 'Name',
                ),
                array(
                    'id'    => 'designation',
                    'type'  => 'text',
                    'title' => 'Designation',
                ),
                array(
                    'id'    => 'qualification',
                    'type'  => 'text',
                    'title' => 'Qualification',
                ),
                array(
                    'id'    => 'experience',
                    'type'  => 'text',
                    'title' => 'Experience',
                ),
                array(
                    'id'    => 'about',
                    'type'  => 'textarea',
                    'title' => 'About',
                ),
                array(
                    'id'    => 'image',
                    'type'  => 'media',
                    'title' => 'Profile Picture',
                    'url'   => true,
                ),
                array(
                    'id'    => 'facebook',
                    'type'  => 'text',
                    'title' => 'Facebook URL',
                ),
                array(
                    'id'    => 'twitter',
                    'type'  => 'text',
                    'title' => 'Twitter URL',
                ),
                array(
                    'id'    => 'linkedin',
                    'type'  => 'text',
                    'title' => 'LinkedIn URL',
                ),
                array(
                    'id'    => 'instagram',
                    'type'  => 'text',
                    'title' => 'Instagram URL',
                ),
                array(
                    'id'    => 'youtube',
                    'type'  => 'text',
                    'title' => 'YouTube URL',
                ),
            ),
        ),
    ),
));

Redux::set_section( $opt_name, array(
    'title'  => 'Gallery',
    'id'     => 'gallery-section',
    'icon'   => 'el el-picture',
    'fields' => array(
        array(
            'id'    => 'section_info',
            'type'  => 'textarea',
            'title' => 'Sub Heading',
        ),
        array(
            'id'    => 'image',
            'type'  => 'gallery',
            'title' => 'Image',
            'url'   => true,
        ),
    ),
));

Redux::set_section( $opt_name, array(
    'title'  => 'Homepage',
    'id'     => 'homepage',
    'icon'   => 'el el-home',
    'fields' => array(
        array(
            'id'   => 'homepage-info',
            'type' => 'info',
            'desc' => 'Configure all homepage sections here',
        ),
    ),
));

Redux::set_section( $opt_name, array(
    'title'      => 'Welcome Section',
    'id'         => 'homepage-welcome',
    'subsection' => true,
    'fields'     => array(

        array(
            'id'       => 'welcome_heading',
            'type'     => 'text',
            'title'    => 'Heading',
            //'default'  => 'Bringing People Together',
        ),
        array(
            'id'       => 'welcome_subheading',
            'type'     => 'text',
            'title'    => 'Sub Heading',
            //'default'  => 'More Than 25 years of',
        ),
        array(
            'id'       => 'welcome_bg',
            'type'     => 'background',
            'title'    => 'Section Background',
            'preview'   => true,
            //'default'  => 'More Than 25 years of',
            'subtitle' => esc_html__('Body background with image, color, etc.', 'your-project-name'),
            'desc'     => esc_html__('This is the description field, again good for additional info.', 'your-project-name'),
            'default'  => array(
                'background-color' => '#1e73be',
            )
        ),
    ),
));

Redux::set_section( $opt_name, array(
    'title'      => 'Benefits',
    'id'         => 'homepage-benefits',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'benefits_subtitle',
            'type'     => 'text',
            'title'    => 'Subtitle',
            //'default'  => 'More Than 25 years of',
        ),
        array(
            'id'       => 'benefits_title',
            'type'     => 'text',
            'title'    => 'Title',
            //'default'  => 'Bringing People Together',
        ),
        array(
            'id'       => 'benefits_groups',
            'type'     => 'repeater',
            'title'    => 'Benefit Groups',
            'item_name' => 'Group',
            'limit'     => 3, // Fixed to 3 groups
            'fields'    => array(
                array(
                    'id'    => 'icon',
                    'type'  => 'select',
                    'title' => 'Icon',
                    'data'  => 'elusive-icons',
                    //'default' => 'el el-ok-circle',
                    'options' => $fa_icons,
                ),
                array(
                    'id'    => 'title',
                    'type'  => 'text',
                    'title' => 'Title',
                    //'default' => 'Professional Service',
                ),
                array(
                    'id'    => 'description',
                    'type'  => 'textarea',
                    'title' => 'Description',
                ),
            ),
        ),
    ),
));

Redux::set_section( $opt_name, array(
    'title'      => 'Features',
    'id'         => 'homepage-features',
    'subsection' => true,
    'fields'     => array(
        // Multi Image Field
        array(
            'id'       => 'feature_images',
            'type'     => 'multi_media', // Changed to multi_media to allow multiple image selection
            'title'    => 'Feature Images',
            'desc'     => 'Select multiple images for the feature section.',
            'default'  => array(),
        ),
        
        // Subheading Field
        array(
            'id'       => 'feature_subheading',
            'type'     => 'text',
            'title'    => 'Feature Subheading',
            'default'  => 'Subheading Text Here',
        ),
        
        // Heading Field
        array(
            'id'       => 'feature_heading',
            'type'     => 'text',
            'title'    => 'Feature Heading',
            'default'  => 'Feature Heading Here',
        ),
        
        // Repeater for Feature Details
        array(
            'id'       => 'feature_details',
            'type'     => 'repeater',
            'title'    => 'Feature Details',
            'item_name' => 'Detail',
            'limit'    => 5, // You can set a limit here (optional)
            'fields'   => array(
                array(
                    'id'       => 'feature_detail_heading',
                    'type'     => 'text',
                    'title'    => 'Detail Heading',
                    'default'  => 'Detail Heading Here',
                ),
                array(
                    'id'       => 'feature_detail_text',
                    'type'     => 'textarea',
                    'title'    => 'Detail Text',
                    'default'  => 'Detail description goes here.',
                ),
            ),
        ),
    ),
));


Redux::setSection($opt_name, array(
    'title'  => 'Membership Plans',
    'id'     => 'membership-plans',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'membership_title',
            'type'     => 'text',
            'title'    => 'Section Title',
            'default'  => 'Membership Plans'
        ),
        array(
            'id'       => 'membership_description',
            'type'     => 'textarea',
            'title'    => 'Description',
            'default'  => 'Lorem ipsum dolor sit amet...'
        ),
        array(
            'id'       => 'membership_plans',
            'type'     => 'repeater',
            'title'    => 'Features',
            'fields'   => array(
                array(
                    'id'    => 'feature',
                    'type'  => 'text',
                    'title' => 'Feature Name',
                    'placeholder' => 'Enter feature name'
                ),
                array(
                    'id'       => 'plan_selection',
                    'type'     => 'checkbox',
                    'title'    => 'Available In',
                    'options'  => array(
                        'free' => 'Free Plan',
                        'paid' => 'Paid Plan'
                    ),
                )
            )
        ),
        array(
            'id'       => 'signup_button_page',
            'type'     => 'select',
            'title'    => 'Sign Up Button Page',
            'data'     => 'pages',
            'placeholder' => 'Select a page'
        ),
        array(
            'id'       => 'membership_target_page',
            'type'     => 'select',
            'title'    => 'Pricing Page',
            'data'     => 'pages',
            'placeholder' => 'Select a page'
        )
    )
));

Redux::setSection($opt_name, array(
    'title'  => 'About Section',
    'id'     => 'about-section',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'about_site',
            'type'     => 'textarea',
            'title'    => 'About Us',
            'default'  => 'Lorem ipsum dolor sit amet...'
        )
    )
));

Redux::setSection($opt_name, array(
    'title'  => 'Introduc Section',
    'id'     => 'introduc-section',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'introduc_repeater',
            'type'     => 'repeater',
            'title'    => 'Features',
            'item_name' => 'Group',
            'limit'     => 3, // Fixed to 3 groups
            'fields'    => array(
                array(
                    'id'    => 'introduc_icon',
                    'type'  => 'select',
                    'title' => 'Icon',
                    'data'  => 'elusive-icons',
                    'options' => $fa_icons,
                ),
                array(
                    'id'    => 'introduc_title',
                    'type'  => 'text',
                    'title' => 'Title',

                ),
                array(
                    'id'    => 'introduc_description',
                    'type'  => 'textarea',
                    'title' => 'Description',
                ),
            ),
        ),
    )
));


Redux::setSection($opt_name, array(
    'title'  => 'About Us',
    'id'     => 'about-us',
    'icon'   => 'el el-info-circle',
    'subsection' => false,
    'fields' => array(
        array(
            'id'    => 'top_text',
            'type'  => 'text',
            'title' => 'Top Sub Heading',
        ),
        array(
            'id'    => 'heading_text',
            'type'  => 'text',
            'title' => 'Heading',
        ),
        array(
            'id'    => 'subheading_text',
            'type'  => 'text',
            'title' => 'Sub Heading',
        ),
        array(
            'id'       => 'about_us_features',
            'type'     => 'repeater',
            'title'    => 'About Us Features',
            'item_name' => 'Group',
            'limit'     => 3, // Fixed to 3 groups
            'fields'    => array(
                array(
                    'id'    => 'about_features_icon',
                    'type'  => 'select',
                    'title' => 'Icon',
                    'data'  => 'elusive-icons',
                    'options' => $fa_icons,
                ),
                array(
                    'id'    => 'about_features_title',
                    'type'  => 'text',
                    'title' => 'Title',

                ),
                array(
                    'id'    => 'about_features_description',
                    'type'  => 'textarea',
                    'title' => 'Description',
                ),
            ),
        ),
        array(
            'id'    => 'about_us_image_01',
            'type'  => 'media',
            'title' => 'About Us Image 01',
            'url'   => true,
        ),
        array(
            'id'    => 'about_us_image_02',
            'type'  => 'media',
            'title' => 'About Us Image 02',
            'url'   => true,
        ),
        array(
            'id'       => 'about_us_heading',
            'type'     => 'text',
            'title'    => __('Heading', 'your-textdomain'),
            'default'  => 'WELCOME TO',
        ),
        array(
            'id'       => 'about_us_subheading',
            'type'     => 'text',
            'title'    => __('Highlighted Subheading', 'your-textdomain'),
            'default'  => 'WEDDING MATRIMONY',
        ),
        array(
            'id'       => 'about_us_editor',
            'type'     => 'editor',
            'title'    => __('Main Content', 'your-textdomain'),
            'default'  => '<p>Best wedding matrimony... <a href="#">Click here</a> to start your matrimony service now.</p><hr><p>More details...</p>',
        ),        
        array(
            'id'    => 'faq_heading_text',
            'type'  => 'text',
            'title' => 'FAQ Heading',
        ),
        array(
            'id'    => 'faq_subheading_text',
            'type'  => 'text',
            'title' => 'FAQ Sub Heading',
        ),
        array(
            'id'       => 'fac_repeater ',
            'type'     => 'repeater',
            'title'    => 'FAQs',
            'item_name' => 'Group',
            //'limit'     => 3, // Fixed to 3 groups
            'fields'    => array(
                array(
                    'id'    => 'faq_question',
                    'type'  => 'text',
                    'title' => 'Question',
                ),
                array(
                    'id'    => 'faq_answer',
                    'type'  => 'textarea',
                    'title' => 'Answer',
                ),
            ),
        ),
        array(
            'id'    => 'faq_right_image',
            'type'  => 'media',
            'title' => 'FAQ Section Image',
            'url'   => true,
        ),
    )
));


Redux::setSection($opt_name, array(
    'title'  => 'Contact Us',
    'id'     => 'contact-us',
    'icon'   => 'el el-envelope',
    'subsection' => false,
    'fields' => array(
        array(
            'id'    => 'contact_us_top_text',
            'type'  => 'text',
            'title' => 'Top Sub Heading',
        ),
        array(
            'id'    => 'contact_us_heading_text',
            'type'  => 'text',
            'title' => 'Heading',
        ),
        array(
            'id'    => 'contact_us_subheading_text',
            'type'  => 'text',
            'title' => 'Sub Heading',
        ),
        array(
            'id'       => 'contact_us_features',
            'type'     => 'repeater',
            'title'    => 'Contact Us Features',
            'item_name' => 'Group',
            'limit'     => 2, // Fixed to 2 groups
            'fields'    => array(
                array(
                    'id'    => 'contact_features_icon',
                    'type'  => 'select',
                    'title' => 'Icon',
                    'data'  => 'elusive-icons',
                    'options' => $fa_icons,
                ),
                array(
                    'id'    => 'contact_features_title',
                    'type'  => 'text',
                    'title' => 'Title',

                ),
                array(
                    'id'    => 'contact_features_description',
                    'type'  => 'textarea',
                    'title' => 'Description',
                ),
                array(
                    'id'    => 'contact_features_link',
                    'type'  => 'text',
                    'title' => 'Link',
                ),
            ),
            
            
        ),
        array(
            'id'    => 'contact_left_side_heading',
            'type'  => 'text',
            'title' => 'Contact Left Side Heading',
        ),
        array(
            'id'    => 'contact_left_side_image',
            'type'  => 'media',
            'title' => 'Left Side Image',
            'url'   => true,
        ),
        array(
            'id'    => 'contact_left_side_text',
            'type'  => 'textarea',
            'title' => 'Contact Left Side Text',
        ),
        array(
            'id'    => 'google_maps_link',
            'type'  => 'text',
            'title' => 'Embed Google Maps Link',
        ),
    )
));
