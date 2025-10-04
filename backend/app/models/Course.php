<?php
/**
 * Course Model
 * Handles course-related database operations
 */

class Course extends Model {
    public function __construct($db) {
        parent::__construct($db, 'courses');
    }

    /**
     * Get all active courses
     */
    public function getActive() {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE status = 'active' ORDER BY sort_order ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting active courses: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get course by ID
     */
    public function getById($id) {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting course by ID: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create new course
     */
    public function create($data) {
        try {
            $sql = "INSERT INTO " . $this->table . " (course_name, description, duration, eligibility, image, sort_order, status, created_at) VALUES (:course_name, :description, :duration, :eligibility, :image, :sort_order, :status, NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':course_name', $data['course_name']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':duration', $data['duration']);
            $stmt->bindParam(':eligibility', $data['eligibility']);
            $stmt->bindParam(':image', $data['image']);
            $stmt->bindParam(':sort_order', $data['sort_order']);
            $stmt->bindParam(':status', $data['status']);
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating course: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update course
     */
    public function update($id, $data) {
        try {
            $sql = "UPDATE " . $this->table . " SET course_name = :course_name, description = :description, duration = :duration, eligibility = :eligibility, image = :image, sort_order = :sort_order, status = :status, updated_at = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':course_name', $data['course_name']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':duration', $data['duration']);
            $stmt->bindParam(':eligibility', $data['eligibility']);
            $stmt->bindParam(':image', $data['image']);
            $stmt->bindParam(':sort_order', $data['sort_order']);
            $stmt->bindParam(':status', $data['status']);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error updating course: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete course
     */
    public function delete($id) {
        try {
            $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error deleting course: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all courses with pagination
     */
    public function getAll($limit = null, $offset = 0) {
        try {
            $sql = "SELECT * FROM " . $this->table . " ORDER BY sort_order ASC";
            if ($limit) {
                $sql .= " LIMIT :limit OFFSET :offset";
            }
            $stmt = $this->db->prepare($sql);
            if ($limit) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting all courses: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get total count of courses
     */
    public function getCount() {
        try {
            $sql = "SELECT COUNT(*) as count FROM " . $this->table;
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            error_log("Error getting course count: " . $e->getMessage());
            return 0;
        }
    }
}