<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-chalkboard-teacher me-2"></i>Teachers Management
            </h1>
            <p class="page-subtitle">Manage teacher records, assignments, and academic responsibilities</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                <i class="fas fa-plus me-2"></i>Add New Teacher
            </button>
            <button class="btn btn-secondary" onclick="exportTeachers()">
                <i class="fas fa-download me-2"></i>Export
            </button>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-primary">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stats-value"><?php echo count($data['teachers']); ?></div>
            <div class="stats-label">Total Teachers</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stats-value">
                <?php
                $active = array_filter($data['teachers'], fn($t) => $t['status'] === 'active');
                echo count($active);
                ?>
            </div>
            <div class="stats-label">Active Teachers</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-info">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="stats-value">
                <?php
                $departments = array_unique(array_column($data['teachers'], 'department'));
                echo count($departments);
                ?>
            </div>
            <div class="stats-label">Departments</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-warning">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="stats-value">
                <?php
                $this_year = date('Y');
                $joined = array_filter($data['teachers'], fn($t) => date('Y', strtotime($t['date_of_joining'])) == $this_year);
                echo count($joined);
                ?>
            </div>
            <div class="stats-label">New Joiners</div>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" class="form-control" name="search" placeholder="Search teachers..." value="<?php echo $_GET['search'] ?? ''; ?>">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="department">
                    <option value="">All Departments</option>
                    <option value="Science" <?php echo ($_GET['department'] ?? '') == 'Science' ? 'selected' : ''; ?>>Science</option>
                    <option value="Commerce" <?php echo ($_GET['department'] ?? '') == 'Commerce' ? 'selected' : ''; ?>>Commerce</option>
                    <option value="Arts" <?php echo ($_GET['department'] ?? '') == 'Arts' ? 'selected' : ''; ?>>Arts</option>
                    <option value="Mathematics" <?php echo ($_GET['department'] ?? '') == 'Mathematics' ? 'selected' : ''; ?>>Mathematics</option>
                    <option value="English" <?php echo ($_GET['department'] ?? '') == 'English' ? 'selected' : ''; ?>>English</option>
                    <option value="Hindi" <?php echo ($_GET['department'] ?? '') == 'Hindi' ? 'selected' : ''; ?>>Hindi</option>
                    <option value="Physical Education" <?php echo ($_GET['department'] ?? '') == 'Physical Education' ? 'selected' : ''; ?>>Physical Education</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="designation">
                    <option value="">All Designations</option>
                    <option value="Principal" <?php echo ($_GET['designation'] ?? '') == 'Principal' ? 'selected' : ''; ?>>Principal</option>
                    <option value="Vice Principal" <?php echo ($_GET['designation'] ?? '') == 'Vice Principal' ? 'selected' : ''; ?>>Vice Principal</option>
                    <option value="Head Teacher" <?php echo ($_GET['designation'] ?? '') == 'Head Teacher' ? 'selected' : ''; ?>>Head Teacher</option>
                    <option value="Senior Teacher" <?php echo ($_GET['designation'] ?? '') == 'Senior Teacher' ? 'selected' : ''; ?>>Senior Teacher</option>
                    <option value="Teacher" <?php echo ($_GET['designation'] ?? '') == 'Teacher' ? 'selected' : ''; ?>>Teacher</option>
                    <option value="Assistant Teacher" <?php echo ($_GET['designation'] ?? '') == 'Assistant Teacher' ? 'selected' : ''; ?>>Assistant Teacher</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="status">
                    <option value="">All Status</option>
                    <option value="active" <?php echo ($_GET['status'] ?? '') == 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo ($_GET['status'] ?? '') == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    <option value="resigned" <?php echo ($_GET['status'] ?? '') == 'resigned' ? 'selected' : ''; ?>>Resigned</option>
                    <option value="terminated" <?php echo ($_GET['status'] ?? '') == 'terminated' ? 'selected' : ''; ?>>Terminated</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-2"></i>Search
                </button>
                <a href="/admin/teachers" class="btn btn-secondary">
                    <i class="fas fa-redo me-2"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Teachers Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>Teachers List
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Department</th>
                        <th>Qualification</th>
                        <th>Mobile</th>
                        <th>Joining Date</th>
                        <th>Experience</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['teachers'])): ?>
                        <?php foreach ($data['teachers'] as $teacher): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($teacher['employee_id']); ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($teacher['photo'])): ?>
                                            <img src="/backend/public/uploads/teachers/<?php echo htmlspecialchars($teacher['photo']); ?>"
                                                 alt="Photo" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                        <?php endif; ?>
                                        <span><?php echo htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']); ?></span>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($teacher['designation']); ?></td>
                                <td><?php echo htmlspecialchars($teacher['department']); ?></td>
                                <td><?php echo htmlspecialchars($teacher['qualification']); ?></td>
                                <td><?php echo htmlspecialchars($teacher['mobile']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($teacher['date_of_joining'])); ?></td>
                                <td><?php echo htmlspecialchars($teacher['experience_years']); ?> years</td>
                                <td>
                                    <span class="badge bg-<?php echo getStatusBadge($teacher['status']); ?>">
                                        <?php echo ucfirst($teacher['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-primary" title="View Details"
                                                onclick="viewTeacher(<?php echo $teacher['id']; ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" title="Edit Teacher"
                                                onclick="editTeacher(<?php echo $teacher['id']; ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-info" title="View Assignments"
                                                onclick="viewAssignments(<?php echo $teacher['id']; ?>)">
                                            <i class="fas fa-tasks"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" title="Delete Teacher"
                                                onclick="deleteTeacher(<?php echo $teacher['id']; ?>, '<?php echo htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']); ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <i class="fas fa-search fa-2x text-muted mb-3"></i>
                                <p class="text-muted">No teachers found matching your criteria.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Teacher Modal -->
<div class="modal fade" id="addTeacherModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Add New Teacher
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/admin/teachers/add" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="employee_id" class="form-label">Employee ID *</label>
                                <input type="text" class="form-control" id="employee_id" name="employee_id" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="designation" class="form-label">Designation *</label>
                                <select class="form-select" id="designation" name="designation" required>
                                    <option value="">Select Designation</option>
                                    <option value="Principal">Principal</option>
                                    <option value="Vice Principal">Vice Principal</option>
                                    <option value="Head Teacher">Head Teacher</option>
                                    <option value="Senior Teacher">Senior Teacher</option>
                                    <option value="Teacher">Teacher</option>
                                    <option value="Assistant Teacher">Assistant Teacher</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="department" class="form-label">Department *</label>
                                <select class="form-select" id="department" name="department" required>
                                    <option value="">Select Department</option>
                                    <option value="Science">Science</option>
                                    <option value="Commerce">Commerce</option>
                                    <option value="Arts">Arts</option>
                                    <option value="Mathematics">Mathematics</option>
                                    <option value="English">English</option>
                                    <option value="Hindi">Hindi</option>
                                    <option value="Physical Education">Physical Education</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="qualification" class="form-label">Qualification *</label>
                                <input type="text" class="form-control" id="qualification" name="qualification" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile Number *</label>
                                <input type="tel" class="form-control" id="mobile" name="mobile" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth *</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="experience_years" class="form-label">Experience (Years) *</label>
                                <input type="number" class="form-control" id="experience_years" name="experience_years" min="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label">Teacher Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Add Teacher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Status badge helper function
    function getStatusBadge(status) {
        switch (status) {
            case 'active': return 'success';
            case 'inactive': return 'secondary';
            case 'resigned': return 'warning';
            case 'terminated': return 'danger';
            default: return 'secondary';
        }
    }

    // View teacher details
    function viewTeacher(id) {
        window.location.href = '/admin/teachers/view/' + id;
    }

    // Edit teacher
    function editTeacher(id) {
        window.location.href = '/admin/teachers/edit/' + id;
    }

    // View teacher assignments
    function viewAssignments(id) {
        window.location.href = '/admin/teachers/assignments/' + id;
    }

    // Delete teacher
    function deleteTeacher(id, name) {
        if (confirm('Are you sure you want to delete teacher: ' + name + '?')) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/teachers/delete/' + id;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = '<?php echo htmlspecialchars($data['csrf_token']); ?>';

            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Export teachers
    function exportTeachers() {
        const searchParams = new URLSearchParams(window.location.search);
        window.location.href = '/admin/teachers/export?' + searchParams.toString();
    }

    // Auto-submit search form on input change
    document.querySelectorAll('input[name="search"], select[name="department"], select[name="designation"], select[name="status"]').forEach(element => {
        element.addEventListener('change', function() {
            const form = this.closest('form');
            if (this.name === 'search' && this.value.length >= 3) {
                form.submit();
            } else if (this.name !== 'search') {
                form.submit();
            }
        });
    });

    // Search with debounce
    let searchTimeout;
    document.querySelector('input[name="search"]').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (this.value.length >= 3 || this.value.length === 0) {
                this.closest('form').submit();
            }
        }, 500);
    });
</script>