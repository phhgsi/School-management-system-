<?php
/**
 * Student Controller
 * Handles student portal functionality
 */

class StudentController extends Controller {
    public function __construct($db, $auth) {
        parent::__construct($db, $auth);
        $this->auth->requireRole(['student']);
    }

    public function dashboard() {
        $studentId = $this->auth->getUserId();
        $studentModel = $this->model('Student');

        // Get student profile
        $profile = $studentModel->getStudentProfile($studentId);

        // Get attendance summary
        $attendanceSummary = $this->getAttendanceSummary($studentId);

        // Get recent results
        $recentResults = $this->getRecentResults($studentId);

        // Get upcoming events
        $upcomingEvents = $this->getUpcomingEvents();

        // Get fee status
        $feeStatus = $this->getFeeStatus($studentId);

        $data = [
            'title' => 'Student Dashboard - ' . APP_NAME,
            'profile' => $profile,
            'attendance_summary' => $attendanceSummary,
            'recent_results' => $recentResults,
            'upcoming_events' => $upcomingEvents,
            'fee_status' => $feeStatus,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('student/dashboard', $data);
    }

    public function profile() {
        $studentId = $this->auth->getUserId();
        $studentModel = $this->model('Student');

        $profile = $studentModel->getStudentProfile($studentId);

        $data = [
            'title' => 'My Profile - ' . APP_NAME,
            'profile' => $profile,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('student/profile', $data);
    }

    public function attendance() {
        $studentId = $this->auth->getUserId();
        $studentModel = $this->model('Student');

        // Get attendance for current month
        $currentMonthAttendance = $studentModel->getStudentAttendance($studentId);

        // Get attendance summary
        $attendanceSummary = $this->getAttendanceSummary($studentId);

        $data = [
            'title' => 'My Attendance - ' . APP_NAME,
            'attendance' => $currentMonthAttendance,
            'summary' => $attendanceSummary,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('student/attendance', $data);
    }

    public function results() {
        $studentId = $this->auth->getUserId();
        $studentModel = $this->model('Student');

        $results = $studentModel->getStudentResults($studentId);

        $data = [
            'title' => 'My Results - ' . APP_NAME,
            'results' => $results,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('student/results', $data);
    }

    public function fees() {
        $studentId = $this->auth->getUserId();
        $studentModel = $this->model('Student');

        $feeHistory = $studentModel->getStudentFees($studentId);
        $feeStatus = $this->getFeeStatus($studentId);

        $data = [
            'title' => 'My Fees - ' . APP_NAME,
            'fee_history' => $feeHistory,
            'fee_status' => $feeStatus,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('student/fees', $data);
    }

    private function getAttendanceSummary($studentId) {
        $currentMonth = date('m');
        $currentYear = date('Y');

        $this->db->query("
            SELECT
                COUNT(*) as total_days,
                SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_days,
                SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent_days,
                SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late_days
            FROM attendance
            WHERE student_id = :student_id
            AND MONTH(attendance_date) = :month
            AND YEAR(attendance_date) = :year
        ");
        $this->db->bind(':student_id', $studentId);
        $this->db->bind(':month', $currentMonth);
        $this->db->bind(':year', $currentYear);

        $result = $this->db->single();

        $total = $result['total_days'];
        $present = $result['present_days'];
        $percentage = $total > 0 ? round(($present / $total) * 100, 1) : 0;

        return [
            'total_days' => $total,
            'present_days' => $present,
            'absent_days' => $result['absent_days'],
            'late_days' => $result['late_days'],
            'percentage' => $percentage
        ];
    }

    private function getRecentResults($studentId, $limit = 5) {
        $this->db->query("
            SELECT er.*, e.exam_name, e.exam_type, s.subject_name,
                   c.class_name, c.section
            FROM exam_results er
            LEFT JOIN exams e ON er.exam_id = e.id
            LEFT JOIN subjects s ON er.subject_id = s.id
            LEFT JOIN classes c ON e.class_id = c.id
            WHERE er.student_id = :student_id
            ORDER BY e.start_date DESC
            LIMIT :limit
        ");
        $this->db->bind(':student_id', $studentId);
        $this->db->bind(':limit', $limit);

        return $this->db->resultSet();
    }

    private function getUpcomingEvents() {
        $this->db->query("
            SELECT * FROM events
            WHERE event_date >= CURDATE()
            AND status = 'published'
            AND (target_audience = 'all' OR target_audience = 'students')
            ORDER BY event_date ASC
            LIMIT 5
        ");

        return $this->db->resultSet();
    }

    private function getFeeStatus($studentId) {
        $this->db->query("
            SELECT
                SUM(CASE WHEN status = 'paid' THEN amount ELSE 0 END) as total_paid,
                SUM(CASE WHEN status = 'pending' THEN amount ELSE 0 END) as total_pending
            FROM fee_payments
            WHERE student_id = :student_id
        ");
        $this->db->bind(':student_id', $studentId);

        $result = $this->db->single();

        return [
            'total_paid' => $result['total_paid'] ?? 0,
            'total_pending' => $result['total_pending'] ?? 0,
            'last_payment' => $this->getLastPaymentDate($studentId)
        ];
    }

    private function getLastPaymentDate($studentId) {
        $this->db->query("
            SELECT payment_date
            FROM fee_payments
            WHERE student_id = :student_id AND status = 'paid'
            ORDER BY payment_date DESC
            LIMIT 1
        ");
        $this->db->bind(':student_id', $studentId);

        $result = $this->db->single();
        return $result ? $result['payment_date'] : null;
    }
}