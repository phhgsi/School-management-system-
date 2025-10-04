<?php
/**
 * Setting Model
 * Handles system settings and configuration
 */

class Setting extends Model {
    public function __construct($db) {
        parent::__construct($db);
        $this->table = 'settings';
    }

    public function getAll() {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY setting_group, setting_key");
        return $this->db->resultSet();
    }

    public function getByKey($key) {
        $this->db->query("SELECT * FROM {$this->table} WHERE setting_key = :key");
        $this->db->bind(':key', $key);
        $result = $this->db->single();

        if ($result && $result['is_serialized']) {
            return unserialize($result['setting_value']);
        }

        return $result ? $result['setting_value'] : null;
    }

    public function getByGroup($group) {
        $this->db->query("SELECT * FROM {$this->table} WHERE setting_group = :group ORDER BY setting_key");
        $this->db->bind(':group', $group);
        return $this->db->resultSet();
    }

    public function setSetting($key, $value, $group = 'general', $isSerialized = false) {
        $existing = $this->getByKey($key);

        if ($existing !== null) {
            // Update existing setting
            $this->db->query("UPDATE {$this->table} SET
                setting_value = :value,
                setting_group = :group,
                is_serialized = :is_serialized,
                updated_at = :updated_at
                WHERE setting_key = :key
            ");

            $this->db->bind(':key', $key);
            $this->db->bind(':value', $isSerialized ? serialize($value) : $value);
            $this->db->bind(':group', $group);
            $this->db->bind(':is_serialized', $isSerialized ? 1 : 0);
            $this->db->bind(':updated_at', date('Y-m-d H:i:s'));

            return $this->db->execute();
        } else {
            // Create new setting
            $this->db->query("INSERT INTO {$this->table} SET
                setting_key = :key,
                setting_value = :value,
                setting_group = :group,
                is_serialized = :is_serialized,
                created_at = :created_at,
                updated_at = :updated_at
            ");

            $this->db->bind(':key', $key);
            $this->db->bind(':value', $isSerialized ? serialize($value) : $value);
            $this->db->bind(':group', $group);
            $this->db->bind(':is_serialized', $isSerialized ? 1 : 0);
            $this->db->bind(':created_at', date('Y-m-d H:i:s'));
            $this->db->bind(':updated_at', date('Y-m-d H:i:s'));

            return $this->db->execute();
        }
    }

    public function deleteSetting($key) {
        $this->db->query("DELETE FROM {$this->table} WHERE setting_key = :key");
        $this->db->bind(':key', $key);
        return $this->db->execute();
    }

    public function getSchoolInfo() {
        return [
            'school_name' => $this->getByKey('school_name') ?: SCHOOL_NAME,
            'school_address' => $this->getByKey('school_address') ?: SCHOOL_ADDRESS,
            'school_phone' => $this->getByKey('school_phone') ?: SCHOOL_PHONE,
            'school_email' => $this->getByKey('school_email') ?: SCHOOL_EMAIL,
            'school_website' => $this->getByKey('school_website') ?: SCHOOL_WEBSITE,
            'academic_year' => $this->getByKey('academic_year') ?: CURRENT_ACADEMIC_YEAR,
            'currency_symbol' => $this->getByKey('currency_symbol') ?: CURRENCY_SYMBOL,
            'timezone' => $this->getByKey('timezone') ?: APP_TIMEZONE
        ];
    }

    public function updateSchoolInfo($data) {
        $settings = [
            'school_name' => $data['school_name'] ?? SCHOOL_NAME,
            'school_address' => $data['school_address'] ?? SCHOOL_ADDRESS,
            'school_phone' => $data['school_phone'] ?? SCHOOL_PHONE,
            'school_email' => $data['school_email'] ?? SCHOOL_EMAIL,
            'school_website' => $data['school_website'] ?? SCHOOL_WEBSITE,
            'academic_year' => $data['academic_year'] ?? CURRENT_ACADEMIC_YEAR,
            'currency_symbol' => $data['currency_symbol'] ?? CURRENCY_SYMBOL,
            'timezone' => $data['timezone'] ?? APP_TIMEZONE
        ];

        foreach ($settings as $key => $value) {
            $this->setSetting($key, $value, 'general');
        }

        return true;
    }

    public function getSystemSettings() {
        return [
            'app_name' => APP_NAME,
            'app_version' => APP_VERSION,
            'app_debug' => APP_DEBUG,
            'session_lifetime' => SESSION_LIFETIME,
            'upload_max_size' => UPLOAD_MAX_SIZE,
            'per_page' => PER_PAGE,
            'date_format' => DISPLAY_DATE_FORMAT,
            'currency_symbol' => $this->getByKey('currency_symbol') ?: CURRENCY_SYMBOL,
            'timezone' => $this->getByKey('timezone') ?: APP_TIMEZONE
        ];
    }

    public function getEmailSettings() {
        return [
            'mail_mailer' => MAIL_MAILER,
            'mail_host' => MAIL_HOST,
            'mail_port' => MAIL_PORT,
            'mail_username' => MAIL_USERNAME,
            'mail_password' => MAIL_PASSWORD,
            'mail_encryption' => MAIL_ENCRYPTION,
            'mail_from_address' => MAIL_FROM_ADDRESS,
            'mail_from_name' => MAIL_FROM_NAME
        ];
    }

    public function getPaymentSettings() {
        return [
            'razorpay_key' => RAZORPAY_KEY,
            'razorpay_secret' => RAZORPAY_SECRET,
            'paypal_client_id' => PAYPAL_CLIENT_ID,
            'paypal_client_secret' => PAYPAL_CLIENT_SECRET
        ];
    }

    public function getFeatureFlags() {
        return [
            'enable_notifications' => ENABLE_NOTIFICATIONS,
            'enable_sms' => ENABLE_SMS,
            'enable_email' => ENABLE_EMAIL,
            'enable_backup' => ENABLE_BACKUP,
            'enable_audit_log' => ENABLE_AUDIT_LOG,
            'enable_two_factor' => ENABLE_TWO_FACTOR
        ];
    }
}