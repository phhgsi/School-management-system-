<!-- Exams & Results content will be included in the admin layout -->

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-primary">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stats-value"><?php echo count($data['exams']); ?></div>
            <div class="stats-label">Total Exams</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stats-value">
                <?php
                $published = array_filter($data['exams'], fn($e) => $e['status'] === 'published');
                echo count($published);
                ?>
            </div>
            <div class="stats-label">Published</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stats-value">
                <?php
                $upcoming = array_filter($data['exams'], fn($e) => $e['start_date'] > date('Y-m-d') && $e['status'] !== 'cancelled');
                echo count($upcoming);
                ?>
            </div>
            <div class="stats-label">Upcoming</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-info">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stats-value">
                <?php
                $completed = array_filter($data['exams'], fn($e) => $e['status'] === 'completed');
                echo count($completed);
                ?>
            </div>
            <div class="stats-label">Completed</div>
        </div>
    </div>
</div>

<!-- Exams Management -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-clipboard-list me-2"></i>Exams Management
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Exam Name</th>
                                <th>Type</th>
                                <th>Class</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Subjects</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['exams'])): ?>
                                <?php foreach ($data['exams'] as $exam): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($exam['exam_name']); ?></td>
                                        <td>
                                            <span class="badge bg-info">
                                                <?php echo ucfirst(str_replace('_', ' ', $exam['exam_type'])); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($exam['class_name']); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($exam['start_date'])); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($exam['end_date'])); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo getExamStatusBadge($exam['status']); ?>">
                                                <?php echo ucfirst($exam['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" title="View Subjects"
                                                    onclick="viewExamSubjects(<?php echo $exam['id']; ?>)">
                                                <i class="fas fa-book"></i> View
                                            </button>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-primary" title="View Exam"
                                                        onclick="viewExam(<?php echo $exam['id']; ?>)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-warning" title="Edit Exam"
                                                        onclick="editExam(<?php echo $exam['id']; ?>)">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-info" title="Manage Schedule"
                                                        onclick="manageSchedule(<?php echo $exam['id']; ?>)">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </button>
                                                <?php if ($exam['status'] === 'draft'): ?>
                                                    <button type="button" class="btn btn-sm btn-success" title="Publish Exam"
                                                            onclick="publishExam(<?php echo $exam['id']; ?>)">
                                                        <i class="fas fa-upload"></i>
                                                    </button>
                                                <?php endif; ?>
                                                <button type="button" class="btn btn-sm btn-danger" title="Delete Exam"
                                                        onclick="deleteExam(<?php echo $exam['id']; ?>, '<?php echo htmlspecialchars($exam['exam_name']); ?>')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-clipboard-list fa-2x text-muted mb-3"></i>
                                        <p class="text-muted">No exams found. Create your first exam to get started.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Results -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Recent Results
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Student Name</th>
                                <th>Exam</th>
                                <th>Subject</th>
                                <th>Marks Obtained</th>
                                <th>Max Marks</th>
                                <th>Percentage</th>
                                <th>Grade</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // This would typically come from the controller with recent results
                            $recent_results = [];
                            if (empty($recent_results)): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-chart-line fa-2x text-muted mb-3"></i>
                                        <p class="text-muted">No results available yet. Results will appear here once exams are completed.</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recent_results as $result): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($result['student_name']); ?></td>
                                        <td><?php echo htmlspecialchars($result['exam_name']); ?></td>
                                        <td><?php echo htmlspecialchars($result['subject_name']); ?></td>
                                        <td><?php echo htmlspecialchars($result['marks_obtained']); ?></td>
                                        <td><?php echo htmlspecialchars($result['max_marks']); ?></td>
                                        <td>
                                            <?php
                                            $percentage = ($result['marks_obtained'] / $result['max_marks']) * 100;
                                            echo number_format($percentage, 1) . '%';
                                            ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo getGradeBadge($result['grade']); ?>">
                                                <?php echo htmlspecialchars($result['grade']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" title="View Details"
                                                    onclick="viewResultDetails(<?php echo $result['id']; ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Exam Modal -->
<div class="modal fade" id="createExamModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Create New Exam
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/admin/exams/create">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">

                    <div class="mb-3">
                        <label for="exam_name" class="form-label">Exam Name *</label>
                        <input type="text" class="form-control" id="exam_name" name="exam_name"
                               placeholder="e.g., Mid Term Examination 2024" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exam_type" class="form-label">Exam Type *</label>
                                <select class="form-select" id="exam_type" name="exam_type" required>
                                    <option value="">Select Type</option>
                                    <option value="unit_test">Unit Test</option>
                                    <option value="mid_term">Mid Term</option>
                                    <option value="final">Final</option>
                                    <option value="practical">Practical</option>
                                    <option value="oral">Oral</option>
                                </select>
                            </div>
                        </div>
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
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date *</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date *</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                                  placeholder="Optional description or instructions"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Create Exam
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Exam status badge helper function
    function getExamStatusBadge(status) {
        switch (status) {
            case 'published': return 'success';
            case 'draft': return 'warning';
            case 'completed': return 'info';
            case 'cancelled': return 'danger';
            default: return 'secondary';
        }
    }

    // Grade badge helper function
    function getGradeBadge(grade) {
        switch (strtoupper(grade)) {
            case 'A+':
            case 'A': return 'success';
            case 'B+':
            case 'B': return 'primary';
            case 'C+':
            case 'C': return 'warning';
            case 'D':
            case 'F': return 'danger';
            default: return 'secondary';
        }
    }

    // View exam details
    function viewExam(id) {
        window.location.href = '/admin/exams/view/' + id;
    }

    // Edit exam
    function editExam(id) {
        window.location.href = '/admin/exams/edit/' + id;
    }

    // View exam subjects
    function viewExamSubjects(examId) {
        window.location.href = '/admin/exams/' + examId + '/subjects';
    }

    // Manage exam schedule
    function manageSchedule(examId) {
        window.location.href = '/admin/exams/' + examId + '/schedule';
    }

    // Publish exam
    function publishExam(id) {
        if (confirm('Are you sure you want to publish this exam? Students will be able to see it.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/exams/' + id + '/publish';

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = '<?php echo htmlspecialchars($data['csrf_token']); ?>';

            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Delete exam
    function deleteExam(id, name) {
        if (confirm('Are you sure you want to delete exam: ' + name + '? This action cannot be undone.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/exams/delete/' + id;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = '<?php echo htmlspecialchars($data['csrf_token']); ?>';

            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // View result details
    function viewResultDetails(id) {
        window.location.href = '/admin/results/view/' + id;
    }

    // Export results
    function exportResults() {
        window.location.href = '/admin/exams/export-results';
    }

    // Set minimum end date based on start date
    document.getElementById('start_date')?.addEventListener('change', function() {
        const startDate = new Date(this.value);
        const endDateInput = document.getElementById('end_date');
        if (endDateInput) {
            const minEndDate = new Date(startDate);
            minEndDate.setDate(minEndDate.getDate() + 1);
            endDateInput.min = minEndDate.toISOString().split('T')[0];

            if (endDateInput.value && new Date(endDateInput.value) <= startDate) {
                endDateInput.value = minEndDate.toISOString().split('T')[0];
            }
        }
    });

    // Auto-generate exam name based on type and date
    document.getElementById('exam_type')?.addEventListener('change', function() {
        const examName = document.getElementById('exam_name');
        const startDate = document.getElementById('start_date').value;
        const classSelect = document.getElementById('class_id');

        if (examName && !examName.value && startDate && classSelect.value) {
            const classText = classSelect.options[classSelect.selectedIndex].text;
            const typeText = this.options[this.selectedIndex].text;
            const year = new Date(startDate).getFullYear();
            examName.value = `${typeText} - ${classText} (${year})`;
        }
    });
</script>