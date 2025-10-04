<!-- Reports & Analytics content will be included in the admin layout -->

<!-- Report Categories -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-folder me-2"></i>Report Categories
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="report-category-card text-center p-4 border rounded cursor-pointer"
                             onclick="showReportCategory('academic')">
                            <i class="fas fa-graduation-cap fa-3x text-primary mb-3"></i>
                            <h6>Academic Reports</h6>
                            <p class="text-muted small">Student performance, grades, and academic analytics</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="report-category-card text-center p-4 border rounded cursor-pointer"
                             onclick="showReportCategory('attendance')">
                            <i class="fas fa-calendar-check fa-3x text-success mb-3"></i>
                            <h6>Attendance Reports</h6>
                            <p class="text-muted small">Student and teacher attendance analysis</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="report-category-card text-center p-4 border rounded cursor-pointer"
                             onclick="showReportCategory('financial')">
                            <i class="fas fa-money-bill-wave fa-3x text-warning mb-3"></i>
                            <h6>Financial Reports</h6>
                            <p class="text-muted small">Fee collection and payment analytics</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="report-category-card text-center p-4 border rounded cursor-pointer"
                             onclick="showReportCategory('administrative')">
                            <i class="fas fa-chart-line fa-3x text-info mb-3"></i>
                            <h6>Administrative Reports</h6>
                            <p class="text-muted small">Staff, infrastructure, and system reports</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Generator -->
<div class="row mb-4">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cog me-2"></i>Report Generator
                </h5>
            </div>
            <div class="card-body">
                <form id="reportForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="report_type" class="form-label">Report Type *</label>
                                <select class="form-select" id="report_type" name="report_type" required onchange="updateReportOptions()">
                                    <option value="">Select Report Type</option>
                                    <option value="student_list">Student List</option>
                                    <option value="attendance_summary">Attendance Summary</option>
                                    <option value="exam_results">Exam Results</option>
                                    <option value="fee_collection">Fee Collection</option>
                                    <option value="teacher_workload">Teacher Workload</option>
                                    <option value="class_performance">Class Performance</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="output_format" class="form-label">Output Format *</label>
                                <select class="form-select" id="output_format" name="output_format" required>
                                    <option value="html">HTML (View)</option>
                                    <option value="pdf">PDF</option>
                                    <option value="excel">Excel</option>
                                    <option value="csv">CSV</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="reportOptions">
                        <!-- Dynamic options will be loaded here -->
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="include_charts" name="include_charts">
                            <label class="form-check-label" for="include_charts">
                                Include charts and graphs
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="auto_generate" name="auto_generate">
                            <label class="form-check-label" for="auto_generate">
                                Auto-generate on schedule
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-generate me-2"></i>Generate Report
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Quick Reports -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Quick Reports
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary" onclick="generateReport('daily_attendance')">
                        <i class="fas fa-calendar-day me-2"></i>Daily Attendance
                    </button>
                    <button class="btn btn-outline-success" onclick="generateReport('monthly_fees')">
                        <i class="fas fa-money-bill me-2"></i>Monthly Fee Collection
                    </button>
                    <button class="btn btn-outline-info" onclick="generateReport('student_strength')">
                        <i class="fas fa-users me-2"></i>Student Strength
                    </button>
                    <button class="btn btn-outline-warning" onclick="generateReport('exam_performance')">
                        <i class="fas fa-chart-line me-2"></i>Exam Performance
                    </button>
                    <button class="btn btn-outline-secondary" onclick="generateReport('teacher_summary')">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Teacher Summary
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Preview Area -->
<div class="row" id="reportPreview" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-file-alt me-2"></i>Report Preview
                </h5>
                <div>
                    <button class="btn btn-success btn-sm me-2" onclick="downloadReport()">
                        <i class="fas fa-download me-2"></i>Download
                    </button>
                    <button class="btn btn-secondary btn-sm" onclick="printReport()">
                        <i class="fas fa-print me-2"></i>Print
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="reportContent">
                    <!-- Report content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Reports -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>Recent Reports
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Report Name</th>
                                <th>Type</th>
                                <th>Generated Date</th>
                                <th>Generated By</th>
                                <th>Format</th>
                                <th>Size</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // This would typically come from a reports table
                            $recent_reports = [];
                            if (empty($recent_reports)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-file-alt fa-2x text-muted mb-3"></i>
                                        <p class="text-muted">No reports generated yet. Generate your first report to get started.</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recent_reports as $report): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($report['report_name']); ?></td>
                                        <td><?php echo htmlspecialchars($report['report_type']); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($report['generated_at'])); ?></td>
                                        <td><?php echo htmlspecialchars($report['generated_by']); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo getFormatBadge($report['format']); ?>">
                                                <?php echo strtoupper($report['format']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($report['file_size']); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" title="View Report"
                                                    onclick="viewReport(<?php echo $report['id']; ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-success" title="Download"
                                                    onclick="downloadReportFile(<?php echo $report['id']; ?>)">
                                                <i class="fas fa-download"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Delete"
                                                    onclick="deleteReport(<?php echo $report['id']; ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
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
    // Format badge helper function
    function getFormatBadge(format) {
        switch (strtolower(format)) {
            case 'pdf': return 'danger';
            case 'excel': return 'success';
            case 'csv': return 'info';
            case 'html': return 'primary';
            default: return 'secondary';
        }
    }

    // Show report category
    function showReportCategory(category) {
        const options = {
            academic: `
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Academic Report Type</label>
                            <select class="form-select" name="academic_type">
                                <option value="student_performance">Student Performance</option>
                                <option value="class_ranking">Class Ranking</option>
                                <option value="subject_analysis">Subject Analysis</option>
                                <option value="grade_distribution">Grade Distribution</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Class</label>
                            <select class="form-select" name="class_id">
                                <option value="">All Classes</option>
                                <!-- Classes would be loaded here -->
                            </select>
                        </div>
                    </div>
                </div>
            `,
            attendance: `
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Attendance Report Type</label>
                            <select class="form-select" name="attendance_type">
                                <option value="daily_summary">Daily Summary</option>
                                <option value="monthly_report">Monthly Report</option>
                                <option value="student_wise">Student-wise</option>
                                <option value="class_wise">Class-wise</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Include Teachers</label>
                            <select class="form-select" name="include_teachers">
                                <option value="no">Students Only</option>
                                <option value="yes">Include Teachers</option>
                            </select>
                        </div>
                    </div>
                </div>
            `,
            financial: `
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Financial Report Type</label>
                            <select class="form-select" name="financial_type">
                                <option value="fee_collection">Fee Collection</option>
                                <option value="outstanding_fees">Outstanding Fees</option>
                                <option value="payment_summary">Payment Summary</option>
                                <option value="income_statement">Income Statement</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Period</label>
                            <select class="form-select" name="period">
                                <option value="monthly">Monthly</option>
                                <option value="quarterly">Quarterly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>
                    </div>
                </div>
            `,
            administrative: `
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Administrative Report Type</label>
                            <select class="form-select" name="admin_type">
                                <option value="staff_summary">Staff Summary</option>
                                <option value="infrastructure">Infrastructure</option>
                                <option value="system_usage">System Usage</option>
                                <option value="audit_log">Audit Log</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department">
                                <option value="">All Departments</option>
                                <option value="academic">Academic</option>
                                <option value="administrative">Administrative</option>
                                <option value="support">Support</option>
                            </select>
                        </div>
                    </div>
                </div>
            `
        };

        document.getElementById('reportOptions').innerHTML = options[category] || '';
    }

    // Update report options based on type
    function updateReportOptions() {
        const reportType = document.getElementById('report_type').value;
        const reportOptions = document.getElementById('reportOptions');

        switch (reportType) {
            case 'student_list':
                reportOptions.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Class</label>
                                <select class="form-select" name="class_id">
                                    <option value="">All Classes</option>
                                    <!-- Classes would be loaded here -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="student_status">
                                    <option value="">All Students</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                `;
                break;
            case 'exam_results':
                reportOptions.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Exam</label>
                                <select class="form-select" name="exam_id">
                                    <option value="">All Exams</option>
                                    <!-- Exams would be loaded here -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Class</label>
                                <select class="form-select" name="class_id">
                                    <option value="">All Classes</option>
                                    <!-- Classes would be loaded here -->
                                </select>
                            </div>
                        </div>
                    </div>
                `;
                break;
            default:
                reportOptions.innerHTML = '';
        }
    }

    // Generate report
    document.getElementById('reportForm')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const reportPreview = document.getElementById('reportPreview');
        const reportContent = document.getElementById('reportContent');

        // Show loading
        reportContent.innerHTML = '<div class="text-center py-4"><div class="spinner"></div> Generating report...</div>';
        reportPreview.style.display = 'block';

        // Simulate report generation (replace with actual API call)
        setTimeout(() => {
            reportContent.innerHTML = `
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    Report generated successfully! Preview shown below.
                </div>
                <div class="report-preview">
                    <h6>Report Preview</h6>
                    <p>This is a sample report preview. In a real implementation, this would show the actual report content based on the selected parameters.</p>
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="sampleChart" width="300" height="200"></canvas>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>Total Students</td><td>500</td></tr>
                                    <tr><td>Total Teachers</td><td>25</td></tr>
                                    <tr><td>Attendance Rate</td><td>95%</td></tr>
                                    <tr><td>Fee Collection</td><td>₹2,50,000</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            `;

            // Initialize sample chart
            const ctx = document.getElementById('sampleChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Present', 'Absent', 'Late'],
                    datasets: [{
                        data: [85, 10, 5],
                        backgroundColor: ['#28a745', '#dc3545', '#ffc107']
                    }]
                }
            });
        }, 2000);
    });

    // Generate specific report
    function generateReport(type) {
        const reportForm = document.getElementById('reportForm');
        document.getElementById('report_type').value = type;
        document.getElementById('output_format').value = 'html';
        updateReportOptions();

        // Auto-submit after a short delay
        setTimeout(() => {
            reportForm.dispatchEvent(new Event('submit'));
        }, 500);
    }

    // Generate all reports
    function generateAllReports() {
        if (confirm('This will generate all major reports. This may take some time. Continue?')) {
            // Implement bulk report generation
            alert('Bulk report generation started. You will be notified when complete.');
        }
    }

    // View report
    function viewReport(id) {
        window.location.href = '/admin/reports/view/' + id;
    }

    // Download report file
    function downloadReportFile(id) {
        window.location.href = '/admin/reports/download/' + id;
    }

    // Delete report
    function deleteReport(id) {
        if (confirm('Are you sure you want to delete this report?')) {
            // Implement report deletion
            alert('Report deleted successfully');
        }
    }

    // Download current report
    function downloadReport() {
        const format = document.getElementById('output_format').value;
        const reportType = document.getElementById('report_type').value;

        if (format === 'pdf') {
            window.open('/admin/reports/generate/' + reportType + '?format=pdf', '_blank');
        } else if (format === 'excel') {
            window.open('/admin/reports/generate/' + reportType + '?format=excel', '_blank');
        } else {
            alert('Report downloaded as ' + format.toUpperCase());
        }
    }

    // Print report
    function printReport() {
        const reportContent = document.getElementById('reportContent');
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Report Print</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .no-print { display: none; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; }
                    </style>
                </head>
                <body>
                    ${reportContent.innerHTML}
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    }
</script>

<style>
    .report-category-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .report-category-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        background-color: #f8f9fa;
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>