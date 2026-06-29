<?php
namespace Models;

use Config\Database;

class HealthMonitoringModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addHealthCheck($data) {
        $sql = "INSERT INTO health_monitoring 
                (batch_id, check_date, temperature_avg, humidity_avg, ammonia_level, 
                 co2_level, feed_intake, water_intake, mortality_count, 
                 sick_birds, injured_birds, treatment_given, observations) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['batch_id'],
            $data['check_date'],
            $data['temperature_avg'] ?? null,
            $data['humidity_avg'] ?? null,
            $data['ammonia_level'] ?? null,
            $data['co2_level'] ?? null,
            $data['feed_intake'] ?? null,
            $data['water_intake'] ?? null,
            $data['mortality_count'] ?? 0,
            $data['sick_birds'] ?? 0,
            $data['injured_birds'] ?? 0,
            $data['treatment_given'] ?? null,
            $data['observations'] ?? null
        ]);
    }

    public function getHealthStatus($batchId) {
        $sql = "SELECT * FROM health_monitoring 
                WHERE batch_id = ? 
                ORDER BY check_date DESC 
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$batchId]);
        return $stmt->fetch();
    }

    public function getHealthHistory($batchId, $days = 30) {
        $sql = "SELECT * FROM health_monitoring 
                WHERE batch_id = ? 
                AND check_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                ORDER BY check_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$batchId, $days]);
        return $stmt->fetchAll();
    }

    public function addPreventiveTreatment($data) {
        $sql = "INSERT INTO preventive_treatments 
                (batch_id, treatment_date, treatment_type, product_name, 
                 dosage, administration_method, cost, next_due_date, notes) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['batch_id'],
            $data['treatment_date'],
            $data['treatment_type'],
            $data['product_name'],
            $data['dosage'],
            $data['administration_method'],
            $data['cost'],
            $data['next_due_date'],
            $data['notes'] ?? null
        ]);
    }

    public function getTreatments($batchId) {
        $sql = "SELECT * FROM preventive_treatments 
                WHERE batch_id = ? 
                ORDER BY treatment_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$batchId]);
        return $stmt->fetchAll();
    }

    public function addWeightRecord($data) {
        $sql = "INSERT INTO weight_monitoring 
                (batch_id, weigh_date, sample_size, avg_weight, 
                 min_weight, max_weight, weight_gain, feed_conversion_ratio) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['batch_id'],
            $data['weigh_date'],
            $data['sample_size'] ?? 10,
            $data['avg_weight'],
            $data['min_weight'] ?? null,
            $data['max_weight'] ?? null,
            $data['weight_gain'] ?? null,
            $data['feed_conversion_ratio'] ?? null
        ]);
    }

    public function getWeightHistory($batchId, $limit = 10) {
        $sql = "SELECT * FROM weight_monitoring 
                WHERE batch_id = ? 
                ORDER BY weigh_date DESC 
                LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$batchId, $limit]);
        return $stmt->fetchAll();
    }

    public function getBatchAlerts($batchId) {
        $health = $this->getHealthStatus($batchId);
        $alerts = [];
        
        if ($health) {
            if (isset($health['temperature_avg']) && ($health['temperature_avg'] > 30 || $health['temperature_avg'] < 20)) {
                $alerts[] = "⚠️ Température critique: " . $health['temperature_avg'] . "°C";
            }
            if (isset($health['humidity_avg']) && ($health['humidity_avg'] > 80 || $health['humidity_avg'] < 40)) {
                $alerts[] = "⚠️ Humidité critique: " . $health['humidity_avg'] . "%";
            }
            if (isset($health['ammonia_level']) && $health['ammonia_level'] > 10) {
                $alerts[] = "⚠️ Niveau d'ammoniaque élevé: " . $health['ammonia_level'] . " ppm";
            }
            if (isset($health['mortality_count']) && $health['mortality_count'] > 3) {
                $alerts[] = "⚠️ Mortalité anormale: " . $health['mortality_count'] . " sujets";
            }
        }
        
        return $alerts;
    }
}
