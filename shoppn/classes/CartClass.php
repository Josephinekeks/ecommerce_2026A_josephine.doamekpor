<?php
require_once __DIR__ . '/../core/db_class.php';

class CartClass extends Database {
    // True if avisitor  already has the product in their cart.
    public function isInCart($product_id, $ip) {
        $stmt = $this->conn->prepare(
            "SELECT p_id FROM cart WHERE p_id = ? AND ip_add = ?"
        );
        $stmt->bind_param("is", $product_id, $ip); // i = integer, s = string
        $stmt->execute();
        $found = $stmt->get_result()->num_rows > 0; // any row back means it's there
        $stmt->close();
        return $found;
    }

    // Adds one product to the cart. $customer_id stays null for guests.
    public function addToCart($product_id, $qty, $ip, $customer_id = null) {
        $stmt = $this->conn->prepare(
            "INSERT INTO cart (p_id, ip_add, c_id, qty) VALUES (?, ?, ?, ?)"
        );
        // Types in order: i, s, i, i. A PHP null in an "i" slot is saved as NULL.
        $stmt->bind_param("isii", $product_id, $ip, $customer_id, $qty);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // All cart rows for this IP, joined to the products table so we also
    // get each product's title, price and image in the same result.
    public function getCartItems($ip) {
        $stmt = $this->conn->prepare(
            "SELECT cart.*, products.product_title, products.product_price, products.product_image
               FROM cart
               JOIN products ON cart.p_id = products.product_id
              WHERE cart.ip_add = ?"
        );
        $stmt->bind_param("s", $ip);
        $stmt->execute();
        $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); 
        return $items;
    }

    // How many cart rows this IP has (one row per product).
    public function getCartCount($ip) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM cart WHERE ip_add = ?");
        $stmt->bind_param("s", $ip);
        $stmt->execute();
        // COUNT(*) gives one row with one column. fetch_row() reads it by position.
        $row = $stmt->get_result()->fetch_row();
        $stmt->close();
        return (int)$row[0];
    }

    // Total price: loop through the items and add up qty x price, as the spec says.
    public function getCartTotal($ip) {
        $total = 0;
        foreach ($this->getCartItems($ip) as $item) {
            $total += $item['qty'] * $item['product_price'];
        }
        return (float)$total;
    }

    // Deletes one product from this visitor's cart.
public function removeFromCart($product_id, $ip) {
    // "AND ip_add = ?" means you can only remove rows from YOUR cart,
    // even if someone edits the product id in the form.
    $stmt = $this->conn->prepare(
        "DELETE FROM cart WHERE p_id = ? AND ip_add = ?"
    );
    $stmt->bind_param("is", $product_id, $ip); // i = integer, s = string

    // affected_rows = how many rows the DELETE removed. Requiring more than 0
    // means we only report success if something was really deleted.
    $success = $stmt->execute() && $stmt->affected_rows > 0;
    $stmt->close();
    return $success;
}

// Changes the quantity of one product in this visitor's cart.
public function updateQty($product_id, $new_qty, $ip) {
  
    // even if a caller forgot to validate it first.
    if ($new_qty < 1) {
        return false;
    }

    $stmt = $this->conn->prepare(
        "UPDATE cart SET qty = ? WHERE p_id = ? AND ip_add = ?"
    );
    // Order matches the ? marks: qty (i), product id (i), ip (s).
    $stmt->bind_param("iis", $new_qty, $product_id, $ip);

    // Only execute() here, not affected_rows. If the quantity didn't actually
    // change, MySQL reports 0 affected rows, which isn't a failure.
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}


}
?>







