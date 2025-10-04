-- SQLite Database Schema for School Management System
-- Version: 1.0.0

-- Users table
CREATE TABLE users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  email TEXT NOT NULL UNIQUE,
  first_name TEXT NOT NULL,
  last_name TEXT NOT NULL,
  role TEXT NOT NULL DEFAULT 'student' CHECK (role IN ('admin','teacher','student','parent','cashier')),
  status TEXT NOT NULL DEFAULT 'active' CHECK (status IN ('active','inactive','suspended')),
  email_verified INTEGER NOT NULL DEFAULT 0,
  phone TEXT,
  profile_image TEXT,
  last_login TEXT,
  login_attempts INTEGER NOT NULL DEFAULT 0,
  locked_until TEXT,
  reset_token TEXT,
  reset_expiry TEXT,
  remember_token TEXT,
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Roles and permissions table
CREATE TABLE roles (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  role_name TEXT NOT NULL UNIQUE,
  display_name TEXT NOT NULL,
  permissions TEXT NOT NULL,
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Students table
CREATE TABLE students (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER,
  scholar_number TEXT NOT NULL UNIQUE,
  admission_number TEXT NOT NULL UNIQUE,
  admission_date TEXT NOT NULL,
  first_name TEXT NOT NULL,
  middle_name TEXT,
  last_name TEXT NOT NULL,
  class_id INTEGER NOT NULL,
  section TEXT NOT NULL,
  roll_number INTEGER NOT NULL,
  date_of_birth TEXT NOT NULL,
  gender TEXT NOT NULL CHECK (gender IN ('male','female','other')),
  blood_group TEXT,
  nationality TEXT NOT NULL DEFAULT 'Indian',
  religion TEXT,
  caste TEXT,
  aadhar_number TEXT UNIQUE,
  samagra_id TEXT,
  apaar_id TEXT,
  pan_number TEXT,
  father_name TEXT NOT NULL,
  mother_name TEXT NOT NULL,
  guardian_name TEXT,
  guardian_contact TEXT,
  permanent_address TEXT NOT NULL,
  temporary_address TEXT,
  village TEXT,
  mobile TEXT NOT NULL,
  email TEXT,
  photo TEXT,
  previous_school TEXT,
  medical_conditions TEXT,
  status TEXT NOT NULL DEFAULT 'active' CHECK (status IN ('active','inactive','transferred','graduated')),
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Teachers table
CREATE TABLE teachers (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER,
  employee_id TEXT NOT NULL UNIQUE,
  first_name TEXT NOT NULL,
  middle_name TEXT,
  last_name TEXT NOT NULL,
  date_of_birth TEXT NOT NULL,
  gender TEXT NOT NULL CHECK (gender IN ('male','female','other')),
  marital_status TEXT CHECK (marital_status IN ('single','married','divorced','widowed')),
  blood_group TEXT,
  qualification TEXT NOT NULL,
  specialization TEXT,
  designation TEXT NOT NULL,
  department TEXT,
  date_of_joining TEXT NOT NULL,
  experience_years INTEGER NOT NULL DEFAULT 0,
  permanent_address TEXT NOT NULL,
  temporary_address TEXT,
  mobile TEXT NOT NULL,
  email TEXT,
  aadhar_number TEXT UNIQUE,
  pan_number TEXT,
  samagra_id TEXT,
  photo TEXT,
  medical_conditions TEXT,
  status TEXT NOT NULL DEFAULT 'active' CHECK (status IN ('active','inactive','resigned','terminated')),
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Classes table
CREATE TABLE classes (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  class_name TEXT NOT NULL,
  section TEXT NOT NULL,
  class_teacher_id INTEGER,
  room_number TEXT,
  capacity INTEGER NOT NULL DEFAULT 30,
  academic_year TEXT NOT NULL,
  status TEXT NOT NULL DEFAULT 'active' CHECK (status IN ('active','inactive')),
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (class_teacher_id) REFERENCES teachers(id)
);

-- Subjects table
CREATE TABLE subjects (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  subject_name TEXT NOT NULL,
  subject_code TEXT NOT NULL UNIQUE,
  class_id INTEGER NOT NULL,
  teacher_id INTEGER,
  max_marks INTEGER NOT NULL DEFAULT 100,
  pass_marks INTEGER NOT NULL DEFAULT 33,
  description TEXT,
  status TEXT NOT NULL DEFAULT 'active' CHECK (status IN ('active','inactive')),
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (class_id) REFERENCES classes(id),
  FOREIGN KEY (teacher_id) REFERENCES teachers(id)
);

-- Student class enrollment
CREATE TABLE student_classes (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  student_id INTEGER NOT NULL,
  class_id INTEGER NOT NULL,
  academic_year TEXT NOT NULL,
  enrollment_date TEXT NOT NULL,
  status TEXT NOT NULL DEFAULT 'enrolled' CHECK (status IN ('enrolled','transferred','withdrawn')),
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES students(id),
  FOREIGN KEY (class_id) REFERENCES classes(id)
);

-- Teacher subject assignments
CREATE TABLE teacher_subjects (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  teacher_id INTEGER NOT NULL,
  subject_id INTEGER NOT NULL,
  class_id INTEGER NOT NULL,
  academic_year TEXT NOT NULL,
  is_class_teacher INTEGER NOT NULL DEFAULT 0,
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (teacher_id) REFERENCES teachers(id),
  FOREIGN KEY (subject_id) REFERENCES subjects(id),
  FOREIGN KEY (class_id) REFERENCES classes(id)
);

-- Attendance table
CREATE TABLE attendance (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  student_id INTEGER NOT NULL,
  class_id INTEGER NOT NULL,
  subject_id INTEGER,
  attendance_date TEXT NOT NULL,
  status TEXT NOT NULL CHECK (status IN ('present','absent','late','half_day')),
  marked_by INTEGER NOT NULL,
  remarks TEXT,
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES students(id),
  FOREIGN KEY (class_id) REFERENCES classes(id),
  FOREIGN KEY (subject_id) REFERENCES subjects(id)
);

-- Teacher attendance table
CREATE TABLE teacher_attendance (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  teacher_id INTEGER NOT NULL,
  attendance_date TEXT NOT NULL,
  status TEXT NOT NULL CHECK (status IN ('present','absent','late','half_day')),
  marked_by INTEGER NOT NULL,
  remarks TEXT,
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (teacher_id) REFERENCES teachers(id)
);

-- Exams table
CREATE TABLE exams (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  exam_name TEXT NOT NULL,
  exam_type TEXT NOT NULL CHECK (exam_type IN ('unit_test','mid_term','final','practical','oral')),
  class_id INTEGER NOT NULL,
  academic_year TEXT NOT NULL,
  start_date TEXT NOT NULL,
  end_date TEXT NOT NULL,
  description TEXT,
  status TEXT NOT NULL DEFAULT 'draft' CHECK (status IN ('draft','published','completed','cancelled')),
  created_by INTEGER NOT NULL,
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (class_id) REFERENCES classes(id)
);

-- Exam subjects schedule
CREATE TABLE exam_subjects (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  exam_id INTEGER NOT NULL,
  subject_id INTEGER NOT NULL,
  exam_date TEXT NOT NULL,
  start_time TEXT NOT NULL,
  end_time TEXT NOT NULL,
  max_marks INTEGER NOT NULL DEFAULT 100,
  pass_marks INTEGER NOT NULL DEFAULT 33,
  room_number TEXT,
  instructions TEXT,
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (exam_id) REFERENCES exams(id),
  FOREIGN KEY (subject_id) REFERENCES subjects(id)
);

-- Exam results
CREATE TABLE exam_results (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  exam_id INTEGER NOT NULL,
  student_id INTEGER NOT NULL,
  subject_id INTEGER NOT NULL,
  marks_obtained REAL NOT NULL,
  grade TEXT,
  remarks TEXT,
  marked_by INTEGER NOT NULL,
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (exam_id) REFERENCES exams(id),
  FOREIGN KEY (student_id) REFERENCES students(id),
  FOREIGN KEY (subject_id) REFERENCES subjects(id)
);

-- Fee structure
CREATE TABLE fee_structure (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  fee_name TEXT NOT NULL,
  fee_type TEXT NOT NULL CHECK (fee_type IN ('tuition','transport','hostel','books','uniform','activity','exam','other')),
  class_id INTEGER,
  amount REAL NOT NULL,
  academic_year TEXT NOT NULL,
  due_date TEXT,
  is_optional INTEGER NOT NULL DEFAULT 0,
  description TEXT,
  status TEXT NOT NULL DEFAULT 'active' CHECK (status IN ('active','inactive')),
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (class_id) REFERENCES classes(id)
);

-- Fee payments
CREATE TABLE fee_payments (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  student_id INTEGER NOT NULL,
  receipt_number TEXT NOT NULL UNIQUE,
  payment_date TEXT NOT NULL,
  payment_mode TEXT NOT NULL CHECK (payment_mode IN ('cash','cheque','online','upi','bank_transfer')),
  transaction_id TEXT,
  amount REAL NOT NULL,
  discount REAL NOT NULL DEFAULT 0.00,
  fine REAL NOT NULL DEFAULT 0.00,
  remarks TEXT,
  collected_by INTEGER NOT NULL,
  fee_month TEXT,
  fee_year INTEGER,
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES students(id)
);

-- Fee payment details
CREATE TABLE fee_payment_details (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  payment_id INTEGER NOT NULL,
  fee_structure_id INTEGER NOT NULL,
  amount_paid REAL NOT NULL,
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (payment_id) REFERENCES fee_payments(id),
  FOREIGN KEY (fee_structure_id) REFERENCES fee_structure(id)
);

-- Events and announcements
CREATE TABLE events (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  title TEXT NOT NULL,
  description TEXT NOT NULL,
  event_date TEXT NOT NULL,
  start_time TEXT,
  end_time TEXT,
  venue TEXT,
  event_type TEXT NOT NULL CHECK (event_type IN ('academic','cultural','sports','other')),
  target_audience TEXT NOT NULL DEFAULT 'all' CHECK (target_audience IN ('all','students','teachers','parents')),
  image TEXT,
  is_public INTEGER NOT NULL DEFAULT 1,
  status TEXT NOT NULL DEFAULT 'draft' CHECK (status IN ('draft','published','cancelled','completed')),
  created_by INTEGER NOT NULL,
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Gallery
CREATE TABLE gallery (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  title TEXT NOT NULL,
  description TEXT,
  image_path TEXT NOT NULL,
  category TEXT NOT NULL CHECK (category IN ('sports','cultural','academic','infrastructure','events','other')),
  is_public INTEGER NOT NULL DEFAULT 1,
  sort_order INTEGER NOT NULL DEFAULT 0,
  uploaded_by INTEGER NOT NULL,
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Homepage carousel
CREATE TABLE carousel (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  title TEXT NOT NULL,
  description TEXT,
  image TEXT NOT NULL,
  link_url TEXT,
  sort_order INTEGER NOT NULL DEFAULT 0,
  status TEXT NOT NULL DEFAULT 'active' CHECK (status IN ('active','inactive')),
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- About section
CREATE TABLE about (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  title TEXT NOT NULL,
  content TEXT NOT NULL,
  vision TEXT,
  mission TEXT,
  image TEXT,
  status TEXT NOT NULL DEFAULT 'active' CHECK (status IN ('active','inactive')),
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Courses
CREATE TABLE courses (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  course_name TEXT NOT NULL,
  description TEXT NOT NULL,
  duration TEXT,
  eligibility TEXT,
  image TEXT,
  sort_order INTEGER NOT NULL DEFAULT 0,
  status TEXT NOT NULL DEFAULT 'active' CHECK (status IN ('active','inactive')),
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Testimonials
CREATE TABLE testimonials (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  designation TEXT,
  content TEXT NOT NULL,
  image TEXT,
  rating INTEGER NOT NULL DEFAULT 5,
  sort_order INTEGER NOT NULL DEFAULT 0,
  status TEXT NOT NULL DEFAULT 'active' CHECK (status IN ('active','inactive')),
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Settings
CREATE TABLE settings (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  setting_key TEXT NOT NULL UNIQUE,
  setting_value TEXT,
  setting_group TEXT NOT NULL DEFAULT 'general',
  is_serialized INTEGER NOT NULL DEFAULT 0,
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Audit logs
CREATE TABLE audit_logs (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER,
  action TEXT NOT NULL,
  table_name TEXT NOT NULL,
  record_id INTEGER,
  old_values TEXT,
  new_values TEXT,
  ip_address TEXT,
  user_agent TEXT,
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Rate limiting
CREATE TABLE rate_limit (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  ip_address TEXT NOT NULL,
  timestamp INTEGER NOT NULL
);

-- Notifications
CREATE TABLE notifications (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER,
  title TEXT NOT NULL,
  message TEXT NOT NULL,
  type TEXT NOT NULL DEFAULT 'info' CHECK (type IN ('info','success','warning','error')),
  is_read INTEGER NOT NULL DEFAULT 0,
  read_at TEXT,
  expires_at TEXT,
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert default roles and permissions
INSERT INTO roles (role_name, display_name, permissions) VALUES
('admin', 'Administrator', '{"users": {"create": true, "read": true, "update": true, "delete": true}, "students": {"create": true, "read": true, "update": true, "delete": true}, "teachers": {"create": true, "read": true, "update": true, "delete": true}, "classes": {"create": true, "read": true, "update": true, "delete": true}, "attendance": {"create": true, "read": true, "update": true, "delete": true}, "exams": {"create": true, "read": true, "update": true, "delete": true}, "fees": {"create": true, "read": true, "update": true, "delete": true}, "events": {"create": true, "read": true, "update": true, "delete": true}, "gallery": {"create": true, "read": true, "update": true, "delete": true}, "reports": {"create": true, "read": true, "update": true, "delete": true}, "settings": {"create": true, "read": true, "update": true, "delete": true}}'),
('teacher', 'Teacher', '{"attendance": {"create": true, "read": true, "update": true}, "exams": {"create": true, "read": true, "update": true}, "students": {"read": true}, "classes": {"read": true}, "events": {"read": true}, "profile": {"read": true, "update": true}}'),
('cashier', 'Cashier', '{"fees": {"create": true, "read": true, "update": true}, "reports": {"read": true}, "students": {"read": true}, "profile": {"read": true, "update": true}}'),
('student', 'Student', '{"attendance": {"read": true}, "exams": {"read": true}, "fees": {"read": true}, "events": {"read": true}, "gallery": {"read": true}, "profile": {"read": true, "update": true}}'),
('parent', 'Parent', '{"attendance": {"read": true}, "exams": {"read": true}, "fees": {"read": true}, "events": {"read": true}, "profile": {"read": true}}');

-- Insert default admin user (password: admin123)
INSERT INTO users (username, password, email, first_name, last_name, role, status) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@school.com', 'System', 'Administrator', 'admin', 'active');

-- Insert sample school settings
INSERT INTO settings (setting_key, setting_value, setting_group) VALUES
('school_name', 'Springfield International School', 'general'),
('school_address', '123 Education Street, Knowledge City', 'general'),
('school_phone', '+91-1234567890', 'general'),
('school_email', 'info@springfield.edu', 'general'),
('school_website', 'https://springfield.edu', 'general'),
('academic_year', '2024-2025', 'academic'),
('currency_symbol', '₹', 'financial'),
('timezone', 'Asia/Kolkata', 'general');

-- Create indexes for better performance
CREATE INDEX idx_students_name ON students (first_name, last_name);
CREATE INDEX idx_students_class ON students (class_id, section);
CREATE INDEX idx_teachers_name ON teachers (first_name, last_name);
CREATE INDEX idx_attendance_student_date ON attendance (student_id, attendance_date);
CREATE INDEX idx_attendance_class_date ON attendance (class_id, attendance_date);
CREATE INDEX idx_fee_payments_student ON fee_payments (student_id, payment_date);
CREATE INDEX idx_events_date ON events (event_date, status);