{{-- @extends('site.loging.plans.layout.master') --}}
@extends('site.layout.mater')

@section('content')
    <section class="pricing-section">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="section-title">💼 Subscription Plans</h1>
                <p class="section-subtitle">Choose the perfect plan for your business</p>
            </div>

            <div class="row g-4">
                <!-- Free Trial Plan -->
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card">
                        <div class="plan-badge free-badge">🟢 Free Trial</div>
                        <h3 class="plan-title">Starter</h3>
                        <p class="plan-subtitle">No credit card required</p>

                        <div class="price-box">
                            <span class="price">$0</span>
                            <span class="period">14 Days Free Trial</span>
                        </div>

                        <ul class="features-list">
                            <li class="feature-item">
                                <strong>👥 Users</strong>
                                <span>Up to 5 employees</span>
                            </li>
                            <li class="feature-item">
                                <strong>📚 Knowledge</strong>
                                <span>Up to 50 Knowledge Cards</span>
                                <ul class="sub-features">
                                    <li>Onboarding Knowledge</li>
                                    <li>Mistakes & Lessons Learned</li>
                                    <li>Operational Knowledge</li>
                                    <li>Critical & Strategic Knowledge</li>
                                </ul>
                            </li>
                            <li class="feature-item">
                                <strong>🤖 AI</strong>
                                <span>20 AI Requests</span>
                                <ul class="sub-features">
                                    <li>Card summaries</li>
                                    <li>Simple roadmaps</li>
                                </ul>
                            </li>
                            <li class="feature-item">
                                <strong>📅 Calendar</strong>
                                <span>✅ Public Company Calendar</span>
                                <span>❌ Private Department Calendar</span>
                            </li>
                            <li class="feature-item">
                                <strong>📰 Company News</strong>
                                <span>❌ Not available</span>
                            </li>
                            <li class="feature-item">
                                <strong>🔐 Permissions</strong>
                                <span>One Company Admin only</span>
                                <span>Manual approval for all cards</span>
                            </li>
                        </ul>

                        <div class="plan-goal">
                            <strong>🎯 Goal:</strong> Try the concept with no commitment
                        </div>

                        <a href="{{ route('signup.create') }}"><button class="btn-plan">Start Free Trial</button></a>
                    </div>
                </div>

                <!-- Business Plan -->
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card popular">
                        <div class="popular-ribbon">Most Popular</div>
                        <div class="plan-badge business-badge">🔵 Business</div>
                        <h3 class="plan-title">Business</h3>
                        <p class="plan-subtitle">For small and medium businesses</p>

                        <div class="price-box">
                            <span class="price">$29</span>
                            <span class="period">/ month</span>
                        </div>
                        <p class="yearly-price">or $290 / year (2 months free)</p>

                        <ul class="features-list">
                            <li class="feature-item">
                                <strong>👥 Users</strong>
                                <span>Up to 30 employees</span>
                            </li>
                            <li class="feature-item">
                                <strong>📚 Knowledge</strong>
                                <span>Up to 500 Knowledge Cards</span>
                                <span>All knowledge types</span>
                            </li>
                            <li class="feature-item">
                                <strong>🤖 AI</strong>
                                <span>200 AI Requests / month</span>
                                <ul class="sub-features">
                                    <li>Summaries</li>
                                    <li>Roadmaps</li>
                                    <li>Grouped cards analysis</li>
                                </ul>
                            </li>
                            <li class="feature-item">
                                <strong>📅 Calendar</strong>
                                <span>✅ Public Company Calendar</span>
                                <span>✅ Private Department Calendars</span>
                            </li>
                            <li class="feature-item">
                                <strong>📰 Company News</strong>
                                <span>✅ Available</span>
                            </li>
                            <li class="feature-item">
                                <strong>🔐 Permissions</strong>
                                <span>Multiple Company Admins</span>
                                <span>Department Managers</span>
                                <span>Delegated approvals</span>
                            </li>
                            <li class="feature-item">
                                <strong>📊 Dashboard</strong>
                                <span>Basic analytics</span>
                                <ul class="sub-features">
                                    <li>Most active departments</li>
                                    <li>Most used knowledge types</li>
                                </ul>
                            </li>
                        </ul>

                        <div class="plan-goal">
                            <strong>🎯 Goal:</strong> Organize knowledge and prevent loss
                        </div>

                        <button class="btn-plan btn-popular">Get Started</button>
                    </div>
                </div>

                <!-- Enterprise Plan -->
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card">
                        <div class="plan-badge enterprise-badge">🟣 Enterprise</div>
                        <h3 class="plan-title">Advanced</h3>
                        <p class="plan-subtitle">For large and multi-branch companies</p>

                        <div class="price-box">
                            <span class="price">$99</span>
                            <span class="period">/ month</span>
                        </div>
                        <p class="yearly-price">or Custom Pricing for large enterprises</p>

                        <ul class="features-list">
                            <li class="feature-item">
                                <strong>👥 Users</strong>
                                <span>Unlimited Employees</span>
                            </li>
                            <li class="feature-item">
                                <strong>📚 Knowledge</strong>
                                <span>Unlimited Knowledge Cards</span>
                                <span>Advanced tagging & search</span>
                            </li>
                            <li class="feature-item">
                                <strong>🤖 AI</strong>
                                <span>Unlimited AI Requests</span>
                                <ul class="sub-features">
                                    <li>Cross-department insights</li>
                                    <li>Knowledge gaps detection</li>
                                    <li>Suggested onboarding paths</li>
                                </ul>
                            </li>
                            <li class="feature-item">
                                <strong>📅 Calendar</strong>
                                <span>✅ Public Company Calendar</span>
                                <span>✅ Private Department Calendars</span>
                                <span>Multiple calendars per department</span>
                            </li>
                            <li class="feature-item">
                                <strong>📰 Company News</strong>
                                <span>✅ Available + Scheduled publishing</span>
                            </li>
                            <li class="feature-item">
                                <strong>🔐 Permissions</strong>
                                <span>Role-based permissions (Advanced)</span>
                                <span>Approval workflows</span>
                                <span>Audit logs</span>
                            </li>
                            <li class="feature-item">
                                <strong>📊 Dashboard</strong>
                                <span>Advanced analytics</span>
                                <span>Export reports</span>
                            </li>
                        </ul>

                        <div class="plan-goal">
                            <strong>🎯 Goal:</strong> Complete knowledge management solution
                        </div>

                        <button class="btn-plan">Contact Sales</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
