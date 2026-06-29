<?php
namespace Models;

use Config\Database;

class BatchModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createBatch($data) {
        $sql = "INSERT INTO batches (building_id, name, start_date, initial_quantity, current_quantity) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['building_id'],
            $data['name'],
            $data['start_date'],
            $data['initial_quantity'],
            $data['initial_quantity']
        ]);
    }

    public function getBatchById($id) {
        $sql = "SELECT b.*, u.name as building_name 
                FROM batches b 
                LEFT JOIN buildings u ON b.building_id = u.id 
                WHERE b.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getBatchStats($batchId) {
        $sql = "SELECT 
                    b.*,
                    COALESCE(SUM(dr.feed_consumed), 0) as total_feed,
                    COALESCE(SUM(dr.water_consumed), 0) as total_water,
                    COALESCE(SUM(dr.mortality), 0) as total_mortality,
                    COALESCE(SUM(dr.eggs_collected), 0) as total_eggs,
                    COALESCE(AVG(dr.average_weight), 0) as avg_weight,
                    DATEDIFF(CURDATE(), b.start_date) as age_days
                FROM batches b
                LEFT JOIN daily_records dr ON b.id = dr.batch_id
                WHERE b.id = ?
                GROUP BY b.id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$batchId]);
        return $stmt->fetch();
    }

    public function calculateProductionCost($batchId) {
        $stats = $this->getBatchStats($batchId);
        
        // Coûts variables
        $feedCost = $stats['total_feed'] * 0.45; // Prix moyen aliment
        $veterinaryCost = $this->getVeterinaryCost($batchId);
        $waterCost = $stats['total_water'] * 0.002;
        $otherExpenses = $this->getOtherExpenses($batchId);
        
        // Coûts fixes (amortissement, main d'œuvre, etc.)
        $fixedCost = $this->getFixedCosts($batchId);
        
        $totalCost = $feedCost + $veterinaryCost + $waterCost + $otherExpenses + $fixedCost;
        $survivingBirds = $stats['current_quantity'];
        $initialBirds = $stats['initial_quantity'];
        
        return [
            'total_cost' => $totalCost,
            'cost_per_bird' => $survivingBirds > 0 ? $totalCost / $survivingBirds : 0,
            'feed_cost' => $feedCost,
            'veterinary_cost' => $veterinaryCost,
            'water_cost' => $waterCost,
            'other_expenses' => $otherExpenses,
            'fixed_costs' => $fixedCost,
            'total_mortality' => $stats['total_mortality'],
            'total_eggs' => $stats['total_eggs'],
            'avg_weight' => $stats['avg_weight'],
            'mortality_rate' => $initialBirds > 0 ? ($stats['total_mortality'] / $initialBirds) * 100 : 0,
            'survival_rate' => $initialBirds > 0 ? (($initialBirds - $stats['total_mortality']) / $initialBirds) * 100 : 0
        ];
    }

    private function getVeterinaryCost($batchId) {
        $sql = "SELECT COALESCE(SUM(cost), 0) as total FROM treatments WHERE batch_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$batchId]);
        return $stmt->fetch()['total'];
    }

    private function getOtherExpenses($batchId) {
        $sql = "SELECT COALESCE(SUM(amount), 0) as total FROM expenses WHERE batch_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$batchId]);
        return $stmt->fetch()['total'];
    }

    private function getFixedCosts($batchId) {
        // Coûts fixes estimés (amortissement, électricité, main d'œuvre)
        $sql = "SELECT DATEDIFF(CURDATE(), start_date) as days FROM batches WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$batchId]);
        $days = $stmt->fetch()['days'] ?? 0;
        
        // Estimation: 50 FCFA par jour par poulet
        return $days * 50;
    }

    public function getAllBatches() {
        $sql = "SELECT b.*, u.name as building_name 
                FROM batches b 
                LEFT JOIN buildings u ON b.building_id = u.id 
                ORDER BY b.start_date DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getDailyRecords($batchId) {
        $sql = "SELECT * FROM daily_records 
                WHERE batch_id = ? 
                ORDER BY record_date DESC 
                LIMIT 30";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$batchId]);
        return $stmt->fetchAll();
    }

    public function updateDailyRecord($data) {
        $sql = "INSERT INTO daily_records 
                (batch_id, record_date, feed_consumed, water_consumed, mortality, eggs_collected, average_weight, notes) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                feed_consumed = VALUES(feed_consumed),
                water_consumed = VALUES(water_consumed),
                mortality = VALUES(mortality),
                eggs_collected = VALUES(eggs_collected),
                average_weight = VALUES(average_weight),
                notes = VALUES(notes)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['batch_id'],
            $data['record_date'],
            $data['feed_consumed'],
            $data['water_consumed'],
            $data['mortality'],
            $data['eggs_collected'],
            $data['average_weight'],
            $data['notes']
        ]);
    }

    public function updateBatch($id, $data) {
        $sql = "UPDATE batches SET 
                name = ?,
                current_quantity = ?,
                average_weight = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['current_quantity'],
            $data['average_weight'],
            $id
        ]);
    }
}
