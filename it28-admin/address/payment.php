<?php
include 'config.php';

// Initialize variables for product details and total price
$product_id = '';
$product_name = '';
$price = '';
$quantity = 1; // Default quantity
$total_price = '';
$error_message = '';
$success_message = '';

// Check if product details are provided via GET and set variables
if (isset($_GET['product_id']) && isset($_GET['product_name']) && isset($_GET['price']) && isset($_GET['quantity']) && isset($_GET['total_price'])) {
    $product_id = $_GET['product_id'];
    $product_name = $_GET['product_name'];
    $price = $_GET['price'];
    $quantity = $_GET['quantity'];
    $total_price = $_GET['total_price'];
} else {
    $error_message = 'Invalid product details.';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if payment method is set and not empty
    if (isset($_POST['payment_method']) && !empty($_POST['payment_method'])) {
        // Extract payment method from POST data
        $payment_method = $_POST['payment_method'];

        // // Debug: Display form submission status
        // echo "Form Submitted Successfully.<br>";

        // // Debug: Display POST data
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        // Insert payment data into database
        $sql = "INSERT INTO payments (product_name, price, total, payment_method, created_at, product_id) 
                VALUES (:product_name, :price, :total, :payment_method, NOW(), :product_id)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':total', $total_price);
        $stmt->bindParam(':payment_method', $payment_method);
        $stmt->bindParam(':product_id', $product_id);

        if ($stmt->execute()) {
            // Get the payment_id of the inserted payment
            $payment_id = $pdo->lastInsertId();

            // Redirect to address.php with payment_id parameter
            header("Location: address.php?payment_id=" . $payment_id);
            exit;
        } else {
            $error_message = 'Error recording payment. Please try again.';
            // Debug: Display error message
            echo "Error: " . $stmt->errorInfo()[2];
        }
        
    } else {
        $error_message = 'Please select a payment method.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Payment Form</h2>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php elseif (!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form id="paymentForm" action="" method="POST">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" min="1" readonly>
            </div>
            <div class="form-group">
                <label for="total_price">Total Price</label>
                <input type="text" class="form-control" id="total_price" name="total_price" value="<?php echo htmlspecialchars($total_price); ?>" readonly>
            </div>
            <!-- Add this hidden input field inside the form -->
<input type="hidden" name="payment_id" value="<?php echo htmlspecialchars($payment_id); ?>">

            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select class="form-control" id="payment_method" name="payment_method">
                    <option value="">Select Payment Method</option>
                    <option value="PayPal">PayPal</option>
                    <option value="GCash">GCash</option>
                    <option value="PayMaya">PayMaya</option>
                    <option value="Credit Card">Credit Card</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit Payment</button>
        </form>
    </div>
</body>
</html>
