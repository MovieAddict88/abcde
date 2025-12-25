<?php
session_start();
require_once '../../config/db.php';
require_once '../../src/Car.php';

// Auth check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php?error=Access denied.');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: cars.php?error=No car selected.');
    exit;
}

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if ($id === false) {
    header('Location: cars.php?error=Invalid car ID.');
    exit;
}

try {
    $pdo = getDBConnection();
    $car = new Car($pdo);

    if ($car->delete($id)) {
        header('Location: cars.php?success=Car deleted successfully.');
    } else {
        header('Location: cars.php?error=Failed to delete car.');
    }
} catch (PDOException $e) {
    // Handle foreign key constraint error
    if ($e->getCode() == '23000') {
        header('Location: cars.php?error=Cannot delete car because it is associated with an existing invoice.');
    } else {
        header('Location: cars.php?error=An unexpected database error occurred.');
    }
} catch (Exception $e) {
    header('Location: cars.php?error=An unexpected error occurred.');
}
exit;
?>
