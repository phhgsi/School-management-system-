<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-chalkboard me-2"></i>My Classes & Subjects
            </h1>
            <p class="page-subtitle">Manage your assigned classes and subjects</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" onclick="refreshPage()">
                <i class="fas fa-sync-alt me-2"></i>Refresh
            </button>
        </div>
    </div>
</div>

<!-- Assigned Classes -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-school me-2"></i>Assigned Classes
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($data['my_classes'])): ?>
                    <div class="row">
                        <?php foreach ($data['my_classes'] as $class): ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card class-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h5 class="card-title mb-1">
                                                    <?php echo htmlspecialchars($class['class_name'] . ' - ' . $class['section']); ?>
                                                </h5>
                                                <?php if ($class['is_class_teacher']): ?>
                                                    <span class="badge bg-primary">Class Teacher</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-info">
                                                    <?php echo $class['student_count']; ?> Students
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <strong>Subject:</strong>
                                            <span class="ms-2"><?php echo htmlspecialchars($class['subject_name']); ?></span>
                                        </div>

                                        <?php if (!empty($class['students'])): ?>
                                            <div class="student-list">
                                                <strong>Students (<?php echo count($class['students']); ?>):</strong>
                                                <div class="mt-2">
                                                    <?php foreach (array_slice($class['students'], 0, 5) as $student): ?>
                                                        <span class="badge bg-light text-dark me-1 mb-1">
                                                            <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>
                                                        </span>
                                                    <?php endforeach; ?>
                                                    <?php if (count($class['students']) > 5): ?>
                                                        <span class="badge bg-secondary">
                                                            +<?php echo count($class['students']) - 5; ?> more
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="mt-3">
                                            <button class="btn btn-sm btn-outline-primary me-2" onclick="viewClassDetails(<?php echo $class['class_id']; ?>)">
                                                <i class="fas fa-eye me-1"></i>View Details
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" onclick="markAttendance(<?php echo $class['class_id']; ?>)">
                                                <i class="fas fa-calendar-check me-1"></i>Mark Attendance
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-chalkboard-teacher fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Classes Assigned</h5>
                        <p class="text-muted">You haven't been assigned to any classes yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" onclick="viewTimetable()">
                        <i class="fas fa-calendar-alt me-2"></i>View Timetable
                    </button>
                    <button class="btn btn-success" onclick="uploadStudyMaterial()">
                        <i class="fas fa-upload me-2"></i>Upload Study Material
                    </button>
                    <button class="btn btn-info" onclick="viewAnnouncements()">
                        <i class="fas fa-bullhorn me-2"></i>School Announcements
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Class Statistics
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h4 class="text-primary mb-1"><?php echo $data['total_classes']; ?></h4>
                        <small class="text-muted">Total Classes</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success mb-1"><?php echo $data['total_students']; ?></h4>
                        <small class="text-muted">Total Students</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function refreshPage() {
    location.reload();
}

function viewClassDetails(classId) {
    // Redirect to class details page
    window.location.href = '/teacher/classes/details/' + classId;
}

function markAttendance(classId) {
    // Redirect to attendance marking page
    window.location.href = '/teacher/attendance/mark/' + classId;
}

function viewTimetable() {
    // Redirect to timetable page
    window.location.href = '/teacher/timetable';
}

function uploadStudyMaterial() {
    // Open modal or redirect to upload page
    alert('Study material upload feature coming soon!');
}

function viewAnnouncements() {
    // Redirect to announcements page
    window.location.href = '/teacher/announcements';
}
</script>