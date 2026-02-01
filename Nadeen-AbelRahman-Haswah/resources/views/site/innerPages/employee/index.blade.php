@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-header">
        <h1>Dashboard</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <div class="content-body">
        <!-- Welcome Header -->
        <div class="employee-welcome-header">
            <div class="welcome-content-wrapper">
                <div class="welcome-left">
                    <div class="employee-avatar-large">
                        <img src="https://ui-avatars.com/api/?name=Mohammad+Ali&background=47b2e4&color=fff&size=150"
                            alt="Mohammad Ali">
                        <div class="status-indicator"></div>
                    </div>
                    <div class="welcome-info">
                        <h2>Welcome back, Mohammad! 👋</h2>
                        <p>Here's what's happening with your contributions today</p>
                        <div class="employee-meta">
                            <span><i class="fas fa-building me-2"></i> IT Department</span>
                            <span><i class="fas fa-briefcase me-2"></i> Full Stack Developer</span>
                        </div>
                    </div>
                </div>
                <div class="welcome-actions">
                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addKnowledgeModal">
                        <i class="fas fa-plus-circle me-2"></i> Add Knowledge
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="employee-stat-card total-contributions">
                    <div class="stat-icon-wrapper">
                        <div class="stat-icon-emp">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                    <div class="stat-content-emp">
                        <h3>28</h3>
                        <p>Total Contributions</p>
                        <small class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i> +4 this month
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="employee-stat-card approved-cards">
                    <div class="stat-icon-wrapper">
                        <div class="stat-icon-emp">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="stat-content-emp">
                        <h3>22</h3>
                        <p>Approved Cards</p>
                        <small class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i> 78% approval rate
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="employee-stat-card pending-cards">
                    <div class="stat-icon-wrapper">
                        <div class="stat-icon-emp">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="stat-content-emp">
                        <h3>6</h3>
                        <p>Pending Review</p>
                        <small class="stat-trend neutral">
                            <i class="fas fa-hourglass-half"></i> Awaiting approval
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="employee-stat-card saved-cards">
                    <div class="stat-icon-wrapper">
                        <div class="stat-icon-emp">
                            <i class="fas fa-bookmark"></i>
                        </div>
                    </div>
                    <div class="stat-content-emp">
                        <h3>15</h3>
                        <p>Saved Cards</p>
                        <small class="stat-trend neutral">
                            <i class="fas fa-heart"></i> For quick access
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- My Contributions Breakdown -->
                <div class="content-card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-chart-pie text-primary me-2"></i>
                            My Contributions Breakdown
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="contribution-type-box onboarding-box">
                                    <div class="contribution-header">
                                        <div class="contribution-icon">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                        <div class="contribution-info">
                                            <h5>8</h5>
                                            <p>Onboarding Knowledge</p>
                                        </div>
                                    </div>
                                    <div class="contribution-stats">
                                        <div class="stat-item-small">
                                            <i class="fas fa-check-circle text-success"></i>
                                            <span>6 Approved</span>
                                        </div>
                                        <div class="stat-item-small">
                                            <i class="fas fa-clock text-warning"></i>
                                            <span>2 Pending</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="contribution-type-box mistakes-box">
                                    <div class="contribution-header">
                                        <div class="contribution-icon">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <div class="contribution-info">
                                            <h5>5</h5>
                                            <p>Mistakes & Lessons</p>
                                        </div>
                                    </div>
                                    <div class="contribution-stats">
                                        <div class="stat-item-small">
                                            <i class="fas fa-check-circle text-success"></i>
                                            <span>4 Approved</span>
                                        </div>
                                        <div class="stat-item-small">
                                            <i class="fas fa-clock text-warning"></i>
                                            <span>1 Pending</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="contribution-type-box operational-box">
                                    <div class="contribution-header">
                                        <div class="contribution-icon">
                                            <i class="fas fa-cogs"></i>
                                        </div>
                                        <div class="contribution-info">
                                            <h5>10</h5>
                                            <p>Operational Knowledge</p>
                                        </div>
                                    </div>
                                    <div class="contribution-stats">
                                        <div class="stat-item-small">
                                            <i class="fas fa-check-circle text-success"></i>
                                            <span>8 Approved</span>
                                        </div>
                                        <div class="stat-item-small">
                                            <i class="fas fa-clock text-warning"></i>
                                            <span>2 Pending</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="contribution-type-box critical-box">
                                    <div class="contribution-header">
                                        <div class="contribution-icon">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="contribution-info">
                                            <h5>5</h5>
                                            <p>Critical & Strategic</p>
                                        </div>
                                    </div>
                                    <div class="contribution-stats">
                                        <div class="stat-item-small">
                                            <i class="fas fa-check-circle text-success"></i>
                                            <span>4 Approved</span>
                                        </div>
                                        <div class="stat-item-small">
                                            <i class="fas fa-clock text-warning"></i>
                                            <span>1 Pending</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="content-card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-history text-info me-2"></i>
                            Recent Activity
                        </h4>
                        <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="activity-timeline">
                            <div class="activity-item-emp">
                                <div class="activity-dot approved"></div>
                                <div class="activity-content-emp">
                                    <div class="activity-header-emp">
                                        <h6>Knowledge Card Approved</h6>
                                        <span class="activity-time">2 hours ago</span>
                                    </div>
                                    <p>Your card "Git Workflow Best Practices" has been approved</p>
                                    <span class="badge bg-success-subtle text-success">Onboarding Knowledge</span>
                                </div>
                            </div>
                            <div class="activity-item-emp">
                                <div class="activity-dot pending"></div>
                                <div class="activity-content-emp">
                                    <div class="activity-header-emp">
                                        <h6>Card Submitted for Review</h6>
                                        <span class="activity-time">5 hours ago</span>
                                    </div>
                                    <p>You submitted "Docker Container Setup Guide"</p>
                                    <span class="badge bg-warning-subtle text-warning">Operational Knowledge</span>
                                </div>
                            </div>
                            <div class="activity-item-emp">
                                <div class="activity-dot approved"></div>
                                <div class="activity-content-emp">
                                    <div class="activity-header-emp">
                                        <h6>Knowledge Card Approved</h6>
                                        <span class="activity-time">1 day ago</span>
                                    </div>
                                    <p>Your card "Common API Integration Mistakes" has been approved</p>
                                    <span class="badge bg-danger-subtle text-danger">Mistakes & Lessons</span>
                                </div>
                            </div>
                            <div class="activity-item-emp">
                                <div class="activity-dot saved"></div>
                                <div class="activity-content-emp">
                                    <div class="activity-header-emp">
                                        <h6>Card Saved</h6>
                                        <span class="activity-time">2 days ago</span>
                                    </div>
                                    <p>You saved "Project Management Best Practices"</p>
                                    <span class="badge bg-primary-subtle text-primary">Critical & Strategic</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Saved Cards -->
                <div class="content-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-bookmark text-warning me-2"></i>
                            Saved Cards
                        </h4>
                        <a href="#" class="btn btn-sm btn-outline-primary">View All (15)</a>
                    </div>
                    <div class="card-body">
                        <div class="saved-cards-list">
                            <div class="saved-card-item">
                                <div class="saved-card-icon onboarding-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="saved-card-content">
                                    <h6>First Week Survival Guide</h6>
                                    <p>Essential tips for new developers joining the IT team</p>
                                    <div class="saved-card-meta">
                                        <span><i class="fas fa-user me-1"></i> Sarah Ahmed</span>
                                        <span><i class="fas fa-clock me-1"></i> Saved 3 days ago</span>
                                    </div>
                                </div>
                                <div class="saved-card-actions">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-bookmark-slash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="saved-card-item">
                                <div class="saved-card-icon operational-icon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div class="saved-card-content">
                                    <h6>CI/CD Pipeline Configuration</h6>
                                    <p>Step-by-step guide for setting up automated deployments</p>
                                    <div class="saved-card-meta">
                                        <span><i class="fas fa-user me-1"></i> Omar Khaled</span>
                                        <span><i class="fas fa-clock me-1"></i> Saved 1 week ago</span>
                                    </div>
                                </div>
                                <div class="saved-card-actions">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-bookmark-slash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="saved-card-item">
                                <div class="saved-card-icon critical-icon">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="saved-card-content">
                                    <h6>Promotion Path for Developers</h6>
                                    <p>How I got promoted from Junior to Senior in 2 years</p>
                                    <div class="saved-card-meta">
                                        <span><i class="fas fa-user me-1"></i> Ahmed Khaled</span>
                                        <span><i class="fas fa-clock me-1"></i> Saved 2 weeks ago</span>
                                    </div>
                                </div>
                                <div class="saved-card-actions">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-bookmark-slash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Quick Stats -->
                <div class="content-card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-chart-line text-success me-2"></i>
                            This Month
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="quick-stat-item">
                            <div class="quick-stat-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div class="quick-stat-info">
                                <h5>4</h5>
                                <p>Cards Added</p>
                            </div>
                        </div>
                        <div class="quick-stat-item">
                            <div class="quick-stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="quick-stat-info">
                                <h5>3</h5>
                                <p>Cards Approved</p>
                            </div>
                        </div>
                        <div class="quick-stat-item">
                            <div class="quick-stat-icon">
                                <i class="fas fa-bookmark"></i>
                            </div>
                            <div class="quick-stat-info">
                                <h5>5</h5>
                                <p>Cards Saved</p>
                            </div>
                        </div>
                        <div class="quick-stat-item">
                            <div class="quick-stat-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div class="quick-stat-info">
                                <h5>127</h5>
                                <p>Cards Viewed</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="content-card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            Upcoming Events
                        </h4>
                        <a href="#" class="btn btn-sm btn-outline-primary">Calendar</a>
                    </div>
                    <div class="card-body">
                        <div class="upcoming-events-emp">
                            <div class="event-item-emp">
                                <div class="event-date-emp">
                                    <div class="event-day-emp">25</div>
                                    <div class="event-month-emp">JAN</div>
                                </div>
                                <div class="event-content-emp">
                                    <h6>Team Sprint Planning</h6>
                                    <p><i class="fas fa-clock me-1"></i> 10:00 AM - 12:00 PM</p>
                                    <span class="event-badge dept-event">
                                        <i class="fas fa-users me-1"></i> Department
                                    </span>
                                </div>
                            </div>
                            <div class="event-item-emp">
                                <div class="event-date-emp">
                                    <div class="event-day-emp">27</div>
                                    <div class="event-month-emp">JAN</div>
                                </div>
                                <div class="event-content-emp">
                                    <h6>React Workshop</h6>
                                    <p><i class="fas fa-clock me-1"></i> 2:00 PM - 5:00 PM</p>
                                    <span class="event-badge training-event">
                                        <i class="fas fa-chalkboard-teacher me-1"></i> Training
                                    </span>
                                </div>
                            </div>
                            <div class="event-item-emp">
                                <div class="event-date-emp">
                                    <div class="event-day-emp">30</div>
                                    <div class="event-month-emp">JAN</div>
                                </div>
                                <div class="event-content-emp">
                                    <h6>Company Town Hall</h6>
                                    <p><i class="fas fa-clock me-1"></i> 11:00 AM - 12:00 PM</p>
                                    <span class="event-badge company-event">
                                        <i class="fas fa-building me-1"></i> Company
                                    </span>
                                </div>
                            </div>
                            <div class="event-item-emp">
                                <div class="event-date-emp">
                                    <div class="event-day-emp">02</div>
                                    <div class="event-month-emp">FEB</div>
                                </div>
                                <div class="event-content-emp">
                                    <h6>Project Milestone Review</h6>
                                    <p><i class="fas fa-clock me-1"></i> 3:00 PM</p>
                                    <span class="event-badge deadline-event">
                                        <i class="fas fa-flag me-1"></i> Deadline
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="content-card">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-bolt text-warning me-2"></i>
                            Quick Actions
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#addKnowledgeModal">
                                <i class="fas fa-plus-circle me-2"></i> Add Knowledge Card
                            </button>
                            <button class="btn btn-outline-success">
                                <i class="fas fa-search me-2"></i> Browse Knowledge
                            </button>
                            <button class="btn btn-outline-info">
                                <i class="fas fa-bookmark me-2"></i> My Saved Cards
                            </button>
                            <button class="btn btn-outline-warning">
                                <i class="fas fa-clock me-2"></i> Pending Reviews
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Knowledge Modal -->
    <div class="modal fade" id="addKnowledgeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle me-2"></i> Add Knowledge Card
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-4">Select the type of knowledge you want to share:</p>
                    <div class="knowledge-type-selection">
                        <a href="#" class="knowledge-type-option">
                            <div class="knowledge-type-icon onboarding-bg">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="knowledge-type-info">
                                <h6>Onboarding Knowledge</h6>
                                <p>Help new team members get started faster</p>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="#" class="knowledge-type-option">
                            <div class="knowledge-type-icon mistakes-bg">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="knowledge-type-info">
                                <h6>Mistakes & Lessons</h6>
                                <p>Share lessons learned from past mistakes</p>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="#" class="knowledge-type-option">
                            <div class="knowledge-type-icon operational-bg">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div class="knowledge-type-info">
                                <h6>Operational Knowledge</h6>
                                <p>Document how to perform specific tasks</p>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="#" class="knowledge-type-option">
                            <div class="knowledge-type-icon critical-bg">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="knowledge-type-info">
                                <h6>Critical & Strategic</h6>
                                <p>Share important career and project insights</p>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Employee Dashboard JavaScript

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all features
            initializeStatCards();
            initializeSavedCards();
            initializeQuickActions();
            initializeAnimations();
        });

        // Animate stat cards on load
        function initializeStatCards() {
            const statCards = document.querySelectorAll('.employee-stat-card');

            statCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.5s ease';

                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                }, index * 100);
            });
        }

        // Handle saved cards functionality
        function initializeSavedCards() {
            const unsaveButtons = document.querySelectorAll('.saved-card-actions .btn-outline-danger');

            unsaveButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const cardItem = this.closest('.saved-card-item');

                    // Add animation
                    cardItem.style.transition = 'all 0.3s ease';
                    cardItem.style.opacity = '0';
                    cardItem.style.transform = 'translateX(-20px)';

                    // Remove after animation
                    setTimeout(() => {
                        cardItem.remove();

                        // Update saved cards count
                        updateSavedCardsCount();
                    }, 300);
                });
            });
        }

        // Update saved cards count
        function updateSavedCardsCount() {
            const savedCardsCount = document.querySelectorAll('.saved-card-item').length;
            const savedStatCard = document.querySelector('.employee-stat-card.saved-cards h3');

            if (savedStatCard) {
                // Animate number change
                const currentCount = parseInt(savedStatCard.textContent);
                animateNumber(savedStatCard, currentCount, savedCardsCount);
            }
        }

        // Animate number counting
        function animateNumber(element, from, to) {
            const duration = 500;
            const steps = 20;
            const stepDuration = duration / steps;
            const increment = (to - from) / steps;
            let current = from;
            let stepCount = 0;

            const timer = setInterval(() => {
                current += increment;
                stepCount++;
                element.textContent = Math.round(current);

                if (stepCount >= steps) {
                    clearInterval(timer);
                    element.textContent = to;
                }
            }, stepDuration);
        }

        // Quick actions handlers
        function initializeQuickActions() {
            const quickActionButtons = document.querySelectorAll(
                '.quick-action-btn, .btn-outline-primary, .btn-outline-success, .btn-outline-info, .btn-outline-warning'
            );

            quickActionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Add ripple effect
                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple');
                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        }

        // Initialize animations for timeline
        function initializeAnimations() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '0';
                        entry.target.style.transform = 'translateX(-20px)';
                        entry.target.style.transition = 'all 0.5s ease';

                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateX(0)';
                        }, 100);

                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.activity-item-emp').forEach(item => {
                observer.observe(item);
            });
        }

        // Filter activities by type
        function filterActivities(type) {
            const activities = document.querySelectorAll('.activity-item-emp');

            activities.forEach(activity => {
                const badge = activity.querySelector('.badge');

                if (type === 'all' || !badge) {
                    activity.style.display = 'flex';
                } else {
                    const activityType = badge.textContent.trim().toLowerCase();
                    activity.style.display = activityType.includes(type.toLowerCase()) ? 'flex' : 'none';
                }
            });
        }

        // Search saved cards
        function searchSavedCards(query) {
            const cards = document.querySelectorAll('.saved-card-item');
            const searchQuery = query.toLowerCase();

            cards.forEach(card => {
                const title = card.querySelector('h6').textContent.toLowerCase();
                const description = card.querySelector('p').textContent.toLowerCase();
                const author = card.querySelector('.saved-card-meta span:first-child').textContent.toLowerCase();

                if (title.includes(searchQuery) || description.includes(searchQuery) || author.includes(
                        searchQuery)) {
                    card.style.display = 'flex';
                    card.style.animation = 'fadeIn 0.3s ease';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Toggle event calendar view
        function toggleCalendarView() {
            const events = document.querySelectorAll('.event-item-emp');
            let isExpanded = false;

            events.forEach((event, index) => {
                if (index >= 3) {
                    event.style.display = isExpanded ? 'flex' : 'none';
                }
            });

            return !isExpanded;
        }

        // Refresh dashboard data
        function refreshDashboard() {
            // Show loading state
            const statCards = document.querySelectorAll('.employee-stat-card');
            statCards.forEach(card => {
                card.style.opacity = '0.5';
            });

            // Simulate API call
            setTimeout(() => {
                statCards.forEach(card => {
                    card.style.opacity = '1';
                });

                // Show success message
                showNotification('Dashboard refreshed successfully!', 'success');
            }, 1000);
        }

        // Show notification
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} notification-toast`;
            notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        animation: slideIn 0.3s ease;
    `;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Export functions for external use
        window.EmployeeDashboard = {
            filterActivities,
            searchSavedCards,
            toggleCalendarView,
            refreshDashboard,
            showNotification
        };

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        width: 20px;
        height: 20px;
        animation: rippleEffect 0.6s ease-out;
        pointer-events: none;
    }

    @keyframes rippleEffect {
        to {
            width: 200px;
            height: 200px;
            opacity: 0;
        }
    }
`;
        document.head.appendChild(style);
    </script>
@endsection
