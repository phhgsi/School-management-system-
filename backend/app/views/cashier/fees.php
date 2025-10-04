<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-money-bill-wave me-2"></i>Fee Collection
            </h1>
            <p class="page-subtitle">Collect and manage student fee payments</p>
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
                <i class="fas fa-money-bill-wave fa-2x mb-2"></i>
                <h4>₹<?php echo number_format($data['today_collection']); ?></h4>
                <small>Today's Collection</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-calendar-check fa-2x mb-2"></i>
                <h4><?php echo $data['today_transactions']; ?></h4>
                <small>Today's Transactions</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <h4>₹<?php echo number_format($data['pending_amount']); ?></h4>
                <small>Pending Amount</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x mb-2"></i>
                <h4><?php echo $data['pending_students']; ?></h4>
                <small>Students with Dues</small>
            </div>
        </div>
    </div>
</div>

<!-- Fee Collection Form -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Collect Fee Payment
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/cashier/fees/collect" id="feeForm">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="scholar_number" class="form-label">Scholar Number</label>
                                <input type="text" class="form-control" id="scholar_number" name="scholar_number" 
                                       placeholder="Enter scholar number" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="button" class="btn btn-primary" onclick="findStudent()">
                                        <i class="fas fa-search me-2"></i>Find Student
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Student Info (populated after search) -->
                    <div id="studentInfo" style="display: none;">
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Student Information</h6>
                                <p class="mb-1"><strong>Name:</strong> <span id="studentName"></span></p>
                                <p class="mb-1"><strong>Class:</strong> <span id="studentClass"></span></p>
                                <p class="mb-1"><strong>Father:</strong> <span id="studentFather"></span></p>
                            </div>
                            <div class="col-md-8">
                                <h6>Fee Details</h6>
                                <div id="feeDetails"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>Recent Transactions
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($data['recent_transactions'])): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Receipt No</th>
                                    <th>Student</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Mode</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['recent_transactions'] as $transaction): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($transaction['receipt_number']); ?></td>
                                        <td><?php echo htmlspecialchars($transaction['student_name']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($transaction['payment_date'])); ?></td>
                                        <td>₹<?php echo number_format($transaction['amount'], 2); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo getPaymentModeColor($transaction['payment_mode']); ?>">
                                                <?php echo ucfirst($transaction['payment_mode']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="printReceipt(<?php echo $transaction['id']; ?>)">
                                                <i class="fas fa-print"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-3">No recent transactions found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function refreshPage() {
    location.reload();
}

function findStudent() {
    const scholarNumber = document.getElementById('scholar_number').value.trim();
    if (!scholarNumber) {
        alert('Please enter scholar number');
        return;
    }
    
    // AJAX call to find student and fee details
    fetch('/api/students?scholar_number=' + scholarNumber)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data.length > 0) {
                const student = data.data[0];
                document.getElementById('studentName').textContent = student.first_name + ' ' + student.last_name;
                document.getElementById('studentClass').textContent = student.class_name + ' - ' + student.section;
                document.getElementById('studentFather').textContent = student.father_name;
                document.getElementById('studentInfo').style.display = 'block';
                
                // Load fee details
                loadFeeDetails(student.id);
            } else {
                alert('Student not found');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error finding student');
        });
}

function loadFeeDetails(studentId) {
    fetch('/api/fees?student_id=' + studentId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let html = '';
                data.data.forEach(fee => {
                    html += `
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="fee_types[]" value="${fee.id}" id="fee_${fee.id}">
                            <label class="form-check-label" for="fee_${fee.id}">
                                ${fee.fee_name} - ₹${fee.amount}
                                ${fee.pending_amount > 0 ? `<small class="text-danger">(₹${fee.pending_amount} pending)</small>` : '<small class="text-success">(Paid)</small>'}
                            </label>
                        </div>
                    `;
                });
                document.getElementById('feeDetails').innerHTML = html;
            }
        });
}

function printReceipt(transactionId) {
    window.open('/cashier/fees/receipt/' + transactionId, '_blank');
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
