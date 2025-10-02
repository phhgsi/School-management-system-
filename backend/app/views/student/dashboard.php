<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-user-graduate me-2"></i>Student Dashboard
            </h1>
            <p class="page-subtitle">Welcome back, <?php echo htmlspecialchars($this->auth->getUserName()); ?>! Here's your academic overview.</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" onclick="refreshDashboard()">
                <i class="fas fa-sync-alt me-2"></i>Refresh
            </button>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-success">
                <i class="fas fa-percentage"></i>
            </div>
            <div class="stats-value"><?php echo $data['attendance_summary']['percentage']; ?>%</div>
            <div class="stats-label">Attendance This Month</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-primary">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stats-value"><?php echo $data['attendance_summary']['present_days']; ?></div>
            <div class="stats-label">Days Present</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-warning">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stats-value">₹<?php echo number_format($data['fee_status']['total_pending'], 2); ?></div>
            <div class="stats-label">Pending Fees</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-info">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="stats-value"><?php echo htmlspecialchars($data['profile']['class_name']); ?></div>
            <div class="stats-label">My Class</div>
        </div>
    </div>
</div>

<!-- Academic Overview -->
<div class="row mb-4">
    <!-- Attendance Overview -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-check me-2"></i>Attendance Overview
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center mb-3">
                    <div class="col-4">
                        <div class="attendance-stat">
                            <div class="stat-number text-success"><?php echo $data['attendance_summary']['present_days']; ?></div>
                            <div class="stat-label">Present</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="attendance-stat">
                            <div class="stat-number text-danger"><?php echo $data['attendance_summary']['absent_days']; ?></div>
                            <div class="stat-label">Absent</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="attendance-stat">
                            <div class="stat-number text-warning"><?php echo $data['attendance_summary']['late_days']; ?></div>
                            <div class="stat-label">Late</div>
                        </div>
                    </div>
                </div>

                <div class="progress mb-3" style="height: 10px;">
                    <?php
                    $presentPercent = $data['attendance_summary']['total_days'] > 0 ?
                        ($data['attendance_summary']['present_days'] / $data['attendance_summary']['total_days']) * 100 : 0;
                    ?>
                    <div class="progress-bar bg-success" style="width: <?php echo $presentPercent; ?>%">
                        <?php echo round($presentPercent, 1); ?>%
                    </div>
                </div>

                <div class="text-center">
                    <small class="text-muted">
                        Total Days: <?php echo $data['attendance_summary']['total_days']; ?> |
                        Attendance Rate: <?php echo $data['attendance_summary']['percentage']; ?>%
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Fee Status -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-money-bill-wave me-2"></i>Fee Status
                </h5>
            </div>
            <div class="card-body">
                <div class="fee-summary">
                    <div class="row mb-3">
                        <div class="col-6 text-center">
                            <div class="fee-amount text-success">
                                <div class="amount">₹<?php echo number_format($data['fee_status']['total_paid'], 2); ?></div>
                                <div class="label">Paid</div>
                            </div>
                        </div>
                        <div class="col-6 text-center">
                            <div class="fee-amount text-warning">
                                <div class="amount">₹<?php echo number_format($data['fee_status']['total_pending'], 2); ?></div>
                                <div class="label">Pending</div>
                            </div>
                        </div>
                    </div>

                    <?php if ($data['fee_status']['last_payment']): ?>
                        <div class="text-center">
                            <small class="text-muted">
                                Last Payment: <?php echo date('d/m/Y', strtotime($data['fee_status']['last_payment'])); ?>
                            </small>
                        </div>
                    <?php endif; ?>

                    <?php if ($data['fee_status']['total_pending'] > 0): ?>
                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            You have pending fees of ₹<?php echo number_format($data['fee_status']['total_pending'], 2); ?>.
                            Please contact the fee counter for payment.
                        </div>
                    <?php else: ?>
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-circle me-2"></i>
                            All fees are up to date!
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Results and Upcoming Events -->
<div class="row mb-4">
    <!-- Recent Results -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>Recent Results
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($data['recent_results'])): ?>
                    <?php foreach ($data['recent_results'] as $result): ?>
                        <div class="result-item mb-3 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1"><?php echo htmlspecialchars($result['exam_name']); ?></h6>
                                    <p class="mb-1 text-muted">
                                        <i class="fas fa-book me-2"></i>
                                        <?php echo htmlspecialchars($result['subject_name']); ?>
                                    </p>
                                    <p class="mb-1 text-muted">
                                        <i class="fas fa-calendar me-2"></i>
                                        <?php echo date('d/m/Y', strtotime($result['start_date'] ?? '')); ?>
                                    </p>
                                </div>
                                <div class="text-end">
                                    <div class="result-marks">
                                        <div class="marks-obtained text-primary">
                                            <?php echo htmlspecialchars($result['marks_obtained']); ?>/<?php echo htmlspecialchars($result['max_marks'] ?? 100); ?>
                                        </div>
                                        <div class="percentage">
                                            <?php
                                            $percentage = $result['max_marks'] ? ($result['marks_obtained'] / $result['max_marks']) * 100 : 0;
                                            echo round($percentage, 1) . '%';
                                            ?>
                                        </div>
                                        <div class="grade badge bg-<?php echo getGradeBadge($result['grade']); ?>">
                                            <?php echo htmlspecialchars($result['grade']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="text-center mt-3">
                        <a href="/student/results" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-2"></i>View All Results
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-chart-line fa-2x text-muted mb-3"></i>
                        <p class="text-muted">No results available yet. Results will appear here once exams are completed.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Upcoming Events
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($data['upcoming_events'])): ?>
                    <?php foreach ($data['upcoming_events'] as $event): ?>
                        <div class="event-item mb-3 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1"><?php echo htmlspecialchars($event['title']); ?></h6>
                                    <p class="mb-1 text-muted">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        <?php echo htmlspecialchars($event['venue'] ?? 'TBA'); ?>
                                    </p>
                                    <p class="mb-1 text-muted">
                                        <i class="fas fa-clock me-2"></i>
                                        <?php echo date('h:i A', strtotime($event['start_time'] ?? '00:00')); ?> -
                                        <?php echo date('h:i A', strtotime($event['end_time'] ?? '23:59')); ?>
                                    </p>
                                    <span class="badge bg-<?php echo getEventTypeBadge($event['event_type']); ?>">
                                        <?php echo ucfirst($event['event_type']); ?>
                                    </span>
                                </div>
                                <div class="text-end">
                                    <div class="event-date bg-primary text-white p-2 rounded text-center" style="min-width: 60px;">
                                        <div class="fw-bold"><?php echo date('d', strtotime($event['event_date'])); ?></div>
                                        <div class="small"><?php echo date('M', strtotime($event['event_date'])); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-2x text-muted mb-3"></i>
                        <p class="text-muted">No upcoming events scheduled.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="/student/attendance" class="quick-action-btn btn btn-outline-success w-100 text-start p-3">
                            <i class="fas fa-calendar-check fa-2x mb-2"></i>
                            <h6>View Attendance</h6>
                            <p class="text-muted small">Check your attendance records</p>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="/student/results" class="quick-action-btn btn btn-outline-primary w-100 text-start p-3">
                            <i class="fas fa-chart-line fa-2x mb-2"></i>
                            <h6>View Results</h6>
                            <p class="text-muted small">Check your exam results and grades</p>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="/student/fees" class="quick-action-btn btn btn-outline-warning w-100 text-start p-3">
                            <i class="fas fa-money-bill-wave fa-2x mb-2"></i>
                            <h6>Fee Status</h6>
                            <p class="text-muted small">Check your fee payments</p>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="/student/profile" class="quick-action-btn btn btn-outline-info w-100 text-start p-3">
                            <i class="fas fa-user fa-2x mb-2"></i>
                            <h6>My Profile</h6>
                            <p class="text-muted small">View and update your profile</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Academic Progress -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Academic Progress
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Current Academic Year: <?php echo htmlspecialchars(CURRENT_ACADEMIC_YEAR); ?></h6>
                        <div class="academic-info">
                            <div class="info-item mb-2">
                                <span class="label">Class:</span>
                                <span class="value"><?php echo htmlspecialchars($data['profile']['class_name'] . ' - ' . $data['profile']['section']); ?></span>
                            </div>
                            <div class="info-item mb-2">
                                <span class="label">Roll Number:</span>
                                <span class="value"><?php echo htmlspecialchars($data['profile']['roll_number']); ?></span>
                            </div>
                            <div class="info-item mb-2">
                                <span class="label">Scholar Number:</span>
                                <span class="value"><?php echo htmlspecialchars($data['profile']['scholar_number']); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Parent/Guardian Information</h6>
                        <div class="parent-info">
                            <div class="info-item mb-2">
                                <span class="label">Father's Name:</span>
                                <span class="value"><?php echo htmlspecialchars($data['profile']['father_name']); ?></span>
                            </div>
                            <div class="info-item mb-2">
                                <span class="label">Mother's Name:</span>
                                <span class="value"><?php echo htmlspecialchars($data['profile']['mother_name']); ?></span>
                            </div>
                            <div class="info-item mb-2">
                                <span class="label">Contact:</span>
                                <span class="value"><?php echo htmlspecialchars($data['profile']['mobile']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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

    // Event type badge helper function
    function getEventTypeBadge(type) {
        switch (type) {
            case 'academic': return 'primary';
            case 'cultural': return 'success';
            case 'sports': return 'warning';
            case 'other': return 'info';
            default: return 'secondary';
        }
    }

    // Refresh dashboard
    function refreshDashboard() {
        location.reload();
    }

    // Quick action button hover effects
    document.querySelectorAll('.quick-action-btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
        });

        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });

    // Auto refresh every 10 minutes
    setInterval(function() {
        // Update time-sensitive data if needed
        const now = new Date();
        console.log('Dashboard refreshed at:', now.toLocaleTimeString());
    }, 600000);
</script>

<style>
    .stats-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-left: 4px solid var(--primary-color);
        transition: transform 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-2px);
    }

    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-bottom: 1rem;
    }

    .stats-value {
        font-size: 2rem;
        font-weight: 700;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .stats-label {
        color: #6c757d;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .attendance-stat .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .attendance-stat .stat-label {
        font-size: 0.8rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .fee-amount .amount {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .fee-amount .label {
        font-size: 0.8rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .result-item {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        transition: all 0.3s ease;
    }

    .result-item:hover {
        background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    }

    .result-marks {
        text-align: center;
    }

    .marks-obtained {
        font-size: 1.2rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.25rem;
    }

    .percentage {
        font-size: 1rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }

    .grade {
        font-size: 0.9rem;
    }

    .event-item {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        transition: all 0.3s ease;
    }

    .event-item:hover {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .event-date {
        font-size: 0.8rem;
    }

    .info-item .label {
        font-weight: 600;
        color: #495057;
        display: inline-block;
        width: 120px;
    }

    .info-item .value {
        color: #6c757d;
    }

    .quick-action-btn {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .quick-action-btn:hover {
        transform: translateY(-2px);
        border-color: currentColor;
    }
</style>