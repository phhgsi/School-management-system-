<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-clipboard-list me-2"></i>My Exams
            </h1>
            <p class="page-subtitle">Manage your exam schedules and results</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" onclick="refreshPage()">
                <i class="fas fa-sync-alt me-2"></i>Refresh
            </button>
        </div>
    </div>
</div>

<!-- Upcoming Exams -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Upcoming Exams
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($data['upcoming_exams'])): ?>
                    <div class="row">
                        <?php foreach ($data['upcoming_exams'] as $exam): ?>
                            <div class="col-lg-6 col-md-12 mb-3">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="card-title mb-2"><?php echo htmlspecialchars($exam['exam_name']); ?></h6>
                                                <p class="mb-2">
                                                    <i class="fas fa-school me-2"></i>
                                                    <?php echo htmlspecialchars($exam['class_name'] . ' - ' . $exam['section']); ?>
                                                </p>
                                                <p class="mb-2">
                                                    <i class="fas fa-calendar me-2"></i>
                                                    <?php echo date('M d, Y', strtotime($exam['start_date'])); ?> - 
                                                    <?php echo date('M d, Y', strtotime($exam['end_date'])); ?>
                                                </p>
                                            </div>
                                            <span class="badge bg-primary"><?php echo htmlspecialchars($exam['exam_type']); ?></span>
                                        </div>
                                        <div class="mt-3">
                                            <button class="btn btn-sm btn-outline-primary me-2" onclick="viewExamDetails(<?php echo $exam['id']; ?>)">
                                                <i class="fas fa-eye me-1"></i>View Details
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" onclick="enterMarks(<?php echo $exam['id']; ?>)">
                                                <i class="fas fa-edit me-1"></i>Enter Marks
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Upcoming Exams</h5>
                        <p class="text-muted">No exams scheduled for your classes.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Exam Statistics -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Exam Statistics
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h4 class="text-primary mb-1"><?php echo $data['total_exams']; ?></h4>
                        <small class="text-muted">Total Exams</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success mb-1"><?php echo $data['pending_marks']; ?></h4>
                        <small class="text-muted">Pending Marks</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" onclick="viewAllResults()">
                        <i class="fas fa-chart-line me-2"></i>View All Results
                    </button>
                    <button class="btn btn-success" onclick="generateReport()">
                        <i class="fas fa-download me-2"></i>Generate Report
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function refreshPage() {
    location.reload();
}

function viewExamDetails(examId) {
    window.location.href = '/teacher/exams/details/' + examId;
}

function enterMarks(examId) {
    window.location.href = '/teacher/exams/marks/' + examId;
}

function viewAllResults() {
    window.location.href = '/teacher/exams/results';
}

function generateReport() {
    window.location.href = '/teacher/exams/report';
}
</script>
