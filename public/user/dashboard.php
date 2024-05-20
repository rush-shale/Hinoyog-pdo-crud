<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../index.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <p>
        <a href="./reset.php" class="btn btn-warning">Reset Your Password</a>
        <a href="./logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Product Details</h2>
                        <a href="../inventory/create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Product</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "../../db/config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM products";
                    if($result = $pdo->query($sql)){
                        if($result->rowCount() > 0){
                            // Define the table template
                            $tableTemplate = '
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Product Description</th>
                                            <th>Retail Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{rows}}
                                    </tbody>
                                </table>
                            ';
                    
                            // Define the row template
                            $rowTemplate = '
                                <tr>
                                    <td>{{product_id}}</td>
                                    <td>{{product_name}}</td>
                                    <td>{{product_details}}</td>
                                    <td>{{product_retail_price}}</td>
                                    <td>
                                        <a href="../inventory/read.php?product_id={{product_id}}" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>
                                        <a href="../inventory/update.php?product_id={{product_id}}" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>
                                        <a href="../inventory/delete.php?product_id={{product_id}}" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>
                                    </td>
                                </tr>
                            ';
                    
                            // Populate the rows using the row template
                            $rows = '';
                            while ($row = $result->fetch()) {
                                $rowHtml = str_replace(
                                    array('{{product_id}}', '{{product_name}}', '{{product_details}}', '{{product_retail_price}}'),
                                    array($row['product_id'], $row['product_name'], $row['product_details'], $row['product_retail_price']),
                                    $rowTemplate
                                );
                                $rows .= $rowHtml;
                            }
                    
                            // Replace the rows placeholder in the table template with the actual rows
                            echo str_replace('{{rows}}', $rows, $tableTemplate);
                            
                            // Free result set
                            unset($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    
                    // Close connection
                    unset($pdo);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>