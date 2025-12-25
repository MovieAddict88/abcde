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

$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
$name = trim($_POST['name']);
$model = trim($_POST['model']);
$year = filter_var($_POST['year'], FILTER_VALIDATE_INT);
$plate_number = trim($_POST['plate_number']);
$price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
$image_url = trim($_POST['image_url']);

if ($id === false || empty($name) || $price === false || $price < 0) {
    header('Location: edit_car.php?id=' . $_POST['id'] . '&error=Invalid input.');
    exit;
}

try {
    $pdo = getDBConnection();
    $car = new Car($pdo);

    if ($car->update($id, $name, $model, $year, $plate_number, $price, $image_url)) {
        header('Location: cars.php?success=Car updated successfully.');
    } else {
        header('Location: edit_car.php?id=' . $id . '&error=Failed to update car.');
    }
} catch (Exception $e) {
    header('Location: edit_car.php?id=' . $id . '&error=An unexpected error occurred.');
}
exit;
?>
