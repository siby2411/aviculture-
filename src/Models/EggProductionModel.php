<?php
namespace Models;

use Config\Database;

class EggProductionModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addProduction($data) {
        $sql = "INSERT INTO egg_production (batch_id, record_date, eggs_collected, broken_eggs, saleable_eggs) 
                VALUES (?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                eggs_collected = VALUES(eggs_collected),
                broken_eggs = VALUES(broken_eggs),
                saleable_eggs = VALUES(saleable_eggs)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['batch_id'],
            $data['record_date'],
            $data['eggs_collected'],
            $data['broken_eggs'],
            $data['eggs_collected'] - $data['broken_eggs']
        ]);
    }

    public function getProductionByBatch($batchId) {
        $sql = "SELECT * FROM egg_production 
                WHERE batch_id = ? 
                ORDER BY record_date DESC 
                LIMIT 30";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$batchId]);
        return $stmt->fetchAll();
    }

    public function getTotalProduction() {
        $sql = "SELECT COALESCE(SUM(eggs_collected), 0) as total FROM egg_production";
        $stmt = $this->db->query($sql);
        return $stmt->fetch()['total'];
    }

    public function getProductionStats() {
        $sql = "SELECT 
                    DATE(record_date) as date,
                    SUM(eggs_collected) as total_eggs,
                    SUM(saleable_eggs) as saleable_eggs
                FROM egg_production 
                GROUP BY DATE(record_date)
                ORDER BY date DESC
                LIMIT 30";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
