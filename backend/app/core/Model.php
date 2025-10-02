<?php
/**
 * Base Model Class
 * All models should extend this class
 */

class Model {
    protected $db;
    protected $table;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $this->db->query("SELECT * FROM {$this->table}");
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function create($data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

        $this->db->query($sql);
        foreach ($data as $key => $value) {
            $this->db->bind(':' . $key, $value);
        }

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function update($id, $data) {
        $setParts = [];
        foreach ($data as $key => $value) {
            $setParts[] = "{$key} = :{$key}";
        }
        $setString = implode(', ', $setParts);

        $sql = "UPDATE {$this->table} SET {$setString} WHERE id = :id";

        $this->db->query($sql);
        $this->db->bind(':id', $id);
        foreach ($data as $key => $value) {
            $this->db->bind(':' . $key, $value);
        }

        return $this->db->execute();
    }

    public function delete($id) {
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function findBy($conditions) {
        $whereParts = [];
        foreach ($conditions as $key => $value) {
            $whereParts[] = "{$key} = :{$key}";
        }
        $whereString = implode(' AND ', $whereParts);

        $sql = "SELECT * FROM {$this->table} WHERE {$whereString}";

        $this->db->query($sql);
        foreach ($conditions as $key => $value) {
            $this->db->bind(':' . $key, $value);
        }

        return $this->db->resultSet();
    }

    public function query($sql, $params = []) {
        $this->db->query($sql);
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }
        return $this->db->resultSet();
    }
}