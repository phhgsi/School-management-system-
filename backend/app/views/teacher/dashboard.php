<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-chalkboard-teacher me-2"></i>Teacher Dashboard
            </h1>
            <p class="page-subtitle">Welcome back, <?php echo htmlspecialchars($this->auth->getUserName()); ?>! Here's your teaching overview.</p>
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
            <div class="stats-icon bg-primary">
                <i class="fas fa-school"></i>
            </div>
            <div class="stats-value"><?php echo $data['workload']['class_count']; ?></div>
            <div class="stats-label">My Classes</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-success">
                <i class="fas fa-book"></i>
            </div>
            <div class="stats-value"><?php echo $data['workload']['subject_count']; ?></div>
            <div class="stats-label">Subjects</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-info">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-value"><?php echo $data['workload']['student_count']; ?></div>
            <div class="stats-label">Total Students</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-warning">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="stats-value"><?php echo count($data['pending_tasks']); ?></div>
            <div class="stats-label">Pending Tasks</div>
        </div>
    </div>
</div>

<!-- Today's Schedule and Pending Tasks -->
<div class="row mb-4">
    <!-- Today's Schedule -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-day me-2"></i>Today's Schedule
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($data['today_schedule'])): ?>
                    <?php foreach ($data['today_schedule'] as $schedule): ?>
                        <div class="schedule-item mb-3 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1"><?php echo htmlspecialchars($schedule['subject_name']); ?></h6>
                                    <p class="mb-1 text-muted">
                                        <i class="fas fa-school me-2"></i>
                                        <?php echo htmlspecialchars($schedule['class_name'] . ' - ' . $schedule['section']); ?>
                                    </p>
                                    <?php if (!empty($schedule['room_number'])): ?>
                                        <p class="mb-1 text-muted">
                                            <i class="fas fa-map-marker-alt me-2"></i>
                                            Room: <?php echo htmlspecialchars($schedule['room_number']); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                                <div class="text-end">
                                    <?php if ($schedule['start_time'] && $schedule['end_time']): ?>
                                        <div class="schedule-time bg-primary text-white p-2 rounded text-center" style="min-width: 80px;">
                                            <div class="fw-bold"><?php echo date('H:i', strtotime($schedule['start_time'])); ?></div>
                                            <div class="small">to</div>
                                            <div class="fw-bold"><?php echo date('H:i', strtotime($schedule['end_time'])); ?></div>
                                        </div>
                                    <?php else: ?>
                                        <div class="schedule-time bg-info text-white p-2 rounded text-center" style="min-width: 80px;">
                                            <div class="fw-bold">All Day</div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-2x text-muted mb-3"></i>
                        <p class="text-muted">No classes scheduled for today.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Pending Tasks -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tasks me-2"></i>Pending Tasks
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($data['pending_tasks'])): ?>
                    <?php foreach ($data['pending_tasks'] as $task): ?>
                        <div class="task-item mb-3 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="fas fa-<?php echo getTaskIcon($task['type']); ?> me-2"></i>
                                        <?php echo htmlspecialchars($task['title']); ?>
                                    </h6>
                                    <p class="mb-1 text-muted"><?php echo htmlspecialchars($task['description']); ?></p>
                                    <span class="badge bg-<?php echo getPriorityBadge($task['priority']); ?>">
                                        <?php echo ucfirst($task['priority']); ?> Priority
                                    </span>
                                </div>
                                <div class="text-end">
                                    <a href="<?php echo htmlspecialchars($task['url']); ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-arrow-right me-1"></i>Go
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                        <p class="text-muted">All tasks completed! Great job!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- My Classes Overview -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-school me-2"></i>My Classes
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if (!empty($data['my_classes'])): ?>
                        <?php foreach ($data['my_classes'] as $class): ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="class-card border rounded p-3 h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="mb-1"><?php echo htmlspecialchars($class['class_name'] . ' - ' . $class['section']); ?></h6>
                                            <p class="mb-1 text-muted">
                                                <i class="fas fa-book me-2"></i>
                                                <?php echo htmlspecialchars($class['subject_name']); ?>
                                            </p>
                                        </div>
                                        <div class="text-end">
                                            <?php if ($class['is_class_teacher']): ?>
                                                <span class="badge bg-success">Class Teacher</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="class-stats mb-3">
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="stat-value"><?php echo count($class['students'] ?? []); ?></div>
                                                <div class="stat-label">Students</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="stat-value">
                                                    <?php
                                                    $today = date('Y-m-d');
                                                    $present = 0;
                                                    if (!empty($class['students'])) {
                                                        // This would typically come from attendance data
                                                        $present = rand(80, 95); // Placeholder
                                                    }
                                                    echo $present . '%';
                                                    ?>
                                                </div>
                                                <div class="stat-label">Attendance</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="class-actions">
                                        <a href="/teacher/classes/<?php echo $class['id']; ?>" class="btn btn-sm btn-primary me-2">
                                            <i class="fas fa-eye me-1"></i>View Class
                                        </a>
                                        <a href="/teacher/attendance/mark/<?php echo $class['id']; ?>" class="btn btn-sm btn-success">
                                            <i class="fas fa-calendar-check me-1"></i>Mark Attendance
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="text-center py-4">
                                <i class="fas fa-school fa-2x text-muted mb-3"></i>
                                <p class="text-muted">No classes assigned yet. Contact administrator for class assignments.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
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
                        <a href="/teacher/attendance" class="quick-action-btn btn btn-outline-primary w-100 text-start p-3">
                            <i class="fas fa-calendar-check fa-2x mb-2"></i>
                            <h6>Mark Attendance</h6>
                            <p class="text-muted small">Mark daily attendance for your classes</p>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="/teacher/exams" class="quick-action-btn btn btn-outline-success w-100 text-start p-3">
                            <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                            <h6>Enter Marks</h6>
                            <p class="text-muted small">Enter exam marks and grades</p>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="/teacher/classes" class="quick-action-btn btn btn-outline-info w-100 text-start p-3">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <h6>View Students</h6>
                            <p class="text-muted small">View and manage your students</p>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="/teacher/profile" class="quick-action-btn btn btn-outline-warning w-100 text-start p-3">
                            <i class="fas fa-user fa-2x mb-2"></i>
                            <h6>My Profile</h6>
                            <p class="text-muted small">Update your profile information</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>Recent Activities
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Activity</th>
                                <th>Class</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // This would typically come from audit logs or activity tracking
                            $recent_activities = [];
                            if (empty($recent_activities)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-3">
                                        <p class="text-muted mb-0">No recent activities found.</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recent_activities as $activity): ?>
                                    <tr>
                                        <td><?php echo date('d/m/Y', strtotime($activity['created_at'])); ?></td>
                                        <td><?php echo htmlspecialchars($activity['activity_type']); ?></td>
                                        <td><?php echo htmlspecialchars($activity['class_name']); ?></td>
                                        <td><?php echo htmlspecialchars($activity['details']); ?></td>
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

<script>
    // Task icon helper function
    function getTaskIcon(type) {
        switch (type) {
            case 'attendance': return 'calendar-check';
            case 'exam': return 'clipboard-list';
            case 'results': return 'chart-line';
            default: return 'task';
        }
    }

    // Priority badge helper function
    function getPriorityBadge(priority) {
        switch (priority) {
            case 'high': return 'danger';
            case 'medium': return 'warning';
            case 'low': return 'info';
            default: return 'secondary';
        }
    }

    // Refresh dashboard
    function refreshDashboard() {
        location.reload();
    }

    // Auto refresh every 5 minutes
    setInterval(function() {
        // Update current time display if any
        const now = new Date();
        console.log('Dashboard refreshed at:', now.toLocaleTimeString());
    }, 300000);

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
</script>

<style>
    .class-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .class-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-color: #667eea;
    }

    .schedule-item {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        transition: all 0.3s ease;
    }

    .schedule-item:hover {
        background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    }

    .schedule-time {
        font-size: 0.8rem;
    }

    .task-item {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        transition: all 0.3s ease;
    }

    .task-item:hover {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #495057;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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