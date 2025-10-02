<?php
/**
 * User Model
 * Handles user-related database operations
 */

class User extends Model {
    public function __construct($db) {
        parent::__construct($db);
        $this->table = 'users';
    }

    public function findByUsername($username) {
        $this->db->query("SELECT * FROM {$this->table} WHERE username = :username");
        $this->db->bind(':username', $username);
        return $this->db->single();
    }

    public function findByEmail($email) {
        $this->db->query("SELECT * FROM {$this->table} WHERE email = :email");
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    public function createUser($data) {
        $data['password'] = $this->auth->hashPassword($data['password']);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['status'] = 'active';

        return $this->create($data);
    }

    public function updateUser($id, $data) {
        if (isset($data['password'])) {
            $data['password'] = $this->auth->hashPassword($data['password']);
        }
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->update($id, $data);
    }

    public function getUsersByRole($role) {
        $this->db->query("SELECT * FROM {$this->table} WHERE role = :role AND status = 'active' ORDER BY first_name, last_name");
        $this->db->bind(':role', $role);
        return $this->db->resultSet();
    }

    public function savePasswordResetToken($userId, $token, $expiry) {
        $this->db->query("UPDATE {$this->table} SET reset_token = :token, reset_expiry = :expiry WHERE id = :id");
        $this->db->bind(':token', $token);
        $this->db->bind(':expiry', $expiry);
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }

    public function verifyResetToken($token) {
        $this->db->query("SELECT * FROM {$this->table} WHERE reset_token = :token AND reset_expiry > NOW() AND status = 'active'");
        $this->db->bind(':token', $token);
        return $this->db->single();
    }

    public function clearResetToken($userId) {
        $this->db->query("UPDATE {$this->table} SET reset_token = NULL, reset_expiry = NULL WHERE id = :id");
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }

    public function updateLastLogin($userId) {
        $this->db->query("UPDATE {$this->table} SET last_login = NOW() WHERE id = :id");
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }

    public function getUserPermissions($userId) {
        $this->db->query("SELECT r.permissions FROM {$this->table} u JOIN roles r ON u.role = r.role_name WHERE u.id = :id");
        $this->db->bind(':id', $userId);
        $result = $this->db->single();

        return $result ? json_decode($result['permissions'], true) : [];
    }

    public function getActiveUsers() {
        $this->db->query("SELECT id, CONCAT(first_name, ' ', last_name) as name, username, email, role FROM {$this->table} WHERE status = 'active' ORDER BY first_name, last_name");
        return $this->db->resultSet();
    }

    public function deactivateUser($id) {
        return $this->update($id, ['status' => 'inactive', 'updated_at' => date('Y-m-d H:i:s')]);
    }

    public function activateUser($id) {
        return $this->update($id, ['status' => 'active', 'updated_at' => date('Y-m-d H:i:s')]);
    }
}