<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-calendar-check me-2"></i>My Attendance
            </h1>
            <p class="page-subtitle">View your attendance records and statistics</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" onclick="refreshPage()">
                <i class="fas fa-sync-alt me-2"></i>Refresh
            </button>
        </div>
    </div>
</div>

<!-- Attendance Summary Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <h4><?php echo $data['summary']['present']; ?></h4>
                <small>Present Days</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <i class="fas fa-times-circle fa-2x mb-2"></i>
                <h4><?php echo $data['summary']['absent']; ?></h4>
                <small>Absent Days</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <h4><?php echo $data['summary']['late']; ?></h4>
                <small>Late Days</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-percentage fa-2x mb-2"></i>
                <h4><?php echo $data['summary']['percentage']; ?>%</h4>
                <small>Attendance %</small>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Chart -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>Attendance Trend
                </h5>
            </div>
            <div class="card-body">
                <canvas id="attendanceChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Attendance Breakdown -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Monthly Attendance
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Present</th>
                                <th>Absent</th>
                                <th>Late</th>
                                <th>Total</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['monthly_attendance'] as $month): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($month['month']); ?></td>
                                    <td><?php echo $month['present']; ?></td>
                                    <td><?php echo $month['absent']; ?></td>
                                    <td><?php echo $month['late']; ?></td>
                                    <td><?php echo $month['total']; ?></td>
                                    <td>
                                        <div class="progress" style="width: 100px;">
                                            <div class="progress-bar bg-<?php echo $month['percentage'] >= 90 ? 'success' : ($month['percentage'] >= 75 ? 'warning' : 'danger'); ?>"
                                                 style="width: <?php echo $month['percentage']; ?>%">
                                                <?php echo round($month['percentage'], 1); ?>%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Attendance Records -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Recent Attendance Records
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($data['recent_attendance'])): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Subject</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['recent_attendance'] as $record): ?>
                                    <tr>
                                        <td><?php echo date('M d, Y', strtotime($record['attendance_date'])); ?></td>
                                        <td>
                                            <span class="badge bg-<?php
                                                echo $record['status'] == 'present' ? 'success' :
                                                     ($record['status'] == 'absent' ? 'danger' : 'warning'); ?>">
                                                <?php echo ucfirst($record['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($record['subject_name'] ?? 'All Subjects'); ?></td>
                                        <td><?php echo htmlspecialchars($record['remarks'] ?? '-'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-3">No attendance records found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function refreshPage() {
    location.reload();
}

// Attendance Chart
const ctx = document.getElementById('attendanceChart').getContext('2d');
const attendanceChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_column($data['chart_data'], 'month')); ?>,
        datasets: [{
            label: 'Attendance %',
            data: <?php echo json_encode(array_column($data['chart_data'], 'percentage')); ?>,
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            tension: 0.4,
            fill: true
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
                display: false
            }
        }
    }
});
</script>