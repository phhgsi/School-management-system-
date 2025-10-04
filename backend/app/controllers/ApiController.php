<?php
/**
 * API Controller
 * Handles API requests and returns JSON responses
 */

class ApiController extends Controller {
    public function __construct($db, $auth) {
        parent::__construct($db, $auth);
        header('Content-Type: application/json');
    }

    public function getStudents() {
        $studentModel = $this->model('Student');
        $students = $studentModel->getAllWithClass();

        $this->jsonResponse([
            'success' => true,
            'data' => $students,
            'total' => count($students)
        ]);
    }

    public function getTeachers() {
        $teacherModel = $this->model('Teacher');
        $teachers = $teacherModel->getAll();

        $this->jsonResponse([
            'success' => true,
            'data' => $teachers,
            'total' => count($teachers)
        ]);
    }

    public function getClasses() {
        $classModel = $this->model('Class');
        $classes = $classModel->getAll();

        $this->jsonResponse([
            'success' => true,
            'data' => $classes,
            'total' => count($classes)
        ]);
    }

    public function getAttendance() {
        $attendanceModel = $this->model('Attendance');
        $classId = $_GET['class_id'] ?? null;
        $date = $_GET['date'] ?? date('Y-m-d');

        $attendance = $attendanceModel->getAttendanceByDate($date, $classId);

        $this->jsonResponse([
            'success' => true,
            'data' => $attendance,
            'total' => count($attendance)
        ]);
    }

    public function getFees() {
        $feeModel = $this->model('Fee');
        $studentId = $_GET['student_id'] ?? null;

        if ($studentId) {
            $fees = $feeModel->getStudentFees($studentId);
        } else {
            $fees = $feeModel->getFeeStructure();
        }

        $this->jsonResponse([
            'success' => true,
            'data' => $fees,
            'total' => count($fees)
        ]);
    }

    public function getEvents() {
        $eventModel = $this->model('Event');
        $events = $eventModel->getUpcoming();

        $this->jsonResponse([
            'success' => true,
            'data' => $events,
            'total' => count($events)
        ]);
    }

    public function getGallery() {
        $galleryModel = $this->model('Gallery');
        $category = $_GET['category'] ?? null;

        if ($category) {
            $gallery = $galleryModel->getByCategory($category);
        } else {
            $gallery = $galleryModel->getActive();
        }

        $this->jsonResponse([
            'success' => true,
            'data' => $gallery,
            'total' => count($gallery)
        ]);
    }

    public function getDashboardStats() {
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

        $this->jsonResponse([
            'success' => true,
            'data' => $stats
        ]);
    }

    private function jsonResponse($data) {
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }
}