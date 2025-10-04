<!-- Edit Student Form -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-edit me-2"></i>Edit Student Details
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="scholar_number" class="form-label">Scholar Number *</label>
                        <input type="text" class="form-control" id="scholar_number" name="scholar_number"
                               value="<?php echo htmlspecialchars($data['student']['scholar_number']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="admission_number" class="form-label">Admission Number *</label>
                        <input type="text" class="form-control" id="admission_number" name="admission_number"
                               value="<?php echo htmlspecialchars($data['student']['admission_number']); ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name *</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                               value="<?php echo htmlspecialchars($data['student']['first_name']); ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name"
                               value="<?php echo htmlspecialchars($data['student']['middle_name'] ?? ''); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name *</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                               value="<?php echo htmlspecialchars($data['student']['last_name']); ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="class_id" class="form-label">Class *</label>
                        <select class="form-select" id="class_id" name="class_id" required>
                            <option value="">Select Class</option>
                            <?php foreach ($data['classes'] as $class): ?>
                                <option value="<?php echo $class['id']; ?>"
                                    <?php echo $data['student']['class_id'] == $class['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($class['class_name'] . ' - ' . $class['section']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="section" class="form-label">Section *</label>
                        <input type="text" class="form-control" id="section" name="section"
                               value="<?php echo htmlspecialchars($data['student']['section']); ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="roll_number" class="form-label">Roll Number *</label>
                        <input type="number" class="form-control" id="roll_number" name="roll_number"
                               value="<?php echo htmlspecialchars($data['student']['roll_number']); ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="father_name" class="form-label">Father's Name *</label>
                        <input type="text" class="form-control" id="father_name" name="father_name"
                               value="<?php echo htmlspecialchars($data['student']['father_name']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="mother_name" class="form-label">Mother's Name *</label>
                        <input type="text" class="form-control" id="mother_name" name="mother_name"
                               value="<?php echo htmlspecialchars($data['student']['mother_name']); ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile Number *</label>
                        <input type="tel" class="form-control" id="mobile" name="mobile"
                               value="<?php echo htmlspecialchars($data['student']['mobile']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?php echo htmlspecialchars($data['student']['email'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Date of Birth *</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                               value="<?php echo htmlspecialchars($data['student']['date_of_birth']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender *</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="male" <?php echo $data['student']['gender'] === 'male' ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo $data['student']['gender'] === 'female' ? 'selected' : ''; ?>>Female</option>
                            <option value="other" <?php echo $data['student']['gender'] === 'other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="blood_group" class="form-label">Blood Group</label>
                        <select class="form-select" id="blood_group" name="blood_group">
                            <option value="">Select Blood Group</option>
                            <option value="A+" <?php echo $data['student']['blood_group'] === 'A+' ? 'selected' : ''; ?>>A+</option>
                            <option value="A-" <?php echo $data['student']['blood_group'] === 'A-' ? 'selected' : ''; ?>>A-</option>
                            <option value="B+" <?php echo $data['student']['blood_group'] === 'B+' ? 'selected' : ''; ?>>B+</option>
                            <option value="B-" <?php echo $data['student']['blood_group'] === 'B-' ? 'selected' : ''; ?>>B-</option>
                            <option value="AB+" <?php echo $data['student']['blood_group'] === 'AB+' ? 'selected' : ''; ?>>AB+</option>
                            <option value="AB-" <?php echo $data['student']['blood_group'] === 'AB-' ? 'selected' : ''; ?>>AB-</option>
                            <option value="O+" <?php echo $data['student']['blood_group'] === 'O+' ? 'selected' : ''; ?>>O+</option>
                            <option value="O-" <?php echo $data['student']['blood_group'] === 'O-' ? 'selected' : ''; ?>>O-</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" <?php echo $data['student']['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo $data['student']['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                            <option value="transferred" <?php echo $data['student']['status'] === 'transferred' ? 'selected' : ''; ?>>Transferred</option>
                            <option value="graduated" <?php echo $data['student']['status'] === 'graduated' ? 'selected' : ''; ?>>Graduated</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="permanent_address" class="form-label">Permanent Address *</label>
                <textarea class="form-control" id="permanent_address" name="permanent_address" rows="3" required><?php echo htmlspecialchars($data['student']['permanent_address']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Student Photo</label>
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                <?php if (!empty($data['student']['photo'])): ?>
                    <div class="mt-2">
                        <img src="/backend/public/uploads/students/<?php echo htmlspecialchars($data['student']['photo']); ?>"
                             alt="Current Photo" class="img-thumbnail" style="max-width: 100px;">
                    </div>
                <?php endif; ?>
            </div>

            <div class="text-end">
                <a href="/admin/students" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Student
                </button>
            </div>
        </form>
    </div>
</div>