<?php
session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {

    // send them to the login page
    header("Location: index.php");
}


// include to database
include ('includes/connection.php');

// include to function file
include ('includes/functions.php');

if ( isset( $_POST['addproduct'] ) ) {

    // set all variables to empty by default
    $brand = $ad  = $notes = "";


    // so we'll just store has been entered
    $brand      =    validateFormData( $_POST["brand"] );
    $ad         =    validateFormData( $_POST["ad"] );
    $notes      =    validateFormData( $_POST["notes"] );

    // if required fields have data
if ( $brand && $ad && $notes) {


    //create query
    $query = "INSERT INTO products (id, brand, ad, notes, date_added) VALUES (NULL, '$brand', '$ad', '$notes',  CURRENT_TIMESTAMP)";

    $result = mysqli_query($conn, $query);

    // if query was successful
    if ($result) {

        // refresh page with query string
        header("location: clients.php?alert=success1");
    } else {

        /// something went wrong
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

}

}

// close mysqli connection
mysqli_close($conn);



include('includes/header.php');

?>

<h1>Add Products</h1>

<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="product-brand">Brand</label>
        <input type="text" class="form-control input-lg" id="product-brand" name="brand" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="product-ad">Ad</label>
        <textarea type="text" class="form-control input-lg" id="product-ad" name="ad"></textarea>
    </div>
    <div class="form-group col-sm-6">
        <label for="product-notes">Notes</label>
        <textarea type="text" class="form-control input-lg" id="product-notes" name="notes"></textarea>
    </div>
    <div class="col-sm-12">
        <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
        <button type="submit" class="btn btn-lg btn-success pull-right" name="addproduct">Add Products</button>
    </div>
</form>

<?php
include('includes/footer.php');
?>
