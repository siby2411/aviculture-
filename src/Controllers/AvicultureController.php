<?php
namespace Controllers;

use Models\BatchModel;
use Models\SaleModel;
use Models\ExpenseModel;
use Models\EggProductionModel;
use Models\HealthMonitoringModel;

class AvicultureController {
    private $batchModel;
    private $saleModel;
    private $expenseModel;
    private $eggModel;
    private $healthModel;

    public function __construct() {
        $this->batchModel = new BatchModel();
        $this->saleModel = new SaleModel();
        $this->expenseModel = new ExpenseModel();
        $this->eggModel = new EggProductionModel();
        $this->healthModel = new HealthMonitoringModel();
    }

    public function dashboard() {
        $batches = $this->batchModel->getAllBatches();
        $totalRevenue = $this->saleModel->getTotalRevenue();
        $totalExpenses = $this->expenseModel->getTotalExpenses();
        $salesStats = $this->saleModel->getSalesStats(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'));
        
        $totalBirds = 0;
        $totalMortality = 0;
        $totalEggs = 0;
        $totalProductionCost = 0;
        
        foreach ($batches as $batch) {
            $stats = $this->batchModel->getBatchStats($batch['id']);
            $cost = $this->batchModel->calculateProductionCost($batch['id']);
            $totalBirds += $batch['current_quantity'];
            $totalMortality += $stats['total_mortality'] ?? 0;
            $totalEggs += $stats['total_eggs'] ?? 0;
            $totalProductionCost += $cost['total_cost'];
        }

        $profit = $totalRevenue - $totalExpenses - $totalProductionCost;

        include_once __DIR__ . '/../Views/dashboard.php';
    }

    public function lots() {
        $batches = $this->batchModel->getAllBatches();
        include_once __DIR__ . '/../Views/lots/index.php';
    }

    public function createLot() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'building_id' => $_POST['building_id'],
                'name' => $_POST['name'],
                'start_date' => $_POST['start_date'],
                'initial_quantity' => $_POST['initial_quantity']
            ];
            $this->batchModel->createBatch($data);
            header('Location: /?route=lots');
            exit;
        }
        include_once __DIR__ . '/../Views/lots/create.php';
    }

    public function lotDetails($id) {
        $batch = $this->batchModel->getBatchById($id);
        $stats = $this->batchModel->getBatchStats($id);
        $cost = $this->batchModel->calculateProductionCost($id);
        $dailyRecords = $this->batchModel->getDailyRecords($id);
        $eggProduction = $this->eggModel->getProductionByBatch($id);
        
        include_once __DIR__ . '/../Views/lots/details.php';
    }

    public function ventes() {
        $sales = $this->saleModel->getAllSales();
        $stats = $this->saleModel->getSalesStats(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'));
        include_once __DIR__ . '/../Views/ventes/index.php';
    }

    public function addSale() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'batch_id' => $_POST['batch_id'],
                'sale_date' => $_POST['sale_date'],
                'quantity' => $_POST['quantity'],
                'unit_price' => $_POST['unit_price'],
                'buyer_name' => $_POST['buyer_name'],
                'sale_type' => $_POST['sale_type']
            ];
            $this->saleModel->addSale($data);
            header('Location: /?route=ventes');
            exit;
        }
        $batches = $this->batchModel->getAllBatches();
        include_once __DIR__ . '/../Views/ventes/add.php';
    }

    public function charges() {
        $expenses = $this->expenseModel->getAllExpenses();
        $total = $this->expenseModel->getTotalExpenses();
        include_once __DIR__ . '/../Views/charges/index.php';
    }

    public function addExpense() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'batch_id' => $_POST['batch_id'],
                'expense_date' => $_POST['expense_date'],
                'category' => $_POST['category'],
                'description' => $_POST['description'],
                'amount' => $_POST['amount']
            ];
            $this->expenseModel->addExpense($data);
            header('Location: /?route=charges');
            exit;
        }
        $batches = $this->batchModel->getAllBatches();
        include_once __DIR__ . '/../Views/charges/add.php';
    }

    public function rapports() {
        $batches = $this->batchModel->getAllBatches();
        $totalRevenue = $this->saleModel->getTotalRevenue();
        $totalExpenses = $this->expenseModel->getTotalExpenses();
        
        $totalBirds = 0;
        $totalMortality = 0;
        $totalEggs = 0;
        $totalProductionCost = 0;
        $profitPerBatch = [];
        
        foreach ($batches as $batch) {
            $stats = $this->batchModel->getBatchStats($batch['id']);
            $cost = $this->batchModel->calculateProductionCost($batch['id']);
            $sales = $this->saleModel->getSalesByBatch($batch['id']);
            
            $totalBirds += $batch['current_quantity'];
            $totalMortality += $stats['total_mortality'] ?? 0;
            $totalEggs += $stats['total_eggs'] ?? 0;
            $totalProductionCost += $cost['total_cost'];
            
            $profitPerBatch[] = [
                'name' => $batch['name'],
                'revenue' => array_sum(array_column($sales, 'total_amount')),
                'cost' => $cost['total_cost'],
                'profit' => array_sum(array_column($sales, 'total_amount')) - $cost['total_cost']
            ];
        }
        
        $profit = $totalRevenue - $totalExpenses - $totalProductionCost;
        
        include_once __DIR__ . '/../Views/rapports/index.php';
    }

    public function uploadImage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['poultry_image'])) {
            $file = $_FILES['poultry_image'];
            $name = $_POST['poultry_name'] ?? pathinfo($file['name'], PATHINFO_FILENAME);
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            
            if (in_array($extension, $allowed) && $file['size'] < 5000000) {
                $filename = strtolower(str_replace(' ', '-', $name)) . '.' . $extension;
                $target = __DIR__ . '/../../public/images/poules/' . $filename;
                
                if (move_uploaded_file($file['tmp_name'], $target)) {
                    $_SESSION['message'] = '✅ Image uploadée avec succès !';
                } else {
                    $_SESSION['error'] = '❌ Erreur lors de l\'upload';
                }
            } else {
                $_SESSION['error'] = '❌ Format non autorisé ou fichier trop volumineux';
            }
            header('Location: /?route=upload');
            exit;
        }
        include_once __DIR__ . '/../Views/upload.php';
    }

    public function healthMonitoring($batchId) {
        $batch = $this->batchModel->getBatchById($batchId);
        $healthStatus = $this->healthModel->getHealthStatus($batchId);
        $healthHistory = $this->healthModel->getHealthHistory($batchId);
        $treatments = $this->healthModel->getTreatments($batchId);
        $weights = $this->healthModel->getWeightHistory($batchId);
        $alerts = $this->healthModel->getBatchAlerts($batchId);
        
        include_once __DIR__ . '/../Views/health/index.php';
    }

    public function addHealthCheck() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'batch_id' => $_POST['batch_id'],
                'check_date' => $_POST['check_date'],
                'temperature_avg' => $_POST['temperature_avg'] ?? null,
                'humidity_avg' => $_POST['humidity_avg'] ?? null,
                'ammonia_level' => $_POST['ammonia_level'] ?? null,
                'co2_level' => $_POST['co2_level'] ?? null,
                'feed_intake' => $_POST['feed_intake'] ?? null,
                'water_intake' => $_POST['water_intake'] ?? null,
                'mortality_count' => $_POST['mortality_count'] ?? 0,
                'sick_birds' => $_POST['sick_birds'] ?? 0,
                'injured_birds' => $_POST['injured_birds'] ?? 0,
                'treatment_given' => $_POST['treatment_given'] ?? null,
                'observations' => $_POST['observations'] ?? null
            ];
            $this->healthModel->addHealthCheck($data);
            header('Location: /?route=health&id=' . $_POST['batch_id']);
            exit;
        }
        $batches = $this->batchModel->getAllBatches();
        include_once __DIR__ . '/../Views/health/add.php';
    }

    public function addTreatment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'batch_id' => $_POST['batch_id'],
                'treatment_date' => $_POST['treatment_date'],
                'treatment_type' => $_POST['treatment_type'],
                'product_name' => $_POST['product_name'],
                'dosage' => $_POST['dosage'],
                'administration_method' => $_POST['administration_method'],
                'cost' => $_POST['cost'],
                'next_due_date' => $_POST['next_due_date'],
                'notes' => $_POST['notes'] ?? null
            ];
            $this->healthModel->addPreventiveTreatment($data);
            header('Location: /?route=health&id=' . $_POST['batch_id']);
            exit;
        }
        $batches = $this->batchModel->getAllBatches();
        include_once __DIR__ . '/../Views/health/treatment.php';
    }
}
