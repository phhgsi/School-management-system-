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

        // Handle search and filters
        $search = $_GET['search'] ?? '';
        $classId = $_GET['class'] ?? '';
        $status = $_GET['status'] ?? '';
        $gender = $_GET['gender'] ?? '';

        $students = $studentModel->searchStudents($search, $classId, $status, $gender);

        $data = [
            'title' => 'Students Management - ' . APP_NAME,
            'students' => $students,
            'classes' => $classModel->getAll(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/students', $data);
    }

    public function addStudent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $studentModel = $this->model('Student');

            $data = [
                'scholar_number' => trim($_POST['scholar_number']),
                'admission_number' => trim($_POST['admission_number']),
                'first_name' => trim($_POST['first_name']),
                'middle_name' => trim($_POST['middle_name'] ?? ''),
                'last_name' => trim($_POST['last_name']),
                'class_id' => (int)$_POST['class_id'],
                'section' => trim($_POST['section']),
                'roll_number' => (int)$_POST['roll_number'],
                'date_of_birth' => $_POST['date_of_birth'],
                'gender' => $_POST['gender'],
                'blood_group' => trim($_POST['blood_group'] ?? ''),
                'nationality' => $_POST['nationality'] ?? 'Indian',
                'religion' => trim($_POST['religion'] ?? ''),
                'caste' => trim($_POST['caste'] ?? ''),
                'aadhar_number' => trim($_POST['aadhar_number'] ?? ''),
                'samagra_id' => trim($_POST['samagra_id'] ?? ''),
                'apaar_id' => trim($_POST['apaar_id'] ?? ''),
                'pan_number' => trim($_POST['pan_number'] ?? ''),
                'father_name' => trim($_POST['father_name']),
                'mother_name' => trim($_POST['mother_name']),
                'guardian_name' => trim($_POST['guardian_name'] ?? ''),
                'guardian_contact' => trim($_POST['guardian_contact'] ?? ''),
                'permanent_address' => trim($_POST['permanent_address']),
                'temporary_address' => trim($_POST['temporary_address'] ?? ''),
                'village' => trim($_POST['village'] ?? ''),
                'mobile' => trim($_POST['mobile']),
                'email' => trim($_POST['email'] ?? ''),
                'previous_school' => trim($_POST['previous_school'] ?? ''),
                'medical_conditions' => trim($_POST['medical_conditions'] ?? ''),
                'status' => 'active'
            ];

            // Handle file upload
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $data['photo'] = $this->uploadStudentPhoto($_FILES['photo']);
            }

            if ($studentModel->createStudent($data)) {
                $this->auth->session->setFlash('success', 'Student added successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to add student');
            }

            $this->redirect('/admin/students');
        }
    }

    public function editStudent($id) {
        $studentModel = $this->model('Student');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'scholar_number' => trim($_POST['scholar_number']),
                'admission_number' => trim($_POST['admission_number']),
                'first_name' => trim($_POST['first_name']),
                'middle_name' => trim($_POST['middle_name'] ?? ''),
                'last_name' => trim($_POST['last_name']),
                'class_id' => (int)$_POST['class_id'],
                'section' => trim($_POST['section']),
                'roll_number' => (int)$_POST['roll_number'],
                'date_of_birth' => $_POST['date_of_birth'],
                'gender' => $_POST['gender'],
                'blood_group' => trim($_POST['blood_group'] ?? ''),
                'nationality' => $_POST['nationality'] ?? 'Indian',
                'religion' => trim($_POST['religion'] ?? ''),
                'caste' => trim($_POST['caste'] ?? ''),
                'aadhar_number' => trim($_POST['aadhar_number'] ?? ''),
                'samagra_id' => trim($_POST['samagra_id'] ?? ''),
                'apaar_id' => trim($_POST['apaar_id'] ?? ''),
                'pan_number' => trim($_POST['pan_number'] ?? ''),
                'father_name' => trim($_POST['father_name']),
                'mother_name' => trim($_POST['mother_name']),
                'guardian_name' => trim($_POST['guardian_name'] ?? ''),
                'guardian_contact' => trim($_POST['guardian_contact'] ?? ''),
                'permanent_address' => trim($_POST['permanent_address']),
                'temporary_address' => trim($_POST['temporary_address'] ?? ''),
                'village' => trim($_POST['village'] ?? ''),
                'mobile' => trim($_POST['mobile']),
                'email' => trim($_POST['email'] ?? ''),
                'previous_school' => trim($_POST['previous_school'] ?? ''),
                'medical_conditions' => trim($_POST['medical_conditions'] ?? ''),
                'status' => $_POST['status']
            ];

            // Handle file upload
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                // Delete old photo if exists
                $oldStudent = $studentModel->getById($id);
                if ($oldStudent && !empty($oldStudent['photo'])) {
                    $oldPhotoPath = UPLOADS_PATH . 'students/' . $oldStudent['photo'];
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                }
                $data['photo'] = $this->uploadStudentPhoto($_FILES['photo']);
            }

            if ($studentModel->updateStudent($id, $data)) {
                $this->auth->session->setFlash('success', 'Student updated successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to update student');
            }

            $this->redirect('/admin/students');
        }

        $student = $studentModel->getById($id);
        if (!$student) {
            $this->auth->session->setFlash('error', 'Student not found');
            $this->redirect('/admin/students');
        }

        $classModel = $this->model('Class');
        $data = [
            'title' => 'Edit Student - ' . APP_NAME,
            'student' => $student,
            'classes' => $classModel->getAll(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/edit_student', $data);
    }

    public function deleteStudent($id) {
        $studentModel = $this->model('Student');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($studentModel->deleteStudent($id)) {
                $this->auth->session->setFlash('success', 'Student deleted successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to delete student');
            }
        }

        $this->redirect('/admin/students');
    }

    public function viewStudent($id) {
        $studentModel = $this->model('Student');

        $student = $studentModel->getStudentProfile($id);
        if (!$student) {
            $this->auth->session->setFlash('error', 'Student not found');
            $this->redirect('/admin/students');
        }

        $data = [
            'title' => 'Student Profile - ' . APP_NAME,
            'student' => $student,
            'attendance' => $studentModel->getStudentAttendance($id),
            'fees' => $studentModel->getStudentFees($id),
            'results' => $studentModel->getStudentResults($id),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/view_student', $data);
    }

    private function uploadStudentPhoto($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('student_') . '.' . $extension;
        $uploadPath = UPLOADS_PATH . 'students/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return $filename;
        }

        return false;
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

    public function addTeacher() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $teacherModel = $this->model('Teacher');

            $data = [
                'employee_id' => trim($_POST['employee_id']),
                'first_name' => trim($_POST['first_name']),
                'middle_name' => trim($_POST['middle_name'] ?? ''),
                'last_name' => trim($_POST['last_name']),
                'date_of_birth' => $_POST['date_of_birth'],
                'gender' => $_POST['gender'],
                'marital_status' => $_POST['marital_status'] ?? '',
                'blood_group' => trim($_POST['blood_group'] ?? ''),
                'qualification' => trim($_POST['qualification']),
                'specialization' => trim($_POST['specialization'] ?? ''),
                'designation' => trim($_POST['designation']),
                'department' => trim($_POST['department'] ?? ''),
                'date_of_joining' => $_POST['date_of_joining'],
                'experience_years' => (int)($_POST['experience_years'] ?? 0),
                'permanent_address' => trim($_POST['permanent_address']),
                'temporary_address' => trim($_POST['temporary_address'] ?? ''),
                'mobile' => trim($_POST['mobile']),
                'email' => trim($_POST['email'] ?? ''),
                'aadhar_number' => trim($_POST['aadhar_number'] ?? ''),
                'pan_number' => trim($_POST['pan_number'] ?? ''),
                'samagra_id' => trim($_POST['samagra_id'] ?? ''),
                'medical_conditions' => trim($_POST['medical_conditions'] ?? ''),
                'status' => 'active'
            ];

            // Handle file upload
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $data['photo'] = $this->uploadTeacherPhoto($_FILES['photo']);
            }

            if ($teacherModel->createTeacher($data)) {
                $this->auth->session->setFlash('success', 'Teacher added successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to add teacher');
            }

            $this->redirect('/admin/teachers');
        }
    }

    public function editTeacher($id) {
        $teacherModel = $this->model('Teacher');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'employee_id' => trim($_POST['employee_id']),
                'first_name' => trim($_POST['first_name']),
                'middle_name' => trim($_POST['middle_name'] ?? ''),
                'last_name' => trim($_POST['last_name']),
                'date_of_birth' => $_POST['date_of_birth'],
                'gender' => $_POST['gender'],
                'marital_status' => $_POST['marital_status'] ?? '',
                'blood_group' => trim($_POST['blood_group'] ?? ''),
                'qualification' => trim($_POST['qualification']),
                'specialization' => trim($_POST['specialization'] ?? ''),
                'designation' => trim($_POST['designation']),
                'department' => trim($_POST['department'] ?? ''),
                'date_of_joining' => $_POST['date_of_joining'],
                'experience_years' => (int)($_POST['experience_years'] ?? 0),
                'permanent_address' => trim($_POST['permanent_address']),
                'temporary_address' => trim($_POST['temporary_address'] ?? ''),
                'mobile' => trim($_POST['mobile']),
                'email' => trim($_POST['email'] ?? ''),
                'aadhar_number' => trim($_POST['aadhar_number'] ?? ''),
                'pan_number' => trim($_POST['pan_number'] ?? ''),
                'samagra_id' => trim($_POST['samagra_id'] ?? ''),
                'medical_conditions' => trim($_POST['medical_conditions'] ?? ''),
                'status' => $_POST['status']
            ];

            // Handle file upload
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                // Delete old photo if exists
                $oldTeacher = $teacherModel->getById($id);
                if ($oldTeacher && !empty($oldTeacher['photo'])) {
                    $oldPhotoPath = UPLOADS_PATH . 'teachers/' . $oldTeacher['photo'];
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                }
                $data['photo'] = $this->uploadTeacherPhoto($_FILES['photo']);
            }

            if ($teacherModel->updateTeacher($id, $data)) {
                $this->auth->session->setFlash('success', 'Teacher updated successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to update teacher');
            }

            $this->redirect('/admin/teachers');
        }

        $teacher = $teacherModel->getById($id);
        if (!$teacher) {
            $this->auth->session->setFlash('error', 'Teacher not found');
            $this->redirect('/admin/teachers');
        }

        $data = [
            'title' => 'Edit Teacher - ' . APP_NAME,
            'teacher' => $teacher,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/edit_teacher', $data);
    }

    public function deleteTeacher($id) {
        $teacherModel = $this->model('Teacher');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($teacherModel->deleteTeacher($id)) {
                $this->auth->session->setFlash('success', 'Teacher deleted successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to delete teacher');
            }
        }

        $this->redirect('/admin/teachers');
    }

    public function viewTeacher($id) {
        $teacherModel = $this->model('Teacher');

        $teacher = $teacherModel->getTeacherProfile($id);
        if (!$teacher) {
            $this->auth->session->setFlash('error', 'Teacher not found');
            $this->redirect('/admin/teachers');
        }

        $data = [
            'title' => 'Teacher Profile - ' . APP_NAME,
            'teacher' => $teacher,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/view_teacher', $data);
    }

    private function uploadTeacherPhoto($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('teacher_') . '.' . $extension;
        $uploadPath = UPLOADS_PATH . 'teachers/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return $filename;
        }

        return false;
    }

    public function classes() {
        $classModel = $this->model('Class');
        $teacherModel = $this->model('Teacher');
        $subjectModel = $this->model('Subject');

        // Get all subjects with class and teacher information
        $allSubjects = [];
        $classes = $classModel->getAll();
        foreach ($classes as $class) {
            $subjects = $subjectModel->getSubjectsByClass($class['id']);
            foreach ($subjects as $subject) {
                $subject['class_name'] = $class['class_name'];
                $subject['class_section'] = $class['section'];
                $allSubjects[] = $subject;
            }
        }

        $data = [
            'title' => 'Classes & Subjects - ' . APP_NAME,
            'classes' => $classModel->getClassesWithTeachers(),
            'teachers' => $teacherModel->getActive(),
            'subjects' => $allSubjects,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/classes', $data);
    }

    public function addClass() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $classModel = $this->model('Class');

            $data = [
                'class_name' => trim($_POST['class_name']),
                'section' => trim($_POST['section']),
                'class_teacher_id' => !empty($_POST['class_teacher_id']) ? (int)$_POST['class_teacher_id'] : null,
                'room_number' => trim($_POST['room_number'] ?? ''),
                'capacity' => (int)($_POST['capacity'] ?? 30),
                'academic_year' => defined('CURRENT_ACADEMIC_YEAR') ? CURRENT_ACADEMIC_YEAR : '2024-2025',
                'status' => 'active'
            ];

            if ($classModel->createClass($data)) {
                $this->auth->session->setFlash('success', 'Class created successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to create class');
            }

            $this->redirect('/admin/classes');
        }
    }

    public function editClass($id) {
        $classModel = $this->model('Class');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'class_name' => trim($_POST['class_name']),
                'section' => trim($_POST['section']),
                'class_teacher_id' => !empty($_POST['class_teacher_id']) ? (int)$_POST['class_teacher_id'] : null,
                'room_number' => trim($_POST['room_number'] ?? ''),
                'capacity' => (int)($_POST['capacity'] ?? 30),
                'status' => $_POST['status']
            ];

            if ($classModel->updateClass($id, $data)) {
                $this->auth->session->setFlash('success', 'Class updated successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to update class');
            }

            $this->redirect('/admin/classes');
        }

        $class = $classModel->getById($id);
        if (!$class) {
            $this->auth->session->setFlash('error', 'Class not found');
            $this->redirect('/admin/classes');
        }

        $teacherModel = $this->model('Teacher');
        $data = [
            'title' => 'Edit Class - ' . APP_NAME,
            'class' => $class,
            'teachers' => $teacherModel->getActive(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/edit_class', $data);
    }

    public function deleteClass($id) {
        $classModel = $this->model('Class');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($classModel->deleteClass($id)) {
                $this->auth->session->setFlash('success', 'Class deleted successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to delete class');
            }
        }

        $this->redirect('/admin/classes');
    }

    public function addSubject() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subjectModel = $this->model('Subject');

            $data = [
                'subject_name' => trim($_POST['subject_name']),
                'subject_code' => trim($_POST['subject_code']),
                'class_id' => (int)$_POST['class_id'],
                'teacher_id' => !empty($_POST['teacher_id']) ? (int)$_POST['teacher_id'] : null,
                'max_marks' => (int)($_POST['max_marks'] ?? 100),
                'pass_marks' => (int)($_POST['pass_marks'] ?? 33),
                'description' => trim($_POST['description'] ?? ''),
                'status' => 'active'
            ];

            if ($subjectModel->createSubject($data)) {
                $this->auth->session->setFlash('success', 'Subject created successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to create subject');
            }

            $this->redirect('/admin/classes');
        }
    }

    public function editSubject($id) {
        $subjectModel = $this->model('Subject');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'subject_name' => trim($_POST['subject_name']),
                'subject_code' => trim($_POST['subject_code']),
                'class_id' => (int)$_POST['class_id'],
                'teacher_id' => !empty($_POST['teacher_id']) ? (int)$_POST['teacher_id'] : null,
                'max_marks' => (int)($_POST['max_marks'] ?? 100),
                'pass_marks' => (int)($_POST['pass_marks'] ?? 33),
                'description' => trim($_POST['description'] ?? ''),
                'status' => $_POST['status']
            ];

            if ($subjectModel->updateSubject($id, $data)) {
                $this->auth->session->setFlash('success', 'Subject updated successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to update subject');
            }

            $this->redirect('/admin/classes');
        }

        $subject = $subjectModel->getById($id);
        if (!$subject) {
            $this->auth->session->setFlash('error', 'Subject not found');
            $this->redirect('/admin/classes');
        }

        $classModel = $this->model('Class');
        $teacherModel = $this->model('Teacher');
        $data = [
            'title' => 'Edit Subject - ' . APP_NAME,
            'subject' => $subject,
            'classes' => $classModel->getAll(),
            'teachers' => $teacherModel->getActive(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/edit_subject', $data);
    }

    public function deleteSubject($id) {
        $subjectModel = $this->model('Subject');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($subjectModel->deleteSubject($id)) {
                $this->auth->session->setFlash('success', 'Subject deleted successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to delete subject');
            }
        }

        $this->redirect('/admin/classes');
    }

    public function attendance() {
        $attendanceModel = $this->model('Attendance');
        $classModel = $this->model('Class');
        $studentModel = $this->model('Student');

        $selectedDate = $_GET['date'] ?? date('Y-m-d');
        $selectedClass = $_GET['class_id'] ?? '';

        $attendance = [];
        if ($selectedClass) {
            $attendance = $attendanceModel->getAttendanceByDate($selectedDate, $selectedClass);
        }

        $data = [
            'title' => 'Attendance Management - ' . APP_NAME,
            'classes' => $classModel->getAll(),
            'attendance' => $attendance,
            'selected_date' => $selectedDate,
            'selected_class' => $selectedClass,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/attendance', $data);
    }

    public function markAttendance() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $attendanceModel = $this->model('Attendance');

            $date = $_POST['attendance_date'];
            $classId = $_POST['class_id'];
            $studentAttendance = $_POST['attendance'] ?? [];

            // First, delete existing attendance for this date and class
            $this->db->query("DELETE FROM attendance WHERE attendance_date = :date AND class_id = :class_id");
            $this->db->bind(':date', $date);
            $this->db->bind(':class_id', $classId);
            $this->db->execute();

            // Insert new attendance records
            foreach ($studentAttendance as $studentId => $status) {
                if (!empty($status)) {
                    $attendanceData = [
                        'student_id' => $studentId,
                        'class_id' => $classId,
                        'attendance_date' => $date,
                        'status' => $status,
                        'marked_by' => $this->auth->getUserId(),
                        'remarks' => $_POST['remarks'][$studentId] ?? ''
                    ];

                    $attendanceModel->markAttendance($attendanceData);
                }
            }

            $this->auth->session->setFlash('success', 'Attendance marked successfully');
            $this->redirect('/admin/attendance?date=' . $date . '&class_id=' . $classId);
        }
    }

    public function getStudentsForAttendance() {
        $classId = $_GET['class_id'] ?? '';
        $date = $_GET['date'] ?? date('Y-m-d');

        if (!$classId) {
            echo json_encode(['error' => 'Class ID required']);
            return;
        }

        $studentModel = $this->model('Student');
        $attendanceModel = $this->model('Attendance');

        $students = $studentModel->getByClass($classId);
        $existingAttendance = $attendanceModel->getAttendanceByDate($date, $classId);

        // Create attendance lookup array
        $attendanceLookup = [];
        foreach ($existingAttendance as $attendance) {
            $attendanceLookup[$attendance['student_id']] = $attendance;
        }

        $result = [];
        foreach ($students as $student) {
            $result[] = [
                'id' => $student['id'],
                'name' => $student['first_name'] . ' ' . $student['last_name'],
                'roll_number' => $student['roll_number'],
                'current_status' => $attendanceLookup[$student['id']]['status'] ?? '',
                'current_remarks' => $attendanceLookup[$student['id']]['remarks'] ?? ''
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($result);
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

    public function createExam() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $examModel = $this->model('Exam');

            $data = [
                'exam_name' => trim($_POST['exam_name']),
                'exam_type' => $_POST['exam_type'],
                'class_id' => (int)$_POST['class_id'],
                'academic_year' => defined('CURRENT_ACADEMIC_YEAR') ? CURRENT_ACADEMIC_YEAR : '2024-2025',
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'description' => trim($_POST['description'] ?? ''),
                'status' => 'draft',
                'created_by' => $this->auth->getUserId()
            ];

            $examId = $examModel->createExam($data);

            if ($examId) {
                // Add exam subjects if provided
                $subjects = $_POST['subjects'] ?? [];
                foreach ($subjects as $subjectData) {
                    if (!empty($subjectData['subject_id'])) {
                        $examModel->addExamSubject([
                            'exam_id' => $examId,
                            'subject_id' => $subjectData['subject_id'],
                            'exam_date' => $subjectData['exam_date'],
                            'start_time' => $subjectData['start_time'],
                            'end_time' => $subjectData['end_time'],
                            'max_marks' => $subjectData['max_marks'] ?? 100,
                            'pass_marks' => $subjectData['pass_marks'] ?? 33,
                            'room_number' => $subjectData['room_number'] ?? '',
                            'instructions' => $subjectData['instructions'] ?? ''
                        ]);
                    }
                }

                $this->auth->session->setFlash('success', 'Exam created successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to create exam');
            }

            $this->redirect('/admin/exams');
        }
    }

    public function editExam($id) {
        $examModel = $this->model('Exam');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'exam_name' => trim($_POST['exam_name']),
                'exam_type' => $_POST['exam_type'],
                'class_id' => (int)$_POST['class_id'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'description' => trim($_POST['description'] ?? ''),
                'status' => $_POST['status']
            ];

            if ($examModel->updateExam($id, $data)) {
                $this->auth->session->setFlash('success', 'Exam updated successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to update exam');
            }

            $this->redirect('/admin/exams');
        }

        $exam = $examModel->getById($id);
        if (!$exam) {
            $this->auth->session->setFlash('error', 'Exam not found');
            $this->redirect('/admin/exams');
        }

        $classModel = $this->model('Class');
        $data = [
            'title' => 'Edit Exam - ' . APP_NAME,
            'exam' => $exam,
            'exam_subjects' => $examModel->getExamSubjects($id),
            'classes' => $classModel->getAll(),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/edit_exam', $data);
    }

    public function deleteExam($id) {
        $examModel = $this->model('Exam');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($examModel->deleteExam($id)) {
                $this->auth->session->setFlash('success', 'Exam deleted successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to delete exam');
            }
        }

        $this->redirect('/admin/exams');
    }

    public function viewExamResults($id) {
        $examModel = $this->model('Exam');

        $exam = $examModel->getById($id);
        if (!$exam) {
            $this->auth->session->setFlash('error', 'Exam not found');
            $this->redirect('/admin/exams');
        }

        $data = [
            'title' => 'Exam Results - ' . APP_NAME,
            'exam' => $exam,
            'results' => $examModel->getStudentResults($id),
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/view_exam_results', $data);
    }

    public function enterResults($examId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $examModel = $this->model('Exam');

            $results = $_POST['results'] ?? [];

            foreach ($results as $studentId => $studentResults) {
                foreach ($studentResults as $subjectId => $marks) {
                    if (is_numeric($marks)) {
                        // Calculate grade based on marks
                        $grade = $this->calculateGrade($marks);

                        $examModel->saveStudentResult([
                            'exam_id' => $examId,
                            'student_id' => $studentId,
                            'subject_id' => $subjectId,
                            'marks_obtained' => $marks,
                            'grade' => $grade,
                            'remarks' => $_POST['remarks'][$studentId][$subjectId] ?? '',
                            'marked_by' => $this->auth->getUserId()
                        ]);
                    }
                }
            }

            $this->auth->session->setFlash('success', 'Results saved successfully');
            $this->redirect('/admin/exams/results/' . $examId);
        }
    }

    private function calculateGrade($marks) {
        if ($marks >= 90) return 'A+';
        elseif ($marks >= 80) return 'A';
        elseif ($marks >= 70) return 'B+';
        elseif ($marks >= 60) return 'B';
        elseif ($marks >= 50) return 'C+';
        elseif ($marks >= 40) return 'C';
        elseif ($marks >= 33) return 'D';
        else return 'F';
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

    public function collectFee() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $feeModel = $this->model('Fee');

            $studentId = $_POST['student_id'];
            $paymentDetails = [];

            // Get fee structure for the student
            $studentFees = $feeModel->getStudentFees($studentId);

            foreach ($studentFees as $fee) {
                $amountPaid = $_POST['fee_amount'][$fee['id']] ?? 0;
                if ($amountPaid > 0) {
                    $paymentDetails[] = [
                        'fee_structure_id' => $fee['id'],
                        'amount_paid' => $amountPaid
                    ];
                }
            }

            if (!empty($paymentDetails)) {
                $totalAmount = array_sum(array_column($paymentDetails, 'amount_paid'));

                $paymentData = [
                    'student_id' => $studentId,
                    'receipt_number' => $feeModel->generateReceiptNumber(),
                    'payment_date' => $_POST['payment_date'],
                    'payment_mode' => $_POST['payment_mode'],
                    'transaction_id' => $_POST['transaction_id'] ?? '',
                    'amount' => $totalAmount,
                    'discount' => $_POST['discount'] ?? 0,
                    'fine' => $_POST['fine'] ?? 0,
                    'remarks' => $_POST['remarks'] ?? '',
                    'collected_by' => $this->auth->getUserId(),
                    'fee_month' => $_POST['fee_month'] ?? date('F'),
                    'fee_year' => $_POST['fee_year'] ?? date('Y')
                ];

                try {
                    $paymentId = $feeModel->recordPayment($paymentData, $paymentDetails);
                    $this->auth->session->setFlash('success', 'Fee collected successfully. Receipt: ' . $paymentData['receipt_number']);
                } catch (Exception $e) {
                    $this->auth->session->setFlash('error', 'Failed to record payment: ' . $e->getMessage());
                }
            } else {
                $this->auth->session->setFlash('error', 'No payment amount specified');
            }

            $this->redirect('/admin/fees');
        }
    }

    public function getStudentFeeDetails() {
        $studentId = $_GET['student_id'] ?? '';

        if (!$studentId) {
            echo json_encode(['error' => 'Student ID required']);
            return;
        }

        $feeModel = $this->model('Fee');
        $studentFees = $feeModel->getStudentFees($studentId);

        header('Content-Type: application/json');
        echo json_encode($studentFees);
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

    public function createEvent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventModel = $this->model('Event');

            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'event_date' => $_POST['event_date'],
                'start_time' => $_POST['start_time'] ?? '',
                'end_time' => $_POST['end_time'] ?? '',
                'venue' => trim($_POST['venue'] ?? ''),
                'event_type' => $_POST['event_type'],
                'target_audience' => $_POST['target_audience'],
                'image' => '',
                'is_public' => isset($_POST['is_public']) ? 1 : 0,
                'status' => $_POST['status'],
                'created_by' => $this->auth->getUserId()
            ];

            // Handle file upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $data['image'] = $this->uploadEventImage($_FILES['image']);
            }

            if ($eventModel->create($data)) {
                $this->auth->session->setFlash('success', 'Event created successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to create event');
            }

            $this->redirect('/admin/events');
        }
    }

    public function editEvent($id) {
        $eventModel = $this->model('Event');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'event_date' => $_POST['event_date'],
                'start_time' => $_POST['start_time'] ?? '',
                'end_time' => $_POST['end_time'] ?? '',
                'venue' => trim($_POST['venue'] ?? ''),
                'event_type' => $_POST['event_type'],
                'target_audience' => $_POST['target_audience'],
                'is_public' => isset($_POST['is_public']) ? 1 : 0,
                'status' => $_POST['status']
            ];

            // Handle file upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Delete old image if exists
                $oldEvent = $eventModel->getById($id);
                if ($oldEvent && !empty($oldEvent['image'])) {
                    $oldImagePath = UPLOADS_PATH . 'events/' . $oldEvent['image'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $data['image'] = $this->uploadEventImage($_FILES['image']);
            }

            if ($eventModel->update($id, $data)) {
                $this->auth->session->setFlash('success', 'Event updated successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to update event');
            }

            $this->redirect('/admin/events');
        }

        $event = $eventModel->getById($id);
        if (!$event) {
            $this->auth->session->setFlash('error', 'Event not found');
            $this->redirect('/admin/events');
        }

        $data = [
            'title' => 'Edit Event - ' . APP_NAME,
            'event' => $event,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/edit_event', $data);
    }

    public function deleteEvent($id) {
        $eventModel = $this->model('Event');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($eventModel->delete($id)) {
                $this->auth->session->setFlash('success', 'Event deleted successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to delete event');
            }
        }

        $this->redirect('/admin/events');
    }

    private function uploadEventImage($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('event_') . '.' . $extension;
        $uploadPath = UPLOADS_PATH . 'events/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return $filename;
        }

        return false;
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

    public function uploadGalleryImage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $galleryModel = $this->model('Gallery');

            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description'] ?? ''),
                'category' => $_POST['category'],
                'is_public' => isset($_POST['is_public']) ? 1 : 0,
                'sort_order' => (int)($_POST['sort_order'] ?? 0),
                'uploaded_by' => $this->auth->getUserId()
            ];

            // Handle file upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $data['image_path'] = $this->uploadGalleryImage($_FILES['image']);
            }

            if ($galleryModel->createImage($data)) {
                $this->auth->session->setFlash('success', 'Image uploaded successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to upload image');
            }

            $this->redirect('/admin/gallery');
        }
    }

    public function editGalleryImage($id) {
        $galleryModel = $this->model('Gallery');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description'] ?? ''),
                'category' => $_POST['category'],
                'is_public' => isset($_POST['is_public']) ? 1 : 0,
                'sort_order' => (int)($_POST['sort_order'] ?? 0)
            ];

            // Handle file upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Delete old image if exists
                $oldImage = $galleryModel->getById($id);
                if ($oldImage && !empty($oldImage['image_path'])) {
                    $oldImagePath = UPLOADS_PATH . 'gallery/' . $oldImage['image_path'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $data['image_path'] = $this->uploadGalleryImage($_FILES['image']);
            }

            if ($galleryModel->updateImage($id, $data)) {
                $this->auth->session->setFlash('success', 'Image updated successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to update image');
            }

            $this->redirect('/admin/gallery');
        }

        $image = $galleryModel->getById($id);
        if (!$image) {
            $this->auth->session->setFlash('error', 'Image not found');
            $this->redirect('/admin/gallery');
        }

        $data = [
            'title' => 'Edit Gallery Image - ' . APP_NAME,
            'image' => $image,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('admin/edit_gallery_image', $data);
    }

    public function deleteGalleryImage($id) {
        $galleryModel = $this->model('Gallery');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($galleryModel->deleteImage($id)) {
                $this->auth->session->setFlash('success', 'Image deleted successfully');
            } else {
                $this->auth->session->setFlash('error', 'Failed to delete image');
            }
        }

        $this->redirect('/admin/gallery');
    }

    private function uploadGalleryFile($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('gallery_') . '.' . $extension;
        $uploadPath = UPLOADS_PATH . 'gallery/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return $filename;
        }

        return false;
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
        $currentMonth = date('m');
        $this->db->query("SELECT SUM(amount) as total FROM fee_payments WHERE strftime('%m', payment_date) = :month");
        $this->db->bind(':month', $currentMonth);
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
        $today = date('Y-m-d');
        $this->db->query("
            SELECT * FROM events
            WHERE event_date >= :today
            AND status = 'published'
            ORDER BY event_date ASC
            LIMIT 5
        ");
        $this->db->bind(':today', $today);
        return $this->db->resultSet();
    }
}