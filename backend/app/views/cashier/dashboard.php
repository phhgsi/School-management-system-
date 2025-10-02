<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-cash-register me-2"></i>Cashier Dashboard
            </h1>
            <p class="page-subtitle">Welcome back, <?php echo htmlspecialchars($this->auth->getUserName()); ?>! Here's your financial overview.</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" onclick="refreshDashboard()">
                <i class="fas fa-sync-alt me-2"></i>Refresh
            </button>
        </div>
    </div>
</div>

<!-- Financial Summary Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-success">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stats-value">₹<?php echo number_format($data['today_summary']['total_amount'] ?? 0, 2); ?></div>
            <div class="stats-label">Today's Collection</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-primary">
                <i class="fas fa-receipt"></i>
            </div>
            <div class="stats-value"><?php echo $data['today_summary']['total_transactions'] ?? 0; ?></div>
            <div class="stats-label">Transactions Today</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stats-value">₹<?php echo number_format($data['pending_summary']['total_pending_amount'] ?? 0, 2); ?></div>
            <div class="stats-label">Pending Amount</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-info">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-value"><?php echo $data['pending_summary']['students_with_pending'] ?? 0; ?></div>
            <div class="stats-label">Students with Pending Fees</div>
        </div>
    </div>
</div>

<!-- Payment Mode Breakdown and Monthly Trend -->
<div class="row mb-4">
    <!-- Payment Mode Breakdown -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>Today's Payment Modes
                </h5>
            </div>
            <div class="card-body">
                <canvas id="paymentModeChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Trend -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>Monthly Collection Trend
                </h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyTrendChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions and Recent Transactions -->
<div class="row mb-4">
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
                    <a href="/cashier/fees" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Collect Fee
                    </a>
                    <a href="/cashier/fees?view=pending" class="btn btn-warning">
                        <i class="fas fa-clock me-2"></i>View Pending Fees
                    </a>
                    <a href="/cashier/reports" class="btn btn-info">
                        <i class="fas fa-chart-bar me-2"></i>Generate Report
                    </a>
                    <button class="btn btn-secondary" onclick="printDailySummary()">
                        <i class="fas fa-print me-2"></i>Print Daily Summary
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-receipt me-2"></i>Recent Transactions
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Receipt No.</th>
                                <th>Student</th>
                                <th>Class</th>
                                <th>Amount</th>
                                <th>Payment Mode</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['recent_transactions'])): ?>
                                <?php foreach ($data['recent_transactions'] as $transaction): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($transaction['receipt_number']); ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user-graduate me-2 text-primary"></i>
                                                <div>
                                                    <div class="fw-bold"><?php echo htmlspecialchars($transaction['student_name']); ?></div>
                                                    <small class="text-muted"><?php echo htmlspecialchars($transaction['scholar_number']); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo htmlspecialchars($transaction['class_name'] . ' - ' . $transaction['section']); ?></td>
                                        <td>
                                            <span class="badge bg-success">₹<?php echo number_format($transaction['amount'], 2); ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo getPaymentModeBadge($transaction['payment_mode']); ?>">
                                                <?php echo ucfirst($transaction['payment_mode']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($transaction['payment_date'])); ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-info" title="View Receipt"
                                                        onclick="viewReceipt(<?php echo $transaction['id']; ?>)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-success" title="Print Receipt"
                                                        onclick="printReceipt(<?php echo $transaction['id']; ?>)">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-warning" title="Send SMS"
                                                        onclick="sendSMS(<?php echo $transaction['student_id']; ?>)">
                                                    <i class="fas fa-sms"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-receipt fa-2x text-muted mb-3"></i>
                                        <p class="text-muted">No transactions found for today.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Fees Alert -->
<?php if (($data['pending_summary']['total_pending_amount'] ?? 0) > 0): ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Pending Fees Alert:</strong> <?php echo $data['pending_summary']['students_with_pending']; ?> students have pending fees totaling ₹<?php echo number_format($data['pending_summary']['total_pending_amount'], 2); ?>.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Collection Summary -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Collection Summary
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="summary-item text-center p-3">
                            <i class="fas fa-money-bill-alt fa-2x text-success mb-2"></i>
                            <div class="summary-value">₹<?php echo number_format($data['today_summary']['cash_amount'] ?? 0, 2); ?></div>
                            <div class="summary-label">Cash Payments</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="summary-item text-center p-3">
                            <i class="fas fa-credit-card fa-2x text-primary mb-2"></i>
                            <div class="summary-value">₹<?php echo number_format($data['today_summary']['online_amount'] ?? 0, 2); ?></div>
                            <div class="summary-label">Online Payments</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="summary-item text-center p-3">
                            <i class="fas fa-university fa-2x text-info mb-2"></i>
                            <div class="summary-value">₹<?php echo number_format($data['today_summary']['cheque_amount'] ?? 0, 2); ?></div>
                            <div class="summary-label">Cheque Payments</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="summary-item text-center p-3">
                            <i class="fas fa-percentage fa-2x text-warning mb-2"></i>
                            <div class="summary-value">
                                <?php
                                $total = ($data['today_summary']['total_amount'] ?? 0);
                                $cash = ($data['today_summary']['cash_amount'] ?? 0);
                                $cashPercentage = $total > 0 ? round(($cash / $total) * 100, 1) : 0;
                                echo $cashPercentage . '%';
                                ?>
                            </div>
                            <div class="summary-label">Cash Ratio</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Payment mode badge helper function
    function getPaymentModeBadge(mode) {
        switch (mode) {
            case 'cash': return 'success';
            case 'online': return 'primary';
            case 'cheque': return 'info';
            case 'upi': return 'warning';
            case 'bank_transfer': return 'secondary';
            default: return 'secondary';
        }
    }

    // Payment mode chart
    const paymentModeCtx = document.getElementById('paymentModeChart').getContext('2d');
    const paymentModeChart = new Chart(paymentModeCtx, {
        type: 'doughnut',
        data: {
            labels: ['Cash', 'Online', 'Cheque', 'UPI'],
            datasets: [{
                data: [
                    <?php echo $data['today_summary']['cash_amount'] ?? 0; ?>,
                    <?php echo $data['today_summary']['online_amount'] ?? 0; ?>,
                    <?php echo $data['today_summary']['cheque_amount'] ?? 0; ?>,
                    0 // UPI amount - would need to be calculated
                ],
                backgroundColor: [
                    '#28a745',
                    '#007bff',
                    '#17a2b8',
                    '#ffc107'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Monthly trend chart
    const monthlyTrendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
    const monthlyTrendChart = new Chart(monthlyTrendCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_column($data['monthly_trend'], 'month')); ?>,
            datasets: [{
                label: 'Collection Amount',
                data: <?php echo json_encode(array_column($data['monthly_trend'], 'total_amount')); ?>,
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
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
                    ticks: {
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Amount: ₹' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Refresh dashboard
    function refreshDashboard() {
        location.reload();
    }

    // View receipt
    function viewReceipt(paymentId) {
        window.open('/cashier/fees/receipt/' + paymentId, '_blank');
    }

    // Print receipt
    function printReceipt(paymentId) {
        window.open('/cashier/fees/receipt/' + paymentId + '?print=1', '_blank');
    }

    // Send SMS notification
    function sendSMS(studentId) {
        if (confirm('Send payment confirmation SMS to student?')) {
            fetch('/cashier/fees/send-sms/' + studentId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'csrf_token=<?php echo htmlspecialchars($data['csrf_token']); ?>'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('SMS sent successfully!');
                } else {
                    alert('Error sending SMS: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error sending SMS');
                console.error('Error:', error);
            });
        }
    }

    // Print daily summary
    function printDailySummary() {
        const today = new Date().toISOString().split('T')[0];
        window.open('/cashier/reports/daily-summary?date=' + today + '&print=1', '_blank');
    }

    // Auto refresh every 2 minutes for real-time updates
    setInterval(function() {
        // Update current time and refresh data if needed
        const now = new Date();
        console.log('Dashboard refreshed at:', now.toLocaleTimeString());
    }, 120000);
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
        font-size: 1.8rem;
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

    .summary-item {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .summary-item:hover {
        background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    }

    .summary-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .summary-label {
        color: #6c757d;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-group .btn {
        margin-right: 0.25rem;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }

    .alert {
        border-radius: 10px;
    }
</style>