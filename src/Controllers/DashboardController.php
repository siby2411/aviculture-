<?php
namespace Controllers;

use Models\BatchModel;
use Models\SaleModel;

class DashboardController {
    private $batchModel;
    private $saleModel;

    public function __construct() {
        $this->batchModel = new BatchModel();
        $this->saleModel = new SaleModel();
    }

    public function index() {
        $batches = $this->batchModel->getAllBatches();
        $totalRevenue = $this->saleModel->getTotalRevenue();
        $salesStats = $this->saleModel->getSalesStats(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'));
        
        $totalBirds = 0;
        $totalMortality = 0;
        $totalEggs = 0;
        
        foreach ($batches as $batch) {
            $stats = $this->batchModel->getBatchStats($batch['id']);
            $totalBirds += $batch['current_quantity'];
            $totalMortality += $stats['total_mortality'] ?? 0;
            $totalEggs += $stats['total_eggs'] ?? 0;
        }

        include_once __DIR__ . '/../Views/dashboard.php';
    }

    public function getBatchDetails($id) {
        $stats = $this->batchModel->getBatchStats($id);
        $cost = $this->batchModel->calculateProductionCost($id);
        
        header('Content-Type: application/json');
        echo json_encode([
            'stats' => $stats,
            'cost' => $cost
        ]);
    }
}
