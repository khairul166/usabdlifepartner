<?php

function create_wp_profile_views_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'profile_views';
    
    // Check if table already exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        
        $charset_collate = $wpdb->get_charset_collate();

        // SQL to create table
        $sql = "CREATE TABLE $table_name (
            id INT(11) NOT NULL AUTO_INCREMENT,
            user_id INT(11) NOT NULL,
            profile_id INT(11) NOT NULL,
            view_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            plan_id INT(11) NOT NULL,  -- Store plan ID instead of membership_type
            PRIMARY KEY (id),
            FOREIGN KEY (user_id) REFERENCES {$wpdb->prefix}users(ID) ON DELETE CASCADE,
            FOREIGN KEY (profile_id) REFERENCES {$wpdb->prefix}users(ID) ON DELETE CASCADE,
            INDEX view_date (view_date)  -- Adding index to view_date for performance
        ) $charset_collate;";
        
        // Run the query to create table
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

// Hook to theme activation
add_action('after_switch_theme', 'create_wp_profile_views_table');


// Function to log profile view
function log_profile_view($user_id, $profile_id, $plan_id) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'profile_views';
    
    // Verify the table exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        error_log("Table $table_name does not exist");
        return false;
    }

    $result = $wpdb->insert(
        $table_name,
        array(
            'user_id' => $user_id,
            'profile_id' => $profile_id,
            'plan_id' => $plan_id
        ),
        array('%d', '%d', '%d') // Specify data types (integers)
    );

    if ($result === false) {
        error_log("DB Error: " . $wpdb->last_error);
        error_log("Query: " . $wpdb->last_query);
        return false;
    }
    
    return true;
}

function get_user_plan_id($profile_id) {
    global $wpdb;

    // Get the free plan ID from the option
    $free_plan_id = intval(get_option('usabdlp_default_package', 0));

    // Query to fetch the profile user's active plan ID
    $query = "
        SELECT m.membership_type
        FROM {$wpdb->prefix}memberships m
        WHERE m.user_id = %d AND m.status = 'active'
    ";
    $active_plan_id = $wpdb->get_var($wpdb->prepare($query, $profile_id));

    // If the profile user has no active plan or is on a free plan, return the free plan ID
    if ($active_plan_id == 0) {
        return $free_plan_id;
    }
    
    // If the profile user is on a premium plan, return the active plan ID
    return $active_plan_id;
}


function get_user_profile_views($user_id) {
    global $wpdb;

    // Get the free plan ID from the option
    $free_plan_id = intval(get_option('usabdlp_default_package', 0));

    // Query to count UNIQUE premium profile views by the user in the current month
    $query = "
        SELECT COUNT(DISTINCT profile_id) 
        FROM {$wpdb->prefix}profile_views
        WHERE user_id = %d
        AND MONTH(view_date) = MONTH(CURRENT_DATE)
        AND YEAR(view_date) = YEAR(CURRENT_DATE)
        AND plan_id != %d  -- Only count views of premium profiles (not free plan)
    ";

    return $wpdb->get_var($wpdb->prepare($query, $user_id, $free_plan_id));
}

add_action('wp', 'log_profile_view_on_page_load');

function log_profile_view_on_page_load() {
    global $wpdb;
    
    if (is_page('user-details')) { // Check if it's the user details page
        // Get the current logged-in user
        $user_id = get_current_user_id();
        
        // Get the profile ID from the URL
        $profile_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

        // Ensure the profile ID is valid
        if ($profile_id > 0) {
            // Get the active plan ID for the user whose profile is being viewed
            $plan_id = get_user_plan_id($profile_id); // Get the active plan ID for the profile being viewed

            // Call log_profile_view to log the profile view
            log_profile_view($user_id, $profile_id, $plan_id);
        }
    }
}
