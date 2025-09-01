jQuery(document).ready(function($) {
    // All your code that uses $ will work here
    
    // Initialize Date Range Picker
    jQuery('#dateRangePicker').daterangepicker({
        opens: 'left',
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear',
            applyLabel: 'Apply',
            format: 'YYYY-MM-DD'
        }
    });

    // Handle date range selection
    jQuery('#dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
        jQuery(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        refreshDashboardData(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
    });

    // Initialize charts with default data
    initCharts(usabdlpDashboard.chart_data);
});

// Make sure all functions use jQuery instead of $
function refreshDashboardData(startDate, endDate) {
    jQuery('.usabdlp-dashboard').addClass('loading');
    
    jQuery.ajax({
        url: usabdlpDashboard.ajax_url,
        type: 'POST',
        data: {
            action: 'usabdlp_filter_dashboard',
            start_date: startDate,
            end_date: endDate,
            nonce: usabdlpDashboard.nonce
        },
        success: function(response) {
            if (response.success) {
                // Update stats
                jQuery('.stat-card:nth-child(1) .stat-value').text(response.data.total_users);
                jQuery('.stat-card:nth-child(2) .stat-value').text('$' + response.data.total_revenue.toLocaleString());
                jQuery('.stat-card:nth-child(3) .stat-value').text(response.data.premium_users);
                jQuery('.stat-card:nth-child(4) .stat-value').text(response.data.free_users);
                
                // Update charts
                updateCharts(response.data.chart_data);
            }
        },
        complete: function() {
            jQuery('.usabdlp-dashboard').removeClass('loading');
        }
    });
}

function initCharts(data) {
    window.usabdlpCharts = {
        revenue: createChart('totalRevenueChart', 'line', data.revenue, 'Total Revenue ($)'),
        premium: createChart('premiumUsersChart', 'bar', data.premium, 'Premium Users'),
        free: createChart('freeUsersChart', 'bar', data.free, 'Free Users')
    };
}

function updateCharts(data) {
    window.usabdlpCharts.revenue.data.labels = data.labels;
    window.usabdlpCharts.revenue.data.datasets[0].data = data.revenue;
    window.usabdlpCharts.premium.data.labels = data.labels;
    window.usabdlpCharts.premium.data.datasets[0].data = data.premium;
    window.usabdlpCharts.free.data.labels = data.labels;
    window.usabdlpCharts.free.data.datasets[0].data = data.free;
    
    window.usabdlpCharts.revenue.update();
    window.usabdlpCharts.premium.update();
    window.usabdlpCharts.free.update();
}

function createChart(elementId, type, data, label) {
    const ctx = document.getElementById(elementId).getContext('2d');
    return new Chart(ctx, {
        type: type,
        data: {
            labels: usabdlpDashboard.chart_data.labels,
            datasets: [{
                label: label,
                data: data,
                backgroundColor: getChartColor(elementId, 'background'),
                borderColor: getChartColor(elementId, 'border'),
                borderWidth: type === 'line' ? 2 : 1,
                tension: type === 'line' ? 0.4 : 0,
                fill: type === 'line'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}

function getChartColor(elementId, type) {
    const colors = {
        'totalRevenueChart': {
            background: 'rgba(75, 192, 192, 0.2)',
            border: 'rgba(75, 192, 192, 1)'
        },
        'premiumUsersChart': {
            background: '#4e73df',
            border: '#4e73df'
        },
        'freeUsersChart': {
            background: '#e53e3e',
            border: '#e53e3e'
        }
    };
    return colors[elementId][type];
}

function updateRecentUsers(users) {
    const $table = $('.registrations-table tbody');
    $table.empty();
    
    users.forEach(user => {
        $table.append(`
            <tr>
                <td class="username">${user.username}</td>
                <td class="time">${user.time_ago}</td>
            </tr>
        `);
    });
}

jQuery(document).ready(function($) {
    // Set default dates (current month)
    var start = moment().startOf('month');
    var end = moment().endOf('month');
    
    // Initialize date range picker
    $('#dateRangePicker').daterangepicker({
        startDate: start,
        endDate: end,
        opens: 'left',
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel: 'Clear',
            applyLabel: 'Apply'
        },
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });

    // Handle date selection
    $('#dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
        refreshDashboardData(
            picker.startDate.format('YYYY-MM-DD'),
            picker.endDate.format('YYYY-MM-DD')
        );
    });

    // Load initial data
    refreshDashboardData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
});