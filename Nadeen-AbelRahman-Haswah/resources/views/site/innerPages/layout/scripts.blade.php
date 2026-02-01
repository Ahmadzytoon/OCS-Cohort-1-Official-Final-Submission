<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainWrapper = document.querySelector('.main-wrapper');

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        mainWrapper.classList.toggle('sidebar-collapsed');
    });

    // Dropdown Menu Toggle
    const dropdownItems = document.querySelectorAll('.nav-item.has-dropdown');

    dropdownItems.forEach(item => {
        const link = item.querySelector('.nav-link');

        link.addEventListener('click', (e) => {
            e.preventDefault();

            // إغلاق باقي القوائم المفتوحة
            dropdownItems.forEach(other => {
                if (other !== item) {
                    other.classList.remove('open');
                }
            });

            // فتح/إغلاق القائمة الحالية
            item.classList.toggle('open');
        });
    });

    // Auto collapse on mobile
    if (window.innerWidth <= 991) {
        sidebar.classList.add('collapsed');
        mainWrapper.classList.add('sidebar-collapsed');
    }
</script>


<script>
    // Save Profile Function
    function saveProfile() {
        // جمع البيانات من الفورم
        const workspaceName = document.getElementById('workspaceName').value;
        const companySize = document.getElementById('companySize').value;
        const industry = document.getElementById('industry').value;

        // هنا راح تضيف كود الحفظ للسيرفر
        console.log('Saving profile...', {
            workspaceName,
            companySize,
            industry
        });

        // إظهار رسالة نجاح
        alert('Profile updated successfully!');

        // إغلاق الـ modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('editProfileModal'));
        modal.hide();

        // تحديث البيانات في الصفحة (optional)
        // يمكنك تحديث القيم المعروضة هنا
    }

    // Save Billing Function
    function saveBilling() {
        const billingEmail = document.getElementById('billingEmail').value;
        const billingName = document.getElementById('billingName').value;

        console.log('Saving billing info...', {
            billingEmail,
            billingName
        });

        alert('Billing information updated successfully!');

        const modal = bootstrap.Modal.getInstance(document.getElementById('manageBillingModal'));
        modal.hide();
    }

    // Add New Card Function
    function addNewCard() {
        alert('Redirecting to add new payment method...');
        // هنا راح تضيف كود إضافة بطاقة جديدة
    }

    // Remove Card Function
    function removeCard() {
        if (confirm('Are you sure you want to remove this payment method?')) {
            alert('Payment method removed successfully!');
            // هنا راح تضيف كود حذف البطاقة
        }
    }
</script>

<script>
    // Approve Request
    function approveRequest(id) {
        const modal = new bootstrap.Modal(document.getElementById('approveRequestModal'));
        modal.show();
    }

    function confirmApproval() {
        alert('Access request approved successfully!');
        bootstrap.Modal.getInstance(document.getElementById('approveRequestModal')).hide();
    }

    // Reject Request
    function rejectRequest(id) {
        const modal = new bootstrap.Modal(document.getElementById('rejectRequestModal'));
        modal.show();
    }

    function confirmRejection() {
        alert('Access request rejected.');
        bootstrap.Modal.getInstance(document.getElementById('rejectRequestModal')).hide();
    }

    // View Role Details
    function viewRoleDetails(roleType) {
        alert('Viewing detailed permissions for: ' + roleType);
    }
</script>

<script>
    // Create Department
    function createDepartment() {
        alert('Department created successfully!');
        bootstrap.Modal.getInstance(document.getElementById('createDepartmentModal')).hide();
    }

    // Edit Department
    function editDepartment(deptId) {
        const modal = new bootstrap.Modal(document.getElementById('editDepartmentModal'));
        modal.show();
    }

    function saveDepartment() {
        alert('Department updated successfully!');
        bootstrap.Modal.getInstance(document.getElementById('editDepartmentModal')).hide();
    }

    // Delete Department
    function deleteDepartment(deptId) {
        if (confirm('Are you sure you want to delete this department? This action cannot be undone.')) {
            alert('Department deleted successfully!');
        }
    }

    // View Department Members
    function viewDepartmentMembers(deptId) {
        const modal = new bootstrap.Modal(document.getElementById('viewMembersModal'));
        modal.show();
    }

    // View Department Cards
    function viewDepartmentCards(deptId) {
        alert('Redirecting to department knowledge cards...');
    }

    // View Department Details
    function viewDepartmentDetails(deptId) {
        alert('Viewing detailed statistics for: ' + deptId);
    }
</script>


<script>
    // Approve Card
    function approveCard(id) {
        if (confirm('Approve this knowledge card?')) {
            alert('Card approved successfully!');
        }
    }

    // Reject Card
    function rejectCard(id) {
        if (confirm('Reject this knowledge card?')) {
            alert('Card rejected.');
        }
    }
</script>


<script>
    let currentCardId = null;

    // Toggle Select All
    function toggleSelectAll() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.approval-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
    }

    // Bulk Approve
    function bulkApprove() {
        const checkboxes = document.querySelectorAll('.approval-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Please select at least one card to approve');
            return;
        }

        if (confirm(`Approve ${checkboxes.length} selected card(s)?`)) {
            alert(`${checkboxes.length} card(s) approved successfully!`);
            // هنا راح تضيف كود الإرسال للسيرفر
        }
    }

    // View Card Details
    function viewCardDetails(cardId) {
        alert('Opening detailed view for card #' + cardId);
        // هنا راح تفتح صفحة التفاصيل أو modal
    }

    // Approve with Comment
    function approveWithComment(cardId) {
        currentCardId = cardId;
        const modal = new bootstrap.Modal(document.getElementById('approveModal'));
        modal.show();
    }

    function confirmApproval() {
        const comment = document.getElementById('approvalComment').value;
        const notify = document.getElementById('notifyAuthor').checked;

        console.log('Approving card:', currentCardId, 'Comment:', comment, 'Notify:', notify);

        alert('Card approved successfully!');
        bootstrap.Modal.getInstance(document.getElementById('approveModal')).hide();

        // هنا راح تضيف كود الإرسال للسيرفر
    }

    // Reject with Comment
    function rejectWithComment(cardId) {
        currentCardId = cardId;
        const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
        modal.show();
    }

    function confirmRejection() {
        const reason = document.getElementById('rejectionReason').value;
        const comment = document.getElementById('rejectionComment').value;
        const notify = document.getElementById('notifyAuthorReject').checked;

        if (!reason || !comment.trim()) {
            alert('Please select a reason and provide comments');
            return;
        }

        console.log('Rejecting card:', currentCardId, 'Reason:', reason, 'Comment:', comment, 'Notify:', notify);

        alert('Card rejected.');
        bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();

        // Clear form
        document.getElementById('rejectionReason').value = '';
        document.getElementById('rejectionComment').value = '';

        // هنا راح تضيف كود الإرسال للسيرفر
    }

    // Reset Filters
    function resetFilters() {
        document.getElementById('filterKnowledgeType').value = '';
        document.getElementById('filterDepartment').value = '';
        document.getElementById('filterAuthor').value = '';
        alert('Filters reset!');
    }
</script>

<script>
    // Navigate Calendar
    function navigateCalendar(direction) {
        if (direction === 'prev') {
            alert('Loading previous month...');
        } else if (direction === 'next') {
            alert('Loading next month...');
        } else if (direction === 'today') {
            alert('Jumping to today...');
        }
    }

    // View Event
    function viewEvent(eventId) {
        const modal = new bootstrap.Modal(document.getElementById('viewEventModal'));
        modal.show();
    }

    // Edit Event
    function editEvent(eventId) {
        alert('Opening edit form for event #' + eventId);
        // هنا راح تفتح modal التعديل
    }

    // Delete Event
    function deleteEvent(eventId) {
        if (confirm('Are you sure you want to delete this event?')) {
            alert('Event #' + eventId + ' deleted successfully!');
        }
    }

    // Save Event
    function saveEvent() {
        alert('Event saved successfully!');
        bootstrap.Modal.getInstance(document.getElementById('addEventModal')).hide();
    }

    // Edit Event from View
    function editEventFromView() {
        bootstrap.Modal.getInstance(document.getElementById('viewEventModal')).hide();
        alert('Opening edit form...');
    }

    // Department Calendar Functions
    function switchDepartment() {
        const dept = document.getElementById('departmentSelector').value;
        alert('Switching to ' + dept + ' calendar...');
    }

    function navigateDepCalendar(direction) {
        if (direction === 'prev') {
            alert('Loading previous month...');
        } else if (direction === 'next') {
            alert('Loading next month...');
        } else if (direction === 'today') {
            alert('Jumping to today...');
        }
    }

    function viewDeptEvent(eventId) {
        const modal = new bootstrap.Modal(document.getElementById('viewDeptEventModal'));
        modal.show();
    }

    function viewDepartmentCalendar(dept) {
        document.getElementById('departmentSelector').value = dept;
        switchDepartment();
    }
</script>

<script>
    // Toggle Schedule Fields
    function toggleSchedule() {
        const pubType = document.getElementById('publicationType').value;
        const scheduleDate = document.getElementById('scheduleDate');
        const scheduleTime = document.getElementById('scheduleTime');

        if (pubType === 'schedule') {
            scheduleDate.style.display = 'block';
            scheduleTime.style.display = 'block';
        } else {
            scheduleDate.style.display = 'none';
            scheduleTime.style.display = 'none';
        }
    }

    // Create News
    function createNews() {
        alert('News created and published successfully!');
        bootstrap.Modal.getInstance(document.getElementById('createNewsModal')).hide();
    }

    // Save Draft
    function saveDraft() {
        alert('News saved as draft!');
        bootstrap.Modal.getInstance(document.getElementById('createNewsModal')).hide();
    }

    // View News
    function viewNews(newsId) {
        const modal = new bootstrap.Modal(document.getElementById('viewNewsModal'));
        modal.show();
    }

    // Edit News
    function editNews(newsId) {
        const modal = new bootstrap.Modal(document.getElementById('editNewsModal'));
        modal.show();
    }

    // Update News
    function updateNews() {
        alert('News updated successfully!');
        bootstrap.Modal.getInstance(document.getElementById('editNewsModal')).hide();
    }

    // Delete News
    function deleteNews(newsId) {
        if (confirm('Are you sure you want to delete this news article?')) {
            alert('News article deleted successfully!');
        }
    }

    // Unpublish News
    function unpublishNews(newsId) {
        if (confirm('Unpublish this news article?')) {
            alert('News article unpublished!');
        }
    }

    // Publish Now
    function publishNow(newsId) {
        if (confirm('Publish this news article immediately?')) {
            alert('News article published!');
        }
    }

    // Publish News (from draft)
    function publishNews(newsId) {
        const modal = new bootstrap.Modal(document.getElementById('editNewsModal'));
        modal.show();
    }

    // Edit from View
    function editNewsFromView() {
        bootstrap.Modal.getInstance(document.getElementById('viewNewsModal')).hide();
        setTimeout(() => {
            const modal = new bootstrap.Modal(document.getElementById('editNewsModal'));
            modal.show();
        }, 300);
    }
</script>


<script>
    // Save Company Info
    function saveCompanyInfo() {
        alert('Company information saved successfully!');
    }

    // Remove Logo
    function removeLogo() {
        if (confirm('Are you sure you want to remove the company logo?')) {
            alert('Logo removed successfully!');
        }
    }

    // Save Regional Settings
    function saveRegionalSettings() {
        alert('Regional settings saved successfully!');
    }

    // Save System Preferences
    function saveSystemPreferences() {
        alert('System preferences saved successfully!');
    }

    // Save Notification Settings
    function saveNotificationSettings() {
        alert('Notification settings saved successfully!');
    }

    // Save Quiet Hours
    function saveQuietHours() {
        alert('Notification schedule saved successfully!');
    }
</script>


<script>
    // Save Personal Info
    function savePersonalInfo() {
        alert('Personal information saved successfully!');
    }

    // Preview Avatar
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    // Save Avatar
    function saveAvatar() {
        alert('Profile picture updated successfully!');
        bootstrap.Modal.getInstance(document.getElementById('changeAvatarModal')).hide();
    }

    // Change Password
    function changePassword() {
        alert('Password changed successfully! Please login again.');
        bootstrap.Modal.getInstance(document.getElementById('changePasswordModal')).hide();
    }

    // Enable 2FA
    function enable2FA() {
        alert('Opening 2FA setup wizard...');
    }

    // Remove Session
    function removeSession(sessionId) {
        if (confirm('Remove this session?')) {
            alert('Session removed successfully!');
        }
    }

    // Remove All Sessions
    function removeAllSessions() {
        if (confirm('This will log you out from all other devices. Continue?')) {
            alert('All other sessions removed successfully!');
        }
    }

    // Download Data
    function downloadData() {
        alert('Preparing your data for download...');
    }

    // Confirm Logout
    function confirmLogout() {
        const modal = new bootstrap.Modal(document.getElementById('logoutModal'));
        modal.show();
    }

    // Logout
    function logout() {
        alert('Logging out...');
        // هنا راح تضيف كود تسجيل الخروج الفعلي
        window.location.href = '/login';
    }
</script>


@yield('js')


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif
