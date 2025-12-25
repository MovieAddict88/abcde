<?php
session_start();
require_once '../../config/db.php';
require_once '../../src/Car.php';

// Auth check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php?error=Access denied.');
    exit;
}

$pdo = getDBConnection();
$car = new Car($pdo);
$cars = $car->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Cars</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '_nav.php'; ?>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Manage Cars</h2>
            <a href="add_car.php" class="btn btn-success">Add New Car</a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Plate Number</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cars as $c): ?>
                <tr>
                    <td><?php echo htmlspecialchars($c['id']); ?></td>
                    <td><?php echo htmlspecialchars($c['name']); ?></td>
                    <td><?php echo htmlspecialchars($c['model']); ?></td>
                    <td><?php echo htmlspecialchars($c['year']); ?></td>
                    <td><?php echo htmlspecialchars($c['plate_number']); ?></td>
                    <td>$<?php echo htmlspecialchars(number_format($c['price'], 2)); ?></td>
                    <td><img src="<?php echo htmlspecialchars($c['image_url']); ?>" alt="<?php echo htmlspecialchars($c['name']); ?>" width="100"></td>
                    <td>
                        <a href="edit_car.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="delete_car.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
