<?php
require_once __DIR__ . '/../classes/CartClass.php';

class CartController {

    private $cartClass;

    public function __construct() {
        $this->cartClass = new CartClass();
    }

    
    public function isInCart($product_id, $ip) {
        return $this->cartClass->isInCart($product_id, $ip);
    }

    public function addToCart($product_id, $qty, $ip, $customer_id = null) {
        return $this->cartClass->addToCart($product_id, $qty, $ip, $customer_id);
    }

    public function getCartItems($ip) {
        return $this->cartClass->getCartItems($ip);
    }

    public function getCartCount($ip) {
        return $this->cartClass->getCartCount($ip);
    }

    public function getCartTotal($ip) {
        return $this->cartClass->getCartTotal($ip);
    }
}
?>