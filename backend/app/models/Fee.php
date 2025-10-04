<?php
/**
 * Fee Model
 * Handles fee structure, payments, and financial records
 */

class Fee extends Model {
    public function __construct($db) {
        parent::__construct($db);
    }

    public function getFeeStructure() {
        $this->db->query("
            SELECT fs.*, c.class_name, c.section
            FROM fee_structure fs
            LEFT JOIN classes c ON fs.class_id = c.id
            WHERE fs.status = 'active'
            ORDER BY fs.fee_type, c.class_name
        ");
        return $this->db->resultSet();
    }

    public function getRecentPayments($limit = 10) {
        $this->db->query("
            SELECT fp.*, s.first_name, s.last_name, s.scholar_number,
                   CONCAT(u.first_name, ' ', u.last_name) as collected_by_name
            FROM fee_payments fp
            JOIN students s ON fp.student_id = s.id
            JOIN users u ON fp.collected_by = u.id
            ORDER BY fp.payment_date DESC, fp.created_at DESC
            LIMIT :limit
        ");
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getPendingFees() {
        $this->db->query("
            SELECT s.scholar_number, s.first_name, s.last_name,
                   c.class_name, c.section,
                   SUM(fs.amount) as total_fee,
                   COALESCE(SUM(fpd.amount_paid), 0) as total_paid,
                   (SUM(fs.amount) - COALESCE(SUM(fpd.amount_paid), 0)) as pending_amount
            FROM students s
            JOIN student_classes sc ON s.id = sc.student_id
            JOIN classes c ON sc.class_id = c.id
            JOIN fee_structure fs ON (fs.class_id = c.id OR fs.class_id IS NULL)
            LEFT JOIN fee_payment_details fpd ON fpd.fee_structure_id = fs.id
            LEFT JOIN fee_payments fp ON fpd.payment_id = fp.id AND fp.student_id = s.id
            WHERE sc.status = 'enrolled'
            AND fs.status = 'active'
            AND sc.academic_year = :academic_year
            GROUP BY s.id
            HAVING pending_amount > 0
            ORDER BY pending_amount DESC, s.first_name
        ");
        $this->db->bind(':academic_year', CURRENT_ACADEMIC_YEAR);
        return $this->db->resultSet();
    }

    public function getStudentFees($studentId) {
        $this->db->query("
            SELECT fs.*, c.class_name, c.section,
                   COALESCE(fpd.amount_paid, 0) as amount_paid,
                   (fs.amount - COALESCE(fpd.amount_paid, 0)) as pending_amount
            FROM fee_structure fs
            JOIN student_classes sc ON (fs.class_id = sc.class_id OR fs.class_id IS NULL)
            JOIN classes c ON sc.class_id = c.id
            LEFT JOIN fee_payment_details fpd ON fpd.fee_structure_id = fs.id
            LEFT JOIN fee_payments fp ON fpd.payment_id = fp.id AND fp.student_id = :student_id
            WHERE sc.student_id = :student_id
            AND sc.status = 'enrolled'
            AND fs.status = 'active'
            AND sc.academic_year = :academic_year
            ORDER BY fs.fee_type
        ");
        $this->db->bind(':student_id', $studentId);
        $this->db->bind(':academic_year', CURRENT_ACADEMIC_YEAR);
        return $this->db->resultSet();
    }

    public function recordPayment($paymentData, $paymentDetails) {
        // Start transaction
        $this->db->beginTransaction();
        try {
            // Insert payment record
            $this->db->query("INSERT INTO fee_payments SET
                student_id = :student_id,
                receipt_number = :receipt_number,
                payment_date = :payment_date,
                payment_mode = :payment_mode,
                transaction_id = :transaction_id,
                amount = :amount,
                discount = :discount,
                fine = :fine,
                remarks = :remarks,
                collected_by = :collected_by,
                fee_month = :fee_month,
                fee_year = :fee_year,
                created_at = :created_at
            ");

            $this->db->bind(':student_id', $paymentData['student_id']);
            $this->db->bind(':receipt_number', $paymentData['receipt_number']);
            $this->db->bind(':payment_date', $paymentData['payment_date']);
            $this->db->bind(':payment_mode', $paymentData['payment_mode']);
            $this->db->bind(':transaction_id', $paymentData['transaction_id']);
            $this->db->bind(':amount', $paymentData['amount']);
            $this->db->bind(':discount', $paymentData['discount']);
            $this->db->bind(':fine', $paymentData['fine']);
            $this->db->bind(':remarks', $paymentData['remarks']);
            $this->db->bind(':collected_by', $paymentData['collected_by']);
            $this->db->bind(':fee_month', $paymentData['fee_month']);
            $this->db->bind(':fee_year', $paymentData['fee_year']);
            $this->db->bind(':created_at', date('Y-m-d H:i:s'));

            $this->db->execute();
            $paymentId = $this->db->lastInsertId();

            // Insert payment details
            foreach ($paymentDetails as $detail) {
                $this->db->query("INSERT INTO fee_payment_details SET
                    payment_id = :payment_id,
                    fee_structure_id = :fee_structure_id,
                    amount_paid = :amount_paid,
                    created_at = :created_at
                ");

                $this->db->bind(':payment_id', $paymentId);
                $this->db->bind(':fee_structure_id', $detail['fee_structure_id']);
                $this->db->bind(':amount_paid', $detail['amount_paid']);
                $this->db->bind(':created_at', date('Y-m-d H:i:s'));

                $this->db->execute();
            }

            $this->db->endTransaction();
            return $paymentId;

        } catch (Exception $e) {
            $this->db->cancelTransaction();
            throw $e;
        }
    }

    public function getMonthlyCollection($year = null) {
        if (!$year) {
            $year = date('Y');
        }

        $this->db->query("
            SELECT
                strftime('%m', payment_date) as month,
                SUM(amount) as total_amount,
                COUNT(*) as payment_count
            FROM fee_payments
            WHERE strftime('%Y', payment_date) = :year
            GROUP BY strftime('%m', payment_date)
            ORDER BY month
        ");
        $this->db->bind(':year', $year);
        return $this->db->resultSet();
    }

    public function generateReceiptNumber() {
        $prefix = 'RCP';
        $date = date('Ymd');
        $random = strtoupper(substr(md5(uniqid()), 0, 4));

        return $prefix . $date . $random;
    }
}