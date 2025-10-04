<!-- Edit Subject Form -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-edit me-2"></i>Edit Subject Details
        </h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="subject_name" class="form-label">Subject Name *</label>
                        <input type="text" class="form-control" id="subject_name" name="subject_name"
                               value="<?php echo htmlspecialchars($data['subject']['subject_name']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="subject_code" class="form-label">Subject Code *</label>
                        <input type="text" class="form-control" id="subject_code" name="subject_code"
                               value="<?php echo htmlspecialchars($data['subject']['subject_code']); ?>" required>
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
                                    <?php echo $data['subject']['class_id'] == $class['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($class['class_name'] . ' - ' . $class['section']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Assigned Teacher</label>
                        <select class="form-select" id="teacher_id" name="teacher_id">
                            <option value="">Select Teacher</option>
                            <?php foreach ($data['teachers'] as $teacher): ?>
                                <option value="<?php echo $teacher['id']; ?>"
                                    <?php echo $data['subject']['teacher_id'] == $teacher['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="max_marks" class="form-label">Maximum Marks</label>
                        <input type="number" class="form-control" id="max_marks" name="max_marks"
                               value="<?php echo htmlspecialchars($data['subject']['max_marks']); ?>" min="1" max="1000">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="pass_marks" class="form-label">Passing Marks</label>
                        <input type="number" class="form-control" id="pass_marks" name="pass_marks"
                               value="<?php echo htmlspecialchars($data['subject']['pass_marks']); ?>" min="1" max="1000">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($data['subject']['description'] ?? ''); ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" <?php echo $data['subject']['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo $data['subject']['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a href="/admin/classes" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Subject
                </button>
            </div>
        </form>
    </div>
</div>