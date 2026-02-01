// Book Store Admin Dashboard - Main JavaScript File
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    // ======================
    // SIDEBAR TOGGLE
    // ======================
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('active');
        });
    }

    // Close sidebar on mobile when clicking a menu item
    const menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(item => {
        item.addEventListener('click', function () {
            if (window.innerWidth < 768) {
                sidebar.classList.remove('active');
            }
        });
    });

    // ======================
    // PAGE NAVIGATION (for single-page layout compatibility)
    // ======================
    // const contentSections = document.querySelectorAll('.content-section');
    // const pageTitle = document.getElementById('pageTitle');

    // menuItems.forEach(item => {
    //     item.addEventListener('click', function (e) {
    //         e.preventDefault();
    //         const pageName = this.getAttribute('data-page');

    //         // Update active menu
    //         menuItems.forEach(mi => mi.classList.remove('active'));
    //         this.classList.add('active');

    //         // Show selected page
    //         contentSections.forEach(section => {
    //             section.classList.add('page-hidden');
    //         });
    //         const targetPage = document.getElementById(`page-${pageName}`);
    //         if (targetPage) {
    //             targetPage.classList.remove('page-hidden');
    //         }

    //         // Update page title
    //         if (pageTitle && this.textContent) {
    //             pageTitle.textContent = this.textContent.trim();
    //         }
    //     });
    // });

    // ======================
    // USER SEARCH & FILTER
    // ======================
    const searchUsers = document.getElementById('searchUsers');
    const filterVerified = document.getElementById('filterVerified');
    const filterActive = document.getElementById('filterActive');

    if (searchUsers) {
        searchUsers.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#usersTableBody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    if (filterVerified || filterActive) {
        const applyFilters = function () {
            const verifiedValue = filterVerified ? filterVerified.value : '';
            const activeValue = filterActive ? filterActive.value : '';
            const rows = document.querySelectorAll('#usersTableBody tr');
            rows.forEach(row => {
                let show = true;
                const cells = row.cells;

                // Verified filter
                if (verifiedValue && cells[4]) {
                    const isVerified = cells[4].textContent.includes('Verified');
                    show = show && (
                        (verifiedValue === '1' && isVerified) ||
                        (verifiedValue === '0' && !isVerified)
                    );
                }

                // Active status filter
                if (activeValue && cells[5]) {
                    const isActive = cells[5].textContent.includes('Active');
                    show = show && (
                        (activeValue === '1' && isActive) ||
                        (activeValue === '0' && !isActive)
                    );
                }

                row.style.display = show ? '' : 'none';
            });
        };

        if (filterVerified) filterVerified.addEventListener('change', applyFilters);
        if (filterActive) filterActive.addEventListener('change', applyFilters);
    }

    // ======================
    // DASHBOARD CHARTS
    // ======================
    const chartDataEl = document.getElementById('chartData');
    if (chartDataEl) {
        const salesDataRaw = JSON.parse(chartDataEl.dataset.sales || '{}');
        const orderStatusRaw = JSON.parse(chartDataEl.dataset.orderStatus || '{}');
        const topBooksRaw = JSON.parse(chartDataEl.dataset.topBooks || '{}');
        const topCategoriesRaw = JSON.parse(chartDataEl.dataset.topCategories || '{}');

        // Sales Chart
        const salesChartEl = document.getElementById('salesChart');
        if (salesChartEl) {
            const salesCtx = salesChartEl.getContext('2d');
            const labels = Object.keys(salesDataRaw);
            const values = Object.values(salesDataRaw);

            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: labels.length ? labels : ['No Data'],
                    datasets: [{
                        label: 'Sales Revenue ($)',
                        data: values.length ? values : [0],
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: true, position: 'top' }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        // Order Status Chart
        const orderStatusChartEl = document.getElementById('orderStatusChart');
        if (orderStatusChartEl) {
            const orderStatusCtx = orderStatusChartEl.getContext('2d');
            new Chart(orderStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(orderStatusRaw),
                    datasets: [{
                        data: Object.values(orderStatusRaw),
                        backgroundColor: ['#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }

        // Top Books Chart
        const topBooksChartEl = document.getElementById('topBooksChart');
        if (topBooksChartEl) {
            const topBooksCtx = topBooksChartEl.getContext('2d');
            new Chart(topBooksCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(topBooksRaw),
                    datasets: [{
                        label: 'Units Sold',
                        data: Object.values(topBooksRaw),
                        backgroundColor: '#4e73df'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        // Top Categories Chart
        const topCategoriesChartEl = document.getElementById('topCategoriesChart');
        if (topCategoriesChartEl) {
            const topCategoriesCtx = topCategoriesChartEl.getContext('2d');
            new Chart(topCategoriesCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(topCategoriesRaw),
                    datasets: [{
                        label: 'Books Count',
                        data: Object.values(topCategoriesRaw),
                        backgroundColor: '#1cc88a'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: { legend: { display: false } },
                    scales: { x: { beginAtZero: true } }
                }
            });
        }
    }

    // ======================
    // ACTION BUTTON HANDLERS (Optional logging or future AJAX)
    // ======================
    document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const icon = this.querySelector('i');
            let action = '';

            if (icon.classList.contains('fa-eye')) action = 'View';
            else if (icon.classList.contains('fa-edit')) action = 'Edit';
            else if (icon.classList.contains('fa-trash')) action = 'Delete';
            else if (icon.classList.contains('fa-ban')) action = 'Block';
            else if (icon.classList.contains('fa-check')) action = 'Approve';
            else if (icon.classList.contains('fa-print')) action = 'Print';
            else if (icon.classList.contains('fa-history')) action = 'History';

            console.log(`${action} action triggered`);
            // TODO: Replace with actual AJAX calls or modal triggers
        });
    });

    // ======================
    // CONSOLE SUCCESS MESSAGE
    // ======================
    console.log('✅ Book Store Admin Dashboard Loaded Successfully');
});


