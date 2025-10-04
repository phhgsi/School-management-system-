<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-calendar-check me-2"></i>Mark Attendance
            </h1>
            <p class="page-subtitle">Mark daily attendance for your classes</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" onclick="refreshPage()">
                <i class="fas fa-sync-alt me-2"></i>Refresh
            </button>
        </div>
    </div>
</div>

<!-- Class Selection -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-filter me-2"></i>Select Class & Date
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="class_id" class="form-label">Select Class</label>
                        <select class="form-select" id="class_id" name="class_id" required onchange="loadStudents()">
                            <option value="">Choose Class...</option>
                            <?php if (!empty($data['my_classes'])): ?>
                                <?php foreach ($data['my_classes'] as $class): ?>
                                    <option value="<?php echo $class['class_id']; ?>">
                                        <?php echo htmlspecialchars($class['class_name'] . ' - ' . $class['section']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="attendance_date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="attendance_date" name="date"
                               value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Load Students
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($data['students'])): ?>
<!-- Attendance Form -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>Mark Attendance
                </h5>
                <div>
                    <button class="btn btn-success btn-sm" onclick="markAllPresent()">Mark All Present</button>
                    <button class="btn btn-warning btn-sm" onclick="markAllAbsent()">Mark All Absent</button>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="/teacher/attendance/save" id="attendanceForm">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">
                    <input type="hidden" name="class_id" value="<?php echo $data['selected_class_id']; ?>">
                    <input type="hidden" name="attendance_date" value="<?php echo $data['selected_date']; ?>">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Roll No</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['students'] as $index => $student): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></td>
                                        <td><?php echo htmlspecialchars($student['roll_number']); ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <input type="radio" class="btn-check" name="attendance[<?php echo $student['id']; ?>]"
                                                       id="present_<?php echo $student['id']; ?>" value="present">
                                                <label class="btn btn-sm btn-outline-success" for="present_<?php echo $student['id']; ?>">Present</label>

                                                <input type="radio" class="btn-check" name="attendance[<?php echo $student['id']; ?>]"
                                                       id="absent_<?php echo $student['id']; ?>" value="absent">
                                                <label class="btn btn-sm btn-outline-danger" for="absent_<?php echo $student['id']; ?>">Absent</label>

                                                <input type="radio" class="btn-check" name="attendance[<?php echo $student['id']; ?>]"
                                                       id="late_<?php echo $student['id']; ?>" value="late">
                                                <label class="btn btn-sm btn-outline-warning" for="late_<?php echo $student['id']; ?>">Late</label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" name="remarks[<?php echo $student['id']; ?>]"
                                                   placeholder="Optional remarks...">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Save Attendance
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
function refreshPage() {
    location.reload();
}

function loadStudents() {
    const classId = document.getElementById('class_id').value;
    const date = document.getElementById('attendance_date').value;
    if (classId && date) {
        window.location.href = '/teacher/attendance?class_id=' + classId + '&date=' + date;
    }
}

function markAllPresent() {
    const radios = document.querySelectorAll('input[value="present"]');
    radios.forEach(radio => radio.checked = true);
}

function markAllAbsent() {
    const radios = document.querySelectorAll('input[value="absent"]');
    radios.forEach(radio => radio.checked = true);
}
</script>
