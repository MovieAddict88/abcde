<?php
session_start();
require_once '../../config/db.php';
require_once '../../src/Car.php';

// Auth check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php?error=Access denied.');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cars.php');
    exit;
}

$name = trim($_POST['name']);
$model = trim($_POST['model']);
$year = filter_var($_POST['year'], FILTER_VALIDATE_INT);
$plate_number = trim($_POST['plate_number']);
$price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
$image_url = trim($_POST['image_url']);

if (empty($name) || $price === false || $price < 0) {
    header('Location: add_car.php?error=Invalid input.');
    exit;
}

try {
    $pdo = getDBConnection();
    $car = new Car($pdo);

    if ($car->create($name, $model, $year, $plate_number, $price, $image_url)) {
        header('Location: cars.php?success=Car added successfully.');
    } else {
        header('Location: add_car.php?error=Failed to add car.');
    }
} catch (Exception $e) {
    header('Location: add_car.php?error=An unexpected error occurred.');
}
exit;
?>
