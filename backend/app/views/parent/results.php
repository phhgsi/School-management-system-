<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Results - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .results-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .exam-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px;
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
        .subject-row {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }
        .subject-row:last-child {
            border-bottom: none;
        }
        .marks-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: bold;
            margin: 0 auto;
        }
        .marks-high { background: #d4edda; color: #155724; }
        .marks-medium { background: #fff3cd; color: #856404; }
        .marks-low { background: #f8d7da; color: #721c24; }
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
                            <a href="/parent/attendance" class="nav-link">
                                <i class="fas fa-calendar-check me-2"></i>Attendance
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/parent/results" class="nav-link active">
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
                    <h1 class="h2">Academic Results</h1>
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
                            <select class="form-select" id="examSelect">
                                <option value="">All Exams</option>
                                <?php if (!empty($data['exams'])): ?>
                                    <?php foreach ($data['exams'] as $exam): ?>
                                        <option value="<?php echo $exam['id']; ?>"
                                                <?php echo ($data['selected_exam'] ?? '') == $exam['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($exam['exam_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <?php if (!empty($data['children'])): ?>
                    <?php if (!empty($data['results'])): ?>
                        <?php foreach ($data['results'] as $examName => $examResults): ?>
                            <div class="exam-card">
                                <h4 class="mb-0"><?php echo htmlspecialchars($examName); ?></h4>
                            </div>

                            <div class="results-card card">
                                <div class="card-body">
                                    <div class="row">
                                        <?php foreach ($examResults as $result): ?>
                                            <div class="col-md-6">
                                                <div class="subject-row d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1"><?php echo htmlspecialchars($result['subject_name']); ?></h6>
                                                        <small class="text-muted">
                                                            Max Marks: <?php echo $result['max_marks']; ?> |
                                                            Pass Marks: <?php echo $result['pass_marks']; ?>
                                                        </small>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="marks-circle <?php
                                                            echo $result['marks_obtained'] >= 80 ? 'marks-high' :
                                                                 ($result['marks_obtained'] >= 60 ? 'marks-medium' : 'marks-low');
                                                        ?>">
                                                            <?php echo $result['marks_obtained']; ?>
                                                        </div>
                                                        <div class="grade-badge grade-<?php echo $result['grade']; ?> mt-1">
                                                            <?php echo $result['grade']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                        <!-- Overall Result -->
                                        <div class="col-12 mt-3 pt-3 border-top">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5>Overall Performance</h5>
                                                    <p class="mb-1"><strong>Total Marks:</strong> <?php echo $examResults[0]['total_marks'] ?? 0; ?>/<?php echo $examResults[0]['max_total'] ?? 0; ?></p>
                                                    <p class="mb-1"><strong>Percentage:</strong> <?php echo number_format($examResults[0]['percentage'] ?? 0, 2); ?>%</p>
                                                </div>
                                                <div class="col-md-6 text-center">
                                                    <div class="marks-circle <?php
                                                        $percentage = $examResults[0]['percentage'] ?? 0;
                                                        echo $percentage >= 80 ? 'marks-high' : ($percentage >= 60 ? 'marks-medium' : 'marks-low');
                                                    ?>">
                                                        <?php echo number_format($percentage, 1); ?>%
                                                    </div>
                                                    <div class="grade-badge grade-<?php echo $examResults[0]['overall_grade'] ?? 'F'; ?> mt-2">
                                                        <?php echo $examResults[0]['overall_grade'] ?? 'F'; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="results-card card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                                <h5>No Results Available</h5>
                                <p class="text-muted">Results will be displayed here once exams are conducted and marks are published.</p>
                            </div>
                        </div>
                    <?php endif; ?>
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
            const examId = document.getElementById('examSelect').value;
            updateResults(studentId, examId);
        });

        document.getElementById('examSelect').addEventListener('change', function() {
            const examId = this.value;
            const studentId = document.getElementById('studentSelect').value;
            updateResults(studentId, examId);
        });

        function updateResults(studentId, examId) {
            const url = new URL(window.location);
            if (studentId) url.searchParams.set('student_id', studentId);
            else url.searchParams.delete('student_id');

            if (examId) url.searchParams.set('exam_id', examId);
            else url.searchParams.delete('exam_id');

            window.location.href = url.toString();
        }
    </script>
</body>
</html>