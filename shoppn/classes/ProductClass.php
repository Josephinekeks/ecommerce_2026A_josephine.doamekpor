<?php
require_once __DIR__ . '/../core/db_class.php';

class ProductClass extends Database {

   
    public function getCategories() {
        $result = $this->conn->query("SELECT * FROM categories");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    
    public function getAllBrands() {
        $result = $this->conn->query("SELECT * FROM brands ORDER BY brand_name ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //  inserting a new brand.
    public function addBrand($name) {
        $stmt = $this->conn->prepare(
            "INSERT INTO brands (brand_name) VALUES (?)"
        );
        $stmt->bind_param("s", $name);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    //  fetch ONE brand by its id, for pre-filling the edit form.
    public function getBrandById($id) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM brands WHERE brand_id = ?"
        );
        
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $brand = $result->fetch_assoc();
        $stmt->close();

        return $brand ?: false;
    }

    //  updating an existing brand's name.
    public function updateBrand($id, $name) {
        $stmt = $this->conn->prepare(
            "UPDATE brands SET brand_name = ? WHERE brand_id = ?"
        );
        
        $stmt->bind_param("si", $name, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Task 7: insert a new category.
public function addCategory($name) {
    $stmt = $this->conn->prepare(
        "INSERT INTO categories (cat_name) VALUES (?)"
    );
    $stmt->bind_param("s", $name);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

// Task 7: fetch all categories, alphabetically —
public function getAllCategories() {
    $result = $this->conn->query("SELECT * FROM categories ORDER BY cat_name ASC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Task 8: fetch one category by id, mirrors getBrandById() 
public function getCategoryById($id) {
    $stmt = $this->conn->prepare(
        "SELECT * FROM categories WHERE cat_id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
    $stmt->close();

    return $category ?: false;
}

// Task 8: update, mirrors updateBrand() exactly.
public function updateCategory($id, $name) {
    $stmt = $this->conn->prepare(
        "UPDATE categories SET cat_name = ? WHERE cat_id = ?"
    );
    $stmt->bind_param("si", $name, $id);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}


}
?>