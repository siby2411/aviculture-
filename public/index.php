<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $file = __DIR__ . '/../src/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

use Controllers\AvicultureController;

$controller = new AvicultureController();
$route = $_GET['route'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($route) {
    case 'dashboard':
        $controller->dashboard();
        break;
    case 'lots':
        if ($action === 'create') {
            $controller->createLot();
        } elseif ($id) {
            $controller->lotDetails($id);
        } else {
            $controller->lots();
        }
        break;
    case 'ventes':
        if ($action === 'add') {
            $controller->addSale();
        } else {
            $controller->ventes();
        }
        break;
    case 'charges':
        if ($action === 'add') {
            $controller->addExpense();
        } else {
            $controller->charges();
        }
        break;
    case 'rapports':
        $controller->rapports();
        break;
    case 'upload':
        $controller->uploadImage();
        break;
    case 'health':
        if ($action === 'add') {
            $controller->addHealthCheck();
        } elseif ($id) {
            $controller->healthMonitoring($id);
        } else {
            $controller->healthMonitoring($_GET['id'] ?? 0);
        }
        break;
    case 'health-add':
        $controller->addHealthCheck();
        break;
    case 'treatment-add':
        $controller->addTreatment();
        break;
    default:
        $controller->dashboard();
        break;
}
