<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Exam - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .subject-row {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .remove-subject {
            color: #dc3545;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .remove-subject:hover {
            color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" id="sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="/admin/dashboard" class="nav-link">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/students" class="nav-link">
                                <i class="fas fa-user-graduate me-2"></i>Students
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/teachers" class="nav-link">
                                <i class="fas fa-chalkboard-teacher me-2"></i>Teachers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/classes" class="nav-link">
                                <i class="fas fa-school me-2"></i>Classes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/attendance" class="nav-link">
                                <i class="fas fa-calendar-check me-2"></i>Attendance
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/exams" class="nav-link active">
                                <i class="fas fa-pen me-2"></i>Exams
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/fees" class="nav-link">
                                <i class="fas fa-money-bill me-2"></i>Fees
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/events" class="nav-link">
                                <i class="fas fa-calendar me-2"></i>Events
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/gallery" class="nav-link">
                                <i class="fas fa-images me-2"></i>Gallery
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/reports" class="nav-link">
                                <i class="fas fa-chart-bar me-2"></i>Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/settings" class="nav-link">
                                <i class="fas fa-cog me-2"></i>Settings
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a href="/logout" class="nav-link text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Edit Exam</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="/admin/exams" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Exams
                            </a>
                        </div>
                    </div>
                </div>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="form-card card">
                    <div class="card-body">
                        <form method="post" id="examForm">
                            <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="exam_name" class="form-label">Exam Name *</label>
                                        <input type="text" class="form-control" id="exam_name" name="exam_name"
                                               value="<?php echo htmlspecialchars($data['exam']['exam_name']); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="exam_type" class="form-label">Exam Type *</label>
                                        <select class="form-select" id="exam_type" name="exam_type" required>
                                            <option value="">Select Exam Type</option>
                                            <option value="unit_test" <?php echo $data['exam']['exam_type'] === 'unit_test' ? 'selected' : ''; ?>>Unit Test</option>
                                            <option value="mid_term" <?php echo $data['exam']['exam_type'] === 'mid_term' ? 'selected' : ''; ?>>Mid Term</option>
                                            <option value="final" <?php echo $data['exam']['exam_type'] === 'final' ? 'selected' : ''; ?>>Final</option>
                                            <option value="practical" <?php echo $data['exam']['exam_type'] === 'practical' ? 'selected' : ''; ?>>Practical</option>
                                            <option value="oral" <?php echo $data['exam']['exam_type'] === 'oral' ? 'selected' : ''; ?>>Oral</option>
                                        </select>
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
                                                <option value="<?php echo $class['id']; ?>"
                                                        <?php echo $data['exam']['class_id'] === $class['id'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($class['class_name'] . ' - ' . $class['section']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status *</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="draft" <?php echo $data['exam']['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                            <option value="published" <?php echo $data['exam']['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                                            <option value="completed" <?php echo $data['exam']['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                            <option value="cancelled" <?php echo $data['exam']['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date *</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                               value="<?php echo htmlspecialchars($data['exam']['start_date']); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date *</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                               value="<?php echo htmlspecialchars($data['exam']['end_date']); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($data['exam']['description']); ?></textarea>
                            </div>

                            <!-- Exam Subjects Section -->
                            <div class="mt-4">
                                <h5>Exam Subjects</h5>
                                <div id="subjectsContainer">
                                    <?php if (!empty($data['exam_subjects'])): ?>
                                        <?php foreach ($data['exam_subjects'] as $index => $subject): ?>
                                            <div class="subject-row">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <select class="form-select subject-select" name="subjects[<?php echo $index; ?>][subject_id]" required>
                                                            <option value="">Select Subject</option>
                                                            <!-- Subjects will be loaded via AJAX -->
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="date" class="form-control" name="subjects[<?php echo $index; ?>][exam_date]"
                                                               value="<?php echo htmlspecialchars($subject['exam_date']); ?>" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="time" class="form-control" name="subjects[<?php echo $index; ?>][start_time]"
                                                               value="<?php echo htmlspecialchars($subject['start_time']); ?>" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="time" class="form-control" name="subjects[<?php echo $index; ?>][end_time]"
                                                               value="<?php echo htmlspecialchars($subject['end_time']); ?>" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="number" class="form-control" name="subjects[<?php echo $index; ?>][max_marks]"
                                                               value="<?php echo htmlspecialchars($subject['max_marks']); ?>" placeholder="Max Marks" min="1" required>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <i class="fas fa-trash remove-subject" onclick="removeSubject(this)"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <button type="button" class="btn btn-outline-primary" onclick="addSubject()">
                                    <i class="fas fa-plus me-2"></i>Add Subject
                                </button>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Exam
                                </button>
                                <a href="/admin/exams" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let subjectIndex = <?php echo count($data['exam_subjects'] ?? []); ?>;

        function addSubject() {
            const container = document.getElementById('subjectsContainer');
            const subjectRow = document.createElement('div');
            subjectRow.className = 'subject-row';
            subjectRow.innerHTML = `
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-select subject-select" name="subjects[${subjectIndex}][subject_id]" required>
                            <option value="">Select Subject</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control" name="subjects[${subjectIndex}][exam_date]" required>
                    </div>
                    <div class="col-md-2">
                        <input type="time" class="form-control" name="subjects[${subjectIndex}][start_time]" required>
                    </div>
                    <div class="col-md-2">
                        <input type="time" class="form-control" name="subjects[${subjectIndex}][end_time]" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="subjects[${subjectIndex}][max_marks]" placeholder="Max Marks" min="1" required>
                    </div>
                    <div class="col-md-1">
                        <i class="fas fa-trash remove-subject" onclick="removeSubject(this)"></i>
                    </div>
                </div>
            `;
            container.appendChild(subjectRow);
            subjectIndex++;
        }

        function removeSubject(element) {
            element.closest('.subject-row').remove();
        }

        // Load subjects for selected class
        document.getElementById('class_id').addEventListener('change', function() {
            const classId = this.value;
            loadSubjectsForClass(classId);
        });

        function loadSubjectsForClass(classId) {
            if (!classId) return;

            fetch(`/api/subjects?class_id=${classId}`)
                .then(response => response.json())
                .then(subjects => {
                    const subjectSelects = document.querySelectorAll('.subject-select');
                    subjectSelects.forEach(select => {
                        select.innerHTML = '<option value="">Select Subject</option>';
                        subjects.forEach(subject => {
                            const option = document.createElement('option');
                            option.value = subject.id;
                            option.textContent = subject.subject_name;
                            select.appendChild(option);
                        });
                    });
                })
                .catch(error => console.error('Error loading subjects:', error));
        }

        // Load subjects on page load if class is selected
        document.addEventListener('DOMContentLoaded', function() {
            const classId = document.getElementById('class_id').value;
            if (classId) {
                loadSubjectsForClass(classId);
            }
        });
    </script>
</body>
</html>