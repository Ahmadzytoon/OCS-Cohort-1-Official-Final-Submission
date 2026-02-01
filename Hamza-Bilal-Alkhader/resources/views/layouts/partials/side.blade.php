<!-- Sidebar -->
            <aside class="col-12 col-lg-3">
              <div class="card shadow-sm border-0">
                <div class="card-body">
                  <h5 class="mb-3">Admin Panel</h5>

                  <div class="list-group">

                    <a
                      href="{{route('admin.dashboard')}}"
                      class="list-group-item list-group-item-action "
                    >
                      <i class="bi bi-person-badge me-2"></i> Dashboard
                    </a>

                    <a
                      href="{{route('admin.teacher-profiles')}}"
                      class="list-group-item list-group-item-action "
                    >
                      <i class="bi bi-person-badge me-2"></i> Teacher Profiles
                    </a>

                    <a
                      href="{{route('admin.students')}}"
                      class="list-group-item list-group-item-action"
                    >
                      <i class="bi bi-people me-2"></i> Students
                    </a>

                    <a
                      href="{{route('admin.teachers')}}"
                      class="list-group-item list-group-item-action"
                    >
                      <i class="bi bi-mortarboard me-2"></i> Teachers
                    </a>

                    <a
                      href="{{route('admin.reviews.reported')}}"
                      class="list-group-item list-group-item-action"
                    >
                      <i class="bi bi-exclamation-triangle-fill me-2"></i>Reported Reviews
                    </a>

                    <a
                      href="{{route('admin.reviews')}}"
                      class="list-group-item list-group-item-action"
                    >
                      <i class="bi bi-chat-square-text me-2"></i>All Reviews
                    </a>
                      
                    <a
                  href="{{route('admin.subjects-branches')}}"
                  class="list-group-item list-group-item-action"
                >
                  <i class="bi bi-book me-2"></i> Subjects & Branches
                </a>
                  </div>
                </div>
              </div>
            </aside>