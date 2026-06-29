<?php
namespace Models;

use Config\Database;

class ExpenseModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addExpense($data) {
        $sql = "INSERT INTO expenses (batch_id, expense_date, category, description, amount) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['batch_id'],
            $data['expense_date'],
            $data['category'],
            $data['description'],
            $data['amount']
        ]);
    }

    public function getAllExpenses() {
        $sql = "SELECT e.*, b.name as batch_name 
                FROM expenses e 
                LEFT JOIN batches b ON e.batch_id = b.id 
                ORDER BY e.expense_date DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getTotalExpenses() {
        $sql = "SELECT COALESCE(SUM(amount), 0) as total FROM expenses";
        $stmt = $this->db->query($sql);
        return $stmt->fetch()['total'];
    }

    public function getExpensesByBatch($batchId) {
        $sql = "SELECT * FROM expenses WHERE batch_id = ? ORDER BY expense_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$batchId]);
        return $stmt->fetchAll();
    }

    public function getExpensesByCategory() {
        $sql = "SELECT category, SUM(amount) as total FROM expenses GROUP BY category";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
