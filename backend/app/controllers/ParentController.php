<?php
/**
 * Parent Controller
 * Handles parent portal functionality
 */

class ParentController extends Controller {
    public function __construct($db, $auth) {
        parent::__construct($db, $auth);
        $this->auth->requireRole(['parent']);
    }

    public function dashboard() {
        $studentModel = $this->model('Student');
        $attendanceModel = $this->model('Attendance');
        $examModel = $this->model('Exam');
        $feeModel = $this->model('Fee');

        // Get parent's children (this would need a parent-student relationship table)
        $children = []; // For now, empty array

        $data = [
            'title' => 'Parent Dashboard - ' . APP_NAME,
            'children' => $children,
            'recent_activities' => $this->getRecentActivities(),
            'upcoming_events' => $this->getUpcomingEvents(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('parent/dashboard', $data);
    }

    public function children() {
        $data = [
            'title' => 'My Children - ' . APP_NAME,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('parent/children', $data);
    }

    public function attendance() {
        $data = [
            'title' => 'Children Attendance - ' . APP_NAME,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('parent/attendance', $data);
    }

    public function results() {
        $data = [
            'title' => 'Children Results - ' . APP_NAME,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('parent/results', $data);
    }

    public function fees() {
        $data = [
            'title' => 'Children Fees - ' . APP_NAME,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('parent/fees', $data);
    }

    private function getRecentActivities() {
        $this->db->query("
            SELECT al.*, CONCAT(u.first_name, ' ', u.last_name) as user_name
            FROM audit_logs al
            JOIN users u ON al.user_id = u.id
            WHERE al.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            ORDER BY al.created_at DESC
            LIMIT 5
        ");
        return $this->db->resultSet();
    }

    private function getUpcomingEvents() {
        $this->db->query("
            SELECT * FROM events
            WHERE event_date >= CURDATE()
            AND status = 'published'
            ORDER BY event_date ASC
            LIMIT 3
        ");
        return $this->db->resultSet();
    }
}