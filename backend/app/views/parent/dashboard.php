<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-home me-2"></i>Parent Dashboard
            </h1>
            <p class="page-subtitle">Welcome back! Monitor your children's academic progress</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" onclick="refreshPage()">
                <i class="fas fa-sync-alt me-2"></i>Refresh
            </button>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-user-graduate fa-2x mb-2"></i>
                <h4><?php echo count($data['children']); ?></h4>
                <small>My Children</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-calendar-check fa-2x mb-2"></i>
                <h4>95%</h4>
                <small>Avg Attendance</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-star fa-2x mb-2"></i>
                <h4>A</h4>
                <small>Avg Grade</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-bell fa-2x mb-2"></i>
                <h4><?php echo count($data['upcoming_events']); ?></h4>
                <small>Upcoming Events</small>
            </div>
        </div>
    </div>
</div>

<!-- Children Overview -->
<?php if (!empty($data['children'])): ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>My Children
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($data['children'] as $child): ?>
                        <div class="col-lg-6 col-md-12 mb-3">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="d-flex">
                                            <?php if (!empty($child['photo'])): ?>
                                                <img src="/backend/public/uploads/students/<?php echo htmlspecialchars($child['photo']); ?>"
                                                     alt="Photo" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                                     style="width: 60px; height: 60px; font-size: 1.5rem;">
                                                    <?php echo strtoupper(substr($child['first_name'], 0, 1)); ?>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <h6 class="mb-1"><?php echo htmlspecialchars($child['first_name'] . ' ' . $child['last_name']); ?></h6>
                                                <p class="mb-1 text-muted"><?php echo htmlspecialchars($child['class_name'] . ' - ' . $child['section']); ?></p>
                                                <p class="mb-0 text-muted">Roll No: <?php echo htmlspecialchars($child['roll_number']); ?></p>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button class="btn btn-sm btn-outline-primary mb-2" onclick="viewChildDetails(<?php echo $child['id']; ?>)">
                                                <i class="fas fa-eye me-1"></i>View Details
                                            </button>
                                            <div>
                                                <span class="badge bg-success">Attendance: 95%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No Children Registered</h5>
                <p class="text-muted">Contact school administration to link your children to your account.</p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="/parent/children" class="btn btn-primary">
                        <i class="fas fa-users me-2"></i>View Children Details
                    </a>
                    <a href="/parent/attendance" class="btn btn-success">
                        <i class="fas fa-calendar-check me-2"></i>Check Attendance
                    </a>
                    <a href="/parent/results" class="btn btn-warning">
                        <i class="fas fa-chart-line me-2"></i>View Results
                    </a>
                    <a href="/parent/fees" class="btn btn-info">
                        <i class="fas fa-money-bill-wave me-2"></i>Fee Status
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bell me-2"></i>Recent Notifications
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($data['recent_activities'])): ?>
                    <?php foreach ($data['recent_activities'] as $activity): ?>
                        <div class="notification-item mb-3 p-2 border-bottom">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                        <i class="fas fa-info"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1"><?php echo htmlspecialchars($activity['action']); ?></p>
                                    <small class="text-muted">
                                        <?php echo date('M d, Y H:i', strtotime($activity['created_at'])); ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">No recent notifications.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Events -->
<?php if (!empty($data['upcoming_events'])): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Upcoming Events
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($data['upcoming_events'] as $event): ?>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-2"><?php echo htmlspecialchars($event['title']); ?></h6>
                                            <p class="mb-1">
                                                <i class="fas fa-calendar me-2"></i>
                                                <?php echo date('M d, Y', strtotime($event['event_date'])); ?>
                                            </p>
                                            <p class="mb-1">
                                                <i class="fas fa-map-marker-alt me-2"></i>
                                                <?php echo htmlspecialchars($event['venue'] ?? 'TBA'); ?>
                                            </p>
                                        </div>
                                        <span class="badge bg-warning"><?php echo ucfirst($event['event_type']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
function refreshPage() {
    location.reload();
}

function viewChildDetails(childId) {
    window.location.href = '/parent/children/details/' + childId;
}
</script>
