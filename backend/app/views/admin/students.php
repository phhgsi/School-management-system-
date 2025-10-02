<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-user-graduate me-2"></i>Students Management
            </h1>
            <p class="page-subtitle">Manage student records, admissions, and academic information</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                <i class="fas fa-plus me-2"></i>Add New Student
            </button>
            <button class="btn btn-secondary" onclick="exportStudents()">
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
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stats-value"><?php echo count($data['students']); ?></div>
            <div class="stats-label">Total Students</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stats-value">
                <?php
                $active = array_filter($data['students'], fn($s) => $s['status'] === 'active');
                echo count($active);
                ?>
            </div>
            <div class="stats-label">Active Students</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-info">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="stats-value"><?php echo count($data['classes']); ?></div>
            <div class="stats-label">Total Classes</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-warning">
                <i class="fas fa-calendar-plus"></i>
            </div>
            <div class="stats-value">
                <?php
                $this_year = date('Y');
                $admissions = array_filter($data['students'], fn($s) => date('Y', strtotime($s['admission_date'])) == $this_year);
                echo count($admissions);
                ?>
            </div>
            <div class="stats-label">New Admissions</div>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" class="form-control" name="search" placeholder="Search students..." value="<?php echo $_GET['search'] ?? ''; ?>">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="class">
                    <option value="">All Classes</option>
                    <?php foreach ($data['classes'] as $class): ?>
                        <option value="<?php echo $class['id']; ?>" <?php echo ($_GET['class'] ?? '') == $class['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($class['class_name'] . ' - ' . $class['section']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="status">
                    <option value="">All Status</option>
                    <option value="active" <?php echo ($_GET['status'] ?? '') == 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo ($_GET['status'] ?? '') == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    <option value="transferred" <?php echo ($_GET['status'] ?? '') == 'transferred' ? 'selected' : ''; ?>>Transferred</option>
                    <option value="graduated" <?php echo ($_GET['status'] ?? '') == 'graduated' ? 'selected' : ''; ?>>Graduated</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="gender">
                    <option value="">All Genders</option>
                    <option value="male" <?php echo ($_GET['gender'] ?? '') == 'male' ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo ($_GET['gender'] ?? '') == 'female' ? 'selected' : ''; ?>>Female</option>
                    <option value="other" <?php echo ($_GET['gender'] ?? '') == 'other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-2"></i>Search
                </button>
                <a href="/admin/students" class="btn btn-secondary">
                    <i class="fas fa-redo me-2"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Students Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>Students List
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Scholar No.</th>
                        <th>Admission No.</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Roll No.</th>
                        <th>Father's Name</th>
                        <th>Mobile</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['students'])): ?>
                        <?php foreach ($data['students'] as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['scholar_number']); ?></td>
                                <td><?php echo htmlspecialchars($student['admission_number']); ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($student['photo'])): ?>
                                            <img src="/backend/public/uploads/students/<?php echo htmlspecialchars($student['photo']); ?>"
                                                 alt="Photo" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                        <?php endif; ?>
                                        <span><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></span>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($student['class_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['section']); ?></td>
                                <td><?php echo htmlspecialchars($student['roll_number']); ?></td>
                                <td><?php echo htmlspecialchars($student['father_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['mobile']); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo getStatusBadge($student['status']); ?>">
                                        <?php echo ucfirst($student['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-primary" title="View Details"
                                                onclick="viewStudent(<?php echo $student['id']; ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" title="Edit Student"
                                                onclick="editStudent(<?php echo $student['id']; ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-info" title="View Profile"
                                                onclick="viewProfile(<?php echo $student['id']; ?>)">
                                            <i class="fas fa-user"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" title="Delete Student"
                                                onclick="deleteStudent(<?php echo $student['id']; ?>, '<?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>')">
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
                                <p class="text-muted">No students found matching your criteria.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Add New Student
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/admin/students/add" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="scholar_number" class="form-label">Scholar Number *</label>
                                <input type="text" class="form-control" id="scholar_number" name="scholar_number" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="admission_number" class="form-label">Admission Number *</label>
                                <input type="text" class="form-control" id="admission_number" name="admission_number" required>
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
                                <label for="class_id" class="form-label">Class *</label>
                                <select class="form-select" id="class_id" name="class_id" required>
                                    <option value="">Select Class</option>
                                    <?php foreach ($data['classes'] as $class): ?>
                                        <option value="<?php echo $class['id']; ?>">
                                            <?php echo htmlspecialchars($class['class_name'] . ' - ' . $class['section']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="section" class="form-label">Section *</label>
                                <input type="text" class="form-control" id="section" name="section" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="roll_number" class="form-label">Roll Number *</label>
                                <input type="number" class="form-control" id="roll_number" name="roll_number" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="father_name" class="form-label">Father's Name *</label>
                                <input type="text" class="form-control" id="father_name" name="father_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="mother_name" class="form-label">Mother's Name *</label>
                                <input type="text" class="form-control" id="mother_name" name="mother_name" required>
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

                    <div class="mb-3">
                        <label for="photo" class="form-label">Student Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Add Student
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
            case 'transferred': return 'warning';
            case 'graduated': return 'info';
            default: return 'secondary';
        }
    }

    // View student details
    function viewStudent(id) {
        window.location.href = '/admin/students/view/' + id;
    }

    // Edit student
    function editStudent(id) {
        window.location.href = '/admin/students/edit/' + id;
    }

    // View student profile
    function viewProfile(id) {
        window.location.href = '/admin/students/profile/' + id;
    }

    // Delete student
    function deleteStudent(id, name) {
        if (confirm('Are you sure you want to delete student: ' + name + '?')) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/students/delete/' + id;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = '<?php echo htmlspecialchars($data['csrf_token']); ?>';

            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Export students
    function exportStudents() {
        const searchParams = new URLSearchParams(window.location.search);
        window.location.href = '/admin/students/export?' + searchParams.toString();
    }

    // Auto-submit search form on input change
    document.querySelectorAll('input[name="search"], select[name="class"], select[name="status"], select[name="gender"]').forEach(element => {
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