<?php
namespace Models;

use Config\Database;

class SaleModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addSale($data) {
        $sql = "INSERT INTO sales (batch_id, sale_date, quantity, unit_price, total_amount, buyer_name, sale_type) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['batch_id'],
            $data['sale_date'],
            $data['quantity'],
            $data['unit_price'],
            $data['quantity'] * $data['unit_price'],
            $data['buyer_name'],
            $data['sale_type']
        ]);
    }

    public function getAllSales() {
        $sql = "SELECT s.*, b.name as batch_name 
                FROM sales s 
                LEFT JOIN batches b ON s.batch_id = b.id 
                ORDER BY s.sale_date DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getSalesStats($startDate = null, $endDate = null) {
        $sql = "SELECT 
                    DATE(sale_date) as date,
                    SUM(quantity) as total_quantity,
                    SUM(total_amount) as total_revenue,
                    sale_type
                FROM sales 
                WHERE 1=1";
        
        $params = [];
        if ($startDate) {
            $sql .= " AND sale_date >= ?";
            $params[] = $startDate;
        }
        if ($endDate) {
            $sql .= " AND sale_date <= ?";
            $params[] = $endDate;
        }
        
        $sql .= " GROUP BY DATE(sale_date), sale_type ORDER BY date DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getTotalRevenue() {
        $sql = "SELECT COALESCE(SUM(total_amount), 0) as total FROM sales";
        $stmt = $this->db->query($sql);
        return $stmt->fetch()['total'];
    }

    public function getSalesByBatch($batchId) {
        $sql = "SELECT * FROM sales WHERE batch_id = ? ORDER BY sale_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$batchId]);
        return $stmt->fetchAll();
    }

    public function getMonthlySales() {
        $sql = "SELECT 
                    DATE_FORMAT(sale_date, '%Y-%m') as month,
                    SUM(total_amount) as total
                FROM sales 
                GROUP BY DATE_FORMAT(sale_date, '%Y-%m')
                ORDER BY month DESC
                LIMIT 12";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
