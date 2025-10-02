# 🎓 School Management System

A comprehensive, modern, and feature-rich School Management System built with PHP, designed to streamline educational institution operations and enhance the learning experience for students, teachers, parents, and administrators.
# project rquirements 
## home page
Create a dynamic school website homepage with sections like Header, Image Carousel, About, Courses, Events, Achievements, Gallery, Testimonials, CTA, and Footer. All content must be managed through an Admin Panel, with data stored in a MySQL database. The Admin Panel should allow adding, editing, and deleting homepage content such as carousel images, events, courses, gallery photos, and contact info. The homepage should load data dynamically via PHP APIs and AJAX.
## login page 
Create a Login Page for a school management system with fields for Username/Email and Password, including validation, 'Remember Me', and 'Forgot Password' options. Implement role-based redirection so Admin, Teacher, Cashier, Student, and Parent each land on their respective dashboards after login. Use MySQL with PHP for backend authentication, hashed passwords for security, and AJAX with API for smooth login without page reloads. The design should be responsive and styled using Tailwind + Bootstrap, with dynamic error and success messages.
## header
Design a modern admin panel header for a school management system. The header must include the school logo, navigation menu for Dashboard, Students, Teachers, Classes, Attendance, Exams, Fees, Events, Gallery, and Settings. On the right side, show an Admin profile dropdown with Profile, Change Password, and Logout options. Each module page should have its own header with the module title, breadcrumb navigation, a search bar, and quick action buttons (like Add, Edit, Export). The design should be responsive, using Tailwind + Bootstrap styles, with dynamic data managed by MySQL and editable from the Admin Panel."
## menu 
 Create a responsive admin panel menu for a school management system. The menu should be a collapsible sidebar with icons and text. It must include links for Dashboard, Students, Teachers, Classes & Subjects, Attendance, Exams & Results, Fees, Events, Gallery, Reports, and Settings. Each item should have submenus where required. The active page should be highlighted. Menu data (titles, icons, links, visibility) should be stored in a MySQL database and controlled by the Admin Panel with role-based permissions. On mobile view, the menu should collapse into a drawer. At the bottom, include an Admin user profile section with Profile, Change Password, and Logout options.
## module permissions :- 
Create a role-based permission system for a school management system with four roles: Admin, Teacher, Cashier, and Student. Admin has full access to all modules including user management, students, teachers, classes, attendance, exams, fees, events, gallery, reports, and settings. Teachers can manage attendance, marks, and classes only for their assigned subjects. Cashiers can only manage fees, payments, receipts, and financial reports. Students have read-only access to their own attendance, results, fees, profile, and announcements. All permissions must be stored in a MySQL database, with the ability to edit roles and permissions from the Admin Panel.
## admin pages :-
Create an Admin Panel for a school management system with the following pages: Dashboard, Students, Teachers, Classes & Subjects, Attendance, Exams & Results, Fees, Events & Announcements, Gallery, Reports, and Settings. Each page should support CRUD operations and display data in dynamic tables with filters and search options. The Dashboard must include graphs and quick stats. The Students, Teachers, Classes, Attendance, Exams, and Fees pages must allow full data management with import/export support. The Events, Gallery, and Homepage content must sync with the public website dynamically. The Reports page should allow exporting data to PDF and Excel. The Settings page must provide user management, permissions, school info, homepage customization, and API security options. All data should be stored in MySQL and controlled via Admin Panel.
(admin module)
## Dashboard Page :-
The Dashboard serves as the central hub of the Admin Panel, providing a quick overview of the entire school’s activities. It displays key statistics such as the total number of students, teachers, and classes, along with financial summaries of collected and pending fees. Graphs and charts showcase student attendance percentages, fee collection trends, and exam performance summaries. Notifications highlight important alerts like upcoming events, pending fee payments, and exam schedules. Quick action buttons allow the admin to immediately add new students, teachers, or events without navigating to other modules.
## Students Page :-
The Students page allows full management of student records within the system. It provides a searchable and filterable table view where admins can easily locate students by class, section, or name. From here, the admin can add new students using an admission form, edit existing student details, or delete records if necessary. Each student has an individual profile page displaying personal details, guardian information, assigned class, fee status, attendance history, and academic results. The page also supports data import/export in Excel or CSV format for bulk management, along with an option to generate student ID cards.
## Teachers Page :-
The Teachers page is dedicated to managing teacher profiles and academic responsibilities. Admins can add new teachers by entering their qualifications, subject specializations, and contact details. Teachers can be assigned to classes and subjects, ensuring accurate workload distribution. Each teacher has a profile page containing their attendance, assigned classes, timetable, and performance metrics. The admin can edit or delete records as needed, and search tools make it easy to filter teachers by subject or department.
## Classes & Subjects Page:- 
The Classes & Subjects page enables the admin to organize academic structures. Admins can create new classes and sections, assign subjects to them, and link teachers to specific subjects. This ensures that each class has a complete academic framework with students and teachers properly connected. The page also allows viewing all students assigned to a particular class and optionally supports timetable management, giving a structured overview of daily schedules.
## Attendance Page:-
The Attendance page provides tools for recording and managing both student and teacher attendance. Admins can select a class or teacher and mark daily attendance using checkboxes for Present, Absent, or Late. Attendance data can also be uploaded in bulk using CSV or Excel files. The system generates detailed reports that can be viewed by class, student, or teacher over a specified time period. Graphical summaries allow quick insights into attendance trends and performance.
## Exams & Results Page:- 
The Exams & Results page allows the admin to create exams, assign subjects, and manage student marks. Exams can be categorized as mid-term, final, or custom, with dates and maximum marks defined for each subject. Teachers can enter marks for their subjects, and the system automatically calculates totals, percentages, and grades. Admins can generate class-wise or student-wise results, download printable report cards in PDF format, and publish results to the student portal for viewing.
## Fees Page:-
The Fees page manages the school’s financial transactions. Admins can define fee structures based on class, term, or special services like transport and hostel. Payments can be recorded with details such as date, amount, mode (cash, cheque, online), and receipt number. The page tracks pending fees and provides options for generating and printing receipts. Comprehensive financial reports summarize collections on a daily, monthly, or yearly basis, giving the admin a clear picture of school revenue.
## Events & Announcements Page:-
The Events & Announcements page allows admins to post upcoming events like annual day, sports day, or cultural functions, as well as important notices such as admission deadlines or exam schedules. Each event includes a title, description, date, venue, and optional image. Events can be published directly to the homepage carousel or scheduled in advance. An integrated calendar view provides a timeline of all upcoming and past events for easy reference.
## Gallery Page:-
The Gallery page manages all media content related to school functions and activities. Admins can upload images and videos, organize them into categories such as Sports, Cultural, or Academics, and publish them to the public gallery. The page supports bulk uploads and allows hiding or deleting media files as needed. This feature keeps the school website visually engaging and regularly updated with fresh content.
## Reports Page:-
The Reports page centralizes all analytical data in the system. Admins can generate attendance reports, exam performance summaries, financial fee reports, and teacher workload statistics. Reports can be customized by date range, class, or department and exported in PDF or Excel format for official use. This page ensures the school can analyze trends, identify issues, and present data for audits or parent meetings.
## Settings Page:-
The Settings page controls the core configuration of the school management system. Admins can update school details such as name, logo, motto, contact information, and address. User management tools allow creating, editing, or deleting accounts for Admins, Teachers, Cashiers, and Students, with role-based permissions determining access levels. The page also includes homepage content management (carousel, about section, courses, testimonials, footer), API and security settings, and options for database backup and restore.
(teacher module)
## Dashboard Page:-
The Teacher Dashboard provides a personalized overview of classes, subjects, and daily responsibilities. It displays upcoming lessons, pending attendance tasks, and exam schedules. Notifications highlight important school announcements, upcoming meetings, and submission deadlines. Teachers can also view quick statistics about their assigned classes, such as average attendance or recent exam performance.
## Class & Subject Management Page:-
This page shows all classes and subjects assigned to the teacher. Teachers can view student lists for each class, check timetables, and manage academic tasks. It allows teachers to upload study materials, assignments, or notes for their students, making it easier to share resources directly from the portal.
## Attendance Page:-
Teachers can mark daily attendance for their assigned classes. The page provides a student list with options to mark Present, Absent, or Late. Attendance can be corrected if mistakes occur, and teachers can view summary reports for their subjects. This ensures accountability while also keeping parents informed through the student portal.
## Exams & Results Page:-
Teachers use this page to enter marks for their assigned subjects during exams. They can view student performance records, update marks when necessary, and generate subject-level performance summaries. The system automatically calculates averages and grades, which teachers can review before publishing results.
## Events & Announcements Page:-
Teachers can view all school-wide events and announcements posted by the admin. They may also receive invitations or reminders for meetings, training sessions, and extracurricular activities. Depending on permissions, teachers can request to add academic-related events, such as subject-specific competitions or exhibitions.
## Profile & Settings Page:-
The profile page allows teachers to manage their personal information, update contact details, and change their password. Teachers can also set availability for classes or office hours. Settings are limited to personal preferences, as system-wide configurations are reserved for admins.
(cashier module)
## Dashboard Page:-
The Cashier Dashboard highlights daily financial activity, showing fee payments collected, pending dues, and overall revenue summaries. Alerts display overdue payments and students with pending balances. Quick links provide access to payment entry and receipt generation for faster operations.
## Fee Management Page:-
This is the core of the cashier’s work. It allows recording student fee payments with details like payment date, amount, method (cash, cheque, online), and receipt number. The cashier can search for students by name or class to update their payment status. The system generates instant receipts that can be printed or shared with parents.
## Pending Fees Page:-
This page provides a list of students who have outstanding fees. The cashier can filter by class or due amount and send reminders or generate pending fee reports. This helps track collections and follow up with parents systematically.
## Financial Reports Page:-
Cashiers can generate reports of collected fees, pending dues, and daily, monthly, or yearly summaries. Reports can be exported in PDF or Excel formats and shared with the admin for financial planning. Unlike the admin, the cashier’s reporting is restricted only to finance-related data.
Profile & Settings Page:-The cashier’s profile page allows managing personal details and password changes. Since financial security is critical, role-based restrictions ensure cashiers cannot access academic data or alter school-wide settings.
(student module)
## Dashboard Page:-
The Student Dashboard provides a personalized snapshot of academic and extracurricular activities. It shows the student’s attendance percentage, recent exam results, upcoming events, and fee status. Notifications display important updates such as exam schedules, holiday announcements, and assignments posted by teachers.
## Profile Page:-
This page contains all student details, including personal information, assigned class and section, subjects, and guardian contact details. Students can view but not edit their information. If corrections are needed, they must request updates through the admin office.
## Attendance Page:-
Students can view their attendance history, including daily presence and overall percentage. The system shows subject-wise or class-wise attendance, helping students and parents track performance and punctuality.
## Exams & Results Page:-
This page displays exam schedules, marks, grades, and downloadable report cards. Students can view subject-wise marks, total percentage, and teacher comments. Results are automatically published here once approved by teachers and admin.
## Fees Page:-
Students can view their fee payment history, pending dues, and upcoming payment deadlines. If integrated with online payments, this page provides a link for paying fees directly. Receipts of previous payments are also accessible for reference.
## Events & Announcements Page:-
Students can view all school events, announcements, and important notices published by the admin. They can check event details such as date, venue, and instructions. This keeps them engaged with extracurricular activities beyond academics.
## Gallery Page:-
Students have access to a media gallery containing pictures and videos from school functions, sports events, and cultural activities. The gallery is managed by the admin, ensuring students only see approved content.
Profile & Settings Page:-This page allows students to update personal preferences like password changes and account security. Other personal data remains locked to prevent unauthorized modifications.
## student add :- 
Create a Student Add Form with the following fields: Scholar Number, Admission Number, Admission Date, Full Name (first, middle, last), Class & Section (dropdown), Father’s Name, Mother’s Name, Guardian’s Name & Contact Number, Date of Birth, Gender, Caste/Category, Nationality, Religion, Blood Group, Village/Address, Permanent/Temporary Address, Mobile Number, Email ID, Aadhar Number, Samagra Number, Apaar ID, PAN Number, Previous School Name, Medical Conditions, and Student Photo Upload. Ensure mandatory fields are validated before submission and save the data in MySQL. The form should be responsive, use external CSS (Tailwind + Bootstrap), and include Save and Reset buttons.
## teacher add:-
Create a Teacher Add Form with the following fields: Employee ID, Full Name (first, middle, last), Date of Birth, Gender, Marital Status, Blood Group, Qualification, Specialization/Subjects, Designation/Position, Department, Date of Joining, Experience (years), Permanent Address, Temporary Address, Mobile Number, Email ID, Aadhar Number, PAN Number, Samagra ID (optional), Medical Conditions, Classes & Subjects Assigned (dropdown), and Teacher Photo Upload. Validate required fields before submission and save all data into MySQL. The form should be responsive, styled with Tailwind + Bootstrap, and include Save and Reset buttons.
## fees add :- 
Create a Fees Add Form for a school management system. Select Class and Village to filter students, then dynamically populate Student Name and Father’s Name. Include Fee Details: Total Fee, Fee Type, optional Discount/Scholarship, and Receipt Number. Provide Payment Mode (Cash, Online, Cheque, UPI) with Transaction ID or Cheque Number, Payment Date, and Remarks. Validate mandatory fields before submission. On submit, store data in MySQL, update fee status, and generate three receipts per A4 page (School Copy, Student Copy, Accounts Copy). Use AJAX to fetch student data dynamically and style the form with Tailwind + Bootstrap, making it fully responsive.
## expences add:-
Create a full Expenses Module for a school management system. Include an Expenses Record Form with fields: Receipt Number, Reason for Expense, Expense Category (Diesel, School Staff, Bus Staff, Maintenance, Miscellaneous, or Custom), Amount, Payment Date, and optional Remarks. Validate mandatory fields and store data in MySQL. Include an Expenses Report Page to view, filter, and analyze expenses by Category, Date Range, or Amount Range. Display tables with all expense details and summary totals per category. Include print and export options (PDF/Excel) and optional graphs showing category-wise spending trends. Make the module responsive using Tailwind + Bootstrap, support AJAX for smooth form submission, and enforce role-based permissions (Admin and Cashier access only).
## admit card ui and generation :- 
Create an Admit Card Generation Module for a school management system. Allow admins to generate admit cards class-wise (bulk) or individually. Each admit card should display School Name & Logo, Exam Name, Student Name, Scholar Number, Father’s Name, Class & Section, Roll Number, and Student Photo. Include a subject-wise exam schedule table with Subject Name, Exam Date, Day, Start Time, and End Time, where subjects and timings are entered manually. Reserve space for Principal’s Signature, Exam Controller’s Signature, and School Seal. Support printing multiple admit cards per A4 page (2–4 per sheet) and PDF export. Fetch student data dynamically from MySQL with AJAX and design the layout using Tailwind + Bootstrap. 
## subject schedule management page:-
Create a Subject Schedule Management Page for a school management system. Allow the admin to select Exam Name and Class/Section, then add subjects in a table format. Each row should include Subject Name, Exam Date, Day of Exam, Start Time, and End Time. Admin can add, edit, or delete subjects. Save the schedule in MySQL and link it automatically to the Admit Card Module so admit cards display the correct subject-wise exam schedule. Provide options to print or export the schedule in PDF/Excel for notice board use. Validate all fields before saving. Use Tailwind + Bootstrap for responsive design and AJAX for smooth operations without page reload.
Create a complete Exam Module for a school management system. It should include:
## Exam Setup Page – 
create/manage exams with fields: Exam Name, Exam Type, Class/Section, Exam Start Date, Exam End Date.
Subject Schedule Management Page – select Exam Name & Class/Section, then define subjects in a table (Subject Name, Exam Date, Day, Start Time, End Time). Allow add/edit/delete, save in MySQL, and provide print/export options.
## Admit Card Generation Page – 
generate admit cards class-wise or individually. Show School Name & Logo, Exam Name, Student Details (Name, Scholar No, Father’s Name, Class & Section, Roll No, Photo), and Subject Schedule Table. Include space for Principal/Controller signatures and School Seal. Support printing multiple admit cards per A4 sheet and exporting PDF.
Use Tailwind + Bootstrap for responsive design, AJAX for smooth data fetching, and enforce role-based permissions (Admin full access, Teachers read-only)."*
## profile:-
Create a Profile Section for a school management system where each role (Admin, Teacher, Student, Cashier) has their own profile page. Admin profiles show name, email, phone, role, photo, login activity, and permissions. Teacher profiles show personal details, assigned classes, subjects, timetable, and attendance records. Student profiles show academic and personal details (scholar number, parents’ names, DOB, Aadhaar, Samagra, Aapaar ID, PAN, class, section, roll no, fee status, results, attendance). Cashier profiles show personal details plus financial summaries (fees collected, expenses recorded). All profiles should include profile picture upload, change password option, and activity logs. Store data in MySQL, fetch dynamically with AJAX, and style with Tailwind + Bootstrap for responsive design.
## sql
use terminal to realtime database creation and also write in a .sql page .. 


## ✨ Features

### 👥 Multi-Role Support
- **Admin Dashboard** - Complete system management and oversight
- **Teacher Portal** - Class management, attendance, assignments, and grading
- **Student Portal** - Academic records, assignments, and progress tracking
- **Parent Portal** - Children overview and academic monitoring
- **Cashier Portal** - Fee management and payment processing

### 📊 Core Modules
- **Student Management** - Complete student lifecycle management
- **Teacher Management** - Staff information and performance tracking
- **Class Management** - Class organization and scheduling
- **Attendance System** - Automated attendance tracking and reporting
- **Examination System** - Exam scheduling, grading, and result management
- **Fee Management** - Fee structure, payments, and outstanding tracking
- **Library Management** - Book inventory and transaction management
- **Transport Management** - Route planning and student assignment
- **Notification System** - Multi-channel communication system

### 🔒 Security Features
- **Role-based Access Control** - Granular permissions for each user type
- **CSRF Protection** - Cross-Site Request Forgery prevention
- **Rate Limiting** - API and login attempt protection
- **CORS Support** - Cross-origin resource sharing configuration
- **Input Validation** - Comprehensive data sanitization
- **Session Management** - Secure session handling with timeout

### 🚀 Technical Features
- **MVC Architecture** - Clean, maintainable code structure
- **RESTful API** - Complete API for mobile and external integrations
- **Responsive Design** - Mobile-first, modern UI with Bootstrap 5
- **Database Optimization** - Efficient queries with proper indexing
- **Error Handling** - Comprehensive error logging and reporting
- **File Management** - Secure file upload and organization
- **Caching System** - Performance optimization with caching
- **Email Integration** - Automated notifications and reports

## 🛠️ Technology Stack

- **Backend**: PHP 8.1+ with MVC architecture
- **Database**: MySQL 8.0+ with optimized schema
- **Frontend**: Bootstrap 5, HTML5, CSS3, JavaScript
- **Security**: CSRF protection, rate limiting, input validation
- **API**: RESTful API with JSON responses
- **File Handling**: Secure upload with validation
- **Email**: SMTP integration for notifications
- **Logging**: Comprehensive error and activity logging

## 📋 System Requirements

### Server Requirements
- **PHP**: 8.1 or higher
- **MySQL**: 8.0 or higher
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **Extensions**: PDO, MySQLi, MBString, cURL, OpenSSL, JSON

### PHP Extensions Required
- `pdo` - Database connectivity
- `pdo_mysql` - MySQL database driver
- `mbstring` - Multi-byte string handling
- `curl` - HTTP requests
- `json` - JSON data handling
- `session` - Session management
- `openssl` - Encryption functions

## 🚀 Installation

### Quick Start (Using Installation Script)

1. **Download and Setup**
   ```bash
   # Upload all files to your web server directory
   # Set proper permissions
   chmod 755 .
   chmod 755 backend/logs/
   chmod 755 backend/public/uploads/
   ```

2. **Run Installation**
   ```bash
   # Access the installation script via web browser
   http://localhost/install.php
   ```

3. **Follow the Installation Wizard**
   - System Requirements Check
   - Database Configuration
   - Administrator Account Setup
   - System Installation

### Manual Installation

1. **Database Setup**
   ```sql
   -- Create MySQL database
   CREATE DATABASE school_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

   -- Import database schema
   mysql -u username -p school_management < database/schema.sql
   ```

2. **Configuration**
   ```bash
   # Copy and edit configuration files
   cp config/database.php.example config/database.php
   # Edit database settings in config/database.php
   ```

3. **Web Server Configuration**
   Configure your web server to point to the project root directory.

   **Apache Example:**
   ```apache
   <VirtualHost *:80>
       ServerName your-domain.com
       DocumentRoot /path/to/school-management
       <Directory /path/to/school-management>
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```

## 🔐 Default Login Credentials

After installation, use these credentials to log in:

| Role | Username | Password | Dashboard |
|------|----------|----------|-----------|
| Admin | admin | admin123 | `/admin/dashboard` |
| Teacher | teacher1 | teacher123 | `/teacher/dashboard` |
| Student | student1 | student123 | `/student/dashboard` |
| Parent | parent1 | parent123 | `/parent/dashboard` |
| Cashier | cashier1 | cashier123 | `/cashier/dashboard` |

**⚠️ Important:** Change all default passwords immediately after first login.

## 📁 Project Structure

```
school-management/
├── backend/                 # PHP Backend Application
│   ├── app/                # Application core
│   │   ├── controllers/    # Controllers for different roles
│   │   ├── core/          # Core framework classes
│   │   ├── middleware/    # Security and routing middleware
│   │   ├── models/        # Database models
│   │   └── views/         # View templates
│   ├── config/            # Configuration files
│   └── public/            # Public assets
├── database/              # Database files
│   ├── schema.sql        # Database schema
│   └── seeders.php       # Sample data
├── assets/               # Frontend assets
│   ├── css/             # Stylesheets
│   ├── js/              # JavaScript files
│   └── images/          # Images
├── install.php          # Installation script
├── index.php           # Main entry point
└── README.md           # This file
```

## 🔧 Usage Guide

### Admin Features
- **User Management** - Create, edit, and manage all user accounts
- **System Settings** - Configure school information and preferences
- **Reports** - Generate comprehensive reports and analytics
- **Student Management** - Oversee all student records and activities
- **Teacher Management** - Manage teaching staff and assignments

### Teacher Features
- **Class Management** - Create and manage classes and sections
- **Attendance** - Mark and track student attendance
- **Assignments** - Create and grade assignments
- **Exams** - Schedule and manage examinations
- **Grade Book** - Maintain student grades and performance

### Student Features
- **Dashboard** - Personal academic dashboard
- **Assignments** - View and submit assignments
- **Results** - Check exam results and grades
- **Attendance** - View attendance records
- **Library** - Access library resources

### Parent Features
- **Children Overview** - Monitor children's academic progress
- **Attendance Reports** - Track children's attendance
- **Grade Reports** - View children's academic performance
- **Fee Status** - Check fee payments and outstanding amounts
- **Notifications** - Receive important school updates

### Cashier Features
- **Fee Collection** - Process fee payments
- **Payment Reports** - Generate payment summaries
- **Outstanding Fees** - Track unpaid fees
- **Receipt Generation** - Create payment receipts
- **Financial Reports** - Generate financial summaries

## 🔒 Security Best Practices

1. **Change Default Passwords** - Update all default credentials
2. **Use HTTPS** - Enable SSL/TLS for all connections
3. **Regular Backups** - Implement automated backup procedures
4. **File Permissions** - Set appropriate file and directory permissions
5. **Input Validation** - Never trust user input
6. **Session Management** - Use secure session configurations
7. **Database Security** - Use prepared statements and proper escaping
8. **Error Handling** - Don't expose sensitive information in errors

## 📊 Database Schema

The system includes 31+ optimized tables:

### Core Tables
- `users` - User accounts and authentication
- `students` - Student information and records
- `teachers` - Teacher information and assignments
- `classes` - Class and section management
- `subjects` - Subject and curriculum management

### Feature Tables
- `attendance` - Attendance records and tracking
- `exams` - Examination scheduling and results
- `fees` - Fee management and payments
- `library_books` - Library inventory management
- `notifications` - System notifications and alerts

### Archive Tables
- `archived_*` - Historical data preservation
- `audit_logs` - System activity tracking

## 🚨 Troubleshooting

### Common Issues

**Database Connection Error**
- Check database credentials in `config/database.php`
- Ensure MySQL service is running
- Verify database user permissions

**File Upload Issues**
- Check file permissions on `backend/public/uploads/` directory
- Verify `MAX_FILE_SIZE` setting
- Check PHP upload limits in `php.ini`

**Email Not Sending**
- Verify SMTP settings in configuration
- Check email service credentials
- Ensure firewall allows SMTP connections

**Permission Errors**
- Set proper file and directory permissions
- Check web server user ownership
- Verify `.htaccess` configuration

### Debug Mode
Enable debug mode in `config/app.php`:
```php
'debug' => true,
'log_level' => 'debug',
```

### Log Files
Check logs in `backend/logs/application.log` for detailed error information.

## 📞 Support

For support and questions:

1. **Documentation** - Check this README and inline code comments
2. **Issue Tracking** - Report bugs and request features
3. **Community** - Join our community forums
4. **Professional Support** - Contact our support team

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🤝 Contributing

We welcome contributions! Please see our contributing guidelines:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Submit a pull request

## 📈 Changelog

### Version 1.0.0
- Initial release
- Complete school management system
- Multi-role support
- Modern UI with Bootstrap 5
- RESTful API
- Comprehensive security features

## 🙏 Acknowledgments

- **Bootstrap** - Frontend framework
- **Font Awesome** - Icons
- **jQuery** - JavaScript library
- **MySQL** - Database system
- **PHP** - Server-side scripting

---

**School Management System v1.0.0**
Built with ❤️ for educational institutions worldwide.

## 📞 Quick Start Guide

1. **Access Installation**: Visit `http://localhost/install.php`
2. **Follow Setup Wizard**: Complete the 5-step installation process
3. **Login**: Use the default credentials provided above
4. **Explore**: Navigate through different user roles and features
5. **Customize**: Modify settings and add your school information

## 🔗 Links

- **Home Page**: `index.php`
- **Installation**: `install.php`
- **Admin Dashboard**: `index.php?page=admin&action=dashboard`
- **Documentation**: This README file

---

*For more detailed documentation, please refer to the inline code comments and configuration files.*
