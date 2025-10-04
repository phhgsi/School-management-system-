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
        // For now, we'll get all students as a placeholder
        $children = $studentModel->getAll();

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
        $studentModel = $this->model('Student');
        $classModel = $this->model('Class');

        $data = [
            'title' => 'My Children - ' . APP_NAME,
            'children' => $studentModel->getAll(),
            'classes' => $classModel->getAll(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('parent/children', $data);
    }

    public function attendance() {
        $studentModel = $this->model('Student');
        $attendanceModel = $this->model('Attendance');

        $selectedStudent = $_GET['student_id'] ?? '';
        $selectedMonth = $_GET['month'] ?? date('Y-m');

        $children = $studentModel->getAll();
        $attendance = [];
        $stats = ['total_days' => 0, 'present_days' => 0, 'absent_days' => 0, 'percentage' => 0];

        if ($selectedStudent) {
            $attendance = $attendanceModel->getStudentAttendanceByMonth($selectedStudent, $selectedMonth);
            $stats = $this->calculateAttendanceStats($attendance);
        }

        $data = [
            'title' => 'Children Attendance - ' . APP_NAME,
            'children' => $children,
            'attendance' => $attendance,
            'stats' => $stats,
            'selected_student' => $selectedStudent,
            'selected_month' => $selectedMonth,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('parent/attendance', $data);
    }

    public function results() {
        $studentModel = $this->model('Student');
        $examModel = $this->model('Exam');

        $selectedStudent = $_GET['student_id'] ?? '';
        $selectedExam = $_GET['exam_id'] ?? '';

        $children = $studentModel->getAll();
        $exams = $examModel->getAll();
        $results = [];

        if ($selectedStudent) {
            $results = $examModel->getStudentResults($selectedStudent, $selectedExam);
        }

        $data = [
            'title' => 'Children Results - ' . APP_NAME,
            'children' => $children,
            'exams' => $exams,
            'results' => $results,
            'selected_student' => $selectedStudent,
            'selected_exam' => $selectedExam,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('parent/results', $data);
    }

    public function fees() {
        $studentModel = $this->model('Student');
        $feeModel = $this->model('Fee');

        $selectedStudent = $_GET['student_id'] ?? '';
        $selectedYear = $_GET['year'] ?? date('Y');

        $children = $studentModel->getAll();
        $feeStructure = [];
        $payments = [];
        $summary = ['total_paid' => 0, 'total_pending' => 0, 'total_overdue' => 0, 'grand_total' => 0];

        if ($selectedStudent) {
            $feeStructure = $feeModel->getStudentFees($selectedStudent);
            $payments = $feeModel->getStudentPayments($selectedStudent, $selectedYear);
            $summary = $this->calculateFeeSummary($payments, $feeStructure);
        }

        $data = [
            'title' => 'Children Fees - ' . APP_NAME,
            'children' => $children,
            'fee_structure' => $feeStructure,
            'payments' => $payments,
            'summary' => $summary,
            'selected_student' => $selectedStudent,
            'selected_year' => $selectedYear,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('parent/fees', $data);
    }

    private function calculateAttendanceStats($attendance) {
        $total = count($attendance);
        $present = 0;
        $absent = 0;

        foreach ($attendance as $record) {
            if ($record['status'] === 'present' || $record['status'] === 'late') {
                $present++;
            } elseif ($record['status'] === 'absent') {
                $absent++;
            }
        }

        $percentage = $total > 0 ? round(($present / $total) * 100, 2) : 0;

        return [
            'total_days' => $total,
            'present_days' => $present,
            'absent_days' => $absent,
            'percentage' => $percentage
        ];
    }

    private function calculateFeeSummary($payments, $feeStructure) {
        $totalPaid = 0;
        $totalPending = 0;
        $totalOverdue = 0;

        foreach ($payments as $payment) {
            $totalPaid += $payment['amount'];
        }

        foreach ($feeStructure as $fee) {
            $totalPending += $fee['amount'];
        }

        $grandTotal = $totalPaid + $totalPending;

        return [
            'total_paid' => $totalPaid,
            'total_pending' => $totalPending,
            'total_overdue' => $totalOverdue,
            'grand_total' => $grandTotal
        ];
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