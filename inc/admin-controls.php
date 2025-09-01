<?php

add_action('admin_menu', 'usabdlp_register_admin_dashboard');

function usabdlp_register_admin_dashboard()
{
    add_menu_page(
        'USABDLifepartner Dashboard',
        'USABDL Dashboard',
        'manage_options',
        'usabdlp-dashboard',
        'usabdlp_render_dashboard_placeholder',
        'dashicons-admin-users',
        2
    );

    add_submenu_page(
        'usabdlp-dashboard',
        'User Management',
        'User Management',
        'manage_options',
        'usabdlp-user-management',
        'usabdlp_render_user_management_page'
    );
    add_submenu_page(
        'usabdlp-dashboard',
        'Membership Packages',
        'Membership Packages',
        'manage_options',
        'usabdlp-packages', // <-- THIS is the page slug
        'usabdlp_render_package_manager'
    );
    
}


function usabdlp_render_dashboard_placeholder() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized access.');
    }

    global $wpdb;

    // Total Users
    $total_users = $wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->prefix}users");

    // Get Free Plan ID
    $free_plan_id = $wpdb->get_var("SELECT id FROM {$wpdb->prefix}membership_plans WHERE name = 'Free'");

    // Total Revenue Calculation
    $total_revenue = 0;
    if ($free_plan_id) {
        $results = $wpdb->get_results("
            SELECT mp.price,
                   m.start_date,
                   m.end_date,
                   TIMESTAMPDIFF(MONTH, m.start_date, m.end_date) AS duration_months
            FROM {$wpdb->prefix}memberships m
            JOIN {$wpdb->prefix}membership_plans mp ON m.membership_type = mp.id
            WHERE m.status = 'active'
              AND m.end_date >= CURDATE()
              AND m.membership_type != $free_plan_id
        ");

        foreach ($results as $row) {
            $months = max(1, $row->duration_months); // minimum 1 month
            $subtotal = $row->price * $months;
            $tax = $subtotal * 0.05; // 5% tax
            $total_revenue += ($subtotal + $tax);
        }
    }

    // Premium Users Count (distinct active users with paid plans)
    $premium_users = 0;
    if ($free_plan_id) {
        $premium_users = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(DISTINCT user_id) FROM {$wpdb->prefix}memberships
             WHERE status = 'active'
               AND membership_type != %d
               AND end_date >= CURDATE()",
            $free_plan_id
        )) ?: 0;
    }

    // Free Users count
    $free_users = max(0, $total_users - $premium_users);

    // Recent Users (last 5)
    $recent_users = $wpdb->get_results("SELECT user_login, user_registered FROM {$wpdb->prefix}users ORDER BY user_registered DESC LIMIT 5");

    // Chart data example - you can update later with real data for date ranges
    $chart_data = [
        'labels' => [],
        'revenue' => [],
        'premium' => [],
        'free' => []
    ];
    for ($i = 5; $i >= 0; $i--) {
        $month = date('M', strtotime("-$i months"));
        $chart_data['labels'][] = $month;
        $chart_data['revenue'][] = rand(500, 2000);
        $chart_data['premium'][] = rand(10, 100);
        $chart_data['free'][] = rand(50, 200);
    }

    wp_localize_script('usabdlp-admin-script', 'usabdlpDashboard', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('usabdlp_dashboard_nonce'),
        'chart_data' => $chart_data
    ]);

    ?>
    <div class="usabdlp-dashboard">
        <h1>USABDL Dashboard</h1>

        <!-- Date Range Picker -->
        <div class="date-range-picker-container">
            <input type="text" id="dateRangePicker" placeholder="Select date range" />
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-title">Total Users</div>
                <div class="stat-value"><?php echo number_format($total_users); ?></div>
                <div class="stat-change negative">-3%</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Total Revenue</div>
                <div class="stat-value">$<?php echo number_format($total_revenue, 2); ?></div>
                <div class="stat-change positive">+10%</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Premium Users</div>
                <div class="stat-value"><?php echo number_format($premium_users); ?></div>
                <div class="stat-change positive">+10%</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Free Users</div>
                <div class="stat-value"><?php echo number_format($free_users); ?></div>
                <div class="stat-change negative">-10%</div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="charts-row">
            <div class="chart-container">
                <h3>Total Revenue</h3>
                <canvas id="totalRevenueChart"></canvas>
            </div>

            <div class="chart-container">
                <h3>Premium Users</h3>
                <canvas id="premiumUsersChart"></canvas>
            </div>
        </div>

        <!-- Second Row -->
        <div class="charts-row">
            <div class="chart-container">
                <h3>Free Users</h3>
                <canvas id="freeUsersChart"></canvas>
            </div>

            <div class="recent-users">
                <h3>Recent User Registrations</h3>
                <table class="registrations-table">
                    <tbody>
                        <?php foreach ($recent_users as $user): 
                            $time_ago = human_time_diff(strtotime($user->user_registered), current_time('timestamp'));
                        ?>
                        <tr>
                            <td class="username"><?php echo esc_html($user->user_login); ?></td>
                            <td class="time"><?php echo esc_html($time_ago . ' ago'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
}


add_action('wp_ajax_usabdlp_filter_dashboard', 'usabdlp_filter_dashboard_data');
function usabdlp_filter_dashboard_data() {
    check_ajax_referer('usabdlp_dashboard_nonce', 'nonce');

    global $wpdb;

   // $free_plan_id = $wpdb->get_var("SELECT id FROM {$wpdb->prefix}membership_plans WHERE name = 'Free Plan'");
    $free_plan_id = (get_option('usabdlp_default_package', 0));

    $start_date = !empty($_POST['start_date']) ? sanitize_text_field($_POST['start_date']) : date('Y-m-01');
    $end_date = !empty($_POST['end_date']) ? sanitize_text_field($_POST['end_date']) : date('Y-m-t');

    $mysql_start = date('Y-m-d 00:00:00', strtotime($start_date));
    $mysql_end = date('Y-m-d 23:59:59', strtotime($end_date));

    // 1. Total Users
    $total_users = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(ID) FROM {$wpdb->prefix}users
         WHERE user_registered BETWEEN %s AND %s",
         $mysql_start, $mysql_end
    )) ?: 0;

    // 2. Calculate total revenue dynamically
    $memberships = $wpdb->get_results($wpdb->prepare(
        "SELECT m.user_id, m.membership_type, m.start_date, m.end_date, mp.price
         FROM {$wpdb->prefix}memberships m
         JOIN {$wpdb->prefix}membership_plans mp ON m.membership_type = mp.id
         WHERE m.status = 'active'
           AND DATE(m.created_at) BETWEEN %s AND %s
           AND m.membership_type != %d",
        $mysql_start, $mysql_end, $free_plan_id
    ));

    $total_revenue = 0;

    foreach ($memberships as $membership) {
        $start = new DateTime($membership->start_date);
        $end = new DateTime($membership->end_date);

        // Calculate full months difference (including partial month rounding)
        $interval = $start->diff($end);
        $months = $interval->y * 12 + $interval->m;
        if ($interval->d > 0) {
            $months++; // count partial month as full
        }
        if ($months < 1) {
            $months = 1; // minimum 1 month revenue
        }

        $price = floatval($membership->price);
        $revenue_for_membership = $months * $price * 1.05; // +5% tax

        $total_revenue += $revenue_for_membership;
    }



    // 3. Premium users count
    $premium_users = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(DISTINCT user_id)
         FROM {$wpdb->prefix}memberships
         WHERE DATE(created_at) BETWEEN %s AND %s
           AND status = 'active'
           AND membership_type != %d",
        $mysql_start, $mysql_end, $free_plan_id
    )) ?: 0;

    $free_users = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(DISTINCT u.ID)
         FROM {$wpdb->prefix}users u
         LEFT JOIN {$wpdb->prefix}memberships m ON u.ID = m.user_id AND m.status = 'active'
         WHERE u.user_registered BETWEEN %s AND %s
         AND (m.id IS NULL OR m.membership_type = %d)",
        $mysql_start,
        $mysql_end,
        $free_plan_id
    )) ?: 0;

// 5. Recent Users (with enhanced data)
$recent_users = $wpdb->get_results($wpdb->prepare(
    "SELECT u.user_login, u.user_registered, u.user_email, 
            umf.meta_value as first_name, uml.meta_value as last_name
     FROM {$wpdb->prefix}users u
     LEFT JOIN {$wpdb->prefix}usermeta umf ON u.ID = umf.user_id AND umf.meta_key = 'first_name'
     LEFT JOIN {$wpdb->prefix}usermeta uml ON u.ID = uml.user_id AND uml.meta_key = 'last_name'
     WHERE u.user_registered BETWEEN %s AND %s
     ORDER BY u.user_registered DESC 
     LIMIT 5",
     $mysql_start, $mysql_end
));

$formatted_recent_users = [];
foreach ($recent_users as $user) {
    $formatted_recent_users[] = [
        'username' => $user->user_login,
        'email' => $user->user_email,
        'name' => trim($user->first_name . ' ' . $user->last_name),
        'time_ago' => human_time_diff(strtotime($user->user_registered), current_time('timestamp')) . ' ago',
        'registered_date' => date('M j, Y', strtotime($user->user_registered))
    ];
}

    // 6. Chart Data: daily data grouped by created_at for memberships and users
    $chart_data = [
        'labels' => [],
        'revenue' => [],
        'premium' => [],
        'free' => []
    ];

 // 5. Prepare daily chart data labels and revenue, premium, free counts
 $labels = [];
 $daily_revenue = [];
 $daily_premium = [];
 $daily_free = [];

 $period = new DatePeriod(
     new DateTime($start_date),
     new DateInterval('P1D'),
     (new DateTime($end_date))->modify('+1 day') // Include end day
 );

 foreach ($period as $date) {
     $day_start = $date->format('Y-m-d 00:00:00');
     $day_end = $date->format('Y-m-d 23:59:59');
     $labels[] = $date->format('M j');

     // Calculate revenue for memberships created that day
     $memberships = $wpdb->get_results($wpdb->prepare(
         "SELECT m.start_date, m.end_date, mp.price
          FROM {$wpdb->prefix}memberships m
          JOIN {$wpdb->prefix}membership_plans mp ON m.membership_type = mp.id
          WHERE m.status = 'active'
            AND DATE(m.created_at) = %s
            AND m.membership_type != %d",
         $date->format('Y-m-d'),
         $free_plan_id
     ));

     $day_revenue_total = 0;

     foreach ($memberships as $membership) {
         $start = new DateTime($membership->start_date);
         $end = new DateTime($membership->end_date);
         $interval = $start->diff($end);

         $months = $interval->y * 12 + $interval->m;
         if ($interval->d > 0) $months++;

         if ($months < 1) $months = 1;

         $day_revenue_total += $months * floatval($membership->price) * 1.05; // 5% tax
     }
     $daily_revenue[] = round($day_revenue_total, 2);

// Get the count of premium packages purchased on that specific day (using `created_at` for purchase date)
$premium_count = $wpdb->get_var($wpdb->prepare(
    "SELECT COUNT(DISTINCT user_id)
     FROM {$wpdb->prefix}memberships
     WHERE status = 'active'
       AND membership_type != %d
       AND created_at BETWEEN %s AND %s",
    $free_plan_id, // Exclude Free Plan by checking membership_type
    $day_start,    // Start of the day
    $day_end       // End of the day
)) ?: 0;

// Store the daily premium count
$daily_premium[] = intval($premium_count);


// Count free users registered that day without premium membership
$free_count = $wpdb->get_var($wpdb->prepare(
    "SELECT COUNT(DISTINCT u.ID)
     FROM {$wpdb->prefix}users u
     LEFT JOIN {$wpdb->prefix}memberships m ON u.ID = m.user_id AND m.status = 'active'
     WHERE u.user_registered BETWEEN %s AND %s
       AND (m.id IS NULL OR m.membership_type = %d)", // Exclude premium memberships and count only free users
    $day_start, // Start of the day
    $day_end,   // End of the day
    $free_plan_id // Free plan ID to filter out premium memberships
)) ?: 0;

$daily_free[] = intval($free_count);
 }

 $chart_data = [
     'labels' => $labels,
     'revenue' => $daily_revenue,
     'premium' => $daily_premium,
     'free' => $daily_free
 ];

 // Prepare response
 $response = [
     'success' => true,
     'data' => [
         'total_users' => intval($total_users),
         'total_revenue' => floatval($wpdb->get_var($wpdb->prepare(
             "SELECT SUM(mp.price * (TIMESTAMPDIFF(MONTH, m.start_date, m.end_date) + 1) * 1.05)
              FROM {$wpdb->prefix}memberships m
              JOIN {$wpdb->prefix}membership_plans mp ON m.membership_type = mp.id
              WHERE m.status = 'active'
              AND m.created_at BETWEEN %s AND %s
              AND m.membership_type != %d",
             $mysql_start,
             $mysql_end,
             $free_plan_id
         ))),
         'premium_users' => intval($premium_users),
         'free_users' => intval($free_users),
         'chart_data' => $chart_data,
         'recent_users' => $formatted_recent_users
     ]
 ];

 wp_send_json($response);
}




function usabdlp_render_user_management_page() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
    }

    global $wpdb;

    // Register the screen option to allow the user to change the number of items per page
    add_screen_option('per_page', [
        'default' => 10,
        'option'  => 'users_per_page',
    ]);

    // Handle Approve / Reject / Ban actions
    if (isset($_GET['usabdlp_action'], $_GET['user_id'], $_GET['_wpnonce'])) {
        $user_id = intval($_GET['user_id']);
        $action = sanitize_text_field($_GET['usabdlp_action']);

        if (in_array($action, ['approve', 'reject', 'ban']) && wp_verify_nonce($_GET['_wpnonce'], "usabdlp_{$action}_user_{$user_id}")) {
            $status_map = [
                'approve' => 'approved',
                'reject' => 'rejected',
                'ban' => 'banned'
            ];
            update_user_meta($user_id, 'approval_status', $status_map[$action]);
            echo '<div class="notice notice-success is-dismissible"><p>User has been ' . esc_html($status_map[$action]) . '.</p></div>';
        }
    }

    $statuses = ['all', 'pending', 'approved', 'rejected', 'banned'];
    $roles = ['all' => 'All Roles', 'subscriber' => 'Subscriber', 'editor' => 'Editor', 'author' => 'Author'];
    $selected_status = isset($_GET['filter_status']) ? sanitize_text_field($_GET['filter_status']) : 'all';
    $selected_role = isset($_GET['filter_role']) ? sanitize_text_field($_GET['filter_role']) : 'all';
    $search = isset($_GET['search_user']) ? sanitize_text_field($_GET['search_user']) : '';
    $paged = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    
    // Retrieve the number of items per page from the user's screen options
    $per_page = get_user_option('users_per_page', 10); // Default to 10 if not set

    // Ensure per_page is not zero
    if ($per_page <= 0) {
        $per_page = 10;  // Set a default value if it's zero or invalid
    }

    $offset = ($paged - 1) * $per_page;

    $query_args = [
        'number' => $per_page,
        'offset' => $offset,
        'search' => '*' . $search . '*',
        'search_columns' => ['user_login', 'user_email', 'display_name']
    ];

    if ($selected_role !== 'all') {
        $query_args['role'] = $selected_role;
    } else {
        $query_args['role__not_in'] = ['Administrator'];
    }

    if ($selected_status !== 'all') {
        $query_args['meta_query'] = [
            [
                'key' => 'approval_status',
                'value' => $selected_status,
                'compare' => '='
            ]
        ];
    }

    $users = get_users($query_args);
    $total_query = new WP_User_Query(array_merge($query_args, ['number' => -1]));
    $total_items = count($total_query->get_results());
    $total_pages = ceil($total_items / $per_page);

    // Count per status
    $status_counts = [];
    foreach (['pending', 'approved', 'rejected', 'banned'] as $status_key) {
        $status_counts[$status_key] = count(get_users([
            'role__not_in' => ['Administrator'],
            'meta_query' => [[
                'key' => 'approval_status',
                'value' => $status_key,
                'compare' => '='
            ]],
            'number' => -1
        ]));
    }

    echo '<div class="wrap">';
    echo '<h1>👥 All Users</h1>';

    echo '<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">';
    // Filter dropdowns
    echo '<form method="get" style="margin:0; display:flex; align-items:center; gap: 10px;">';
    echo '<input type="hidden" name="page" value="usabdlp-user-management" />';
    echo '<input type="hidden" name="search_user" value="' . esc_attr($search) . '" />';

    echo '<label for="filter_status">Status: </label>';
    echo '<select name="filter_status" id="filter_status">';
    foreach ($statuses as $status) {
        $selected = ($status === $selected_status) ? 'selected' : '';
        $count_label = ($status !== 'all' && isset($status_counts[$status])) ? " [{$status_counts[$status]}]" : '';
        echo "<option value='{$status}' {$selected}>" . ucfirst($status) . $count_label . "</option>";
    }
    echo '</select>';

    echo '<label for="filter_role">Role: </label>';
    echo '<select name="filter_role" id="filter_role">';
    foreach ($roles as $role_key => $role_label) {
        $selected = ($role_key === $selected_role) ? 'selected' : '';
        echo "<option value='{$role_key}' {$selected}>{$role_label}</option>";
    }
    echo '</select>';

    echo '<input type="submit" class="button" value="Filter" />';
    echo '<a href="' . admin_url('admin.php?page=usabdlp-user-management') . '" class="button">Clear Filter</a>';
    echo '</form>';

    // Search box
    echo '<form method="get" style="margin:0; display:flex; align-items:center;">';
    echo '<input type="hidden" name="page" value="usabdlp-user-management" />';
    echo '<input type="hidden" name="filter_status" value="' . esc_attr($selected_status) . '" />';
    echo '<input type="hidden" name="filter_role" value="' . esc_attr($selected_role) . '" />';
    echo '<input type="text" name="search_user" value="' . esc_attr($search) . '" placeholder="Search users..." style="margin-right: 8px;" />';
    echo '<input type="submit" class="button" value="Search" />';
    echo '</form>';
    echo '</div>';

    if (empty($users)) {
        echo '<p>No users found.</p>';
    } else {
        echo '<table class="widefat fixed striped">';
        echo '<thead><tr><th>Photo</th><th>Name</th><th>Username</th><th>Email</th><th>Status</th><th>Membership Plan</th><th>Actions</th></tr></thead><tbody>';

        foreach ($users as $user) {
            $user_id = $user->ID;
            $email = $user->user_email;
            $username = $user->user_login;
            $role = implode(', ', $user->roles);
            $status = get_user_meta($user_id, 'approval_status', true);
            if (!$status) {
                $status = 'pending';
                update_user_meta($user_id, 'approval_status', 'pending');
            }

            // Get user's active membership
            $membership = $wpdb->get_row($wpdb->prepare(
                "SELECT mp.name 
                 FROM {$wpdb->prefix}memberships m
                 JOIN {$wpdb->prefix}membership_plans mp ON m.membership_type = mp.id
                 WHERE m.user_id = %d AND m.status = 'active' AND m.end_date >= CURDATE()
                 ORDER BY m.end_date DESC
                 LIMIT 1",
                $user_id
            ));
            
            $membership_name = $membership ? $membership->name : 'Free';

            // Fetch the profile picture URL
            $profile_picture = get_user_meta($user_id, 'user_avatar', true);
            if (empty($profile_picture)) {
                $profile_picture = get_template_directory_uri() . '/image/avater.webp';
            }

            $first_name = get_user_meta($user_id, 'first_name', true);
            $last_name = get_user_meta($user_id, 'last_name', true);
            $full_name = trim($first_name . ' ' . $last_name);
            if (!$full_name) $full_name = $user->display_name;

            $approve_url = wp_nonce_url(admin_url("admin.php?page=usabdlp-user-management&user_id={$user_id}&usabdlp_action=approve&filter_status={$selected_status}"), "usabdlp_approve_user_{$user_id}");
            $reject_url = wp_nonce_url(admin_url("admin.php?page=usabdlp-user-management&user_id={$user_id}&usabdlp_action=reject&filter_status={$selected_status}"), "usabdlp_reject_user_{$user_id}");
            $ban_url = wp_nonce_url(admin_url("admin.php?page=usabdlp-user-management&user_id={$user_id}&usabdlp_action=ban&filter_status={$selected_status}"), "usabdlp_ban_user_{$user_id}");

            echo "<tr>";
            echo '<td><img src="' . esc_url($profile_picture) . '" width="50" height="50" style="border-radius:50%;" /></td>';
            echo '<td>' . esc_html($full_name) . '</td>';
            echo '<td>' . esc_html($username) . '</td>';
            echo '<td>' . esc_html($email) . '</td>';
            // echo '<td>' . esc_html($role) . '</td>';
            echo '<td>' . esc_html(ucfirst($status)) . '</td>';
            echo '<td>' . esc_html($membership_name) . '</td>';
            echo "<td>";

            if ($status === 'pending') {
                echo "<a href='{$approve_url}' class='button button-primary'>✅ Approve</a> ";
                echo "<a href='{$reject_url}' class='button'>❌ Reject</a> ";
                echo "<a href='{$ban_url}' class='button' style='color:red;'>🚫 Ban</a>";
            } elseif ($status === 'approved') {
                echo "<a href='{$ban_url}' class='button' style='color:red;'>🚫 Ban</a>";
            } else {
                echo "<em>No actions</em>";
            }

            echo "</td></tr>";
        }
        echo '</tbody></table>';

        if ($total_pages > 1) {
            echo '<div style="display:flex; justify-content:flex-end; align-items:center; margin-top: 15px; gap:10px;">';
            $base_url = admin_url('admin.php?page=usabdlp-user-management&filter_status=' . $selected_status . '&filter_role=' . $selected_role . '&search_user=' . urlencode($search));
            echo "<span>{$total_items} items</span>";
            if ($paged > 1) {
                echo '<a class="button" href="' . esc_url($base_url . '&paged=1') . '">&laquo;</a>';
                echo '<a class="button" href="' . esc_url($base_url . '&paged=' . ($paged - 1)) . '">&lsaquo;</a>';
            } else {
                echo '<span class="button disabled">&laquo;</span>';
                echo '<span class="button disabled">&lsaquo;</span>';
            }
            echo "<span>{$paged} of {$total_pages}</span>";
            if ($paged < $total_pages) {
                echo '<a class="button" href="' . esc_url($base_url . '&paged=' . ($paged + 1)) . '">&rsaquo;</a>';
                echo '<a class="button" href="' . esc_url($base_url . '&paged=' . $total_pages) . '">&raquo;</a>';
            } else {
                echo '<span class="button disabled">&rsaquo;</span>';
                echo '<span class="button disabled">&raquo;</span>';
            }
            echo '</div>';
        }
    }
    echo '</div>';
}


function usabdlp_render_package_manager()
{
    global $wpdb;
    $table = $wpdb->prefix . 'membership_plans';

    // Handle Delete
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $wpdb->delete($table, ['id' => intval($_GET['id'])]);
        echo '<div class="notice notice-success is-dismissible"><p>Package deleted successfully.</p></div>';
    }

    // Handle Insert or Update Plan
    if (isset($_POST['submit_plan'])) {
        $data = [
            'name' => sanitize_text_field($_POST['plan_name']),
            'price' => floatval($_POST['plan_price']),
            'duration_days' => intval($_POST['plan_duration']),
            'premium_views' => isset($_POST['enable_premium_views']) ? 1 : 0,
            'can_view_contact' => isset($_POST['can_view_contact']) ? 1 : 0,
            'can_send_interest' => isset($_POST['can_send_interest']) ? 1 : 0,
            'can_start_chat' => isset($_POST['can_start_chat']) ? 1 : 0,
            'can_view_profiles' => isset($_POST['can_view_profiles']) ? 1 : 0,
            'can_shortlist' => isset($_POST['can_shortlist']) ? 1 : 0,
        ];

        if (isset($_POST['plan_id']) && !empty($_POST['plan_id'])) {
            $wpdb->update($table, $data, ['id' => intval($_POST['plan_id'])]);
            echo '<div class="notice notice-success is-dismissible"><p>Package updated successfully.</p></div>';
        } else {
            $wpdb->insert($table, $data);
            echo '<div class="notice notice-success is-dismissible"><p>Package added successfully.</p></div>';
        }
    }

    // Handle Save Default Package (General Settings Tab)
    if (isset($_POST['save_default_package'])) {
        $default_package = intval($_POST['default_package']);
        update_option('usabdlp_default_package', $default_package);
        echo '<div class="notice notice-success is-dismissible"><p>Default package updated successfully.</p></div>';
    }

    // Check if editing a plan
    $edit_plan = null;
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
        $edit_plan = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", intval($_GET['id'])));
    }

    // Get all plans
    $plans = $wpdb->get_results("SELECT * FROM $table ORDER BY id DESC");

    // Get saved default package ID
    $saved_default_package = intval(get_option('usabdlp_default_package', 0));

    // Current tab
    $tab = isset($_GET['tab']) ? $_GET['tab'] : 'general-settings';
    ?>

    <div class="wrap">
        <h1>Membership Package Manager</h1>

        <h2 class="nav-tab-wrapper">
            <a href="?page=usabdlp-packages&tab=general-settings" class="nav-tab <?php echo ($tab === 'general-settings') ? 'nav-tab-active' : ''; ?>">General Settings</a>
            <a href="?page=usabdlp-packages&tab=plans" class="nav-tab <?php echo ($tab === 'plans') ? 'nav-tab-active' : ''; ?>">Plans</a>
            <a href="?page=usabdlp-packages&tab=add-plan" class="nav-tab <?php echo ($tab === 'add-plan') ? 'nav-tab-active' : ''; ?>">Add Plan</a>
            <a href="?page=usabdlp-packages&tab=payment-settings" class="nav-tab <?php echo ($tab === 'payment-settings') ? 'nav-tab-active' : ''; ?>">Payment Settings</a>
        </h2>

        <div id="tab-content">
            <?php
            switch ($tab) {
                case 'plans':
                    ?>
                    <h3>All Membership Plans</h3>
                    <table class="widefat fixed striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Duration</th>
                                <th>Features</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($plans as $plan): ?>
                                <tr>
                                    <td><?php echo esc_html($plan->id); ?></td>
                                    <td><?php echo esc_html($plan->name); ?></td>
                                    <td>$<?php echo esc_html($plan->price); ?></td>
                                    <td><?php echo esc_html($plan->duration_days); ?> days</td>
                                    <td>
                                        <ul style="margin-left: 16px;">
                                            <li><?php echo $plan->premium_views > 0 ? '✔️ ' . esc_html($plan->premium_views) . ' Premium Profile Views/mo' : '❌ Premium Profile Views'; ?></li>
                                            <li><?php echo $plan->can_view_profiles ? '✔️ View Profiles' : '❌ View Profiles'; ?></li>
                                            <li><?php echo $plan->can_view_contact ? '✔️ View Contact' : '❌ View Contact'; ?></li>
                                            <li><?php echo $plan->can_send_interest ? '✔️ Send Interest' : '❌ Send Interest'; ?></li>
                                            <li><?php echo $plan->can_start_chat ? '✔️ Start Chat' : '❌ Start Chat'; ?></li>
                                            <li><?php echo $plan->can_shortlist ? '✔️ Shortlist' : '❌ Shortlist'; ?></li>
                                        </ul>
                                    </td>
                                    <td>
                                        <a href="?page=usabdlp-packages&tab=add-plan&action=edit&id=<?php echo $plan->id; ?>" class="button">Edit</a>
                                        <a href="?page=usabdlp-packages&tab=plans&action=delete&id=<?php echo $plan->id; ?>" class="button button-danger" onclick="return confirm('Are you sure you want to delete this package?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                    break;

                case 'add-plan':
                    ?>
                    <h3><?php echo $edit_plan ? 'Edit Plan' : 'Add New Plan'; ?></h3>
                    <form method="post" action="?page=usabdlp-packages&tab=add-plan">
                        <?php if ($edit_plan): ?>
                            <input type="hidden" name="plan_id" value="<?php echo esc_attr($edit_plan->id); ?>">
                        <?php endif; ?>
                        <table class="form-table">
                            <tr>
                                <th>Name</th>
                                <td><input type="text" name="plan_name" value="<?php echo esc_attr($edit_plan->name ?? ''); ?>" required></td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td><input type="number" step="0.01" name="plan_price" value="<?php echo esc_attr($edit_plan->price ?? ''); ?>" required></td>
                            </tr>
                            <tr>
                                <th>Duration (Days)</th>
                                <td><input type="number" name="plan_duration" value="<?php echo esc_attr($edit_plan->duration_days ?? ''); ?>" required></td>
                            </tr>
                            <tr>
                                <th>Allow Premium Profile Views</th>
                                <td><input type="checkbox" name="enable_premium_views" value="1" <?php checked($edit_plan->premium_views ?? 0, 1); ?>></td>
                            </tr>
                            <tr>
                                <th>Allow Contact View</th>
                                <td><input type="checkbox" name="can_view_contact" value="1" <?php checked($edit_plan->can_view_contact ?? 0, 1); ?>></td>
                            </tr>
                            <tr>
                                <th>Allow Send Interest</th>
                                <td><input type="checkbox" name="can_send_interest" value="1" <?php checked($edit_plan->can_send_interest ?? 0, 1); ?>></td>
                            </tr>
                            <tr>
                                <th>Allow Start Chat</th>
                                <td><input type="checkbox" name="can_start_chat" value="1" <?php checked($edit_plan->can_start_chat ?? 0, 1); ?>></td>
                            </tr>
                            <tr>
                                <th>Can View Profiles</th>
                                <td><input type="checkbox" name="can_view_profiles" value="1" <?php checked($edit_plan->can_view_profiles ?? 1, 1); ?>></td>
                            </tr>
                            <tr>
                                <th>Can Shortlist</th>
                                <td><input type="checkbox" name="can_shortlist" value="1" <?php checked($edit_plan->shortlist ?? 1, 1); ?>></td>
                            </tr>
                        </table>
                        <p><input type="submit" name="submit_plan" class="button button-primary" value="<?php echo $edit_plan ? 'Update Package' : 'Add Package'; ?>"></p>
                    </form>
                    <?php
                    break;

                    case 'payment-settings':
                        if (isset($_POST['save_payment_settings'])) {
                            update_option('usabdlp_payment_client_secret', sanitize_text_field($_POST['payment_client_secret']));
                            update_option('usabdlp_tax_percent', floatval($_POST['tax_percent']));
                            update_option('usabdlp_tax_inclusive', isset($_POST['tax_inclusive']) ? 1 : 0);
                            update_option('usabdlp_prorate_upgrades', isset($_POST['prorate_upgrades']) ? 1 : 0);
                            update_option('enable_payment', isset($_POST['enable_payment']) ? 1 : 0);
                            update_option('usabdlp_currency_code', sanitize_text_field($_POST['currency_code']));
                            
                            echo '<div class="notice notice-success is-dismissible"><p>Payment settings updated successfully.</p></div>';
                        }
                    
                        $saved_client_secret = get_option('usabdlp_payment_client_secret', '');
                        $saved_tax_percent = floatval(get_option('usabdlp_tax_percent', 5));
                        $saved_tax_inclusive = intval(get_option('usabdlp_tax_inclusive', 0));
                        $saved_prorate_upgrades = intval(get_option('usabdlp_prorate_upgrades', 1));
                        $enable_payment = intval(get_option('enable_payment', 1));
                        $saved_currency_code = get_option('usabdlp_currency_code', 'USD');
                        ?>
                    
                        <h3>Payment Settings</h3>
                    
                        <form method="post" action="?page=usabdlp-packages&tab=payment-settings">
                            <table class="form-table">
                            <tr>
                                    <th><label for="enable_payment">Enable Payment</label></th>
                                    <td><input type="checkbox" name="enable_payment" id="enable_payment" value="1" <?php checked($enable_payment, 1); ?> /></td>
                                </tr>
                                <tr>
                                    <th><label for="payment_client_secret">Payment Gateway Client Secret Key</label></th>
                                    <td><input type="text" id="payment_client_secret" name="payment_client_secret" value="<?php echo esc_attr($saved_client_secret); ?>" class="regular-text" required></td>
                                </tr>
                                <tr>
                                    <th><label for="currency_code">Currency Code</label></th>
                                    <td>
                                        <select name="currency_code" id="currency_code">
                                            <option value="USD" <?php selected($saved_currency_code, 'USD'); ?>>USD ($)</option>
                                            <option value="BDT" <?php selected($saved_currency_code, 'BDT'); ?>>BDT (৳)</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="tax_percent">Tax Percentage (%)</label></th>
                                    <td><input type="number" step="0.01" min="0" max="100" name="tax_percent" id="tax_percent" value="<?php echo esc_attr($saved_tax_percent); ?>" required></td>
                                </tr>
                                <tr>
                                    <th><label for="tax_inclusive">Tax Inclusive Pricing?</label></th>
                                    <td><input type="checkbox" name="tax_inclusive" id="tax_inclusive" value="1" <?php checked($saved_tax_inclusive, 1); ?> /> Prices include tax</td>
                                </tr>
                                <tr>
                                    <th><label for="prorate_upgrades">Pro-rate Upgrades</label></th>
                                    <td><input type="checkbox" name="prorate_upgrades" id="prorate_upgrades" value="1" <?php checked($saved_prorate_upgrades, 1); ?> /> Calculate charges on pro-rata basis</td>
                                </tr>
                            </table>
                            <p><input type="submit" name="save_payment_settings" class="button button-primary" value="Save Settings"></p>
                        </form>
                    
                    <?php
                    break;
                    
                    

                    case 'general-settings':
                        default:
                            // Handle form submission
                            if (isset($_POST['save_general_settings'])) {
                                check_admin_referer('usabdlp_general_settings_nonce');
                                update_option('usabdlp_default_package', intval($_POST['default_package']));
                                update_option('usabdlp_payment_success_page', intval($_POST['payment_success_page']));
                                update_option('usabdlp_payment_cancel_page', intval($_POST['payment_cancel_page']));
                                update_option('usabdlp_update_success_page', intval($_POST['update_success_page']));
                                update_option('usabdlp_update_cancel_page', intval($_POST['update_cancel_page']));
                                update_option('usabdlp_default_duration_days', max(0, intval($_POST['default_duration_days'])));
                                update_option('usabdlp_grace_period_days', max(0, intval($_POST['grace_period_days'])));
                                update_option('usabdlp_expiry_reminder_days', max(1, intval($_POST['expiry_reminder_days']))); // NEW!
                                update_option('usabdlp_default_role', sanitize_text_field($_POST['default_role']));
                                
                                echo '<div class="notice notice-success is-dismissible"><p>General settings updated successfully.</p></div>';
                            }
                        
                            // Load saved options
                            $saved_default_package = intval(get_option('usabdlp_default_package', 0));
                            $saved_payment_success_page = intval(get_option('usabdlp_payment_success_page', 0));
                            $saved_payment_cancel_page = intval(get_option('usabdlp_payment_cancel_page', 0));
                            $saved_update_success_page = intval(get_option('usabdlp_update_success_page', 0));
                            $saved_update_cancel_page = intval(get_option('usabdlp_update_cancel_page', 0));
                            $saved_default_duration_days = intval(get_option('usabdlp_default_duration_days', 30));
                            $saved_grace_period_days = intval(get_option('usabdlp_grace_period_days', 7));
                            $saved_expiry_reminder_days = intval(get_option('usabdlp_expiry_reminder_days', 7)); // NEW!
                            $saved_default_role = get_option('usabdlp_default_role', 'subscriber');
                            $pages = get_pages(['post_status' => 'publish']);
                            $roles = get_editable_roles();
                            ?>
                        
                            <h3>General Membership Settings</h3>
                        
                            <form method="post" action="?page=usabdlp-packages&tab=general-settings">
                                <table class="form-table">
                                    <!-- Default Package Dropdown -->
                                    <tr>
                                        <th><label for="default_package">Default Package After Expiry</label></th>
                                        <td>
                                            <select name="default_package" id="default_package">
                                                <option value="0">-- Select Default Package --</option>
                                                <?php foreach ($plans as $plan): ?>
                                                    <option value="<?php echo esc_attr($plan->id); ?>" <?php selected($saved_default_package, $plan->id); ?>>
                                                        <?php echo esc_html($plan->name . ' ($' . $plan->price . ')'); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <p class="description">Package assigned automatically after paid membership expires.</p>
                                        </td>
                                    </tr>
                        
                                    <!-- Pages Dropdowns -->
                                    <tr>
                                        <th><label for="payment_success_page">Payment Success Page</label></th>
                                        <td>
                                            <select name="payment_success_page" id="payment_success_page">
                                                <option value="0">-- Select Page --</option>
                                                <?php foreach ($pages as $page): ?>
                                                    <option value="<?php echo esc_attr($page->ID); ?>" <?php selected($saved_payment_success_page, $page->ID); ?>>
                                                        <?php echo esc_html($page->post_title); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label for="payment_cancel_page">Payment Cancel Page</label></th>
                                        <td>
                                            <select name="payment_cancel_page" id="payment_cancel_page">
                                                <option value="0">-- Select Page --</option>
                                                <?php foreach ($pages as $page): ?>
                                                    <option value="<?php echo esc_attr($page->ID); ?>" <?php selected($saved_payment_cancel_page, $page->ID); ?>>
                                                        <?php echo esc_html($page->post_title); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label for="update_success_page">Update Success Page</label></th>
                                        <td>
                                            <select name="update_success_page" id="update_success_page">
                                                <option value="0">-- Select Page --</option>
                                                <?php foreach ($pages as $page): ?>
                                                    <option value="<?php echo esc_attr($page->ID); ?>" <?php selected($saved_update_success_page, $page->ID); ?>>
                                                        <?php echo esc_html($page->post_title); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label for="update_cancel_page">Update Cancel Page</label></th>
                                        <td>
                                            <select name="update_cancel_page" id="update_cancel_page">
                                                <option value="0">-- Select Page --</option>
                                                <?php foreach ($pages as $page): ?>
                                                    <option value="<?php echo esc_attr($page->ID); ?>" <?php selected($saved_update_cancel_page, $page->ID); ?>>
                                                        <?php echo esc_html($page->post_title); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                        
                                    <!-- Default Membership Duration -->
                                    <tr>
                                        <th><label for="default_duration_days">Default Membership Duration After Expiry (days)</label></th>
                                        <td>
                                            <input type="number" min="0" id="default_duration_days" name="default_duration_days" value="<?php echo esc_attr($saved_default_duration_days); ?>" />
                                            <p class="description">Duration for default package after expiry.</p>
                                        </td>
                                    </tr>
                        
                                    <!-- Grace Period -->
                                    <tr>
                                        <th><label for="grace_period_days">Grace Period After Expiry (days)</label></th>
                                        <td>
                                            <input type="number" min="0" id="grace_period_days" name="grace_period_days" value="<?php echo esc_attr($saved_grace_period_days); ?>" />
                                            <p class="description">Buffer period before membership downgrade.</p>
                                        </td>
                                    </tr>
                        
                                    <!-- Expiry Reminder Days -->
                                    <tr>
                                        <th><label for="expiry_reminder_days">Expiry Reminder Days</label></th>
                                        <td>
                                            <input type="number" min="1" max="30" id="expiry_reminder_days" name="expiry_reminder_days" value="<?php echo esc_attr($saved_expiry_reminder_days); ?>" />
                                            <p class="description">Send reminder email X days before membership expiry.</p>
                                        </td>
                                    </tr>
                        
                                    <!-- Default Role Assignment -->
                                    <tr>
                                        <th><label for="default_role">Default User Role After Expiry</label></th>
                                        <td>
                                            <select name="default_role" id="default_role">
                                                <?php foreach ($roles as $role_key => $role): ?>
                                                    <option value="<?php echo esc_attr($role_key); ?>" <?php selected($saved_default_role, $role_key); ?>>
                                                        <?php echo esc_html($role['name']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <p class="description">WP user role assigned after expiry and downgrade.</p>
                                        </td>
                                    </tr>
                                </table>
                        
                                <p><input type="submit" name="save_general_settings" class="button button-primary" value="Save Settings"></p>
                            </form>
                        
                        <?php
                        break;
                                                                     
            }
            ?>
        </div>
    </div>

<?php
}





// Register the admin menu page
add_action('admin_menu', function() {
    add_submenu_page(
        'usabdlp-dashboard',
        'Email Templates',
        'Email Templates',
        'manage_options',
        'usabdlp-email-templates',
        'usabdlp_render_email_templates_page'
    );
});

function usabdlp_render_email_templates_page() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized user');
    }

    // Enqueue WP editor scripts/styles
    wp_enqueue_editor();

    // Handle form submission
    if (isset($_POST['save_email_templates'])) {
        check_admin_referer('usabdlp_email_templates_nonce');

        update_option('usabdlp_email_template_payment_success', wp_kses_post($_POST['payment_success_email']));
        update_option('usabdlp_email_template_upgrade_success', wp_kses_post($_POST['upgrade_success_email']));
        update_option('usabdlp_email_template_expiry_notice', wp_kses_post($_POST['expiry_warning_email']));

        echo '<div class="updated notice is-dismissible"><p>Email templates saved successfully.</p></div>';
    }

    // Get saved templates or set defaults
    $payment_success_email = get_option('usabdlp_email_template_payment_success', "Hello {user},<br>Your payment for the {plan} plan was successful. Your membership is valid until {expiry_date}.");
    $upgrade_success_email = get_option('usabdlp_email_template_upgrade_success', "Hello {user},<br>Your membership has been upgraded to {plan}. Valid until {expiry_date}.");
    $expiry_warning_email = get_option('usabdlp_email_template_expiry_notice', "Dear {user},<br>Your membership {plan} will expire on {expiry_date}. Please renew to continue enjoying benefits.");

    ?>
    <div class="wrap">
        <h1>Email Templates</h1>
        <form method="post" action="">
            <?php wp_nonce_field('usabdlp_email_templates_nonce'); ?>

            <h2>Payment Success Email Template</h2>
            <?php
            wp_editor(
                $payment_success_email,
                'payment_success_email',
                [
                    'textarea_name' => 'payment_success_email',
                    'textarea_rows' => 10,
                    'media_buttons' => false,
                    'teeny' => true,
                    'quicktags' => true,
                ]
            );
            ?>
            <p class="description">Email sent on successful payment. Use <code>{user}</code>, <code>{plan}</code>, <code>{expiry_date}</code> placeholders.</p>

            <h2>Upgrade Success Email Template</h2>
            <?php
            wp_editor(
                $upgrade_success_email,
                'upgrade_success_email',
                [
                    'textarea_name' => 'upgrade_success_email',
                    'textarea_rows' => 10,
                    'media_buttons' => false,
                    'teeny' => true,
                    'quicktags' => true,
                ]
            );
            ?>
            <p class="description">Email sent after successful upgrade. Use <code>{user}</code>, <code>{plan}</code>, <code>{expiry_date}</code> placeholders.</p>

            <h2>Membership Expiry Notice Email Template</h2>
            <?php
            wp_editor(
                $expiry_warning_email,
                'expiry_warning_email',
                [
                    'textarea_name' => 'expiry_warning_email',
                    'textarea_rows' => 10,
                    'media_buttons' => false,
                    'teeny' => true,
                    'quicktags' => true,
                ]
            );
            ?>
            <p class="description">Email sent before membership expires. Use <code>{user}</code>, <code>{plan}</code>, <code>{expiry_date}</code> placeholders.</p>

            <p><input type="submit" name="save_email_templates" class="button button-primary" value="Save Templates"></p>
        </form>
    </div>
    <?php
}
