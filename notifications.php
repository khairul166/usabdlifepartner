<?php
/* Template Name: Notifications */

get_header();

if (!is_user_logged_in()) {
    echo '<div class="container py-5"><h4>You must be logged in to view notifications.</h4></div>';
    get_footer();
    exit;
}

global $wpdb;
$current_user = get_current_user_id();
$notif_table = $wpdb->prefix . "notifications";

// Mark all as read
$wpdb->update($notif_table, ['read_status' => 1], ['user_id' => $current_user]);

// Fetch all notifications
$notifications = $wpdb->get_results("SELECT * FROM $notif_table WHERE user_id = $current_user ORDER BY created_at DESC");
?>

<div class="container py-5">
    <h3 class="mb-4">🔔 Your Notifications</h3>
    <ul class="list-group">
        <?php if ($notifications): ?>
            <?php foreach ($notifications as $notif): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?= esc_html($notif->message); ?></span>
                    <small class="text-muted"><?= date('M d, Y h:i A', strtotime($notif->created_at)); ?></small>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="list-group-item">You have no notifications yet.</li>
        <?php endif; ?>
    </ul>
</div>

<?php get_footer(); ?>
