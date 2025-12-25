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

$pdo = getDBConnection();
$car = new Car($pdo);
$carData = $car->getById($_GET['id']);

if (!$carData) {
    header('Location: cars.php?error=Car not found.');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '_nav.php'; ?>
    <div class="container mt-5">
        <h2>Edit Car</h2>
        <form action="handle_edit_car.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($carData['id']); ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Car Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($carData['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model" value="<?php echo htmlspecialchars($carData['model']); ?>">
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Year</label>
                <input type="number" class="form-control" id="year" name="year" value="<?php echo htmlspecialchars($carData['year']); ?>">
            </div>
            <div class="mb-3">
                <label for="plate_number" class="form-label">Plate Number</label>
                <input type="text" class="form-control" id="plate_number" name="plate_number" value="<?php echo htmlspecialchars($carData['plate_number']); ?>">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($carData['price']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">Image URL</label>
                <input type="text" class="form-control" id="image_url" name="image_url" value="<?php echo htmlspecialchars($carData['image_url']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Car</button>
            <a href="cars.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
