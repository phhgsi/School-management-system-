<?php
/**
 * Class Model
 * Handles class and subject-related database operations
 */

class ClassModel extends Model {
    public function __construct($db) {
        parent::__construct($db);
        $this->table = 'classes';
    }

    public function getAll() {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY class_name, section");
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getClassesWithTeachers() {
        $this->db->query("
            SELECT c.*, CONCAT(t.first_name, ' ', t.last_name) as class_teacher_name
            FROM {$this->table} c
            LEFT JOIN teachers t ON c.class_teacher_id = t.id
            ORDER BY c.class_name, c.section
        ");
        return $this->db->resultSet();
    }

    public function getStudentsInClass($classId) {
        $this->db->query("
            SELECT s.*, sc.academic_year
            FROM students s
            JOIN student_classes sc ON s.id = sc.student_id
            WHERE sc.class_id = :class_id AND sc.status = 'enrolled'
            ORDER BY s.roll_number, s.first_name
        ");
        $this->db->bind(':class_id', $classId);
        return $this->db->resultSet();
    }

    public function getClassSubjects($classId) {
        $this->db->query("
            SELECT s.*, CONCAT(t.first_name, ' ', t.last_name) as teacher_name
            FROM subjects s
            LEFT JOIN teachers t ON s.teacher_id = t.id
            WHERE s.class_id = :class_id
            ORDER BY s.subject_name
        ");
        $this->db->bind(':class_id', $classId);
        return $this->db->resultSet();
    }

    public function createClass($data) {
        $data['academic_year'] = defined('CURRENT_ACADEMIC_YEAR') ? CURRENT_ACADEMIC_YEAR : '2024-2025';
        return $this->create($data);
    }

    public function updateClass($id, $data) {
        return $this->update($id, $data);
    }

    public function deleteClass($id) {
        return $this->delete($id);
    }

    public function getClassStats() {
        $stats = [];

        // Students per class
        $this->db->query("
            SELECT c.class_name, c.section, COUNT(sc.student_id) as student_count
            FROM {$this->table} c
            LEFT JOIN student_classes sc ON c.id = sc.class_id
            WHERE c.status = 'active' AND sc.status = 'enrolled'
            GROUP BY c.id
            ORDER BY c.class_name, c.section
        ");
        $stats['student_distribution'] = $this->db->resultSet();

        // Teachers per class
        $this->db->query("
            SELECT c.class_name, c.section, COUNT(DISTINCT ts.teacher_id) as teacher_count
            FROM {$this->table} c
            LEFT JOIN teacher_subjects ts ON c.id = ts.class_id
            WHERE c.status = 'active'
            GROUP BY c.id
            ORDER BY c.class_name, c.section
        ");
        $stats['teacher_distribution'] = $this->db->resultSet();

        return $stats;
    }
}