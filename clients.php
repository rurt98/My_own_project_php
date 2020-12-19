<?php

session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {

    // send them to the login page
    header("Location: index.php");
}

$userId = $_SESSION['loggedInId'];

// connect to database
include('includes/connection.php');

// query & result
$query = "SELECT * FROM clients";
$result = mysqli_query( $conn, $query );

// check for query string
if ( isset($_GET['alert'] ) ) {

    // now client added
    if ($_GET['alert'] == 'success') {
        $alertMessage = "<div class='alert alert-success'>New client added! <a class='close' data-dismiss='alert'>&times;</a></div>";

        // client updated
    } elseif ($_GET['alert'] == 'updatesuccess') {
        $alertMessage = "<div class='alert alert-success'>Client updated! <a class='close' data-dismiss='alert'>&times;</a></div>";

        /// client deleted
    } elseif ($_GET['alert'] == 'deleted') {
        $alertMessage = "<div class='alert alert-success'>Client deleted! <a class='close' data-dismiss='alert'>&times;</a></div>";

    } elseif ($_GET['alert'] == 'success1') {
        $alertProduct = "<div class='alert alert-success'>Product added! <a class='close' data-dismiss='alert'>&times;</a></div>";

    } elseif ($_GET['alert'] == 'updatesuccess1') {
        $alertProduct = "<div class='alert alert-success'>Product updated! <a class='close' data-dismiss='alert'>&times;</a></div>";

    } elseif ($_GET['alert'] == 'deleted1') {
    $alertProduct = "<div class='alert alert-success'>Product deleted! <a class='close' data-dismiss='alert'>&times;</a></div>";

} elseif ($_GET['alert'] == 'singUp') {
        $alertMessage1 = "<div class='alert alert-success'>Welcome To Your Book! <a class='close' data-dismiss='alert'>&times;</a></div>";

    }

}



// close the mysql connection
mysqli_close($conn);

include('includes/header.php');
?>

<?php echo $alertMessage1 ?>

<h1>Client Address Book</h1>

<?php echo $alertMessage;

?>

<table class="table table-striped table-bordered">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Company</th>
        <th>Notes</th>
        <th>Edit</th>
    </tr>

    <?php

    if( mysqli_num_rows($result) > 0 ) {

        // we have data
        // output the data
        while ( $row = mysqli_fetch_assoc($result ) ) {
            echo "<tr>";

            echo "<td>" . $row['name'] . "</td><td>" . $row['email'] . "</td><td>" . $row['phone'] . "</td><td>" . $row['address'] . "</td><td>" . $row['company'] . "</td><td>" . $row['notes'] ."</td>";

            echo '<td><a href="edit.php?id=' . $row['id'] . $row ['u_id'] .'" type="button" class="btn btn-primary btn-sm">
             <span class="glyphicon glyphincon-edit"></span>
            </a></td>';
            echo "</tr>";

        }
    } else { // if no entries
        echo "<div class='alert alert-warning'>You have no clients!</div>";
    }

    mysqli_close($conn);

    ?>

    <tr>
        <td colspan="7"><div class="text-center"><a href="add.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add Client</a></div></td>
    </tr>
</table>

<?php echo $alertProduct;

?>


<?php
include('products.php')

?>


<?php
include('includes/footer.php');
?>