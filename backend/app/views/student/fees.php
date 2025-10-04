<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-money-bill-wave me-2"></i>My Fees
            </h1>
            <p class="page-subtitle">View your fee payment history and pending dues</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" onclick="refreshPage()">
                <i class="fas fa-sync-alt me-2"></i>Refresh
            </button>
        </div>
    </div>
</div>

<!-- Fee Summary Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <h4>₹<?php echo number_format($data['summary']['total_paid']); ?></h4>
                <small>Total Paid</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                <h4>₹<?php echo number_format($data['summary']['pending_amount']); ?></h4>
                <small>Pending Amount</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-receipt fa-2x mb-2"></i>
                <h4><?php echo $data['summary']['total_payments']; ?></h4>
                <small>Total Payments</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                <h4><?php echo $data['summary']['next_due_date'] ?? 'N/A'; ?></h4>
                <small>Next Due Date</small>
            </div>
        </div>
    </div>
</div>

<!-- Fee Structure -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Fee Structure (<?php echo htmlspecialchars($data['academic_year']); ?>)
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fee Type</th>
                                <th>Amount</th>
                                <th>Paid Amount</th>
                                <th>Pending Amount</th>
                                <th>Status</th>
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['fee_structure'] as $fee): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($fee['fee_name']); ?></td>
                                    <td>₹<?php echo number_format($fee['amount'], 2); ?></td>
                                    <td>₹<?php echo number_format($fee['paid_amount'], 2); ?></td>
                                    <td class="<?php echo $fee['pending_amount'] > 0 ? 'text-danger' : 'text-success'; ?>">
                                        ₹<?php echo number_format($fee['pending_amount'], 2); ?>
                                    </td>
                                    <td>
                                        <?php if ($fee['pending_amount'] == 0): ?>
                                            <span class="badge bg-success">Paid</span>
                                        <?php elseif ($fee['paid_amount'] > 0): ?>
                                            <span class="badge bg-warning">Partial</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Unpaid</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($fee['due_date']): ?>
                                            <?php echo date('M d, Y', strtotime($fee['due_date'])); ?>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-primary">
                            <tr>
                                <th>Total</th>
                                <th>₹<?php echo number_format($data['summary']['total_fee'], 2); ?></th>
                                <th>₹<?php echo number_format($data['summary']['total_paid'], 2); ?></th>
                                <th class="text-danger">₹<?php echo number_format($data['summary']['pending_amount'], 2); ?></th>
                                <th colspan="2">
                                    <?php
                                    $percentage = $data['summary']['total_fee'] > 0 ?
                                        round(($data['summary']['total_paid'] / $data['summary']['total_fee']) * 100, 1) : 0;
                                    ?>
                                    <?php echo $percentage; ?>% Paid
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment History -->
<?php if (!empty($data['payment_history'])): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>Payment History
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Receipt No</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Payment Mode</th>
                                <th>Fee Period</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['payment_history'] as $payment): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($payment['receipt_number']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($payment['payment_date'])); ?></td>
                                    <td>₹<?php echo number_format($payment['amount'], 2); ?></td>
                                    <td>
                                        <span class="badge bg-<?php
                                            echo getPaymentModeColor($payment['payment_mode']);
                                        ?>">
                                            <?php echo ucfirst($payment['payment_mode']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                        if ($payment['fee_month'] && $payment['fee_year']) {
                                            echo htmlspecialchars($payment['fee_month'] . ' ' . $payment['fee_year']);
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" onclick="printReceipt(<?php echo $payment['id']; ?>)">
                                            <i class="fas fa-print me-1"></i>Print
                                        </button>
                                        <?php if (!empty($payment['transaction_id'])): ?>
                                            <button class="btn btn-sm btn-outline-info" onclick="viewTransaction(<?php echo $payment['id']; ?>)">
                                                <i class="fas fa-eye me-1"></i>Details
                                            </button>
                                        <?php endif; ?>
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
<?php endif; ?>

<!-- Online Payment (if enabled) -->
<?php if (ENABLE_ONLINE_PAYMENT): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-credit-card me-2"></i>Pay Online
                </h5>
            </div>
            <div class="card-body">
                <?php if ($data['summary']['pending_amount'] > 0): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Pending Amount:</strong> ₹<?php echo number_format($data['summary']['pending_amount'], 2); ?></p>
                            <p><strong>Payment Methods:</strong></p>
                            <div class="mb-3">
                                <button class="btn btn-primary me-2" onclick="payWithRazorpay()">
                                    <i class="fas fa-mobile-alt me-2"></i>Razorpay
                                </button>
                                <button class="btn btn-warning" onclick="payWithPayPal()">
                                    <i class="fab fa-paypal me-2"></i>PayPal
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Payment Instructions:</strong><br>
                                - Online payments are processed securely<br>
                                - Receipt will be generated automatically<br>
                                - For any issues, contact school office
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-success text-center">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>All fees are paid!</strong> No pending payments.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
function refreshPage() {
    location.reload();
}

function printReceipt(paymentId) {
    window.open('/student/fees/receipt/' + paymentId, '_blank');
}

function viewTransaction(paymentId) {
    // Show transaction details modal
    alert('Transaction details feature coming soon!');
}

function payWithRazorpay() {
    <?php if ($data['summary']['pending_amount'] > 0): ?>
        // Initialize Razorpay payment
        const options = {
            key: '<?php echo RAZORPAY_KEY; ?>',
            amount: <?php echo $data['summary']['pending_amount'] * 100; ?>, // Amount in paise
            currency: 'INR',
            name: '<?php echo SCHOOL_NAME; ?>',
            description: 'Fee Payment',
            handler: function(response) {
                // Handle payment success
                window.location.href = '/student/fees/payment-success?payment_id=' + response.razorpay_payment_id;
            }
        };
        const rzp = new Razorpay(options);
        rzp.open();
    <?php endif; ?>
}

function payWithPayPal() {
    <?php if ($data['summary']['pending_amount'] > 0): ?>
        // Redirect to PayPal payment
        window.location.href = '/student/fees/paypal-payment?amount=<?php echo $data['summary']['pending_amount']; ?>';
    <?php endif; ?>
}

<?php
function getPaymentModeColor($mode) {
    $colors = [
        'cash' => 'success',
        'online' => 'primary',
        'cheque' => 'warning',
        'upi' => 'info',
        'bank_transfer' => 'secondary'
    ];
    return $colors[$mode] ?? 'secondary';
}
?>
</script>