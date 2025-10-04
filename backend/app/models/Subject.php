<?php
/**
 * Subject Model
 * Handles subject-related database operations
 */

class Subject extends Model {
    public function __construct($db) {
        parent::__construct($db);
        $this->table = 'subjects';
    }

    public function getAll() {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY subject_name");
        return $this->db->resultSet();
    }

    public function getActive() {
        $this->db->query("SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY subject_name");
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getByCode($code) {
        $this->db->query("SELECT * FROM {$this->table} WHERE subject_code = :code");
        $this->db->bind(':code', $code);
        return $this->db->single();
    }

    public function getSubjectsByClass($classId) {
        $this->db->query("
            SELECT s.*, CONCAT(t.first_name, ' ', t.last_name) as teacher_name
            FROM {$this->table} s
            LEFT JOIN teachers t ON s.teacher_id = t.id
            WHERE s.class_id = :class_id
            ORDER BY s.subject_name
        ");
        $this->db->bind(':class_id', $classId);
        return $this->db->resultSet();
    }

    public function getSubjectsByTeacher($teacherId) {
        $this->db->query("
            SELECT s.*, c.class_name, c.section
            FROM {$this->table} s
            JOIN classes c ON s.class_id = c.id
            WHERE s.teacher_id = :teacher_id
            ORDER BY c.class_name, c.section, s.subject_name
        ");
        $this->db->bind(':teacher_id', $teacherId);
        return $this->db->resultSet();
    }

    public function createSubject($data) {
        return $this->create($data);
    }

    public function updateSubject($id, $data) {
        return $this->update($id, $data);
    }

    public function deleteSubject($id) {
        return $this->delete($id);
    }

    public function assignTeacher($subjectId, $teacherId) {
        return $this->update($subjectId, ['teacher_id' => $teacherId]);
    }

    public function removeTeacher($subjectId) {
        return $this->update($subjectId, ['teacher_id' => null]);
    }

    public function getSubjectStats() {
        $stats = [];

        // Subjects per class
        $this->db->query("
            SELECT c.class_name, c.section, COUNT(s.id) as subject_count
            FROM classes c
            LEFT JOIN {$this->table} s ON c.id = s.class_id
            WHERE c.status = 'active' AND s.status = 'active'
            GROUP BY c.id
            ORDER BY c.class_name, c.section
        ");
        $stats['per_class'] = $this->db->resultSet();

        // Teachers assigned
        $this->db->query("
            SELECT COUNT(*) as assigned_count
            FROM {$this->table}
            WHERE teacher_id IS NOT NULL AND status = 'active'
        ");
        $stats['assigned_teachers'] = $this->db->single()['assigned_count'];

        // Unassigned subjects
        $this->db->query("
            SELECT COUNT(*) as unassigned_count
            FROM {$this->table}
            WHERE teacher_id IS NULL AND status = 'active'
        ");
        $stats['unassigned_subjects'] = $this->db->single()['unassigned_count'];

        return $stats;
    }

    public function searchSubjects($searchTerm, $classId = null, $status = null) {
        $conditions = [];
        $params = [];

        if (!empty($searchTerm)) {
            $conditions[] = "(subject_name LIKE :search OR subject_code LIKE :search)";
            $params[':search'] = '%' . $searchTerm . '%';
        }

        if (!empty($classId)) {
            $conditions[] = "class_id = :class_id";
            $params[':class_id'] = $classId;
        }

        if (!empty($status)) {
            $conditions[] = "status = :status";
            $params[':status'] = $status;
        }

        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

        $this->db->query("
            SELECT s.*, c.class_name, c.section,
                   CONCAT(t.first_name, ' ', t.last_name) as teacher_name
            FROM {$this->table} s
            LEFT JOIN classes c ON s.class_id = c.id
            LEFT JOIN teachers t ON s.teacher_id = t.id
            {$whereClause}
            ORDER BY c.class_name, c.section, s.subject_name
        ");

        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }

        return $this->db->resultSet();
    }
}