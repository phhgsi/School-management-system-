<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Results - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .results-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .exam-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .student-result {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .grade-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
        }
        .grade-A+ { background: #28a745; color: white; }
        .grade-A { background: #20c997; color: white; }
        .grade-B+ { background: #17a2b8; color: white; }
        .grade-B { background: #007bff; color: white; }
        .grade-C+ { background: #ffc107; color: #212529; }
        .grade-C { background: #fd7e14; color: white; }
        .grade-D { background: #dc3545; color: white; }
        .grade-F { background: #6c757d; color: white; }
        .marks-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            font-weight: bold;
            margin-right: 10px;
        }
        .marks-high { background: #d4edda; color: #155724; }
        .marks-medium { background: #fff3cd; color: #856404; }
        .marks-low { background: #f8d7da; color: #721c24; }
        .export-btn {
            background: #28a745;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .export-btn:hover {
            background: #218838;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
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
                    <h1 class="h2">Exam Results</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="/admin/exams" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Exams
                            </a>
                            <a href="/admin/exams/results/<?php echo $data['exam']['id']; ?>/export" class="btn btn-success">
                                <i class="fas fa-download me-2"></i>Export Results
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Exam Information -->
                <div class="exam-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="mb-2"><?php echo htmlspecialchars($data['exam']['exam_name']); ?></h3>
                            <p class="mb-1">Class: <?php echo htmlspecialchars($data['exam']['class_name'] . ' - ' . $data['exam']['section']); ?></p>
                            <p class="mb-1">Type: <?php echo ucfirst($data['exam']['exam_type']); ?></p>
                            <p class="mb-0">Duration: <?php echo date('d/m/Y', strtotime($data['exam']['start_date'])); ?> - <?php echo date('d/m/Y', strtotime($data['exam']['end_date'])); ?></p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="exam-stats">
                                <h4><?php echo count($data['results']); ?> Students</h4>
                                <p>Results Published</p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($data['results'])): ?>
                    <!-- Class Performance Summary -->
                    <div class="results-card card">
                        <div class="card-header">
                            <h5 class="mb-0">Class Performance Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <div class="stat-item">
                                        <div class="stat-number"><?php echo $data['summary']['total_students']; ?></div>
                                        <div class="stat-label">Total Students</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-item">
                                        <div class="stat-number text-success"><?php echo $data['summary']['passed_students']; ?></div>
                                        <div class="stat-label">Passed</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-item">
                                        <div class="stat-number text-danger"><?php echo $data['summary']['failed_students']; ?></div>
                                        <div class="stat-label">Failed</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-item">
                                        <div class="stat-number"><?php echo number_format($data['summary']['average_percentage'], 1); ?>%</div>
                                        <div class="stat-label">Average</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Student Results -->
                    <div class="results-card card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Student Results</h5>
                            <div class="btn-group">
                                <button class="btn btn-outline-primary btn-sm" onclick="toggleEnterMarks()">
                                    <i class="fas fa-edit me-2"></i>Enter/Edit Marks
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Roll No</th>
                                            <th>Student Name</th>
                                            <?php foreach ($data['subjects'] as $subject): ?>
                                                <th><?php echo htmlspecialchars($subject['subject_name']); ?></th>
                                            <?php endforeach; ?>
                                            <th>Total</th>
                                            <th>Percentage</th>
                                            <th>Grade</th>
                                            <th>Result</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['results'] as $result): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($result['roll_number']); ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($result['student_name']); ?></strong>
                                                    <br><small class="text-muted"><?php echo htmlspecialchars($result['scholar_number']); ?></small>
                                                </td>
                                                <?php foreach ($data['subjects'] as $subject): ?>
                                                    <td>
                                                        <?php
                                                        $marks = $result['subjects'][$subject['id']] ?? '-';
                                                        if ($marks !== '-'):
                                                        ?>
                                                            <span class="marks-circle <?php
                                                                echo $marks >= 80 ? 'marks-high' : ($marks >= 60 ? 'marks-medium' : 'marks-low');
                                                            ?>">
                                                                <?php echo $marks; ?>
                                                            </span>
                                                        <?php else: ?>
                                                            -
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endforeach; ?>
                                                <td><strong><?php echo htmlspecialchars($result['total_marks'] ?? '-'); ?></strong></td>
                                                <td>
                                                    <strong><?php echo isset($result['percentage']) ? number_format($result['percentage'], 1) . '%' : '-'; ?></strong>
                                                </td>
                                                <td>
                                                    <?php if (isset($result['grade'])): ?>
                                                        <span class="grade-badge grade-<?php echo $result['grade']; ?>">
                                                            <?php echo $result['grade']; ?>
                                                        </span>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (isset($result['result'])): ?>
                                                        <span class="badge bg-<?php echo $result['result'] === 'Pass' ? 'success' : 'danger'; ?>">
                                                            <?php echo $result['result']; ?>
                                                        </span>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Enter Marks Form (Initially Hidden) -->
                    <div id="enterMarksSection" class="results-card card" style="display: none;">
                        <div class="card-header">
                            <h5 class="mb-0">Enter/Edit Student Marks</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="/admin/exams/results/<?php echo $data['exam']['id']; ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Roll No</th>
                                                <th>Student Name</th>
                                                <?php foreach ($data['subjects'] as $subject): ?>
                                                    <th><?php echo htmlspecialchars($subject['subject_name']); ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data['results'] as $result): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($result['roll_number']); ?></td>
                                                    <td><?php echo htmlspecialchars($result['student_name']); ?></td>
                                                    <?php foreach ($data['subjects'] as $subject): ?>
                                                        <td>
                                                            <input type="number"
                                                                   class="form-control form-control-sm"
                                                                   name="results[<?php echo $result['student_id']; ?>][<?php echo $subject['id']; ?>]"
                                                                   value="<?php echo $result['subjects'][$subject['id']] ?? ''; ?>"
                                                                   min="0"
                                                                   max="<?php echo $subject['max_marks']; ?>"
                                                                   placeholder="Marks">
                                                        </td>
                                                    <?php endforeach; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Save Results
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="toggleEnterMarks()">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="results-card card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                            <h5>No Results Available</h5>
                            <p class="text-muted">Results will be displayed here once students are enrolled and marks are entered.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleEnterMarks() {
            const section = document.getElementById('enterMarksSection');
            if (section.style.display === 'none') {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        }
    </script>
</body>
</html>