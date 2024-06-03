<?php
// Include config file
require_once '../../db/config.php';
 
// Define variables and initialize with empty values
$product_id = $product_name = $description = $price = $rrp = $quantity = $img = "";
$product_id_err = $product_name_err = $description_err = $price_err = $rrp_err = $quantity_err = $img_err = "";

// Prepare a select statement
$sql = "SELECT * FROM products WHERE product_id = :product_id";
    
if ($stmt = $pdo->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":product_id", $param_product_id);
       
    // Set parameters
    $param_product_id = trim($_GET["product_id"]);
       
    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
            /* Fetch result row as an associative array. Since the result set
            contains only one row, we don't need to use while loop */
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
           
            // Retrieve individual field values
            $product_id = $row["product_id"];
            $product_name = $row["product_name"];
            $description = $row["description"];
            $price = $row["price"];
            $rrp = $row["rrp"];
            $quantity = $row["quantity"];
            $img = $row["img"];
        } else {
            // Product ID not found, redirect to error page
            header("location: ../public/error.php");
            exit();
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}
   
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate product_id
    $input_product_id = trim($_POST["product_id"]);
    if (empty($input_product_id)) {
        $product_id_err = "Please enter a product_id.";
    } else {
        $product_id = $input_product_id;
    }
    
    // Validate product_name
    $input_product_name = trim($_POST["product_name"]);
    if (empty($input_product_name)) {
        $product_name_err = "Please enter a product name.";
    } else {
        $product_name = $input_product_name;
    }
    
    // Validate description
    $input_description = trim($_POST["description"]);
    if (empty($input_description)) {
        $description_err = "Please enter a description.";
    } else {
        $description = $input_description;
    }
    
    // Validate price
    $input_price = trim($_POST["price"]);
    if (empty($input_price)) {
        $price_err = "Please enter the price amount.";
    } elseif (!ctype_digit($input_price)) {
        $price_err = "Please enter a positive integer value.";
    } else {
        $price = $input_price;
    }

    // Validate rrp
    $input_rrp = trim($_POST["rrp"]);
    if (empty($input_rrp)) {
        $rrp_err = "Please enter the RRP amount.";
    } elseif (!ctype_digit($input_rrp)) {
        $rrp_err = "Please enter a positive integer value.";
    } else {
        $rrp = $input_rrp;
    }
    
    // Validate quantity
    $input_quantity = trim($_POST["quantity"]);
    if (empty($input_quantity)) {
        $quantity_err = "Please enter the quantity.";
    } elseif (!ctype_digit($input_quantity)) {
        $quantity_err = "Please enter a positive integer value.";
    } else {
        $quantity = $input_quantity;
    }
    
    // Validate image
    $input_img = trim($_POST["img"]);
    if (empty($input_img)) {
        $img_err = "Please enter the image URL.";
    } else {
        $img = $input_img;
    }
    
    // Check input errors before updating in database
    if (empty($product_id_err) && empty($product_name_err) && empty($description_err) && empty($price_err) && empty($rrp_err) && empty($quantity_err) && empty($img_err)) {
        // Prepare an update statement
        $sql = "UPDATE products SET product_name = :product_name, description = :description, price = :price, rrp = :rrp, quantity = :quantity, img = :img WHERE product_id = :product_id";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":product_id", $product_id);
            $stmt->bindParam(":product_name", $product_name);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":rrp", $rrp);
            $stmt->bindParam(":quantity", $quantity);
            $stmt->bindParam(":img", $img);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records updated successfully. Redirect to landing page
                header("location: ../products.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5">Update Record</h2>
                <p>Please edit the input values and submit to update the product record.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="product_name" class="form-control <?php echo (!empty($product_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $product_name; ?>">
                        <span class="invalid-feedback"><?php echo $product_name_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"><?php echo $description; ?></textarea>
                        <span class="invalid-feedback"><?php echo $description_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                        <span class="invalid-feedback"><?php echo $price_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>RRP</label>
                        <input type="text" name="rrp" class="form-control <?php echo (!empty($rrp_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $rrp; ?>">
                        <span class="invalid-feedback"><?php echo $rrp_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" name="quantity" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $quantity; ?>">
                        <span class="invalid-feedback"><?php echo $quantity_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Image URL</label>
                        <input type="text" name="img" class="form-control <?php echo (!empty($img_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $img; ?>">
                        <span class="invalid-feedback"><?php echo $img_err;?></span>
                    </div>
                    <input type="hidden" name="product_id" value="<?php echo $_GET["product_id"]; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="../products.php" class="btn btn-secondary ml-2">Cancel</a>
                </form>
            </div>
        </div>        
    </div>
</div>
</body>
</html>
