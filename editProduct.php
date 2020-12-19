<?php
session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {

    // send them to the login page
    header("Location: index.php");
}

// get ID sent by GET collection
$productID = $_GET['id'];

// connect to database
include('includes/connection.php');

// include functions file
include('includes/functions.php');

// query the database with product ID
$query = "SELECT * FROM products WHERE id='$productID'";
$result = mysqli_query( $conn, $query );

// if result is returned
if( mysqli_num_rows($result) > 0 ) {

    // we have data!
    // set some variables
    while( $row = mysqli_fetch_assoc($result) ) {
        $brand     = $row['brand'];
        $ad        = $row['ad'];
        $notes     = $row['notes'];

    }
} else { // no results returned
    $alertMessage = "<div class='alert alert-warning'>No products. <a href='clients.php'>Head back</a>.</div>";
}

// if update button was submitted
if( isset($_POST['update']) ) {

    // set variables
    $brand     = validateFormData( $_POST["brand"] );
    $ad        = validateFormData( $_POST["ad"] );
    $notes     = validateFormData( $_POST["notes"] );

    // new database query & result
    $query = "UPDATE products
            SET brand='$brand',
            ad='$ad',
            notes='$notes'
            WHERE id='$productID'";

    $result = mysqli_query( $conn, $query );

    if( $result ) {

        // redirect to client page with query string
        header("Location: clients.php?alert=updatesuccess1");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// if delete button was submitted
if( isset($_POST['delete']) ) {

    $alertMessage = "<div class='alert alert-danger'>
                        <p>Are you sure you want to delete this product? No take backs!</p><br>
                        <form action='". htmlspecialchars( $_SERVER["PHP_SELF"] ) ."?id=$productID' method='post'>
                            <input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Yes, delete!'>
                            <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>No thanks!</a>
                        </form>
                    </div>";

}

// if confirm delete button was submitted
if( isset($_POST['confirm-delete']) ) {

    // new database query & result
    $query = "DELETE FROM products WHERE id='$productID'";
    $result = mysqli_query( $conn, $query );

    if( $result ) {

        // redirect to client page with query string
        header("Location: clients.php?alert=deleted1");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

}

// close the mysql connection
mysqli_close($conn);

include('includes/header.php');
?>

<h1>Edit Product</h1>

<?php echo $alertMessage; ?>

<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>?id=<?php echo $productID; ?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="product-brand">Brand</label>
        <input type="text" class="form-control input-lg" id="product-brand" name="brand" value="<?php echo $brand; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="product-ad">Ad</label>
        <textarea type="text" class="form-control input-lg" id="product-ad" name="ad"><?php echo $ad; ?></textarea>
    </div>
    <div class="form-group col-sm-6">
        <label for="product-notes">Notes</label>
        <textarea type="text" class="form-control input-lg" id="product-notes" name="notes"><?php echo $notes; ?></textarea>
    </div>
    <div class="col-sm-12">
        <hr>
        <button type="submit" class="btn btn-lg btn-danger pull-left" name="delete">Delete</button>
        <div class="pull-right">
            <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success" name="update">Update</button>
        </div>
    </div>
</form>

<?php
include('includes/footer.php');
?>



