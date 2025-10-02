<?php
/**
 * About Model
 * Handles about section content
 */

class About extends Model {
    public function __construct($db) {
        parent::__construct($db);
        $this->table = 'about';
    }

    public function getActive() {
        $this->db->query("SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY id DESC LIMIT 1");
        return $this->db->single();
    }
}