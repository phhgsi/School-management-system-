<!-- Classes & Subjects content will be included in the admin layout -->

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-primary">
                <i class="fas fa-school"></i>
            </div>
            <div class="stats-value"><?php echo count($data['classes']); ?></div>
            <div class="stats-label">Total Classes</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stats-value">
                <?php
                $active = array_filter($data['classes'], fn($c) => $c['status'] === 'active');
                echo count($active);
                ?>
            </div>
            <div class="stats-label">Active Classes</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-info">
                <i class="fas fa-book"></i>
            </div>
            <div class="stats-value">
                <?php
                // This would typically come from a subjects query
                echo '25+';
                ?>
            </div>
            <div class="stats-label">Total Subjects</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-warning">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-value">
                <?php
                // Calculate total students across all classes
                $total_students = 0;
                foreach ($data['classes'] as $class) {
                    $total_students += $class['student_count'] ?? 0;
                }
                echo $total_students;
                ?>
            </div>
            <div class="stats-label">Total Students</div>
        </div>
    </div>
</div>

<!-- Classes Management -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-school me-2"></i>Classes Management
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Class Name</th>
                                <th>Section</th>
                                <th>Class Teacher</th>
                                <th>Room Number</th>
                                <th>Capacity</th>
                                <th>Students</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['classes'])): ?>
                                <?php foreach ($data['classes'] as $class): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($class['class_name']); ?></td>
                                        <td><?php echo htmlspecialchars($class['section']); ?></td>
                                        <td>
                                            <?php if (!empty($class['class_teacher_name'])): ?>
                                                <?php echo htmlspecialchars($class['class_teacher_name']); ?>
                                            <?php else: ?>
                                                <span class="text-muted">Not Assigned</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($class['room_number'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($class['capacity']); ?></td>
                                        <td>
                                            <span class="badge bg-info">
                                                <?php echo htmlspecialchars($class['student_count'] ?? 0); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo $class['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                                <?php echo ucfirst($class['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-primary" title="View Class"
                                                        onclick="viewClass(<?php echo $class['id']; ?>)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-warning" title="Edit Class"
                                                        onclick="editClass(<?php echo $class['id']; ?>)">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-info" title="Manage Subjects"
                                                        onclick="manageSubjects(<?php echo $class['id']; ?>)">
                                                    <i class="fas fa-book"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-success" title="View Students"
                                                        onclick="viewStudents(<?php echo $class['id']; ?>)">
                                                    <i class="fas fa-users"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-school fa-2x text-muted mb-3"></i>
                                        <p class="text-muted">No classes found. Add your first class to get started.</p>
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

<!-- Subjects Management -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-book me-2"></i>Subjects Management
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Subject Name</th>
                                <th>Subject Code</th>
                                <th>Class</th>
                                <th>Teacher</th>
                                <th>Max Marks</th>
                                <th>Pass Marks</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['subjects'])): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-book fa-2x text-muted mb-3"></i>
                                        <p class="text-muted">No subjects found. Add subjects to classes to get started.</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($data['subjects'] as $subject): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                                        <td><?php echo htmlspecialchars($subject['subject_code']); ?></td>
                                        <td><?php echo htmlspecialchars($subject['class_name'] . ' - ' . $subject['class_section']); ?></td>
                                        <td><?php echo htmlspecialchars($subject['teacher_name'] ?? 'Not Assigned'); ?></td>
                                        <td><?php echo htmlspecialchars($subject['max_marks']); ?></td>
                                        <td><?php echo htmlspecialchars($subject['pass_marks']); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $subject['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                                <?php echo ucfirst($subject['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-warning" title="Edit Subject"
                                                        onclick="editSubject(<?php echo $subject['id']; ?>)">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-info" title="Assign Teacher"
                                                        onclick="assignTeacher(<?php echo $subject['id']; ?>)">
                                                    <i class="fas fa-user-plus"></i>
                                                </button>
                                            </div>
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

<!-- Add Class Modal -->
<div class="modal fade" id="addClassModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Add New Class
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/admin/classes/add">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">

                    <div class="mb-3">
                        <label for="class_name" class="form-label">Class Name *</label>
                        <select class="form-select" id="class_name" name="class_name" required>
                            <option value="">Select Class</option>
                            <option value="Nursery">Nursery</option>
                            <option value="LKG">LKG</option>
                            <option value="UKG">UKG</option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                            <option value="V">V</option>
                            <option value="VI">VI</option>
                            <option value="VII">VII</option>
                            <option value="VIII">VIII</option>
                            <option value="IX">IX</option>
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="section" class="form-label">Section *</label>
                        <input type="text" class="form-control" id="section" name="section"
                               placeholder="e.g., A, B, C" maxlength="10" required>
                    </div>

                    <div class="mb-3">
                        <label for="class_teacher_id" class="form-label">Class Teacher</label>
                        <select class="form-select" id="class_teacher_id" name="class_teacher_id">
                            <option value="">Select Class Teacher</option>
                            <?php foreach ($data['teachers'] as $teacher): ?>
                                <option value="<?php echo $teacher['id']; ?>">
                                    <?php echo htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name'] . ' (' . $teacher['designation'] . ')'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="room_number" class="form-label">Room Number</label>
                                <input type="text" class="form-control" id="room_number" name="room_number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Capacity *</label>
                                <input type="number" class="form-control" id="capacity" name="capacity"
                                       min="1" value="30" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Add Class
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Subject Modal -->
<div class="modal fade" id="addSubjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Add New Subject
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/admin/subjects/add">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">

                    <div class="mb-3">
                        <label for="subject_name" class="form-label">Subject Name *</label>
                        <input type="text" class="form-control" id="subject_name" name="subject_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="subject_code" class="form-label">Subject Code *</label>
                        <input type="text" class="form-control" id="subject_code" name="subject_code"
                               maxlength="20" required>
                    </div>

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

                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Assigned Teacher</label>
                        <select class="form-select" id="teacher_id" name="teacher_id">
                            <option value="">Select Teacher</option>
                            <?php foreach ($data['teachers'] as $teacher): ?>
                                <option value="<?php echo $teacher['id']; ?>">
                                    <?php echo htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name'] . ' (' . $teacher['department'] . ')'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_marks" class="form-label">Max Marks *</label>
                                <input type="number" class="form-control" id="max_marks" name="max_marks"
                                       min="1" max="100" value="100" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pass_marks" class="form-label">Pass Marks *</label>
                                <input type="number" class="form-control" id="pass_marks" name="pass_marks"
                                       min="1" max="100" value="33" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Add Subject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // View class details
    function viewClass(id) {
        window.location.href = '/admin/classes/view/' + id;
    }

    // Edit class
    function editClass(id) {
        window.location.href = '/admin/classes/edit/' + id;
    }

    // Manage subjects for a class
    function manageSubjects(classId) {
        window.location.href = '/admin/classes/' + classId + '/subjects';
    }

    // View students in a class
    function viewStudents(classId) {
        window.location.href = '/admin/classes/' + classId + '/students';
    }

    // Edit subject
    function editSubject(id) {
        window.location.href = '/admin/subjects/edit/' + id;
    }

    // Assign teacher to subject
    function assignTeacher(subjectId) {
        window.location.href = '/admin/subjects/' + subjectId + '/assign-teacher';
    }

    // Auto-populate pass marks based on max marks
    document.getElementById('max_marks')?.addEventListener('input', function() {
        const maxMarks = parseInt(this.value) || 100;
        const passMarksInput = document.getElementById('pass_marks');
        if (passMarksInput && !passMarksInput.value) {
            passMarksInput.value = Math.ceil(maxMarks * 0.33);
        }
    });
</script>