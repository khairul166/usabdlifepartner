<?php

add_action('admin_menu', 'usabdlp_register_admin_dashboard');

function usabdlp_register_admin_dashboard() {
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
}


function usabdlp_render_dashboard_placeholder() {
    echo '<div class="wrap"><h1>Welcome to USABDL Dashboard</h1><p>Select a submenu like <strong>User Management</strong> to begin.</p></div>';
}


function usabdlp_render_user_management_page() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
    }

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
    $per_page = 10;
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
        echo '<thead><tr><th>Photo</th><th>Name</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th></tr></thead><tbody>';

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
            // Fetch the profile picture URL (assuming it's stored in user_meta)
$profile_picture = get_user_meta($user_id, 'user_avatar', true);

//If no profile picture is set, use a default placeholder
if (empty($profile_picture)) {
    $profile_picture = get_template_directory_uri() . '/image/avater.webp'; // Path to your default avatar
}

            $first_name = get_user_meta($user_id, 'first_name', true);
            $last_name = get_user_meta($user_id, 'last_name', true);
            $full_name = trim($first_name . ' ' . $last_name);
            if (!$full_name) $full_name = $user->display_name;
            $avatar_url = get_avatar_url($profile_picture, ['size' => 50]);

            $approve_url = wp_nonce_url(admin_url("admin.php?page=usabdlp-user-management&user_id={$user_id}&usabdlp_action=approve&filter_status={$selected_status}"), "usabdlp_approve_user_{$user_id}");
            $reject_url = wp_nonce_url(admin_url("admin.php?page=usabdlp-user-management&user_id={$user_id}&usabdlp_action=reject&filter_status={$selected_status}"), "usabdlp_reject_user_{$user_id}");
            $ban_url = wp_nonce_url(admin_url("admin.php?page=usabdlp-user-management&user_id={$user_id}&usabdlp_action=ban&filter_status={$selected_status}"), "usabdlp_ban_user_{$user_id}");

            echo "<tr>";
            echo "<td><img src='{$profile_picture}' width='50' height='50' style='border-radius:50%;' /></td>";
            echo "<td>{$full_name}</td>";
            echo "<td>{$username}</td>";
            echo "<td>{$email}</td>";
            echo "<td>{$role}</td>";
            echo "<td>" . ucfirst($status) . "</td>";
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