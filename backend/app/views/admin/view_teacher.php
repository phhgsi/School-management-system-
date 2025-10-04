<!-- Teacher Profile Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 text-center">
                        <?php if (!empty($data['teacher']['photo'])): ?>
                            <img src="/backend/public/uploads/teachers/<?php echo htmlspecialchars($data['teacher']['photo']); ?>"
                                 alt="Teacher Photo" class="img-thumbnail mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 150px; height: 150px; font-size: 3rem; font-weight: bold;">
                                <?php echo strtoupper(substr($data['teacher']['first_name'], 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-10">
                        <h2><?php echo htmlspecialchars($data['teacher']['first_name'] . ' ' . $data['teacher']['last_name']); ?></h2>
                        <p class="text-muted mb-2">
                            <i class="fas fa-id-badge me-2"></i>
                            Employee ID: <?php echo htmlspecialchars($data['teacher']['employee_id']); ?> |
                            Designation: <?php echo htmlspecialchars($data['teacher']['designation']); ?> |
                            Department: <?php echo htmlspecialchars($data['teacher']['department'] ?? 'N/A'); ?>
                        </p>
                        <div class="mb-3">
                            <span class="badge bg-<?php echo $data['teacher']['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                <?php echo ucfirst($data['teacher']['status']); ?>
                            </span>
                            <span class="badge bg-info ms-2">
                                <i class="fas fa-<?php echo $data['teacher']['gender'] === 'male' ? 'mars' : 'venus'; ?> me-1"></i>
                                <?php echo ucfirst($data['teacher']['gender']); ?>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><i class="fas fa-birthday-cake me-2"></i><?php echo date('d M Y', strtotime($data['teacher']['date_of_birth'])); ?></p>
                                <p><i class="fas fa-mobile-alt me-2"></i><?php echo htmlspecialchars($data['teacher']['mobile']); ?></p>
                                <p><i class="fas fa-calendar-check me-2"></i>Joined: <?php echo date('d M Y', strtotime($data['teacher']['date_of_joining'])); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="fas fa-envelope me-2"></i><?php echo htmlspecialchars($data['teacher']['email'] ?? 'N/A'); ?></p>
                                <p><i class="fas fa-graduation-cap me-2"></i><?php echo htmlspecialchars($data['teacher']['qualification']); ?></p>
                                <p><i class="fas fa-briefcase me-2"></i>Experience: <?php echo htmlspecialchars($data['teacher']['experience_years']); ?> years</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Teacher Details Tabs -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="teacherTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab">
                            <i class="fas fa-user me-2"></i>Personal Details
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="professional-tab" data-bs-toggle="tab" data-bs-target="#professional" type="button" role="tab">
                            <i class="fas fa-briefcase me-2"></i>Professional Details
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab">
                            <i class="fas fa-calendar-check me-2"></i>Attendance
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="classes-tab" data-bs-toggle="tab" data-bs-target="#classes" type="button" role="tab">
                            <i class="fas fa-school me-2"></i>Assigned Classes
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="teacherTabContent">
                    <!-- Personal Details Tab -->
                    <div class="tab-pane fade show active" id="personal" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Basic Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Blood Group:</strong></td>
                                        <td><?php echo htmlspecialchars($data['teacher']['blood_group'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Marital Status:</strong></td>
                                        <td><?php echo htmlspecialchars($data['teacher']['marital_status'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Specialization:</strong></td>
                                        <td><?php echo htmlspecialchars($data['teacher']['specialization'] ?? 'N/A'); ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Government IDs</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Aadhar Number:</strong></td>
                                        <td><?php echo htmlspecialchars($data['teacher']['aadhar_number'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>PAN Number:</strong></td>
                                        <td><?php echo htmlspecialchars($data['teacher']['pan_number'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Samagra ID:</strong></td>
                                        <td><?php echo htmlspecialchars($data['teacher']['samagra_id'] ?? 'N/A'); ?></td>
                                    </tr>
                                </table>

                                <h5>Addresses</h5>
                                <p><strong>Permanent Address:</strong><br><?php echo nl2br(htmlspecialchars($data['teacher']['permanent_address'])); ?></p>
                                <?php if (!empty($data['teacher']['temporary_address'])): ?>
                                    <p><strong>Temporary Address:</strong><br><?php echo nl2br(htmlspecialchars($data['teacher']['temporary_address'])); ?></p>
                                <?php endif; ?>

                                <?php if (!empty($data['teacher']['medical_conditions'])): ?>
                                    <h5>Medical Information</h5>
                                    <p><?php echo nl2br(htmlspecialchars($data['teacher']['medical_conditions'])); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Details Tab -->
                    <div class="tab-pane fade" id="professional" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Professional Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Employee ID:</strong></td>
                                        <td><?php echo htmlspecialchars($data['teacher']['employee_id']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Designation:</strong></td>
                                        <td><?php echo htmlspecialchars($data['teacher']['designation']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Department:</strong></td>
                                        <td><?php echo htmlspecialchars($data['teacher']['department'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Qualification:</strong></td>
                                        <td><?php echo htmlspecialchars($data['teacher']['qualification']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date of Joining:</strong></td>
                                        <td><?php echo date('d M Y', strtotime($data['teacher']['date_of_joining'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Experience:</strong></td>
                                        <td><?php echo htmlspecialchars($data['teacher']['experience_years']); ?> years</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Work Statistics</h5>
                                <?php
                                $teacherModel = new Teacher($this->db);
                                $workload = $teacherModel->getTeacherWorkload($data['teacher']['id']);
                                ?>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Classes Assigned:</strong></td>
                                        <td><?php echo $workload['class_count'] ?? 0; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Subjects Teaching:</strong></td>
                                        <td><?php echo $workload['subject_count'] ?? 0; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Students:</strong></td>
                                        <td><?php echo $workload['student_count'] ?? 0; ?></td>
                                    </tr>
                                </table>
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
                                    <?php
                                    $attendance = $teacherModel->getTeacherAttendance($data['teacher']['id']);
                                    if (!empty($attendance)):
                                        foreach ($attendance as $record): ?>
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
                                        <?php endforeach;
                                    else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center">No attendance records found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Assigned Classes Tab -->
                    <div class="tab-pane fade" id="classes" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Subject</th>
                                        <th>Class Teacher</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $classes = $teacherModel->getTeacherClasses($data['teacher']['id']);
                                    if (!empty($classes)):
                                        foreach ($classes as $class): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($class['class_name']); ?></td>
                                                <td><?php echo htmlspecialchars($class['section']); ?></td>
                                                <td><?php echo htmlspecialchars($class['subject_name']); ?></td>
                                                <td>
                                                    <?php if ($class['is_class_teacher']): ?>
                                                        <span class="badge bg-primary">Yes</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">No</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach;
                                    else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No class assignments found</td>
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
    <a href="/admin/teachers" class="btn btn-secondary me-2">
        <i class="fas fa-arrow-left me-2"></i>Back to Teachers
    </a>
    <a href="/admin/teachers/edit/<?php echo $data['teacher']['id']; ?>" class="btn btn-primary">
        <i class="fas fa-edit me-2"></i>Edit Teacher
    </a>
</div>