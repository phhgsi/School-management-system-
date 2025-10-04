<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Children - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .child-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }
        .child-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .child-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
        }
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .status-active { background: #d4edda; color: #155724; }
        .status-inactive { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" id="sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="/parent/dashboard" class="nav-link">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/parent/children" class="nav-link active">
                                <i class="fas fa-users me-2"></i>My Children
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/parent/attendance" class="nav-link">
                                <i class="fas fa-calendar-check me-2"></i>Attendance
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/parent/results" class="nav-link">
                                <i class="fas fa-chart-bar me-2"></i>Results
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/parent/fees" class="nav-link">
                                <i class="fas fa-money-bill me-2"></i>Fees
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/logout" class="nav-link text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">My Children</h1>
                </div>

                <?php if (!empty($data['children'])): ?>
                    <div class="row">
                        <?php foreach ($data['children'] as $child): ?>
                            <div class="col-lg-6 col-xl-4">
                                <div class="child-card card">
                                    <div class="card-body text-center">
                                        <?php if (!empty($child['photo'])): ?>
                                            <img src="/backend/public/uploads/students/<?php echo htmlspecialchars($child['photo']); ?>"
                                                 alt="<?php echo htmlspecialchars($child['first_name']); ?>"
                                                 class="child-avatar mb-3">
                                        <?php else: ?>
                                            <div class="child-avatar mb-3">
                                                <?php echo strtoupper(substr($child['first_name'], 0, 1)); ?>
                                            </div>
                                        <?php endif; ?>

                                        <h5 class="card-title">
                                            <?php echo htmlspecialchars($child['first_name'] . ' ' . $child['last_name']); ?>
                                        </h5>
                                        <p class="text-muted mb-2">
                                            <?php echo htmlspecialchars($child['class_name'] . ' - ' . $child['section']); ?>
                                        </p>

                                        <span class="status-badge status-<?php echo $child['status']; ?>">
                                            <?php echo ucfirst($child['status']); ?>
                                        </span>

                                        <div class="mt-3">
                                            <a href="/parent/attendance?student_id=<?php echo $child['id']; ?>"
                                               class="btn btn-outline-primary btn-sm me-2">
                                                <i class="fas fa-calendar-check me-1"></i>Attendance
                                            </a>
                                            <a href="/parent/results?student_id=<?php echo $child['id']; ?>"
                                               class="btn btn-outline-success btn-sm me-2">
                                                <i class="fas fa-chart-bar me-1"></i>Results
                                            </a>
                                            <a href="/parent/fees?student_id=<?php echo $child['id']; ?>"
                                               class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-money-bill me-1"></i>Fees
                                            </a>
                                        </div>

                                        <div class="mt-3 text-start">
                                            <h6 class="mb-2">Quick Info</h6>
                                            <p class="mb-1"><strong>Roll No:</strong> <?php echo $child['roll_number']; ?></p>
                                            <p class="mb-1"><strong>Scholar No:</strong> <?php echo $child['scholar_number']; ?></p>
                                            <p class="mb-1"><strong>Mobile:</strong> <?php echo $child['mobile']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        No children found in your account. Please contact the school administration to link your children.
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>