<?php
require_once('wp-load.php'); // if this file is outside WordPress theme folder

global $wpdb;
$user_id = get_current_user_id();

$notifications = $wpdb->get_results("
    SELECT * FROM {$wpdb->prefix}notifications 
    WHERE user_id = $user_id 
    ORDER BY created_at DESC
");

// Mark as read
$wpdb->update(
    "{$wpdb->prefix}notifications",
    ['read_status' => 1],
    ['user_id' => $user_id]
);
?>

<h3>Your Notifications</h3>
<ul>
<?php foreach ($notifications as $note): ?>
    <li><?php echo esc_html($note->message); ?> - 
    <small><?php echo date('d M Y h:i A', strtotime($note->created_at)); ?></small></li>
<?php endforeach; ?>
</ul>
