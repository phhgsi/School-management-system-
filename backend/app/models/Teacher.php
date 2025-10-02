<?php
/**
 * Teacher Model
 * Handles teacher-related database operations
 */

class Teacher extends Model {
    public function __construct($db) {
        parent::__construct($db);
        $this->table = 'teachers';
    }

    public function getAll() {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY first_name, last_name");
        return $this->db->resultSet();
    }

    public function getActive() {
        $this->db->query("SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY first_name, last_name");
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getByEmployeeId($employeeId) {
        $this->db->query("SELECT * FROM {$this->table} WHERE employee_id = :employee_id");
        $this->db->bind(':employee_id', $employeeId);
        return $this->db->single();
    }

    public function getTeachersByDepartment($department) {
        $this->db->query("SELECT * FROM {$this->table} WHERE department = :department AND status = 'active' ORDER BY first_name, last_name");
        $this->db->bind(':department', $department);
        return $this->db->resultSet();
    }

    public function getTeachersBySubject($subjectId) {
        $this->db->query("
            SELECT t.*, ts.class_id
            FROM {$this->table} t
            JOIN teacher_subjects ts ON t.id = ts.teacher_id
            WHERE ts.subject_id = :subject_id AND t.status = 'active'
            ORDER BY t.first_name, t.last_name
        ");
        $this->db->bind(':subject_id', $subjectId);
        return $this->db->resultSet();
    }

    public function getTeacherClasses($teacherId) {
        $this->db->query("
            SELECT c.*, s.subject_name, ts.is_class_teacher
            FROM classes c
            JOIN teacher_subjects ts ON c.id = ts.class_id
            JOIN subjects s ON ts.subject_id = s.id
            WHERE ts.teacher_id = :teacher_id
            ORDER BY c.class_name, c.section, s.subject_name
        ");
        $this->db->bind(':teacher_id', $teacherId);
        return $this->db->resultSet();
    }

    public function getClassTeacher($classId) {
        $this->db->query("
            SELECT t.*
            FROM {$this->table} t
            JOIN classes c ON t.id = c.class_teacher_id
            WHERE c.id = :class_id
        ");
        $this->db->bind(':class_id', $classId);
        return $this->db->single();
    }

    public function createTeacher($data) {
        $data['date_of_joining'] = date('Y-m-d');
        $data['status'] = 'active';
        return $this->create($data);
    }

    public function updateTeacher($id, $data) {
        return $this->update($id, $data);
    }

    public function deleteTeacher($id) {
        // Delete associated photo if exists
        $teacher = $this->getById($id);
        if ($teacher && !empty($teacher['photo'])) {
            $photoPath = UPLOADS_PATH . 'teachers/' . $teacher['photo'];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }
        return $this->delete($id);
    }

    public function getTeacherStats() {
        $stats = [];

        // Total teachers by status
        $this->db->query("
            SELECT status, COUNT(*) as count
            FROM {$this->table}
            GROUP BY status
        ");
        $stats['by_status'] = $this->db->resultSet();

        // Total teachers by department
        $this->db->query("
            SELECT department, COUNT(*) as count
            FROM {$this->table}
            WHERE status = 'active'
            GROUP BY department
            ORDER BY count DESC
        ");
        $stats['by_department'] = $this->db->resultSet();

        // Total teachers by qualification
        $this->db->query("
            SELECT qualification, COUNT(*) as count
            FROM {$this->table}
            WHERE status = 'active'
            GROUP BY qualification
            ORDER BY count DESC
        ");
        $stats['by_qualification'] = $this->db->resultSet();

        return $stats;
    }

    public function getTeacherAttendance($teacherId, $month = null, $year = null) {
        if (!$month) $month = date('m');
        if (!$year) $year = date('Y');

        $this->db->query("
            SELECT attendance_date, status, remarks
            FROM teacher_attendance
            WHERE teacher_id = :teacher_id
            AND MONTH(attendance_date) = :month
            AND YEAR(attendance_date) = :year
            ORDER BY attendance_date
        ");
        $this->db->bind(':teacher_id', $teacherId);
        $this->db->bind(':month', $month);
        $this->db->bind(':year', $year);

        return $this->db->resultSet();
    }

    public function getTeacherWorkload($teacherId) {
        $this->db->query("
            SELECT COUNT(DISTINCT ts.class_id) as class_count,
                   COUNT(DISTINCT ts.subject_id) as subject_count,
                   COUNT(DISTINCT sc.student_id) as student_count
            FROM teacher_subjects ts
            LEFT JOIN student_classes sc ON ts.class_id = sc.class_id
            WHERE ts.teacher_id = :teacher_id
        ");
        $this->db->bind(':teacher_id', $teacherId);
        return $this->db->single();
    }

    public function assignSubject($teacherId, $subjectId, $classId, $isClassTeacher = false) {
        $this->db->query("
            INSERT INTO teacher_subjects (teacher_id, subject_id, class_id, is_class_teacher)
            VALUES (:teacher_id, :subject_id, :class_id, :is_class_teacher)
            ON DUPLICATE KEY UPDATE is_class_teacher = :is_class_teacher
        ");
        $this->db->bind(':teacher_id', $teacherId);
        $this->db->bind(':subject_id', $subjectId);
        $this->db->bind(':class_id', $classId);
        $this->db->bind(':is_class_teacher', $isClassTeacher);

        return $this->db->execute();
    }

    public function removeSubjectAssignment($teacherId, $subjectId, $classId) {
        $this->db->query("
            DELETE FROM teacher_subjects
            WHERE teacher_id = :teacher_id
            AND subject_id = :subject_id
            AND class_id = :class_id
        ");
        $this->db->bind(':teacher_id', $teacherId);
        $this->db->bind(':subject_id', $subjectId);
        $this->db->bind(':class_id', $classId);

        return $this->db->execute();
    }

    public function updateTeacherStatus($id, $status) {
        return $this->update($id, [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function getTeacherProfile($id) {
        $this->db->query("
            SELECT t.*,
                   u.username, u.email as user_email
            FROM {$this->table} t
            LEFT JOIN users u ON t.user_id = u.id
            WHERE t.id = :id
        ");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function searchTeachers($searchTerm, $department = null, $status = null) {
        $conditions = [];
        $params = [];

        if (!empty($searchTerm)) {
            $conditions[] = "(t.first_name LIKE :search OR t.last_name LIKE :search OR t.employee_id LIKE :search OR t.mobile LIKE :search)";
            $params[':search'] = '%' . $searchTerm . '%';
        }

        if (!empty($department)) {
            $conditions[] = "t.department = :department";
            $params[':department'] = $department;
        }

        if (!empty($status)) {
            $conditions[] = "t.status = :status";
            $params[':status'] = $status;
        }

        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

        $this->db->query("
            SELECT t.*
            FROM {$this->table} t
            {$whereClause}
            ORDER BY t.first_name, t.last_name
        ");

        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }

        return $this->db->resultSet();
    }

    public function exportTeachers($format = 'csv', $filters = []) {
        $conditions = [];
        $params = [];

        if (!empty($filters['department'])) {
            $conditions[] = "t.department = :department";
            $params[':department'] = $filters['department'];
        }

        if (!empty($filters['status'])) {
            $conditions[] = "t.status = :status";
            $params[':status'] = $filters['status'];
        }

        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

        $this->db->query("
            SELECT t.employee_id, t.first_name, t.middle_name, t.last_name,
                   t.date_of_birth, t.gender, t.designation, t.department,
                   t.qualification, t.mobile, t.email, t.date_of_joining,
                   t.experience_years, t.status
            FROM {$this->table} t
            {$whereClause}
            ORDER BY t.first_name, t.last_name
        ");

        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }

        return $this->db->resultSet();
    }
}