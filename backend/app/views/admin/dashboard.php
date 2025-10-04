<!-- Dashboard content will be included in the admin layout -->

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-primary">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stats-value"><?php echo number_format($data['stats']['total_students']); ?></div>
            <div class="stats-label">Total Students</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-success">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stats-value"><?php echo number_format($data['stats']['total_teachers']); ?></div>
            <div class="stats-label">Total Teachers</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-info">
                <i class="fas fa-school"></i>
            </div>
            <div class="stats-value"><?php echo number_format($data['stats']['total_classes']); ?></div>
            <div class="stats-label">Total Classes</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-warning">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stats-value"><?php echo number_format($data['stats']['today_attendance']); ?></div>
            <div class="stats-label">Today's Attendance</div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-success">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stats-value">₹<?php echo number_format($data['stats']['monthly_collection'], 2); ?></div>
            <div class="stats-label">Monthly Collection</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-danger">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stats-value">₹<?php echo number_format($data['stats']['pending_fees'], 2); ?></div>
            <div class="stats-label">Pending Fees</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stats-value">
                <?php
                $total = $data['stats']['total_students'] + $data['stats']['total_teachers'];
                echo number_format($total);
                ?>
            </div>
            <div class="stats-label">Total Users</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-info">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stats-value"><?php echo date('d'); ?></div>
            <div class="stats-label"><?php echo date('F Y'); ?></div>
        </div>
    </div>
</div>

<!-- Charts and Quick Actions -->
<div class="row mb-4">
    <!-- Attendance Chart -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Attendance Overview
                </h5>
            </div>
            <div class="card-body">
                <canvas id="attendanceChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="/admin/students/add" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Student
                    </a>
                    <a href="/admin/teachers/add" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Add New Teacher
                    </a>
                    <a href="/admin/attendance/mark" class="btn btn-info">
                        <i class="fas fa-calendar-check me-2"></i>Mark Attendance
                    </a>
                    <a href="/admin/fees/collect" class="btn btn-warning">
                        <i class="fas fa-money-bill-wave me-2"></i>Collect Fees
                    </a>
                    <a href="/admin/events/add" class="btn btn-secondary">
                        <i class="fas fa-calendar-plus me-2"></i>Add Event
                    </a>
                    <a href="/admin/reports/generate" class="btn btn-dark">
                        <i class="fas fa-chart-bar me-2"></i>Generate Report
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities and Upcoming Events -->
<div class="row">
    <!-- Recent Activities -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>Recent Activities
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($data['recent_activities'])): ?>
                    <div class="timeline">
                        <?php foreach ($data['recent_activities'] as $activity): ?>
                            <div class="timeline-item mb-3">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($activity['user_name']); ?></h6>
                                        <p class="mb-1 text-muted"><?php echo htmlspecialchars($activity['action']); ?></p>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <?php echo date('M d, Y H:i', strtotime($activity['created_at'])); ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">No recent activities found.</p>
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
                                    <p class="mb-0 text-muted">
                                        <?php echo htmlspecialchars(substr($event['description'], 0, 100)); ?>...
                                    </p>
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
                    <p class="text-muted mb-0">No upcoming events found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- System Status -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-server me-2"></i>System Status
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="system-status-item text-center p-3">
                            <i class="fas fa-database fa-2x text-success mb-2"></i>
                            <h6>Database</h6>
                            <span class="badge bg-success">Connected</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="system-status-item text-center p-3">
                            <i class="fas fa-memory fa-2x text-info mb-2"></i>
                            <h6>Memory Usage</h6>
                            <span class="badge bg-info"><?php echo round(memory_get_usage() / 1024 / 1024, 1); ?> MB</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="system-status-item text-center p-3">
                            <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                            <h6>Uptime</h6>
                            <span class="badge bg-warning">Online</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="system-status-item text-center p-3">
                            <i class="fas fa-shield-alt fa-2x text-success mb-2"></i>
                            <h6>Security</h6>
                            <span class="badge bg-success">Protected</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Attendance Chart
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    const attendanceChart = new Chart(attendanceCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            datasets: [{
                label: 'Present',
                data: [85, 88, 82, 90, 87, 0],
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4
            }, {
                label: 'Absent',
                data: [5, 3, 8, 2, 4, 0],
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });

    // Refresh dashboard function
    function refreshDashboard() {
        location.reload();
    }

    // Auto refresh every 5 minutes
    setInterval(function() {
        // Update time
        document.querySelector('.stats-card .stats-label').lastElementChild.textContent = new Date().toLocaleDateString();
    }, 60000);
</script>