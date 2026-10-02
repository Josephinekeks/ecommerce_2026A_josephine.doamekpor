<?php

require_once __DIR__ . '/../classes/ProductClass.php';

class ProductController {

    // Holds one instance of ProductClass, 
    private $productClass;

    public function __construct() {
        $this->productClass = new ProductClass();
    }

    
    public function getCategories() {
        return $this->productClass->getCategories();
    }

    public function getAllBrands() {
        return $this->productClass->getAllBrands();
    }

    // T add a new brand. 
    public function addBrand($name) {
        return $this->productClass->addBrand($name);
    }

    //  fetch one brand for editing.
    public function getBrandById($id) {
        return $this->productClass->getBrandById($id);
    }

    //  update an existing brand.
    public function updateBrand($id, $name) {
        return $this->productClass->updateBrand($id, $name);
    }

    public function addCategory($name) {
    return $this->productClass->addCategory($name);
}

public function getAllCategories() {
    return $this->productClass->getAllCategories();
}

public function getCategoryById($id) {
    return $this->productClass->getCategoryById($id);
}

public function updateCategory($id, $name) {
    return $this->productClass->updateCategory($id, $name);
}
}
?>