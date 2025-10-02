<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-cog me-2"></i>System Settings
            </h1>
            <p class="page-subtitle">Configure school information, user permissions, and system preferences</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" onclick="saveAllSettings()">
                <i class="fas fa-save me-2"></i>Save All Settings
            </button>
            <button class="btn btn-secondary" onclick="exportSettings()">
                <i class="fas fa-download me-2"></i>Export Settings
            </button>
        </div>
    </div>
</div>

<!-- Settings Tabs -->
<ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
            <i class="fas fa-building me-2"></i>General Settings
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="academic-tab" data-bs-toggle="tab" data-bs-target="#academic" type="button" role="tab">
            <i class="fas fa-graduation-cap me-2"></i>Academic Settings
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">
            <i class="fas fa-users me-2"></i>User Management
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions" type="button" role="tab">
            <i class="fas fa-shield-alt me-2"></i>Permissions
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">
            <i class="fas fa-lock me-2"></i>Security
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="backup-tab" data-bs-toggle="tab" data-bs-target="#backup" type="button" role="tab">
            <i class="fas fa-database me-2"></i>Backup & Restore
        </button>
    </li>
</ul>

<!-- Settings Tab Content -->
<div class="tab-content" id="settingsTabContent">
    <!-- General Settings -->
    <div class="tab-pane fade show active" id="general" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-building me-2"></i>School Information
                </h5>
            </div>
            <div class="card-body">
                <form id="generalSettingsForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="school_name" class="form-label">School Name *</label>
                                <input type="text" class="form-control" id="school_name" name="school_name"
                                       value="<?php echo htmlspecialchars(SCHOOL_NAME); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="school_email" class="form-label">School Email *</label>
                                <input type="email" class="form-control" id="school_email" name="school_email"
                                       value="<?php echo htmlspecialchars(SCHOOL_EMAIL); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="school_address" class="form-label">School Address</label>
                        <textarea class="form-control" id="school_address" name="school_address" rows="3"><?php echo htmlspecialchars(SCHOOL_ADDRESS); ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="school_phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="school_phone" name="school_phone"
                                       value="<?php echo htmlspecialchars(SCHOOL_PHONE); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="school_website" class="form-label">Website</label>
                                <input type="url" class="form-control" id="school_website" name="school_website"
                                       value="<?php echo htmlspecialchars(SCHOOL_WEBSITE); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="timezone" class="form-label">Timezone</label>
                                <select class="form-select" id="timezone" name="timezone">
                                    <option value="Asia/Kolkata" <?php echo APP_TIMEZONE === 'Asia/Kolkata' ? 'selected' : ''; ?>>Asia/Kolkata</option>
                                    <option value="Asia/Delhi" <?php echo APP_TIMEZONE === 'Asia/Delhi' ? 'selected' : ''; ?>>Asia/Delhi</option>
                                    <option value="Asia/Mumbai" <?php echo APP_TIMEZONE === 'Asia/Mumbai' ? 'selected' : ''; ?>>Asia/Mumbai</option>
                                    <option value="America/New_York" <?php echo APP_TIMEZONE === 'America/New_York' ? 'selected' : ''; ?>>America/New_York</option>
                                    <option value="Europe/London" <?php echo APP_TIMEZONE === 'Europe/London' ? 'selected' : ''; ?>>Europe/London</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="currency" class="form-label">Currency</label>
                                <select class="form-select" id="currency" name="currency">
                                    <option value="INR" <?php echo CURRENCY_CODE === 'INR' ? 'selected' : ''; ?>>Indian Rupee (₹)</option>
                                    <option value="USD" <?php echo CURRENCY_CODE === 'USD' ? 'selected' : ''; ?>>US Dollar ($)</option>
                                    <option value="EUR" <?php echo CURRENCY_CODE === 'EUR' ? 'selected' : ''; ?>>Euro (€)</option>
                                    <option value="GBP" <?php echo CURRENCY_CODE === 'GBP' ? 'selected' : ''; ?>>British Pound (£)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="school_logo" class="form-label">School Logo</label>
                        <input type="file" class="form-control" id="school_logo" name="school_logo" accept="image/*">
                        <div class="form-text">Upload school logo (recommended size: 200x200px)</div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Academic Settings -->
    <div class="tab-pane fade" id="academic" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-graduation-cap me-2"></i>Academic Configuration
                </h5>
            </div>
            <div class="card-body">
                <form id="academicSettingsForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="current_academic_year" class="form-label">Current Academic Year *</label>
                                <select class="form-select" id="current_academic_year" name="current_academic_year" required>
                                    <option value="2024-2025" <?php echo CURRENT_ACADEMIC_YEAR === '2024-2025' ? 'selected' : ''; ?>>2024-2025</option>
                                    <option value="2025-2026" <?php echo CURRENT_ACADEMIC_YEAR === '2025-2026' ? 'selected' : ''; ?>>2025-2026</option>
                                    <option value="2026-2027" <?php echo CURRENT_ACADEMIC_YEAR === '2026-2027' ? 'selected' : ''; ?>>2026-2027</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="academic_year_start" class="form-label">Academic Year Start</label>
                                <input type="text" class="form-control" id="academic_year_start" name="academic_year_start"
                                       value="<?php echo htmlspecialchars(ACADEMIC_YEAR_START); ?>"
                                       placeholder="MM-DD">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="total_classes" class="form-label">Total Classes</label>
                                <input type="number" class="form-control" id="total_classes" name="total_classes"
                                       min="1" max="20" value="12">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="students_per_class" class="form-label">Students per Class</label>
                                <input type="number" class="form-control" id="students_per_class" name="students_per_class"
                                       min="1" max="100" value="40">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="working_days" class="form-label">Working Days per Week</label>
                                <select class="form-select" id="working_days" name="working_days">
                                    <option value="5">5 Days</option>
                                    <option value="6" selected>6 Days</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Grading System</label>
                        <div class="table-responsive">
                            <table class="table table-sm" id="gradingTable">
                                <thead>
                                    <tr>
                                        <th>Grade</th>
                                        <th>Min %</th>
                                        <th>Max %</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" class="form-control form-control-sm" value="A+" readonly></td>
                                        <td><input type="number" class="form-control form-control-sm" value="90" min="0" max="100"></td>
                                        <td><input type="number" class="form-control form-control-sm" value="100" min="0" max="100"></td>
                                        <td><input type="text" class="form-control form-control-sm" value="Excellent"></td>
                                        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeGrade(this)">Remove</button></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" class="form-control form-control-sm" value="A" readonly></td>
                                        <td><input type="number" class="form-control form-control-sm" value="80" min="0" max="100"></td>
                                        <td><input type="number" class="form-control form-control-sm" value="89" min="0" max="100"></td>
                                        <td><input type="text" class="form-control form-control-sm" value="Very Good"></td>
                                        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeGrade(this)">Remove</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary" onclick="addGrade()">Add Grade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- User Management -->
    <div class="tab-pane fade" id="users" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>User Management
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Last Login</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['users'] as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo getRoleBadge($user['role']); ?>">
                                            <?php echo ucfirst($user['role']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo $user['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                            <?php echo ucfirst($user['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'Never'; ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-primary" title="Edit User"
                                                    onclick="editUser(<?php echo $user['id']; ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning" title="Reset Password"
                                                    onclick="resetPassword(<?php echo $user['id']; ?>)">
                                                <i class="fas fa-key"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-<?php echo $user['status'] === 'active' ? 'danger' : 'success'; ?>"
                                                    title="<?php echo $user['status'] === 'active' ? 'Deactivate' : 'Activate'; ?>"
                                                    onclick="toggleUserStatus(<?php echo $user['id']; ?>, '<?php echo $user['status']; ?>')">
                                                <i class="fas fa-<?php echo $user['status'] === 'active' ? 'ban' : 'check'; ?>"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-plus me-2"></i>Add New User
                </button>
            </div>
        </div>
    </div>

    <!-- Permissions -->
    <div class="tab-pane fade" id="permissions" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-shield-alt me-2"></i>Role Permissions
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    $roles = ['admin', 'teacher', 'student', 'parent', 'cashier'];
                    foreach ($roles as $role):
                    ?>
                        <div class="col-md-6 mb-4">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-user-shield me-2"></i><?php echo ucfirst($role); ?> Permissions
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="permissions-list">
                                        <?php
                                        $permissions = [
                                            'admin' => ['users', 'students', 'teachers', 'classes', 'attendance', 'exams', 'fees', 'events', 'gallery', 'reports', 'settings'],
                                            'teacher' => ['attendance', 'exams', 'students', 'classes', 'events'],
                                            'student' => ['attendance', 'exams', 'fees', 'events', 'gallery'],
                                            'parent' => ['attendance', 'exams', 'fees', 'events'],
                                            'cashier' => ['fees', 'reports', 'students']
                                        ];
                                        ?>

                                        <?php foreach ($permissions[$role] as $permission): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                       id="<?php echo $role . '_' . $permission; ?>"
                                                       name="permissions[<?php echo $role; ?>][]"
                                                       value="<?php echo $permission; ?>" checked>
                                                <label class="form-check-label" for="<?php echo $role . '_' . $permission; ?>">
                                                    <?php echo ucfirst(str_replace('_', ' ', $permission)); ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Settings -->
    <div class="tab-pane fade" id="security" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-lock me-2"></i>Security Configuration
                </h5>
            </div>
            <div class="card-body">
                <form id="securitySettingsForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="session_timeout" class="form-label">Session Timeout (minutes)</label>
                                <input type="number" class="form-control" id="session_timeout" name="session_timeout"
                                       min="5" max="480" value="60">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_login_attempts" class="form-label">Max Login Attempts</label>
                                <input type="number" class="form-control" id="max_login_attempts" name="max_login_attempts"
                                       min="3" max="10" value="5">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="enable_csrf" name="enable_csrf" checked>
                            <label class="form-check-label" for="enable_csrf">
                                Enable CSRF Protection
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="enable_rate_limit" name="enable_rate_limit" checked>
                            <label class="form-check-label" for="enable_rate_limit">
                                Enable Rate Limiting
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="enable_audit_log" name="enable_audit_log" checked>
                            <label class="form-check-label" for="enable_audit_log">
                                Enable Audit Logging
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_policy" class="form-label">Password Policy</label>
                        <select class="form-select" id="password_policy" name="password_policy">
                            <option value="basic">Basic (8+ characters)</option>
                            <option value="medium" selected>Medium (8+ chars, 1 number, 1 uppercase)</option>
                            <option value="strong">Strong (12+ chars, numbers, symbols, mixed case)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="backup_frequency" class="form-label">Automatic Backup Frequency</label>
                        <select class="form-select" id="backup_frequency" name="backup_frequency">
                            <option value="daily">Daily</option>
                            <option value="weekly" selected>Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="disabled">Disabled</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Backup & Restore -->
    <div class="tab-pane fade" id="backup" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-database me-2"></i>Backup & Restore
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-download me-2"></i>Create Backup
                                </h6>
                            </div>
                            <div class="card-body">
                                <p>Create a full backup of the system including database and files.</p>
                                <button class="btn btn-primary" onclick="createBackup()">
                                    <i class="fas fa-download me-2"></i>Create Full Backup
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-upload me-2"></i>Restore from Backup
                                </h6>
                            </div>
                            <div class="card-body">
                                <p>Restore the system from a previously created backup file.</p>
                                <input type="file" class="form-control" id="backup_file" accept=".zip,.sql">
                                <button class="btn btn-success mt-2" onclick="restoreBackup()">
                                    <i class="fas fa-upload me-2"></i>Restore Backup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h6>Recent Backups</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Backup Date</th>
                                    <th>Type</th>
                                    <th>Size</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center py-3">
                                        <p class="text-muted mb-0">No backups available yet.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Add New User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/admin/users/add">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username *</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role *</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="admin">Administrator</option>
                            <option value="teacher">Teacher</option>
                            <option value="student">Student</option>
                            <option value="parent">Parent</option>
                            <option value="cashier">Cashier</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="temp_password" class="form-label">Temporary Password *</label>
                        <input type="password" class="form-control" id="temp_password" name="temp_password" required>
                        <div class="form-text">User will be required to change this password on first login</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Add User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Role badge helper function
    function getRoleBadge(role) {
        switch (role) {
            case 'admin': return 'danger';
            case 'teacher': return 'primary';
            case 'student': return 'info';
            case 'parent': return 'warning';
            case 'cashier': return 'success';
            default: return 'secondary';
        }
    }

    // Save all settings
    function saveAllSettings() {
        // Collect data from all forms
        const generalForm = document.getElementById('generalSettingsForm');
        const academicForm = document.getElementById('academicSettingsForm');
        const securityForm = document.getElementById('securitySettingsForm');

        if (confirm('Save all settings? This will update the system configuration.')) {
            // Implement save functionality
            alert('Settings saved successfully!');
        }
    }

    // Export settings
    function exportSettings() {
        window.location.href = '/admin/settings/export';
    }

    // Add new grade row
    function addGrade() {
        const table = document.getElementById('gradingTable').querySelector('tbody');
        const rowCount = table.children.length + 1;
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td><input type="text" class="form-control form-control-sm" placeholder="Grade" maxlength="5"></td>
            <td><input type="number" class="form-control form-control-sm" placeholder="Min %" min="0" max="100"></td>
            <td><input type="number" class="form-control form-control-sm" placeholder="Max %" min="0" max="100"></td>
            <td><input type="text" class="form-control form-control-sm" placeholder="Remarks"></td>
            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeGrade(this)">Remove</button></td>
        `;

        table.appendChild(newRow);
    }

    // Remove grade row
    function removeGrade(button) {
        if (confirm('Remove this grade?')) {
            button.closest('tr').remove();
        }
    }

    // Edit user
    function editUser(id) {
        window.location.href = '/admin/users/edit/' + id;
    }

    // Reset password
    function resetPassword(id) {
        const newPassword = prompt('Enter new temporary password:');
        if (newPassword) {
            // Implement password reset
            alert('Password reset successfully!');
        }
    }

    // Toggle user status
    function toggleUserStatus(id, currentStatus) {
        const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
        const action = currentStatus === 'active' ? 'deactivate' : 'activate';

        if (confirm(`Are you sure you want to ${action} this user?`)) {
            // Implement status toggle
            location.reload();
        }
    }

    // Create backup
    function createBackup() {
        if (confirm('Create full system backup? This may take several minutes.')) {
            // Implement backup creation
            alert('Backup creation started. You will be notified when complete.');
        }
    }

    // Restore backup
    function restoreBackup() {
        const fileInput = document.getElementById('backup_file');
        if (!fileInput.files[0]) {
            alert('Please select a backup file first.');
            return;
        }

        if (confirm('Restore from backup? This will overwrite current data and cannot be undone.')) {
            // Implement backup restore
            alert('Backup restore started. System will restart when complete.');
        }
    }

    // Auto-save settings on change
    document.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('change', function() {
            // Mark form as changed
            this.closest('form')?.classList.add('form-changed');
        });
    });

    // Tab change handler
    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function() {
            // Load tab-specific data if needed
            const target = this.getAttribute('data-bs-target');
            console.log('Switched to tab:', target);
        });
    });
</script>

<style>
    .form-changed {
        border-left: 4px solid #ffc107;
    }

    .permissions-list {
        max-height: 300px;
        overflow-y: auto;
    }

    .nav-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        color: #6c757d;
    }

    .nav-tabs .nav-link.active {
        background-color: transparent;
        border-bottom-color: #667eea;
        color: #667eea;
    }

    .nav-tabs .nav-link:hover {
        border-bottom-color: #667eea;
        color: #667eea;
    }
</style>