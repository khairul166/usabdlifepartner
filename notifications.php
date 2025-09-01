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

// Pagination setup
$per_page = 20;
$paged = max(1, get_query_var('paged'));
$offset = ($paged - 1) * $per_page;

// Count total
$total_notifications = $wpdb->get_var("SELECT COUNT(*) FROM $notif_table WHERE user_id = $current_user");
$total_pages = ceil($total_notifications / $per_page);

// Fetch paginated notifications
$notifications = $wpdb->get_results($wpdb->prepare(
    "SELECT * FROM $notif_table WHERE user_id = %d ORDER BY created_at DESC LIMIT %d OFFSET %d",
    $current_user, $per_page, $offset
));
?>

<div class="container py-5">
    <h3 class="mb-4">🔔 Your Notifications</h3>
    <ul class="list-group">
        <?php if ($notifications): ?>
            <?php foreach ($notifications as $index => $notif):
                $delay = $index* 0.1; // Delay for staggered animation
                $human_time = human_time_diff(strtotime($notif->created_at), current_time('timestamp')) . ' ago'; ?>
                <li class="list-group-item border-bottom d-flex justify-content-between align-items-center animate__animated animate__fadeInUp" style="animation-delay: <?= esc_attr($delay); ?>s;">
                    <span><?= wp_kses_post($notif->message); ?></span>
                    <small class="text-muted"><?= esc_html($human_time); ?></small>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="list-group-item">You have no notifications yet.</li>
        <?php endif; ?>
    </ul>

    <!-- ✅ Bootstrap Pagination -->
    <?php
    $pagination_links = paginate_links(array(
        'base' => get_pagenum_link(1) . '%_%',
        'format' => 'page/%#%/',
        'current' => $paged,
        'total' => $total_pages,
        'prev_text' => '<i class="bi bi-chevron-left"></i>',
        'next_text' => '<i class="bi bi-chevron-right"></i>',
        'type' => 'array',
        'mid_size' => 2,
    ));
    ?>

    <?php if (!empty($pagination_links)): ?>
        <div class="paging">
            <ul class="mb-0 paginate text-center mt-4">
                <?php foreach ($pagination_links as $link): ?>
                    <?php
                    $link = str_replace('page-numbers', 'border d-block', $link);
                    $link = str_replace('current', 'border d-block active', $link);
                    ?>
                    <li class="d-inline-block mt-1 mb-1"><?= $link; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
