<?php
class Car {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Creates a new car.
     * @param string $name
     * @param string $model
     * @param int $year
     * @param string $plate_number
     * @param float $price
     * @param string $image_url
     * @return bool
     */
    public function create($name, $model, $year, $plate_number, $price, $image_url) {
        $stmt = $this->pdo->prepare('INSERT INTO cars (name, model, year, plate_number, price, image_url) VALUES (?, ?, ?, ?, ?, ?)');
        return $stmt->execute([$name, $model, $year, $plate_number, $price, $image_url]);
    }

    /**
     * Fetches all cars.
     * @return array
     */
    public function getAll() {
        $stmt = $this->pdo->query('SELECT * FROM cars ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    /**
     * Fetches a single car by its ID.
     * @param int $id
     * @return mixed
     */
    public function getById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM cars WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Updates a car.
     * @param int $id
     * @param string $name
     * @param string $model
     * @param int $year
     * @param string $plate_number
     * @param float $price
     * @param string $image_url
     * @return bool
     */
    public function update($id, $name, $model, $year, $plate_number, $price, $image_url) {
        $stmt = $this->pdo->prepare('UPDATE cars SET name = ?, model = ?, year = ?, plate_number = ?, price = ?, image_url = ? WHERE id = ?');
        return $stmt->execute([$name, $model, $year, $plate_number, $price, $image_url, $id]);
    }

    /**
     * Deletes a car by its ID.
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM cars WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
?>
