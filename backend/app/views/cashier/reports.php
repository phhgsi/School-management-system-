<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-chart-bar me-2"></i>Financial Reports
            </h1>
            <p class="page-subtitle">View and analyze fee collection reports</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" onclick="refreshPage()">
                <i class="fas fa-sync-alt me-2"></i>Refresh
            </button>
        </div>
    </div>
</div>

<!-- Report Filters -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-filter me-2"></i>Report Filters
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="report_type" class="form-label">Report Type</label>
                        <select class="form-select" id="report_type" name="type" required>
                            <option value="daily">Daily Collection</option>
                            <option value="monthly">Monthly Collection</option>
                            <option value="pending">Pending Fees</option>
                            <option value="student">Student-wise</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Generate Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-money-bill-wave fa-2x mb-2"></i>
                <h4>₹<?php echo number_format($data['total_collection']); ?></h4>
                <small>Total Collection</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-receipt fa-2x mb-2"></i>
                <h4><?php echo $data['total_transactions']; ?></h4>
                <small>Total Transactions</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <h4>₹<?php echo number_format($data['total_pending']); ?></h4>
                <small>Pending Amount</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x mb-2"></i>
                <h4><?php echo $data['pending_count']; ?></h4>
                <small>Students with Dues</small>
            </div>
        </div>
    </div>
</div>

<!-- Report Content -->
<?php if (!empty($data['report_data'])): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-table me-2"></i>Report Results
                </h5>
                <div>
                    <button class="btn btn-success btn-sm" onclick="exportReport()">
                        <i class="fas fa-download me-1"></i>Export Excel
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="printReport()">
                        <i class="fas fa-print me-1"></i>Print
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <?php if ($data['report_type'] == 'daily' || $data['report_type'] == 'monthly'): ?>
                                    <th>Date</th>
                                    <th>Total Amount</th>
                                    <th>Transactions</th>
                                    <th>Average Amount</th>
                                <?php elseif ($data['report_type'] == 'pending'): ?>
                                    <th>Student Name</th>
                                    <th>Class</th>
                                    <th>Total Fee</th>
                                    <th>Paid Amount</th>
                                    <th>Pending Amount</th>
                                <?php elseif ($data['report_type'] == 'student'): ?>
                                    <th>Student Name</th>
                                    <th>Class</th>
                                    <th>Total Paid</th>
                                    <th>Last Payment</th>
                                    <th>Payment Mode</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['report_data'] as $row): ?>
                                <tr>
                                    <?php if ($data['report_type'] == 'daily' || $data['report_type'] == 'monthly'): ?>
                                        <td><?php echo date('M d, Y', strtotime($row['date'])); ?></td>
                                        <td>₹<?php echo number_format($row['total_amount'], 2); ?></td>
                                        <td><?php echo $row['transaction_count']; ?></td>
                                        <td>₹<?php echo number_format($row['avg_amount'], 2); ?></td>
                                    <?php elseif ($data['report_type'] == 'pending'): ?>
                                        <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['class_name'] . ' - ' . $row['section']); ?></td>
                                        <td>₹<?php echo number_format($row['total_fee'], 2); ?></td>
                                        <td>₹<?php echo number_format($row['paid_amount'], 2); ?></td>
                                        <td class="text-danger">₹<?php echo number_format($row['pending_amount'], 2); ?></td>
                                    <?php elseif ($data['report_type'] == 'student'): ?>
                                        <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['class_name'] . ' - ' . $row['section']); ?></td>
                                        <td>₹<?php echo number_format($row['total_paid'], 2); ?></td>
                                        <td><?php echo $row['last_payment'] ? date('M d, Y', strtotime($row['last_payment'])) : 'N/A'; ?></td>
                                        <td><?php echo htmlspecialchars($row['payment_mode'] ?? 'N/A'); ?></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Charts Section -->
<?php if (!empty($data['chart_data'])): ?>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>Collection Trend
                </h5>
            </div>
            <div class="card-body">
                <canvas id="collectionChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-pie-chart me-2"></i>Payment Modes
                </h5>
            </div>
            <div class="card-body">
                <canvas id="paymentModeChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
function refreshPage() {
    location.reload();
}

function exportReport() {
    const reportType = document.getElementById('report_type').value;
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    window.location.href = `/cashier/reports/export?type=${reportType}&start_date=${startDate}&end_date=${endDate}`;
}

function printReport() {
    window.print();
}

// Set default dates
document.getElementById('start_date').value = '<?php echo date('Y-m-d', strtotime('-30 days')); ?>';
document.getElementById('end_date').value = '<?php echo date('Y-m-d'); ?>';

// Charts (if chart data is available)
<?php if (!empty($data['chart_data'])): ?>
const collectionCtx = document.getElementById('collectionChart').getContext('2d');
const paymentModeCtx = document.getElementById('paymentModeChart').getContext('2d');

const collectionChart = new Chart(collectionCtx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_column($data['chart_data'], 'date')); ?>,
        datasets: [{
            label: 'Collection Amount',
            data: <?php echo json_encode(array_column($data['chart_data'], 'amount')); ?>,
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

const paymentModeChart = new Chart(paymentModeCtx, {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode(array_keys($data['payment_modes'])); ?>,
        datasets: [{
            data: <?php echo json_encode(array_values($data['payment_modes'])); ?>,
            backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
<?php endif; ?>
</script>
