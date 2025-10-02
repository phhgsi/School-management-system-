<?php
/**
 * Student Model
 * Handles student-related database operations
 */

class Student extends Model {
    public function __construct($db) {
        parent::__construct($db);
        $this->table = 'students';
    }

    public function getAll() {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY first_name, last_name");
        return $this->db->resultSet();
    }

    public function getAllWithClass() {
        $this->db->query("
            SELECT s.*, c.class_name, c.section
            FROM {$this->table} s
            LEFT JOIN classes c ON s.class_id = c.id
            ORDER BY c.class_name, c.section, s.roll_number, s.first_name
        ");
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getByScholarNumber($scholarNumber) {
        $this->db->query("SELECT * FROM {$this->table} WHERE scholar_number = :scholar_number");
        $this->db->bind(':scholar_number', $scholarNumber);
        return $this->db->single();
    }

    public function getByClass($classId) {
        $this->db->query("
            SELECT s.*, c.class_name, c.section
            FROM {$this->table} s
            LEFT JOIN classes c ON s.class_id = c.id
            WHERE s.class_id = :class_id
            ORDER BY s.roll_number, s.first_name
        ");
        $this->db->bind(':class_id', $classId);
        return $this->db->resultSet();
    }

    public function getByClassAndSection($classId, $section) {
        $this->db->query("
            SELECT s.*, c.class_name
            FROM {$this->table} s
            LEFT JOIN classes c ON s.class_id = c.id
            WHERE s.class_id = :class_id AND s.section = :section
            ORDER BY s.roll_number, s.first_name
        ");
        $this->db->bind(':class_id', $classId);
        $this->db->bind(':section', $section);
        return $this->db->resultSet();
    }

    public function createStudent($data) {
        $data['admission_date'] = date('Y-m-d');
        $data['status'] = 'active';
        return $this->create($data);
    }

    public function updateStudent($id, $data) {
        return $this->update($id, $data);
    }

    public function deleteStudent($id) {
        // Delete associated photo if exists
        $student = $this->getById($id);
        if ($student && !empty($student['photo'])) {
            $photoPath = UPLOADS_PATH . 'students/' . $student['photo'];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }
        return $this->delete($id);
    }

    public function searchStudents($searchTerm, $classId = null, $status = null, $gender = null) {
        $conditions = [];
        $params = [];

        if (!empty($searchTerm)) {
            $conditions[] = "(s.first_name LIKE :search OR s.last_name LIKE :search OR s.scholar_number LIKE :search OR s.admission_number LIKE :search OR s.father_name LIKE :search OR s.mobile LIKE :search)";
            $params[':search'] = '%' . $searchTerm . '%';
        }

        if (!empty($classId)) {
            $conditions[] = "s.class_id = :class_id";
            $params[':class_id'] = $classId;
        }

        if (!empty($status)) {
            $conditions[] = "s.status = :status";
            $params[':status'] = $status;
        }

        if (!empty($gender)) {
            $conditions[] = "s.gender = :gender";
            $params[':gender'] = $gender;
        }

        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

        $this->db->query("
            SELECT s.*, c.class_name, c.section
            FROM {$this->table} s
            LEFT JOIN classes c ON s.class_id = c.id
            {$whereClause}
            ORDER BY c.class_name, c.section, s.roll_number, s.first_name
        ");

        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }

        return $this->db->resultSet();
    }

    public function getStudentStats() {
        $stats = [];

        // Total students by status
        $this->db->query("
            SELECT status, COUNT(*) as count
            FROM {$this->table}
            GROUP BY status
        ");
        $stats['by_status'] = $this->db->resultSet();

        // Total students by class
        $this->db->query("
            SELECT c.class_name, c.section, COUNT(s.id) as count
            FROM {$this->table} s
            LEFT JOIN classes c ON s.class_id = c.id
            WHERE s.status = 'active'
            GROUP BY s.class_id
            ORDER BY c.class_name, c.section
        ");
        $stats['by_class'] = $this->db->resultSet();

        // Total students by gender
        $this->db->query("
            SELECT gender, COUNT(*) as count
            FROM {$this->table}
            WHERE status = 'active'
            GROUP BY gender
        ");
        $stats['by_gender'] = $this->db->resultSet();

        return $stats;
    }

    public function getRecentAdmissions($limit = 10) {
        $this->db->query("
            SELECT s.*, c.class_name, c.section
            FROM {$this->table} s
            LEFT JOIN classes c ON s.class_id = c.id
            ORDER BY s.admission_date DESC
            LIMIT :limit
        ");
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getStudentProfile($id) {
        $this->db->query("
            SELECT s.*,
                   c.class_name, c.section,
                   u.username, u.email as user_email
            FROM {$this->table} s
            LEFT JOIN classes c ON s.class_id = c.id
            LEFT JOIN users u ON s.user_id = u.id
            WHERE s.id = :id
        ");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getStudentAttendance($studentId, $month = null, $year = null) {
        if (!$month) $month = date('m');
        if (!$year) $year = date('Y');

        $this->db->query("
            SELECT attendance_date, status, remarks
            FROM attendance
            WHERE student_id = :student_id
            AND MONTH(attendance_date) = :month
            AND YEAR(attendance_date) = :year
            ORDER BY attendance_date
        ");
        $this->db->bind(':student_id', $studentId);
        $this->db->bind(':month', $month);
        $this->db->bind(':year', $year);

        return $this->db->resultSet();
    }

    public function getStudentFees($studentId) {
        $this->db->query("
            SELECT fp.*, fpd.amount_paid, fpd.fee_structure_id,
                   fs.fee_name, fs.fee_type
            FROM fee_payments fp
            LEFT JOIN fee_payment_details fpd ON fp.id = fpd.payment_id
            LEFT JOIN fee_structure fs ON fpd.fee_structure_id = fs.id
            WHERE fp.student_id = :student_id
            ORDER BY fp.payment_date DESC
        ");
        $this->db->bind(':student_id', $studentId);

        return $this->db->resultSet();
    }

    public function getStudentResults($studentId) {
        $this->db->query("
            SELECT er.*, e.exam_name, e.exam_type, s.subject_name,
                   c.class_name, c.section
            FROM exam_results er
            LEFT JOIN exams e ON er.exam_id = e.id
            LEFT JOIN subjects s ON er.subject_id = s.id
            LEFT JOIN classes c ON e.class_id = c.id
            WHERE er.student_id = :student_id
            ORDER BY e.start_date DESC, s.subject_name
        ");
        $this->db->bind(':student_id', $studentId);

        return $this->db->resultSet();
    }

    public function updateStudentStatus($id, $status) {
        return $this->update($id, [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function getStudentsByParent($parentId) {
        // This would typically join with a parent-student relationship table
        // For now, return empty array as this relationship isn't implemented yet
        return [];
    }

    public function exportStudents($format = 'csv', $filters = []) {
        $conditions = [];
        $params = [];

        if (!empty($filters['class_id'])) {
            $conditions[] = "s.class_id = :class_id";
            $params[':class_id'] = $filters['class_id'];
        }

        if (!empty($filters['status'])) {
            $conditions[] = "s.status = :status";
            $params[':status'] = $filters['status'];
        }

        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

        $this->db->query("
            SELECT s.scholar_number, s.admission_number,
                   s.first_name, s.middle_name, s.last_name,
                   s.father_name, s.mother_name,
                   s.mobile, s.email, s.date_of_birth,
                   s.gender, s.blood_group, s.nationality,
                   s.permanent_address, s.village,
                   c.class_name, c.section, s.roll_number,
                   s.admission_date, s.status
            FROM {$this->table} s
            LEFT JOIN classes c ON s.class_id = c.id
            {$whereClause}
            ORDER BY c.class_name, c.section, s.roll_number
        ");

        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }

        return $this->db->resultSet();
    }
}