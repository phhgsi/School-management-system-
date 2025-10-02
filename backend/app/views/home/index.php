<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($data['title'] ?? SCHOOL_NAME); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --accent-color: #f093fb;
            --text-dark: #2d3748;
            --text-light: #718096;
            --bg-light: #f7fafc;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
        }

        /* Header Styles */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .header.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 30px rgba(0,0,0,0.15);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-color) !important;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="500" cy="500" r="400" fill="url(%23a)"/></svg>');
            animation: float 20s ease-in-out infinite;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease-out;
        }

        .hero p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 30px;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        .hero-btn {
            background: white;
            color: var(--primary-color);
            border: none;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            animation: fadeInUp 1s ease-out 0.4s both;
        }

        .hero-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        /* Carousel Section */
        .carousel-section {
            background: var(--bg-light);
            padding: 80px 0;
        }

        .carousel-item img {
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
        }

        /* About Section */
        .about-section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 50px;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            margin: 20px auto 0;
            border-radius: 2px;
        }

        /* Courses Section */
        .courses-section {
            background: var(--bg-light);
            padding: 80px 0;
        }

        .course-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .course-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .course-content {
            padding: 25px;
        }

        .course-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 15px;
        }

        .course-description {
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        /* Events Section */
        .events-section {
            padding: 80px 0;
        }

        .event-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .event-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .event-date {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px;
            text-align: center;
        }

        .event-month {
            font-size: 1rem;
            font-weight: 500;
        }

        .event-day {
            font-size: 2rem;
            font-weight: 700;
        }

        .event-content {
            padding: 25px;
        }

        .event-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .event-venue {
            color: var(--text-light);
        }

        /* Gallery Section */
        .gallery-section {
            background: var(--bg-light);
            padding: 80px 0;
        }

        .gallery-item {
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .gallery-item:hover {
            transform: scale(1.05);
        }

        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        /* Testimonials Section */
        .testimonials-section {
            padding: 80px 0;
        }

        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            text-align: center;
        }

        .testimonial-content {
            font-size: 1.1rem;
            line-height: 1.6;
            color: var(--text-dark);
            margin-bottom: 20px;
            font-style: italic;
        }

        .testimonial-author {
            font-weight: 600;
            color: var(--primary-color);
        }

        .testimonial-rating {
            color: #ffd700;
            margin-bottom: 15px;
        }

        /* Footer */
        .footer {
            background: var(--text-dark);
            color: white;
            padding: 50px 0 20px;
        }

        .footer h5 {
            font-weight: 600;
            margin-bottom: 20px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            color: white;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .login-btn {
                position: absolute;
                top: 20px;
                right: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header" id="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="/">
                    <i class="fas fa-graduation-cap me-2"></i>
                    <?php echo htmlspecialchars(SCHOOL_NAME); ?>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#courses">Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#events">Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#gallery">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact</a>
                        </li>
                    </ul>

                    <div class="d-flex">
                        <a href="/login" class="btn btn-outline-primary me-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                        <a href="/admin/dashboard" class="btn btn-primary">
                            <i class="fas fa-tachometer-alt me-2"></i>Admin
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1>Shaping Tomorrow's Leaders Today</h1>
                        <p>Providing quality education and nurturing young minds to become responsible citizens and future leaders of our society.</p>
                        <a href="#about" class="btn hero-btn">
                            <i class="fas fa-arrow-down me-2"></i>Learn More
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image">
                        <img src="/assets/images/hero-education.svg" alt="Education" class="img-fluid" style="max-height: 400px;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Carousel Section -->
    <?php if (!empty($data['carousel'])): ?>
    <section class="carousel-section">
        <div class="container">
            <div class="section-title">Latest News & Announcements</div>
            <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($data['carousel'] as $index => $slide): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="/backend/public/uploads/carousel/<?php echo htmlspecialchars($slide['image']); ?>"
                                         alt="<?php echo htmlspecialchars($slide['title']); ?>"
                                         class="d-block w-100">
                                </div>
                                <div class="col-md-6 d-flex align-items-center">
                                    <div>
                                        <h3><?php echo htmlspecialchars($slide['title']); ?></h3>
                                        <p><?php echo htmlspecialchars($slide['description']); ?></p>
                                        <?php if (!empty($slide['link_url'])): ?>
                                            <a href="<?php echo htmlspecialchars($slide['link_url']); ?>" class="btn btn-primary">Read More</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- About Section -->
    <section class="about-section" id="about">
        <div class="container">
            <div class="section-title">About Our School</div>
            <div class="row">
                <div class="col-lg-6">
                    <?php if (!empty($data['about']['image'])): ?>
                        <img src="/backend/public/uploads/about/<?php echo htmlspecialchars($data['about']['image']); ?>"
                             alt="About" class="img-fluid rounded">
                    <?php endif; ?>
                </div>
                <div class="col-lg-6">
                    <h3><?php echo htmlspecialchars($data['about']['title'] ?? 'Welcome to Our School'); ?></h3>
                    <p><?php echo htmlspecialchars($data['about']['content'] ?? 'We are committed to providing quality education...'); ?></p>

                    <?php if (!empty($data['about']['vision'])): ?>
                        <div class="mt-4">
                            <h5>Our Vision</h5>
                            <p><?php echo htmlspecialchars($data['about']['vision']); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($data['about']['mission'])): ?>
                        <div class="mt-3">
                            <h5>Our Mission</h5>
                            <p><?php echo htmlspecialchars($data['about']['mission']); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section class="courses-section" id="courses">
        <div class="container">
            <div class="section-title">Our Courses</div>
            <div class="row">
                <?php if (!empty($data['courses'])): ?>
                    <?php foreach ($data['courses'] as $course): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="course-card">
                                <?php if (!empty($course['image'])): ?>
                                    <img src="/backend/public/uploads/courses/<?php echo htmlspecialchars($course['image']); ?>"
                                         alt="<?php echo htmlspecialchars($course['course_name']); ?>">
                                <?php endif; ?>
                                <div class="course-content">
                                    <h4 class="course-title"><?php echo htmlspecialchars($course['course_name']); ?></h4>
                                    <p class="course-description"><?php echo htmlspecialchars(substr($course['description'], 0, 100)); ?>...</p>
                                    <?php if (!empty($course['duration'])): ?>
                                        <p><strong>Duration:</strong> <?php echo htmlspecialchars($course['duration']); ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($course['eligibility'])): ?>
                                        <p><strong>Eligibility:</strong> <?php echo htmlspecialchars($course['eligibility']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Default courses if none in database -->
                    <div class="col-lg-4 col-md-6">
                        <div class="course-card">
                            <img src="/assets/images/course-primary.jpg" alt="Primary Education">
                            <div class="course-content">
                                <h4 class="course-title">Primary Education</h4>
                                <p class="course-description">Comprehensive primary education program focusing on fundamental skills and character development...</p>
                                <p><strong>Duration:</strong> 5 years</p>
                                <p><strong>Eligibility:</strong> Age 5-11 years</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="course-card">
                            <img src="/assets/images/course-secondary.jpg" alt="Secondary Education">
                            <div class="course-content">
                                <h4 class="course-title">Secondary Education</h4>
                                <p class="course-description">Advanced curriculum preparing students for higher education and professional careers...</p>
                                <p><strong>Duration:</strong> 7 years</p>
                                <p><strong>Eligibility:</strong> Class V passed</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="course-card">
                            <img src="/assets/images/course-senior.jpg" alt="Senior Secondary">
                            <div class="course-content">
                                <h4 class="course-title">Senior Secondary</h4>
                                <p class="course-description">Specialized streams in Science, Commerce, and Humanities for career preparation...</p>
                                <p><strong>Duration:</strong> 2 years</p>
                                <p><strong>Eligibility:</strong> Class X passed</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section class="events-section" id="events">
        <div class="container">
            <div class="section-title">Upcoming Events</div>
            <div class="row">
                <?php if (!empty($data['events'])): ?>
                    <?php foreach ($data['events'] as $event): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="event-card">
                                <div class="event-date">
                                    <div class="event-month"><?php echo date('M', strtotime($event['event_date'])); ?></div>
                                    <div class="event-day"><?php echo date('d', strtotime($event['event_date'])); ?></div>
                                </div>
                                <div class="event-content">
                                    <h5 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                                    <p class="event-venue">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        <?php echo htmlspecialchars($event['venue'] ?? 'TBA'); ?>
                                    </p>
                                    <p><?php echo htmlspecialchars(substr($event['description'], 0, 100)); ?>...</p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Default events if none in database -->
                    <div class="col-lg-4 col-md-6">
                        <div class="event-card">
                            <div class="event-date">
                                <div class="event-month">DEC</div>
                                <div class="event-day">25</div>
                            </div>
                            <div class="event-content">
                                <h5 class="event-title">Christmas Celebration</h5>
                                <p class="event-venue"><i class="fas fa-map-marker-alt me-2"></i>School Auditorium</p>
                                <p>Join us for a joyous Christmas celebration with students and staff...</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery-section" id="gallery">
        <div class="container">
            <div class="section-title">School Gallery</div>
            <div class="row">
                <?php if (!empty($data['gallery'])): ?>
                    <?php foreach ($data['gallery'] as $item): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="gallery-item">
                                <img src="/backend/public/uploads/gallery/<?php echo htmlspecialchars($item['image_path']); ?>"
                                     alt="<?php echo htmlspecialchars($item['title']); ?>">
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Default gallery items if none in database -->
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="gallery-item">
                            <img src="/assets/images/gallery/sports.jpg" alt="Sports Day">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="gallery-item">
                            <img src="/assets/images/gallery/cultural.jpg" alt="Cultural Event">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="gallery-item">
                            <img src="/assets/images/gallery/science-fair.jpg" alt="Science Fair">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="gallery-item">
                            <img src="/assets/images/gallery/annual-day.jpg" alt="Annual Day">
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-title">What Parents Say</div>
            <div class="row">
                <?php if (!empty($data['testimonials'])): ?>
                    <?php foreach ($data['testimonials'] as $testimonial): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="testimonial-card">
                                <div class="testimonial-rating">
                                    <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                                        <i class="fas fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                                <div class="testimonial-content">
                                    "<?php echo htmlspecialchars($testimonial['content']); ?>"
                                </div>
                                <div class="testimonial-author">
                                    - <?php echo htmlspecialchars($testimonial['name']); ?>
                                    <?php if (!empty($testimonial['designation'])): ?>
                                        <br><small><?php echo htmlspecialchars($testimonial['designation']); ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Default testimonials if none in database -->
                    <div class="col-lg-4 col-md-6">
                        <div class="testimonial-card">
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <div class="testimonial-content">
                                "Excellent school with dedicated teachers and great infrastructure. My child has shown tremendous improvement."
                            </div>
                            <div class="testimonial-author">
                                - Mrs. Sarah Johnson<br><small>Parent</small>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <h5><i class="fas fa-graduation-cap me-2"></i><?php echo htmlspecialchars(SCHOOL_NAME); ?></h5>
                    <p><?php echo htmlspecialchars($data['school_info']['address'] ?? SCHOOL_ADDRESS); ?></p>
                    <p>
                        <i class="fas fa-phone me-2"></i><?php echo htmlspecialchars($data['school_info']['phone'] ?? SCHOOL_PHONE); ?><br>
                        <i class="fas fa-envelope me-2"></i><?php echo htmlspecialchars($data['school_info']['email'] ?? SCHOOL_EMAIL); ?>
                    </p>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5>Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#courses">Courses</a></li>
                        <li><a href="#events">Events</a></li>
                        <li><a href="#gallery">Gallery</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5>Student Area</h5>
                    <ul class="footer-links">
                        <li><a href="/login">Student Login</a></li>
                        <li><a href="/admin/dashboard">Admin Login</a></li>
                        <li><a href="/teacher/dashboard">Teacher Portal</a></li>
                        <li><a href="/parent/dashboard">Parent Portal</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5>Follow Us</h5>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr style="background: rgba(255,255,255,0.2); margin: 30px 0;">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(SCHOOL_NAME); ?>. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>Powered by School Management System</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Auto-play carousel
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = new bootstrap.Carousel(document.getElementById('newsCarousel'), {
                interval: 5000
            });
        });
    </script>
</body>
</html>