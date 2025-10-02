# 🏫 School Management System

A comprehensive, modern, and feature-rich School Management System built with PHP, designed to streamline educational institution operations and enhance the learning experience for students, teachers, parents, and administrators.

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
- **Event Management** - School events and announcements
- **Gallery Management** - Photo and video management

### 🔒 Security Features
- **Role-based Access Control** - Granular permissions for each user type
- **CSRF Protection** - Cross-Site Request Forgery prevention
- **Rate Limiting** - API and login attempt protection
- **Input Validation** - Comprehensive data sanitization
- **Session Management** - Secure session handling with timeout

### 🚀 Technical Features
- **MVC Architecture** - Clean, maintainable code structure
- **Responsive Design** - Mobile-first, modern UI with Bootstrap 5
- **Database Optimization** - Efficient queries with proper indexing
- **File Management** - Secure file upload and organization
- **Email Integration** - Automated notifications and reports

## 🛠️ Technology Stack

- **Backend**: PHP 8.1+ with MVC architecture
- **Database**: MySQL 8.0+ with optimized schema
- **Frontend**: Bootstrap 5, HTML5, CSS3, JavaScript
- **Security**: CSRF protection, rate limiting, input validation
- **File Handling**: Secure upload with validation

## 📋 System Requirements

### Server Requirements
- **PHP**: 8.1 or higher
- **MySQL**: 8.0 or higher
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **Extensions**: PDO, MySQLi, MBString, cURL, OpenSSL, GD, ZIP

### PHP Extensions Required
- `pdo` - Database connectivity
- `pdo_mysql` - MySQL database driver
- `mbstring` - Multi-byte string handling
- `curl` - HTTP requests
- `openssl` - Encryption functions
- `gd` - Image processing
- `zip` - Archive handling

## 🚀 Installation

### Quick Start (Using Web Installation)

1. **Upload Files**
   ```bash
   # Upload all files to your web server directory
   # Set proper permissions
   chmod 755 .
   chmod 755 backend/logs/
   chmod 755 backend/public/uploads/
   ```

2. **Run Web Installation**
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
   # Edit database settings in backend/config/database.php
   # Update school information in backend/config/app.php
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
│   └── setup.php         # Database setup script
├── assets/               # Frontend assets
│   ├── css/             # Stylesheets
│   ├── js/              # JavaScript files
│   └── images/          # Images
├── install.php          # Web installation script
├── index.php           # Main entry point
└── README.md           # This file
```

## 🔧 Usage Guide

### Admin Features
- **User Management** - Create, edit, and manage all user accounts
- **System Settings** - Configure school information and preferences
- **Student Management** - Oversee all student records and activities
- **Teacher Management** - Manage teaching staff and assignments
- **Class Management** - Organize classes and subjects
- **Attendance Management** - Track student and teacher attendance
- **Exam Management** - Schedule exams and manage results
- **Fee Management** - Handle fee collection and payments
- **Event Management** - Manage school events and announcements
- **Gallery Management** - Upload and organize school photos
- **Reports** - Generate comprehensive reports and analytics

### Teacher Features
- **Class Management** - View assigned classes and students
- **Attendance** - Mark and track student attendance
- **Exams** - Enter marks and manage exam results
- **Assignments** - Create and manage assignments
- **Grade Book** - Maintain student grades and performance

### Student Features
- **Dashboard** - Personal academic dashboard
- **Attendance** - View attendance records
- **Results** - Check exam results and grades
- **Fee Status** - Check fee payments and outstanding amounts
- **Events** - View school events and announcements

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
- `roles` - Role-based permissions
- `students` - Student information and records
- `teachers` - Teacher information and assignments
- `classes` - Class and section management
- `subjects` - Subject and curriculum management

### Feature Tables
- `attendance` - Attendance records and tracking
- `teacher_attendance` - Teacher attendance records
- `exams` - Examination scheduling and results
- `exam_subjects` - Exam subject schedules
- `exam_results` - Student exam results
- `fee_structure` - Fee definitions and structures
- `fee_payments` - Fee payment records
- `fee_payment_details` - Detailed fee payment information
- `events` - School events and announcements
- `gallery` - Media gallery management

### Content Tables
- `carousel` - Homepage carousel slides
- `about` - About section content
- `courses` - Course information
- `testimonials` - Parent/guardian testimonials

### System Tables
- `settings` - System configuration
- `audit_logs` - System activity tracking
- `rate_limit` - Rate limiting data
- `notifications` - System notifications

## 🚨 Troubleshooting

### Common Issues

**Database Connection Error**
- Check database credentials in `backend/config/database.php`
- Ensure MySQL service is running
- Verify database user permissions

**File Upload Issues**
- Check file permissions on `backend/public/uploads/` directory
- Verify `MAX_FILE_SIZE` setting
- Check PHP upload limits in `php.ini`

**Permission Errors**
- Set proper file and directory permissions
- Check web server user ownership
- Verify `.htaccess` configuration

### Debug Mode
Enable debug mode in `backend/config/app.php`:
```php
define('APP_DEBUG', true);
```

### Log Files
Check logs in `backend/logs/` for detailed error information.

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
- Comprehensive security features
- Role-based access control

## 🙏 Acknowledgments

- **Bootstrap** - Frontend framework
- **Font Awesome** - Icons
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