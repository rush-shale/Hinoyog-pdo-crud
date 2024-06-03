<?php
// Include config file
include 'config.php';

// Retrieve the payment_id from the GET parameters
$payment_id = isset($_GET['payment_id']) ? $_GET['payment_id'] : null;

// Define variables and initialize with empty values
$street = $city = $state = $zip = $country = '';
$street_err = $city_err = $state_err = $zip_err = $country_err = '';

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the payment_id from the form submission data
$payment_id = isset($_POST['payment_id']) ? $_POST['payment_id'] : null;


    // Validate street address
    if (empty(trim($_POST["street"]))) {
        $street_err = "Please enter your street address.";
    } else {
        $street = trim($_POST["street"]);
    }

    // Validate city
    if (empty(trim($_POST["city"]))) {
        $city_err = "Please enter your city.";
    } else {
        $city = trim($_POST["city"]);
    }

    // Validate state
    if (empty(trim($_POST["state"]))) {
        $state_err = "Please enter your state.";
    } else {
        $state = trim($_POST["state"]);
    }

    // Validate ZIP code
    if (empty(trim($_POST["zip"]))) {
        $zip_err = "Please enter your ZIP code.";
    } else {
        $zip = trim($_POST["zip"]);
    }

    // Validate country
    if (empty(trim($_POST["country"]))) {
        $country_err = "Please enter your country.";
    } else {
        $country = trim($_POST["country"]);
    }

    // Check input errors before inserting into database
    if (empty($street_err) && empty($city_err) && empty($state_err) && empty($zip_err) && empty($country_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO addresses (street, city, state, zip, country) VALUES (:street, :city, :state, :zip, :country)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":street", $street, PDO::PARAM_STR);
            $stmt->bindParam(":city", $city, PDO::PARAM_STR);
            $stmt->bindParam(":state", $state, PDO::PARAM_STR);
            $stmt->bindParam(":zip", $zip, PDO::PARAM_STR);
            $stmt->bindParam(":country", $country, PDO::PARAM_STR);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to success page
                header("location: success.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Address Form</h2>
        <p>Please fill in your address.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($street_err)) ? 'has-error' : ''; ?>">
                <label>Street Address</label>
                <input type="text" name="street" class="form-control" value="<?php echo $street; ?>">
                <span class="text-danger"><?php echo $street_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
                <label>City</label>
                <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                <span class="text-danger"><?php echo $city_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($state_err)) ? 'has-error' : ''; ?>">
                <label>State</label>
                <input type="text" name="state" class="form-control" value="<?php echo $state; ?>">
                <span class="text-danger"><?php echo $state_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($zip_err)) ? 'has-error' : ''; ?>">
                <label>ZIP Code</label>
                <input type="text" name="zip" class="form-control" value="<?php echo $zip; ?>">
                <span class="text-danger"><?php echo $zip_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($country_err)) ? 'has-error' : ''; ?>">
                <label>Country</label>
                <input type="text" name="country" class="form-control" value="<?php echo $country; ?>">
                <span class="text-danger"><?php echo $country_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>
</body>
</html>
