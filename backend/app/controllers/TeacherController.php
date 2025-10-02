<?php
/**
 * Teacher Controller
 * Handles teacher portal functionality
 */

class TeacherController extends Controller {
    public function __construct($db, $auth) {
        parent::__construct($db, $auth);
        $this->auth->requireRole(['teacher']);
    }

    public function dashboard() {
        $teacherId = $this->auth->getUserId();
        $teacherModel = $this->model('Teacher');

        // Get teacher's classes and subjects
        $myClasses = $teacherModel->getTeacherClasses($teacherId);
        $workload = $teacherModel->getTeacherWorkload($teacherId);

        // Get today's schedule
        $todaySchedule = $this->getTodaySchedule($teacherId);

        // Get pending tasks
        $pendingTasks = $this->getPendingTasks($teacherId);

        $data = [
            'title' => 'Teacher Dashboard - ' . APP_NAME,
            'my_classes' => $myClasses,
            'workload' => $workload,
            'today_schedule' => $todaySchedule,
            'pending_tasks' => $pendingTasks,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('teacher/dashboard', $data);
    }

    public function classes() {
        $teacherId = $this->auth->getUserId();
        $teacherModel = $this->model('Teacher');
        $studentModel = $this->model('Student');

        $myClasses = $teacherModel->getTeacherClasses($teacherId);

        // Get students for each class
        foreach ($myClasses as &$class) {
            $class['students'] = $studentModel->getByClass($class['id']);
        }

        $data = [
            'title' => 'My Classes - ' . APP_NAME,
            'my_classes' => $myClasses,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('teacher/classes', $data);
    }

    public function attendance() {
        $teacherId = $this->auth->getUserId();
        $teacherModel = $this->model('Teacher');
        $attendanceModel = $this->model('Attendance');

        $myClasses = $teacherModel->getTeacherClasses($teacherId);

        $data = [
            'title' => 'Attendance Management - ' . APP_NAME,
            'my_classes' => $myClasses,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('teacher/attendance', $data);
    }

    public function exams() {
        $teacherId = $this->auth->getUserId();
        $examModel = $this->model('Exam');

        // Get exams where teacher is assigned
        $myExams = $examModel->getTeacherExams($teacherId);

        $data = [
            'title' => 'My Exams - ' . APP_NAME,
            'my_exams' => $myExams,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('teacher/exams', $data);
    }

    public function profile() {
        $teacherId = $this->auth->getUserId();
        $teacherModel = $this->model('Teacher');

        $profile = $teacherModel->getTeacherProfile($teacherId);

        $data = [
            'title' => 'My Profile - ' . APP_NAME,
            'profile' => $profile,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('teacher/profile', $data);
    }

    private function getTodaySchedule($teacherId) {
        $today = date('Y-m-d');
        $dayOfWeek = date('l');

        $this->db->query("
            SELECT s.subject_name, c.class_name, c.section,
                   es.start_time, es.end_time, es.room_number
            FROM teacher_subjects ts
            JOIN subjects s ON ts.subject_id = s.id
            JOIN classes c ON ts.class_id = c.id
            LEFT JOIN exam_subjects es ON s.id = es.subject_id
            WHERE ts.teacher_id = :teacher_id
            AND (es.exam_date = :today OR s.id IN (
                SELECT subject_id FROM timetable
                WHERE teacher_id = :teacher_id AND day_of_week = :day_of_week
            ))
            ORDER BY es.start_time, s.subject_name
        ");
        $this->db->bind(':teacher_id', $teacherId);
        $this->db->bind(':today', $today);
        $this->db->bind(':day_of_week', $dayOfWeek);

        return $this->db->resultSet();
    }

    private function getPendingTasks($teacherId) {
        $tasks = [];

        // Pending attendance marking
        $today = date('Y-m-d');
        $this->db->query("
            SELECT COUNT(*) as count
            FROM teacher_subjects ts
            JOIN classes c ON ts.class_id = c.id
            LEFT JOIN attendance a ON c.id = a.class_id AND a.attendance_date = :today
            WHERE ts.teacher_id = :teacher_id AND a.id IS NULL
        ");
        $this->db->bind(':teacher_id', $teacherId);
        $this->db->bind(':today', $today);

        $result = $this->db->single();
        if ($result['count'] > 0) {
            $tasks[] = [
                'type' => 'attendance',
                'title' => 'Mark Attendance',
                'description' => $result['count'] . ' classes pending attendance marking',
                'priority' => 'high',
                'url' => '/teacher/attendance'
            ];
        }

        // Upcoming exams
        $this->db->query("
            SELECT e.exam_name, e.start_date, s.subject_name
            FROM exams e
            JOIN teacher_subjects ts ON e.class_id = ts.class_id
            JOIN subjects s ON ts.subject_id = s.id
            WHERE ts.teacher_id = :teacher_id
            AND e.start_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
            AND e.status = 'published'
            ORDER BY e.start_date
        ");
        $this->db->bind(':teacher_id', $teacherId);

        $upcomingExams = $this->db->resultSet();
        foreach ($upcomingExams as $exam) {
            $tasks[] = [
                'type' => 'exam',
                'title' => 'Upcoming Exam: ' . $exam['exam_name'],
                'description' => $exam['subject_name'] . ' on ' . date('d/m/Y', strtotime($exam['start_date'])),
                'priority' => 'medium',
                'url' => '/teacher/exams'
            ];
        }

        // Pending result entry
        $this->db->query("
            SELECT COUNT(DISTINCT er.id) as count
            FROM exam_results er
            WHERE er.marked_by = :teacher_id AND er.marks_obtained IS NULL
        ");
        $this->db->bind(':teacher_id', $teacherId);

        $result = $this->db->single();
        if ($result['count'] > 0) {
            $tasks[] = [
                'type' => 'results',
                'title' => 'Enter Results',
                'description' => $result['count'] . ' results pending entry',
                'priority' => 'high',
                'url' => '/teacher/exams'
            ];
        }

        return $tasks;
    }
}