<!-- Attendance Management content will be included in the admin layout -->

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stats-value">
                <?php
                $today = date('Y-m-d');
                $present_today = array_filter($data['attendance'], fn($a) => $a['attendance_date'] === $today && $a['status'] === 'present');
                echo count($present_today);
                ?>
            </div>
            <div class="stats-label">Present Today</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-danger">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stats-value">
                <?php
                $absent_today = array_filter($data['attendance'], fn($a) => $a['attendance_date'] === $today && $a['status'] === 'absent');
                echo count($absent_today);
                ?>
            </div>
            <div class="stats-label">Absent Today</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stats-value">
                <?php
                $late_today = array_filter($data['attendance'], fn($a) => $a['attendance_date'] === $today && $a['status'] === 'late');
                echo count($late_today);
                ?>
            </div>
            <div class="stats-label">Late Today</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-info">
                <i class="fas fa-percentage"></i>
            </div>
            <div class="stats-value">
                <?php
                $total_today = count(array_filter($data['attendance'], fn($a) => $a['attendance_date'] === $today));
                $present_count = count($present_today);
                $percentage = $total_today > 0 ? round(($present_count / $total_today) * 100, 1) : 0;
                echo $percentage . '%';
                ?>
            </div>
            <div class="stats-label">Attendance Rate</div>
        </div>
    </div>
</div>

<!-- Attendance Overview -->
<div class="row mb-4">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Today's Attendance by Class
                </h5>
            </div>
            <div class="card-body">
                <canvas id="attendanceChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-filter me-2"></i>Quick Filters
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" class="mb-3">
                    <div class="mb-3">
                        <label for="filter_date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="filter_date" name="date"
                               value="<?php echo $_GET['date'] ?? date('Y-m-d'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="filter_class" class="form-label">Class</label>
                        <select class="form-select" id="filter_class" name="class">
                            <option value="">All Classes</option>
                            <?php foreach ($data['classes'] as $class): ?>
                                <option value="<?php echo $class['id']; ?>" <?php echo ($_GET['class'] ?? '') == $class['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($class['class_name'] . ' - ' . $class['section']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>Attendance Records
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Subject</th>
                        <th>Marked By</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['attendance'])): ?>
                        <?php foreach ($data['attendance'] as $attendance): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($attendance['first_name'] . ' ' . $attendance['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($attendance['class_name']); ?></td>
                                <td><?php echo htmlspecialchars($attendance['section']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($attendance['attendance_date'])); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo getAttendanceBadge($attendance['status']); ?>">
                                        <?php echo ucfirst($attendance['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($attendance['subject_name'] ?? 'All Subjects'); ?></td>
                                <td>System</td>
                                <td><?php echo htmlspecialchars($attendance['remarks'] ?? '-'); ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-warning" title="Edit Attendance"
                                                onclick="editAttendance(<?php echo $attendance['id']; ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-info" title="View History"
                                                onclick="viewHistory('<?php echo $attendance['student_id']; ?>')">
                                            <i class="fas fa-history"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="fas fa-calendar-times fa-2x text-muted mb-3"></i>
                                <p class="text-muted">No attendance records found for the selected criteria.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Mark Attendance Modal -->
<div class="modal fade" id="markAttendanceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Mark Attendance
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/admin/attendance/mark">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="attendance_date" class="form-label">Date *</label>
                                <input type="date" class="form-control" id="attendance_date" name="attendance_date"
                                       value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="class_id" class="form-label">Class *</label>
                                <select class="form-select" id="class_id" name="class_id" required onchange="loadStudents()">
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

                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Subject (Optional)</label>
                        <select class="form-select" id="subject_id" name="subject_id">
                            <option value="">All Subjects</option>
                            <!-- Subjects will be loaded dynamically -->
                        </select>
                    </div>

                    <!-- Students Attendance List -->
                    <div id="studentsList">
                        <p class="text-muted">Please select a class to load students.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Attendance badge helper function
    function getAttendanceBadge(status) {
        switch (status) {
            case 'present': return 'success';
            case 'absent': return 'danger';
            case 'late': return 'warning';
            case 'half_day': return 'info';
            default: return 'secondary';
        }
    }

    // Load students when class is selected
    function loadStudents() {
        const classId = document.getElementById('class_id').value;
        const studentsList = document.getElementById('studentsList');

        if (!classId) {
            studentsList.innerHTML = '<p class="text-muted">Please select a class to load students.</p>';
            return;
        }

        // Show loading
        studentsList.innerHTML = '<div class="text-center"><div class="spinner"></div> Loading students...</div>';

        // Fetch students via AJAX
        fetch(`/api/attendance/students?class_id=${classId}&date=${document.getElementById('attendance_date').value}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    studentsList.innerHTML = '<p class="text-danger">' + data.error + '</p>';
                    return;
                }

                let html = '<div class="mb-3"><label class="form-label">Mark Attendance for Students:</label></div>';
                html += '<div class="table-responsive"><table class="table table-sm"><thead><tr><th>Student Name</th><th>Roll No.</th><th>Present</th><th>Absent</th><th>Late</th><th>Remarks</th></tr></thead><tbody>';

                data.forEach(student => {
                    const currentStatus = student.current_status || 'present';
                    html += `
                        <tr>
                            <td>${student.name}</td>
                            <td>${student.roll_number}</td>
                            <td><input type="radio" name="attendance[${student.id}]" value="present" ${currentStatus === 'present' ? 'checked' : ''}></td>
                            <td><input type="radio" name="attendance[${student.id}]" value="absent" ${currentStatus === 'absent' ? 'checked' : ''}></td>
                            <td><input type="radio" name="attendance[${student.id}]" value="late" ${currentStatus === 'late' ? 'checked' : ''}></td>
                            <td><input type="text" name="remarks[${student.id}]" class="form-control form-control-sm" placeholder="Optional remarks" value="${student.current_remarks || ''}"></td>
                        </tr>
                    `;
                });

                html += '</tbody></table></div>';
                studentsList.innerHTML = html;
            })
            .catch(error => {
                studentsList.innerHTML = '<p class="text-danger">Error loading students. Please try again.</p>';
                console.error('Error:', error);
            });
    }

    // Edit attendance
    function editAttendance(id) {
        window.location.href = '/admin/attendance/edit/' + id;
    }

    // View attendance history
    function viewHistory(studentId) {
        window.location.href = '/admin/attendance/history/' + studentId;
    }

    // Export attendance report
    function exportAttendance() {
        const params = new URLSearchParams({
            date: document.getElementById('filter_date').value,
            class: document.getElementById('filter_class').value
        });
        window.location.href = '/admin/attendance/export?' + params.toString();
    }

    // Attendance Chart
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    const attendanceChart = new Chart(attendanceCtx, {
        type: 'doughnut',
        data: {
            labels: ['Present', 'Absent', 'Late'],
            datasets: [{
                data: [
                    <?php echo count($present_today); ?>,
                    <?php echo count($absent_today); ?>,
                    <?php echo count($late_today); ?>
                ],
                backgroundColor: [
                    '#28a745',
                    '#dc3545',
                    '#ffc107'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Auto-submit filter form on change
    document.getElementById('filter_date')?.addEventListener('change', function() {
        this.closest('form').submit();
    });

    document.getElementById('filter_class')?.addEventListener('change', function() {
        this.closest('form').submit();
    });
</script>