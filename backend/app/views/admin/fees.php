<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-money-bill-wave me-2"></i>Fee Management
            </h1>
            <p class="page-subtitle">Manage fee structures, collect payments, and track financial records</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#collectFeeModal">
                <i class="fas fa-plus me-2"></i>Collect Fee
            </button>
            <button class="btn btn-secondary" onclick="exportFinancialReport()">
                <i class="fas fa-download me-2"></i>Export Report
            </button>
        </div>
    </div>
</div>

<!-- Financial Overview -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-success">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stats-value">₹<?php echo number_format($data['monthly_collection'], 2); ?></div>
            <div class="stats-label">This Month</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stats-value">₹<?php echo number_format($data['pending_fees'], 2); ?></div>
            <div class="stats-label">Pending</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-info">
                <i class="fas fa-receipt"></i>
            </div>
            <div class="stats-value"><?php echo count($data['recent_payments']); ?></div>
            <div class="stats-label">Recent Payments</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-primary">
                <i class="fas fa-percentage"></i>
            </div>
            <div class="stats-value">
                <?php
                $total_expected = $data['monthly_collection'] + $data['pending_fees'];
                $collection_rate = $total_expected > 0 ? ($data['monthly_collection'] / $total_expected) * 100 : 0;
                echo number_format($collection_rate, 1) . '%';
                ?>
            </div>
            <div class="stats-label">Collection Rate</div>
        </div>
    </div>
</div>

<!-- Fee Structure Management -->
<div class="row mb-4">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cog me-2"></i>Fee Structure
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Fee Type</th>
                                <th>Class</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['fee_structure'])): ?>
                                <?php foreach ($data['fee_structure'] as $fee): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($fee['fee_name']); ?></td>
                                        <td><?php echo htmlspecialchars($fee['class_name'] ?? 'All Classes'); ?></td>
                                        <td>₹<?php echo number_format($fee['amount'], 2); ?></td>
                                        <td><?php echo $fee['due_date'] ? date('d/m/Y', strtotime($fee['due_date'])) : 'N/A'; ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" title="Edit Fee"
                                                    onclick="editFeeStructure(<?php echo $fee['id']; ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-3">
                                        <p class="text-muted mb-0">No fee structures defined yet.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#addFeeStructureModal">
                    <i class="fas fa-plus me-2"></i>Add Fee Structure
                </button>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-receipt me-2"></i>Recent Payments
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Receipt No.</th>
                                <th>Student</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['recent_payments'])): ?>
                                <?php foreach ($data['recent_payments'] as $payment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($payment['receipt_number']); ?></td>
                                        <td><?php echo htmlspecialchars($payment['student_name']); ?></td>
                                        <td>₹<?php echo number_format($payment['amount'], 2); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($payment['payment_date'])); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" title="View Receipt"
                                                    onclick="viewReceipt(<?php echo $payment['id']; ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-success" title="Print Receipt"
                                                    onclick="printReceipt(<?php echo $payment['id']; ?>)">
                                                <i class="fas fa-print"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-3">
                                        <p class="text-muted mb-0">No recent payments found.</p>
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

<!-- Pending Fees -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>Pending Fees
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Student Name</th>
                                <th>Class</th>
                                <th>Fee Type</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                                <th>Days Overdue</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['pending_fees'])): ?>
                                <?php foreach ($data['pending_fees'] as $pending): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($pending['student_name']); ?></td>
                                        <td><?php echo htmlspecialchars($pending['class_name']); ?></td>
                                        <td><?php echo htmlspecialchars($pending['fee_name']); ?></td>
                                        <td>₹<?php echo number_format($pending['amount'], 2); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($pending['due_date'])); ?></td>
                                        <td>
                                            <?php
                                            $days_overdue = floor((time() - strtotime($pending['due_date'])) / (60 * 60 * 24));
                                            $badge_class = $days_overdue > 30 ? 'danger' : ($days_overdue > 7 ? 'warning' : 'info');
                                            ?>
                                            <span class="badge bg-<?php echo $badge_class; ?>"><?php echo $days_overdue; ?> days</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-success" title="Collect Payment"
                                                    onclick="collectPendingFee(<?php echo $pending['student_id']; ?>, <?php echo $pending['fee_structure_id']; ?>)">
                                                <i class="fas fa-money-bill-wave"></i> Collect
                                            </button>
                                            <button class="btn btn-sm btn-warning" title="Send Reminder"
                                                    onclick="sendReminder(<?php echo $pending['student_id']; ?>)">
                                                <i class="fas fa-bell"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                                        <p class="text-muted">No pending fees! All payments are up to date.</p>
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

<!-- Collect Fee Modal -->
<div class="modal fade" id="collectFeeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-money-bill-wave me-2"></i>Collect Fee Payment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/admin/fees/collect">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">

                    <!-- Student Selection -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="class_filter" class="form-label">Filter by Class</label>
                                <select class="form-select" id="class_filter" onchange="filterStudents()">
                                    <option value="">All Classes</option>
                                    <?php foreach ($data['classes'] as $class): ?>
                                        <option value="<?php echo $class['id']; ?>">
                                            <?php echo htmlspecialchars($class['class_name'] . ' - ' . $class['section']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="student_id" class="form-label">Select Student *</label>
                                <select class="form-select" id="student_id" name="student_id" required onchange="loadStudentFees()">
                                    <option value="">Choose Student</option>
                                    <!-- Students will be loaded here -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Student Info (Auto-filled) -->
                    <div id="studentInfo" style="display: none;">
                        <div class="alert alert-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Student:</strong> <span id="studentName"></span><br>
                                    <strong>Class:</strong> <span id="studentClass"></span><br>
                                    <strong>Father:</strong> <span id="studentFather"></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Scholar No:</strong> <span id="studentScholar"></span><br>
                                    <strong>Mobile:</strong> <span id="studentMobile"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fee Details -->
                    <div id="feeDetails">
                        <h6>Fee Details</h6>
                        <div class="table-responsive">
                            <table class="table table-sm" id="feeTable">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Fee Type</th>
                                        <th>Amount</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Fee items will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="payment_mode" class="form-label">Payment Mode *</label>
                                <select class="form-select" id="payment_mode" name="payment_mode" required onchange="togglePaymentFields()">
                                    <option value="cash">Cash</option>
                                    <option value="online">Online</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="upi">UPI</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="payment_date" class="form-label">Payment Date *</label>
                                <input type="date" class="form-control" id="payment_date" name="payment_date"
                                       value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div id="transactionFields">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="transaction_id" class="form-label">Transaction ID</label>
                                    <input type="text" class="form-control" id="transaction_id" name="transaction_id">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="receipt_number" class="form-label">Receipt Number *</label>
                                    <input type="text" class="form-control" id="receipt_number" name="receipt_number" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="2"></textarea>
                    </div>

                    <!-- Payment Summary -->
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Payment Summary</h6>
                                    <p class="mb-1">Subtotal: <span id="subtotal">₹0.00</span></p>
                                    <p class="mb-1">Discount: <span id="totalDiscount">₹0.00</span></p>
                                    <p class="mb-0"><strong>Total: <span id="totalAmount">₹0.00</span></strong></p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button type="button" class="btn btn-info" onclick="generateReceipt()">
                                        <i class="fas fa-receipt me-2"></i>Generate Receipt
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Process Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Fee Structure Modal -->
<div class="modal fade" id="addFeeStructureModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Add Fee Structure
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/admin/fees/add-structure">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">

                    <div class="mb-3">
                        <label for="fee_name" class="form-label">Fee Name *</label>
                        <input type="text" class="form-control" id="fee_name" name="fee_name" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fee_type" class="form-label">Fee Type *</label>
                                <select class="form-select" id="fee_type" name="fee_type" required>
                                    <option value="">Select Type</option>
                                    <option value="tuition">Tuition</option>
                                    <option value="transport">Transport</option>
                                    <option value="hostel">Hostel</option>
                                    <option value="books">Books</option>
                                    <option value="uniform">Uniform</option>
                                    <option value="activity">Activity</option>
                                    <option value="exam">Exam</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount *</label>
                                <input type="number" class="form-control" id="amount" name="amount"
                                       min="0" step="0.01" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="class_id" class="form-label">Applicable Class (Leave empty for all classes)</label>
                        <select class="form-select" id="class_id" name="class_id">
                            <option value="">All Classes</option>
                            <?php foreach ($data['classes'] as $class): ?>
                                <option value="<?php echo $class['id']; ?>">
                                    <?php echo htmlspecialchars($class['class_name'] . ' - ' . $class['section']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date">
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_optional" name="is_optional">
                            <label class="form-check-label" for="is_optional">
                                This is an optional fee
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Add Fee Structure
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Filter students by class
    function filterStudents() {
        const classId = document.getElementById('class_filter').value;
        const studentSelect = document.getElementById('student_id');

        // Clear current options
        studentSelect.innerHTML = '<option value="">Choose Student</option>';

        if (!classId) return;

        // Fetch students for selected class
        fetch(`/api/students/class/${classId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(student => {
                    const option = document.createElement('option');
                    option.value = student.id;
                    option.textContent = `${student.first_name} ${student.last_name} (${student.scholar_number})`;
                    studentSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading students:', error);
            });
    }

    // Load student fees and info
    function loadStudentFees() {
        const studentId = document.getElementById('student_id').value;

        if (!studentId) {
            document.getElementById('studentInfo').style.display = 'none';
            document.getElementById('feeDetails').style.display = 'none';
            return;
        }

        // Fetch student details and fees
        fetch(`/api/students/${studentId}/fees`)
            .then(response => response.json())
            .then(data => {
                // Show student info
                document.getElementById('studentName').textContent = data.student.first_name + ' ' + data.student.last_name;
                document.getElementById('studentClass').textContent = data.student.class_name;
                document.getElementById('studentFather').textContent = data.student.father_name;
                document.getElementById('studentScholar').textContent = data.student.scholar_number;
                document.getElementById('studentMobile').textContent = data.student.mobile;
                document.getElementById('studentInfo').style.display = 'block';

                // Load fee details
                loadFeeDetails(data.fees);
            })
            .catch(error => {
                console.error('Error loading student data:', error);
            });
    }

    // Load fee details for student
    function loadFeeDetails(fees) {
        const tbody = document.getElementById('feeTable').querySelector('tbody');
        tbody.innerHTML = '';

        fees.forEach(fee => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><input type="checkbox" name="fee_ids[]" value="${fee.id}" onchange="calculateTotal()"></td>
                <td>${fee.fee_name}</td>
                <td>₹${parseFloat(fee.amount).toFixed(2)}</td>
                <td><input type="number" name="discounts[${fee.id}]" class="form-control form-control-sm" min="0" max="${fee.amount}" step="0.01" value="0" onchange="calculateTotal()"></td>
                <td>₹${parseFloat(fee.amount).toFixed(2)}</td>
            `;
            tbody.appendChild(row);
        });

        document.getElementById('feeDetails').style.display = 'block';
        calculateTotal();
    }

    // Calculate total amount
    function calculateTotal() {
        const checkboxes = document.querySelectorAll('input[name="fee_ids[]"]:checked');
        let subtotal = 0;
        let totalDiscount = 0;

        checkboxes.forEach(checkbox => {
            const row = checkbox.closest('tr');
            const amount = parseFloat(row.cells[2].textContent.replace('₹', ''));
            const discountInput = row.querySelector('input[name^="discounts"]');
            const discount = parseFloat(discountInput.value) || 0;

            subtotal += amount;
            totalDiscount += discount;
        });

        document.getElementById('subtotal').textContent = '₹' + subtotal.toFixed(2);
        document.getElementById('totalDiscount').textContent = '₹' + totalDiscount.toFixed(2);
        document.getElementById('totalAmount').textContent = '₹' + (subtotal - totalDiscount).toFixed(2);
    }

    // Toggle transaction fields based on payment mode
    function togglePaymentFields() {
        const paymentMode = document.getElementById('payment_mode').value;
        const transactionFields = document.getElementById('transactionFields');
        const transactionId = document.getElementById('transaction_id');

        if (paymentMode === 'cash') {
            transactionFields.style.display = 'none';
            transactionId.required = false;
        } else {
            transactionFields.style.display = 'block';
            transactionId.required = true;
        }
    }

    // Generate receipt number
    function generateReceipt() {
        const receiptInput = document.getElementById('receipt_number');
        if (!receiptInput.value) {
            const timestamp = Date.now();
            receiptInput.value = 'RCP' + timestamp.toString().slice(-8);
        }
    }

    // Collect pending fee
    function collectPendingFee(studentId, feeStructureId) {
        document.getElementById('student_id').value = studentId;
        loadStudentFees();

        // Check the specific fee
        setTimeout(() => {
            const checkboxes = document.querySelectorAll('input[name="fee_ids[]"]');
            checkboxes.forEach(cb => {
                if (cb.value == feeStructureId) {
                    cb.checked = true;
                }
            });
            calculateTotal();
        }, 1000);

        document.querySelector('[data-bs-target="#collectFeeModal"]').click();
    }

    // View receipt
    function viewReceipt(paymentId) {
        window.open('/admin/fees/receipt/' + paymentId, '_blank');
    }

    // Print receipt
    function printReceipt(paymentId) {
        window.open('/admin/fees/receipt/' + paymentId + '?print=1', '_blank');
    }

    // Send reminder
    function sendReminder(studentId) {
        if (confirm('Send fee reminder to this student?')) {
            fetch('/admin/fees/send-reminder/' + studentId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'csrf_token=<?php echo htmlspecialchars($data['csrf_token']); ?>'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Reminder sent successfully!');
                } else {
                    alert('Error sending reminder: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error sending reminder');
                console.error('Error:', error);
            });
        }
    }

    // Export financial report
    function exportFinancialReport() {
        window.location.href = '/admin/fees/export-report';
    }

    // Edit fee structure
    function editFeeStructure(id) {
        window.location.href = '/admin/fees/edit-structure/' + id;
    }
</script>