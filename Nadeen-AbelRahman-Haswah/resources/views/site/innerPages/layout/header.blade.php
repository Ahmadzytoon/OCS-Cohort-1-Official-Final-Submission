 <!-- Header -->
 <header class="main-header">
     <div class="header-left">
         <button class="sidebar-toggle" id="sidebarToggle">
             <i class="fas fa-bars"></i>
         </button>
         <div class="header-search">
             <i class="fas fa-search"></i>
             <input type="text" placeholder="Search...">
         </div>
     </div>

     <div class="header-right">
         <!-- Messages -->
         <div class="header-item dropdown">
             <a href="#" class="header-link" data-bs-toggle="dropdown">
                 <i class="fas fa-envelope"></i>
                 <span class="badge">3</span>
             </a>
             <div class="dropdown-menu dropdown-menu-end">
                 <div class="dropdown-header">
                     <span>Messages</span>
                     <a href="#" class="small">Mark all as read</a>
                 </div>
                 <div class="dropdown-body">
                     <a href="#" class="dropdown-item">
                         <div class="item-avatar">
                             <img src="https://ui-avatars.com/api/?name=John+Doe" alt="User">
                         </div>
                         <div class="item-content">
                             <h6>John Doe</h6>
                             <p>How are you?</p>
                             <span class="time">5 min ago</span>
                         </div>
                     </a>
                 </div>
                 <div class="dropdown-footer">
                     <a href="#">View all messages</a>
                 </div>
             </div>
         </div>

         <!-- Notifications -->
         <div class="header-item dropdown">
             <a href="#" class="header-link" data-bs-toggle="dropdown">
                 <i class="fas fa-bell"></i>
                 <span class="badge">4</span>
             </a>
             <div class="dropdown-menu dropdown-menu-end">
                 <div class="dropdown-header">
                     <span>Notifications</span>
                 </div>
                 <div class="dropdown-body">
                     <a href="#" class="dropdown-item">
                         <div class="item-icon">
                             <i class="fas fa-user-plus"></i>
                         </div>
                         <div class="item-content">
                             <h6>New user registered</h6>
                             <span class="time">5 min ago</span>
                         </div>
                     </a>
                 </div>
                 <div class="dropdown-footer">
                     <a href="#">View all notifications</a>
                 </div>
             </div>
         </div>

         <!-- User Profile -->
         <div class="header-item dropdown">
             <a href="#" class="header-user" data-bs-toggle="dropdown">
                 <img src="https://ui-avatars.com/api/?name=Admin+User" alt="Admin">
                 <div class="user-info">
                     <span class="user-greeting">Hi,</span>
                     <span class="user-name">Admin</span>
                 </div>
             </a>
             <div class="dropdown-menu dropdown-menu-end">
                 <div class="dropdown-header user-header">
                     <img src="https://ui-avatars.com/api/?name=Admin+User" alt="Admin">
                     <div>
                         <h6>Admin User</h6>
                         <p>admin@company.com</p>
                     </div>
                 </div>
                 <a href="{{ route('companyOwner.profile') }}" class="dropdown-item">
                     <i class="fas fa-user"></i> My Profile
                 </a>
                 <a href="#" class="dropdown-item">
                     <i class="fas fa-cog"></i> Settings
                 </a>
                 <div class="dropdown-divider"></div>
                 {{-- <a href="#" class="dropdown-item text-danger">
                     <i class="fas fa-sign-out-alt"></i> Logout
                 </a> --}}
                 <a href="#" class="dropdown-item text-danger"
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                     <i class="fas fa-sign-out-alt"></i> Logout
                 </a>

                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                     @csrf
                 </form>

             </div>
         </div>
     </div>
 </header>
