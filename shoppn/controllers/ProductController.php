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

public function addProduct($cat, $brand, $title, $price, $desc, $image, $keywords) {
    return $this->productClass->addProduct($cat, $brand, $title, $price, $desc, $image, $keywords);
}

public function updateProduct($id, $cat, $brand, $title, $price, $desc, $image, $keywords) {
    return $this->productClass->updateProduct($id, $cat, $brand, $title, $price, $desc, $image, $keywords);
}

public function getProductById($id) {
    return $this->productClass->getProductById($id);
}

public function getAllProducts() {
    return $this->productClass->getAllProducts();
}

public function getFeaturedProducts($limit = 6) {
    return $this->productClass->getFeaturedProducts($limit);
}

public function getProductsByCategory($cat_id) {
    return $this->productClass->getProductsByCategory($cat_id);
}

public function getProductsByBrand($brand_id) {
    return $this->productClass->getProductsByBrand($brand_id);
}

public function searchProducts($query) {
    return $this->productClass->searchProducts($query);
}
}
?>