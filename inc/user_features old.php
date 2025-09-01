<?php
function usabdlp_get_user_features($user_id = null) {
    global $wpdb;
    if (!$user_id) {
        $user_id = get_current_user_id();
    }

    $membership = $wpdb->get_row("
        SELECT p.* FROM {$wpdb->prefix}memberships m
        JOIN {$wpdb->prefix}membership_plans p ON m.membership_type = p.id
        WHERE m.user_id = $user_id AND m.status = 'active'
        ORDER BY m.end_date DESC LIMIT 1
    ");

    return $membership;
}

$features = usabdlp_get_user_features();

if (!$features || !$features->can_view_contact) {
    echo "<p>You need to upgrade your plan to see contact details.</p>";
} else {
    // show contact info
}

if (!$features || !$features->can_send_interest) {
    echo "<p>Only premium members can send interests.</p>";
    return;
}

if (!$features || !$features->can_start_chat) {
    echo "<p>Upgrade your plan to chat with this user.</p>";
    return;
}

// function usabdlp_increment_profile_view($user_id, $profile_user_id) {
//     $current_month = date('Y-m');
//     $monthly_key = "usabdlp_views_{$current_month}";
//     $total_key = "usabdlp_total_views";

//     // Get current month's view count for the user
//     $monthly_views = get_user_meta($user_id, $monthly_key, true);
//     $monthly_views = $monthly_views ? intval($monthly_views) : 0;

//     // Get total profile views for the user across all months
//     $total_views = get_user_meta($user_id, $total_key, true);
//     $total_views = $total_views ? intval($total_views) : 0;

//     $features = usabdlp_get_user_features($user_id);
//     $saved_default_package = intval(get_option('usabdlp_default_package', 0));
//     $profile_features = usabdlp_get_user_features($profile_user_id);
//     $is_premium_profile = isset($profile_features->membership_type) && $profile_features->membership_type != $saved_default_package;

//     // Debugging logs
//     error_log("User {$user_id} - Monthly Views: {$monthly_views}, Total Views: {$total_views}");
    
//     if ($is_premium_profile) {
//         if ($monthly_views >= intval($features->premium_views)) {
//             return false; // Limit reached
//         }

//         // Log before updating user meta
//         error_log("User {$user_id} - Incrementing views: Monthly Views: " . ($monthly_views + 1) . ", Total Views: " . ($total_views + 1));
        
//         // Increment both total and monthly view counts
//         update_user_meta($user_id, $monthly_key, $monthly_views + 1);
//         update_user_meta($user_id, $total_key, $total_views + 1);

//         // Log after updating user meta
//         error_log("User {$user_id} - Updated views in DB: Monthly Views: " . ($monthly_views + 1) . ", Total Views: " . ($total_views + 1));
//     }

//     return true;
// }



// if (!usabdlp_increment_profile_view(get_current_user_id())) {
//     echo "<p>You’ve reached your monthly profile view limit.</p>";
//     return;
// }

// function usabdlp_get_profile_views($user_id) {
//     $current_month = date('Y-m'); // Get the current month
//     $key = "usabdlp_views_{$current_month}";
//     $views = get_user_meta($user_id, $key, true); // Get the views from user_meta
//     return $views ? intval($views) : 0; // Return the view count, or 0 if not set
// }


function usabdlp_increment_profile_view($user_id, $profile_user_id) {
    $current_month = date('Y-m');  // Get current month (YYYY-MM)
    $premium_key = "usabdlp_premium_views_{$current_month}";  // Meta key for premium views

    // Get the current month's premium view count (it should be 0 if not set)
    $monthly_premium_views = get_user_meta($user_id, $premium_key, true);
    $monthly_premium_views = $monthly_premium_views ? intval($monthly_premium_views) : 0;

    // Log to confirm if we're checking the meta key
    error_log("Checking premium views for user {$user_id}: {$monthly_premium_views}");

    // If the premium views key doesn't exist (first time), initialize it
    if ($monthly_premium_views === 0) {
        update_user_meta($user_id, $premium_key, 0);  // Initialize to 0 if it's the first time
        error_log("Initializing premium views meta key for user {$user_id}.");
    }

    // Check if the viewed profile is premium
    $profile_features = usabdlp_get_user_features($profile_user_id);
    $is_premium_profile = isset($profile_features->membership_type) && $profile_features->membership_type != get_option('usabdlp_default_package', 0);

    // If it's a premium profile, increment the premium view count for this month
    if ($is_premium_profile) {
        update_user_meta($user_id, $premium_key, $monthly_premium_views + 1);
        error_log("Incremented premium views for user {$user_id}. New count: " . ($monthly_premium_views + 1));
    }

    // Optional: Log to verify the view count
    error_log("User {$user_id} premium views this month: " . ($monthly_premium_views + 1));
}
