<?php
/* Template Name: Matrimonial Search */
get_header(); ?>

<div class="container">
    <h1 class="theme-text-color text-center mb-4 mt-5">SEARCH YOUR MATCH</h1>
</div>

<section id="center" class="list pt-5 pb-5">
    <div class="container-xl">
        <div class="row list_1">
            <!-- Left Sidebar with Filters -->
            <div class="col-lg-3 col-md-4">
                <div class="mobile_filter">
                    <i class="bi bi-funnel"></i> Filter
                </div>
                <div class="list_1_left">
                    <div class="list_1_left1">
                        <h3>Filter Profiles</h3>
                        <hr class="line mb-4">

                        <!-- Filter Form -->
                        <form id="filter-form">
                            <div class="form-group">
                                <label for="lookingfor">Looking for</label>
                                <select id="lookingfor" name="lookingfor" class="form-select">
                                    <option value="" selected>All</option>
                                    <option value="bride">Bride</option>
                                    <option value="groom">Groom</option>
                                </select>
                            </div>

                            <div class="form-group mt-2">
                                <label for="country">Country of Recidance</label>
                                <select id="country" name="country" class="form-select">
                                    <option value="" selected>All</option>
                                    <option value="bangladesh">Bangladesh</option>
                                    <option value="usa">USA</option>
                                </select>
                            </div>

                            <div class="form-group mt-2">
                                <label for="marital_status">Marital Status</label>
                                <select id="marital_status" name="marital_status" class="form-select">
                                    <option value="" selected>All</option>
                                    <option value="Never Married">Single</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Awaiting Divorce">Awaiting Divorce</option>
                                    <option value="Annulled">Annulled
                                    </option>
                                    <option value="Divorced">Divorced
                                    </option>
                                </select>
                            </div>

                            <div class="form-group mt-2">
                                <label for="religion">Religion</label>
                                <select id="religion" name="religion" class="form-select">
                                    <option value="">All</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Hinduism">Hinduism</option>
                                    <option value="Christianity">
                                        Christianity</option>
                                    <option value="Buddhism">Buddhism</option>
                                    <option value="Judaism">Judaism</option>
                                    <option value="Sikhism">Sikhism</option>
                                    <option value="Jainism">Jainism</option>
                                    <option value="Baháí">Baháí</option>
                                    <option value="Zoroastrianism">
                                        Zoroastrianism</option>
                                    <option value="Atheist">Atheist</option>
                                    <option value="Agnostic">Agnostic</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="form-group mt-2">
                                <label for="profession">Profession</label>
                                <select id="profession" name="profession" class="form-select">
                                    <option value="">All</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="architect">Architect</option>
                                    <option value="artist">Artist</option>
                                    <option value="banker">Banker</option>
                                    <option value="business_analyst">Business Analyst</option>
                                    <option value="business_owner">Business Owner</option>
                                    <option value="chef">Chef</option>
                                    <option value="civil_engineer">Civil Engineer</option>
                                    <option value="content_writer">Content Writer</option>
                                    <option value="customer_service_rep">Customer Service Representative</option>
                                    <option value="data_analyst">Data Analyst</option>
                                    <option value="dentist">Dentist</option>
                                    <option value="digital_marketer">Digital Marketer</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="engineer">Engineer</option>
                                    <option value="fashion_designer">Fashion Designer</option>
                                    <option value="financial_advisor">Financial Advisor</option>
                                    <option value="graphic_designer">Graphic Designer</option>
                                    <option value="human_resources">Human Resources</option>
                                    <option value="interior_designer">Interior Designer</option>
                                    <option value="it_professional">IT Professional</option>
                                    <option value="journalist">Journalist</option>
                                    <option value="lawyer">Lawyer</option>
                                    <option value="marketing_manager">Marketing Manager</option>
                                    <option value="mechanical_engineer">Mechanical Engineer</option>
                                    <option value="nurse">Nurse</option>
                                    <option value="pharmacist">Pharmacist</option>
                                    <option value="photographer">Photographer</option>
                                    <option value="pilot">Pilot</option>
                                    <option value="police_officer">Police Officer</option>
                                    <option value="professor">Professor</option>
                                    <option value="real_estate_agent">Real Estate Agent</option>
                                    <option value="research_scientist">Research Scientist</option>
                                    <option value="sales_manager">Sales Manager</option>
                                    <option value="software_developer">Software Developer</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="therapist">Therapist</option>
                                    <option value="translator">Translator</option>
                                    <option value="veterinarian">Veterinarian</option>
                                    <option value="web_developer">Web Developer</option>
                                    <option value="writer">Writer</option>

                                </select>
                            </div>

                            <div class="form-group mt-2">
                                <label for="smoking_status">Smoking Habits</label>
                                <select id="smoking_status" name="smoking_status" class="form-select">
                                    <option value="" selected>All</option>
                                    <option value="Never">Never</option>
                                    <option value="Occasionally">
                                        Occasionally</option>
                                    <option value="Regularly">Regularly
                                    </option>
                                </select>
                            </div>

                            <div class="form-group mt-2">
                                <label for="drinking_status">Drinking Status</label>
                                <select id="drinking_status" name="drinking_status" class="form-select">
                                    <option value="" selected>All</option>
                                    <option value="Never">Never</option>
                                    <option value="Occasionally">
                                        Occasionally</option>
                                    <option value="Regularly">Regularly
                                    </option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Section for displaying profiles -->
            <div class="col-lg-9 col-md-8">
                <div class="list_1_right shadow p-3">
                    <div class="list_1_right2">
                        <div id="profile-list" class="tab-content mt-4">
                            <?php
                            // Get the current page for pagination
                            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                            // Handle filter parameters from GET request
                            $looking_for = isset($_GET['looking_for']) ? sanitize_text_field($_GET['looking_for']) : '';
                            $country = isset($_GET['country']) ? sanitize_text_field($_GET['country']) : '';
                            $marital_status = isset($_GET['marital_status']) ? sanitize_text_field($_GET['marital_status']) : '';
                            $religion = isset($_GET['religion']) ? sanitize_text_field($_GET['religion']) : '';
                            $profession = isset($_GET['profession']) ? sanitize_text_field($_GET['profession']) : '';
                            $smoking_status = isset($_GET['smoking_status']) ? sanitize_text_field($_GET['smoking_status']) : '';
                            $drinking_status = isset($_GET['drinking_status']) ? sanitize_text_field($_GET['drinking_status']) : '';

                            // Define the query arguments to get users
                            $args = array(
                                'number' => 2,  // Limit to 2 users per page (adjust as needed)
                                'paged' => $paged, // Current page
                                'meta_query' => array(
                                    'relation' => 'AND',
                                ),
                            );

                            if ($looking_for) {
                                $args['meta_query'][] = array(
                                    'key' => 'looking_for',
                                    'value' => $looking_for,
                                    'compare' => '=',
                                );
                            }
                            if ($country) {
                                $args['meta_query'][] = array(
                                    'key' => 'country',
                                    'value' => $country,
                                    'compare' => 'LIKE',
                                );
                            }
                            if ($marital_status) {
                                $args['meta_query'][] = array(
                                    'key' => 'marital_status',
                                    'value' => $marital_status,
                                    'compare' => '=',
                                );
                            }
                            if ($religion) {
                                $args['meta_query'][] = array(
                                    'key' => 'religion',
                                    'value' => $religion,
                                    'compare' => '=',
                                );
                            }
                            if ($profession) {
                                $args['meta_query'][] = array(
                                    'key' => 'profession',
                                    'value' => $profession,
                                    'compare' => '=',
                                );
                            }
                            if ($smoking_status) {
                                $args['meta_query'][] = array(
                                    'key' => 'smoking_habits',  // Correct the meta key
                                    'value' => $smoking_status,  // Smoking habits filter value
                                    'compare' => '='
                                );
                            }
                            if ($drinking_status) {
                                $args['meta_query'][] = array(
                                    'key' => 'drinking_habits',  // Correct the meta key
                                    'value' => $drinking_status,  // Drinking habits filter value
                                    'compare' => '='
                                );
                            }

                            // Use WP_User_Query for pagination support
                            $user_query = new WP_User_Query($args);

                            // Get the filtered users
                            $users = $user_query->get_results();
                            $total_users = $user_query->get_total(); // Get the total number of users for pagination
                            
                            // Output the profiles in the required format
                            if ($users) {
                                foreach ($users as $user) {
                                    // Get user meta data
// Get user meta data
                                    $about_yourself = get_user_meta($user->ID, 'about_yourself', true);
                                    $profile_pic = get_user_meta($user->ID, 'user_avatar', true);
                                    //If no profile picture is set, use a default placeholder
                                    if (empty($profile_pic)) {
                                        $profile_pic = get_template_directory_uri() . '/image/avater.webp'; // Path to your default avatar
                                    }
                                    $name = get_user_meta($user->ID, 'first_name', true) . ' ' . get_user_meta($user->ID, 'last_name', true);
                                    $age = get_user_meta($user->ID, 'age', true);
                                    $height = get_user_meta($user->ID, 'height', true);
                                    $religion = get_user_meta($user->ID, 'religion', true);

                                    $country = get_user_meta($user->ID, 'country', true);
                                    $division = get_user_meta($user->ID, 'division', true);
                                    $district = get_user_meta($user->ID, 'district', true);
                                    $upazila = get_user_meta($user->ID, 'upazila', true);
                                    $village = get_user_meta($user->ID, 'village', true);
                                    $landmark = get_user_meta($user->ID, 'landmark', true);

                                    $state = get_user_meta($user->ID, 'state', true);
                                    $city = get_user_meta($user->ID, 'city', true);
                                    $usaLandmark = get_user_meta($user->ID, 'usaLandmark', true);
                                    if ($country == "Bangladesh") {
                                        $location = $district . ', ' . $country;
                                    } else {
                                        $location = $city . ', ' . $country;
                                    }

                                    $education = get_user_meta($user->ID, 'education', true);
                                    $profession = get_user_meta($user->ID, 'profession', true);
                                    $annual_income = get_user_meta($user->ID, 'annual_income', true);
                                    $gender = get_user_meta($user->ID, 'gender', true);
                                    // Fetch linked accounts from user meta
                                    $facebook = get_user_meta($user->ID, 'facebook', true);
                                    $instagram = get_user_meta($user->ID, 'instagram', true);
                                    $linkedin = get_user_meta($user->ID, 'linkedin', true);
                                    $x = get_user_meta($user->ID, 'x', true);
                                    ?>
                                    <div class="list_1_right2_inner row border-top mt-4 pt-4 mx-0">
                                        <div class="col-md-4 ps-0 col-sm-4">
                                            <div class="list_1_right2_inner_left">
                                                <a
                                                    href="<?php echo get_permalink(get_page_by_path('user-details')); ?>?user_id=<?php echo $user->ID; ?>"><img
                                                        src="<?php echo esc_url($profile_pic); ?>" class="img-fluid"
                                                        alt="abc"></a>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-8">
                                            <div
                                                class="row row-cols-1 row-cols-lg-2 row-cols-md-1 list_1_right2_inner_right_inner">
                                                <div class="col">
                                                    <div class="list_1_right2_inner_right">
                                                        <b class="d-block mb-3 fs-5"><a
                                                                href="<?php echo get_permalink(get_page_by_path('user-details')); ?>?user_id=<?php echo $user->ID; ?>"><?php echo esc_html($name); ?>
                                                            </a></b>
                                                        <ul class="font_15 mb-0">
                                                            <li class="d-flex"><b class="me-2"> Age:</b>
                                                                <span><?php echo esc_html($age); ?> Yrs</span>
                                                            </li>
                                                            <li class="d-flex mt-2"><b class="me-2"> Religion:</b><span>
                                                                    <?php echo esc_html($religion); ?></span></li>
                                                            <li class="d-flex mt-2"><b class="me-2"> Height:</b><span>
                                                                    <?php echo esc_html($height); ?></span></li>
                                                            <li class="d-flex mt-2"><b class="me-2"> Location:</b><span>
                                                                    <?php echo esc_html($location); ?></span></li>
                                                            <li class="d-flex mt-2"><b class="me-2"> Education:</b><span>
                                                                    <?php echo esc_html($education); ?></span></li>
                                                            <li class="d-flex mt-2"><b class="me-2"> Profession:</b><span>
                                                                    <?php echo esc_html($profession); ?></span></li>
                                                            <li class="d-flex mt-2"><b class="me-2"> Annual Income:</b><span>
                                                                    <?php echo esc_html($annual_income); ?></span></li>
                                                        </ul>
                                                        <span class="d-block mt-3">
                                                            <a class="button"
                                                                href="<?php echo get_permalink(get_page_by_path('user-details')); ?>?user_id=<?php echo $user->ID; ?>">
                                                                <i class="bi bi-person-fill me-1 align-middle"></i> View Full
                                                                Profile
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="list_1_right2_inner_right">
                                                        <p class="mt-1"><?php echo $about_yourself; ?></p>
                                                        <ul class="mb-0 d-flex social_brands">
                                                            <?php if($facebook){?>
                                                                <li>
                                                                <a class="bg-primary d-inline-block text-white text-center"
                                                                    href="https://www.facebook.com/<?php echo esc_attr($facebook); ?>"
                                                                    target="_blank">
                                                                    <i class="bi bi-facebook"></i>
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                            <?php if($instagram){?>
                                                            <!-- Instagram -->
                                                            <li class="ms-2">
                                                                <a class="bg-success d-inline-block text-white text-center"
                                                                    href="https://www.instagram.com/<?php echo esc_attr($instagram); ?>"
                                                                    target="_blank">
                                                                    <i class="bi bi-instagram"></i>
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                            <?php if($linkedin){?>
                                                            <!-- LinkedIn -->
                                                            <li class="ms-2">
                                                                <a class="bg-warning d-inline-block text-white text-center"
                                                                    href="https://www.linkedin.com/in/<?php echo esc_attr($linkedin); ?>"
                                                                    target="_blank">
                                                                    <i class="bi bi-linkedin"></i>
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                            <?php if($x){?>
                                                            <!-- X (Twitter) -->
                                                            <li class="ms-2">
                                                                <a class="bg-dark d-inline-block text-white text-center"
                                                                    href="https://twitter.com/<?php echo esc_attr($x); ?>"
                                                                    target="_blank">
                                                                    <i class="bi bi-twitter-x"></i>
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                        </ul>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo '<p class="col-12 text-center">No profiles found based on your search criteria.</p>';
                            }
                            ?>

                            <!-- Pagination -->
                            <div class="paging">
                                <ul class="mb-0 paginate text-center mt-4">
                                    <?php
                                    $big = 999999999; // An unlikely integer
                                    $pagination = paginate_links(array(
                                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                        'format' => '?paged=%#%',
                                        'current' => max(1, get_query_var('paged')),
                                        'total' => ceil($total_users / $args['number']), // Calculate total pages
                                        'prev_text' => '<i class="bi bi-chevron-left"></i>',
                                        'next_text' => '<i class="bi bi-chevron-right"></i>',
                                        'type' => 'array', // Return as an array instead of a string
                                        'mid_size' => 2, // Number of pages to show around the current page
                                    ));

                                    if (!empty($pagination)):
                                        foreach ($pagination as $page_link):
                                            // Add custom classes to the pagination links
                                            $page_link = str_replace('page-numbers', 'border d-block', $page_link);
                                            $page_link = str_replace('current', 'border d-block active', $page_link);
                                            ?>
                                            <li class="d-inline-block mt-1 mb-1"><?php echo $page_link; ?></li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const filterBtn = document.querySelector(".mobile_filter");
        const filterSection = document.querySelector(".list_1_left");

        if (filterBtn && filterSection) {
            filterBtn.addEventListener("click", function () {
                filterSection.classList.toggle("active"); // Toggle visibility
            });
        }
    });


</script>


<!-- Modal for login (if applicable) -->
<?php get_footer(); ?>