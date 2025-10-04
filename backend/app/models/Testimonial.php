<?php
/**
 * Testimonial Model
 * Handles testimonials/reviews
 */

class Testimonial extends Model {
    public function __construct($db) {
        parent::__construct($db);
        $this->table = 'testimonials';
    }

    public function getActive() {
        $this->db->query("SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY sort_order ASC, created_at DESC");
        return $this->db->resultSet();
    }

    public function getAll() {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY sort_order ASC, created_at DESC");
        return $this->db->resultSet();
    }

    public function createTestimonial($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['status'] = 'active';
        return $this->create($data);
    }

    public function updateTestimonial($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->update($id, $data);
    }

    public function deleteTestimonial($id) {
        return $this->delete($id);
    }

    public function updateSortOrder($testimonials) {
        foreach ($testimonials as $sortOrder => $id) {
            $this->db->query("UPDATE {$this->table} SET sort_order = :sort_order WHERE id = :id");
            $this->db->bind(':sort_order', $sortOrder + 1);
            $this->db->bind(':id', $id);
            $this->db->execute();
        }
        return true;
    }
}