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
        <!-- Page Header -->
        <div class="page-header-knowledge">
            <div class="header-content-knowledge">
                <div>
                    <h1><i class="fas fa-plus-circle me-3"></i>Share Your Knowledge</h1>
                    <p>Help your team learn from your experience and expertise</p>
                </div>
            </div>
        </div>

        <!-- Knowledge Type Selection (Step 1) -->
        <div id="typeSelectionStep" class="knowledge-step active">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="content-card">
                        <div class="card-header text-center">
                            <h3 class="mb-2">Choose Knowledge Type</h3>
                            <p class="text-muted mb-0">Select the category that best fits what you want to share</p>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Onboarding Knowledge -->
                                <div class="col-md-6">
                                    <div class="knowledge-type-card" onclick="selectKnowledgeType('onboarding')">
                                        <div class="type-card-header">
                                            <div class="type-card-icon onboarding-gradient">
                                                <i class="fas fa-graduation-cap"></i>
                                            </div>
                                            <h4>Onboarding Knowledge</h4>
                                        </div>
                                        <p class="type-card-description">
                                            Share what you wish you knew when you first started. Help new team members get
                                            up to speed faster with practical tips and essential information.
                                        </p>
                                        <div class="type-card-examples">
                                            <strong>Examples:</strong>
                                            <ul>
                                                <li>First week survival guide</li>
                                                <li>Essential tools and setup</li>
                                                <li>Common beginner questions</li>
                                            </ul>
                                        </div>
                                        <button class="btn btn-outline-primary w-100 mt-3">
                                            Select <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Mistakes & Lessons -->
                                <div class="col-md-6">
                                    <div class="knowledge-type-card" onclick="selectKnowledgeType('mistakes')">
                                        <div class="type-card-header">
                                            <div class="type-card-icon mistakes-gradient">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </div>
                                            <h4>Mistakes & Lessons Learned</h4>
                                        </div>
                                        <p class="type-card-description">
                                            Document mistakes you've made so others can avoid them. Share the lessons you
                                            learned and how you resolved the issues.
                                        </p>
                                        <div class="type-card-examples">
                                            <strong>Examples:</strong>
                                            <ul>
                                                <li>Common coding errors</li>
                                                <li>Project pitfalls to avoid</li>
                                                <li>Communication mistakes</li>
                                            </ul>
                                        </div>
                                        <button class="btn btn-outline-warning w-100 mt-3">
                                            Select <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Operational Knowledge -->
                                <div class="col-md-6">
                                    <div class="knowledge-type-card" onclick="selectKnowledgeType('operational')">
                                        <div class="type-card-header">
                                            <div class="type-card-icon operational-gradient">
                                                <i class="fas fa-cogs"></i>
                                            </div>
                                            <h4>Operational Knowledge</h4>
                                        </div>
                                        <p class="type-card-description">
                                            Document specific tasks, processes, and workflows. Make it easy for others to
                                            replicate what you do with detailed step-by-step guides.
                                        </p>
                                        <div class="type-card-examples">
                                            <strong>Examples:</strong>
                                            <ul>
                                                <li>How to deploy applications</li>
                                                <li>Database backup procedures</li>
                                                <li>Client onboarding process</li>
                                            </ul>
                                        </div>
                                        <button class="btn btn-outline-success w-100 mt-3">
                                            Select <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Critical & Strategic -->
                                <div class="col-md-6">
                                    <div class="knowledge-type-card" onclick="selectKnowledgeType('critical')">
                                        <div class="type-card-header">
                                            <div class="type-card-icon critical-gradient">
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <h4>Critical & Strategic Knowledge</h4>
                                        </div>
                                        <p class="type-card-description">
                                            Share career-defining moments, strategic decisions, and important lessons.
                                            Inspire others with stories of growth and achievement.
                                        </p>
                                        <div class="type-card-examples">
                                            <strong>Examples:</strong>
                                            <ul>
                                                <li>How I got promoted</li>
                                                <li>Major project success story</li>
                                                <li>Career turning points</li>
                                            </ul>
                                        </div>
                                        <button class="btn btn-outline-danger w-100 mt-3">
                                            Select <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Knowledge Form (Step 2) -->
        <div id="formStep" class="knowledge-step">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Progress Steps -->
                    <div class="progress-steps mb-4">
                        <div class="step completed">
                            <div class="step-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Choose Type</span>
                        </div>
                        <div class="step-line"></div>
                        <div class="step active">
                            <div class="step-icon">2</div>
                            <span>Fill Details</span>
                        </div>
                        <div class="step-line"></div>
                        <div class="step">
                            <div class="step-icon">3</div>
                            <span>Submit</span>
                        </div>
                    </div>

                    <div class="content-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="mb-2" id="formTitle">Add Knowledge</h3>
                                    <p class="text-muted mb-0" id="formSubtitle">Fill in the details below</p>
                                </div>
                                <button class="btn btn-outline-secondary" onclick="backToTypeSelection()">
                                    <i class="fas fa-arrow-left me-2"></i> Change Type
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="knowledgeForm" method="POST" action="{{ route('knowledge.knowledge.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="type" id="typeInput">
                                <input type="hidden" name="action" id="actionInput" value="submit">

                                <!-- Common Fields -->
                                <div class="mb-4">
                                    <label class="form-label required">Title</label>
                                    <input type="text" name="title" class="form-control form-control-lg"
                                        id="title" placeholder="Give your knowledge card a clear, descriptive title"
                                        required>
                                    <div class="form-text">Keep it concise and searchable (e.g., "Git Workflow Best
                                        Practices")</div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label required">Summary</label>
                                    <textarea class="form-control" id="summary" name="summary" rows="3"
                                        placeholder="Brief overview of what this knowledge covers" required></textarea>
                                    <div class="form-text">2-3 sentences that give readers a quick idea of the content
                                    </div>
                                </div>

                                <!-- Dynamic Fields Based on Type -->
                                <div id="dynamicFields"></div>

                                <!-- Tags -->
                                <div class="mb-4">
                                    <label class="form-label">Tags</label>
                                    <input type="text" name="tags" class="form-control" id="tags"
                                        placeholder="e.g., git, workflow, best-practices (comma-separated)">
                                    <div class="form-text">Add keywords to make your knowledge easier to find</div>
                                </div>

                                <!-- Attachments -->
                                <div class="mb-4">
                                    <label class="form-label">Attachments (Optional)</label>
                                    <div class="file-upload-area" onclick="document.getElementById('fileInput').click()">
                                        <i class="fas fa-cloud-upload-alt fa-3x mb-3 text-muted"></i>
                                        <p>Click to upload files or drag and drop</p>
                                        <small class="text-muted">Supported: PDF, DOC, Images (Max 10MB)</small>
                                        <input type="file" name="attachments[]" id="fileInput" multiple hidden>
                                    </div>
                                    <div id="fileList" class="mt-3"></div>
                                </div>

                                <!-- Form Actions -->
                                <div class="form-actions">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="backToTypeSelection()">
                                        <i class="fas fa-times me-2"></i> Cancel
                                    </button>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-primary" onclick="submitAsDraft()">
                                            <i class="fas fa-save me-2"></i> Save as Draft
                                        </button>

                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-paper-plane me-2"></i> Submit for Approval
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message (Step 3) -->
        <div id="successStep" class="knowledge-step">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="success-message">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2>Knowledge Card Submitted!</h2>
                        <p>Your knowledge card has been sent for review. You'll be notified once it's approved.</p>

                        <div class="success-details">
                            <div class="detail-item">
                                <i class="fas fa-file-alt"></i>
                                <div>
                                    <strong>Card Title:</strong>
                                    <span id="submittedTitle"></span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-tag"></i>
                                <div>
                                    <strong>Type:</strong>
                                    <span id="submittedType"></span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <strong>Status:</strong>
                                    <span class="badge bg-warning">Pending Review</span>
                                </div>
                            </div>
                        </div>

                        <div class="success-actions">
                            <button class="btn btn-primary btn-lg" onclick="addAnotherCard()">
                                <i class="fas fa-plus me-2"></i> Add Another Card
                            </button>
                            <button class="btn btn-outline-primary" onclick="goToDashboard()">
                                <i class="fas fa-home me-2"></i> Back to Dashboard
                            </button>
                            <button class="btn btn-outline-secondary" onclick="viewPending()">
                                <i class="fas fa-list me-2"></i> View Pending Cards
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Add Knowledge Page JavaScript

        let selectedType = '';
        let uploadedFiles = [];


        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            initializeFileUpload();
            initializeForm();
        });

        // Select Knowledge Type
        function selectKnowledgeType(type) {
            document.getElementById('typeInput').value = type;

            selectedType = type;

            // Update form title and subtitle
            const titles = {
                onboarding: {
                    title: 'Add Onboarding Knowledge',
                    subtitle: 'Help new team members get started faster'
                },
                mistakes: {
                    title: 'Share Mistakes & Lessons Learned',
                    subtitle: 'Help others avoid the same mistakes'
                },
                operational: {
                    title: 'Document Operational Knowledge',
                    subtitle: 'Share how to perform specific tasks'
                },
                critical: {
                    title: 'Share Critical & Strategic Knowledge',
                    subtitle: 'Inspire others with your experience'
                }
            };

            document.getElementById('formTitle').textContent = titles[type].title;
            document.getElementById('formSubtitle').textContent = titles[type].subtitle;

            // Load dynamic fields
            loadDynamicFields(type);

            // Show form step
            showStep('formStep');

            // Scroll to top
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Load Dynamic Fields Based on Type
        function loadDynamicFields(type) {
            const dynamicFieldsContainer = document.getElementById('dynamicFields');
            let fieldsHTML = '';

            switch (type) {
                case 'onboarding':
                    fieldsHTML = `
                    <div class="field-section">
                        <h5><i class="fas fa-lightbulb"></i> What You Wish You Knew</h5>
                        <div class="mb-3">
                            <label class="form-label required">Main Content</label>
                            <textarea class="form-control" name="content" rows="6" placeholder="Share the key things you wish you knew when you started. Be specific and practical." required></textarea>
                            <div class="form-text">Write in a friendly, conversational tone</div>
                        </div>
                    </div>
                    <div class="field-section">
                        <h5><i class="fas fa-clock"></i> Timeline</h5>
                        <div class="mb-3">
                        <label class="form-label">When is this most useful?</label>
                        <select class="form-select" name="extra[timeline]">
                            <option value="">Select timeframe</option>
                            <option value="first-day">First Day</option>
                            <option value="first-week">First Week</option>
                            <option value="first-month">First Month</option>
                            <option value="first-quarter">First 3 Months</option>
                        </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Key Takeaways (Optional)</label>
                        <textarea class="form-control"  placeholder="List 3-5 main points or tips" name="extra[key_takeaways]" rows="4"></textarea>
                    </div>`;
                    break;

                case 'mistakes':
                    fieldsHTML = `
                        <div class="field-section">
                            <h5><i class="fas fa-exclamation-circle"></i> The Mistake</h5>
                            <div class="mb-3">
                            <label class="form-label required">What happened?</label>
                            <textarea class="form-control" name="extra[mistake]" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                            <label class="form-label required">Impact Level</label>
                            <select class="form-select" name="extra[impact_level]" required>
                                <option value="">Select impact</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                            </div>
                        </div>

                        <div class="field-section">
                            <h5><i class="fas fa-tools"></i> The Solution</h5>
                            <textarea class="form-control" placeholder="Explain the solution and steps taken to resolve the issue" name="extra[solution]" rows="4" required></textarea>
                        </div>

                        <div class="field-section">
                            <h5><i class="fas fa-graduation-cap"></i> Lessons Learned</h5>
                            <textarea class="form-control" placeholder="Share the key lessons and how others can avoid this mistake" name="extra[lessons]" rows="4" required></textarea>
                        </div>
                        `;

                    break;

                case 'operational':
                    fieldsHTML = `
                        <div class="field-section">
                            <h5><i class="fas fa-tasks"></i> The Task</h5>
                            <div class="mb-3">
                            <label class="form-label required">Task name</label>
                            <input type="text" class="form-control" placeholder="e.g., Deploying to Production, Database Backup" name="extra[task_name]" required>
                            </div>
                            <div class="mb-3">
                            <label class="form-label">Frequency</label>
                            <select class="form-select" name="extra[frequency]">
                                <option value="">Select</option>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="as-needed">As Needed</option>
                            </select>
                            </div>
                        </div>
                        <div class="field-section">
                            <h5><i class="fas fa-list-ol"></i> Step-by-Step Guide</h5>
                            <div class="mb-3">
                                <label class="form-label required">Detailed Steps</label>
                                <textarea class="form-control" name="extra[steps]" rows="8" placeholder="Write clear, numbered steps:
                                1. First step...
                                2. Second step...
                                3. Third step..." required></textarea>
                                <div class="form-text">Be as detailed as possible - assume the reader has never done this before</div>
                            </div>
                        </div>
                        <div class="field-section">
                            <h5><i class="fas fa-wrench"></i> Tools & Resources</h5>
                            <div class="mb-3">
                            <label class="form-label">Required Tools</label>
                            <input type="text" class="form-control" placeholder="e.g., Git, Docker, AWS CLI (comma-separated)" name="extra[tools]">
                            </div>
                            <div class="mb-3">
                            <label class="form-label">Helpful Links</label>
                            <textarea class="form-control" name="extra[links]" placeholder="Add any relevant documentation links or resources" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Common Issues & Tips</label>
                            <textarea class="form-control"  placeholder="What problems might someone encounter? Any pro tips?" name="extra[common_issues]" rows="4"></textarea>
                        </div>
                        `;

                    break;

                case 'critical':
                    fieldsHTML = `
                        <div class="field-section">
                            <h5><i class="fas fa-star"></i> The Story</h5>
                            <textarea class="form-control" placeholder="Tell your story - what was the situation, what did you do, and what was the outcome?" name="extra[story]" rows="6" required></textarea>

                            <div class="mb-3 mt-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="extra[category]">
                                <option value="">Select</option>
                                <option value="promotion">Career Promotion</option>
                                <option value="project">Major Project</option>
                                <option value="decision">Strategic Decision</option>
                                <option value="challenge">Overcoming Challenge</option>
                                <option value="other">Other</option>
                            </select>
                            </div>
                        </div>

                        <div class="field-section">
                            <h5><i class="fas fa-key"></i> Key Success Factors</h5>
                            <textarea class="form-control" name="extra[success_factors]" rows="4" required>What made it successful?</textarea>
                        </div>

                        <div class="field-section">
                            <h5><i class="fas fa-lightbulb"></i> Advice & Insights</h5>
                            <textarea class="form-control"  name="extra[advice]" rows="4" required>What advice would you give?</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Skills Developed</label>
                            <input type="text" class="form-control" placeholder="e.g., Leadership, Problem Solving, Communication (comma-separated)" name="extra[skills]">
                        </div>
                        `;

                    break;
            }

            dynamicFieldsContainer.innerHTML = fieldsHTML;
        }

        function submitAsDraft() {
            document.getElementById('actionInput').value = 'draft';
            document.getElementById('knowledgeForm').submit();
        }

        function submitForApproval() {
            document.getElementById('actionInput').value = 'submit';
        }

        // Back to Type Selection
        function backToTypeSelection() {
            selectedType = '';
            uploadedFiles = [];
            document.getElementById('fileList').innerHTML = '';
            document.getElementById('knowledgeForm').reset();
            showStep('typeSelectionStep');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Show Step
        function showStep(stepId) {
            document.querySelectorAll('.knowledge-step').forEach(step => {
                step.classList.remove('active');
            });
            document.getElementById(stepId).classList.add('active');
        }

        function syncFilesToInput() {
            const fileInput = document.getElementById('fileInput');
            const dt = new DataTransfer();

            uploadedFiles.forEach(file => dt.items.add(file));

            fileInput.files = dt.files; // ✅ الآن Laravel رح يستقبلها
        }

        // File Upload Handling
        function initializeFileUpload() {
            const fileInput = document.getElementById('fileInput');
            const fileList = document.getElementById('fileList');

            fileInput.addEventListener('change', function(e) {
                const files = Array.from(e.target.files);
                files.forEach(file => addFile(file));
                // fileInput.value = ''; // Reset input
            });

            // Drag and drop
            const uploadArea = document.querySelector('.file-upload-area');

            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.style.borderColor = 'var(--accent-color)';
                uploadArea.style.background = 'rgba(71, 178, 228, 0.05)';
            });

            uploadArea.addEventListener('dragleave', (e) => {
                e.preventDefault();
                uploadArea.style.borderColor = '#dee2e6';
                uploadArea.style.background = 'transparent';
            });

            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.style.borderColor = '#dee2e6';
                uploadArea.style.background = 'transparent';

                const files = Array.from(e.dataTransfer.files);
                files.forEach(file => addFile(file));
            });
        }

        // Add File
        function addFile(file) {
            if (file.size > 10 * 1024 * 1024) {
                alert('File size must be less than 10MB');
                return;
            }

            uploadedFiles.push(file);
            syncFilesToInput(); // ✅ مهم
            displayFiles();
        }


        // Display Files
        function displayFiles() {
            const fileList = document.getElementById('fileList');
            fileList.innerHTML = '';

            uploadedFiles.forEach((file, index) => {
                const fileItem = document.createElement('div');
                fileItem.className = 'file-item';
                fileItem.innerHTML = `
            <div class="file-info">
                <div class="file-icon">
                    <i class="fas fa-file-${getFileIcon(file.name)}"></i>
                </div>
                <div class="file-details">
                    <h6>${file.name}</h6>
                    <small>${formatFileSize(file.size)}</small>
                </div>
            </div>
            <div class="file-remove" onclick="removeFile(${index})">
                <i class="fas fa-times"></i>
            </div>
        `;
                fileList.appendChild(fileItem);
            });
        }

        // Remove File
        function removeFile(index) {
            uploadedFiles.splice(index, 1);
            syncFilesToInput(); // ✅ مهم
            displayFiles();
        }

        // Get File Icon
        function getFileIcon(filename) {
            const ext = filename.split('.').pop().toLowerCase();
            const icons = {
                'pdf': 'pdf',
                'doc': 'word',
                'docx': 'word',
                'xls': 'excel',
                'xlsx': 'excel',
                'jpg': 'image',
                'jpeg': 'image',
                'png': 'image',
                'gif': 'image'
            };
            return icons[ext] || 'alt';
        }

        // Format File Size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        // Initialize Form
        function initializeForm() {
            const form = document.getElementById('knowledgeForm');

            form.addEventListener('submit', function(e) {

                // Get form data
                const formData = {
                    type: selectedType,
                    title: document.getElementById('title').value,
                    summary: document.getElementById('summary').value,
                    tags: document.getElementById('tags').value,
                    files: uploadedFiles,
                    timestamp: new Date().toISOString()
                };

                // Show success step
                displaySuccessMessage(formData);
            });
        }

        // Display Success Message
        function displaySuccessMessage(data) {
            const typeNames = {
                onboarding: 'Onboarding Knowledge',
                mistakes: 'Mistakes & Lessons Learned',
                operational: 'Operational Knowledge',
                critical: 'Critical & Strategic Knowledge'
            };

            document.getElementById('submittedTitle').textContent = data.title;
            document.getElementById('submittedType').textContent = typeNames[data.type];

            // Update progress
            document.querySelectorAll('.step').forEach(step => {
                step.classList.remove('active');
                step.classList.add('completed');
            });

            showStep('successStep');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

            // Simulate notification
            setTimeout(() => {
                showNotification('Your knowledge card has been submitted successfully!', 'success');
            }, 500);
        }

        // Add Another Card
        function addAnotherCard() {
            // Reset everything
            selectedType = '';
            uploadedFiles = [];
            document.getElementById('knowledgeForm').reset();
            document.getElementById('fileList').innerHTML = '';

            // Reset progress
            document.querySelectorAll('.step').forEach((step, index) => {
                step.classList.remove('active', 'completed');
                if (index === 0) step.classList.add('active');
            });

            showStep('typeSelectionStep');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Go to Dashboard
        function goToDashboard() {
            // In real app, navigate to dashboard
            window.location.href = '/employee/dashboard';
        }

        // View Pending
        function viewPending() {
            // In real app, navigate to pending cards page
            window.location.href = '/employee/pending-cards';
        }

        // Show Notification
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
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    `;
            notification.innerHTML = `
        <i class="fas fa-check-circle me-2"></i>
        ${message}
    `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Add animations
        const style = document.createElement('style');
        style.textContent = `
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
`;
        document.head.appendChild(style);
    </script>
@endsection
