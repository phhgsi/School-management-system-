<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Details - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .fees-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .fee-summary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .status-paid { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-overdue { background: #f8d7da; color: #721c24; }
        .payment-card {
            border-left: 4px solid #667eea;
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
        }
        .amount-text {
            font-size: 1.2rem;
            font-weight: bold;
            color: #667eea;
        }
        .receipt-btn {
            background: #28a745;
            border: none;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .receipt-btn:hover {
            background: #218838;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" id="sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="/parent/dashboard" class="nav-link">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/parent/children" class="nav-link">
                                <i class="fas fa-users me-2"></i>My Children
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/parent/attendance" class="nav-link">
                                <i class="fas fa-calendar-check me-2"></i>Attendance
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/parent/results" class="nav-link">
                                <i class="fas fa-chart-bar me-2"></i>Results
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/parent/fees" class="nav-link active">
                                <i class="fas fa-money-bill me-2"></i>Fees
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/logout" class="nav-link text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Fee Details</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <select class="form-select" id="studentSelect">
                                <option value="">All Children</option>
                                <?php if (!empty($data['children'])): ?>
                                    <?php foreach ($data['children'] as $child): ?>
                                        <option value="<?php echo $child['id']; ?>"
                                                <?php echo ($data['selected_student'] ?? '') == $child['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($child['first_name'] . ' ' . $child['last_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="btn-group me-2">
                            <select class="form-select" id="yearSelect">
                                <option value="">All Years</option>
                                <?php
                                $currentYear = date('Y');
                                for ($year = $currentYear; $year >= $currentYear - 2; $year--):
                                ?>
                                    <option value="<?php echo $year; ?>"
                                            <?php echo ($data['selected_year'] ?? '') == $year ? 'selected' : ''; ?>>
                                        <?php echo $year; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <?php if (!empty($data['children'])): ?>
                    <!-- Fee Summary -->
                    <div class="fee-summary">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="stats-number">₹<?php echo number_format($data['summary']['total_paid'] ?? 0); ?></div>
                                <div>Total Paid</div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-number text-warning">₹<?php echo number_format($data['summary']['total_pending'] ?? 0); ?></div>
                                <div>Pending</div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-number text-danger">₹<?php echo number_format($data['summary']['total_overdue'] ?? 0); ?></div>
                                <div>Overdue</div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-number">₹<?php echo number_format($data['summary']['grand_total'] ?? 0); ?></div>
                                <div>Grand Total</div>
                            </div>
                        </div>
                    </div>

                    <!-- Fee Structure -->
                    <?php if (!empty($data['fee_structure'])): ?>
                        <div class="fees-card card">
                            <div class="card-header">
                                <h5 class="mb-0">Fee Structure</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Fee Type</th>
                                                <th>Amount</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data['fee_structure'] as $fee): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($fee['fee_name']); ?></td>
                                                    <td class="amount-text">₹<?php echo number_format($fee['amount']); ?></td>
                                                    <td><?php echo $fee['due_date'] ? date('d/m/Y', strtotime($fee['due_date'])) : 'N/A'; ?></td>
                                                    <td>
                                                        <span class="status-badge status-<?php echo $fee['status']; ?>">
                                                            <?php echo ucfirst($fee['status']); ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Payment History -->
                    <?php if (!empty($data['payments'])): ?>
                        <div class="fees-card card">
                            <div class="card-header">
                                <h5 class="mb-0">Payment History</h5>
                            </div>
                            <div class="card-body">
                                <?php foreach ($data['payments'] as $payment): ?>
                                    <div class="payment-card">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                <strong><?php echo htmlspecialchars($payment['receipt_number']); ?></strong>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="amount-text">₹<?php echo number_format($payment['amount']); ?></span>
                                            </div>
                                            <div class="col-md-2">
                                                <?php echo date('d/m/Y', strtotime($payment['payment_date'])); ?>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="badge bg-<?php
                                                    echo $payment['payment_mode'] === 'cash' ? 'success' :
                                                         ($payment['payment_mode'] === 'online' ? 'primary' : 'info');
                                                ?>">
                                                    <?php echo ucfirst($payment['payment_mode']); ?>
                                                </span>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="status-badge status-paid">Paid</span>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <a href="/parent/receipt/<?php echo $payment['id']; ?>"
                                                   class="receipt-btn" target="_blank">
                                                    <i class="fas fa-download me-1"></i>Receipt
                                                </a>
                                            </div>
                                        </div>
                                        <?php if (!empty($payment['remarks'])): ?>
                                            <div class="mt-2">
                                                <small class="text-muted"><?php echo htmlspecialchars($payment['remarks']); ?></small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="fees-card card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
                                <h5>No Payment History</h5>
                                <p class="text-muted">Payment records will appear here once fees are paid.</p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Pending Fees Alert -->
                    <?php if (($data['summary']['total_pending'] ?? 0) > 0): ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Pending Fees:</strong> ₹<?php echo number_format($data['summary']['total_pending'] ?? 0); ?>
                            Please pay your outstanding fees to avoid any inconvenience.
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        No children found in your account. Please contact the school administration to link your children.
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Filter functionality
        document.getElementById('studentSelect').addEventListener('change', function() {
            const studentId = this.value;
            const year = document.getElementById('yearSelect').value;
            updateFees(studentId, year);
        });

        document.getElementById('yearSelect').addEventListener('change', function() {
            const year = this.value;
            const studentId = document.getElementById('studentSelect').value;
            updateFees(studentId, year);
        });

        function updateFees(studentId, year) {
            const url = new URL(window.location);
            if (studentId) url.searchParams.set('student_id', studentId);
            else url.searchParams.delete('student_id');

            if (year) url.searchParams.set('year', year);
            else url.searchParams.delete('year');

            window.location.href = url.toString();
        }
    </script>
</body>
</html>