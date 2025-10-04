<!-- Student Profile content will be included in the student layout -->

<!-- Profile Information -->
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <?php if (!empty($data['student']['photo'])): ?>
                    <img src="/backend/public/uploads/students/<?php echo htmlspecialchars($data['student']['photo']); ?>"
                         alt="Profile Photo" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                <?php else: ?>
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 120px; height: 120px; font-size: 3rem;">
                        <?php echo strtoupper(substr($data['student']['first_name'], 0, 1)); ?>
                    </div>
                <?php endif; ?>
                <h5><?php echo htmlspecialchars($data['student']['first_name'] . ' ' . $data['student']['last_name']); ?></h5>
                <p class="text-muted mb-2"><?php echo htmlspecialchars($data['student']['class_name'] . ' - ' . $data['student']['section']); ?></p>
                <span class="badge bg-success">Active Student</span>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Academic Stats
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h5 class="text-primary mb-1"><?php echo $data['stats']['attendance']; ?>%</h5>
                        <small class="text-muted">Attendance</small>
                    </div>
                    <div class="col-6">
                        <h5 class="text-success mb-1"><?php echo $data['stats']['current_class']; ?></h5>
                        <small class="text-muted">Class</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Personal Information -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Personal Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Scholar Number:</strong> <?php echo htmlspecialchars($data['student']['scholar_number']); ?></p>
                        <p><strong>Admission Number:</strong> <?php echo htmlspecialchars($data['student']['admission_number']); ?></p>
                        <p><strong>Admission Date:</strong> <?php echo date('M d, Y', strtotime($data['student']['admission_date'])); ?></p>
                        <p><strong>Date of Birth:</strong> <?php echo date('M d, Y', strtotime($data['student']['date_of_birth'])); ?></p>
                        <p><strong>Gender:</strong> <?php echo ucfirst($data['student']['gender']); ?></p>
                        <p><strong>Blood Group:</strong> <?php echo htmlspecialchars($data['student']['blood_group'] ?? 'N/A'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Roll Number:</strong> <?php echo htmlspecialchars($data['student']['roll_number']); ?></p>
                        <p><strong>Nationality:</strong> <?php echo htmlspecialchars($data['student']['nationality']); ?></p>
                        <p><strong>Religion:</strong> <?php echo htmlspecialchars($data['student']['religion'] ?? 'N/A'); ?></p>
                        <p><strong>Caste/Category:</strong> <?php echo htmlspecialchars($data['student']['caste'] ?? 'N/A'); ?></p>
                        <p><strong>Mobile:</strong> <?php echo htmlspecialchars($data['student']['mobile']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($data['student']['email'] ?? 'N/A'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Parent/Guardian Information -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>Parent/Guardian Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Father's Name:</strong> <?php echo htmlspecialchars($data['student']['father_name']); ?></p>
                        <p><strong>Mother's Name:</strong> <?php echo htmlspecialchars($data['student']['mother_name']); ?></p>
                        <?php if (!empty($data['student']['guardian_name'])): ?>
                            <p><strong>Guardian's Name:</strong> <?php echo htmlspecialchars($data['student']['guardian_name']); ?></p>
                            <p><strong>Guardian Contact:</strong> <?php echo htmlspecialchars($data['student']['guardian_contact']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Permanent Address:</strong></p>
                        <p class="text-muted"><?php echo nl2br(htmlspecialchars($data['student']['permanent_address'])); ?></p>
                        <?php if (!empty($data['student']['temporary_address'])): ?>
                            <p><strong>Temporary Address:</strong></p>
                            <p class="text-muted"><?php echo nl2br(htmlspecialchars($data['student']['temporary_address'])); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Information -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-graduation-cap me-2"></i>Academic Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Current Class:</strong> <?php echo htmlspecialchars($data['student']['class_name'] . ' - ' . $data['student']['section']); ?></p>
                        <p><strong>Academic Year:</strong> <?php echo htmlspecialchars($data['student']['academic_year']); ?></p>
                        <?php if (!empty($data['student']['previous_school'])): ?>
                            <p><strong>Previous School:</strong> <?php echo htmlspecialchars($data['student']['previous_school']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Aadhar Number:</strong> <?php echo htmlspecialchars($data['student']['aadhar_number'] ?? 'N/A'); ?></p>
                        <p><strong>Samagra ID:</strong> <?php echo htmlspecialchars($data['student']['samagra_id'] ?? 'N/A'); ?></p>
                        <p><strong>Apaar ID:</strong> <?php echo htmlspecialchars($data['student']['apaar_id'] ?? 'N/A'); ?></p>
                        <p><strong>PAN Number:</strong> <?php echo htmlspecialchars($data['student']['pan_number'] ?? 'N/A'); ?></p>
                    </div>
                </div>
                
                <?php if (!empty($data['student']['medical_conditions'])): ?>
                    <div class="mt-3">
                        <p><strong>Medical Conditions:</strong></p>
                        <p class="text-muted"><?php echo nl2br(htmlspecialchars($data['student']['medical_conditions'])); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function editProfile() {
    window.location.href = '/student/profile/edit';
}

function refreshPage() {
    location.reload();
}
</script>
