<?php
require_once __DIR__ . '/../core/db_class.php';
// Extends Database, so it automatically gets $conn and the

class ProductController extends Database {

    // Returns every row from the categories table as an array.
    public function getCategories() {
        $result = $this->conn->query("SELECT * FROM categories");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Returns every row from the brands table as an array.
    public function getBrands() {
        $result = $this->conn->query("SELECT * FROM brands");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>