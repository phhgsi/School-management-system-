<!-- Edit Teacher Form -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-edit me-2"></i>Edit Teacher Details
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="employee_id" class="form-label">Employee ID *</label>
                        <input type="text" class="form-control" id="employee_id" name="employee_id"
                               value="<?php echo htmlspecialchars($data['teacher']['employee_id']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="designation" class="form-label">Designation *</label>
                        <input type="text" class="form-control" id="designation" name="designation"
                               value="<?php echo htmlspecialchars($data['teacher']['designation']); ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name *</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                               value="<?php echo htmlspecialchars($data['teacher']['first_name']); ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name"
                               value="<?php echo htmlspecialchars($data['teacher']['middle_name'] ?? ''); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name *</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                               value="<?php echo htmlspecialchars($data['teacher']['last_name']); ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Date of Birth *</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                               value="<?php echo htmlspecialchars($data['teacher']['date_of_birth']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender *</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="male" <?php echo $data['teacher']['gender'] === 'male' ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo $data['teacher']['gender'] === 'female' ? 'selected' : ''; ?>>Female</option>
                            <option value="other" <?php echo $data['teacher']['gender'] === 'other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="qualification" class="form-label">Qualification *</label>
                        <input type="text" class="form-control" id="qualification" name="qualification"
                               value="<?php echo htmlspecialchars($data['teacher']['qualification']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="specialization" class="form-label">Specialization</label>
                        <input type="text" class="form-control" id="specialization" name="specialization"
                               value="<?php echo htmlspecialchars($data['teacher']['specialization'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" class="form-control" id="department" name="department"
                               value="<?php echo htmlspecialchars($data['teacher']['department'] ?? ''); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="marital_status" class="form-label">Marital Status</label>
                        <select class="form-select" id="marital_status" name="marital_status">
                            <option value="">Select Status</option>
                            <option value="single" <?php echo $data['teacher']['marital_status'] === 'single' ? 'selected' : ''; ?>>Single</option>
                            <option value="married" <?php echo $data['teacher']['marital_status'] === 'married' ? 'selected' : ''; ?>>Married</option>
                            <option value="divorced" <?php echo $data['teacher']['marital_status'] === 'divorced' ? 'selected' : ''; ?>>Divorced</option>
                            <option value="widowed" <?php echo $data['teacher']['marital_status'] === 'widowed' ? 'selected' : ''; ?>>Widowed</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="date_of_joining" class="form-label">Date of Joining *</label>
                        <input type="date" class="form-control" id="date_of_joining" name="date_of_joining"
                               value="<?php echo htmlspecialchars($data['teacher']['date_of_joining']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="experience_years" class="form-label">Experience (Years)</label>
                        <input type="number" class="form-control" id="experience_years" name="experience_years"
                               value="<?php echo htmlspecialchars($data['teacher']['experience_years']); ?>" min="0">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile Number *</label>
                        <input type="tel" class="form-control" id="mobile" name="mobile"
                               value="<?php echo htmlspecialchars($data['teacher']['mobile']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?php echo htmlspecialchars($data['teacher']['email'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="blood_group" class="form-label">Blood Group</label>
                        <select class="form-select" id="blood_group" name="blood_group">
                            <option value="">Select Blood Group</option>
                            <option value="A+" <?php echo $data['teacher']['blood_group'] === 'A+' ? 'selected' : ''; ?>>A+</option>
                            <option value="A-" <?php echo $data['teacher']['blood_group'] === 'A-' ? 'selected' : ''; ?>>A-</option>
                            <option value="B+" <?php echo $data['teacher']['blood_group'] === 'B+' ? 'selected' : ''; ?>>B+</option>
                            <option value="B-" <?php echo $data['teacher']['blood_group'] === 'B-' ? 'selected' : ''; ?>>B-</option>
                            <option value="AB+" <?php echo $data['teacher']['blood_group'] === 'AB+' ? 'selected' : ''; ?>>AB+</option>
                            <option value="AB-" <?php echo $data['teacher']['blood_group'] === 'AB-' ? 'selected' : ''; ?>>AB-</option>
                            <option value="O+" <?php echo $data['teacher']['blood_group'] === 'O+' ? 'selected' : ''; ?>>O+</option>
                            <option value="O-" <?php echo $data['teacher']['blood_group'] === 'O-' ? 'selected' : ''; ?>>O-</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" <?php echo $data['teacher']['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo $data['teacher']['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                            <option value="resigned" <?php echo $data['teacher']['status'] === 'resigned' ? 'selected' : ''; ?>>Resigned</option>
                            <option value="terminated" <?php echo $data['teacher']['status'] === 'terminated' ? 'selected' : ''; ?>>Terminated</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="permanent_address" class="form-label">Permanent Address *</label>
                <textarea class="form-control" id="permanent_address" name="permanent_address" rows="3" required><?php echo htmlspecialchars($data['teacher']['permanent_address']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Teacher Photo</label>
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                <?php if (!empty($data['teacher']['photo'])): ?>
                    <div class="mt-2">
                        <img src="/backend/public/uploads/teachers/<?php echo htmlspecialchars($data['teacher']['photo']); ?>"
                             alt="Current Photo" class="img-thumbnail" style="max-width: 100px;">
                    </div>
                <?php endif; ?>
            </div>

            <div class="text-end">
                <a href="/admin/teachers" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Teacher
                </button>
            </div>
        </form>
    </div>
</div>