<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .attendance-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .status-present { background: #d4edda; color: #155724; }
        .status-absent { background: #f8d7da; color: #721c24; }
        .status-late { background: #fff3cd; color: #856404; }
        .status-half-day { background: #d1ecf1; color: #0c5460; }
        .monthly-stats {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
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
                            <a href="/parent/dashboard" class="nav-link">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/parent/children" class="nav-link">
                                <i class="fas fa-users me-2"></i>My Children
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/parent/attendance" class="nav-link active">
                                <i class="fas fa-calendar-check me-2"></i>Attendance
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/parent/results" class="nav-link">
                                <i class="fas fa-chart-bar me-2"></i>Results
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/parent/fees" class="nav-link">
                                <i class="fas fa-money-bill me-2"></i>Fees
                            </a>
                        </li>
                        <li class="nav-item">
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
                    <h1 class="h2">Attendance Overview</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <select class="form-select" id="studentSelect">
                                <option value="">All Children</option>
                                <?php if (!empty($data['children'])): ?>
                                    <?php foreach ($data['children'] as $child): ?>
                                        <option value="<?php echo $child['id']; ?>"
                                                <?php echo ($data['selected_student'] ?? '') == $child['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($child['first_name'] . ' ' . $child['last_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="btn-group me-2">
                            <input type="month" class="form-control" id="monthSelect"
                                   value="<?php echo $data['selected_month'] ?? date('Y-m'); ?>">
                        </div>
                    </div>
                </div>

                <?php if (!empty($data['children'])): ?>
                    <!-- Monthly Statistics -->
                    <div class="monthly-stats">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="stats-number"><?php echo $data['stats']['total_days'] ?? 0; ?></div>
                                <div>Total Days</div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-number text-success"><?php echo $data['stats']['present_days'] ?? 0; ?></div>
                                <div>Present</div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-number text-danger"><?php echo $data['stats']['absent_days'] ?? 0; ?></div>
                                <div>Absent</div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-number">
                                    <?php echo isset($data['stats']['percentage']) ? number_format($data['stats']['percentage'], 1) : '0.0'; ?>%
                                </div>
                                <div>Attendance</div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Records -->
                    <div class="attendance-card card">
                        <div class="card-header">
                            <h5 class="mb-0">Attendance Records</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($data['attendance'])): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Student</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data['attendance'] as $record): ?>
                                                <tr>
                                                    <td><?php echo date('d/m/Y', strtotime($record['attendance_date'])); ?></td>
                                                    <td>
                                                        <?php echo htmlspecialchars($record['student_name']); ?>
                                                        <br><small class="text-muted">
                                                            <?php echo htmlspecialchars($record['class_name'] . ' - ' . $record['section']); ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <span class="status-badge status-<?php echo $record['status']; ?>">
                                                            <?php echo ucfirst($record['status']); ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($record['remarks'] ?? '-'); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No attendance records found for the selected period.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        No children found in your account. Please contact the school administration to link your children.
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Filter functionality
        document.getElementById('studentSelect').addEventListener('change', function() {
            const studentId = this.value;
            const month = document.getElementById('monthSelect').value;
            updateAttendance(studentId, month);
        });

        document.getElementById('monthSelect').addEventListener('change', function() {
            const month = this.value;
            const studentId = document.getElementById('studentSelect').value;
            updateAttendance(studentId, month);
        });

        function updateAttendance(studentId, month) {
            const url = new URL(window.location);
            if (studentId) url.searchParams.set('student_id', studentId);
            else url.searchParams.delete('student_id');

            if (month) url.searchParams.set('month', month);
            else url.searchParams.delete('month');

            window.location.href = url.toString();
        }
    </script>
</body>
</html>