<?php
/**
 * Template Name: User Profile
 */
get_header();



// Ensure user ID is passed in the URL
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;

if ($user_id) {
    // Fetch user info
    $user_info = get_user_by('ID', $user_id);

    if ($user_info) {
        // Fetch user meta data
        $profile_pic = get_user_meta($user_id, 'user_avatar', true);
        //If no profile picture is set, use a default placeholder
if (empty($profile_pic)) {
    $profile_pic = get_template_directory_uri() . '/image/avater.webp'; // Path to your default avatar
}
        $about_yourself = get_user_meta($user_id, 'about_yourself', true);
        $name = $user_info->first_name . ' ' . $user_info->last_name;
        $age = get_user_meta($user_id, 'age', true);
        $height = get_user_meta($user_id, 'height', true);
        $religion = get_user_meta($user_id, 'religion', true);
        $location = get_user_meta($user_id, 'location', true);
        $education = get_user_meta($user_id, 'education', true);
        $profession = get_user_meta($user_id, 'profession', true);
        $annual_income = get_user_meta($user_id, 'annual_income', true);

        $mother_tongue = get_user_meta($user_id, 'mother_tongue', true);
        $marital_status = get_user_meta($user_id, 'marital_status', true);
        $body_type = get_user_meta($user_id, 'body_type', true);
        $complexion = get_user_meta($user_id, 'complexion', true);
        $physical_status = get_user_meta($user_id, 'physical_status', true);
        $eating_habits = get_user_meta($user_id, 'eating_habits', true);
        $drinking_habits = get_user_meta($user_id, 'drinking_habits', true);
        $smoking_habits = get_user_meta($user_id, 'smoking_habits', true);

        // Fetch linked accounts from user meta
        $facebook = get_user_meta($user_id, 'facebook', true);
        $instagram = get_user_meta($user_id, 'instagram', true);
        $linkedin = get_user_meta($user_id, 'linkedin', true);
        $x = get_user_meta($user_id, 'x', true);

        // Fetch contact details from user meta
        $candidate_phone = get_user_meta($user_id, 'user_phone', true);
        $candidate_country_code = get_user_meta($user_id, 'candidate_country_code', true);
        $parent_phone = get_user_meta($user_id, 'user_g_phone', true);
        $parent_country_code = get_user_meta($user_id, 'guardian_country_code', true);
        $user_data = get_userdata($user_id);
        $email = $user_data->user_email;

        $country = get_user_meta($user_id, 'country', true);
        $division = get_user_meta($user_id, 'division', true);
        $district = get_user_meta($user_id, 'district', true);
        $upazila = get_user_meta($user_id, 'upazila', true);
        $village = get_user_meta($user_id, 'village', true);
        $landmark = get_user_meta($user_id, 'landmark', true);

        $state = get_user_meta($user_id, 'state', true);
        $city = get_user_meta($user_id, 'city', true);
        $usaLandmark = get_user_meta($user_id, 'usaLandmark', true);
        // Fetch professional details from user meta
$education = get_user_meta($user_id, 'education', true);
$education_detail = get_user_meta($user_id, 'education_detail', true);
$employed_in = get_user_meta($user_id, 'employed_in', true);
$profession = get_user_meta($user_id, 'profession', true);
$profession_detail = get_user_meta($user_id, 'profession_detail', true);
$annual_income = get_user_meta($user_id, 'annual_income', true);
$dob = get_user_meta($user_id, 'dob', true);
$place_of_birth = get_user_meta($user_id, 'place_of_birth', true);
$about_partner = get_user_meta($user_id, 'about_partner', true);
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
$partner_education = get_user_meta($user_id, 'partner_education', true);
$partner_profession = get_user_meta($user_id, 'partner_profession', true);
$partner_annual_income = get_user_meta($user_id, 'partner_annual_income', true);
$partner_religion = get_user_meta($user_id, 'partner_religion', true);
$partner_country = get_user_meta($user_id, 'partner_country', true);


    } else {
        echo '<p>No user found with this ID.</p>';
    }
} else {
    echo '<p>Invalid user ID.</p>';
}

?>

<section id="center" class="list pt-5 pb-5">
    <div class="container-xl">
        <div class="row list_1">
            <div class="col-lg-9 col-md-8">
                <div class="list_dt">
                    <div class="list_dt1 shadow p-3">
                        <div class="list_1_right2_inner row mx-0">
                            <div class="col-md-3 ps-0 col-sm-4">
                                <div class="list_1_right2_inner_left">
                                    <img src="<?php echo esc_url($profile_pic); ?>" class="img-fluid"
                                        alt="Profile Picture">
                                    <?php $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;

$last_login = get_user_meta($user_id, 'last_login', true);
$last_activity = get_user_meta($user_id, 'last_activity', true);

// Check if the user is online (e.g., if their last activity was within the last 5 minutes)
$is_online = false;
if ($last_activity && (time() - $last_activity < 300)) {
    $is_online = true;
}

if ($is_online) {
    echo '<span class="font_14 d-block mt-2">Online</span>';
} else {
    // If the user is offline, display the last login time
    if ($last_login) {
        $last_login_time = human_time_diff(strtotime($last_login), current_time('timestamp')) . ' ago';
        echo '<span class="font_14 d-block mt-2">Last Login: ' . esc_html($last_login_time) . '</span>';
    }
}
 ?>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-8">
                                <div class="row row-cols-1 row-cols-lg-2 row-cols-md-1 list_1_right2_inner_right_inner">
                                    <div class="col">
                                        <div class="list_1_right2_inner_right">
                                            <b class="d-block mb-3 fs-5"><a
                                                    href="#"><?php echo esc_html($name); ?></a></b>
                                            <ul class="font_15 mb-0">
                                                <li class="d-flex"><b class="me-2">Age:</b>
                                                    <span><?php echo esc_html($age); ?> Yrs</span></li>
                                                <li class="d-flex mt-2"><b class="me-2">Height:</b>
                                                    <span><?php echo esc_html($height); ?> Ft</span></li>
                                                <li class="d-flex mt-2"><b class="me-2">Religion:</b>
                                                    <span><?php echo esc_html($religion); ?></span></li>
                                                <li class="d-flex mt-2"><b class="me-2">Location:</b>
                                                    <span><?php echo esc_html($location); ?></span></li>
                                                <li class="d-flex mt-2"><b class="me-2">Education:</b>
                                                    <span><?php echo esc_html($education); ?></span></li>
                                                <li class="d-flex mt-2"><b class="me-2">Profession:</b>
                                                    <span><?php echo esc_html($profession); ?></span></li>
                                                <li class="d-flex mt-2"><b class="me-2">Annual Income:</b>
                                                    <span><?php echo esc_html($annual_income); ?></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="list_1_right2_inner_right">
                                            <p class="mt-1"><?php echo esc_html($about_yourself); ?></p>
                                            <ul class="mb-0 d-flex social_brands">
                                                <!-- Facebook -->
                                                <li>
                                                    <a class="bg-primary d-inline-block text-white text-center"
                                                        href="https://www.facebook.com/<?php echo esc_attr($facebook); ?>"
                                                        target="_blank">
                                                        <i class="bi bi-facebook"></i>
                                                    </a>
                                                </li>
                                                <!-- Instagram -->
                                                <li class="ms-2">
                                                    <a class="bg-success d-inline-block text-white text-center"
                                                        href="https://www.instagram.com/<?php echo esc_attr($instagram); ?>"
                                                        target="_blank">
                                                        <i class="bi bi-instagram"></i>
                                                    </a>
                                                </li>
                                                <!-- LinkedIn -->
                                                <li class="ms-2">
                                                    <a class="bg-warning d-inline-block text-white text-center"
                                                        href="https://www.linkedin.com/in/<?php echo esc_attr($linkedin); ?>"
                                                        target="_blank">
                                                        <i class="bi bi-linkedin"></i>
                                                    </a>
                                                </li>
                                                <!-- X (Twitter) -->
                                                <li class="ms-2">
                                                    <a class="bg-dark d-inline-block text-white text-center"
                                                        href="https://twitter.com/<?php echo esc_attr($x); ?>"
                                                        target="_blank">
                                                        <i class="bi bi-twitter-x"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                    

                                            <?php if (is_user_logged_in()): ?>
    <?php
    global $wpdb;
    $current_user = get_current_user_id(); // Safe now — inside is_user_logged_in() check
    $profile_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

    if ($current_user !== $profile_id && $profile_id > 0) {
        $interest_table = $wpdb->prefix . "interests";

        $already_sent = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $interest_table WHERE from_user_id = %d AND to_user_id = %d",
            $current_user, $profile_id
        ));
        ?>
        <div class="send-interest">
        <button 
            class="button button_1 text-uppercase interest-toggle-btn" 
            data-to-user-id="<?= esc_attr($profile_id); ?>" 
            data-action="<?= $already_sent ? 'cancel' : 'send'; ?>">
            <i class="bi <?= $already_sent ? 'bi-x-circle' : 'bi-heart' ?> me-1 align-middle"></i> 
            <?= $already_sent ? 'Cancel Interest' : 'Send Interest'; ?>
        </button>
        </div>

    <?php } ?>
<?php endif; ?>











                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Section -->
                    <div class="list_dt2 mt-4 p-3 shadow">
                        <h3>Personal Information</h3>
                        <hr class="line mb-4">
                        <h5 class="mb-3"><i class="bi bi-gender-female text-danger me-1 align-middle"></i> About</h5>
                        <p class="px_28 mb-0"><?php echo esc_html($about_yourself); ?></p>

                        <h5 class="mb-3 mt-4"><i class="bi bi-person text-danger me-1 align-middle"></i> Basic Details
                        </h5>
                        <ul class="px_28 font_14 justify-content-between d-flex mb-0 flex-wrap">
                            <li>
                                <b class="d-block">Name:</b>
                                <b class="d-block mt-2">Age:</b>
                                <b class="d-block mt-2">Height:</b>
                                <b class="d-block mt-2">Weight:</b>
                                <b class="d-block mt-2">Mother Tongue:</b>
                                <b class="d-block mt-2">Marital Status:</b>
                            </li>
                            <li>
                                <span class="d-block"><?php echo esc_html($name); ?></span>
                                <span class="d-block mt-2"><?php echo esc_html($age); ?> Yrs</span>
                                <span class="d-block mt-2"><?php echo esc_html($height); ?> Inch</span>
                                <span class="d-block mt-2"><?php echo esc_html($weight); ?> Kg</span>
                                <span class="d-block mt-2"><?php echo esc_html($mother_tongue); ?></span>
                                <span class="d-block mt-2"><?php echo esc_html($marital_status); ?></span>
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
                                            <span><?php echo esc_html($email); ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col">
                                <div class="list_dt2_inner_left">
                                    <h5 class="mb-3 mt-4">
                                        <i class="bi bi-book theme-text-color me-1 align-middle"></i>
                                        Religion Information
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
                                        <i class="bi bi-life-preserver theme-text-color me-1 align-middle"></i>
                                        Astro Details
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
                        </div>
                    </div>
                    <div class="list_dt2 mt-4 p-3 shadow">
                                    <h3>Partner Preferences</h3>
                                    <hr class="line mb-4">
                                    <h5 class="mb-3">
                                        <i class="bi bi-gender-male theme-text-color me-1 align-middle"></i>
                                        About Partner
                                    </h5>
                                    <p class="px_28 mb-0"><?php echo esc_html($about_partner); ?></p>
                                    <h5 class="mb-3 mt-4"><i
                                            class="bi bi-person theme-text-color me-1 align-middle"></i>
                                        Basic
                                        Preferences 
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
                                        Preferences</h5>
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
        <?php 
        // Fetch user photos from user meta (assuming photos are stored as an array of attachment IDs)
        $user_photos = get_user_meta($user_id, 'user_photos', true);

        // If no photos are set, initialize an empty array
        if (empty($user_photos)) {
            $user_photos = [];
        }

        // Check if there are any user photos
        if (!empty($user_photos)) {
            // Loop through the photos and display them
            foreach ($user_photos as $photo_id) {
                $photo_url = wp_get_attachment_url($photo_id);
                ?>
                <div class="col-md-4 mb-4">
                    <div class="gallery-item">
                        <!-- Link to open the image in lightbox -->
                        <a href="<?php echo esc_url($photo_url); ?>" data-lightbox="user-gallery" data-title="User Photo">
                            <img src="<?php echo esc_url($photo_url); ?>" alt="Gallery Image" class="img-fluid rounded">
                        </a>
                    </div>
                </div>
                <?php
            }
        } else {
            // If there are no photos, display a message
            echo '<p>No photos available.</p>';
        }
        ?>
    </div>
</div>
                </div>

            </div>
            <div class="col-lg-3 col-md-4 mt-4">
    <div class="list_1_left">
        <div class="list_1_left1">
            <?php
            // Display the Profile Page Widget Area
            if ( is_active_sidebar( 'profile_page_widget_area' ) ) {
                dynamic_sidebar( 'profile_page_widget_area' );
            }
            ?>
        </div>
    </div>
</div>

        </div>
</section>
<script>
jQuery(document).ready(function($) {
    $('.interest-toggle-btn').click(function(e) {
        e.preventDefault();
        let btn = $(this);
        let toUserId = btn.data('to-user-id');
        let currentAction = btn.data('action');

        $.post(interest_ajax.ajax_url, {
            action: 'toggle_interest',
            to_user_id: toUserId,
            type: currentAction,
            security: interest_ajax.nonce
        }, function(response) {
            if (response.success) {
                if (response.data.action === 'sent') {
                    btn.html('<i class="bi bi-heart me-1 align-middle"></i> Cancel Interest');
                    btn.data('action', 'cancel');
                } else {
                    btn.html('<i class="bi bi-heart me-1 align-middle"></i> Send Interest');
                    btn.data('action', 'send');
                }
            } else {
                alert(response.data.message || 'Something went wrong.');
            }
        });
    });
});
</script>

<?php get_footer(); ?>