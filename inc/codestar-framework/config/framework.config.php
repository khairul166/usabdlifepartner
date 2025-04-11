<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK SETTINGS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$settings      = array(
  'menu_title' => 'Theme Options',
  'menu_type'  => 'add_menu_page',
  'menu_slug'  => 'theme-options',
  'ajax_save'  => false,
);

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options        = array();

// ----------------------------------------
// a option section for options overview  -
// ----------------------------------------
$options[]      = array(
  'name'        => 'overwiew',
  'title'       => 'Overview',
  'icon'        => 'fa fa-star',

  // begin: fields
  'fields'      => array(

    // begin: a field
    array(
      'id'      => 'text_1',
      'type'    => 'text',
      'title'   => 'Text',
    ),
    // end: a field

    array(
      'id'      => 'textarea_1',
      'type'    => 'textarea',
      'title'   => 'Textarea',
      'help'    => 'This option field is useful. You will love it!',
    ),

    array(
      'id'      => 'upload_1',
      'type'    => 'upload',
      'title'   => 'Upload',
      'help'    => 'Upload a site logo for your branding.',
    ),

    array(
      'id'      => 'switcher_1',
      'type'    => 'switcher',
      'title'   => 'Switcher',
      'label'   => 'You want to update for this framework ?',
    ),

    array(
      'id'      => 'color_picker_1',
      'type'    => 'color_picker',
      'title'   => 'Color Picker',
      'default' => '#3498db',
    ),

    array(
      'id'      => 'checkbox_1',
      'type'    => 'checkbox',
      'title'   => 'Checkbox',
      'label'   => 'Did you like this framework ?',
    ),

    array(
      'id'      => 'radio_1',
      'type'    => 'radio',
      'title'   => 'Radio',
      'options' => array(
        'yes'   => 'Yes, Please.',
        'no'    => 'No, Thank you.',
      ),
      'help'    => 'Are you sure for this choice?',
    ),

    array(
      'id'             => 'select_1',
      'type'           => 'select',
      'title'          => 'Select',
      'options'        => array(
        'bmw'          => 'BMW',
        'mercedes'     => 'Mercedes',
        'volkswagen'   => 'Volkswagen',
        'other'        => 'Other',
      ),
      'default_option' => 'Select your favorite car',
    ),

    array(
      'id'      => 'number_1',
      'type'    => 'number',
      'title'   => 'Number',
      'default' => '10',
      'after'   => ' <i class="cs-text-muted">$ (dollars)</i>',
    ),

    array(
      'id'        => 'image_select_1',
      'type'      => 'image_select',
      'title'     => 'Image Select',
      'options'   => array(
        'value-1' => 'http://dummyimage.com/100x80/2ecc71/fff.png',
        'value-2' => 'http://dummyimage.com/100x80/e74c3c/fff.png',
        'value-3' => 'http://dummyimage.com/100x80/ffbc00/fff.png',
        'value-4' => 'http://dummyimage.com/100x80/3498db/fff.png',
        'value-5' => 'http://dummyimage.com/100x80/555555/fff.png',
      ),
    ),

    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => 'This is info notice field for your highlight sentence.',
    ),

    array(
      'id'      => 'background_1',
      'type'    => 'background',
      'title'   => 'Background',
    ),

    array(
      'type'    => 'notice',
      'class'   => 'warning',
      'content' => 'This is info warning field for your highlight sentence.',
    ),

    array(
      'id'      => 'icon_1',
      'type'    => 'icon',
      'title'   => 'Icon',
      'desc'    => 'Some description here for this option field.',
    ),

    array(
      'id'      => 'text_2',
      'type'    => 'text',
      'title'   => 'Text',
      'desc'    => 'Some description here for this option field.',
    ),

    array(
      'id'        => 'textarea_2',
      'type'      => 'textarea',
      'title'     => 'Textarea',
      'info'      => 'Some information here for this option field.',
      'shortcode' => true,
    ),

  ), // end: fields
);

$options[] = array(
  'name'   => 'teams_section',
  'title'  => 'Teams',
  'icon'   => 'fa fa-users',
  'fields' => array(

    array(
      'id'     => 'team_members',
      'type'   => 'group',
      'title'  => 'Team Members',
      'button_title' => 'Add Member',
      'accordion_title' => 'New Member',
      'fields' => array(

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
          'type'  => 'upload',
          'title' => 'Profile Picture',
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
);

$options[] = array(
  'name'   => 'gallery_section',
  'title'  => 'Gallery',
  'icon'   => 'fa fa-image',
  'fields' => array(

    array(
      'id'             => 'gallery_items',
      'type'           => 'group',
      'title'          => 'Gallery Items',
      'button_title'   => 'Add Image',
      'accordion_title'=> 'New Image',
      'fields'         => array(

        array(
          'id'    => 'image',
          'type'  => 'upload',
          'title' => 'Image',
        ),

        array(
          'id'    => 'caption',
          'type'  => 'text',
          'title' => 'Caption (optional)',
        ),

      ),
    ),

  ),
);


CSFramework::instance( $settings, $options );