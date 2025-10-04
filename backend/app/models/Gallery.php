<?php
/**
 * Gallery Model
 * Handles gallery images and media
 */

class Gallery extends Model {
    public function __construct($db) {
        parent::__construct($db);
        $this->table = 'gallery';
    }

    public function getActive() {
        $this->db->query("SELECT * FROM {$this->table} WHERE is_public = 1 ORDER BY sort_order ASC, created_at DESC");
        return $this->db->resultSet();
    }

    public function getAll() {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY sort_order ASC, created_at DESC");
        return $this->db->resultSet();
    }

    public function getByCategory($category) {
        $this->db->query("SELECT * FROM {$this->table} WHERE category = :category AND is_public = 1 ORDER BY sort_order ASC");
        $this->db->bind(':category', $category);
        return $this->db->resultSet();
    }

    public function createImage($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['is_public'] = 1;
        return $this->create($data);
    }

    public function updateImage($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->update($id, $data);
    }

    public function deleteImage($id) {
        // Delete associated image file if exists
        $image = $this->getById($id);
        if ($image && !empty($image['image_path'])) {
            $imagePath = UPLOADS_PATH . 'gallery/' . $image['image_path'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        return $this->delete($id);
    }

    public function updateSortOrder($images) {
        foreach ($images as $sortOrder => $id) {
            $this->db->query("UPDATE {$this->table} SET sort_order = :sort_order WHERE id = :id");
            $this->db->bind(':sort_order', $sortOrder + 1);
            $this->db->bind(':id', $id);
            $this->db->execute();
        }
        return true;
    }
}