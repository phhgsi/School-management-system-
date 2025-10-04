<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-calendar-alt me-2"></i>Events & Announcements
            </h1>
            <p class="page-subtitle">Manage school events, announcements, and important notices</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
                <i class="fas fa-plus me-2"></i>Add Event
            </button>
            <button class="btn btn-secondary" onclick="exportEvents()">
                <i class="fas fa-download me-2"></i>Export Calendar
            </button>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-primary">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stats-value"><?php echo count($data['events']); ?></div>
            <div class="stats-label">Total Events</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stats-value">
                <?php
                $published = array_filter($data['events'], fn($e) => $e['status'] === 'published');
                echo count($published);
                ?>
            </div>
            <div class="stats-label">Published</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stats-value">
                <?php
                $upcoming = array_filter($data['events'], fn($e) => $e['event_date'] >= date('Y-m-d') && $e['status'] !== 'cancelled');
                echo count($upcoming);
                ?>
            </div>
            <div class="stats-label">Upcoming</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-info">
                <i class="fas fa-bullhorn"></i>
            </div>
            <div class="stats-value">
                <?php
                $this_month = date('Y-m');
                $month_events = array_filter($data['events'], fn($e) => substr($e['event_date'], 0, 7) === $this_month);
                echo count($month_events);
                ?>
            </div>
            <div class="stats-label">This Month</div>
        </div>
    </div>
</div>

<!-- Calendar View -->
<div class="row mb-4">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar me-2"></i>Calendar View
                </h5>
            </div>
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-plus me-2"></i>Upcoming Events
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($upcoming)): ?>
                    <?php foreach ($upcoming as $event): ?>
                        <div class="event-item mb-3 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1"><?php echo htmlspecialchars($event['title']); ?></h6>
                                    <p class="mb-1 text-muted">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        <?php echo htmlspecialchars($event['venue'] ?? 'TBA'); ?>
                                    </p>
                                    <p class="mb-1 text-muted">
                                        <i class="fas fa-clock me-2"></i>
                                        <?php echo date('h:i A', strtotime($event['start_time'] ?? '00:00')); ?> -
                                        <?php echo date('h:i A', strtotime($event['end_time'] ?? '23:59')); ?>
                                    </p>
                                    <span class="badge bg-<?php echo getEventTypeBadge($event['event_type']); ?>">
                                        <?php echo ucfirst($event['event_type']); ?>
                                    </span>
                                </div>
                                <div class="text-end">
                                    <div class="event-date bg-primary text-white p-2 rounded text-center" style="min-width: 60px;">
                                        <div class="fw-bold"><?php echo date('d', strtotime($event['event_date'])); ?></div>
                                        <div class="small"><?php echo date('M', strtotime($event['event_date'])); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">No upcoming events scheduled.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Events Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>Events Management
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Event Title</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Venue</th>
                        <th>Audience</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['events'])): ?>
                        <?php foreach ($data['events'] as $event): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($event['image'])): ?>
                                            <img src="/backend/public/uploads/events/<?php echo htmlspecialchars($event['image']); ?>"
                                                 alt="Event" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        <?php endif; ?>
                                        <span><?php echo htmlspecialchars($event['title']); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo getEventTypeBadge($event['event_type']); ?>">
                                        <?php echo ucfirst($event['event_type']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($event['event_date'])); ?></td>
                                <td>
                                    <?php if ($event['start_time'] && $event['end_time']): ?>
                                        <?php echo date('h:i A', strtotime($event['start_time'])); ?> -
                                        <?php echo date('h:i A', strtotime($event['end_time'])); ?>
                                    <?php else: ?>
                                        <span class="text-muted">All Day</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($event['venue'] ?? 'TBA'); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo getAudienceBadge($event['target_audience']); ?>">
                                        <?php echo ucfirst($event['target_audience']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo getEventStatusBadge($event['status']); ?>">
                                        <?php echo ucfirst($event['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-primary" title="View Event"
                                                onclick="viewEvent(<?php echo $event['id']; ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" title="Edit Event"
                                                onclick="editEvent(<?php echo $event['id']; ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <?php if ($event['status'] === 'draft'): ?>
                                            <button type="button" class="btn btn-sm btn-success" title="Publish Event"
                                                    onclick="publishEvent(<?php echo $event['id']; ?>)">
                                                <i class="fas fa-upload"></i>
                                            </button>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-sm btn-danger" title="Delete Event"
                                                onclick="deleteEvent(<?php echo $event['id']; ?>, '<?php echo htmlspecialchars($event['title']); ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-calendar-times fa-2x text-muted mb-3"></i>
                                <p class="text-muted">No events found. Create your first event to get started.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Add New Event
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/admin/events/create" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Event Title *</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="event_type" class="form-label">Event Type *</label>
                                <select class="form-select" id="event_type" name="event_type" required>
                                    <option value="">Select Type</option>
                                    <option value="academic">Academic</option>
                                    <option value="cultural">Cultural</option>
                                    <option value="sports">Sports</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="event_date" class="form-label">Event Date *</label>
                                <input type="date" class="form-control" id="event_date" name="event_date" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" class="form-control" id="start_time" name="start_time">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" class="form-control" id="end_time" name="end_time">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="venue" class="form-label">Venue</label>
                                <input type="text" class="form-control" id="venue" name="venue"
                                       placeholder="e.g., School Auditorium, Playground">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="target_audience" class="form-label">Target Audience *</label>
                                <select class="form-select" id="target_audience" name="target_audience" required>
                                    <option value="">Select Audience</option>
                                    <option value="all">All</option>
                                    <option value="students">Students</option>
                                    <option value="teachers">Teachers</option>
                                    <option value="parents">Parents</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Event Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="form-text">Upload an image for the event (optional)</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_public" name="is_public" checked>
                                    <label class="form-check-label" for="is_public">
                                        Publish to public website
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="draft">Draft</option>
                                    <option value="published" selected>Published</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Add Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Event type badge helper function
    function getEventTypeBadge(type) {
        switch (type) {
            case 'academic': return 'primary';
            case 'cultural': return 'success';
            case 'sports': return 'warning';
            case 'other': return 'info';
            default: return 'secondary';
        }
    }

    // Event status badge helper function
    function getEventStatusBadge(status) {
        switch (status) {
            case 'published': return 'success';
            case 'draft': return 'warning';
            case 'cancelled': return 'danger';
            case 'completed': return 'info';
            default: return 'secondary';
        }
    }

    // Audience badge helper function
    function getAudienceBadge(audience) {
        switch (audience) {
            case 'all': return 'primary';
            case 'students': return 'info';
            case 'teachers': return 'success';
            case 'parents': return 'warning';
            default: return 'secondary';
        }
    }

    // View event details
    function viewEvent(id) {
        window.location.href = '/admin/events/view/' + id;
    }

    // Edit event
    function editEvent(id) {
        window.location.href = '/admin/events/edit/' + id;
    }

    // Publish event
    function publishEvent(id) {
        if (confirm('Are you sure you want to publish this event? It will be visible to the selected audience.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/events/' + id + '/publish';

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = '<?php echo htmlspecialchars($data['csrf_token']); ?>';

            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Delete event
    function deleteEvent(id, title) {
        if (confirm('Are you sure you want to delete event: ' + title + '? This action cannot be undone.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/events/delete/' + id;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = '<?php echo htmlspecialchars($data['csrf_token']); ?>';

            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Export events calendar
    function exportEvents() {
        window.location.href = '/admin/events/export-calendar';
    }

    // Initialize calendar (you can integrate with a calendar library like FullCalendar)
    document.addEventListener('DOMContentLoaded', function() {
        // Simple calendar placeholder - you can integrate FullCalendar or similar
        const calendarDiv = document.getElementById('calendar');
        calendarDiv.innerHTML = `
            <div class="text-center p-4">
                <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                <h5>Calendar Integration</h5>
                <p class="text-muted">Integrate with FullCalendar or similar library for full calendar functionality</p>
                <button class="btn btn-primary" onclick="showMonthView()">
                    <i class="fas fa-calendar me-2"></i>Show Month View
                </button>
            </div>
        `;
    });

    // Show month view (placeholder)
    function showMonthView() {
        const calendarDiv = document.getElementById('calendar');
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        // Simple month view (you can replace with a proper calendar library)
        calendarDiv.innerHTML = `
            <div class="text-center">
                <h6>${new Date(year, month).toLocaleDateString('en-US', { month: 'long', year: 'numeric' })}</h6>
                <div class="row">
                    <div class="col">Sun</div>
                    <div class="col">Mon</div>
                    <div class="col">Tue</div>
                    <div class="col">Wed</div>
                    <div class="col">Thu</div>
                    <div class="col">Fri</div>
                    <div class="col">Sat</div>
                </div>
                <!-- Calendar days would be generated here -->
                <p class="text-muted mt-3">Calendar view - integrate with calendar library for full functionality</p>
            </div>
        `;
    }

    // Auto-populate end time based on start time
    document.getElementById('start_time')?.addEventListener('change', function() {
        const startTime = this.value;
        const endTimeInput = document.getElementById('end_time');

        if (startTime && !endTimeInput.value) {
            // Add 2 hours to start time
            const [hours, minutes] = startTime.split(':');
            const endHours = (parseInt(hours) + 2) % 24;
            endTimeInput.value = String(endHours).padStart(2, '0') + ':' + minutes;
        }
    });

    // Set minimum end date based on start date
    document.getElementById('event_date')?.addEventListener('change', function() {
        // You can add validation logic here if needed
    });
</script>