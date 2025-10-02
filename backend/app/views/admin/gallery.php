<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-title">
                <i class="fas fa-images me-2"></i>Gallery Management
            </h1>
            <p class="page-subtitle">Upload, organize, and manage school photos and videos</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="fas fa-upload me-2"></i>Upload Media
            </button>
            <button class="btn btn-secondary" onclick="createAlbum()">
                <i class="fas fa-folder-plus me-2"></i>Create Album
            </button>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-primary">
                <i class="fas fa-images"></i>
            </div>
            <div class="stats-value"><?php echo count($data['gallery']); ?></div>
            <div class="stats-label">Total Media</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-success">
                <i class="fas fa-eye"></i>
            </div>
            <div class="stats-value">
                <?php
                $public = array_filter($data['gallery'], fn($g) => $g['is_public'] == 1);
                echo count($public);
                ?>
            </div>
            <div class="stats-label">Public Media</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-info">
                <i class="fas fa-folder"></i>
            </div>
            <div class="stats-value">
                <?php
                $categories = array_unique(array_column($data['gallery'], 'category'));
                echo count($categories);
                ?>
            </div>
            <div class="stats-label">Categories</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stats-card">
            <div class="stats-icon bg-warning">
                <i class="fas fa-upload"></i>
            </div>
            <div class="stats-value">
                <?php
                $this_month = date('Y-m');
                $month_uploads = array_filter($data['gallery'], fn($g) => substr($g['created_at'], 0, 7) === $this_month);
                echo count($month_uploads);
                ?>
            </div>
            <div class="stats-label">This Month</div>
        </div>
    </div>
</div>

<!-- Gallery Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <select class="form-select" name="category">
                    <option value="">All Categories</option>
                    <option value="sports" <?php echo ($_GET['category'] ?? '') == 'sports' ? 'selected' : ''; ?>>Sports</option>
                    <option value="cultural" <?php echo ($_GET['category'] ?? '') == 'cultural' ? 'selected' : ''; ?>>Cultural</option>
                    <option value="academic" <?php echo ($_GET['category'] ?? '') == 'academic' ? 'selected' : ''; ?>>Academic</option>
                    <option value="infrastructure" <?php echo ($_GET['category'] ?? '') == 'infrastructure' ? 'selected' : ''; ?>>Infrastructure</option>
                    <option value="events" <?php echo ($_GET['category'] ?? '') == 'events' ? 'selected' : ''; ?>>Events</option>
                    <option value="other" <?php echo ($_GET['category'] ?? '') == 'other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="visibility">
                    <option value="">All Media</option>
                    <option value="public" <?php echo ($_GET['visibility'] ?? '') == 'public' ? 'selected' : ''; ?>>Public</option>
                    <option value="private" <?php echo ($_GET['visibility'] ?? '') == 'private' ? 'selected' : ''; ?>>Private</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="search" placeholder="Search media..." value="<?php echo $_GET['search'] ?? ''; ?>">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="sort">
                    <option value="newest" <?php echo ($_GET['sort'] ?? '') == 'newest' ? 'selected' : ''; ?>>Newest First</option>
                    <option value="oldest" <?php echo ($_GET['sort'] ?? '') == 'oldest' ? 'selected' : ''; ?>>Oldest First</option>
                    <option value="title" <?php echo ($_GET['sort'] ?? '') == 'title' ? 'selected' : ''; ?>>By Title</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-2"></i>Filter
                </button>
                <a href="/admin/gallery" class="btn btn-secondary">
                    <i class="fas fa-redo me-2"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Gallery Grid -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-th me-2"></i>Media Gallery
        </h5>
    </div>
    <div class="card-body">
        <?php if (!empty($data['gallery'])): ?>
            <div class="row" id="galleryGrid">
                <?php foreach ($data['gallery'] as $item): ?>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-4 gallery-item" data-id="<?php echo $item['id']; ?>">
                        <div class="card h-100">
                            <div class="position-relative">
                                <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $item['image_path'])): ?>
                                    <img src="/backend/public/uploads/gallery/<?php echo htmlspecialchars($item['image_path']); ?>"
                                         alt="<?php echo htmlspecialchars($item['title']); ?>"
                                         class="card-img-top gallery-image"
                                         style="height: 200px; object-fit: cover; cursor: pointer;"
                                         onclick="openLightbox('<?php echo htmlspecialchars($item['image_path']); ?>')">
                                <?php else: ?>
                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                                         style="height: 200px;">
                                        <i class="fas fa-video fa-3x text-muted"></i>
                                    </div>
                                <?php endif; ?>

                                <!-- Overlay with actions -->
                                <div class="gallery-overlay">
                                    <div class="gallery-actions">
                                        <button class="btn btn-sm btn-light" title="Edit" onclick="editMedia(<?php echo $item['id']; ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info" title="Download" onclick="downloadMedia('<?php echo htmlspecialchars($item['image_path']); ?>')">
                                            <i class="fas fa-download"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" title="Delete" onclick="deleteMedia(<?php echo $item['id']; ?>, '<?php echo htmlspecialchars($item['title']); ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Visibility badge -->
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-<?php echo $item['is_public'] ? 'success' : 'secondary'; ?>">
                                        <i class="fas fa-<?php echo $item['is_public'] ? 'eye' : 'eye-slash'; ?>"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="card-body">
                                <h6 class="card-title mb-1"><?php echo htmlspecialchars($item['title']); ?></h6>
                                <p class="card-text small text-muted mb-2">
                                    <?php echo htmlspecialchars(substr($item['description'] ?? '', 0, 60)); ?>
                                    <?php if (strlen($item['description'] ?? '') > 60): ?>...<?php endif; ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-<?php echo getCategoryBadge($item['category']); ?>">
                                        <?php echo ucfirst($item['category']); ?>
                                    </span>
                                    <small class="text-muted">
                                        <?php echo date('M d, Y', strtotime($item['created_at'])); ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Load More Button (if pagination needed) -->
            <div class="text-center mt-4">
                <button class="btn btn-outline-primary" onclick="loadMore()">
                    <i class="fas fa-plus me-2"></i>Load More
                </button>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                <h5>No Media Found</h5>
                <p class="text-muted">Upload your first media files to get started with the gallery.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Upload Media Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-upload me-2"></i>Upload Media
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/admin/gallery/upload" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($data['csrf_token']); ?>">

                    <div class="mb-3">
                        <label for="media_files" class="form-label">Select Files *</label>
                        <input type="file" class="form-control" id="media_files" name="media_files[]"
                               accept="image/*,video/*" multiple required>
                        <div class="form-text">You can select multiple images and videos (Max 5MB each)</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category *</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="sports">Sports</option>
                                    <option value="cultural">Cultural</option>
                                    <option value="academic">Academic</option>
                                    <option value="infrastructure">Infrastructure</option>
                                    <option value="events">Events</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="album_id" class="form-label">Album (Optional)</label>
                                <select class="form-select" id="album_id" name="album_id">
                                    <option value="">No Album</option>
                                    <!-- Albums would be loaded here -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title *</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                        <div class="form-text">This will be used as title for all uploaded files</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_public" name="is_public" checked>
                                    <label class="form-check-label" for="is_public">
                                        Make visible on public website
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order"
                                       min="0" value="0">
                            </div>
                        </div>
                    </div>

                    <!-- Upload Preview -->
                    <div id="uploadPreview" class="mb-3" style="display: none;">
                        <h6>Upload Preview</h6>
                        <div id="previewContainer" class="row"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i>Upload Files
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Lightbox Modal -->
<div class="modal fade" id="lightboxModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">
                <img id="lightboxImage" src="" alt="" class="w-100">
            </div>
            <div class="modal-footer justify-content-between">
                <small class="text-muted" id="lightboxCaption"></small>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Category badge helper function
    function getCategoryBadge(category) {
        switch (category) {
            case 'sports': return 'success';
            case 'cultural': return 'warning';
            case 'academic': return 'primary';
            case 'infrastructure': return 'info';
            case 'events': return 'danger';
            case 'other': return 'secondary';
            default: return 'secondary';
        }
    }

    // Edit media
    function editMedia(id) {
        window.location.href = '/admin/gallery/edit/' + id;
    }

    // Delete media
    function deleteMedia(id, title) {
        if (confirm('Are you sure you want to delete: ' + title + '?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/gallery/delete/' + id;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = '<?php echo htmlspecialchars($data['csrf_token']); ?>';

            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Download media
    function downloadMedia(filename) {
        window.open('/backend/public/uploads/gallery/' + filename, '_blank');
    }

    // Open lightbox
    function openLightbox(imagePath) {
        document.getElementById('lightboxImage').src = '/backend/public/uploads/gallery/' + imagePath;
        document.getElementById('lightboxCaption').textContent = 'Gallery Image';
        new bootstrap.Modal(document.getElementById('lightboxModal')).show();
    }

    // Create album
    function createAlbum() {
        window.location.href = '/admin/gallery/create-album';
    }

    // Load more gallery items (pagination)
    function loadMore() {
        // Implement pagination logic here
        alert('Load more functionality - implement pagination');
    }

    // File upload preview
    document.getElementById('media_files')?.addEventListener('change', function(e) {
        const previewContainer = document.getElementById('previewContainer');
        const uploadPreview = document.getElementById('uploadPreview');

        if (this.files.length > 0) {
            uploadPreview.style.display = 'block';
            previewContainer.innerHTML = '';

            Array.from(this.files).forEach((file, index) => {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'col-md-3 mb-3';

                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.className = 'img-fluid rounded';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    previewDiv.appendChild(img);
                } else {
                    previewDiv.innerHTML = `
                        <div class="d-flex align-items-center justify-content-center bg-light rounded" style="height: 100px;">
                            <i class="fas fa-video fa-2x text-muted"></i>
                        </div>
                    `;
                }

                previewDiv.innerHTML += `<small class="d-block text-center mt-1">${file.name}</small>`;
                previewContainer.appendChild(previewDiv);
            });
        } else {
            uploadPreview.style.display = 'none';
        }
    });

    // Gallery item hover effects
    document.querySelectorAll('.gallery-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.querySelector('.gallery-overlay').style.opacity = '1';
        });

        item.addEventListener('mouseleave', function() {
            this.querySelector('.gallery-overlay').style.opacity = '0';
        });
    });

    // Auto-submit filter form on change
    document.querySelectorAll('select[name="category"], select[name="visibility"], select[name="sort"]').forEach(element => {
        element.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });

    // Search with debounce
    let searchTimeout;
    document.querySelector('input[name="search"]')?.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (this.value.length >= 3 || this.value.length === 0) {
                this.closest('form').submit();
            }
        }, 500);
    });
</script>

<style>
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-actions {
        display: flex;
        gap: 0.5rem;
    }

    .gallery-image {
        transition: transform 0.3s ease;
    }

    .gallery-item:hover .gallery-image {
        transform: scale(1.05);
    }
</style>