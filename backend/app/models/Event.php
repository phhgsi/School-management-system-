<?php
/**
 * Event Model
 * Handles event-related database operations
 */

class Event extends Model {
    public function __construct($db) {
        parent::__construct($db);
        $this->table = 'events';
    }

    /**
     * Get upcoming events
     */
    public function getUpcoming($limit = null) {
        try {
            $today = date('Y-m-d');
            $sql = "SELECT * FROM " . $this->table . " WHERE event_date >= :today AND status = 'published' ORDER BY event_date ASC, start_time ASC";
            if ($limit) {
                $sql .= " LIMIT :limit";
            }
            $this->db->query($sql);
            $this->db->bind(':today', $today);
            if ($limit) {
                $this->db->bind(':limit', $limit);
            }
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error getting upcoming events: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get events by date range
     */
    public function getByDateRange($start_date, $end_date) {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE event_date BETWEEN :start_date AND :end_date AND status = 'published' ORDER BY event_date ASC, start_time ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date', $end_date);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting events by date range: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get event by ID
     */
    public function getById($id) {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting event by ID: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create new event
     */
    public function create($data) {
        try {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['is_public'] = $data['is_public'] ?? 1;
            return $this->create($data);
        } catch (Exception $e) {
            error_log("Error creating event: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update event
     */
    public function update($id, $data) {
        try {
            $data['updated_at'] = date('Y-m-d H:i:s');
            return parent::update($id, $data);
        } catch (Exception $e) {
            error_log("Error updating event: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete event
     */
    public function delete($id) {
        try {
            $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error deleting event: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all events with pagination
     */
    public function getAll($limit = null, $offset = 0) {
        try {
            $sql = "SELECT e.*, u.first_name, u.last_name FROM " . $this->table . " e LEFT JOIN users u ON e.created_by = u.id ORDER BY e.event_date DESC, e.start_time DESC";
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
            error_log("Error getting all events: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get events by type
     */
    public function getByType($type) {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE event_type = :event_type AND status = 'published' ORDER BY event_date ASC, start_time ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':event_type', $type);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting events by type: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get events for specific audience
     */
    public function getForAudience($audience) {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE target_audience = :audience AND status = 'published' ORDER BY event_date ASC, start_time ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':audience', $audience);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting events for audience: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get total count of events
     */
    public function getCount() {
        try {
            $sql = "SELECT COUNT(*) as count FROM " . $this->table;
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            error_log("Error getting event count: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get events for current month
     */
    public function getCurrentMonth() {
        try {
            $currentMonth = date('m');
            $currentYear = date('Y');
            $sql = "SELECT * FROM " . $this->table . " WHERE strftime('%m', event_date) = :month AND strftime('%Y', event_date) = :year AND status = 'published' ORDER BY event_date ASC, start_time ASC";
            $this->db->query($sql);
            $this->db->bind(':month', $currentMonth);
            $this->db->bind(':year', $currentYear);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error getting current month events: " . $e->getMessage());
            return [];
        }
    }
}