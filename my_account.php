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
 * Template Name: My Account
 */

// Redirect to login page if user is not logged in
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url());
    exit;
}


// Get the current user ID
$user_id = get_current_user_id();

$email_verified = get_user_meta($user_id, 'email_verified', true);
$approval_status = get_user_meta($user_id, 'approval_status', true);

// if (!$email_verified && !is_admin()) {
//     echo "<p style='color:red;'>⚠️ Your email is not verified. Please check your inbox.</p>";
//     return;
// }

// if ($approval_status !== 'approvedd') {
//     echo "<p style='color:red;'>⛔ Your account is awaiting admin approval.</p>";
//     return;
// }

// $ban_status = get_user_meta($user_id, 'approval_status', true);
// if ($ban_status === 'banned') {
//     echo "<p style='color:red;'>🚫 Your account has been banned by the admin due to unusual activity.</p>";
//     return;
// }

// Fetch the profile picture URL (assuming it's stored in user_meta)
$profile_picture = get_user_meta($user_id, 'user_avatar', true);

//If no profile picture is set, use a default placeholder
if (empty($profile_picture)) {
    $profile_picture = get_template_directory_uri() . '/image/avater.webp'; // Path to your default avatar
}


// Fetch the "About Yourself" text from user meta
$about_yourself = get_user_meta($user_id, 'about_yourself', true);

// If no data is set, use a default placeholder
if (empty($about_yourself)) {
    $about_yourself = "";
}


//form Handling for profile picture
if (isset($_POST['upload_profile_picture'])) {
    $user_id = intval($_POST['user_id']);

    // Check if a file was uploaded
    if (!empty($_FILES['profile_picture']['name'])) {
        // Include WordPress file handling functions
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        // Handle the file upload
        $attachment_id = media_handle_upload('profile_picture', 0);

        if (is_wp_error($attachment_id)) {
            // Handle error
            echo '<div class="alert alert-danger">Error uploading file: ' . $attachment_id->get_error_message() . '</div>';
        } else {
            // Get the image URL
            $image_url = wp_get_attachment_url($attachment_id);

            // Save the URL to user meta
            update_user_meta($user_id, 'user_avatar', $image_url);

            // Redirect to refresh the page
            echo '<script>window.location.href = window.location.href;</script>';
        }
    } else {
        echo '<div class="alert alert-warning">No file selected.</div>';
    }
}


//About Yourself form handling
if (isset($_POST['update_about'])) {
    $user_id = intval($_POST['user_id']);
    $about_yourself = sanitize_textarea_field($_POST['about_yourself']);

    // Save the updated "About Yourself" text to user meta
    update_user_meta($user_id, 'about_yourself', $about_yourself);

    // Redirect to refresh the page
    echo '<script>window.location.href = window.location.href;</script>';
}

//Basic Details  form handling
// Fetch basic details from user meta
$first_name = get_user_meta($user_id, 'first_name', true);
$last_name = get_user_meta($user_id, 'last_name', true);
$age = get_user_meta($user_id, 'age', true);
$height = get_user_meta($user_id, 'height', true);
$weight = get_user_meta($user_id, 'weight', true);
$mother_tongue = get_user_meta($user_id, 'mother_tongue', true);
$marital_status = get_user_meta($user_id, 'marital_status', true);
$user_gender = get_user_meta($user_id, 'user_gender', true);
$body_type = get_user_meta($user_id, 'body_type', true);
$complexion = get_user_meta($user_id, 'complexion', true);
$physical_status = get_user_meta($user_id, 'physical_status', true);
$eating_habits = get_user_meta($user_id, 'eating_habits', true);
$drinking_habits = get_user_meta($user_id, 'drinking_habits', true);
$smoking_habits = get_user_meta($user_id, 'smoking_habits', true);

// Set default values if the fields are empty
$first_name = !empty($first_name) ? $first_name : 'Not set';
$last_name = !empty($last_name) ? $last_name : 'Not set';
$age = !empty($age) ? $age : 'Not set';
$height = !empty($height) ? $height : 'Not set';
$weight = !empty($weight) ? $weight : 'Not set';
$mother_tongue = !empty($mother_tongue) ? $mother_tongue : 'Not set';
$marital_status = !empty($marital_status) ? $marital_status : 'Not set';
$user_gender = !empty($user_gender) ? $user_gender : 'Not set';
$body_type = !empty($body_type) ? $body_type : 'Not set';
$complexion = !empty($complexion) ? $complexion : 'Not set';
$physical_status = !empty($physical_status) ? $physical_status : 'Not set';
$eating_habits = !empty($eating_habits) ? $eating_habits : 'Not set';
$drinking_habits = !empty($drinking_habits) ? $drinking_habits : 'Not set';
$smoking_habits = !empty($smoking_habits) ? $smoking_habits : 'Not set';
if (isset($_POST['update_basic_details'])) {
    $user_id = intval($_POST['user_id']);

    // Sanitize and save each field
    update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
    update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['last_name']));
    update_user_meta($user_id, 'age', sanitize_text_field($_POST['age']));
    update_user_meta($user_id, 'height', sanitize_text_field($_POST['height']));
    update_user_meta($user_id, 'weight', sanitize_text_field($_POST['weight']));
    update_user_meta($user_id, 'mother_tongue', sanitize_text_field($_POST['mother_tongue']));
    update_user_meta($user_id, 'marital_status', sanitize_text_field($_POST['marital_status']));
    update_user_meta($user_id, 'user_gender', sanitize_text_field($_POST['user_gender']));
    update_user_meta($user_id, 'body_type', sanitize_text_field($_POST['body_type']));
    update_user_meta($user_id, 'complexion', sanitize_text_field($_POST['complexion']));
    update_user_meta($user_id, 'physical_status', sanitize_text_field($_POST['physical_status']));
    update_user_meta($user_id, 'eating_habits', sanitize_text_field($_POST['eating_habits']));
    update_user_meta($user_id, 'drinking_habits', sanitize_text_field($_POST['drinking_habits']));
    update_user_meta($user_id, 'smoking_habits', sanitize_text_field($_POST['smoking_habits']));

    // Redirect to refresh the page
    echo '<script>window.location.href = window.location.href;</script>';
}


//contact details form handling
// Fetch contact details from user meta
$candidate_phone = get_user_meta($user_id, 'user_phone', true);
$candidate_country_code = get_user_meta($user_id, 'candidate_country_code', true);
$parent_phone = get_user_meta($user_id, 'user_g_phone', true);
$parent_country_code = get_user_meta($user_id, 'guardian_country_code', true);

// Fetch the user's email (from WordPress profile)
$user_data = get_userdata($user_id);
$email = $user_data->user_email;

// Set default values if the fields are empty
$candidate_phone = !empty($candidate_phone) ? $candidate_phone : 'Not set';
$candidate_country_code = !empty($candidate_country_code) ? $candidate_country_code : '+1';
$parent_phone = !empty($parent_phone) ? $parent_phone : 'Not set';
$parent_country_code = !empty($parent_country_code) ? $parent_country_code : '+1';

if (isset($_POST['update_contact_details'])) {
    $user_id = intval($_POST['user_id']);

    // Sanitize and save each field
    update_user_meta($user_id, 'candidate_phone', sanitize_text_field($_POST['candidate_phone']));
    update_user_meta($user_id, 'candidate_country_code', sanitize_text_field($_POST['candidate_country_code']));
    update_user_meta($user_id, 'parent_phone', sanitize_text_field($_POST['parent_phone']));
    update_user_meta($user_id, 'parent_country_code', sanitize_text_field($_POST['parent_country_code']));

    // Redirect to refresh the page
    echo '<script>window.location.href = window.location.href;</script>';
}


// Fetch religion from user meta
$religion = get_user_meta($user_id, 'religion', true);

// If no religion is set, use a default placeholder
if (empty($religion)) {
    $religion = 'Not set';
}

if (isset($_POST['update_religion_details'])) {
    $user_id = intval($_POST['user_id']);
    $religion = sanitize_text_field($_POST['religion']);

    // Validate the input
    if (empty($religion)) {
        echo '<div class="alert alert-warning">Please select a religion.</div>';
    } else {
        // Save the updated religion to user meta
        update_user_meta($user_id, 'religion', $religion);

        // Redirect to refresh the page
        echo '<script>window.location.href = window.location.href;</script>';
    }
}

// Fetch professional details from user meta
$education = get_user_meta($user_id, 'education', true);
$education_detail = get_user_meta($user_id, 'education_detail', true);
$employed_in = get_user_meta($user_id, 'employed_in', true);
$profession = get_user_meta($user_id, 'profession', true);
$profession_detail = get_user_meta($user_id, 'profession_detail', true);
$annual_income = get_user_meta($user_id, 'annual_income', true);

// Set default values if the fields are empty
$education = !empty($education) ? $education : 'Not set';
$education_detail = !empty($education_detail) ? $education_detail : 'Not set';
$employed_in = !empty($employed_in) ? $employed_in : 'Not set';
$profession = !empty($profession) ? $profession : 'Not set';
$profession_detail = !empty($profession_detail) ? $profession_detail : 'Not set';
$annual_income = !empty($annual_income) ? $annual_income : 'Not set';
if (isset($_POST['update_professional_details'])) {
    $user_id = intval($_POST['user_id']);

    // Sanitize and save each field
    update_user_meta($user_id, 'education', sanitize_text_field($_POST['education']));
    update_user_meta($user_id, 'education_detail', sanitize_text_field($_POST['education_detail']));
    update_user_meta($user_id, 'employed_in', sanitize_text_field($_POST['employed_in']));
    update_user_meta($user_id, 'profession', sanitize_text_field($_POST['profession']));
    update_user_meta($user_id, 'profession_detail', sanitize_text_field($_POST['profession_detail']));
    update_user_meta($user_id, 'annual_income', sanitize_text_field($_POST['annual_income']));

    // Redirect to refresh the page
    echo '<script>window.location.href = window.location.href;</script>';
}

//Astro Details
// Fetch astro details from user meta
$dob = get_user_meta($user_id, 'dob', true);
$place_of_birth = get_user_meta($user_id, 'place_of_birth', true);

// Set default values if the fields are empty
$dob = !empty($dob) ? $dob : 'Not set';
$place_of_birth = !empty($place_of_birth) ? $place_of_birth : 'Not set';

if (isset($_POST['update_astro_details'])) {
    $user_id = intval($_POST['user_id']);
    $dob = sanitize_text_field($_POST['dob']);
    $place_of_birth = sanitize_text_field($_POST['place_of_birth']);

    // Validate the input
    if (empty($dob) || empty($place_of_birth)) {
        echo '<div class="alert alert-warning">Please fill in all fields.</div>';
    } else {
        // Save the updated astro details to user meta
        update_user_meta($user_id, 'dob', $dob);
        update_user_meta($user_id, 'place_of_birth', $place_of_birth);

        // Redirect to refresh the page
        echo '<script>window.location.href = window.location.href;</script>';
    }
}


//partner details
// Fetch partner details from user meta
$about_partner = get_user_meta($user_id, 'about_partner', true);

// If no partner description is set, use a default placeholder
if (empty($about_partner)) {
    $about_partner = "";
}

if (isset($_POST['update_about_partner'])) {
    $user_id = intval($_POST['user_id']);
    $about_partner = sanitize_textarea_field($_POST['about_partner']);

    // Validate the input
    if (empty($about_partner)) {
        echo '<div class="alert alert-warning">Please enter a description.</div>';
    } else {
        // Save the updated partner description to user meta
        update_user_meta($user_id, 'about_partner', $about_partner);

        // Redirect to refresh the page
        echo '<script>window.location.href = window.location.href;</script>';
    }
}



// Fetch partner preferences from user meta
$partner_min_age = get_user_meta($user_id, 'partner_min_age', true);
$partner_max_age = get_user_meta($user_id, 'partner_max_age', true);
$partner_min_height = get_user_meta($user_id, 'partner_min_height', true);
$partner_max_height = get_user_meta($user_id, 'partner_max_height', true);
$partner_marital_status = get_user_meta($user_id, 'partner_marital_status', true);
$partner_mother_tongue = get_user_meta($user_id, 'partner_mother_tongue', true);
$partner_physical_status = get_user_meta($user_id, 'partner_physical_status', true);
$partner_eating_habits = get_user_meta($user_id, 'partner_eating_habits', true);
$partner_smoking_habits = get_user_meta($user_id, 'partner_smoking_habits', true);
$partner_drinking_habits = get_user_meta($user_id, 'partner_drinking_habits', true);

// Set default values if the fields are empty
$partner_min_age = !empty($partner_min_age) ? $partner_min_age : 'Not set';
$partner_max_age = !empty($partner_max_age) ? $partner_max_age : 'Not set';
$partner_min_height = !empty($partner_min_height) ? $partner_min_height : 'Not set';
$partner_max_height = !empty($partner_max_height) ? $partner_max_height : 'Not set';
$partner_marital_status = !empty($partner_marital_status) ? $partner_marital_status : 'Not set';
$partner_mother_tongue = !empty($partner_mother_tongue) ? $partner_mother_tongue : 'Not set';
$partner_physical_status = !empty($partner_physical_status) ? $partner_physical_status : 'Not set';
$partner_eating_habits = !empty($partner_eating_habits) ? $partner_eating_habits : 'Not set';
$partner_smoking_habits = !empty($partner_smoking_habits) ? $partner_smoking_habits : 'Not set';
$partner_drinking_habits = !empty($partner_drinking_habits) ? $partner_drinking_habits : 'Not set';
if (isset($_POST['update_partner_basic_preferences'])) {
    $user_id = intval($_POST['user_id']);

    // Sanitize and save each field
    update_user_meta($user_id, 'partner_min_age', sanitize_text_field($_POST['partner_min_age']));
    update_user_meta($user_id, 'partner_max_age', sanitize_text_field($_POST['partner_max_age']));
    update_user_meta($user_id, 'partner_min_height', sanitize_text_field($_POST['partner_min_height']));
    update_user_meta($user_id, 'partner_max_height', sanitize_text_field($_POST['partner_max_height']));
    update_user_meta($user_id, 'partner_marital_status', sanitize_text_field($_POST['partner_marital_status']));
    update_user_meta($user_id, 'partner_mother_tongue', sanitize_text_field($_POST['partner_mother_tongue']));
    update_user_meta($user_id, 'partner_physical_status', sanitize_text_field($_POST['partner_physical_status']));
    update_user_meta($user_id, 'partner_eating_habits', sanitize_text_field($_POST['partner_eating_habits']));
    update_user_meta($user_id, 'partner_smoking_habits', sanitize_text_field($_POST['partner_smoking_habits']));
    update_user_meta($user_id, 'partner_drinking_habits', sanitize_text_field($_POST['partner_drinking_habits']));

    // Redirect to refresh the page
    echo '<script>window.location.href = window.location.href;</script>';
}

// Fetch partner professional preferences from user meta
$partner_education = get_user_meta($user_id, 'partner_education', true);
$partner_profession = get_user_meta($user_id, 'partner_profession', true);
$partner_annual_income = get_user_meta($user_id, 'partner_annual_income', true);

// Set default values if the fields are empty
$partner_education = !empty($partner_education) ? $partner_education : 'Any Engineering / Computers...';
$partner_profession = !empty($partner_profession) ? $partner_profession : 'Any profession';
$partner_annual_income = !empty($partner_annual_income) ? $partner_annual_income : 'Any Annual Income';
if (isset($_POST['update_partner_professional_preferences'])) {
    $user_id = intval($_POST['user_id']);

    // Sanitize and save each field
    update_user_meta($user_id, 'partner_education', sanitize_text_field($_POST['partner_education']));
    update_user_meta($user_id, 'partner_profession', sanitize_text_field($_POST['partner_profession']));
    update_user_meta($user_id, 'partner_annual_income', sanitize_text_field($_POST['partner_annual_income']));

    // Redirect to refresh the page
    echo '<script>window.location.href = window.location.href;</script>';
}


// Fetch partner religious preferences from user meta
$partner_religion = get_user_meta($user_id, 'partner_religion', true);

// If no religion is set, use a default placeholder
if (empty($partner_religion)) {
    $partner_religion = 'Hindu';
}

if (isset($_POST['update_partner_religion'])) {
    $user_id = intval($_POST['user_id']);

    // Sanitize and save the partner religion
    update_user_meta($user_id, 'partner_religion', sanitize_text_field($_POST['partner_religion']));

    // Redirect to refresh the page
    echo '<script>window.location.href = window.location.href;</script>';
}


// Fetch partner location preferences from user meta
$partner_country = get_user_meta($user_id, 'partner_country', true);

// If no country is set, use a default placeholder
if (empty($partner_country)) {
    $partner_country = 'Bangladesh';
}
if (isset($_POST['update_partner_location'])) {
    $user_id = intval($_POST['user_id']);
    $partner_country = sanitize_text_field($_POST['partner_country']);

    // Validate the input
    if (empty($partner_country)) {
        echo '<div class="alert alert-warning">Please select a country.</div>';
    } else {
        // Save the updated partner country to user meta
        update_user_meta($user_id, 'partner_country', $partner_country);

        // Redirect to refresh the page
        echo '<script>window.location.href = window.location.href;</script>';
    }
}

// Fetch user photos from user meta (assuming photos are stored as an array of attachment IDs)
$user_photos = get_user_meta($user_id, 'user_photos', true);

// If no photos are set, initialize an empty array
if (empty($user_photos)) {
    $user_photos = [];
}

if (isset($_POST['upload_image'])) {
    $user_id = intval($_POST['user_id']);

    // Check if a file was uploaded
    if (!empty($_FILES['imageUpload']['name'])) {
        // Include necessary WordPress files
        if (!function_exists('media_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
        }

        // Validate file type and size
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB

        $file_type = $_FILES['imageUpload']['type'];
        $file_size = $_FILES['imageUpload']['size'];

        if (!in_array($file_type, $allowed_types)) {
            echo '<div class="alert alert-warning">Only JPEG, PNG, and GIF files are allowed.</div>';
        } elseif ($file_size > $max_size) {
            echo '<div class="alert alert-warning">File size must be less than 2MB.</div>';
        } else {
            // Handle the file upload
            $attachment_id = media_handle_upload('imageUpload', 0);

            if (is_wp_error($attachment_id)) {
                // Handle error
                echo '<div class="alert alert-danger">Error uploading file: ' . $attachment_id->get_error_message() . '</div>';
            } else {
                // Get the current user photos
                $user_photos = get_user_meta($user_id, 'user_photos', true);
                if (empty($user_photos)) {
                    $user_photos = [];
                }

                // Add the new photo to the array
                $user_photos[] = $attachment_id;

                // Save the updated photos array to user meta
                update_user_meta($user_id, 'user_photos', $user_photos);

                // Redirect to refresh the page
                echo '<script>window.location.href = window.location.href;</script>';
                exit; // Stop further execution after redirect
            }
        }
    } else {
        echo '<div class="alert alert-warning">No file selected.</div>';
    }
}

// Fetch linked accounts from user meta
$facebook = get_user_meta($user_id, 'facebook', true);
$instagram = get_user_meta($user_id, 'instagram', true);
$linkedin = get_user_meta($user_id, 'linkedin', true);
$x = get_user_meta($user_id, 'x', true);

// Set default values if the fields are empty
$facebook = !empty($facebook) ? $facebook : 'Not set';
$instagram = !empty($instagram) ? $instagram : 'Not set';
$linkedin = !empty($linkedin) ? $linkedin : 'Not set';
$x = !empty($x) ? $x : 'Not set';
if (isset($_POST['update_social_accounts'])) {
    $user_id = intval($_POST['user_id']);

    // Sanitize inputs
    $facebook = sanitize_text_field($_POST['facebook']);
    $instagram = sanitize_text_field($_POST['instagram']);
    $linkedin = sanitize_text_field($_POST['linkedin']);
    $x = sanitize_text_field($_POST['x']);

    // Save the updated linked accounts to user meta
    update_user_meta($user_id, 'facebook', $facebook);
    update_user_meta($user_id, 'instagram', $instagram);
    update_user_meta($user_id, 'linkedin', $linkedin);
    update_user_meta($user_id, 'x', $x);

    // Redirect to refresh the page
    echo '<script>window.location.href = window.location.href;</script>';
}
$password_change_message = handle_password_change();


$country = get_user_meta($user_id, 'country', true);
$division = get_user_meta($user_id, 'division', true);
$district = get_user_meta($user_id, 'district', true);
$upazila = get_user_meta($user_id, 'upazila', true);
$village = get_user_meta($user_id, 'village', true);
$landmark = get_user_meta($user_id, 'landmark', true);

$state = get_user_meta($user_id, 'state', true);
$city = get_user_meta($user_id, 'city', true);
$usaLandmark = get_user_meta($user_id, 'usaLandmark', true);
$user_status = get_user_meta($user_id, 'approval_status', true);

get_header();
?>

<section id="center" class="list  pt-5 pb-5">
    <div class="container-xl">
        <div class="row list_1">

            <div class="col-lg-12 col-md-12">
                <div class="list_dt">
                    <div class="list_dt1 shadow p-3">
                        <div class="list_1_right2_inner row mx-0">
                            <div class="col-md-3 ps-0 col-sm-4">
                                <div class="list_1_right2_inner_left">
                                    <!-- Profile Picture with Edit Button -->
                                    <div class="profile-picture-container">

                                        <?php if (!empty($profile_picture)) { ?>
                                            <img src="<?php echo esc_url($profile_picture); ?>"
                                                class="img-fluid profile-picture" width="100%" alt="Profile Picture">
                                        <?php } else {
                                            echo get_avatar($current_user->ID, 200, '', '', ['class' => 'img-fluid profile-picture']); ?>

                                        <?php } ?>


                                        <!-- Edit Button -->
                                        <button class="edit-profile-btn" data-toggle="modal"
                                            data-target="#profilePictureModal">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-8">
                                <div class="row row-cols-1 row-cols-lg-2 row-cols-md-1 list_1_right2_inner_right_inner">
                                    <div class="col">
                                        <div class="list_1_right2_inner_right">
                                            <b
                                                class="d-block mb-3 fs-5"><?php echo $first_name . ' ' . $last_name; ?></b>
                                            <ul class="font_15 mb-0">
                                                <li class="d-flex"><b class="me-2"> Age:</b>
                                                    <span><?php echo esc_html($age); ?></span>
                                                </li>
                                                <li class="d-flex mt-2"><b class="me-2"> Religion:</b> <span>
                                                        <?php echo esc_html($religion); ?></span></li>
                                                <li class="d-flex mt-2">
                                                    <b class="me-2">Location:</b>
                                                    <span>
                                                        <?php
                                                        if (strtolower($country) == 'bangladesh') {
                                                            echo esc_html($district . ', ' . $division);
                                                        } else {
                                                            echo esc_html($city . ', ' . $country);
                                                        }
                                                        ?>
                                                    </span>
                                                </li>

                                                <li class="d-flex mt-2"><b class="me-2"> Education:</b> <span>
                                                        <?php echo esc_html($education); ?></span></li>
                                                <li class="d-flex mt-2"><b class="me-2"> Profession:</b> <span>
                                                        <?php echo esc_html($profession); ?></span></li>
                                                <li class="d-flex mt-2"><b class="me-2"> Annual Income:</b>
                                                    <span><?php echo esc_html($annual_income); ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="list_1_right2_inner_right">
                                            <p class="mt-1"><?php echo esc_html($about_yourself); ?></p>
                                            <ul class="mb-0 d-flex social_brands">
                                                <!-- Facebook -->
                                                <?php if (!empty($facebook) && $facebook !== 'Not set'): ?>
                                                    <li>
                                                        <a class="bg-primary d-inline-block text-white text-center"
                                                            href="https://www.facebook.com/<?php echo esc_attr($facebook); ?>"
                                                            target="_blank">
                                                            <i class="bi bi-facebook"></i>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>

                                                <!-- Instagram -->
                                                <?php if (!empty($instagram) && $instagram !== 'Not set'): ?>
                                                    <li class="ms-2">
                                                        <a class="bg-success d-inline-block text-white text-center"
                                                            href="https://www.instagram.com/<?php echo esc_attr($instagram); ?>"
                                                            target="_blank">
                                                            <i class="bi bi-instagram"></i>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>

                                                <!-- LinkedIn -->
                                                <?php if (!empty($linkedin) && $linkedin !== 'Not set'): ?>
                                                    <li class="ms-2">
                                                        <a class="bg-warning d-inline-block text-white text-center"
                                                            href="https://www.linkedin.com/in/<?php echo esc_attr($linkedin); ?>"
                                                            target="_blank">
                                                            <i class="bi bi-linkedin"></i>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>

                                                <!-- X (Twitter) -->
                                                <?php if (!empty($x) && $x !== 'Not set'): ?>
                                                    <li class="ms-2">
                                                        <a class="bg-dark d-inline-block text-white text-center"
                                                            href="https://twitter.com/<?php echo esc_attr($x); ?>"
                                                            target="_blank">
                                                            <i class="bi bi-twitter-x"></i>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($email_verified == false): ?>
                        <div class="list_dt1 shadow p-3 mt-4">
                            <div class="list_1_right2_inner row mx-0">
                                <p class="text-danger">Your email has not been verified yet. Please check your inbox and
                                    verify it to edit your profile.</p>
                            </div>
                        </div>
                    <?php elseif ($email_verified == true && $user_status != 'approved'): ?>
                        <div class="list_dt1 shadow p-3 mt-4">
                            <div class="list_1_right2_inner row mx-0">
                                <p class="text-info">✅ Your email has been verified. Please wait for admin approval to edit
                                    your profile.</p>
                            </div>
                        </div>
                    <?php endif; ?>



                    <div class="mt-4">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                    role="tab" aria-controls="nav-home" aria-selected="true">Basic
                                    Detals</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                    role="tab" aria-controls="nav-profile" aria-selected="false">Settings</a>
                                <a class="nav-item nav-link" id="nav-interest-tab" data-toggle="tab"
                                    href="#received-interests" role="tab" aria-controls="received-interests"
                                    aria-selected="false">Interests</a>
                            </div>
                        </nav>
                        <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                                <div class="list_dt2 mt-4 p-3 shadow">

                                    <h3>Personal Information</h3>
                                    <hr class="line mb-4">
                                    <h5 class="mb-3">
                                        <i class="bi bi-gender-female theme-text-color me-1 align-middle"></i>
                                        About
                                        <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                            data-bs-target="<?php
                                            if ($email_verified == true && $user_status == 'approved') {
                                                echo '#aboutmodal';
                                            } else {
                                                echo '#verifyEmailModal';
                                            }
                                            ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                    </h5>
                                    <p class="px_28 mb-0"><?php echo esc_html($about_yourself); ?></p>


                                    <h5 class="mb-3 mt-4">
                                        <i class="bi bi-person theme-text-color me-1 align-middle"></i>
                                        Basic Details
                                        <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                            data-bs-target="<?php if ($email_verified == true && $user_status == 'approved') {
                                                echo "#basicdetailsmodal";
                                            } else {
                                                echo '#verifyEmailModal';
                                            } ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <!-- <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                            data-bs-target="#basicdetailsmodal">
                                            <i class="bi bi-pencil-square"></i>
                                        </button> -->
                                    </h5>
                                    <ul class="px_28 font_14 justify-content-between d-flex mb-0 flex-wrap">
                                        <li>
                                            <b class="d-block">Name:</b>
                                            <b class="d-block mt-2">Age:</b>
                                            <b class="d-block mt-2">Height:</b>
                                            <b class="d-block mt-2">Weight:</b>
                                            <b class="d-block mt-2">Mother Tongue:</b>
                                            <b class="d-block mt-2">Marital Status:</b>
                                            <b class="d-block mt-2">Gender:</b>
                                        </li>
                                        <li>
                                            <span
                                                class="d-block"><?php echo esc_html($first_name . ' ' . $last_name); ?></span>
                                            <span class="d-block mt-2"><?php echo esc_html($age); ?> Yrs</span>
                                            <span class="d-block mt-2"><?php echo esc_html($height); ?> Inch</span>
                                            <span class="d-block mt-2"><?php echo esc_html($weight); ?> Kg</span>
                                            <span class="d-block mt-2"><?php echo esc_html($mother_tongue); ?></span>
                                            <span class="d-block mt-2"><?php echo esc_html($marital_status); ?></span>
                                            <span class="d-block mt-2"><?php echo esc_html($user_gender); ?></span>
                                        </li>
                                        <li>
                                            <b class="d-block">Body Type:</b>
                                            <b class="d-block mt-2">Complexion:</b>
                                            <b class="d-block mt-2">Physical Status:</b>
                                            <b class="d-block mt-2">Eating Habits:</b>
                                            <b class="d-block mt-2">Drinking Habits:</b>
                                            <b class="d-block mt-2">Smoking Habits:</b>
                                        </li>
                                        <li>
                                            <span class="d-block"><?php echo esc_html($body_type); ?></span>
                                            <span class="d-block mt-2"><?php echo esc_html($complexion); ?></span>
                                            <span class="d-block mt-2"><?php echo esc_html($physical_status); ?></span>
                                            <span class="d-block mt-2"><?php echo esc_html($eating_habits); ?></span>
                                            <span class="d-block mt-2"><?php echo esc_html($drinking_habits); ?></span>
                                            <span class="d-block mt-2"><?php echo esc_html($smoking_habits); ?></span>
                                        </li>
                                    </ul>
                                    <div class="row row-cols-1 row-cols-md-2 list_dt2_inner">
                                        <div class="col">
                                            <div class="list_dt2_inner_left">
                                                <h5 class="mb-3 mt-4">
                                                    <i class="bi bi-phone theme-text-color me-1 align-middle"></i>
                                                    Contact Details
                                                    <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                                        data-bs-target="<?php if ($email_verified == true && $user_status == 'approved') {
                                                            echo "#contactdetailsmodal";
                                                        } else {
                                                            echo '#verifyEmailModal';
                                                        } ?>">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <!-- <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                                        data-bs-target="#contactdetailsmodal">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button> -->
                                                </h5>
                                                <ul class="px_28 font_14 mb-0">
                                                    <li class="d-flex">
                                                        <b class="me-2">Your Contact Number:</b>
                                                        <span><?php echo esc_html($candidate_country_code . ' ' . $candidate_phone); ?></span>
                                                    </li>
                                                    <li class="d-flex mt-2">
                                                        <b class="me-2">Parent Contact Number:</b>
                                                        <span><?php echo esc_html($parent_country_code . ' ' . $parent_phone); ?></span>
                                                    </li>

                                                    <li class="d-flex mt-2">
                                                        <b class="me-2">Email:</b>
                                                        <span>
                                                            <?php
                                                            if ($email_verified == true) {
                                                                echo esc_html($email) . ' <i class="fas fa-check-circle text-primary"></i>';
                                                            } else {
                                                                echo esc_html($email);
                                                            }
                                                            ?>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="list_dt2_inner_left">
                                                <h5 class="mb-3 mt-4">
                                                    <i class="bi bi-book theme-text-color me-1 align-middle"></i>
                                                    Religion Information
                                                    <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                                        data-bs-target="<?php if ($email_verified == true && $user_status == 'approved') {
                                                            echo "#userreligiondetailsmodal";
                                                        } else {
                                                            echo '#verifyEmailModal';
                                                        } ?>">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <!-- <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                                        data-bs-target="#userreligiondetailsmodal">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button> -->
                                                </h5>
                                                <ul class="px_28 font_14 mb-0">
                                                    <li class="d-flex">
                                                        <b class="me-2">Religion:</b>
                                                        <span><?php echo esc_html($religion); ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="mb-3 mt-4"><i class="bi bi-map theme-text-color me-1 align-middle"></i>
                                        Location</h5>
                                    <?php
                                    if ($country == "Bangladesh") {
                                        ?>
                                        <ul class="px_28 font_14 mb-0">
                                            <li class="d-flex"><b class="me-2"> Country:</b>
                                                <span><?php echo $country; ?></span>
                                            </li>
                                            <li class="d-flex mt-2"><b class="me-2"> Division:</b>
                                                <span><?php echo $division; ?></span>
                                            </li>
                                            <li class="d-flex mt-2"><b class="me-2"> District:</b>
                                                <span><?php echo $district; ?></span>
                                            </li>
                                            <li class="d-flex mt-2"><b class="me-2"> Thana:</b>
                                                <span><?php echo $upazila; ?></span>
                                            </li>
                                            <li class="d-flex mt-2"><b class="me-2"> Village:</b>
                                                <span><?php echo $village; ?></span>
                                            </li>
                                            <li class="d-flex mt-2"><b class="me-2"> Landmark:</b>
                                                <span><?php echo $landmark; ?></span>
                                            </li>
                                        </ul>
                                        <?php
                                    } else {
                                        ?>
                                        <ul class="px_28 font_14 mb-0">
                                            <li class="d-flex"><b class="me-2"> Country:</b>
                                                <span><?php echo $country; ?></span>
                                            </li>
                                            <li class="d-flex mt-2"><b class="me-2"> State:</b> <span>
                                                    <?php echo esc_html($state); ?></span></li>
                                            <li class="d-flex mt-2"><b class="me-2"> Citizenship:</b>
                                                <span><?php echo esc_html($city); ?></span>
                                            </li>
                                            <li class="d-flex mt-2"><b class="me-2"> City:</b>
                                                <span><?php echo esc_html($usaLandmark); ?></span>
                                            </li>
                                        </ul>
                                        <?php
                                    }
                                    ?>

                                    <div class="row row-cols-1 row-cols-md-2 list_dt2_inner">
                                        <div class="col">
                                            <div class="list_dt2_inner_left">
                                                <h5 class="mb-3 mt-4">
                                                    <i class="bi bi-person theme-text-color me-1 align-middle"></i>
                                                    Professional Information
                                                    <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                                        data-bs-target="<?php if ($email_verified == true && $user_status == 'approved') {
                                                            echo "#professionaldetailsmodal";
                                                        } else {
                                                            echo '#verifyEmailModal';
                                                        } ?>">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <!-- <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                                        data-bs-target="#professionaldetailsmodal">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button> -->
                                                </h5>
                                                <ul class="px_28 font_14 mb-0">
                                                    <li class="d-flex">
                                                        <b class="me-2">Education:</b>
                                                        <span><?php echo esc_html($education); ?></span>
                                                    </li>
                                                    <li class="d-flex mt-2">
                                                        <b class="me-2">Education in Detail:</b>
                                                        <span><?php echo esc_html($education_detail); ?></span>
                                                    </li>
                                                    <li class="d-flex mt-2">
                                                        <b class="me-2">Employed in:</b>
                                                        <span><?php echo esc_html($employed_in); ?></span>
                                                    </li>
                                                    <li class="d-flex mt-2">
                                                        <b class="me-2">profession:</b>
                                                        <span><?php echo esc_html($profession); ?></span>
                                                    </li>
                                                    <li class="d-flex mt-2">
                                                        <b class="me-2">profession in Detail:</b>
                                                        <span><?php echo esc_html($profession_detail); ?></span>
                                                    </li>
                                                    <li class="d-flex mt-2">
                                                        <b class="me-2">Annual Income:</b>
                                                        <span><?php echo esc_html($annual_income); ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="list_dt2_inner_left">
                                                <h5 class="mb-3 mt-4">
                                                    <i
                                                        class="bi bi-life-preserver theme-text-color me-1 align-middle"></i>
                                                    Astro Details
                                                    <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                                        data-bs-target="<?php if ($email_verified == true && $user_status == 'approved') {
                                                            echo "#astrodetailsmodal";
                                                        } else {
                                                            echo '#verifyEmailModal';
                                                        } ?>">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <!-- <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                                        data-bs-target="#astrodetailsmodal">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button> -->
                                                </h5>
                                                <ul class="px_28 font_14 mb-0">
                                                    <li class="d-flex">
                                                        <b class="me-2">Date of Birth:</b>
                                                        <span><?php echo esc_html($dob); ?></span>
                                                    </li>
                                                    <li class="d-flex mt-2">
                                                        <b class="me-2">Place of Birth:</b>
                                                        <span><?php echo esc_html($place_of_birth); ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="list_dt2_inner_left">
                                                <h5 class="mb-3 mt-4">
                                                    <i
                                                        class="bi bi-life-preserver theme-text-color me-1 align-middle"></i>
                                                    Linked Account
                                                    <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                                        data-bs-target="<?php if ($email_verified == true && $user_status == 'approved') {
                                                            echo "#socialaccounts";
                                                        } else {
                                                            echo '#verifyEmailModal';
                                                        } ?>">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <!-- <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                                        data-bs-target="#socialaccounts">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button> -->
                                                </h5>
                                                <ul class="px_28 font_14 mb-0">
                                                    <li class="d-flex">
                                                        <b class="me-2">Facebook:</b>
                                                        <span><?php echo esc_html($facebook); ?></span>
                                                    </li>
                                                    <li class="d-flex mt-2">
                                                        <b class="me-2">Instagram:</b>
                                                        <span><?php echo esc_html($instagram); ?></span>
                                                    </li>
                                                    <li class="d-flex mt-2">
                                                        <b class="me-2">LinkedIn:</b>
                                                        <span><?php echo esc_html($linkedin); ?></span>
                                                    </li>
                                                    <li class="d-flex mt-2">
                                                        <b class="me-2">X:</b>
                                                        <span><?php echo esc_html($x); ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>




                                </div>
                                <div class="list_dt2 mt-4 p-3 shadow">
                                    <h3>Partner Preferences</h3>
                                    <hr class="line mb-4">
                                    <h5 class="mb-3">
                                        <i class="bi bi-gender-male theme-text-color me-1 align-middle"></i>
                                        About Partner

                                        <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                            data-bs-target="<?php if ($email_verified == true && $user_status == 'approved') {
                                                echo "#about_partner_modal";
                                            } else {
                                                echo '#verifyEmailModal';
                                            } ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </h5>
                                    <p class="px_28 mb-0"><?php echo esc_html($about_partner); ?></p>
                                    <h5 class="mb-3 mt-4"><i
                                            class="bi bi-person theme-text-color me-1 align-middle"></i>
                                        Basic
                                        Preferences <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                            data-bs-target="<?php if ($email_verified == true && $user_status == 'approved') {
                                                echo "#partner_basic_modal";
                                            } else {
                                                echo '#verifyEmailModal';
                                            } ?>"><i class="bi bi-pencil-square"></i></button>
                                    </h5>
                                    <ul class="px_28 font_14 justify-content-between d-flex mb-0 flex-wrap">
                                        <li>
                                            <b class="d-block">Groom's Age:</b>
                                            <b class="d-block mt-2">Height:</b>
                                            <b class="d-block mt-2">Marital Status:</b>
                                            <b class="d-block mt-2">Mother Tongue:</b>
                                            <b class="d-block mt-2">Physical Status:</b>
                                            <b class="d-block mt-2">Eating Habits:</b>
                                        </li>
                                        <li>
                                            <span class="d-block"><?php echo esc_html($partner_min_age); ?> -
                                                <?php echo esc_html($partner_max_age); ?> Yrs</span>
                                            <span class="d-block mt-2"><?php echo esc_html($partner_min_height); ?> -
                                                <?php echo esc_html($partner_max_height); ?></span>
                                            <span
                                                class="d-block mt-2"><?php echo esc_html($partner_marital_status); ?></span>
                                            <span
                                                class="d-block mt-2"><?php echo esc_html($partner_mother_tongue); ?></span>
                                            <span
                                                class="d-block mt-2"><?php echo esc_html($partner_physical_status); ?></span>
                                            <span
                                                class="d-block mt-2"><?php echo esc_html($partner_eating_habits); ?></span>
                                        </li>
                                        <li>
                                            <b class="d-block">Smoking Habits:</b>
                                            <b class="d-block mt-2">Drinking Habits:</b>
                                        </li>
                                        <li>
                                            <span
                                                class="d-block"><?php echo esc_html($partner_smoking_habits); ?></span>
                                            <span
                                                class="d-block mt-2"><?php echo esc_html($partner_drinking_habits); ?></span>
                                        </li>
                                    </ul>
                                    <div class="row row-cols-1 row-cols-md-2 list_dt2_inner">
                                        <div class="col">
                                            <div class="list_dt2_inner_left">
                                                <h5 class="mb-3 mt-4">
                                                    <i class="bi bi-person theme-text-color me-1 align-middle"></i>
                                                    Professional Preferences
                                                    <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                                        data-bs-target="<?php if ($email_verified == true && $user_status == 'approved') {
                                                            echo "#partner_professional_modal";
                                                        } else {
                                                            echo '#verifyEmailModal';
                                                        } ?>">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                </h5>
                                                <ul class="px_28 font_14 mb-0">
                                                    <li class="d-flex">
                                                        <b class="me-2">Education:</b>
                                                        <span><?php echo esc_html($partner_education); ?></span>
                                                    </li>
                                                    <li class="d-flex mt-2">
                                                        <b class="me-2">profession:</b>
                                                        <span><?php echo esc_html($partner_profession); ?></span>
                                                    </li>
                                                    <li class="d-flex mt-2">
                                                        <b class="me-2">Annual Income:</b>
                                                        <span><?php echo esc_html($partner_annual_income); ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="list_dt2_inner_left">
                                                <h5 class="mb-3 mt-4">
                                                    <i class="bi bi-book theme-text-color me-1 align-middle"></i>
                                                    Religious Preferences
                                                    <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                                        data-bs-target="<?php if ($email_verified == true && $user_status == 'approved') {
                                                            echo "#partnerreligiondetailsmodal";
                                                        } else {
                                                            echo '#verifyEmailModal';
                                                        } ?>">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                </h5>
                                                <ul class="px_28 font_14 mb-0">
                                                    <li class="d-flex">
                                                        <b class="me-2">Religion:</b>
                                                        <span><?php echo esc_html($partner_religion); ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="mb-3 mt-4"><i class="bi bi-map theme-text-color me-1 align-middle"></i>
                                        Location
                                        Preferences <button class="btn btn-sm float-end edit-btn" data-bs-toggle="modal"
                                            data-bs-target="<?php if ($email_verified == true && $user_status == 'approved') {
                                                echo "#partnerlocationdetailsmodal";
                                            } else {
                                                echo '#verifyEmailModal';
                                            } ?>"><i class="bi bi-pencil-square"></i></button></h5>
                                    <ul class="px_28 font_14 mb-0">
                                        <li class="d-flex">
                                            <b class="me-2">Country:</b>
                                            <span><?php echo esc_html($partner_country); ?></span>
                                        </li>
                                    </ul>

                                </div>

                                <div class="list_dt2 mt-4 p-3 shadow">
                                    <h3>Photo Gallery</h3>
                                    <hr class="line mb-4">
                                    <!-- Photo Gallery Grid -->
                                    <div class="row">
                                        <!-- Display User Photos -->
                                        <?php foreach ($user_photos as $photo_id): ?>
                                            <?php $photo_url = wp_get_attachment_url($photo_id); ?>
                                            <div class="col-md-2 mb-2">
                                                <div class="gallery-item position-relative">
                                                    <a href="<?php echo esc_url($photo_url); ?>" data-lightbox="gallery">
                                                        <img src="<?php echo esc_url($photo_url); ?>" alt="Gallery Image"
                                                            class="img-fluid rounded">
                                                    </a>
                                                    <!-- Delete Button -->
                                                    <button
                                                        class="delete-photo-btn btn btn-danger btn-sm position-absolute top-0 end-0 m-2"
                                                        data-photo-id="<?php echo esc_attr($photo_id); ?>">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                        <!-- Upload Option -->
                                        <div class="col-md-2 mb-2">
                                            <div class="gallery-item upload-item" data-toggle="modal" data-target="<?php if ($email_verified == true && $user_status == 'approved') {
                                                echo "#uploadModal";
                                            } else {
                                                echo '#verifyEmailModal';
                                            } ?>">
                                                <div class="upload-icon">
                                                    <i class="bi bi-plus"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                aria-labelledby="nav-profile-tab">
                                <div class="list_dt2 mt-4 p-3 shadow">
                                    <h3>Account Settings</h3>
                                    <hr class="line mb-4">
                                    <?php if (!empty($password_change_message)): ?>
                                        <?php echo $password_change_message; ?>
                                    <?php endif; ?>
                                    <h5 class="mb-3">
                                        <i class="bi bi-gender-male theme-text-color me-1 align-middle"></i>
                                        Change Password
                                    </h5>
                                    <form method="post" action="">
                                        <?php wp_nonce_field('change_password_action', 'change_password_nonce'); ?>
                                        <div class="col-md-6 pt-1 pb-2">
                                            <label for="c_password" class="form-label">Current Password</label>
                                            <input type="password" id="c_password" name="c_password"
                                                class="form-control" placeholder="Enter current Password" required>
                                        </div>
                                        <div class="col-md-6 pt-1 pb-2">
                                            <label for="new_password" class="form-label">New Password</label>
                                            <input type="password" id="new_password" name="new_password"
                                                class="form-control" placeholder="Enter New Password" required>
                                        </div>
                                        <div class="col-md-6 pt-1 pb-2">
                                            <label for="re_new_password" class="form-label">Re-type New Password</label>
                                            <input type="password" id="re_new_password" name="re_new_password"
                                                class="form-control" placeholder="Re-type New Password" required>
                                        </div>
                                        <button type="submit" name="change_password_submit" class="btn theme-btn">Change
                                            Password</button>
                                    </form>
                                </div>
                            </div>
                            <div id="received-interests" class="tab-pane fade">
                                <h4 class="mb-4">💌 Interests Received</h4>
                                <?php
                                global $wpdb;
                                $user_id = get_current_user_id();
                                $interests = $wpdb->get_results("
        SELECT i.*, u.display_name, um.meta_value AS profile_picture
        FROM {$wpdb->prefix}interests i
        JOIN {$wpdb->users} u ON i.from_user_id = u.ID
        LEFT JOIN {$wpdb->prefix}usermeta um ON u.ID = um.user_id AND um.meta_key = 'profile_picture'
        WHERE i.to_user_id = $user_id
        ORDER BY i.sent_at DESC
    ");

                                if ($interests):
                                    foreach ($interests as $row):
                                        $profile_picture = get_user_meta($row->from_user_id, 'user_avatar', true);
                                        $avatar = $profile_picture ?: get_template_directory_uri() . '/assets/img/default-avatar.png';
                                        $u_first_name = get_user_meta($row->from_user_id, 'first_name', true);
                                        $u_last_name = get_user_meta($row->from_user_id, 'last_name', true);
                                        $full_name  = trim("$u_first_name $u_last_name");
                                        ?>
                                        
                                        <div class="d-flex align-items-center gap-4 mb-4 p-3 border rounded shadow-sm"
                                            style="background-color: #fff;">
                                            <img src="<?= esc_url($avatar); ?>" alt="Avatar" width="70" height="70"
                                                class="rounded-circle" style="object-fit: cover;">


                                            <div style="flex: 1;">
                                                <p class="mb-2 fs-5"
                                                    style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                                                    <a href="<?= esc_url(home_url('/user-details/?user_id=' . $row->from_user_id)); ?>"
                                                        class="fw-bold text-dark text-decoration-none">
                                                        <?= esc_html($full_name); ?>
                                                    </a>
                                                    <span class="text-muted">sent you an interest.</span>

                                                </p>

                                                <?php if ($row->status === 'pending'): ?>
    <div class="d-flex gap-2">
        <button class="btn btn-sm respond-interest"
            style="background-color: #5e2ced; color: white; padding: 8px 24px; font-weight: bold;"
            data-id="<?= esc_attr($row->id); ?>" data-action="accepted">
            Accept
        </button>
        <button class="btn btn-sm respond-interest"
            style="background-color: #f44336; color: white; padding: 8px 24px; font-weight: bold;"
            data-id="<?= esc_attr($row->id); ?>" data-action="rejected">
            Reject
        </button>
    </div>
<?php else: ?>

                                                    <span class="badge bg-success"><?= ucfirst($row->status); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php
                                    endforeach;
                                else:
                                    echo '<p>No interests received yet.</p>';
                                endif;
                                ?>

                                <h4 class="mb-3 mt-4">📤 Interests Sent</h4>
                                <?php
                                $current_user = get_current_user_id();
                                $sent_interests = $wpdb->get_results("
    SELECT i.*, u.display_name, u.ID 
    FROM {$wpdb->prefix}interests i
    JOIN {$wpdb->users} u ON i.to_user_id = u.ID
    WHERE i.from_user_id = $current_user
    ORDER BY i.sent_at DESC
");

                                if ($sent_interests):
                                    foreach ($sent_interests as $row):
                                        $profile_picture = get_user_meta($row->to_user_id, 'user_avatar', true);
                                        $avatar = $profile_picture ?: 'https://via.placeholder.com/70';
                                        ?>
                                        <div class="d-flex align-items-center p-3 mb-3 border rounded">
                                            <img src="<?= esc_url($avatar); ?>" alt="Avatar" width="50" height="50"
                                                class="rounded-circle me-3" style="object-fit: cover;">
                                            <div>
                                                <a href="<?= esc_url(home_url('/user-details/?user_id=' . $row->to_user_id)); ?>"
                                                    class="fw-bold text-dark text-decoration-none">
                                                    <?= esc_html($row->display_name); ?>
                                                </a>
                                                <span class="text-muted">– you sent an interest.</span>
                                                <p class="mb-0"><small>Status:
                                                        <strong><?= ucfirst($row->status); ?></strong></small></p>
                                            </div>
                                        </div>
                                        <?php
                                    endforeach;
                                else:
                                    echo '<p class="text-muted">You haven\'t sent any interests yet.</p>';
                                endif;
                                ?>

                            </div>

                        </div>
                    </div>


                </div>
            </div>



        </div>
    </div>
</section>



<!-- Modals -->
<!-- About Details Modal -->
<div class="modal fade" id="aboutmodal" tabindex="-1" aria-labelledby="aboutmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="aboutmodalLabel">Edit About Yourself</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="aboutForm" method="post">
                    <div class="mb-3">
                        <label for="about-modal" class="form-label">About Yourself</label>
                        <textarea class="form-control" id="about-modal" name="about_yourself" rows="5"
                            style="height: 300px;"><?php echo esc_textarea($about_yourself); ?></textarea>
                    </div>
                    <!-- Add a hidden field for the user ID -->
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="aboutForm" name="update_about" class="btn theme-btn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Basic Details Modal -->
<div class="modal fade" id="basicdetailsmodal" tabindex="-1" aria-labelledby="basicdetailsmodalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="basicdetailsmodalLabel">Edit Basic Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="basicdetailsForm" method="post" action="">
                    <div class="mb-3">
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">First Name</span>
                            <input class="form-control w-75" placeholder="Enter First Name" name="first_name" id="fname"
                                type="text" value="<?php echo esc_attr($first_name); ?>">
                        </div>
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Last Name</span>
                            <input class="form-control w-75" placeholder="Enter Last Name" name="last_name" id="lname"
                                type="text" value="<?php echo esc_attr($last_name); ?>">
                        </div>
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Age</span>
                            <input class="form-control w-75" placeholder="Enter your Age" name="age" id="user_age"
                                type="text" value="<?php echo esc_attr($age); ?>">
                        </div>
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Height</span>
                            <select id="user_height" name="height" class="form-control w-75">
                                <option value="" disabled>Select One</option>
                                <option value="5 Ft 3 In / 160 Cms" <?php selected($height, '5 Ft 3 In / 160 Cms'); ?>>5
                                    Ft 3 In / 160 Cms</option>
                                <!-- Add more height options as needed -->
                            </select>
                        </div>
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Weight</span>
                            <select id="user_weight" name="weight" class="form-control w-75">
                                <option value="" disabled>Select One</option>
                                <option value="45 Kgs / 99 lbs" <?php selected($weight, '45 Kgs / 99 lbs'); ?>>45 Kgs /
                                    99 lbs</option>
                                <!-- Add more weight options as needed -->
                            </select>
                        </div>
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Mother Tongue</span>
                            <select id="mother_tongue" name="mother_tongue" class="form-control w-75">
                                <option value="" disabled>Select One</option>
                                <option value="Bangla" <?php selected($mother_tongue, 'Bangla'); ?>>Bangla</option>
                                <option value="English" <?php selected($mother_tongue, 'English'); ?>>English</option>
                                <!-- Add more options if needed -->
                            </select>
                        </div>
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Marital Status</span>
                            <select id="marital_status" name="marital_status" class="form-control w-75">
                                <option value="" disabled>Select Marital Status</option>
                                <option value="Never Married" <?php selected($marital_status, 'Never Married'); ?>>
                                    Single</option>
                                <option value="Widowed" <?php selected($marital_status, 'Widowed'); ?>>Widowed</option>
                                <option value="Awaiting Divorce" <?php selected($marital_status, 'Awaiting Divorce'); ?>>Awaiting Divorce</option>
                                <option value="Annulled" <?php selected($marital_status, 'Annulled'); ?>>Annulled
                                </option>
                                <option value="Divorced" <?php selected($marital_status, 'Divorced'); ?>>Divorced
                                </option>
                            </select>
                        </div>
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Gender</span>
                            <select id="user_gender" name="user_gender" class="form-control w-75" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male" <?php selected($user_gender, 'Male'); ?>>Male</option>
                                <option value="Female" <?php selected($user_gender, 'Female'); ?>>Female</option>
                                <option value="Transgender Male" <?php selected($user_gender, 'Transgender Male'); ?>>
                                    Transgender Male</option>
                                <option value="Transgender Female" <?php selected($user_gender, 'Transgender Female'); ?>>Transgender Female</option>
                                <option value="Non-Binary" <?php selected($user_gender, 'Non-Binary'); ?>>Non-Binary
                                </option>
                                <option value="Genderqueer" <?php selected($user_gender, 'Genderqueer'); ?>>Genderqueer
                                </option>
                                <option value="Genderfluid" <?php selected($user_gender, 'Genderfluid'); ?>>Genderfluid
                                </option>
                                <option value="Agender" <?php selected($user_gender, 'Agender'); ?>>Agender</option>
                                <option value="Intersex" <?php selected($user_gender, 'Intersex'); ?>>Intersex</option>
                                <option value="Two-Spirit" <?php selected($user_gender, 'Two-Spirit'); ?>>Two-Spirit
                                </option>
                                <option value="Other" <?php selected($user_gender, 'Other'); ?>>Other</option>
                                <option value="Prefer not to say" <?php selected($user_gender, 'Prefer not to say'); ?>>
                                    Prefer not to say</option>
                            </select>
                        </div>

                        <!-- Body Type Dropdown -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Body Type</span>
                            <select id="body_type" name="body_type" class="form-control w-75">
                                <option value="" disabled>Select Body Type</option>
                                <option value="Slim" <?php selected($body_type, 'Slim'); ?>>Slim</option>
                                <option value="Average" <?php selected($body_type, 'Average'); ?>>Average</option>
                                <option value="Athletic" <?php selected($body_type, 'Athletic'); ?>>Athletic</option>
                                <option value="Heavy" <?php selected($body_type, 'Heavy'); ?>>Heavy</option>
                            </select>
                        </div>

                        <!-- Complexion Dropdown -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Complexion</span>
                            <select id="complexion" name="complexion" class="form-control w-75">
                                <option value="" disabled>Select Complexion</option>
                                <option value="Very Fair" <?php selected($complexion, 'Very Fair'); ?>>Very Fair
                                </option>
                                <option value="Fair" <?php selected($complexion, 'Fair'); ?>>Fair</option>
                                <option value="Wheatish" <?php selected($complexion, 'Wheatish'); ?>>Wheatish</option>
                                <option value="Dark" <?php selected($complexion, 'Dark'); ?>>Dark</option>
                            </select>
                        </div>

                        <!-- Physical Status Dropdown -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Physical Status</span>
                            <select id="physical_status" name="physical_status" class="form-control w-75">
                                <option value="" disabled>Select Physical Status</option>
                                <option value="Normal" <?php selected($physical_status, 'Normal'); ?>>Normal</option>
                                <option value="Physically Challenged" <?php selected($physical_status, 'Physically Challenged'); ?>>Physically Challenged</option>
                            </select>
                        </div>

                        <!-- Eating Habits Dropdown -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Eating Habits</span>
                            <select id="eating_habits" name="eating_habits" class="form-control w-75">
                                <option value="" disabled>Select Eating Habits</option>
                                <option value="Vegetarian" <?php selected($eating_habits, 'Vegetarian'); ?>>Vegetarian
                                </option>
                                <option value="Non-Vegetarian" <?php selected($eating_habits, 'Non-Vegetarian'); ?>>
                                    Non-Vegetarian</option>
                                <option value="Eggetarian" <?php selected($eating_habits, 'Eggetarian'); ?>>Eggetarian
                                </option>
                                <option value="Vegan" <?php selected($eating_habits, 'Vegan'); ?>>Vegan</option>
                            </select>
                        </div>

                        <!-- Drinking Habits Dropdown -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Drinking Habits</span>
                            <select id="drinking_habits" name="drinking_habits" class="form-control w-75">
                                <option value="" disabled>Select Drinking Habits</option>
                                <option value="Never" <?php selected($drinking_habits, 'Never'); ?>>Never</option>
                                <option value="Occasionally" <?php selected($drinking_habits, 'Occasionally'); ?>>
                                    Occasionally</option>
                                <option value="Regularly" <?php selected($drinking_habits, 'Regularly'); ?>>Regularly
                                </option>
                            </select>
                        </div>

                        <!-- Smoking Habits Dropdown -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Smoking Habits</span>
                            <select id="smoking_habits" name="smoking_habits" class="form-control w-75">
                                <option value="" disabled>Select Smoking Habits</option>
                                <option value="Never" <?php selected($smoking_habits, 'Never'); ?>>Never</option>
                                <option value="Occasionally" <?php selected($smoking_habits, 'Occasionally'); ?>>
                                    Occasionally</option>
                                <option value="Regularly" <?php selected($smoking_habits, 'Regularly'); ?>>Regularly
                                </option>
                            </select>
                        </div>
                    </div>
                    <!-- Add a hidden field for the user ID -->
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="basicdetailsForm" name="update_basic_details" class="btn theme-btn">Save
                    Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Contact Details Modal -->
<div class="modal fade" id="contactdetailsmodal" tabindex="-1" aria-labelledby="contactdetailsmodalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="contactdetailsmodalLabel">Edit Contact Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="contactDetailsForm" method="post" action="">
                    <div class="mb-3">
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Candidate Contact Number</span>
                            <div class="input-group">
                                <select class="form-select" name="candidate_country_code" style="max-width: 100px;">
                                    <option value="+1" <?php selected($candidate_country_code, '+1'); ?>>+1 (USA)
                                    </option>
                                    <option value="+880" <?php selected($candidate_country_code, '+880'); ?>>+880
                                        (Bangladesh)</option>
                                </select>
                                <input type="text" name="candidate_phone" class="form-control"
                                    placeholder="Enter Candidate Phone Number"
                                    value="<?php echo esc_attr($candidate_phone); ?>">
                            </div>
                        </div>
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Parent Contact Number</span>
                            <div class="input-group">
                                <select class="form-select" name="parent_country_code" style="max-width: 100px;">
                                    <option value="+1" <?php selected($parent_country_code, '+1'); ?>>+1 (USA)</option>
                                    <option value="+880" <?php selected($parent_country_code, '+880'); ?>>+880
                                        (Bangladesh)</option>
                                </select>
                                <input type="text" name="parent_phone" class="form-control"
                                    placeholder="Enter Parent Phone Number"
                                    value="<?php echo esc_attr($parent_phone); ?>">
                            </div>
                        </div>
                    </div>
                    <!-- Add a hidden field for the user ID -->
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="contactDetailsForm" name="update_contact_details" class="btn theme-btn">Save
                    Changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Religion Details Modal -->
<div class="modal fade" id="userreligiondetailsmodal" tabindex="-1" aria-labelledby="userreligiondetailsmodalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="userreligiondetailsmodalLabel">Edit Religion Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="religionDetailsForm" method="post" action="">
                    <div class="mb-3">
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Religion</span>
                            <div class="input-group">
                                <select class="form-select" name="religion" id="user_religion">
                                    <option value="" disabled>Select Religion</option>
                                    <option value="Islam" <?php selected($religion, 'Islam'); ?>>Islam</option>
                                    <option value="Hinduism" <?php selected($religion, 'Hinduism'); ?>>Hinduism</option>
                                    <option value="Christianity" <?php selected($religion, 'Christianity'); ?>>
                                        Christianity</option>
                                    <option value="Buddhism" <?php selected($religion, 'Buddhism'); ?>>Buddhism</option>
                                    <option value="Judaism" <?php selected($religion, 'Judaism'); ?>>Judaism</option>
                                    <option value="Sikhism" <?php selected($religion, 'Sikhism'); ?>>Sikhism</option>
                                    <option value="Jainism" <?php selected($religion, 'Jainism'); ?>>Jainism</option>
                                    <option value="Baháí" <?php selected($religion, 'Baháí'); ?>>Baháí</option>
                                    <option value="Zoroastrianism" <?php selected($religion, 'Zoroastrianism'); ?>>
                                        Zoroastrianism</option>
                                    <option value="Atheist" <?php selected($religion, 'Atheist'); ?>>Atheist</option>
                                    <option value="Agnostic" <?php selected($religion, 'Agnostic'); ?>>Agnostic</option>
                                    <option value="Other" <?php selected($religion, 'Other'); ?>>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Add a hidden field for the user ID -->
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="religionDetailsForm" name="update_religion_details"
                    class="btn theme-btn">Save Changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Partner Religious Preferences Modal -->
<div class="modal fade" id="partnerreligiondetailsmodal" tabindex="-1"
    aria-labelledby="partnerreligiondetailsmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="partnerreligiondetailsmodalLabel">Edit Partner Religion Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="partnerReligionForm" method="post" action="">
                    <div class="mb-3">
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Religion</span>
                            <div class="input-group">
                                <select class="form-select" id="partner_religion" name="partner_religion">
                                    <option value="" disabled>Select Religion</option>
                                    <option value="Islam" <?php selected($partner_religion, 'Islam'); ?>>Islam</option>
                                    <option value="Hinduism" <?php selected($partner_religion, 'Hinduism'); ?>>Hinduism
                                    </option>
                                    <option value="Christianity" <?php selected($partner_religion, 'Christianity'); ?>>
                                        Christianity</option>
                                    <option value="Buddhism" <?php selected($partner_religion, 'Buddhism'); ?>>Buddhism
                                    </option>
                                    <option value="Judaism" <?php selected($partner_religion, 'Judaism'); ?>>Judaism
                                    </option>
                                    <option value="Sikhism" <?php selected($partner_religion, 'Sikhism'); ?>>Sikhism
                                    </option>
                                    <option value="Jainism" <?php selected($partner_religion, 'Jainism'); ?>>Jainism
                                    </option>
                                    <option value="Baháí" <?php selected($partner_religion, 'Baháí'); ?>>Baháí</option>
                                    <option value="Zoroastrianism" <?php selected($partner_religion, 'Zoroastrianism'); ?>>Zoroastrianism</option>
                                    <option value="Atheist" <?php selected($partner_religion, 'Atheist'); ?>>Atheist
                                    </option>
                                    <option value="Agnostic" <?php selected($partner_religion, 'Agnostic'); ?>>Agnostic
                                    </option>
                                    <option value="Other" <?php selected($partner_religion, 'Other'); ?>>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Add a hidden field for the user ID -->
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="partnerReligionForm" name="update_partner_religion"
                    class="btn theme-btn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Professional Details Modal -->
<div class="modal fade" id="professionaldetailsmodal" tabindex="-1" aria-labelledby="professionaldetailsmodalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="professionaldetailsmodalLabel">Edit Professional Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="professionalDetailsForm" method="post" action="">
                    <div class="mb-3">
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Select Education</span>
                            <div class="input-group">
                                <select name="education" class="form-select form-select-sm">
                                    <option value="" disabled>Select Education</option>
                                    <option value="A Level" <?php selected($education, 'A Level'); ?>>A Level</option>
                                    <option value="Alim" <?php selected($education, 'Alim'); ?>>Alim</option>
                                    <option value="Associates Degree" <?php selected($education, 'Associates Degree'); ?>>Associates Degree</option>
                                    <option value="B-Tech" <?php selected($education, 'B-Tech'); ?>>B-Tech</option>
                                    <option value="B.C.S Cadre" <?php selected($education, 'B.C.S Cadre'); ?>>B.C.S
                                        Cadre</option>
                                    <option value="BA|BSS|BCOM|BSC" <?php selected($education, 'BA|BSS|BCOM|BSC'); ?>>
                                        BA|BSS|BCOM|BSC</option>
                                    <option value="Bachelor" <?php selected($education, 'Bachelor'); ?>>Bachelor
                                    </option>
                                    <option value="BBA" <?php selected($education, 'BBA'); ?>>BBA</option>
                                    <option value="BBS" <?php selected($education, 'BBS'); ?>>BBS</option>
                                    <option value="BDS|Dental Surgery" <?php selected($education, 'BDS|Dental Surgery'); ?>>BDS|Dental Surgery</option>
                                    <option value="BSC-Honours" <?php selected($education, 'BSC-Honours'); ?>>
                                        BSC-Honours</option>
                                    <option value="C.A" <?php selected($education, 'C.A'); ?>>C.A</option>
                                    <option value="Dakhil" <?php selected($education, 'Dakhil'); ?>>Dakhil</option>
                                    <option value="Diploma" <?php selected($education, 'Diploma'); ?>>Diploma</option>
                                    <option value="DVM" <?php selected($education, 'DVM'); ?>>DVM</option>
                                    <option value="Fazil" <?php selected($education, 'Fazil'); ?>>Fazil</option>
                                    <option value="FCPS Part - 1" <?php selected($education, 'FCPS Part - 1'); ?>>FCPS
                                        Part - 1</option>
                                    <option value="FCPS Part - 2" <?php selected($education, 'FCPS Part - 2'); ?>>FCPS
                                        Part - 2</option>
                                    <option value="H.S.C" <?php selected($education, 'H.S.C'); ?>>H.S.C</option>
                                    <option value="High School" <?php selected($education, 'High School'); ?>>High
                                        School</option>
                                    <option value="Higher Diploma" <?php selected($education, 'Higher Diploma'); ?>>
                                        Higher Diploma</option>
                                    <option value="Honours Degree" <?php selected($education, 'Honours Degree'); ?>>
                                        Honours Degree</option>
                                    <option value="Kamil" <?php selected($education, 'Kamil'); ?>>Kamil</option>
                                    <option value="M.A|M.SS|M.COM|MSC" <?php selected($education, 'M.A|M.SS|M.COM|MSC'); ?>>M.A|M.SS|M.COM|MSC</option>
                                    <option value="M.Phil" <?php selected($education, 'M.Phil'); ?>>M.Phil</option>
                                    <option value="Masters" <?php selected($education, 'Masters'); ?>>Masters</option>
                                    <option value="MBA" <?php selected($education, 'MBA'); ?>>MBA</option>
                                    <option value="MBBS" <?php selected($education, 'MBBS'); ?>>MBBS</option>
                                    <option value="MBS" <?php selected($education, 'MBS'); ?>>MBS</option>
                                    <option value="O level" <?php selected($education, 'O level'); ?>>O level</option>
                                    <option value="PHD|Doctorate" <?php selected($education, 'PHD|Doctorate'); ?>>
                                        PHD|Doctorate</option>
                                    <option value="PMP" <?php selected($education, 'PMP'); ?>>PMP</option>
                                    <option value="Trade school" <?php selected($education, 'Trade school'); ?>>Trade
                                        school</option>
                                    <option value="Undergraduate" <?php selected($education, 'Undergraduate'); ?>>
                                        Undergraduate</option>
                                </select>
                            </div>
                        </div>
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Education in Detail:</span>
                            <div class="input-group">
                                <input type="text" name="education_detail" class="form-control"
                                    placeholder="Enter Education in Detail"
                                    value="<?php echo esc_attr($education_detail); ?>">
                            </div>
                        </div>
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Employed in:</span>
                            <div class="input-group">
                                <select name="employed_in" class="form-select form-select-sm">
                                    <option value="" disabled>Select One</option>
                                    <option value="Government Job" <?php selected($employed_in, 'Government Job'); ?>>
                                        Government Job</option>
                                    <option value="Private Job" <?php selected($employed_in, 'Private Job'); ?>>Private
                                        Job</option>
                                    <option value="Defence" <?php selected($employed_in, 'Defence'); ?>>Defence</option>
                                    <option value="Business" <?php selected($employed_in, 'Business'); ?>>Business
                                    </option>
                                    <option value="Unemployed" <?php selected($employed_in, 'Unemployed'); ?>>Unemployed
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">profession:</span>
                            <div class="input-group">
                                <select name="profession" class="form-select form-select-sm">
                                    <option value="" disabled>Select profession</option>
                                    <option value="accountant" <?php selected($profession, 'accountant'); ?>>Accountant
                                    </option>
                                    <option value="architect" <?php selected($profession, 'architect'); ?>>Architect
                                    </option>
                                    <option value="artist" <?php selected($profession, 'artist'); ?>>Artist</option>
                                    <option value="banker" <?php selected($profession, 'banker'); ?>>Banker</option>
                                    <option value="business_analyst" <?php selected($profession, 'business_analyst'); ?>>Business Analyst</option>
                                    <option value="business_owner" <?php selected($profession, 'business_owner'); ?>>
                                        Business Owner</option>
                                    <option value="chef" <?php selected($profession, 'chef'); ?>>Chef</option>
                                    <option value="civil_engineer" <?php selected($profession, 'civil_engineer'); ?>>
                                        Civil Engineer</option>
                                    <option value="content_writer" <?php selected($profession, 'content_writer'); ?>>
                                        Content Writer</option>
                                    <option value="customer_service_rep" <?php selected($profession, 'customer_service_rep'); ?>>Customer Service Representative</option>
                                    <option value="data_analyst" <?php selected($profession, 'data_analyst'); ?>>Data
                                        Analyst</option>
                                    <option value="dentist" <?php selected($profession, 'dentist'); ?>>Dentist</option>
                                    <option value="digital_marketer" <?php selected($profession, 'digital_marketer'); ?>>Digital Marketer</option>
                                    <option value="doctor" <?php selected($profession, 'doctor'); ?>>Doctor</option>
                                    <option value="engineer" <?php selected($profession, 'engineer'); ?>>Engineer
                                    </option>
                                    <option value="fashion_designer" <?php selected($profession, 'fashion_designer'); ?>>Fashion Designer</option>
                                    <option value="financial_advisor" <?php selected($profession, 'financial_advisor'); ?>>Financial Advisor</option>
                                    <option value="graphic_designer" <?php selected($profession, 'graphic_designer'); ?>>Graphic Designer</option>
                                    <option value="human_resources" <?php selected($profession, 'human_resources'); ?>>
                                        Human Resources</option>
                                    <option value="interior_designer" <?php selected($profession, 'interior_designer'); ?>>Interior Designer</option>
                                    <option value="it_professional" <?php selected($profession, 'it_professional'); ?>>
                                        IT Professional</option>
                                    <option value="journalist" <?php selected($profession, 'journalist'); ?>>Journalist
                                    </option>
                                    <option value="lawyer" <?php selected($profession, 'lawyer'); ?>>Lawyer</option>
                                    <option value="marketing_manager" <?php selected($profession, 'marketing_manager'); ?>>Marketing Manager</option>
                                    <option value="mechanical_engineer" <?php selected($profession, 'mechanical_engineer'); ?>>Mechanical Engineer</option>
                                    <option value="nurse" <?php selected($profession, 'nurse'); ?>>Nurse</option>
                                    <option value="pharmacist" <?php selected($profession, 'pharmacist'); ?>>Pharmacist
                                    </option>
                                    <option value="photographer" <?php selected($profession, 'photographer'); ?>>
                                        Photographer</option>
                                    <option value="pilot" <?php selected($profession, 'pilot'); ?>>Pilot</option>
                                    <option value="police_officer" <?php selected($profession, 'police_officer'); ?>>
                                        Police Officer</option>
                                    <option value="professor" <?php selected($profession, 'professor'); ?>>Professor
                                    </option>
                                    <option value="real_estate_agent" <?php selected($profession, 'real_estate_agent'); ?>>Real Estate Agent</option>
                                    <option value="research_scientist" <?php selected($profession, 'research_scientist'); ?>>Research Scientist</option>
                                    <option value="sales_manager" <?php selected($profession, 'sales_manager'); ?>>Sales
                                        Manager</option>
                                    <option value="software_developer" <?php selected($profession, 'software_developer'); ?>>Software Developer</option>
                                    <option value="teacher" <?php selected($profession, 'teacher'); ?>>Teacher</option>
                                    <option value="therapist" <?php selected($profession, 'therapist'); ?>>Therapist
                                    </option>
                                    <option value="translator" <?php selected($profession, 'translator'); ?>>Translator
                                    </option>
                                    <option value="veterinarian" <?php selected($profession, 'veterinarian'); ?>>
                                        Veterinarian</option>
                                    <option value="web_developer" <?php selected($profession, 'web_developer'); ?>>Web
                                        Developer</option>
                                    <option value="writer" <?php selected($profession, 'writer'); ?>>Writer</option>
                                </select>
                            </div>
                        </div>
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">profession in Detail:</span>
                            <div class="input-group">
                                <input type="text" name="profession_detail" class="form-control"
                                    placeholder="Enter profession in Detail"
                                    value="<?php echo esc_attr($profession_detail); ?>">
                            </div>
                        </div>
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Annual Income:</span>
                            <div class="input-group">
                                <select name="annual_income" class="form-control">
                                    <option value="" disabled>Select Annual Income</option>
                                    <option value="Rs. 5 - 6 Lakhs" <?php selected($annual_income, 'Rs. 5 - 6 Lakhs'); ?>>Rs. 5 - 6 Lakhs</option>
                                    <option value="Rs. 6 - 7 Lakhs" <?php selected($annual_income, 'Rs. 6 - 7 Lakhs'); ?>>Rs. 6 - 7 Lakhs</option>
                                    <option value="Rs. 7 - 8 Lakhs" <?php selected($annual_income, 'Rs. 7 - 8 Lakhs'); ?>>Rs. 7 - 8 Lakhs</option>
                                    <option value="Rs. 8 - 9 Lakhs" <?php selected($annual_income, 'Rs. 8 - 9 Lakhs'); ?>>Rs. 8 - 9 Lakhs</option>
                                    <!-- Add more income options as needed -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Add a hidden field for the user ID -->
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="professionalDetailsForm" name="update_professional_details"
                    class="btn theme-btn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Astro Details Modal -->
<div class="modal fade" id="astrodetailsmodal" tabindex="-1" aria-labelledby="astrodetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="astrodetailsLabel">Edit Astro Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="astroDetailsForm" method="post" action="">
                    <div class="mb-3">
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Select Date Of Birth</span>
                            <div class="input-group">
                                <input type="date" name="dob" class="form-control"
                                    value="<?php echo esc_attr($dob); ?>">
                            </div>
                        </div>
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Select Place of Birth:</span>
                            <div class="input-group">
                                <select name="place_of_birth" class="form-select form-select-sm">
                                    <option value="" disabled>Select One</option>
                                    <option value="Afghanistan" <?php selected($place_of_birth, 'Afghanistan'); ?>>
                                        Afghanistan</option>
                                    <option value="Albania" <?php selected($place_of_birth, 'Albania'); ?>>Albania
                                    </option>
                                    <option value="Algeria" <?php selected($place_of_birth, 'Algeria'); ?>>Algeria
                                    </option>
                                    <option value="Andorra" <?php selected($place_of_birth, 'Andorra'); ?>>Andorra
                                    </option>
                                    <option value="Angola" <?php selected($place_of_birth, 'Angola'); ?>>Angola</option>
                                    <option value="Antigua and Barbuda" <?php selected($place_of_birth, 'Antigua and Barbuda'); ?>>Antigua and Barbuda</option>
                                    <option value="Argentina" <?php selected($place_of_birth, 'Argentina'); ?>>Argentina
                                    </option>
                                    <option value="Armenia" <?php selected($place_of_birth, 'Armenia'); ?>>Armenia
                                    </option>
                                    <option value="Australia" <?php selected($place_of_birth, 'Australia'); ?>>Australia
                                    </option>
                                    <option value="Austria" <?php selected($place_of_birth, 'Austria'); ?>>Austria
                                    </option>
                                    <option value="Azerbaijan" <?php selected($place_of_birth, 'Azerbaijan'); ?>>
                                        Azerbaijan</option>
                                    <option value="Bahamas" <?php selected($place_of_birth, 'Bahamas'); ?>>Bahamas
                                    </option>
                                    <option value="Bahrain" <?php selected($place_of_birth, 'Bahrain'); ?>>Bahrain
                                    </option>
                                    <option value="Bangladesh" <?php selected($place_of_birth, 'Bangladesh'); ?>>
                                        Bangladesh</option>
                                    <option value="Barbados" <?php selected($place_of_birth, 'Barbados'); ?>>Barbados
                                    </option>
                                    <option value="Belarus" <?php selected($place_of_birth, 'Belarus'); ?>>Belarus
                                    </option>
                                    <option value="Belgium" <?php selected($place_of_birth, 'Belgium'); ?>>Belgium
                                    </option>
                                    <option value="Belize" <?php selected($place_of_birth, 'Belize'); ?>>Belize</option>
                                    <option value="Benin" <?php selected($place_of_birth, 'Benin'); ?>>Benin</option>
                                    <option value="Bhutan" <?php selected($place_of_birth, 'Bhutan'); ?>>Bhutan</option>
                                    <option value="Bolivia" <?php selected($place_of_birth, 'Bolivia'); ?>>Bolivia
                                    </option>
                                    <option value="Bosnia and Herzegovina" <?php selected($place_of_birth, 'Bosnia and Herzegovina'); ?>>Bosnia and Herzegovina</option>
                                    <option value="Botswana" <?php selected($place_of_birth, 'Botswana'); ?>>Botswana
                                    </option>
                                    <option value="Brazil" <?php selected($place_of_birth, 'Brazil'); ?>>Brazil</option>
                                    <option value="Brunei" <?php selected($place_of_birth, 'Brunei'); ?>>Brunei</option>
                                    <option value="Bulgaria" <?php selected($place_of_birth, 'Bulgaria'); ?>>Bulgaria
                                    </option>
                                    <option value="Burkina Faso" <?php selected($place_of_birth, 'Burkina Faso'); ?>>
                                        Burkina Faso</option>
                                    <option value="Burundi" <?php selected($place_of_birth, 'Burundi'); ?>>Burundi
                                    </option>
                                    <option value="Cabo Verde" <?php selected($place_of_birth, 'Cabo Verde'); ?>>Cabo
                                        Verde</option>
                                    <option value="Cambodia" <?php selected($place_of_birth, 'Cambodia'); ?>>Cambodia
                                    </option>
                                    <option value="Cameroon" <?php selected($place_of_birth, 'Cameroon'); ?>>Cameroon
                                    </option>
                                    <option value="Canada" <?php selected($place_of_birth, 'Canada'); ?>>Canada</option>
                                    <option value="Central African Republic" <?php selected($place_of_birth, 'Central African Republic'); ?>>Central African Republic</option>
                                    <option value="Chad" <?php selected($place_of_birth, 'Chad'); ?>>Chad</option>
                                    <option value="Chile" <?php selected($place_of_birth, 'Chile'); ?>>Chile</option>
                                    <option value="China" <?php selected($place_of_birth, 'China'); ?>>China</option>
                                    <option value="Colombia" <?php selected($place_of_birth, 'Colombia'); ?>>Colombia
                                    </option>
                                    <option value="Comoros" <?php selected($place_of_birth, 'Comoros'); ?>>Comoros
                                    </option>
                                    <option value="Congo (Congo-Brazzaville)" <?php selected($place_of_birth, 'Congo (Congo-Brazzaville)'); ?>>Congo (Congo-Brazzaville)</option>
                                    <option value="Costa Rica" <?php selected($place_of_birth, 'Costa Rica'); ?>>Costa
                                        Rica</option>
                                    <option value="Croatia" <?php selected($place_of_birth, 'Croatia'); ?>>Croatia
                                    </option>
                                    <option value="Cuba" <?php selected($place_of_birth, 'Cuba'); ?>>Cuba</option>
                                    <option value="Cyprus" <?php selected($place_of_birth, 'Cyprus'); ?>>Cyprus</option>
                                    <option value="Czechia (Czech Republic)" <?php selected($place_of_birth, 'Czechia (Czech Republic)'); ?>>Czechia (Czech Republic)</option>
                                    <option value="Denmark" <?php selected($place_of_birth, 'Denmark'); ?>>Denmark
                                    </option>
                                    <option value="Djibouti" <?php selected($place_of_birth, 'Djibouti'); ?>>Djibouti
                                    </option>
                                    <option value="Dominica" <?php selected($place_of_birth, 'Dominica'); ?>>Dominica
                                    </option>
                                    <option value="Dominican Republic" <?php selected($place_of_birth, 'Dominican Republic'); ?>>Dominican Republic</option>
                                    <option value="Ecuador" <?php selected($place_of_birth, 'Ecuador'); ?>>Ecuador
                                    </option>
                                    <option value="Egypt" <?php selected($place_of_birth, 'Egypt'); ?>>Egypt</option>
                                    <option value="El Salvador" <?php selected($place_of_birth, 'El Salvador'); ?>>El
                                        Salvador</option>
                                    <option value="Equatorial Guinea" <?php selected($place_of_birth, 'Equatorial Guinea'); ?>>Equatorial Guinea</option>
                                    <option value="Eritrea" <?php selected($place_of_birth, 'Eritrea'); ?>>Eritrea
                                    </option>
                                    <option value="Estonia" <?php selected($place_of_birth, 'Estonia'); ?>>Estonia
                                    </option>
                                    <option value="Eswatini (fmr. Swaziland)" <?php selected($place_of_birth, 'Eswatini (fmr. Swaziland)'); ?>>Eswatini (fmr. Swaziland)</option>
                                    <option value="Ethiopia" <?php selected($place_of_birth, 'Ethiopia'); ?>>Ethiopia
                                    </option>
                                    <option value="Fiji" <?php selected($place_of_birth, 'Fiji'); ?>>Fiji</option>
                                    <option value="Finland" <?php selected($place_of_birth, 'Finland'); ?>>Finland
                                    </option>
                                    <option value="France" <?php selected($place_of_birth, 'France'); ?>>France</option>
                                    <option value="Gabon" <?php selected($place_of_birth, 'Gabon'); ?>>Gabon</option>
                                    <option value="Gambia" <?php selected($place_of_birth, 'Gambia'); ?>>Gambia</option>
                                    <option value="Georgia" <?php selected($place_of_birth, 'Georgia'); ?>>Georgia
                                    </option>
                                    <option value="Germany" <?php selected($place_of_birth, 'Germany'); ?>>Germany
                                    </option>
                                    <option value="Ghana" <?php selected($place_of_birth, 'Ghana'); ?>>Ghana</option>
                                    <option value="Greece" <?php selected($place_of_birth, 'Greece'); ?>>Greece</option>
                                    <option value="Grenada" <?php selected($place_of_birth, 'Grenada'); ?>>Grenada
                                    </option>
                                    <option value="Guatemala" <?php selected($place_of_birth, 'Guatemala'); ?>>Guatemala
                                    </option>
                                    <option value="Guinea" <?php selected($place_of_birth, 'Guinea'); ?>>Guinea</option>
                                    <option value="Guinea-Bissau" <?php selected($place_of_birth, 'Guinea-Bissau'); ?>>
                                        Guinea-Bissau</option>
                                    <option value="Guyana" <?php selected($place_of_birth, 'Guyana'); ?>>Guyana</option>
                                    <option value="Haiti" <?php selected($place_of_birth, 'Haiti'); ?>>Haiti</option>
                                    <option value="Honduras" <?php selected($place_of_birth, 'Honduras'); ?>>Honduras
                                    </option>
                                    <option value="Hungary" <?php selected($place_of_birth, 'Hungary'); ?>>Hungary
                                    </option>
                                    <option value="Iceland" <?php selected($place_of_birth, 'Iceland'); ?>>Iceland
                                    </option>
                                    <option value="India" <?php selected($place_of_birth, 'India'); ?>>India</option>
                                    <option value="Indonesia" <?php selected($place_of_birth, 'Indonesia'); ?>>Indonesia
                                    </option>
                                    <option value="Iran" <?php selected($place_of_birth, 'Iran'); ?>>Iran</option>
                                    <option value="Iraq" <?php selected($place_of_birth, 'Iraq'); ?>>Iraq</option>
                                    <option value="Ireland" <?php selected($place_of_birth, 'Ireland'); ?>>Ireland
                                    </option>
                                    <option value="Israel" <?php selected($place_of_birth, 'Israel'); ?>>Israel</option>
                                    <option value="Italy" <?php selected($place_of_birth, 'Italy'); ?>>Italy</option>
                                    <option value="Jamaica" <?php selected($place_of_birth, 'Jamaica'); ?>>Jamaica
                                    </option>
                                    <option value="Japan" <?php selected($place_of_birth, 'Japan'); ?>>Japan</option>
                                    <option value="Jordan" <?php selected($place_of_birth, 'Jordan'); ?>>Jordan</option>
                                    <option value="Kazakhstan" <?php selected($place_of_birth, 'Kazakhstan'); ?>>
                                        Kazakhstan</option>
                                    <option value="Kenya" <?php selected($place_of_birth, 'Kenya'); ?>>Kenya</option>
                                    <option value="Kiribati" <?php selected($place_of_birth, 'Kiribati'); ?>>Kiribati
                                    </option>
                                    <option value="Kuwait" <?php selected($place_of_birth, 'Kuwait'); ?>>Kuwait</option>
                                    <option value="Kyrgyzstan" <?php selected($place_of_birth, 'Kyrgyzstan'); ?>>
                                        Kyrgyzstan</option>
                                    <option value="Laos" <?php selected($place_of_birth, 'Laos'); ?>>Laos</option>
                                    <option value="Latvia" <?php selected($place_of_birth, 'Latvia'); ?>>Latvia</option>
                                    <option value="Lebanon" <?php selected($place_of_birth, 'Lebanon'); ?>>Lebanon
                                    </option>
                                    <option value="Lesotho" <?php selected($place_of_birth, 'Lesotho'); ?>>Lesotho
                                    </option>
                                    <option value="Liberia" <?php selected($place_of_birth, 'Liberia'); ?>>Liberia
                                    </option>
                                    <option value="Libya" <?php selected($place_of_birth, 'Libya'); ?>>Libya</option>
                                    <option value="Liechtenstein" <?php selected($place_of_birth, 'Liechtenstein'); ?>>
                                        Liechtenstein</option>
                                    <option value="Lithuania" <?php selected($place_of_birth, 'Lithuania'); ?>>Lithuania
                                    </option>
                                    <option value="Luxembourg" <?php selected($place_of_birth, 'Luxembourg'); ?>>
                                        Luxembourg</option>
                                    <option value="Madagascar" <?php selected($place_of_birth, 'Madagascar'); ?>>
                                        Madagascar</option>
                                    <option value="Malawi" <?php selected($place_of_birth, 'Malawi'); ?>>Malawi</option>
                                    <option value="Malaysia" <?php selected($place_of_birth, 'Malaysia'); ?>>Malaysia
                                    </option>
                                    <option value="Maldives" <?php selected($place_of_birth, 'Maldives'); ?>>Maldives
                                    </option>
                                    <option value="Mali" <?php selected($place_of_birth, 'Mali'); ?>>Mali</option>
                                    <option value="Malta" <?php selected($place_of_birth, 'Malta'); ?>>Malta</option>
                                    <option value="Marshall Islands" <?php selected($place_of_birth, 'Marshall Islands'); ?>>Marshall Islands</option>
                                    <option value="Mauritania" <?php selected($place_of_birth, 'Mauritania'); ?>>
                                        Mauritania</option>
                                    <option value="Mauritius" <?php selected($place_of_birth, 'Mauritius'); ?>>Mauritius
                                    </option>
                                    <option value="Mexico" <?php selected($place_of_birth, 'Mexico'); ?>>Mexico</option>
                                    <option value="Micronesia" <?php selected($place_of_birth, 'Micronesia'); ?>>
                                        Micronesia</option>
                                    <option value="Moldova" <?php selected($place_of_birth, 'Moldova'); ?>>Moldova
                                    </option>
                                    <option value="Monaco" <?php selected($place_of_birth, 'Monaco'); ?>>Monaco</option>
                                    <option value="Mongolia" <?php selected($place_of_birth, 'Mongolia'); ?>>Mongolia
                                    </option>
                                    <option value="Montenegro" <?php selected($place_of_birth, 'Montenegro'); ?>>
                                        Montenegro</option>
                                    <option value="Morocco" <?php selected($place_of_birth, 'Morocco'); ?>>Morocco
                                    </option>
                                    <option value="Mozambique" <?php selected($place_of_birth, 'Mozambique'); ?>>
                                        Mozambique</option>
                                    <option value="Myanmar (Burma)" <?php selected($place_of_birth, 'Myanmar (Burma)'); ?>>Myanmar (Burma)</option>
                                    <option value="Namibia" <?php selected($place_of_birth, 'Namibia'); ?>>Namibia
                                    </option>
                                    <option value="Nauru" <?php selected($place_of_birth, 'Nauru'); ?>>Nauru</option>
                                    <option value="Nepal" <?php selected($place_of_birth, 'Nepal'); ?>>Nepal</option>
                                    <option value="Netherlands" <?php selected($place_of_birth, 'Netherlands'); ?>>
                                        Netherlands</option>
                                    <option value="New Zealand" <?php selected($place_of_birth, 'New Zealand'); ?>>New
                                        Zealand</option>
                                    <option value="Nicaragua" <?php selected($place_of_birth, 'Nicaragua'); ?>>Nicaragua
                                    </option>
                                    <option value="Niger" <?php selected($place_of_birth, 'Niger'); ?>>Niger</option>
                                    <option value="Nigeria" <?php selected($place_of_birth, 'Nigeria'); ?>>Nigeria
                                    </option>
                                    <option value="North Korea" <?php selected($place_of_birth, 'North Korea'); ?>>North
                                        Korea</option>
                                    <option value="North Macedonia" <?php selected($place_of_birth, 'North Macedonia'); ?>>North Macedonia</option>
                                    <option value="Norway" <?php selected($place_of_birth, 'Norway'); ?>>Norway</option>
                                    <option value="Oman" <?php selected($place_of_birth, 'Oman'); ?>>Oman</option>
                                    <option value="Pakistan" <?php selected($place_of_birth, 'Pakistan'); ?>>Pakistan
                                    </option>
                                    <option value="Palau" <?php selected($place_of_birth, 'Palau'); ?>>Palau</option>
                                    <option value="Palestine State" <?php selected($place_of_birth, 'Palestine State'); ?>>Palestine State</option>
                                    <option value="Panama" <?php selected($place_of_birth, 'Panama'); ?>>Panama</option>
                                    <option value="Papua New Guinea" <?php selected($place_of_birth, 'Papua New Guinea'); ?>>Papua New Guinea</option>
                                    <option value="Paraguay" <?php selected($place_of_birth, 'Paraguay'); ?>>Paraguay
                                    </option>
                                    <option value="Peru" <?php selected($place_of_birth, 'Peru'); ?>>Peru</option>
                                    <option value="Philippines" <?php selected($place_of_birth, 'Philippines'); ?>>
                                        Philippines</option>
                                    <option value="Poland" <?php selected($place_of_birth, 'Poland'); ?>>Poland</option>
                                    <option value="Portugal" <?php selected($place_of_birth, 'Portugal'); ?>>Portugal
                                    </option>
                                    <option value="Qatar" <?php selected($place_of_birth, 'Qatar'); ?>>Qatar</option>
                                    <option value="Romania" <?php selected($place_of_birth, 'Romania'); ?>>Romania
                                    </option>
                                    <option value="Russia" <?php selected($place_of_birth, 'Russia'); ?>>Russia</option>
                                    <option value="Rwanda" <?php selected($place_of_birth, 'Rwanda'); ?>>Rwanda</option>
                                    <option value="Saint Kitts and Nevis" <?php selected($place_of_birth, 'Saint Kitts and Nevis'); ?>>Saint Kitts and Nevis</option>
                                    <option value="Saint Lucia" <?php selected($place_of_birth, 'Saint Lucia'); ?>>Saint
                                        Lucia</option>
                                    <option value="Saint Vincent and the Grenadines" <?php selected($place_of_birth, 'Saint Vincent and the Grenadines'); ?>>Saint Vincent and the Grenadines
                                    </option>
                                    <option value="Samoa" <?php selected($place_of_birth, 'Samoa'); ?>>Samoa</option>
                                    <option value="San Marino" <?php selected($place_of_birth, 'San Marino'); ?>>San
                                        Marino</option>
                                    <option value="Sao Tome and Principe" <?php selected($place_of_birth, 'Sao Tome and Principe'); ?>>Sao Tome and Principe</option>
                                    <option value="Saudi Arabia" <?php selected($place_of_birth, 'Saudi Arabia'); ?>>
                                        Saudi Arabia</option>
                                    <option value="Senegal" <?php selected($place_of_birth, 'Senegal'); ?>>Senegal
                                    </option>
                                    <option value="Serbia" <?php selected($place_of_birth, 'Serbia'); ?>>Serbia</option>
                                    <option value="Seychelles" <?php selected($place_of_birth, 'Seychelles'); ?>>
                                        Seychelles</option>
                                    <option value="Sierra Leone" <?php selected($place_of_birth, 'Sierra Leone'); ?>>
                                        Sierra Leone</option>
                                    <option value="Singapore" <?php selected($place_of_birth, 'Singapore'); ?>>Singapore
                                    </option>
                                    <option value="Slovakia" <?php selected($place_of_birth, 'Slovakia'); ?>>Slovakia
                                    </option>
                                    <option value="Slovenia" <?php selected($place_of_birth, 'Slovenia'); ?>>Slovenia
                                    </option>
                                    <option value="Solomon Islands" <?php selected($place_of_birth, 'Solomon Islands'); ?>>Solomon Islands</option>
                                    <option value="Somalia" <?php selected($place_of_birth, 'Somalia'); ?>>Somalia
                                    </option>
                                    <option value="South Africa" <?php selected($place_of_birth, 'South Africa'); ?>>
                                        South Africa</option>
                                    <option value="South Korea" <?php selected($place_of_birth, 'South Korea'); ?>>South
                                        Korea</option>
                                    <option value="South Sudan" <?php selected($place_of_birth, 'South Sudan'); ?>>South
                                        Sudan</option>
                                    <option value="Spain" <?php selected($place_of_birth, 'Spain'); ?>>Spain</option>
                                    <option value="Sri Lanka" <?php selected($place_of_birth, 'Sri Lanka'); ?>>Sri Lanka
                                    </option>
                                    <option value="Sudan" <?php selected($place_of_birth, 'Sudan'); ?>>Sudan</option>
                                    <option value="Suriname" <?php selected($place_of_birth, 'Suriname'); ?>>Suriname
                                    </option>
                                    <option value="Sweden" <?php selected($place_of_birth, 'Sweden'); ?>>Sweden</option>
                                    <option value="Switzerland" <?php selected($place_of_birth, 'Switzerland'); ?>>
                                        Switzerland</option>
                                    <option value="Syria" <?php selected($place_of_birth, 'Syria'); ?>>Syria</option>
                                    <option value="Tajikistan" <?php selected($place_of_birth, 'Tajikistan'); ?>>
                                        Tajikistan</option>
                                    <option value="Tanzania" <?php selected($place_of_birth, 'Tanzania'); ?>>Tanzania
                                    </option>
                                    <option value="Thailand" <?php selected($place_of_birth, 'Thailand'); ?>>Thailand
                                    </option>
                                    <option value="Timor-Leste" <?php selected($place_of_birth, 'Timor-Leste'); ?>>
                                        Timor-Leste</option>
                                    <option value="Togo" <?php selected($place_of_birth, 'Togo'); ?>>Togo</option>
                                    <option value="Tonga" <?php selected($place_of_birth, 'Tonga'); ?>>Tonga</option>
                                    <option value="Trinidad and Tobago" <?php selected($place_of_birth, 'Trinidad and Tobago'); ?>>Trinidad and Tobago</option>
                                    <option value="Tunisia" <?php selected($place_of_birth, 'Tunisia'); ?>>Tunisia
                                    </option>
                                    <option value="Turkey" <?php selected($place_of_birth, 'Turkey'); ?>>Turkey</option>
                                    <option value="Turkmenistan" <?php selected($place_of_birth, 'Turkmenistan'); ?>>
                                        Turkmenistan</option>
                                    <option value="Tuvalu" <?php selected($place_of_birth, 'Tuvalu'); ?>>Tuvalu</option>
                                    <option value="Uganda" <?php selected($place_of_birth, 'Uganda'); ?>>Uganda</option>
                                    <option value="Ukraine" <?php selected($place_of_birth, 'Ukraine'); ?>>Ukraine
                                    </option>
                                    <option value="United Arab Emirates" <?php selected($place_of_birth, 'United Arab Emirates'); ?>>United Arab Emirates</option>
                                    <option value="United Kingdom" <?php selected($place_of_birth, 'United Kingdom'); ?>>United Kingdom</option>
                                    <option value="United States" <?php selected($place_of_birth, 'United States'); ?>>
                                        United States</option>
                                    <option value="Uruguay" <?php selected($place_of_birth, 'Uruguay'); ?>>Uruguay
                                    </option>
                                    <option value="Uzbekistan" <?php selected($place_of_birth, 'Uzbekistan'); ?>>
                                        Uzbekistan</option>
                                    <option value="Vanuatu" <?php selected($place_of_birth, 'Vanuatu'); ?>>Vanuatu
                                    </option>
                                    <option value="Vatican City" <?php selected($place_of_birth, 'Vatican City'); ?>>
                                        Vatican City</option>
                                    <option value="Venezuela" <?php selected($place_of_birth, 'Venezuela'); ?>>Venezuela
                                    </option>
                                    <option value="Vietnam" <?php selected($place_of_birth, 'Vietnam'); ?>>Vietnam
                                    </option>
                                    <option value="Yemen" <?php selected($place_of_birth, 'Yemen'); ?>>Yemen</option>
                                    <option value="Zambia" <?php selected($place_of_birth, 'Zambia'); ?>>Zambia</option>
                                    <option value="Zimbabwe" <?php selected($place_of_birth, 'Zimbabwe'); ?>>Zimbabwe
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Add a hidden field for the user ID -->
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="astroDetailsForm" name="update_astro_details" class="btn theme-btn">Save
                    Changes</button>
            </div>
        </div>
    </div>
</div>


<!-- About Partner Details Modal -->
<div class="modal fade" id="about_partner_modal" tabindex="-1" aria-labelledby="about_partner_modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="about_partner_modalLabel">Edit About Your Partner</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="aboutPartnerForm" method="post" action="">
                    <div class="mb-3">
                        <label for="about-modal" class="form-label">About Your Partner</label>
                        <textarea class="form-control" id="about-modal" name="about_partner" rows="5"
                            style="height: 300px;"><?php echo esc_textarea($about_partner); ?></textarea>
                    </div>
                    <!-- Add a hidden field for the user ID -->
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="aboutPartnerForm" name="update_about_partner" class="btn theme-btn">Save
                    Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Partner Basic Preferences Modal -->
<div class="modal fade" id="partner_basic_modal" tabindex="-1" aria-labelledby="partner_basic_modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="partner_basic_modalLabel">Edit Partner Basic Preferences</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="partnerBasicForm" method="post" action="">
                    <div class="mb-3">
                        <!-- Age Range -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Age</span>
                            <div class="input-group w-75">
                                <input type="text" id="partner_min_age" name="partner_min_age" class="form-control"
                                    placeholder="Minimum age" value="<?php echo esc_attr($partner_min_age); ?>">
                                <input type="text" id="partner_max_age" name="partner_max_age" class="form-control"
                                    placeholder="Maximum age" value="<?php echo esc_attr($partner_max_age); ?>">
                                <span class="input-group-text">Years</span>
                            </div>
                        </div>
                        <!-- Height Range -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Height</span>
                            <div class="input-group w-75">
                                <input type="text" id="partner_min_height" name="partner_min_height"
                                    class="form-control" placeholder="Minimum Height"
                                    value="<?php echo esc_attr($partner_min_height); ?>">
                                <input type="text" id="partner_max_height" name="partner_max_height"
                                    class="form-control" placeholder="Maximum Height"
                                    value="<?php echo esc_attr($partner_max_height); ?>">
                            </div>
                        </div>
                        <!-- Marital Status -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Marital Status:</span>
                            <select id="partner_marital_status" name="partner_marital_status" class="form-control w-75">
                                <option value="" disabled>Select Marital Status</option>
                                <option value="Never Married" <?php selected($partner_marital_status, 'Never Married'); ?>>Never Married</option>
                                <option value="Widowed" <?php selected($partner_marital_status, 'Widowed'); ?>>Widowed
                                </option>
                                <option value="Awaiting Divorce" <?php selected($partner_marital_status, 'Awaiting Divorce'); ?>>Awaiting Divorce</option>
                                <option value="Annulled" <?php selected($partner_marital_status, 'Annulled'); ?>>
                                    Annulled</option>
                                <option value="Divorced" <?php selected($partner_marital_status, 'Divorced'); ?>>
                                    Divorced</option>
                            </select>
                        </div>
                        <!-- Mother Tongue -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Mother Tongue:</span>
                            <select id="partner_mother_tongue" name="partner_mother_tongue" class="form-control w-75">
                                <option value="" disabled>Select One</option>
                                <option value="Bangla" <?php selected($partner_mother_tongue, 'Bangla'); ?>>Bangla
                                </option>
                                <option value="English" <?php selected($partner_mother_tongue, 'English'); ?>>English
                                </option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <!-- Physical Status -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Physical Status:</span>
                            <select id="partner_physical_status" name="partner_physical_status"
                                class="form-control w-75">
                                <option value="" disabled>Select Physical Status</option>
                                <option value="Normal" <?php selected($partner_physical_status, 'Normal'); ?>>Normal
                                </option>
                                <option value="Physically Challenged" <?php selected($partner_physical_status, 'Physically Challenged'); ?>>Physically Challenged</option>
                            </select>
                        </div>
                        <!-- Eating Habits -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Eating Habits:</span>
                            <select id="partner_eating_habits" name="partner_eating_habits" class="form-control w-75">
                                <option value="" disabled>Select Eating Habits</option>
                                <option value="Vegetarian" <?php selected($partner_eating_habits, 'Vegetarian'); ?>>
                                    Vegetarian</option>
                                <option value="Non-Vegetarian" <?php selected($partner_eating_habits, 'Non-Vegetarian'); ?>>Non-Vegetarian</option>
                                <option value="Eggetarian" <?php selected($partner_eating_habits, 'Eggetarian'); ?>>
                                    Eggetarian</option>
                                <option value="Vegan" <?php selected($partner_eating_habits, 'Vegan'); ?>>Vegan</option>
                            </select>
                        </div>
                        <!-- Smoking Habits -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Smoking Habits:</span>
                            <select id="partner_smoking_habits" name="partner_smoking_habits" class="form-control w-75">
                                <option value="" disabled>Select Smoking Habits</option>
                                <option value="Never" <?php selected($partner_smoking_habits, 'Never'); ?>>Never
                                </option>
                                <option value="Occasionally" <?php selected($partner_smoking_habits, 'Occasionally'); ?>>Occasionally</option>
                                <option value="Regularly" <?php selected($partner_smoking_habits, 'Regularly'); ?>>
                                    Regularly</option>
                            </select>
                        </div>
                        <!-- Drinking Habits -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Drinking Habits:</span>
                            <select id="partner_drinking_habits" name="partner_drinking_habits"
                                class="form-control w-75">
                                <option value="" disabled>Select Drinking Habits</option>
                                <option value="Never" <?php selected($partner_drinking_habits, 'Never'); ?>>Never
                                </option>
                                <option value="Occasionally" <?php selected($partner_drinking_habits, 'Occasionally'); ?>>Occasionally</option>
                                <option value="Regularly" <?php selected($partner_drinking_habits, 'Regularly'); ?>>
                                    Regularly</option>
                            </select>
                        </div>
                    </div>
                    <!-- Add a hidden field for the user ID -->
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="partnerBasicForm" name="update_partner_basic_preferences"
                    class="btn theme-btn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Partner Professional Preferences Modal -->
<div class="modal fade" id="partner_professional_modal" tabindex="-1" aria-labelledby="partner_professional_modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="partner_professional_modalLabel">Edit Partner Professional Preferences
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="partnerProfessionalForm" method="post" action="">
                    <div class="mb-3">
                        <!-- Education -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Select Education</span>
                            <div class="input-group">
                                <select id="partner_education" name="partner_education"
                                    class="form-select form-select-sm">
                                    <option value="" disabled>Select Education</option>
                                    <option value="A Level" <?php selected($partner_education, 'A Level'); ?>>A Level
                                    </option>
                                    <option value="Alim" <?php selected($partner_education, 'Alim'); ?>>Alim</option>
                                    <option value="Associates Degree" <?php selected($partner_education, 'Associates Degree'); ?>>Associates Degree</option>
                                    <option value="B-Tech" <?php selected($partner_education, 'B-Tech'); ?>>B-Tech
                                    </option>
                                    <option value="B.C.S Cadre" <?php selected($partner_education, 'B.C.S Cadre'); ?>>
                                        B.C.S Cadre</option>
                                    <option value="BA|BSS|BCOM|BSC" <?php selected($partner_education, 'BA|BSS|BCOM|BSC'); ?>>BA|BSS|BCOM|BSC</option>
                                    <option value="Bachelor" <?php selected($partner_education, 'Bachelor'); ?>>Bachelor
                                    </option>
                                    <option value="BBA" <?php selected($partner_education, 'BBA'); ?>>BBA</option>
                                    <option value="BBS" <?php selected($partner_education, 'BBS'); ?>>BBS</option>
                                    <option value="BDS|Dental Surgery" <?php selected($partner_education, 'BDS|Dental Surgery'); ?>>BDS|Dental Surgery</option>
                                    <option value="BSC-Honours" <?php selected($partner_education, 'BSC-Honours'); ?>>
                                        BSC-Honours</option>
                                    <option value="C.A" <?php selected($partner_education, 'C.A'); ?>>C.A</option>
                                    <option value="Dakhil" <?php selected($partner_education, 'Dakhil'); ?>>Dakhil
                                    </option>
                                    <option value="Diploma" <?php selected($partner_education, 'Diploma'); ?>>Diploma
                                    </option>
                                    <option value="DVM" <?php selected($partner_education, 'DVM'); ?>>DVM</option>
                                    <option value="Fazil" <?php selected($partner_education, 'Fazil'); ?>>Fazil</option>
                                    <option value="FCPS Part - 1" <?php selected($partner_education, 'FCPS Part - 1'); ?>>FCPS Part - 1</option>
                                    <option value="FCPS Part - 2" <?php selected($partner_education, 'FCPS Part - 2'); ?>>FCPS Part - 2</option>
                                    <option value="H.S.C" <?php selected($partner_education, 'H.S.C'); ?>>H.S.C</option>
                                    <option value="High School" <?php selected($partner_education, 'High School'); ?>>
                                        High School</option>
                                    <option value="Higher Diploma" <?php selected($partner_education, 'Higher Diploma'); ?>>Higher Diploma</option>
                                    <option value="Honours Degree" <?php selected($partner_education, 'Honours Degree'); ?>>Honours Degree</option>
                                    <option value="Kamil" <?php selected($partner_education, 'Kamil'); ?>>Kamil</option>
                                    <option value="M.A|M.SS|M.COM|MSC" <?php selected($partner_education, 'M.A|M.SS|M.COM|MSC'); ?>>M.A|M.SS|M.COM|MSC</option>
                                    <option value="M.Phil" <?php selected($partner_education, 'M.Phil'); ?>>M.Phil
                                    </option>
                                    <option value="Masters" <?php selected($partner_education, 'Masters'); ?>>Masters
                                    </option>
                                    <option value="MBA" <?php selected($partner_education, 'MBA'); ?>>MBA</option>
                                    <option value="MBBS" <?php selected($partner_education, 'MBBS'); ?>>MBBS</option>
                                    <option value="MBS" <?php selected($partner_education, 'MBS'); ?>>MBS</option>
                                    <option value="O level" <?php selected($partner_education, 'O level'); ?>>O level
                                    </option>
                                    <option value="PHD|Doctorate" <?php selected($partner_education, 'PHD|Doctorate'); ?>>PHD|Doctorate</option>
                                    <option value="PMP" <?php selected($partner_education, 'PMP'); ?>>PMP</option>
                                    <option value="Trade school" <?php selected($partner_education, 'Trade school'); ?>>
                                        Trade school</option>
                                    <option value="Undergraduate" <?php selected($partner_education, 'Undergraduate'); ?>>Undergraduate</option>
                                </select>
                            </div>
                        </div>
                        <!-- profession -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Select profession:</span>
                            <div class="input-group">
                                <select id="partner_profession" name="partner_profession"
                                    class="form-select form-select-sm">
                                    <option value="" disabled>Select profession</option>
                                    <option value="Accountant" <?php selected($partner_profession, 'Accountant'); ?>>
                                        Accountant</option>
                                    <option value="Architect" <?php selected($partner_profession, 'Architect'); ?>>
                                        Architect</option>
                                    <option value="Artist" <?php selected($partner_profession, 'Artist'); ?>>Artist
                                    </option>
                                    <option value="Banker" <?php selected($partner_profession, 'Banker'); ?>>Banker
                                    </option>
                                    <option value="Business Analyst" <?php selected($partner_profession, 'Business Analyst'); ?>>Business Analyst</option>
                                    <option value="Business Owner" <?php selected($partner_profession, 'Business Owner'); ?>>Business Owner</option>
                                    <option value="Chef" <?php selected($partner_profession, 'Chef'); ?>>Chef</option>
                                    <option value="Civil Engineer" <?php selected($partner_profession, 'Civil Engineer'); ?>>Civil Engineer</option>
                                    <option value="Content Writer" <?php selected($partner_profession, 'Content Writer'); ?>>Content Writer</option>
                                    <option value="Customer Service Representative" <?php selected($partner_profession, 'Customer Service Representative'); ?>>Customer Service Representative</option>
                                    <option value="Data Analyst" <?php selected($partner_profession, 'Data Analyst'); ?>>Data Analyst</option>
                                    <option value="Dentist" <?php selected($partner_profession, 'Dentist'); ?>>Dentist
                                    </option>
                                    <option value="Digital Marketer" <?php selected($partner_profession, 'Digital Marketer'); ?>>Digital Marketer</option>
                                    <option value="Doctor" <?php selected($partner_profession, 'Doctor'); ?>>Doctor
                                    </option>
                                    <option value="Engineer" <?php selected($partner_profession, 'Engineer'); ?>>
                                        Engineer</option>
                                    <option value="Fashion Designer" <?php selected($partner_profession, 'Fashion Designer'); ?>>Fashion Designer</option>
                                    <option value="Financial Advisor" <?php selected($partner_profession, 'Financial Advisor'); ?>>Financial Advisor</option>
                                    <option value="Graphic Designer" <?php selected($partner_profession, 'Graphic Designer'); ?>>Graphic Designer</option>
                                    <option value="Human Resources" <?php selected($partner_profession, 'Human Resources'); ?>>Human Resources</option>
                                    <option value="Interior Designer" <?php selected($partner_profession, 'Interior Designer'); ?>>Interior Designer</option>
                                    <option value="IT Professional" <?php selected($partner_profession, 'IT Professional'); ?>>IT Professional</option>
                                    <option value="Journalist" <?php selected($partner_profession, 'Journalist'); ?>>
                                        Journalist</option>
                                    <option value="Lawyer" <?php selected($partner_profession, 'Lawyer'); ?>>Lawyer
                                    </option>
                                    <option value="Marketing Manager" <?php selected($partner_profession, 'Marketing Manager'); ?>>Marketing Manager</option>
                                    <option value="Mechanical Engineer" <?php selected($partner_profession, 'Mechanical Engineer'); ?>>Mechanical Engineer</option>
                                    <option value="Nurse" <?php selected($partner_profession, 'Nurse'); ?>>Nurse
                                    </option>
                                    <option value="Pharmacist" <?php selected($partner_profession, 'Pharmacist'); ?>>
                                        Pharmacist</option>
                                    <option value="Photographer" <?php selected($partner_profession, 'Photographer'); ?>>Photographer</option>
                                    <option value="Pilot" <?php selected($partner_profession, 'Pilot'); ?>>Pilot
                                    </option>
                                    <option value="Police Officer" <?php selected($partner_profession, 'Police Officer'); ?>>Police Officer</option>
                                    <option value="Professor" <?php selected($partner_profession, 'Professor'); ?>>
                                        Professor</option>
                                    <option value="Real Estate Agent" <?php selected($partner_profession, 'Real Estate Agent'); ?>>Real Estate Agent</option>
                                    <option value="Research Scientist" <?php selected($partner_profession, 'Research Scientist'); ?>>Research Scientist</option>
                                    <option value="Sales Manager" <?php selected($partner_profession, 'Sales Manager'); ?>>Sales Manager</option>
                                    <option value="Software Developer" <?php selected($partner_profession, 'Software Developer'); ?>>Software Developer</option>
                                    <option value="Teacher" <?php selected($partner_profession, 'Teacher'); ?>>Teacher
                                    </option>
                                    <option value="Therapist" <?php selected($partner_profession, 'Therapist'); ?>>
                                        Therapist</option>
                                    <option value="Translator" <?php selected($partner_profession, 'Translator'); ?>>
                                        Translator</option>
                                    <option value="Veterinarian" <?php selected($partner_profession, 'Veterinarian'); ?>>Veterinarian</option>
                                    <option value="Web Developer" <?php selected($partner_profession, 'Web Developer'); ?>>Web Developer</option>
                                    <option value="Writer" <?php selected($partner_profession, 'Writer'); ?>>Writer
                                    </option>
                                </select>
                            </div>
                        </div>
                        <!-- Annual Income -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Select Annual Income:</span>
                            <div class="input-group">
                                <select class="form-control" id="partner_currency">
                                    <option value="taka" selected>Taka (৳)</option>
                                    <option value="dollar">Dollar ($)</option>
                                </select>
                                <select class="form-control" id="partner_annual_income" name="partner_annual_income">
                                    <option value="" disabled>Select Annual Income</option>
                                    <option value="Any Annual Income" <?php selected($partner_annual_income, 'Any Annual Income'); ?>>Any Annual Income</option>
                                    <option value="Rs. 5 - 6 Lakhs" <?php selected($partner_annual_income, 'Rs. 5 - 6 Lakhs'); ?>>Rs. 5 - 6 Lakhs</option>
                                    <option value="Rs. 6 - 7 Lakhs" <?php selected($partner_annual_income, 'Rs. 6 - 7 Lakhs'); ?>>Rs. 6 - 7 Lakhs</option>
                                    <option value="Rs. 7 - 8 Lakhs" <?php selected($partner_annual_income, 'Rs. 7 - 8 Lakhs'); ?>>Rs. 7 - 8 Lakhs</option>
                                    <option value="Rs. 8 - 9 Lakhs" <?php selected($partner_annual_income, 'Rs. 8 - 9 Lakhs'); ?>>Rs. 8 - 9 Lakhs</option>
                                    <!-- Add more income options as needed -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Add a hidden field for the user ID -->
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="partnerProfessionalForm" name="update_partner_professional_preferences"
                    class="btn theme-btn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Partner Location Preferences Modal -->
<div class="modal fade" id="partnerlocationdetailsmodal" tabindex="-1"
    aria-labelledby="partnerlocationdetailsmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="partnerlocationdetailsmodalLabel">Edit Partner Location Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="partnerLocationForm" method="post" action="">
                    <div class="mb-3">
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Country</span>
                            <div class="input-group">
                                <select class="form-select" id="partner_country" name="partner_country">
                                    <option value="" disabled>Select Country</option>
                                    <option value="Bangladesh" <?php selected($partner_country, 'Bangladesh'); ?>>
                                        Bangladesh</option>
                                    <option value="USA" <?php selected($partner_country, 'USA'); ?>>USA</option>
                                    <!-- Add more countries as needed -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Add a hidden field for the user ID -->
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="partnerLocationForm" name="update_partner_location"
                    class="btn theme-btn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Social Details Modal -->
<div class="modal fade" id="socialaccounts" tabindex="-1" aria-labelledby="socialaccountsmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="socialaccountsmodalLabel">Linked Accounts</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="socialaccountsForm" method="post" action="">
                    <div class="mb-3">
                        <!-- Facebook -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Facebook</span>
                            <input class="form-control w-75" placeholder="Enter Facebook Username" name="facebook"
                                id="user_fb" type="text" value="<?php echo esc_attr($facebook); ?>">
                        </div>
                        <!-- Instagram -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">Instagram</span>
                            <input class="form-control w-75" placeholder="Enter Instagram Username" name="instagram"
                                id="user_ig" type="text" value="<?php echo esc_attr($instagram); ?>">
                        </div>
                        <!-- LinkedIn -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">LinkedIn</span>
                            <input class="form-control w-75" placeholder="Enter LinkedIn Username" name="linkedin"
                                id="user_linkedin" type="text" value="<?php echo esc_attr($linkedin); ?>">
                        </div>
                        <!-- X (Twitter) -->
                        <div class="justify-content-between d-flex mt-3">
                            <span class="d-inline-block mt-2 w-25">X</span>
                            <input class="form-control w-75" placeholder="Enter X Handle" name="x" id="user_x"
                                type="text" value="<?php echo esc_attr($x); ?>">
                        </div>
                    </div>
                    <!-- Add a hidden field for the user ID -->
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="socialaccountsForm" name="update_social_accounts" class="btn theme-btn">Save
                    Changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="imageUpload">Choose an image to upload:</label>
                        <input type="file" class="form-control-file" id="imageUpload" name="imageUpload"
                            accept="image/*">
                    </div>
                    <!-- Add a hidden field for the user ID -->
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="uploadForm" name="upload_image" class="btn theme-btn">Upload</button>
            </div>
        </div>
    </div>
</div>


<!-- Profile Picture Upload Modal -->
<div class="modal fade" id="profilePictureModal" tabindex="-1" role="dialog" aria-labelledby="profilePictureModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profilePictureModalLabel">Upload & Crop Profile Picture</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Profile Picture Upload Form -->
                <form id="profilePictureForm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="profilePictureUpload">Choose a new profile picture:</label>
                        <input type="file" class="form-control-file" id="profilePictureUpload" name="profile_picture"
                            accept="image/*">
                    </div>

                    <!-- Image Preview & Cropping Area -->
                    <div class="form-group text-center" id="imagePreviewContainer" style="display: none;">
                        <img id="imagePreview" style="max-width: 100%; display: block; margin: auto;">
                    </div>

                    <!-- Hidden Input to Store Cropped Image Data -->
                    <input type="hidden" name="cropped_image" id="croppedImageData">
                    <input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="cropImageBtn" class="btn theme-btn">Crop & Upload</button>
            </div>
        </div>
    </div>
</div>


<!-- About Details Modal -->
<div class="modal fade" id="verifyEmailModal" tabindex="-1" aria-labelledby="verifyEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="verifyEmailModalLabel">Verify Email</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                if ($email_verified == false) {
                    echo 'Your email is not verified yet. Please check your inbox and verify it to edit your profile.';
                } elseif ($email_verified == true && $approval_status !== 'approved') {
                    echo '✅ Your email has been verified. Please wait for admin approval to edit your profile.';
                }
                ?>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>





<?php get_footer(); ?>