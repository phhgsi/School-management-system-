<?php
/**
 * Attendance Model
 * Handles student and teacher attendance
 */

class Attendance extends Model {
    public function __construct($db) {
        parent::__construct($db);
        $this->table = 'attendance';
    }

    public function getTodayAttendance() {
        $today = date('Y-m-d');
        $this->db->query("
            SELECT a.*, s.first_name, s.last_name, c.class_name, c.section
            FROM {$this->table} a
            JOIN students s ON a.student_id = s.id
            JOIN classes c ON a.class_id = c.id
            WHERE a.attendance_date = :today
            ORDER BY c.class_name, s.first_name
        ");
        $this->db->bind(':today', $today);
        return $this->db->resultSet();
    }

    public function getAttendanceByDate($date, $classId = null) {
        $sql = "
            SELECT a.*, s.first_name, s.last_name, c.class_name, c.section
            FROM {$this->table} a
            JOIN students s ON a.student_id = s.id
            JOIN classes c ON a.class_id = c.id
            WHERE a.attendance_date = :date
        ";

        if ($classId) {
            $sql .= " AND a.class_id = :class_id";
        }

        $sql .= " ORDER BY c.class_name, s.first_name";

        $this->db->query($sql);
        $this->db->bind(':date', $date);

        if ($classId) {
            $this->db->bind(':class_id', $classId);
        }

        return $this->db->resultSet();
    }

    public function markAttendance($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->create($data);
    }

    public function updateAttendance($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->update($id, $data);
    }

    public function getStudentAttendance($studentId, $startDate = null, $endDate = null) {
        $sql = "
            SELECT a.*, c.class_name, c.section
            FROM {$this->table} a
            JOIN classes c ON a.class_id = c.id
            WHERE a.student_id = :student_id
        ";

        if ($startDate) {
            $sql .= " AND a.attendance_date >= :start_date";
        }

        if ($endDate) {
            $sql .= " AND a.attendance_date <= :end_date";
        }

        $sql .= " ORDER BY a.attendance_date DESC";

        $this->db->query($sql);
        $this->db->bind(':student_id', $studentId);

        if ($startDate) {
            $this->db->bind(':start_date', $startDate);
        }

        if ($endDate) {
            $this->db->bind(':end_date', $endDate);
        }

        return $this->db->resultSet();
    }

    public function getAttendanceStats($classId = null, $startDate = null, $endDate = null) {
        $sql = "
            SELECT
                COUNT(CASE WHEN status = 'present' THEN 1 END) as present_count,
                COUNT(CASE WHEN status = 'absent' THEN 1 END) as absent_count,
                COUNT(CASE WHEN status = 'late' THEN 1 END) as late_count,
                COUNT(*) as total_count
            FROM {$this->table}
            WHERE 1=1
        ";

        if ($classId) {
            $sql .= " AND class_id = :class_id";
        }

        if ($startDate) {
            $sql .= " AND attendance_date >= :start_date";
        }

        if ($endDate) {
            $sql .= " AND attendance_date <= :end_date";
        }

        $this->db->query($sql);

        if ($classId) {
            $this->db->bind(':class_id', $classId);
        }

        if ($startDate) {
            $this->db->bind(':start_date', $startDate);
        }

        if ($endDate) {
            $this->db->bind(':end_date', $endDate);
        }

        return $this->db->single();
    }
}