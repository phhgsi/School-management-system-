<!-- Edit Class Form -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-edit me-2"></i>Edit Class Details
        </h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="class_name" class="form-label">Class Name *</label>
                        <input type="text" class="form-control" id="class_name" name="class_name"
                               value="<?php echo htmlspecialchars($data['class']['class_name']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="section" class="form-label">Section *</label>
                        <input type="text" class="form-control" id="section" name="section"
                               value="<?php echo htmlspecialchars($data['class']['section']); ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="class_teacher_id" class="form-label">Class Teacher</label>
                        <select class="form-select" id="class_teacher_id" name="class_teacher_id">
                            <option value="">Select Class Teacher</option>
                            <?php foreach ($data['teachers'] as $teacher): ?>
                                <option value="<?php echo $teacher['id']; ?>"
                                    <?php echo $data['class']['class_teacher_id'] == $teacher['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="room_number" class="form-label">Room Number</label>
                        <input type="text" class="form-control" id="room_number" name="room_number"
                               value="<?php echo htmlspecialchars($data['class']['room_number'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Capacity</label>
                        <input type="number" class="form-control" id="capacity" name="capacity"
                               value="<?php echo htmlspecialchars($data['class']['capacity']); ?>" min="1" max="100">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" <?php echo $data['class']['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo $data['class']['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a href="/admin/classes" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Class
                </button>
            </div>
        </form>
    </div>
</div>