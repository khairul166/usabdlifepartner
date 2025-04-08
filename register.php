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
 * Template Name: Register
 */

ob_start(); // Start output buffering
get_header();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Sanitize and validate input
    $username = isset($_POST['username']) ? sanitize_user($_POST['username']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['repassword']) ? $_POST['repassword'] : '';

    // Additional fields
    $profileby = isset($_POST['profileby']) ? sanitize_text_field($_POST['profileby']) : '';
    $lookingfor = isset($_POST['lookingfor']) ? sanitize_text_field($_POST['lookingfor']) : '';
    $fname = isset($_POST['fname']) ? sanitize_text_field($_POST['fname']) : '';
    $lname = isset($_POST['lname']) ? sanitize_text_field($_POST['lname']) : '';
    $religion = isset($_POST['religion']) ? sanitize_text_field($_POST['religion']) : '';
    $dob = isset($_POST['dob']) ? sanitize_text_field($_POST['dob']) : '';
    $maritalstatus = isset($_POST['maritalstatus']) ? sanitize_text_field($_POST['maritalstatus']) : '';
    $user_gender = isset($_POST['user_gender']) ? sanitize_text_field($_POST['user_gender']) : '';
    $education = isset($_POST['education']) ? sanitize_text_field($_POST['education']) : '';
    $user_profession = isset($_POST['user_profession']) ? sanitize_text_field($_POST['user_profession']) : '';
    $country = isset($_POST['country']) ? sanitize_text_field($_POST['country']) : '';
    $division = isset($_POST['division']) ? sanitize_text_field($_POST['division']) : '';
    $district = isset($_POST['district']) ? sanitize_text_field($_POST['district']) : '';
    $upazila = isset($_POST['upazila']) ? sanitize_text_field($_POST['upazila']) : '';
    $village = isset($_POST['village']) ? sanitize_text_field($_POST['village']) : '';
    $landmark = isset($_POST['landmark']) ? sanitize_text_field($_POST['landmark']) : '';
    $guardian_country_code = isset($_POST['guardian_country_code']) ? sanitize_text_field($_POST['guardian_country_code']) : '';
    $user_phone = isset($_POST['user_phone']) ? sanitize_text_field($_POST['user_phone']) : '';
    $user_g_phone = isset($_POST['user_g_phone']) ? sanitize_text_field($_POST['user_g_phone']) : '';
    $candidate_country_code = isset($_POST['candidate_country_code']) ? sanitize_text_field($_POST['candidate_country_code']) : '';

    // USA Fields
    $state = isset($_POST['state']) ? sanitize_text_field($_POST['state']) : '';
    $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';
    $usaLandmark = isset($_POST['usaLandmark']) ? sanitize_text_field($_POST['usaLandmark']) : '';

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error_message = 'Passwords do not match.';
    } else {
        // Create new user
        $user_id = wp_create_user($username, $password, $email);

        if (is_wp_error($user_id)) {
            $error_message = $user_id->get_error_message();
        } else {
            // Save additional user meta data
            update_user_meta($user_id, 'first_name', $fname);
            update_user_meta($user_id, 'last_name', $lname);
            update_user_meta($user_id, 'profile_created_by', $profileby);
            update_user_meta($user_id, 'looking_for', $lookingfor);
            update_user_meta($user_id, 'religion', $religion);
            update_user_meta($user_id, 'dob', $dob);
            update_user_meta($user_id, 'marital_status', $maritalstatus);
            update_user_meta($user_id, 'user_gender', $user_gender);
            update_user_meta($user_id, 'education', $education);
            update_user_meta($user_id, 'profession', $user_profession);
            update_user_meta($user_id, 'country', $country);
            update_user_meta($user_id, 'division', $division);
            update_user_meta($user_id, 'district', $district);
            update_user_meta($user_id, 'upazila', $upazila);
            update_user_meta($user_id, 'village', $village);
            update_user_meta($user_id, 'landmark', $landmark);
            update_user_meta($user_id, 'user_phone', $user_phone);
            update_user_meta($user_id, 'user_g_phone', $user_g_phone);

            // Save USA Fields
            if ($country === 'USA') {
                update_user_meta($user_id, 'state', $state);
                update_user_meta($user_id, 'city', $city);
                update_user_meta($user_id, 'usaLandmark', $usaLandmark);
            }

            // Generate verification token
            $token = bin2hex(random_bytes(16));
            update_user_meta($user_id, 'email_verification_token', $token);
            update_user_meta($user_id, 'email_verified', 0);

            // Build verification URL
            $verification_url = home_url("/verify-email/?token={$token}&user_id={$user_id}");

            // Send email
            $subject = 'Verify Your Email Address';
            $message = "<p>Thanks for registering. Please <a href='{$verification_url}'>click here to verify your email</a>.</p>";
            $headers = ['Content-Type: text/html; charset=UTF-8'];

            wp_mail($email, $subject, $message, $headers);

            // Optional: Log the user out right away if needed
//  wp_logout();

            wp_redirect(home_url('/my-account'));
            exit;
        }
    }
}
?>

<section id="center" class="search_form pt-5 pb-5">
    <div class="container-xl">
        <h1 class="theme-text-color text-center mb-4">REGISTRATION</h1>
        <div class="row search_form1 shadow p-4 w-75 mx-auto">
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo esc_html($error_message); ?></div>
            <?php endif; ?>
            <div class="col-md-12">
                <span class="text-center d-block mb-3">Your partner search begins with a<br>
                    FREE REGISTRATION!</span>
                <form method="post">
                    <div class="personalinfo">
                        <div class="row">
                            <h3 class="reg_form_head pb-2 pt-2 theme-text-color">Personal Information</h3>
                            <div class="col-md-6 pt-1 pb-2">
                                <label for="profileby">Profile created by:</label>
                                <select id="profileby" name="profileby" class="form-select form-select-sm">
                                    <option selected disabled>Select One</option>
                                    <option value="Self">Self</option>
                                    <option value="Friend">Friend</option>
                                    <option value="Guardian">Guardian</option>
                                    <option value="Parents">Parents</option>
                                    <option value="Relative">Relative</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-md-6 pt-1 pb-2">
                                <label for="lookingfor">Looking For:</label>
                                <select id="lookingfor" name="lookingfor" class="form-select form-select-sm">
                                    <option selected disabled>Select One</option>
                                    <option value="Bride">Bride</option>
                                    <option value="Groom">Groom</option>
                                </select>
                            </div>
                            <div class="col-md-6 pt-1 pb-2">
                                <label for="fname" class="form-label">First Name:</label>
                                <input type="text" class="form-control" id="fname" name="fname"
                                    placeholder="Enter your first name" required>
                            </div>
                            <div class="col-md-6 pt-1 pb-2">
                                <label for="lname" class="form-label">Last Name:</label>
                                <input type="text" class="form-control" id="lname" name="lname"
                                    placeholder="Enter your last name" required>
                            </div>
                            <div class="col-md-6 pt-1 pb-2">
                                <label for="religion" class="form-label">Religion:</label>
                                <select id="religion" name="religion" class="form-select form-select-sm" required>
                                    <option selected disabled>Religion</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Muslim">Muslim</option>
                                    <option value="Sikh">Sikh</option>
                                    <option value="Christian">Christian</option>
                                    <option value="Jain">Jain</option>
                                </select>
                            </div>
                            <div class="col-md-6 pt-1 pb-2">
                                <label for="dob" class="form-label">Date of Birth:</label>
                                <input type="date" class="form-control" id="dob" name="dob" required>
                            </div>
                            <div class="col-md-6 pt-1 pb-2">
                                <label for="maritalstatus" class="form-label">Marital Status:</label>
                                <select id="maritalstatus" name="maritalstatus" class="form-select form-select-sm"
                                    required>
                                    <option value="" selected disabled>Select Marital Status</option>
                                    <option value="Never Married">Never Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Awaiting Divorce">Awaiting Divorce</option>
                                    <option value="Annulled">Annulled</option>
                                    <option value="Divorced">Divorced</option>
                                </select>
                            </div>
                            <div class="col-md-6 pt-1 pb-2">
                                <label for="education" class="form-label">Education</label>
                                <select id="education" name="education" class="form-select form-select-sm" required>
                                    <option selected disabled>Select Education</option>
                                    <option value="A Level">A Level</option>
                                    <option value="Alim">Alim</option>
                                    <option value="Associates Degree">Associates Degree</option>
                                    <option value="B-Tech">B-Tech</option>
                                    <option value="B.C.S Cadre">B.C.S Cadre</option>
                                    <option value="BA|BSS|BCOM|BSC">BA|BSS|BCOM|BSC</option>
                                    <option value="Bachelor">Bachelor</option>
                                    <option value="BBA">BBA</option>
                                    <option value="BBS">BBS</option>
                                    <option value="BDS|Dental Surgery">BDS|Dental Surgery</option>
                                    <option value="BSC-Honours">BSC-Honours</option>
                                    <option value="C.A">C.A</option>
                                    <option value="Dakhil">Dakhil</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="DVM">DVM</option>
                                    <option value="Fazil">Fazil</option>
                                    <option value="FCPS Part - 1">FCPS Part - 1</option>
                                    <option value="FCPS Part - 2">FCPS Part - 2</option>
                                    <option value="H.S.C">H.S.C</option>
                                    <option value="High School">High School</option>
                                    <option value="Higher Diploma">Higher Diploma</option>
                                    <option value="Honours Degree">Honours Degree</option>
                                    <option value="Kamil">Kamil</option>
                                    <option value="M.A|M.SS|M.COM|MSC">M.A|M.SS|M.COM|MSC</option>
                                    <option value="M.Phil">M.Phil</option>
                                    <option value="Masters">Masters</option>
                                    <option value="MBA">MBA</option>
                                    <option value="MBBS">MBBS</option>
                                    <option value="MBS">MBS</option>
                                    <option value="O level">O level</option>
                                    <option value="PHD|Doctorate">PHD|Doctorate</option>
                                    <option value="PMP">PMP</option>
                                    <option value="Trade school">Trade school</option>
                                    <option value="Undergraduate">Undergraduate</option>
                                </select>
                            </div>
                            <div class="col-md-6 pt-1 pb-2">
                                <label for="user_profession" class="form-label">Profession</label>
                                <select id="user_profession" name="user_profession" class="form-select form-select-sm"
                                    required>
                                    <option value="" selected disabled>Select Profession</option>
                                    <option value="Accountant">Accountant</option>
                                    <option value="Acting Professional">Acting Professional</option>
                                    <option value="Actor">Actor</option>
                                    <option value="Administration Professional">Administration Professional</option>
                                    <option value="Advertising Professional">Advertising Professional</option>
                                    <option value="Air Hostess">Air Hostess</option>
                                    <option value="Airline">Airline</option>
                                    <option value="Architect">Architect</option>
                                    <option value="Artisan">Artisan</option>
                                    <option value="Audiologist">Audiologist</option>
                                    <option value="Banker">Banker</option>
                                    <option value="Beautician">Beautician</option>
                                    <option value="Biologist / Botanist">Biologist / Botanist</option>
                                    <option value="Business Person">Business Person</option>
                                    <option value="Chartered Accountant">Chartered Accountant</option>
                                    <option value="Civil Engineer">Civil Engineer</option>
                                    <option value="Clerical Official">Clerical Official</option>
                                    <option value="Commercial Pilot">Commercial Pilot</option>
                                    <option value="Company Secretary">Company Secretary</option>
                                    <option value="Computer Professional">Computer Professional</option>
                                    <option value="Consultant">Consultant</option>
                                    <option value="Contractor">Contractor</option>
                                    <option value="Cost Accountant">Cost Accountant</option>
                                    <option value="Creative Person">Creative Person</option>
                                    <option value="Customer Support Professional">Customer Support Professional</option>
                                    <option value="Defense Employee">Defense Employee</option>
                                    <option value="Dentist">Dentist</option>
                                    <option value="Designer">Designer</option>
                                    <option value="Doctor">Doctor</option>
                                    <option value="Economist">Economist</option>
                                    <option value="Employeed">Employeed</option>
                                    <option value="Engineer">Engineer</option>
                                    <option value="Engineer (Mechanical)">Engineer (Mechanical)</option>
                                    <option value="Engineer (Project)">Engineer (Project)</option>
                                    <option value="Entertainment Professional">Entertainment Professional</option>
                                    <option value="Event Manager">Event Manager</option>
                                    <option value="Executive">Executive</option>
                                    <option value="Factory worker">Factory worker</option>
                                    <option value="Farmer">Farmer</option>
                                    <option value="Fashion Designer">Fashion Designer</option>
                                    <option value="Finance Professional">Finance Professional</option>
                                    <option value="Flight Attendant">Flight Attendant</option>
                                    <option value="Government Employee">Government Employee</option>
                                    <option value="Health Care Professional">Health Care Professional</option>
                                    <option value="Home Maker">Home Maker</option>
                                    <option value="Hotel And Restaurant Professional">Hotel And Restaurant Professional
                                    </option>
                                    <option value="Human Resources Professional">Human Resources Professional</option>
                                    <option value="Interior Designer">Interior Designer</option>
                                    <option value="Investment Professional">Investment Professional</option>
                                    <option value="IT / Telecom Professional">IT / Telecom Professional</option>
                                    <option value="Journalist">Journalist</option>
                                    <option value="Lawyer">Lawyer</option>
                                    <option value="Lecturer">Lecturer</option>
                                    <option value="Legal Professional">Legal Professional</option>
                                    <option value="Magistrate">Magistrate</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Marine Engineer">Marine Engineer</option>
                                    <option value="Marine Professional">Marine Professional</option>
                                    <option value="Marketing Professional">Marketing Professional</option>
                                    <option value="Media Professional">Media Professional</option>
                                    <option value="Medical Professional">Medical Professional</option>
                                    <option value="Medical Transcriptionist">Medical Transcriptionist</option>
                                    <option value="Merchandiser">Merchandiser</option>
                                    <option value="Merchant Naval Officer">Merchant Naval Officer</option>
                                    <option value="Musician">Musician</option>
                                    <option value="NGO">NGO</option>
                                    <option value="Non-mainstream professional">Non-mainstream professional</option>
                                    <option value="Not Employeed">Not Employeed</option>
                                    <option value="Not working">Not working</option>
                                    <option value="Nurse">Nurse</option>
                                    <option value="Occupational Therapist">Occupational Therapist</option>
                                    <option value="Optician">Optician</option>
                                    <option value="Others">Others</option>
                                    <option value="Pharmacist">Pharmacist</option>
                                    <option value="Physician Assistant">Physician Assistant</option>
                                    <option value="Physicist">Physicist</option>
                                    <option value="Physiotherapist">Physiotherapist</option>
                                    <option value="Pilot">Pilot</option>
                                    <option value="Politician">Politician</option>
                                    <option value="Private services">Private services</option>
                                    <option value="Production professional">Production professional</option>
                                    <option value="Professional">Professional</option>
                                    <option value="Professor">Professor</option>
                                    <option value="Psychologist">Psychologist</option>
                                    <option value="Public Relations Professional">Public Relations Professional</option>
                                    <option value="Real Estate Professional">Real Estate Professional</option>
                                    <option value="Research Scholar">Research Scholar</option>
                                    <option value="Retail Professional">Retail Professional</option>
                                    <option value="Retired">Retired</option>
                                    <option value="Retired Gov. Person">Retired Gov. Person</option>
                                    <option value="Retired Person">Retired Person</option>
                                    <option value="Sales Professional">Sales Professional</option>
                                    <option value="Scientist">Scientist</option>
                                    <option value="Self-employed Person">Self-employed Person</option>
                                    <option value="Shipping Professional">Shipping Professional</option>
                                    <option value="Social Worker">Social Worker</option>
                                    <option value="Software Consultant">Software Consultant</option>
                                    <option value="Software Engineer">Software Engineer</option>
                                    <option value="Software QA Analyst">Software QA Analyst</option>
                                    <option value="Sonologist">Sonologist</option>
                                    <option value="Sportsman">Sportsman</option>
                                    <option value="Student">Student</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Teacher">Teacher</option>
                                    <option value="Technical Advisor">Technical Advisor</option>
                                    <option value="Technician">Technician</option>
                                    <option value="Training Professional">Training Professional</option>
                                    <option value="Transportation Professional">Transportation Professional</option>
                                    <option value="Veterinary Doctor">Veterinary Doctor</option>
                                    <option value="Volunteer">Volunteer</option>
                                    <option value="Working Abroad">Working Abroad</option>
                                    <option value="Writer">Writer</option>
                                    <option value="Zoologist">Zoologist</option>
                                </select>
                            </div>
                            <div class="col-md-6 pt-1 pb-2">
                                <label for="user_gender" class="form-label">Gender</label>
                                <select name="user_gender" id="user_gender" class="form-select form-select-sm" required>
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="trans_male">Transgender Male</option>
                                    <option value="trans_female">Transgender Female</option>
                                    <option value="non_binary">Non-Binary</option>
                                    <option value="genderqueer">Genderqueer</option>
                                    <option value="genderfluid">Genderfluid</option>
                                    <option value="agender">Agender</option>
                                    <option value="intersex">Intersex</option>
                                    <option value="two_spirit">Two-Spirit</option>
                                    <option value="other">Other</option>
                                    <option value="prefer_not_say">Prefer not to say</option>
                                </select>

                            </div>
                        </div>
                    </div>

                    <div class="addressinfo">
                        <h3 class="reg_form_head pb-2 pt-2 theme-text-color">Address Information</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="country" class="form-label">Country Of Present Location *</label>
                                <select id="country" name="country" class="form-select">
                                    <option selected disabled>Select country</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="USA">USA</option>
                                </select>
                            </div>

                        </div>

                        <div id="bangladeshFields">
                            <div class="row">
                            <div class="col-md-6 mt-3" id="user_divison">
                                <label for="division" class="form-label">Present Division *</label>
                                <select id="division" name="division" class="form-select">
                                    <option value="">Select Division</option>
                                </select>
                            </div>
                                <div class="col-md-6 mt-3">
                                    <label for="district" class="form-label">Present District *</label>
                                    <select id="district" name="district" class="form-select">
                                        <option value="">Select District</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="upazila" class="form-label">Present Upazila / City *</label>
                                    <select id="upazila" name="upazila" class="form-select">
                                        <option value="">Select Upazila/City</option>
                                    </select>
                                </div>


                                <div class="col-md-6 mt-3">
                                    <label for="village" class="form-label">Village / Area *</label>
                                    <select id="village" name="village" class="form-select">
                                        <option value="">Select Village/Area</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="landmark" class="form-label">Location / Landmark / Area *</label>
                                    <input type="text" id="landmark" name="landmark" class="form-control"
                                        placeholder="Enter landmark">
                                </div>
                                </div>
                        </div>

                        <div id="usaFields" style="display: none;">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="state" class="form-label">State Of Present Country *</label>
                                    <select id="state" name="state" class="form-select">
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="city" class="form-label">City Of Present State *</label>
                                    <select id="city" name="city" class="form-select">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="usaLandmark" class="form-label">Location / Landmark / Area *</label>
                                    <input type="text" id="usaLandmark" name="usaLandmark" class="form-control"
                                        placeholder="Enter landmark">
                                </div>
                            </div>
                        </div>
                    </div>


                    <h3 class="reg_form_head pb-2 pt-2 theme-text-color">Account Information</h3>
                    <div class="row">
                        <div class="col-md-12 pt-1 pb-2">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control"
                                placeholder="Enter Username" required>
                        </div>
                        <div class="col-md-12 pt-1 pb-2">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email"
                                required>
                        </div>
                        <div class="col-md-6 pt-1 pb-2">
                            <label for="user_phone" class="form-label">Candidate Phone Number*</label>
                            <div class="input-group">
                                <select class="form-select" id="candidate_country_code" name="candidate_country_code"
                                    style="max-width: 100px;">
                                    <option value="+1">+1 (USA)</option>
                                    <option value="+880">+880 (Bangladesh)</option>
                                    <!-- Add more country codes as needed -->
                                </select>
                                <input type="text" id="user_phone" name="user_phone" class="form-control"
                                    placeholder="Enter Candidate Phone Number" required>
                            </div>
                        </div>
                        <div class="col-md-6 pt-1 pb-2">
                            <label for="user_g_phone" class="form-label">Guardian Phone Number*</label>
                            <div class="input-group">
                                <select class="form-select" id="guardian_country_code" name="guardian_country_code"
                                    style="max-width: 100px;">
                                    <option value="+1">+1 (USA)</option>
                                    <option value="+880">+880 (Bangladesh)</option>
                                    <!-- Add more country codes as needed -->
                                </select>
                                <input type="text" id="user_g_phone" name="user_g_phone" class="form-control"
                                    placeholder="Enter Guardian Phone Number" required>
                            </div>
                        </div>
                        <div class="col-md-6 pt-1 pb-2">
                            <label for="password" class="form-label">Password*</label>
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Enter Password" required>
                        </div>
                        <div class="col-md-6 pt-1 pb-2">
                            <label for="repassword" class="form-label">Confirm Password*</label>
                            <input type="password" id="repassword" name="repassword" class="form-control"
                                placeholder="Re-type Password" required>
                        </div>
                        <div class="d-flex mt-4">
                            <input class="form-check-input me-2" type="checkbox" value="" id="invalidCheck" required>
                            <label class="form-check-label" for="invalidCheck">
                                Before registration read our <a href="#">Privacy Statement</a> and <a href="#">Terms &
                                    Conditions</a>
                            </label>
                        </div>
                        <div class="d-block mt-4 text-center">
                            <button type="submit" name="register" class="d-block button w-50 mx-auto"><strong>Register
                                    For Free</strong></button>
                        </div>
                    </div>
                </form>
                <!-- Or Sign Up Using Section -->
                <div class="text-center mt-4">
                    <span class="text-muted">Or already have account? <a href="<?php echo wp_login_url(); ?>">Sign
                            In</a></span>
                </div>

                <!-- Or Sign Up Using Section -->
                <div class="text-center mt-4">
                    <span class="text-muted">Or Sign Up Using</span>
                </div>

                <!-- Social Login Buttons -->
                <div class="row mt-3 justify-content-center">
                    <div class="col-auto text-center">
                        <a href="#" class="btn btn-circle btn-outline-danger">
                            <i class="bi bi-google"></i>
                        </a>
                    </div>
                    <div class="col-auto text-center">
                        <a href="#" class="btn btn-circle btn-outline-primary">
                            <i class="bi bi-facebook"></i>
                        </a>
                    </div>
                    <div class="col-auto text-center">
                        <a href="#" class="btn btn-circle btn-outline-primary">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>