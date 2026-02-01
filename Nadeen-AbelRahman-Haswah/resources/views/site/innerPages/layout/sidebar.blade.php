@php
    $role = auth()->user()->role;
@endphp

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <a href="">
            <h3>KnowledgeHub</h3>
        </a>
    </div>


    <div class="sidebar-menu">
        <ul class="nav-menu">

            @if ($role === 'company_owner')
                <li class="nav-item {{ request()->routeIs('companyOwner.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('companyOwner.dashboard') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('companyOwner.companyProfile') ? 'active' : '' }}">
                    <a href="{{ route('companyOwner.companyProfile') }}" class="nav-link">
                        <i class="fa-solid fa-people-roof"></i>
                        <span>Company Profile</span>
                        {{-- <i class="fas fa-chevron-down dropdown-arrow"></i> --}}
                    </a>

                </li>
                {{--  الصفحات المشتركة بين owner & department manager --}}
                @if (in_array($role, ['department_manager', 'company_owner']))
                    <li
                        class="nav-item has-dropdown {{ request()->routeIs('shared.employee.index', 'shared.accessRequests.index') ? 'active' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Users & Roles</span>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </a>
                        <ul class="nav-dropdown">
                            <li><a href="{{ route('shared.employee.index') }}"><i class="fas fa-user-tie"></i>
                                    Employees</a>
                            </li>
                            <li><a href="{{ route('shared.accessRequests.index') }}"><i class="fas fa-user-plus"></i>
                                    Access
                                    Requests</a></li>

                        </ul>
                    </li>
                @endif
                <li class="nav-item {{ request()->routeIs('companyOwner.departments') ? 'active' : '' }}">
                    <a href="{{ route('companyOwner.departments.index') }}" class="nav-link">
                        <i class="fas fa-book"></i>
                        <span>Departments</span>
                    </a>
                </li>
                <li
                    class="nav-item has-dropdown {{ request()->routeIs('companyOwner.knowledgeOverview', 'companyOwner.onboardingKnowledge', 'companyOwner.MistakesAndLessonsLearned', 'companyOwner.OperationalKnowledge', 'companyOwner.CriticalAndStrategicKnowledge') ? 'active' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="fas fa-layer-group"></i>
                        <span>Knowledge Center</span>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </a>
                    <ul class="nav-dropdown">
                        {{-- <li><a href="{{ route('companyOwner.knowledgeOverview') }}"><i class="fa-regular fa-eye"></i>
                                Knowledge Overview</a></li> --}}
                        <li><a href="{{ route('shared.onboarding') }}"><i class="fa-solid fa-clipboard-question"></i>
                                Onboarding Knowledge</a></li>
                        <li><a href="{{ route('shared.mistakes') }}"><i class="fa-solid fa-square-xmark"></i> Mistakes
                                & Lessons Learned</a></li>
                        <li><a href="{{ route('shared.operational') }}"><i class="fa-solid fa-briefcase"></i>
                                Operational Knowledge</a></li>
                        <li><a href="{{ route('shared.critical') }}"><i class="fa-regular fa-chess-queen"></i> Critical
                                & Strategic Knowledge</a></li>
                    </ul>
                </li>
                <li class="nav-item {{ request()->routeIs('shared.approvals.index') ? 'active' : '' }}">
                    <a href="{{ route('shared.approvals.index') }}" class="nav-link">
                        <i class="fas fa-calendar"></i>
                        <span>Approvals</span>
                    </a>
                </li>
                <li
                    class="nav-item has-dropdown {{ request()->routeIs('companyOwner.companyCalendar', 'companyOwner.departmentsCalendars') ? 'active' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Calendar</span>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </a>
                    <ul class="nav-dropdown">
                        <li><a href="{{ route('companyOwner.companyCalendar') }}"><i
                                    class="fa-solid fa-calendar-days"></i>
                                Company Calendar</a></li>
                        <li><a href="{{ route('companyOwner.departmentsCalendars') }}"><i
                                    class="fa-solid fa-calendar-day"></i>
                                Departments Calendars</a></li>
                    </ul>
                </li>
                <li class="nav-item {{ request()->routeIs('shared.companyNews.index') ? 'active' : '' }}">
                    <a href="{{ route('shared.companyNews.index') }}" class="nav-link">
                        <i class="fas fa-newspaper"></i>
                        <span>Company News</span>
                    </a>
                </li>
                {{-- <li class="nav-item {{ request()->routeIs('companyOwner.settings') ? 'active' : '' }}">
                    <a href="{{ route('companyOwner.settings') }}" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li> --}}
            @endif


            @if ($role === 'department_manager')

                <li class="nav-item {{ request()->routeIs('departmentManager..dashboard') ? 'active' : '' }}">
                    <a href="{{ route('departmentManager.dashboard') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                {{--  الصفحات المشتركة بين owner & department manager --}}
                @if (in_array($role, ['department_manager', 'company_owner']))
                    <li
                        class="nav-item has-dropdown {{ request()->routeIs('shared.employee.index', 'shared.accessRequests.index') ? 'active' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Users & Roles</span>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </a>
                        <ul class="nav-dropdown">
                            <li><a href="{{ route('shared.employee.index') }}"><i class="fas fa-user-tie"></i>
                                    Employees</a>
                            </li>
                            <li><a href="{{ route('shared.accessRequests.index') }}"><i class="fas fa-user-plus"></i>
                                    Access
                                    Requests</a></li>

                        </ul>
                    </li>
                @endif

                <li class="nav-item {{ request()->routeIs('shared.companyNews.index') ? 'active' : '' }}">
                    <a href="{{ route('shared.companyNews.index') }}" class="nav-link">
                        <i class="fas fa-newspaper"></i>
                        <span>Company News</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('shared.approvals.index') ? 'active' : '' }}">
                    <a href="{{ route('shared.approvals.index') }}" class="nav-link">
                        <i class="fas fa-calendar"></i>
                        <span>Approvals</span>
                    </a>
                </li>

                <li
                    class="nav-item has-dropdown {{ request()->routeIs('companyOwner.knowledgeOverview', 'companyOwner.onboardingKnowledge', 'companyOwner.MistakesAndLessonsLearned', 'companyOwner.OperationalKnowledge', 'companyOwner.CriticalAndStrategicKnowledge') ? 'active' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="fas fa-layer-group"></i>
                        <span>Knowledge Center</span>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </a>
                    <ul class="nav-dropdown">
                        <li><a href="{{ route('companyOwner.knowledgeOverview') }}"><i class="fa-regular fa-eye"></i>
                                Knowledge Overview</a></li>
                        <li><a href="{{ route('companyOwner.onboardingKnowledge') }}"><i
                                    class="fa-solid fa-clipboard-question"></i>
                                Onboarding Knowledge</a></li>
                        <li><a href="{{ route('companyOwner.MistakesAndLessonsLearned') }}"><i
                                    class="fa-solid fa-square-xmark"></i> Mistakes & Lessons Learned</a></li>
                        <li><a href="{{ route('companyOwner.OperationalKnowledge') }}"><i
                                    class="fa-solid fa-briefcase"></i>
                                Operational Knowledge</a></li>
                        <li><a href="{{ route('companyOwner.CriticalAndStrategicKnowledge') }}"><i
                                    class="fa-regular fa-chess-queen"></i> Critical & Strategic Knowledge</a></li>
                    </ul>
                </li>

                <li
                    class="nav-item has-dropdown {{ request()->routeIs('companyOwner.companyCalendar', 'companyOwner.departmentsCalendars') ? 'active' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Calendar</span>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </a>
                    <ul class="nav-dropdown">
                        <li><a href="{{ route('companyOwner.companyCalendar') }}"><i
                                    class="fa-solid fa-calendar-days"></i>
                                Company Calendar</a></li>
                        <li><a href="{{ route('companyOwner.departmentsCalendars') }}"><i
                                    class="fa-solid fa-calendar-day"></i>
                                Departments Calendars</a></li>
                    </ul>
                </li>
            @endif


            @if ($role === 'employee')
                <li class="nav-item {{ request()->routeIs('shared.companyNews.index') ? 'active' : '' }}">
                    <a href="{{ route('shared.companyNews.index') }}" class="nav-link">
                        <i class="fas fa-newspaper"></i>
                        <span>Company News</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('knowledge.knowledge.create') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>Add Knowledge </span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('knowledge.knowledge.myContributions') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>My Contributions </span>
                    </a>
                </li>


                <li class="nav-item has-dropdown">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Knowledge Center</span>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </a>
                    <ul class="nav-dropdown">
                        <li><a href="#"><i class="fas fa-user-tie"></i> Knowledge Overview</a></li>
                        <li><a href="#"><i class="fas fa-user-plus"></i> Onboarding Knowledge</a></li>
                        <li><a href="#"><i class="fas fa-user-plus"></i> Mistakes & Lessons Learned</a></li>
                        <li><a href="#"><i class="fas fa-user-plus"></i> Operational Knowledge</a></li>
                        <li><a href="#"><i class="fas fa-user-plus"></i> Critical & Strategic Knowledge</a></li>
                    </ul>
                </li>
            @endif


            {{-- الصفحات المشتركة --}}
            @if (in_array($role, ['department_manager', 'employee']))
                {{-- <li><a href="{{ route('department.calendar') }}">Calendar</a></li> --}}
            @endif
            {{-- Show Add Event button only for department_manager --}}
            {{-- @if (auth()->user()->role === 'department_manager')
                <a href="{{ route('department.calendar.events.create') }}" class="btn btn-primary">
                    Add Event
                </a>
            @endif --}}


        </ul>
    </div>

    @if (Route::is('DepartmentManager*'))
        <div class="sidebar-menu">
            <ul class="nav-menu">
                <li class="nav-item active">
                    <a href="{{ route('DepartmentManager.index') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('DepartmentManager.departmentTeam') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Department Team</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-book"></i>
                        <span>Departments</span>
                    </a>
                </li>
                <li class="nav-item has-dropdown">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Knowledge Center</span>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </a>
                    <ul class="nav-dropdown">
                        <li><a href="#"><i class="fas fa-user-tie"></i> Knowledge Overview</a></li>
                        <li><a href="#"><i class="fas fa-user-plus"></i> Onboarding Knowledge</a></li>
                        <li><a href="#"><i class="fas fa-user-plus"></i> Mistakes & Lessons Learned</a></li>
                        <li><a href="#"><i class="fas fa-user-plus"></i> Operational Knowledge</a></li>
                        <li><a href="#"><i class="fas fa-user-plus"></i> Critical & Strategic Knowledge</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-calendar"></i>
                        <span>Approvals</span>
                    </a>
                </li>
                <li class="nav-item has-dropdown">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Calendar</span>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </a>
                    <ul class="nav-dropdown">
                        <li><a href="#"><i class="fas fa-user-tie"></i> Company Calendar</a></li>
                        <li><a href="#"><i class="fas fa-user-plus"></i> Departments Calendars</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-newspaper"></i>
                        <span>Company News</span>
                    </a>
                </li>


            </ul>
        </div>
    @endif
    @if (Route::is('employee*'))
        <div class="sidebar-menu">
            <ul class="nav-menu">
                <li class="nav-item active">
                    <a href="{{ route('employee.index') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('employee.addknowledge') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>Add Knowledge </span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('employee.myContributions') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>My Contributions </span>
                    </a>
                </li>


                <li class="nav-item has-dropdown">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Knowledge Center</span>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </a>
                    <ul class="nav-dropdown">
                        <li><a href="#"><i class="fas fa-user-tie"></i> Knowledge Overview</a></li>
                        <li><a href="#"><i class="fas fa-user-plus"></i> Onboarding Knowledge</a></li>
                        <li><a href="#"><i class="fas fa-user-plus"></i> Mistakes & Lessons Learned</a></li>
                        <li><a href="#"><i class="fas fa-user-plus"></i> Operational Knowledge</a></li>
                        <li><a href="#"><i class="fas fa-user-plus"></i> Critical & Strategic Knowledge</a></li>
                    </ul>
                </li>

                <li class="nav-item has-dropdown">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Calendar</span>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </a>
                    <ul class="nav-dropdown">
                        <li><a href="#"><i class="fas fa-user-tie"></i> Company Calendar</a></li>
                        <li><a href="#"><i class="fas fa-user-plus"></i> Departments Calendars</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-newspaper"></i>
                        <span>Company News</span>
                    </a>
                </li>


            </ul>
        </div>
    @endif



</div>
