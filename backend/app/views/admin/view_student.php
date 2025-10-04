<!-- Student Profile Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 text-center">
                        <?php if (!empty($data['student']['photo'])): ?>
                            <img src="/backend/public/uploads/students/<?php echo htmlspecialchars($data['student']['photo']); ?>"
                                 alt="Student Photo" class="img-thumbnail mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 150px; height: 150px; font-size: 3rem; font-weight: bold;">
                                <?php echo strtoupper(substr($data['student']['first_name'], 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-10">
                        <h2><?php echo htmlspecialchars($data['student']['first_name'] . ' ' . $data['student']['last_name']); ?></h2>
                        <p class="text-muted mb-2">
                            <i class="fas fa-id-card me-2"></i>
                            Scholar: <?php echo htmlspecialchars($data['student']['scholar_number']); ?> |
                            Admission: <?php echo htmlspecialchars($data['student']['admission_number']); ?> |
                            Class: <?php echo htmlspecialchars($data['student']['class_name'] . ' - ' . $data['student']['section']); ?> |
                            Roll: <?php echo htmlspecialchars($data['student']['roll_number']); ?>
                        </p>
                        <div class="mb-3">
                            <span class="badge bg-<?php echo $data['student']['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                <?php echo ucfirst($data['student']['status']); ?>
                            </span>
                            <span class="badge bg-info ms-2">
                                <i class="fas fa-<?php echo $data['student']['gender'] === 'male' ? 'mars' : 'venus'; ?> me-1"></i>
                                <?php echo ucfirst($data['student']['gender']); ?>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><i class="fas fa-birthday-cake me-2"></i><?php echo date('d M Y', strtotime($data['student']['date_of_birth'])); ?></p>
                                <p><i class="fas fa-mobile-alt me-2"></i><?php echo htmlspecialchars($data['student']['mobile']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="fas fa-envelope me-2"></i><?php echo htmlspecialchars($data['student']['email'] ?? 'N/A'); ?></p>
                                <p><i class="fas fa-map-marker-alt me-2"></i><?php echo htmlspecialchars($data['student']['village'] ?? 'N/A'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Student Details Tabs -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="studentTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab">
                            <i class="fas fa-user me-2"></i>Personal Details
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab">
                            <i class="fas fa-calendar-check me-2"></i>Attendance
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="fees-tab" data-bs-toggle="tab" data-bs-target="#fees" type="button" role="tab">
                            <i class="fas fa-money-bill-wave me-2"></i>Fees
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="results-tab" data-bs-toggle="tab" data-bs-target="#results" type="button" role="tab">
                            <i class="fas fa-chart-bar me-2"></i>Results
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="studentTabContent">
                    <!-- Personal Details Tab -->
                    <div class="tab-pane fade show active" id="personal" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Basic Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Father's Name:</strong></td>
                                        <td><?php echo htmlspecialchars($data['student']['father_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mother's Name:</strong></td>
                                        <td><?php echo htmlspecialchars($data['student']['mother_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Blood Group:</strong></td>
                                        <td><?php echo htmlspecialchars($data['student']['blood_group'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nationality:</strong></td>
                                        <td><?php echo htmlspecialchars($data['student']['nationality']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Religion:</strong></td>
                                        <td><?php echo htmlspecialchars($data['student']['religion'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Caste/Category:</strong></td>
                                        <td><?php echo htmlspecialchars($data['student']['caste'] ?? 'N/A'); ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Government IDs</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Aadhar Number:</strong></td>
                                        <td><?php echo htmlspecialchars($data['student']['aadhar_number'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Samagra ID:</strong></td>
                                        <td><?php echo htmlspecialchars($data['student']['samagra_id'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Apaar ID:</strong></td>
                                        <td><?php echo htmlspecialchars($data['student']['apaar_id'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>PAN Number:</strong></td>
                                        <td><?php echo htmlspecialchars($data['student']['pan_number'] ?? 'N/A'); ?></td>
                                    </tr>
                                </table>

                                <h5>Addresses</h5>
                                <p><strong>Permanent Address:</strong><br><?php echo nl2br(htmlspecialchars($data['student']['permanent_address'])); ?></p>
                                <?php if (!empty($data['student']['temporary_address'])): ?>
                                    <p><strong>Temporary Address:</strong><br><?php echo nl2br(htmlspecialchars($data['student']['temporary_address'])); ?></p>
                                <?php endif; ?>

                                <?php if (!empty($data['student']['medical_conditions'])): ?>
                                    <h5>Medical Information</h5>
                                    <p><?php echo nl2br(htmlspecialchars($data['student']['medical_conditions'])); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Tab -->
                    <div class="tab-pane fade" id="attendance" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data['attendance'])): ?>
                                        <?php foreach ($data['attendance'] as $record): ?>
                                            <tr>
                                                <td><?php echo date('d M Y', strtotime($record['attendance_date'])); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php
                                                        echo $record['status'] === 'present' ? 'success' :
                                                             ($record['status'] === 'absent' ? 'danger' : 'warning'); ?>">
                                                        <?php echo ucfirst($record['status']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars($record['remarks'] ?? ''); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center">No attendance records found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Fees Tab -->
                    <div class="tab-pane fade" id="fees" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Receipt No.</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Mode</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data['fees'])): ?>
                                        <?php foreach ($data['fees'] as $fee): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($fee['receipt_number']); ?></td>
                                                <td><?php echo date('d M Y', strtotime($fee['payment_date'])); ?></td>
                                                <td>₹<?php echo number_format($fee['amount'], 2); ?></td>
                                                <td><?php echo ucfirst($fee['payment_mode']); ?></td>
                                                <td>
                                                    <span class="badge bg-success">Paid</span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No fee records found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Results Tab -->
                    <div class="tab-pane fade" id="results" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Exam</th>
                                        <th>Subject</th>
                                        <th>Marks</th>
                                        <th>Grade</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data['results'])): ?>
                                        <?php foreach ($data['results'] as $result): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($result['exam_name']); ?></td>
                                                <td><?php echo htmlspecialchars($result['subject_name']); ?></td>
                                                <td><?php echo htmlspecialchars($result['marks_obtained']); ?></td>
                                                <td><?php echo htmlspecialchars($result['grade'] ?? 'N/A'); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo $result['marks_obtained'] >= 33 ? 'success' : 'danger'; ?>">
                                                        <?php echo $result['marks_obtained'] >= 33 ? 'Pass' : 'Fail'; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No results found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-end mt-3">
    <a href="/admin/students" class="btn btn-secondary me-2">
        <i class="fas fa-arrow-left me-2"></i>Back to Students
    </a>
    <a href="/admin/students/edit/<?php echo $data['student']['id']; ?>" class="btn btn-primary">
        <i class="fas fa-edit me-2"></i>Edit Student
    </a>
</div>