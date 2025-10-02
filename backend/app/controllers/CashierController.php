<?php
/**
 * Cashier Controller
 * Handles cashier portal functionality
 */

class CashierController extends Controller {
    public function __construct($db, $auth) {
        parent::__construct($db, $auth);
        $this->auth->requireRole(['cashier']);
    }

    public function dashboard() {
        $cashierId = $this->auth->getUserId();

        // Get today's collection summary
        $todaySummary = $this->getTodayCollectionSummary();

        // Get recent transactions
        $recentTransactions = $this->getRecentTransactions();

        // Get pending fees summary
        $pendingSummary = $this->getPendingFeesSummary();

        // Get monthly collection trend
        $monthlyTrend = $this->getMonthlyCollectionTrend();

        $data = [
            'title' => 'Cashier Dashboard - ' . APP_NAME,
            'today_summary' => $todaySummary,
            'recent_transactions' => $recentTransactions,
            'pending_summary' => $pendingSummary,
            'monthly_trend' => $monthlyTrend,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('cashier/dashboard', $data);
    }

    public function fees() {
        $studentModel = $this->model('Student');

        $data = [
            'title' => 'Fee Collection - ' . APP_NAME,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('cashier/fees', $data);
    }

    public function reports() {
        $data = [
            'title' => 'Financial Reports - ' . APP_NAME,
            'csrf_token' => $this->security->generateCSRFToken()
        ];

        $this->view('cashier/reports', $data);
    }

    private function getTodayCollectionSummary() {
        $today = date('Y-m-d');

        $this->db->query("
            SELECT
                COUNT(*) as total_transactions,
                SUM(amount) as total_amount,
                SUM(CASE WHEN payment_mode = 'cash' THEN amount ELSE 0 END) as cash_amount,
                SUM(CASE WHEN payment_mode = 'online' THEN amount ELSE 0 END) as online_amount,
                SUM(CASE WHEN payment_mode = 'cheque' THEN amount ELSE 0 END) as cheque_amount
            FROM fee_payments
            WHERE DATE(payment_date) = :today
        ");
        $this->db->bind(':today', $today);

        return $this->db->single();
    }

    private function getRecentTransactions($limit = 10) {
        $this->db->query("
            SELECT fp.*, CONCAT(s.first_name, ' ', s.last_name) as student_name,
                   s.scholar_number, c.class_name, c.section
            FROM fee_payments fp
            JOIN students s ON fp.student_id = s.id
            LEFT JOIN classes c ON s.class_id = c.id
            ORDER BY fp.payment_date DESC, fp.created_at DESC
            LIMIT :limit
        ");
        $this->db->bind(':limit', $limit);

        return $this->db->resultSet();
    }

    private function getPendingFeesSummary() {
        $this->db->query("
            SELECT
                COUNT(DISTINCT fp.student_id) as students_with_pending,
                SUM(fp.amount) as total_pending_amount,
                COUNT(*) as total_pending_transactions
            FROM fee_payments fp
            WHERE fp.status = 'pending'
        ");

        return $this->db->single();
    }

    private function getMonthlyCollectionTrend() {
        $this->db->query("
            SELECT
                DATE_FORMAT(payment_date, '%Y-%m') as month,
                SUM(amount) as total_amount,
                COUNT(*) as transaction_count
            FROM fee_payments
            WHERE payment_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(payment_date, '%Y-%m')
            ORDER BY month DESC
        ");

        return $this->db->resultSet();
    }
}