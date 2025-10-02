<?php
/**
 * Admin Controller
 * Handles admin panel functionality
 */

class AdminController extends Controller {
    public function __construct($db, $auth) {
        parent::__construct($db, $auth);
        $this->auth->requireRole(['admin']);
    }

    public function dashboard() {
        // Get dashboard statistics
        $stats = $this->getDashboardStats();

        $data = [
            'title' => 'Admin Dashboard - ' . APP_NAME,
            'stats' => $stats,
            'recent_activities' => $this->getRecentActivities(),
            'upcoming_events' => $this->getUpcomingEvents(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/dashboard', $data);
    }

    public function students() {
        $studentModel = $this->model('Student');
        $classModel = $this->model('Class');

        $data = [
            'title' => 'Students Management - ' . APP_NAME,
            'students' => $studentModel->getAllWithClass(),
            'classes' => $classModel->getAll(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/students', $data);
    }

    public function teachers() {
        $teacherModel = $this->model('Teacher');

        $data = [
            'title' => 'Teachers Management - ' . APP_NAME,
            'teachers' => $teacherModel->getAll(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/teachers', $data);
    }

    public function classes() {
        $classModel = $this->model('ClassModel');
        $teacherModel = $this->model('Teacher');

        $data = [
            'title' => 'Classes & Subjects - ' . APP_NAME,
            'classes' => $classModel->getAll(),
            'teachers' => $teacherModel->getActive(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/classes', $data);
    }

    public function attendance() {
        $attendanceModel = $this->model('Attendance');
        $classModel = $this->model('Class');

        $data = [
            'title' => 'Attendance Management - ' . APP_NAME,
            'classes' => $classModel->getAll(),
            'attendance' => $attendanceModel->getTodayAttendance(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/attendance', $data);
    }

    public function exams() {
        $examModel = $this->model('Exam');
        $classModel = $this->model('Class');

        $data = [
            'title' => 'Exams & Results - ' . APP_NAME,
            'exams' => $examModel->getAll(),
            'classes' => $classModel->getAll(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/exams', $data);
    }

    public function fees() {
        $feeModel = $this->model('Fee');
        $studentModel = $this->model('Student');

        $data = [
            'title' => 'Fee Management - ' . APP_NAME,
            'fee_structure' => $feeModel->getFeeStructure(),
            'recent_payments' => $feeModel->getRecentPayments(),
            'pending_fees' => $feeModel->getPendingFees(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/fees', $data);
    }

    public function events() {
        $eventModel = $this->model('Event');

        $data = [
            'title' => 'Events & Announcements - ' . APP_NAME,
            'events' => $eventModel->getAll(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/events', $data);
    }

    public function gallery() {
        $galleryModel = $this->model('Gallery');

        $data = [
            'title' => 'Gallery Management - ' . APP_NAME,
            'gallery' => $galleryModel->getAll(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/gallery', $data);
    }

    public function reports() {
        $data = [
            'title' => 'Reports - ' . APP_NAME,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/reports', $data);
    }

    public function settings() {
        $settingModel = $this->model('Setting');
        $userModel = $this->model('User');

        $data = [
            'title' => 'System Settings - ' . APP_NAME,
            'settings' => $settingModel->getAll(),
            'users' => $userModel->getActiveUsers(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/settings', $data);
    }

    private function getDashboardStats() {
        $stats = [];

        // Total students
        $this->db->query("SELECT COUNT(*) as total FROM students WHERE status = 'active'");
        $stats['total_students'] = $this->db->single()['total'];

        // Total teachers
        $this->db->query("SELECT COUNT(*) as total FROM teachers WHERE status = 'active'");
        $stats['total_teachers'] = $this->db->single()['total'];

        // Total classes
        $this->db->query("SELECT COUNT(*) as total FROM classes WHERE status = 'active'");
        $stats['total_classes'] = $this->db->single()['total'];

        // Today's attendance
        $today = date('Y-m-d');
        $this->db->query("SELECT COUNT(*) as total FROM attendance WHERE attendance_date = :today");
        $this->db->bind(':today', $today);
        $stats['today_attendance'] = $this->db->single()['total'];

        // Monthly fee collection
        $this->db->query("SELECT SUM(amount) as total FROM fee_payments WHERE MONTH(payment_date) = MONTH(CURRENT_DATE())");
        $result = $this->db->single();
        $stats['monthly_collection'] = $result['total'] ?? 0;

        // Pending fees
        $this->db->query("SELECT SUM(amount) as total FROM fee_payments WHERE status = 'pending'");
        $result = $this->db->single();
        $stats['pending_fees'] = $result['total'] ?? 0;

        return $stats;
    }

    private function getRecentActivities() {
        $this->db->query("
            SELECT al.*, CONCAT(u.first_name, ' ', u.last_name) as user_name
            FROM audit_logs al
            JOIN users u ON al.user_id = u.id
            ORDER BY al.created_at DESC
            LIMIT 10
        ");
        return $this->db->resultSet();
    }

    private function getUpcomingEvents() {
        $this->db->query("
            SELECT * FROM events
            WHERE event_date >= CURDATE()
            AND status = 'published'
            ORDER BY event_date ASC
            LIMIT 5
        ");
        return $this->db->resultSet();
    }
}