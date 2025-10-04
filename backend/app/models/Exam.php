<?php
/**
 * Exam Model
 * Handles exams, results, and exam schedules
 */

class Exam extends Model {
    public function __construct($db) {
        parent::__construct($db);
        $this->table = 'exams';
    }

    public function getAll() {
        $this->db->query("
            SELECT e.*, c.class_name, c.section
            FROM {$this->table} e
            JOIN classes c ON e.class_id = c.id
            ORDER BY e.start_date DESC
        ");
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("
            SELECT e.*, c.class_name, c.section
            FROM {$this->table} e
            JOIN classes c ON e.class_id = c.id
            WHERE e.id = :id
        ");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getUpcomingExams() {
        $today = date('Y-m-d');
        $this->db->query("
            SELECT e.*, c.class_name, c.section
            FROM {$this->table} e
            JOIN classes c ON e.class_id = c.id
            WHERE e.start_date >= :today
            AND e.status = 'published'
            ORDER BY e.start_date ASC
        ");
        $this->db->bind(':today', $today);
        return $this->db->resultSet();
    }

    public function getExamSubjects($examId) {
        $this->db->query("
            SELECT es.*, s.subject_name, s.subject_code
            FROM exam_subjects es
            JOIN subjects s ON es.subject_id = s.id
            WHERE es.exam_id = :exam_id
            ORDER BY es.exam_date, es.start_time
        ");
        $this->db->bind(':exam_id', $examId);
        return $this->db->resultSet();
    }

    public function getStudentResults($examId, $studentId = null) {
        $this->db->query("
            SELECT er.*, s.first_name, s.last_name, s.scholar_number,
                   sub.subject_name, sub.subject_code, e.exam_name
            FROM exam_results er
            JOIN students s ON er.student_id = s.id
            JOIN subjects sub ON er.subject_id = sub.id
            JOIN exams e ON er.exam_id = e.id
            WHERE er.exam_id = :exam_id
        ");
        $this->db->bind(':exam_id', $examId);

        if ($studentId) {
            $this->db->query(" AND er.student_id = :student_id");
            $this->db->bind(':student_id', $studentId);
        }

        $this->db->query(" ORDER BY s.first_name, sub.subject_name");
        return $this->db->resultSet();
    }

    public function createExam($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['status'] = 'draft';
        return $this->create($data);
    }

    public function updateExam($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->update($id, $data);
    }

    public function deleteExam($id) {
        // Delete related exam subjects and results
        $this->db->query("DELETE FROM exam_subjects WHERE exam_id = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();

        $this->db->query("DELETE FROM exam_results WHERE exam_id = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();

        return $this->delete($id);
    }

    public function addExamSubject($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->query("INSERT INTO exam_subjects SET
            exam_id = :exam_id,
            subject_id = :subject_id,
            exam_date = :exam_date,
            start_time = :start_time,
            end_time = :end_time,
            max_marks = :max_marks,
            pass_marks = :pass_marks,
            room_number = :room_number,
            instructions = :instructions,
            created_at = :created_at
        ");

        $this->db->bind(':exam_id', $data['exam_id']);
        $this->db->bind(':subject_id', $data['subject_id']);
        $this->db->bind(':exam_date', $data['exam_date']);
        $this->db->bind(':start_time', $data['start_time']);
        $this->db->bind(':end_time', $data['end_time']);
        $this->db->bind(':max_marks', $data['max_marks']);
        $this->db->bind(':pass_marks', $data['pass_marks']);
        $this->db->bind(':room_number', $data['room_number']);
        $this->db->bind(':instructions', $data['instructions']);
        $this->db->bind(':created_at', $data['created_at']);

        return $this->db->execute();
    }

    public function saveStudentResult($data) {
        $data['created_at'] = date('Y-m-d H:i:s');

        // Check if result already exists
        $this->db->query("
            SELECT id FROM exam_results
            WHERE exam_id = :exam_id AND student_id = :student_id AND subject_id = :subject_id
        ");
        $this->db->bind(':exam_id', $data['exam_id']);
        $this->db->bind(':student_id', $data['student_id']);
        $this->db->bind(':subject_id', $data['subject_id']);
        $existing = $this->db->single();

        if ($existing) {
            // Update existing result
            $this->db->query("UPDATE exam_results SET
                marks_obtained = :marks_obtained,
                grade = :grade,
                remarks = :remarks,
                updated_at = :created_at
                WHERE exam_id = :exam_id AND student_id = :student_id AND subject_id = :subject_id
            ");
        } else {
            // Insert new result
            $this->db->query("INSERT INTO exam_results SET
                exam_id = :exam_id,
                student_id = :student_id,
                subject_id = :subject_id,
                marks_obtained = :marks_obtained,
                grade = :grade,
                remarks = :remarks,
                marked_by = :marked_by,
                created_at = :created_at
            ");
        }

        $this->db->bind(':exam_id', $data['exam_id']);
        $this->db->bind(':student_id', $data['student_id']);
        $this->db->bind(':subject_id', $data['subject_id']);
        $this->db->bind(':marks_obtained', $data['marks_obtained']);
        $this->db->bind(':grade', $data['grade']);
        $this->db->bind(':remarks', $data['remarks']);
        $this->db->bind(':marked_by', $data['marked_by']);
        $this->db->bind(':created_at', $data['created_at']);

        return $this->db->execute();
    }
}