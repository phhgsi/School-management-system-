<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-user me-2"></i>My Profile
            </h1>
            <p class="page-subtitle">Manage your personal information and settings</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" onclick="editProfile()">
                <i class="fas fa-edit me-2"></i>Edit Profile
            </button>
        </div>
    </div>
</div>

<!-- Profile Information -->
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <?php if (!empty($data['teacher']['photo'])): ?>
                    <img src="/backend/public/uploads/teachers/<?php echo htmlspecialchars($data['teacher']['photo']); ?>"
                         alt="Profile Photo" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                <?php else: ?>
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 120px; height: 120px; font-size: 3rem;">
                        <?php echo strtoupper(substr($data['teacher']['first_name'], 0, 1)); ?>
                    </div>
                <?php endif; ?>
                <h5><?php echo htmlspecialchars($data['teacher']['first_name'] . ' ' . $data['teacher']['last_name']); ?></h5>
                <p class="text-muted mb-2"><?php echo htmlspecialchars($data['teacher']['designation']); ?></p>
                <span class="badge bg-success">Active</span>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Quick Stats
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h5 class="text-primary mb-1"><?php echo $data['stats']['total_classes']; ?></h5>
                        <small class="text-muted">Classes</small>
                    </div>
                    <div class="col-6">
                        <h5 class="text-success mb-1"><?php echo $data['stats']['total_students']; ?></h5>
                        <small class="text-muted">Students</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Personal Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Employee ID:</strong> <?php echo htmlspecialchars($data['teacher']['employee_id']); ?></p>
                        <p><strong>Date of Birth:</strong> <?php echo date('M d, Y', strtotime($data['teacher']['date_of_birth'])); ?></p>
                        <p><strong>Gender:</strong> <?php echo ucfirst($data['teacher']['gender']); ?></p>
                        <p><strong>Marital Status:</strong> <?php echo ucfirst($data['teacher']['marital_status']); ?></p>
                        <p><strong>Blood Group:</strong> <?php echo htmlspecialchars($data['teacher']['blood_group'] ?? 'N/A'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Qualification:</strong> <?php echo htmlspecialchars($data['teacher']['qualification']); ?></p>
                        <p><strong>Specialization:</strong> <?php echo htmlspecialchars($data['teacher']['specialization'] ?? 'N/A'); ?></p>
                        <p><strong>Department:</strong> <?php echo htmlspecialchars($data['teacher']['department'] ?? 'N/A'); ?></p>
                        <p><strong>Date of Joining:</strong> <?php echo date('M d, Y', strtotime($data['teacher']['date_of_joining'])); ?></p>
                        <p><strong>Experience:</strong> <?php echo $data['teacher']['experience_years']; ?> years</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-address-book me-2"></i>Contact Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Mobile:</strong> <?php echo htmlspecialchars($data['teacher']['mobile']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($data['teacher']['email'] ?? 'N/A'); ?></p>
                        <p><strong>Aadhar Number:</strong> <?php echo htmlspecialchars($data['teacher']['aadhar_number'] ?? 'N/A'); ?></p>
                        <p><strong>PAN Number:</strong> <?php echo htmlspecialchars($data['teacher']['pan_number'] ?? 'N/A'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Permanent Address:</strong></p>
                        <p class="text-muted"><?php echo nl2br(htmlspecialchars($data['teacher']['permanent_address'])); ?></p>
                        <?php if (!empty($data['teacher']['temporary_address'])): ?>
                            <p><strong>Temporary Address:</strong></p>
                            <p class="text-muted"><?php echo nl2br(htmlspecialchars($data['teacher']['temporary_address'])); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assigned Classes -->
        <?php if (!empty($data['assigned_classes'])): ?>
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chalkboard me-2"></i>Assigned Classes & Subjects
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($data['assigned_classes'] as $assignment): ?>
                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3">
                                <h6><?php echo htmlspecialchars($assignment['class_name'] . ' - ' . $assignment['section']); ?></h6>
                                <p class="mb-1"><strong>Subject:</strong> <?php echo htmlspecialchars($assignment['subject_name']); ?></p>
                                <?php if ($assignment['is_class_teacher']): ?>
                                    <span class="badge bg-primary">Class Teacher</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function editProfile() {
    window.location.href = '/teacher/profile/edit';
}

function refreshPage() {
    location.reload();
}
</script>
