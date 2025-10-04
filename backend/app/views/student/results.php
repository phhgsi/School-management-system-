<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-chart-line me-2"></i>My Results
            </h1>
            <p class="page-subtitle">View your exam results and academic performance</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" onclick="refreshPage()">
                <i class="fas fa-sync-alt me-2"></i>Refresh
            </button>
        </div>
    </div>
</div>

<!-- Results Summary -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-trophy fa-2x mb-2"></i>
                <h4><?php echo $data['summary']['total_exams']; ?></h4>
                <small>Exams Appeared</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-star fa-2x mb-2"></i>
                <h4><?php echo $data['summary']['average_percentage']; ?>%</h4>
                <small>Average Score</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-medal fa-2x mb-2"></i>
                <h4><?php echo $data['summary']['highest_score']; ?>%</h4>
                <small>Highest Score</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-graduation-cap fa-2x mb-2"></i>
                <h4><?php echo $data['summary']['current_grade']; ?></h4>
                <small>Current Grade</small>
            </div>
        </div>
    </div>
</div>

<!-- Exam Results -->
<?php if (!empty($data['exam_results'])): ?>
    <?php foreach ($data['exam_results'] as $exam): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-clipboard-list me-2"></i>
                            <?php echo htmlspecialchars($exam['exam_name']); ?>
                            <small class="text-muted">(<?php echo date('M d, Y', strtotime($exam['start_date'])); ?>)</small>
                        </h5>
                        <div>
                            <span class="badge bg-primary"><?php echo htmlspecialchars($exam['exam_type']); ?></span>
                            <button class="btn btn-sm btn-outline-primary ms-2" onclick="downloadResult(<?php echo $exam['exam_id']; ?>)">
                                <i class="fas fa-download me-1"></i>Download
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th>Marks Obtained</th>
                                                <th>Max Marks</th>
                                                <th>Percentage</th>
                                                <th>Grade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($exam['subjects'] as $subject): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                                                    <td><?php echo $subject['marks_obtained']; ?></td>
                                                    <td><?php echo $subject['max_marks']; ?></td>
                                                    <td>
                                                        <div class="progress" style="width: 80px;">
                                                            <div class="progress-bar bg-<?php
                                                                $percentage = ($subject['marks_obtained'] / $subject['max_marks']) * 100;
                                                                echo $percentage >= 90 ? 'success' : ($percentage >= 75 ? 'warning' : 'danger');
                                                            ?>" style="width: <?php echo $percentage; ?>%">
                                                                <?php echo round($percentage, 1); ?>%
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-<?php
                                                            echo $percentage >= 90 ? 'success' : ($percentage >= 75 ? 'warning' : 'danger');
                                                        ?>">
                                                            <?php echo $subject['grade']; ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-primary">
                                                <th>Total</th>
                                                <th><?php echo $exam['total_obtained']; ?>/<?php echo $exam['total_max']; ?></th>
                                                <th><?php echo round(($exam['total_obtained'] / $exam['total_max']) * 100, 1); ?>%</th>
                                                <th><?php echo $exam['overall_grade']; ?></th>
                                                <th>Rank: <?php echo $exam['rank'] ?? 'N/A'; ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="mb-3">
                                        <h3 class="text-primary mb-1"><?php echo round(($exam['total_obtained'] / $exam['total_max']) * 100, 1); ?>%</h3>
                                        <p class="text-muted">Overall Percentage</p>
                                    </div>
                                    <div class="mb-3">
                                        <span class="badge bg-<?php
                                            $overallPercentage = ($exam['total_obtained'] / $exam['total_max']) * 100;
                                            echo $overallPercentage >= 90 ? 'success' : ($overallPercentage >= 75 ? 'warning' : 'danger');
                                        ?> fs-5">
                                            <?php echo $exam['overall_grade']; ?>
                                        </span>
                                    </div>
                                    <?php if (!empty($exam['remarks'])): ?>
                                        <div class="alert alert-info">
                                            <strong>Remarks:</strong><br>
                                            <?php echo htmlspecialchars($exam['remarks']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Results Available</h5>
                    <p class="text-muted">Your exam results will appear here once they are published.</p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Grade Scale -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Grade Scale
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-2">
                        <div class="p-2">
                            <h6 class="text-success">A+</h6>
                            <small>90-100%</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="p-2">
                            <h6 class="text-success">A</h6>
                            <small>80-89%</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="p-2">
                            <h6 class="text-warning">B+</h6>
                            <small>70-79%</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="p-2">
                            <h6 class="text-warning">B</h6>
                            <small>60-69%</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="p-2">
                            <h6 class="text-danger">C</h6>
                            <small>50-59%</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="p-2">
                            <h6 class="text-danger">F</h6>
                            <small>Below 50%</small>
                        </div>
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

function downloadResult(examId) {
    window.open('/student/results/download/' + examId, '_blank');
}
</script>