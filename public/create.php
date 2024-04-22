<?php
// Include config file
require_once "../db/config.php";
 
// Define variables and initialize with empty values
$product = $product_details = $price = "";
$product_err = $product_details_err = $price_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate product
    $input_product = trim($_POST["product"]);
    if(empty($input_product)){
        $product_err = "Please enter a product.";
    } elseif(!filter_var($input_product, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $product_err = "Please enter a valid product.";
    } else{
        $product = $input_product;
    }
    
    // Validate product_details
    $input_product_details = trim($_POST["product_details"]);
    if(empty($input_product_details)){
        $product_details_err = "Please enter product_details.";     
    } else{
        $product_details = $input_product_details;
    }
    
    // Validate price
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Please enter the price.";     
    } elseif(!ctype_digit($input_price)){
        $price_err = "Please enter a positive integer value.";
    } else{
        $price = $input_price;
    }
    
    // Check input errors before inserting in database
    if(empty($product_err) && empty($product_details_err) && empty($price_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (product,product_details , price) VALUES (:product, :product_details, :price)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":product", $param_product);
            $stmt->bindParam(":product_details", $param_product_details);
            $stmt->bindParam(":price", $param_price);
            
            // Set parameters
            $param_product = $product;
            $param_product_details = $product_details;
            $param_price = $price;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: ../index.php");
                exit();
            } else{
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
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>product</label>
                            <input type="text" name="product" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $product; ?>">
                            <span class="invalid-feedback"><?php echo $product_err;?></span>
                        </div>
                        <div class="form-group">
                        <label>Product details</label>
                            <textarea name="product_details" class="form-control <?php echo (!empty($product_details_err)) ? 'is-invalid' : ''; ?>"><?php echo $product_details; ?></textarea>
                            <span class="invalid-feedback"><?php echo $product_details;?></span>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="../index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>